<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\PostJob;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $jobsQuery = PostJob::withCount('applications');
        $application = Application::where('status', 'completed')->get();

        $jobCount = $jobsQuery->count();
        $applicationCount = $application->count();

        $jobs = $jobsQuery->get();

        $totalApplicants = $jobs->sum('applications_count');

        return view('admin.dashboard.dashboard', [
            'pageTitle' => 'Dashboard',
            'jobCount' => $jobCount,
            'totalApplicants' => $totalApplicants,
            'completeApplication' => $applicationCount,
        ]);
    }
}
