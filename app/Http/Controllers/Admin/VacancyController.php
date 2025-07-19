<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostJob;
use Illuminate\Support\Facades\Auth;

class VacancyController extends Controller
{
    public function index()
    {
        return view('admin.vacancy.index', ['pageTitle' => 'Lowongan Jasa']);
    }

    public function fetchJobs()
    {
        $jobs = PostJob::with(['user', 'user.partnerProfile'])->paginate(20);

        return response()->json($jobs);
    }

    public function getJobById($id)
    {
        try {
            $job = PostJob::with([
                'skills',
                'education',
                'employmentType',
                'jobType',
                'serviceTypes',
                'province',
                'district',
                'subdistrict',
                'user',
                'user.partnerProfile'
            ])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $job,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Job not found.',
            ], 404);
        }
    }

    public function acceptJobs($id)
    {
        try {
            $job = PostJob::where('post_job_id', $id)->firstOrFail();

            $job->status = 'accepted';
            $job->approved_at = now();
            $job->approved_by = Auth::id();
            $job->save();

            return response()->json([
                'success' => true,
                'message' => 'Jobs status updated to review_by_mitra.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Jobs not found.',
            ], 404);
        }
    }

    public function rejectJobs($id)
    {
        try {
            $job = PostJob::where('post_job_id', $id)->firstOrFail();

            $job->status = 'reject_by_admin';
            $job->approved_at = null;
            $job->approved_by = null;
            $job->save();

            return response()->json([
                'success' => true,
                'message' => 'Job status updated to rejected.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Job not found.',
            ], 404);
        }
    }

    public function deleteJob($id)
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
        }
    }
}
