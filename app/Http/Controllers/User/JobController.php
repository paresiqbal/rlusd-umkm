<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\District;
use App\Models\Education;
use App\Models\EmploymentType;
use App\Models\PostJob;
use App\Models\Province;
use App\Models\ServiceType;
use App\Utility\GlobalToastUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve all necessary data for filters
        $job_type = EmploymentType::all();
        $provinces = Province::all();
        $districts = District::all();
        $education = Education::all();
        $service_types = ServiceType::all();

        // Initialize the query with accepted and approved jobs
        $jobs = PostJob::with(['user.partnerProfile.logoFile'])
            ->where('status', 'accepted')
            ->whereNotNull('approved_at')
            ->whereNotNull('approved_by')
            ->whereRelation('user', function ($query) {
                $query->where('is_active', true);
            });

        // Apply filters based on user input

        // Filter by Job Type
        if ($request->filled('job_type')) {
            $jobs->where('employment_type_id', $request->job_type);
        }

        // Filter by Location (District)
        if ($request->filled('location')) {
            $jobs->where('district_id', $request->location);
        }

        // Filter by Education Level
        if ($request->filled('education')) {
            $jobs->where('min_education_id', $request->education);
        }

        // Filter by Skills
        if ($request->filled('skills')) {
            $jobs->whereHas('skills', function ($query) use ($request) {
                $query->where('skill_name', "like", "%" . $request->skills . "%");
            });
        }

        // Filter by Service Type
        if ($request->filled('service_type')) {
            $jobs->where('service_type_id', $request->service_type);
        }

        // **Handle the Search Query**
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $jobs->where(function ($query) use ($searchTerm) {
                $query->where('role', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('job_desc', 'LIKE', "%{$searchTerm}%");
            });
        }

        $data = [
            'job_type' => $job_type,
            'provinces' => $provinces,
            'districts' => $districts,
            'education' => $education,
            'service_types' => $service_types,
            'jobs' => $jobs->paginate(10)->withQueryString()
        ];

        return view('user.search-jobs.index', $data);
    }

    public function show($id)
    {
        $job = PostJob::with(['user.partnerProfile.logoFile'])
            ->where('post_job_id', $id)
            ->where('status', 'accepted')
            ->whereRelation('user', function ($query) {
                $query->where('is_active', true);
            })->first();

        if (!$job) {
            GlobalToastUtility::error('Lowongan tidak tersedia');
            return redirect()->route('jobs.index-search');
        }

        $data = [
            'job' => $job,
            'partner' => $job->user->partnerProfile,
        ];

        return view('user.job-detail.index', $data);
    }

    public function store(Request $request, $id)
    {
        // Check if the user is active
        if (!Auth::user()->is_active) {
            session()->flash('error', 'Anda tidak dapat melamar pekerjaan karena akun Anda tidak aktif.');
            return redirect()->back();
        }

        $existingApplication = Application::where('post_job_id', $id)
            ->where('applicant_id', Auth::user()->user_id)
            ->first();

        if ($existingApplication) {
            session()->flash('error', 'Anda sudah melamar pekerjaan ini sebelumnya.');
            return redirect()->back();
        }

        $request->validate([
            'note' => 'nullable|string',
        ]);

        Application::create([
            'post_job_id' => $id,
            'applicant_id' => Auth::user()->user_id,
            'status' => 'review_by_admin',
            'note' => $request->input('note'),
        ]);

        GlobalToastUtility::success('Lamaran Berhasil Dikirim.');

        return redirect()->back();
    }
}
