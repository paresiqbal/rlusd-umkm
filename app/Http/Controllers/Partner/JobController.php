<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Education;
use App\Models\EmploymentType;
use App\Models\JobType;
use App\Models\PostJob;
use App\Models\Province;
use App\Models\Sector;
use App\Models\ServiceType;
use App\Models\Skill;
use App\Models\Subdistrict;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
    public function index()
    {
        // Retrieve skills selected by the postJob
        $postJobs = PostJob::get();
        $selectedSkills = [];
        foreach ($postJobs as $postJob) {
            foreach ($postJob->skills as $skills) {
                $selectedSkills[] = $skills->skill_id;
            }
        }

        $partner = Auth::user();
        $educations = Education::paginate(15);
        $provinces = Province::all();
        $districts = $partner && $partner->province_id
            ? District::where('province_id', $partner->province_id)->get()
            : collect();
        $subdistricts = $partner && $partner->district_id
            ? Subdistrict::where('district_id', $partner->district_id)->get()
            : collect();
        $employmentTypes = EmploymentType::paginate(15);
        $jobTypes = JobType::paginate(15);
        $skills = Skill::whereIn('skill_id', $selectedSkills)->get();
        $sectors = Sector::all();
        $serviceTypes = ServiceType::all();


        $data = [
            'partner' => $partner,
            'employmentTypes' => $employmentTypes,
            'jobTypes' => $jobTypes,
            'serviceTypes' => $serviceTypes,
            'educations' => $educations,
            'provinces' => $provinces,
            'districts' => $districts,
            'subdistricts' => $subdistricts,
            'skills' => $skills,
            'sectors' => $sectors,
        ];

        return view('partner.jobs.index', ['pageTitle' => 'Kebutuhan Jasa'], $data);
    }

    /**
     * Get the districts and subdistrict based on the selected province.
     */
    public function getDistricts($province_id)
    {
        $districts = District::where('province_id', $province_id)->get();
        return response()->json($districts);
    }

    public function getSubdistricts($district_id)
    {
        $subdistricts = Subdistrict::where('district_id', $district_id)->get();
        return response()->json($subdistricts);
    }

    public function fetchJobs(Request $request)
    {
        $userId = Auth::user()->user_id;
        $keyword = $request->query('search');
        $status = $request->query('status');

        $jobsQuery = PostJob::where('created_by', $userId);

        if ($keyword) {
            $jobsQuery->where('role', 'LIKE', '%' . $keyword . '%');
        }

        if ($status && $status !== 'semua') {
            $jobsQuery->where('status', $status);
        }

        $jobs = $jobsQuery->with(['skills', 'education', 'employmentType', 'jobType', 'province', 'district', 'applications'])->paginate(20);


        // Transform the result to include job_type_name
        $jobs->getCollection()->transform(function ($job) {
            $job->job_type_name = $job->jobType ? $job->jobType->job_type_name : null;
            $job->education_name = $job->education ? $job->education->education_name : null;
            $job->employment_type_name = $job->employmentType ? $job->employmentType->employment_type_name : null;
            $job->skill_names = $job->skills->pluck('skill_name')->toArray();
            $job->applicant_count = $job->applications->count();
            return $job;
        });

        return response()->json($jobs);
    }

    public function storeJob(Request $request)
    {
        // Check if the user is active
        if (!Auth::user()->is_active) {
            session()->flash('error', 'Anda tidak dapat memposting lowongan karena akun Anda tidak aktif.');
            return redirect()->back();
        }

        $validated = $request->validate([
            'role'                => 'required|string|max:255',
            'number_sdm'          => 'required|integer',
            'job_desc'            => 'required|string',
            'min_education_id'    => 'required|exists:educations,education_id',
            'employment_type_id'  => 'required|exists:employment_types,employment_type_id',
            'job_type_id'         => 'required|exists:job_types,job_type_id',
            'province_id'         => 'required|exists:provinces,province_id',
            'district_id'         => 'required|exists:districts,district_id,province_id,' . $request->province_id,
            'subdistrict_id'      => 'required|exists:subdistricts,subdistrict_id,district_id,' . $request->district_id,
            'min_salary'          => 'required|numeric',
            'max_salary'          => 'required|numeric',
            'qualifications'      => 'required|string',
            'skills'              => 'required|array',
            'skills.*'            => 'nullable',
            'additional_info'     => 'nullable|string',
            'country_id'          => 'required|integer',
            'address'             => 'required|string|max:255',
            'job_category_id'     => 'required|exists:sectors,sector_id',
            'genders'             => 'required|in:1,2,3',
            'is_hidden_salary'    => 'nullable|boolean',
            'service_types'       => 'required|array',
            'service_types.*'     => 'exists:service_types,service_type_id',
        ]);

        $validated['status'] = 'review_by_admin';
        $validated['genders'] = match ($request->genders) {
            '1' => 'laki laki',
            '2' => 'perempuan',
            '3' => 'tidak ditentukan',
            default => null,
        };

        // split array into new_skills and existing_skills
        $skills = $validated['skills'];
        $new_skills = [];
        $existing_skills = [];

        foreach ($skills as $skill) {
            if (is_numeric($skill)) {
                $existing_skills[] = $skill;
            } else {
                $new_skills[] = $skill;
            }
        }

        try {
            // insert new skills to database 
            if (!empty($new_skills)) {
                foreach ($new_skills as $new_skill) {
                    $skillModel = new Skill();
                    $skillModel->skill_name = $new_skill;

                    $skillModel->saveOrFail();
                    $existing_skills[] = $skillModel->skill_id;
                }
            }

            $validated['created_by'] = Auth::user()->user_id;

            $postJob = PostJob::create($validated);

            // Attach skills
            $postJob->skills()->attach($existing_skills);

            // Attach service types selected by the user, via checkboxes
            $postJob->serviceTypes()->attach($validated['service_types']);

            session()->flash('success', 'Lowongan berhasil diposting.');
        } catch (QueryException $e) {
            Log::error('Job Posting Error: ' . $e->getMessage());
            session()->flash('error', 'Gagal memposting lowongan. Silakan coba lagi.');
        }

        return redirect()->back();
    }

    public function updateJob(Request $request, $id)
    {
        $validatedData = $request->validate([
            'role' => 'required|string|max:255',
            'number_sdm' => 'required|integer',
            'job_desc' => 'required|string',
            'min_education_id' => 'required|exists:educations,education_id',
            'min_salary' => 'required|numeric',
            'max_salary' => 'required|numeric|gte:min_salary',
            'is_hidden_salary' => 'sometimes|boolean',
            'employment_type_id' => 'required|exists:employment_types,employment_type_id',
            'job_category_id' => 'required|exists:sectors,sector_id',
            'province_id' => 'required|exists:provinces,province_id',
            'district_id' => 'required|exists:districts,district_id,province_id,' . $request->province_id,
            'subdistrict_id' => 'required|exists:subdistricts,subdistrict_id,district_id,' . $request->district_id,
            'address' => 'required|string|max:255',
            'job_type_id' => 'required|exists:job_types,job_type_id',
            'qualifications' => 'required|string',
            'skills' => 'required|array',
        ]);

        $validatedData['genders'] = match ($request->genders) {
            '1' => 'laki laki',
            '2' => 'perempuan',
            '3' => 'tidak ditentukan',
            default => null,
        };

        // Set status to 'review_by_admin' when editing the job
        $validatedData['status'] = 'review_by_admin';

        // split array into new_skills and existing_skills
        $skills = $request->skills;
        $new_skills = [];
        $existing_skills = [];

        foreach ($skills as $skill) {
            if (is_numeric($skill)) {
                $existing_skills[] = $skill;
            } else {
                $new_skills[] = $skill;
            }
        }

        try {
            // insert new skills to database 
            if (!empty($new_skills)) {
                foreach ($new_skills as $new_skill) {
                    $skillModel = new Skill();
                    $skillModel->skill_name = $new_skill;

                    $skillModel->saveOrFail();
                    $existing_skills[] = $skillModel->skill_id;
                }
            }

            $job = PostJob::findOrFail($id);
            $job->update($validatedData);

            $job->skills()->sync($existing_skills);

            return redirect()->back()->with('success', 'Job updated successfully and sent for review by admin!');
        } catch (\Exception $e) {
            Log::error('Job Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update job. Please try again.');
        }
    }

    public function getJobById($id)
    {
        try {
            $job = PostJob::with([
                'skills',
                'education',
                'employmentType',
                'jobType',
                'province',
                'district',
                'subdistrict',
                'serviceTypes'
            ])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data'    => $job,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Job not found.',
            ], 404);
        }
    }

    public function delete($id)
    {
        try {
            $job = PostJob::findOrFail($id);
            $job->delete();

            return response()->json([
                'success' => true,
                'message' => 'Job deleted successfully.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Job not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Job Deletion Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete job. Please try again.',
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $job = PostJob::findOrFail($id);
            $job->status = $request->input('status');
            $job->save();

            return response()->json(['success' => true, 'message' => 'Job status updated successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Job not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while updating job status.'], 500);
        }
    }
}
