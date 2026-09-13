<?php

namespace App\Exports;

use App\Models\Applicant;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ApplicantsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected array $photos = [];

    protected int $row = 1;

    public function __construct(protected array $filters = [])
    {
    }

    public function headings(): array
    {
        return [
            'SL', 'Photo', 'Name', 'Mobile', 'Email', 'NID', 'Gender',
            'Date of Birth', 'Father Name', 'Mother Name',
            'Present Address', 'Permanent Address',
        ];
    }

    public function collection()
    {
        $query = Applicant::with([
            'upazila', 'district', 'upazilaPermanent', 'districtPermanent',
        ])->latest('id');

        if (! empty($this->filters['email'])) {
            $query->where('email', 'like', '%'.$this->filters['email'].'%');
        }

        if (! empty($this->filters['phone'])) {
            $query->where('phone', 'like', '%'.$this->filters['phone'].'%');
        }

        $applicants = $query->get();

        return $applicants->map(function (Applicant $applicant) {
            $this->row++;

            if ($applicant->photo) {
                $this->photos[$this->row] = Storage::disk('public')->path($applicant->photo);
            }

            return [
                $this->row - 1,
                '',
                $applicant->name,
                $applicant->phone,
                $applicant->email,
                $applicant->nid,
                $applicant->gender,
                $applicant->date_of_birth,
                $applicant->father_name,
                $applicant->mother_name,
                $this->address($applicant, 'village', 'post_office', 'upazila', 'district'),
                $this->address($applicant, 'permanent_village', 'permanent_post_office', 'upazilaPermanent', 'districtPermanent'),
            ];
        });
    }

    protected function address(Applicant $a, string $village, string $post, string $upazilaRel, string $districtRel): string
    {
        $parts = array_filter([
            $a->$village,
            $a->$post ? 'Post: '.$a->$post.$a->post_code : null,
            optional($a->$upazilaRel)->name,
            optional($a->$districtRel)->name,
        ]);

        return implode(', ', $parts);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->getColumnDimension('B')->setAutoSize(false);
                $sheet->getColumnDimension('B')->setWidth(12);

                foreach ($this->photos as $row => $path) {
                    if (! is_file($path)) {
                        continue;
                    }

                    $sheet->getRowDimension($row)->setRowHeight(58);

                    $drawing = new Drawing();
                    $drawing->setPath($path);
                    $drawing->setCoordinates('B'.$row);
                    $drawing->setWidth(60);
                    $drawing->setHeight(72);
                    $drawing->setOffsetX(6);
                    $drawing->setOffsetY(2);
                    $drawing->setWorksheet($sheet);
                }
            },
        ];
    }
}
