<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\PostJob;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->user_id;
        $jobsQuery = PostJob::where('created_by', $userId);
        $application = Application::where('status', 'completed')->get();

        // Retrieve the job count
        $jobCount = $jobsQuery->count();
        $applicationCount = $application->count();

        // Retrieve the jobs along with the applicant count
        $jobs = $jobsQuery->withCount('applications')->get();

        // Calculate the total number of applicants
        $totalApplicants = $jobs->sum('applications_count');

        return view('partner.dashboard.dashboard', [
            'pageTitle' => 'Dashboard',
            'jobCount' => $jobCount,
            'totalApplicants' => $totalApplicants,
            'completeApplication' => $applicationCount, // Ensure this is correctly named
        ]);
    }
}
