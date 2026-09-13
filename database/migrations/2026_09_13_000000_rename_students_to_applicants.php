<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tableRenames = [
        'students' => 'applicants',
        'student_education' => 'applicant_education',
        'student_employments' => 'applicant_employments',
        'student_trainings' => 'applicant_trainings',
        'student_skills' => 'applicant_skills',
        'student_certifications' => 'applicant_certifications',
    ];

    private array $fkChildTables = [
        'student_education', 'student_employments', 'student_trainings', 'student_skills', 'student_certifications',
    ];

    private array $plainChildTables = [
        'language_proficiencies', 'professional_certificates', 'references', 'job_applications',
    ];

    public function up(): void
    {
        if (! Schema::hasTable('students')) {
            return;
        }

        Schema::rename('students', 'applicants');

        foreach ($this->fkChildTables as $table) {
            $this->renameStudentId($table, withForeignKey: true, toApplicant: true);
        }

        foreach ($this->plainChildTables as $table) {
            $this->renameStudentId($table, withForeignKey: false, toApplicant: true);
        }

        foreach ($this->tableRenames as $from => $to) {
            if ($from !== 'students' && Schema::hasTable($from)) {
                Schema::rename($from, $to);
            }
        }

        $this->updateStoredFilePaths(toApplicant: true);
        $this->updateTokenableType(toApplicant: true);
    }

    public function down(): void
    {
        if (! Schema::hasTable('applicants')) {
            return;
        }

        Schema::rename('applicants', 'students');

        foreach ($this->fkChildTables as $table) {
            $this->renameStudentId($table, withForeignKey: true, toApplicant: false);
        }

        foreach ($this->plainChildTables as $table) {
            $this->renameStudentId($table, withForeignKey: false, toApplicant: false);
        }

        foreach ($this->tableRenames as $from => $to) {
            if ($from !== 'students' && Schema::hasTable($to)) {
                Schema::rename($to, $from);
            }
        }

        $this->updateStoredFilePaths(toApplicant: false);
        $this->updateTokenableType(toApplicant: false);
    }

    private function renameStudentId(string $table, bool $withForeignKey, bool $toApplicant): void
    {
        $from = $toApplicant ? 'student_id' : 'applicant_id';
        $to = $toApplicant ? 'applicant_id' : 'student_id';

        if (! Schema::hasColumn($table, $from)) {
            return;
        }

        $column = DB::selectOne(
            'SELECT COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT FROM information_schema.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?',
            [$table, $from]
        );

        $oldFk = "{$table}_student_id_foreign";
        $newFk = "{$table}_applicant_id_foreign";
        $fkToDrop = $toApplicant ? $oldFk : $newFk;
        $indexToDrop = $toApplicant ? $oldFk : $newFk;
        $fkToAdd = $toApplicant ? $newFk : $oldFk;

        if ($withForeignKey && $this->fkExists($table, $fkToDrop)) {
            DB::statement("ALTER TABLE `{$table}` DROP FOREIGN KEY `{$fkToDrop}`");
        }

        if ($this->indexExists($table, $indexToDrop)) {
            DB::statement("ALTER TABLE `{$table}` DROP INDEX `{$indexToDrop}`");
        }

        $nullable = $column->IS_NULLABLE === 'YES' ? 'NULL' : 'NOT NULL';
        $default = $column->COLUMN_DEFAULT === null
            ? ($nullable === 'NULL' ? ' DEFAULT NULL' : '')
            : " DEFAULT '".addslashes($column->COLUMN_DEFAULT)."'";

        DB::statement("ALTER TABLE `{$table}` CHANGE `{$from}` `{$to}` {$column->COLUMN_TYPE} {$nullable}{$default}");

        if ($withForeignKey) {
            $parent = $toApplicant ? 'applicants' : 'students';
            DB::statement(
                "ALTER TABLE `{$table}` ADD CONSTRAINT `{$fkToAdd}` FOREIGN KEY (`{$to}`) REFERENCES `{$parent}` (`id`) ON DELETE CASCADE"
            );
        }
    }

    private function fkExists(string $table, string $name): bool
    {
        return (bool) DB::selectOne(
            'SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND CONSTRAINT_NAME = ? AND CONSTRAINT_TYPE = "FOREIGN KEY"',
            [$table, $name]
        );
    }

    private function indexExists(string $table, string $name): bool
    {
        return (bool) DB::selectOne(
            'SELECT INDEX_NAME FROM information_schema.STATISTICS
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND INDEX_NAME = ?',
            [$table, $name]
        );
    }

    private function updateStoredFilePaths(bool $toApplicant): void
    {
        $from = $toApplicant ? 'student/' : 'applicant/';
        $to = $toApplicant ? 'applicant/' : 'student/';

        DB::statement("UPDATE `".($toApplicant ? 'applicants' : 'students')."`
            SET photo = REPLACE(photo, '{$from}', '{$to}'),
                signature = REPLACE(signature, '{$from}', '{$to}')");
    }

    private function updateTokenableType(bool $toApplicant): void
    {
        $from = $toApplicant ? 'App\\Models\\Student' : 'App\\Models\\Applicant';
        $to = $toApplicant ? 'App\\Models\\Applicant' : 'App\\Models\\Student';

        DB::table('personal_access_tokens')
            ->where('tokenable_type', $from)
            ->update(['tokenable_type' => $to]);
    }
};
