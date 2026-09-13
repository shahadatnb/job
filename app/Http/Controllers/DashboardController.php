<?php

namespace App\Http\Controllers;

use App\Models\ApplicationStatus;
use App\Models\Applicant;
use App\Models\Job;
use App\Models\JobApplication;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function summary()
    {
        return response()->json([
            'applicants' => Applicant::count(),
            'applicants_today' => Applicant::whereDate('created_at', today())->count(),
            'jobs' => Job::count(),
            'active_jobs' => Job::where('status', 1)->whereDate('last_date', '>=', today())->count(),
            'expired_jobs' => Job::where('status', 1)->whereDate('last_date', '<', today())->count(),
            'applications' => JobApplication::count(),
            'applications_today' => JobApplication::whereDate('created_at', today())->count(),
            'applications_week' => JobApplication::where('created_at', '>=', now()->subDays(7))->count(),
        ]);
    }

    public function applicationsMonthly()
    {
        $counts = JobApplication::selectRaw("DATE_FORMAT(created_at, '%Y-%m') ym, COUNT(*) c")
            ->where('created_at', '>=', now()->copy()->startOfMonth()->subMonths(11))
            ->groupBy('ym')
            ->pluck('c', 'ym');

        $labels = [];
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->copy()->startOfMonth()->subMonths($i);
            $labels[] = $month->format('M y');
            $data[] = (int) $counts->get($month->format('Y-m'), 0);
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }

    public function applicationsByStatus()
    {
        $counts = JobApplication::selectRaw('status, COUNT(*) c')
            ->groupBy('status')
            ->pluck('c', 'status');

        $statuses = ApplicationStatus::where('status', 1)->orderBy('serial')->get();
        $known = $statuses->pluck('id')->all();

        $labels = [];
        $data = [];
        foreach ($statuses as $status) {
            $labels[] = $status->name;
            $data[] = (int) $counts->get($status->id, 0);
        }

        $rest = JobApplication::whereNotIn('status', $known)->count();
        if ($rest > 0) {
            $labels[] = 'Other';
            $data[] = $rest;
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }

    public function applicantGender()
    {
        $counts = Applicant::selectRaw("COALESCE(NULLIF(gender, ''), 'Unspecified') g, COUNT(*) c")
            ->groupBy('g')
            ->pluck('c', 'g');

        return response()->json([
            'labels' => $counts->keys()->all(),
            'data' => $counts->values()->map(fn ($v) => (int) $v)->all(),
        ]);
    }

    public function topJobs()
    {
        $top = JobApplication::selectRaw('job_id, COUNT(*) c')
            ->groupBy('job_id')
            ->orderByDesc('c')
            ->limit(5)
            ->with('job')
            ->get();

        return response()->json($top->map(fn ($row) => [
            'job_id' => $row->job_id,
            'title' => $row->job?->title ?? ('#'.$row->job_id),
            'vacancy' => $row->job?->vacancy,
            'last_date' => $row->job?->last_date ? Carbon::parse($row->job->last_date)->format('d M Y') : null,
            'applications' => (int) $row->c,
        ]));
    }

    public function recentApplications()
    {
        $applications = JobApplication::with(['applicant.district', 'job', 'application_status'])
            ->latest()
            ->limit(10)
            ->get();

        return response()->json($applications->map(fn ($application) => [
            'id' => $application->id,
            'applicant_id' => $application->applicant_id,
            'name' => $application->applicant?->name,
            'phone' => $application->applicant?->phone,
            'photo' => $application->applicant?->photo ? asset('storage/'.$application->applicant->photo) : null,
            'job_title' => $application->job?->title,
            'job_id' => $application->job_id,
            'status' => $application->application_status?->name,
            'applied_on' => $application->created_at?->format('d M Y'),
        ]));
    }

    public function recentApplicants()
    {
        $applicants = Applicant::with('district')
            ->latest('id')
            ->limit(10)
            ->get();

        return response()->json($applicants->map(fn ($applicant) => [
            'id' => $applicant->id,
            'name' => $applicant->name,
            'phone' => $applicant->phone,
            'email' => $applicant->email,
            'district' => $applicant->district?->name,
            'photo' => $applicant->photo ? asset('storage/'.$applicant->photo) : null,
            'joined_on' => $applicant->created_at?->format('d M Y'),
        ]));
    }
}
