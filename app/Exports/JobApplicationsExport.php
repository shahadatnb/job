<?php

namespace App\Exports;

use App\Models\JobApplication;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class JobApplicationsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected array $photos = [];

    protected int $row = 1;

    public function __construct(protected array $filters = [])
    {
    }

    public function headings(): array
    {
        return [
            'SL', 'Photo', 'Name', 'Mobile', 'Email', 'Job Title',
            'Age', 'Expected Salary', 'Status', 'Applied On',
        ];
    }

    public function collection()
    {
        $query = JobApplication::with(['applicant', 'job', 'application_status'])->latest();

        if (! empty($this->filters['job_id'])) {
            $query->where('job_id', $this->filters['job_id']);
        }

        if (! empty($this->filters['email'])) {
            $query->whereHas('applicant', fn ($q) => $q->where('email', $this->filters['email']));
        }

        if (! empty($this->filters['phone'])) {
            $query->whereHas('applicant', fn ($q) => $q->where('phone', $this->filters['phone']));
        }

        if (! empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        return $query->get()->map(function (JobApplication $application) {
            $this->row++;

            $applicant = $application->applicant;

            if ($applicant?->photo) {
                $this->photos[$this->row] = Storage::disk('public')->path($applicant->photo);
            }

            return [
                $this->row - 1,
                '',
                $applicant?->name,
                $applicant?->phone,
                $applicant?->email,
                $application->job?->title,
                $application->age,
                $application->expected_salary,
                $application->application_status?->name,
                $application->created_at?->format('d-m-Y h:i A'),
            ];
        });
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
