<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class CandidateController extends Controller
{
    public function index()
    {

        return view('admin.candidate.index', ['pageTitle' => 'Kandidat Pekerjaan']);
    }

    public function fetchCandidate()
    {
        $statuses = ['review_by_admin', 'rejected_by_admin', 'review_by_mitra', 'rejected_by_mitra', 'accepted'];

        $applications = Application::with(['user.freelancerProfile', 'job.user.partnerProfile'])
            ->whereIn('status', $statuses)
            ->paginate(20);

        return response()->json($applications);
    }

    public function getCandidateById($id)
    {
        try {
            $candidate = Application::with([
                'user.freelancerProfile',
                'user.freelancerProfile.photoProfile',
                'user.freelancerProfile.fileCV',
                'user.freelancerProfile.fileSKKNI',
                'user.freelancerProfile.fileSKKK',
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
            $candidate->status = 'review_by_mitra';
            $candidate->save();

            return response()->json([
                'success' => true,
                'message' => 'Candidate status updated to review_by_mitra.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Candidate not found.',
            ], 404);
        } catch (\Exception $e) {
            // Log the exception message
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
            $candidate->status = 'rejected_by_admin';
            $candidate->save();

            return response()->json([
                'success' => true,
                'message' => 'Candidate status updated to rejected_by_admin.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Candidate not found.',
            ], 404);
        } catch (\Exception $e) {
            // Log the exception message
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
            // Log the exception message
            Log::error('Error deleting candidate: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the candidate.',
            ], 500);
        }
    }

    public function downloadCV($id)
    {
        $file = File::find($id);
        if (!$file) {
            abort(404, 'File record not found.');
        }

        $filePath = ltrim(str_replace('local:', '', $file->path), '/');
        $disk = Storage::disk('private');
        if (!$disk->exists($filePath)) {
            Log::error('File not found on disk: ' . $filePath);
            abort(404, 'File not found.');
        }

        $filename = $file->original_filename;
        if (!pathinfo($filename, PATHINFO_EXTENSION)) {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            $filename .= '.' . $extension;
        }

        $mimeType = $disk->mimeType($filePath);
        $localPath = $disk->path($filePath);

        return response()->file($localPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }
}
