<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Models\User;

class MitraController extends Controller
{
    public function index()
    {
        $provinces = Province::all();

        return view('admin.mitra.mitra', compact('provinces'), ['pageTitle' => 'Mitra']);
    }

    public function fetchPartner(Request $request)
    {
        $province_id = $request->input('province_id');
        $district_id = $request->input('district_id');

        $query = User::where('role_id', 2)
            ->with(['partnerProfile']);

        if ($province_id) {
            $query->whereHas('partnerProfile', function ($q) use ($province_id) {
                $q->where('province_id', $province_id);
            });
        }

        if ($district_id) {
            $query->whereHas('partnerProfile', function ($q) use ($district_id) {
                $q->where('district_id', $district_id);
            });
        }

        $partners = $query->get();

        return response()->json(['data' => $partners]);
    }

    public function getDistricts($province_id)
    {
        $districts = District::where('province_id', $province_id)->get();
        return response()->json($districts);
    }

    public function getMitraById($id)
    {
        $mitra = User::where('role_id', 2)->with(['partnerProfile', 'partnerProfile.photoProfile'])->find($id);

        if (!$mitra) {
            return response()->json(['message' => 'Mitra not found'], 404);
        }

        $mitra->userPhotoProfile = $mitra->partnerProfile->photoProfile->publicUrl ?? null;

        return response()->json($mitra);
    }

    public function activateMitra($id)
    {
        $mitra = User::where('role_id', 2)->find($id);

        if (!$mitra) {
            return response()->json(["success" => false, 'message' => 'Mitra not found'], 404);
        }

        $mitra->is_active = 1;
        $mitra->save();

        return response()->json(["success" => true, 'message' => 'Mitra activated successfully']);
    }

    public function deactivateMitra($id)
    {
        $mitra = User::where('role_id', 2)->find($id);

        if (!$mitra) {
            return response()->json(["success" => false, 'message' => 'Mitra not found'], 404);
        }

        $mitra->is_active = 0;
        $mitra->save();

        return response()->json(["success" => true, 'message' => 'Mitra deactivated successfully',]);
    }

    public function deleteMitra($id)
    {
        $mitra = User::where('role_id', 2)->find($id);

        if (!$mitra) {
            return response()->json(["success" => false, 'message' => 'Mitra not found'], 404);
        }

        $mitra->delete();

        return response()->json(["success" => true, 'message' => 'Mitra deleted successfully']);
    }

    public function downloadMitra()
    {
        // Retrieve all mitra with their partnerProfile and eager load additional relationships if necessary
        $mitras = User::where('role_id', 2)
            ->with([
                'partnerProfile.province',
                'partnerProfile.district',
                'partnerProfile.organization'
            ])
            ->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=mitra_data.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        // Define CSV columns including partner profile and relationships data.
        $columns = [
            "User ID",
            "Username",
            "User Email",
            "Is Active",
            "Partner Name",
            "Address",
            "Phone Number",
            "Postal Code",
            "Province",
            "District",
            "Subdistrict",
            "Organization",
            "About Company",
            "PIC Name",
            "PIC Email",
            "PIC Phone Number",
            "PIC Position",
        ];

        $callback = function () use ($mitras, $columns) {
            $file = fopen('php://output', 'w');
            // Write CSV header row.
            fputcsv($file, $columns);

            foreach ($mitras as $mitra) {
                $profile = $mitra->partnerProfile;
                // Prepare related data if the partner profile is available
                $partnerName   = $profile->partner_name ?? 'N/A';
                // Use the email from the User as the user email outside of partner profile email.
                $userEmail     = $mitra->email ?? 'N/A';
                $address       = $profile->address ?? 'N/A';
                $phone         = $profile->phone_number ?? 'N/A';
                $postalCode    = $profile->postal_code ?? 'N/A';
                $province      = ($profile->province && isset($profile->province->province_name)) ? $profile->province->province_name : 'N/A';
                $district      = ($profile->district && isset($profile->district->district_name)) ? $profile->district->district_name : 'N/A';
                $subdistrict   = $profile->subdistrict_id ?? 'N/A';
                $organization  = ($profile->organization && isset($profile->organization->organization_name)) ? $profile->organization->organization_name : 'N/A';
                $aboutCompany  = $profile->about_company ?? 'N/A';
                $picName       = $profile->pic_name ?? 'N/A';
                $picEmail      = $profile->pic_email ?? 'N/A';
                $picPhone      = $profile->pic_phone_number ?? 'N/A';
                $picPosition   = $profile->pic_position ?? 'N/A';

                // Assemble the row data.
                $row = [
                    $mitra->user_id,
                    $mitra->username,
                    $userEmail,
                    ($mitra->is_active ? 'Active' : 'Inactive'),
                    $partnerName,
                    $address,
                    $phone,
                    $postalCode,
                    $province,
                    $district,
                    $subdistrict,
                    $organization,
                    $aboutCompany,
                    $picName,
                    $picEmail,
                    $picPhone,
                    $picPosition,
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
