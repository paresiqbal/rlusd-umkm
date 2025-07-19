<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Support\Facades\Log;

class CandidateController extends Controller
{
    public function index()
    {
        return view('partner.candidate.index', ['pageTitle' => 'Kandidat Pekerjaan']);
    }

    public function fetchCandidate()
    {
        $statuses = ['review_by_mitra', 'completed', 'rejected_by_mitra', 'accepted'];

        // Filter applications to only include those whose job is created by the current partner.
        $applications = Application::with(['user.freelancerProfile', 'job.user.partnerProfile'])
            ->whereIn('status', $statuses)
            ->whereHas('job', function ($query) {
                // Assuming the partner's user_id is the id of the authenticated user.
                // This filter restricts jobs to those created by the currently authenticated partner.
                $query->where('created_by', auth()->user()->user_id);
            })
            ->paginate(20);

        return response()->json($applications);
    }

    public function getCandidateById($id)
    {
        try {
            $candidate = Application::with([
                'user.freelancerProfile',
                'user.freelancerProfile.photoProfile',
                'user.freelancerProfile.educations',
                'user.freelancerProfile.experiences',
                'user.freelancerProfile.skills',
                'job.user.partnerProfile'
            ])
                ->where('application_id', $id)
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => $candidate,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Candidate not found.',
            ], 404);
        }
    }

    public function acceptCandidate($id)
    {
        try {
            $candidate = Application::where('application_id', $id)->firstOrFail();

            if ($candidate->status === 'completed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot update a candidate that is already completed.',
                ], 400);
            }

            $candidate->status = 'accepted';
            $candidate->save();

            return response()->json([
                'success' => true,
                'message' => 'Candidate status updated to accepted.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Candidate not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error updating candidate status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the candidate status.',
            ], 500);
        }
    }

    public function rejectCandidate($id)
    {
        try {
            $candidate = Application::where('application_id', $id)->firstOrFail();

            if ($candidate->status === 'completed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot update a candidate that is already completed.',
                ], 400);
            }

            $candidate->status = 'rejected_by_mitra';
            $candidate->save();

            return response()->json([
                'success' => true,
                'message' => 'Candidate status updated to rejected.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Candidate not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error updating candidate status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the candidate status.',
            ], 500);
        }
    }

    public function completedCandidate($id)
    {
        try {
            $candidate = Application::where('application_id', $id)
                ->where('status', 'accepted')
                ->firstOrFail();
            $candidate->status = 'completed';
            $candidate->save();

            return response()->json([
                'success' => true,
                'message' => 'Candidate status updated to completed.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Candidate not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error updating candidate status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the candidate status.',
            ], 500);
        }
    }

    public function deleteCandidate($id)
    {
        try {
            $candidate = Application::where('application_id', $id)->firstOrFail();
            $candidate->delete();

            return response()->json([
                'success' => true,
                'message' => 'Candidate deleted successfully.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Candidate not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error deleting candidate: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the candidate.',
            ], 500);
        }
    }
}
