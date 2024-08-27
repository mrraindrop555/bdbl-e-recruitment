<?php

namespace App\Exports;

use App\Models\Application;
use App\Models\Vacancy;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ApplicationExport implements FromCollection, WithHeadings, WithMapping
{
    protected $vacancy;

    public function __construct(Vacancy $vacancy)
    {
        $this->vacancy = $vacancy;
    }

    public function headings(): array
    {
        return [
            'ID',
            'CID',
            'Name',
            'Email',
            'Vacancy',
            'Class X School',
            'Class X Completion Year',
            'Class X Marks',
            'Class X Average',
            'Class XII School',
            'Class XII Stream',
            'Class XII Completion Year',
            'Class XII Marks',
            'Class XII Average',
            'University/College Name',
            'University/College Course',
            'University/College Completion Year',
            'University/College Percentage',
            'Masters Institution',
            'Masters Course',
            'Masters Completion Year',
            'Masters Percentage',
            'Final Score',
            'Is Shortlisted',
            'Created At',
            'Updated At',
        ];
    }

    public function map($application): array
    {
        return [
            $application->id,
            $application->cid,
            $application->name,
            $application->email,
            $application->vacancy->title ?? 'N/A', // Assuming vacancy has a 'title' field
            $application->class_x_school_name,
            $application->class_x_completion_year,
            $application->class_x_marks,
            $application->class_x_avg,
            $application->class_xii_school_name,
            $application->class_xii_stream,
            $application->class_xii_completion_year,
            $application->class_xii_marks,
            $application->class_xii_avg,
            $application->university_or_college_name,
            $application->university_or_college_course_name,
            $application->university_or_college_completion_year,
            $application->university_or_college_percentage,
            $application->masters_institution_name,
            $application->masters_course_name,
            $application->masters_completion_year,
            $application->masters_percentage,
            $application->final_score,
            $application->is_shortlisted ? 'Yes' : 'No',
            $application->created_at->toDateTimeString(),
            $application->updated_at->toDateTimeString(),
        ];
    }

    public function collection()
    {
        return $this->vacancy->applications;
    }
}
