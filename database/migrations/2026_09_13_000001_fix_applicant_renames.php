<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $fkTables = [
        'applicant_education', 'applicant_employments', 'applicant_trainings',
        'applicant_skills', 'applicant_certifications',
    ];

    public function up(): void
    {
        if (! Schema::hasTable('applicants')) {
            return;
        }

        $this->fixStoredFilePaths('ex_applicant/', 'ex_student/');

        foreach ($this->fkTables as $table) {
            $old = 'student_'.substr($table, strlen('applicant_')).'_applicant_id_foreign';
            $new = $table.'_applicant_id_foreign';
            if ($this->fkExists($table, $old)) {
                DB::statement("ALTER TABLE `$table` DROP FOREIGN KEY `$old`");
                DB::statement("ALTER TABLE `$table` DROP INDEX `$old`");
                DB::statement(
                    "ALTER TABLE `$table` ADD CONSTRAINT `$new` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE"
                );
            }
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('applicants')) {
            return;
        }

        $this->fixStoredFilePaths('ex_student/', 'ex_applicant/');

        foreach ($this->fkTables as $table) {
            $old = 'student_'.substr($table, strlen('applicant_')).'_applicant_id_foreign';
            $new = $table.'_applicant_id_foreign';
            if ($this->fkExists($table, $new)) {
                DB::statement("ALTER TABLE `$table` DROP FOREIGN KEY `$new`");
                DB::statement("ALTER TABLE `$table` DROP INDEX `$new`");
                DB::statement(
                    "ALTER TABLE `$table` ADD CONSTRAINT `$old` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`) ON DELETE CASCADE"
                );
            }
        }
    }

    private function fixStoredFilePaths(string $from, string $to): void
    {
        DB::statement("UPDATE `applicants`
            SET photo = REPLACE(photo, ?, ?), signature = REPLACE(signature, ?, ?)", [$from, $to, $from, $to]);
    }

    private function fkExists(string $table, string $name): bool
    {
        return (bool) DB::selectOne(
            'SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND CONSTRAINT_NAME = ? AND CONSTRAINT_TYPE = "FOREIGN KEY"',
            [$table, $name]
        );
    }
};
