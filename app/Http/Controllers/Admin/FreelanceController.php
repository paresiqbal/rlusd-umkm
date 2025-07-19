<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FreelanceController extends Controller
{
    public function index()
    {
        $provinces = Province::all();

        return view('admin.freelance.freelance', compact('provinces'), ['pageTitle' => 'Konsultan']);
    }

    public function fetchFreelancer(Request $request)
    {
        $province_id = $request->input('province_id');
        $district_id = $request->input('district_id');
        $main_skill = $request->input('main_skill');

        // Start with the query builder without calling get() immediately.
        $query = User::where('role_id', 1);

        if ($province_id) {
            $query->whereHas('freelancerProfile', function ($q) use ($province_id) {
                $q->where('province_id', $province_id);
            });
        }

        if ($district_id) {
            $query->whereHas('freelancerProfile', function ($q) use ($district_id) {
                $q->where('district_id', $district_id);
            });
        }

        // If main_skill filter is provided, use whereJsonContains to filter freelancerProfile.
        if ($main_skill) {
            $query->whereHas('freelancerProfile', function ($q) use ($main_skill) {
                $q->whereJsonContains('main_skill', $main_skill);
            });
        }

        // Eager load the freelancerProfile relationship.
        $freelancers = $query->with('freelancerProfile')->get();

        return response()->json([
            'data' => $freelancers
        ]);
    }

    public function getFreelancerById($id)
    {
        $freelancer = User::where('role_id', 1)
            ->with([
                'freelancerProfile',
                'freelancerProfile.photoProfile',
                'freelancerProfile.educations',
                'freelancerProfile.experiences',
                'freelancerProfile.skills',
                'freelancerProfile.achievements',
                'freelancerProfile.fileCV',
                'freelancerProfile.fileSKKNI',
                'freelancerProfile.fileSKKK'
            ])
            ->find($id);

        if (!$freelancer) {
            return response()->json([
                'message' => 'Freelancer not found'
            ], 404);
        }

        // Compute userPhotoProfile from freelancerProfile.photoProfile's publicUrl
        $freelancer->userPhotoProfile = $freelancer->freelancerProfile->photoProfile->publicUrl ?? null;

        return response()->json([
            'data' => $freelancer
        ]);
    }

    public function activateFreelancer($id)
    {
        $freelancer = User::where('role_id', 1)->find($id);

        if (!$freelancer) {
            return response()->json(["success" => false, 'message' => 'Freelancer not found'], 404);
        }

        $freelancer->is_active = 1;
        $freelancer->save();

        return response()->json(["success" => true, 'message' => 'Freelancer activated successfully']);
    }

    public function deactivateFreelancer($id)
    {
        $freelancer = User::where('role_id', 1)->find($id);

        if (!$freelancer) {
            return response()->json(["success" => false, 'message' => 'Freelancer not found'], 404);
        }

        $freelancer->is_active = 0;
        $freelancer->save();

        return response()->json(["success" => true, 'message' => 'Freelancer deactivated successfully',]);
    }

    public function deleteFreelancer($id)
    {
        $freelancer = User::where('role_id', 1)->find($id);

        if (!$freelancer) {
            return response()->json(["success" => false, 'message' => 'Freelancer not found'], 404);
        }

        $freelancer->delete();

        return response()->json(["success" => true, 'message' => 'Freelancer deleted successfully']);
    }

    public function downloadFreelancer()
    {
        // Retrieve all freelancers along with their related freelancer profile data (excluding fileCV, fileSKKNI, fileSKKK, and applyJob)
        $freelancers = User::where('role_id', 1)
            ->with([
                'freelancerProfile.educations',
                'freelancerProfile.experiences',
                'freelancerProfile.skills',
                'freelancerProfile.achievements'
            ])
            ->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=freelancer_data.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        // Define CSV columns. We include all desired freelancerProfile fields except fileCV, fileSKKNI, fileSKKK and applyJob.
        $columns = [
            "User ID",
            "Username",
            "User Email",
            "Is Active",
            "Freelancer Name",
            "Birthdate",
            "Birthplace",
            "Phone Number",
            "Gender",
            "Country ID",
            "Province ID",
            "District ID",
            "Subdistrict ID",
            "Postal Code",
            "Address",
            "About Me",
            "Rating",
            "File Photo ID",
            "Approved At",
            "Approved By",
            "Educations Count",
            "Experiences Count",
            "Achievements Count",
            "Skills"
        ];

        $callback = function () use ($freelancers, $columns) {
            $file = fopen('php://output', 'w');
            // Write CSV header row.
            fputcsv($file, $columns);

            foreach ($freelancers as $freelancer) {
                $profile = $freelancer->freelancerProfile;
                // If no profile exists, use default N/A values.
                $freelancerName    = $profile && isset($profile->name) ? $profile->name : 'N/A';
                $birthdate         = $profile && isset($profile->birthdate) ? $profile->birthdate : 'N/A';
                $birthplace        = $profile && isset($profile->birthplace) ? $profile->birthplace : 'N/A';
                $phoneNumber       = $profile && isset($profile->phone_number) ? $profile->phone_number : 'N/A';
                $gender            = $profile && isset($profile->gender) ? $profile->gender : 'N/A';
                $countryId         = $profile && isset($profile->country_id) ? $profile->country_id : 'N/A';
                $provinceId        = $profile && isset($profile->province_id) ? $profile->province_id : 'N/A';
                $districtId        = $profile && isset($profile->district_id) ? $profile->district_id : 'N/A';
                $subdistrictId     = $profile && isset($profile->subdistrict_id) ? $profile->subdistrict_id : 'N/A';
                $postalCode        = $profile && isset($profile->postal_code) ? $profile->postal_code : 'N/A';
                $address           = $profile && isset($profile->address) ? $profile->address : 'N/A';
                $aboutMe           = $profile && isset($profile->about_me) ? $profile->about_me : 'N/A';
                $rating            = $profile && isset($profile->rating) ? $profile->rating : 'N/A';
                $filePhotoId       = $profile && isset($profile->file_photo_id) ? $profile->file_photo_id : 'N/A';
                $approvedAt        = $profile && isset($profile->approved_at) ? $profile->approved_at : 'N/A';
                $approvedBy        = $profile && isset($profile->approved_by) ? $profile->approved_by : 'N/A';

                // Count related model arrays
                $educationsCount   = ($profile && $profile->educations) ? count($profile->educations) : 0;
                $experiencesCount  = ($profile && $profile->experiences) ? count($profile->experiences) : 0;
                $achievementsCount = ($profile && $profile->achievements) ? count($profile->achievements) : 0;

                $skills = 'N/A';
                if ($profile && $profile->skills && $profile->skills->isNotEmpty()) {
                    // Map skills to get names and join them.
                    $skillsArray = array_map(function ($skill) {
                        if (isset($skill['name'])) {
                            return $skill['name'];
                        } elseif (isset($skill['skill_name'])) {
                            return $skill['skill_name'];
                        }
                        return 'Unknown Skill';
                    }, $profile->skills->toArray());
                    $skills = implode(', ', $skillsArray);
                }

                $row = [
                    $freelancer->user_id,
                    $freelancer->username,
                    $freelancer->email,
                    ($freelancer->is_active ? 'Active' : 'Inactive'),
                    $freelancerName,
                    $birthdate,
                    $birthplace,
                    $phoneNumber,
                    $gender,
                    $countryId,
                    $provinceId,
                    $districtId,
                    $subdistrictId,
                    $postalCode,
                    $address,
                    $aboutMe,
                    $rating,
                    $filePhotoId,
                    $approvedAt,
                    $approvedBy,
                    $educationsCount,
                    $experiencesCount,
                    $achievementsCount,
                    $skills,
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
