<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Organization;
use App\Models\Province;
use App\Models\Subdistrict;
use App\Models\File;
use App\Models\User;
use App\Utility\GlobalToastUtility;
use App\Utility\FileStorage\FileStorageReturn;
use App\Utility\FileStorage\FileStorageUtility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ProfileController extends Controller
{
    /**
     * Display the partner profile dashboard.
     */
    public function show()
    {
        $user = Auth::user();
        $partner = $user->partnerProfile;
        $organizations = Organization::all();
        $provinces = Province::all();
        $districts = $partner && $partner->province_id
            ? District::where('province_id', $partner->province_id)->get()
            : collect();
        $subdistricts = $partner && $partner->district_id
            ? Subdistrict::where('district_id', $partner->district_id)->get()
            : collect();


        return view('partner.profiles.show', [
            'pageTitle' => 'Lengkapi Profil',
            'user' => $user,
            'partner' => $partner,
            'userPhotoProfile' => $user->profile?->photoProfile?->publicUrl,
            'provinces' => $provinces,
            'districts' => $districts,
            'subdistricts' => $subdistricts,
            'organization' => $organizations,
        ]);
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

    /**
     * Update the partner's personal/company data.
     */
    public function updateProfile(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'partner_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone_number' => 'required|string|max:20',
            'postal_code' => 'required|string|max:10',
            'province_id' => 'required|exists:provinces,province_id',
            'district_id' => 'required|exists:districts,district_id,province_id,' . $request->province_id,
            'subdistrict_id' => 'required|exists:subdistricts,subdistrict_id,district_id,' . $request->district_id,
            'organization_id' => 'required|exists:organizations,organization_id',
        ]);

        try {
            $partner = Auth::user()->partnerProfile;

            $partner->update($validated);

            GlobalToastUtility::success('Profile updated successfully.');
        } catch (QueryException $e) {
            Log::error('Profile Update Error: ' . $e->getMessage());
            GlobalToastUtility::error('Failed to update profile. Please try again.');
        }

        return redirect()->back();
    }

    public function updatePhoto(Request $request)
    {
        try {
            /**
             * @var User
             */
            $user    = Auth::user();
            $profile = $user->profile;

            // Validate the request
            $request->validate([
                'cropped_data' => [
                    'required',
                    'string',
                    'regex:/^data:image\/jpeg;base64,/',
                    function ($attribute, $value, $fail) {
                        // Remove the "data:image/jpeg;base64," part
                        $base64_string = substr($value, strpos($value, ',') + 1);

                        // Check if it's a valid base64 string
                        if (! preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $base64_string)) {
                            $fail('Gambar tidak valid.');
                            return;
                        }

                        // Decode and check if it's a valid image
                        $image_data = base64_decode($base64_string);
                        if ($image_data === false) {
                            $fail('Gambar tidak valid.');
                            return;
                        }

                        // Check if it's really a JPEG image
                        $f         = finfo_open();
                        $mime_type = finfo_buffer($f, $image_data, FILEINFO_MIME_TYPE);
                        finfo_close($f);

                        if ($mime_type !== 'image/jpeg') {
                            $fail('Format gambar tidak valid.');
                            return;
                        }

                        // Check file size (max 2MB)
                        if (strlen($image_data) > 2 * 1024 * 1024) {
                            $fail('Ukuran gambar tidak boleh lebih dari 2MB.');
                            return;
                        }
                    },
                ],
            ], [
                'cropped_data.required' => 'Gambar profil wajib diunggah.',
                'cropped_data.regex'    => 'Format gambar tidak valid.',
                'cropped_data'          => 'Gambar tidak valid.',
            ]);

            // Get the base64 image data
            $image_data = $request->input('cropped_data');

            // Remove the "data:image/jpeg;base64," part
            $image_data = substr($image_data, strpos($image_data, ',') + 1);

            // Decode base64 data
            $image = base64_decode($image_data);
            $logoFile = $user->profile->logoFile;

            // Delete old photo if exists
            if ($logoFile) {
                try {
                    $fileReturn = FileStorageReturn::makeFromFileModel($logoFile);
                    Storage::disk('public')->delete($fileReturn->getPath());
                    $logoFile->delete();
                } catch (\Exception $e) {
                    // Log the error
                    dd($e);
                    Log::error('Profile photo delete error: ' . $e->getMessage());
                }
            }

            // Generate unique filename
            $filename  = 'profile-' . $user->user_id . '-' . time();
            $extension = '.jpg';
            $realPath  = 'profile-photos/' . $filename;

            // Save to storage
            $fileStorage = FileStorageUtility::storePublic($image, "profile-photos", $filename, $extension);

            // Update user's photo in database
            DB::beginTransaction();
            $file                    = new File();
            $file->path              = $fileStorage->getPathDb();
            $file->original_filename = $fileStorage->getFileName();
            $file->filename          = $fileStorage->getFileName();
            $file->extension         = $extension;
            $file->mime_type         = $fileStorage->getMimeType();
            $file->size              = $fileStorage->getSize();
            $file->fileable_id       = $profile->partner_profile_id;
            $file->fileable_type     = User::class;
            $file->uploaded_from     = "profile";
            $file->created_by        = $user->user_id;
            $file->save();
            $profile->file_photo_id = $file->file_id;
            $profile->save();

            DB::commit();

            GlobalToastUtility::success('Foto profil berhasil diunggah');

            return redirect()->back();
        } catch (\Exception $e) {
            // Log the error
            Log::error('Profile photo upload error: ' . $e->getMessage());
            GlobalToastUtility::error('Gagal mengupload foto profil');
            return redirect()->back();
        }
    }

    public function deletePhoto(Request $request)
    {
        try {
            $user = Auth::user();
            $profile = $user->profile;
            $logoFile = $profile->logoFile;

            // Delete old photo if exists
            if ($logoFile) {
                try {
                    $fileReturn = FileStorageReturn::makeFromFileModel($logoFile);
                    Storage::disk('public')->delete($fileReturn->getPath());
                    $logoFile->delete();
                } catch (\Exception $e) {
                    Log::error('Profile photo delete error: ' . $e->getMessage());
                    GlobalToastUtility::error('Gagal menghapus foto profil');
                    return redirect()->back();
                }
            }

            // Update user's profile in database
            $profile->file_photo_id = null;
            $profile->save();

            GlobalToastUtility::success('Foto profil berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Profile photo delete error: ' . $e->getMessage());
            GlobalToastUtility::error('Gagal menghapus foto profil');
        }

        return redirect()->back();
    }

    public function updateAboutCompany(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'about_company' => 'nullable|string|max:500'
        ]);

        try {
            $partner = Auth::user()->partnerProfile;

            $partner->update($validated);

            GlobalToastUtility::success('About Company updated successfully.');
        } catch (\Exception $e) {
            Log::error('About Company Update Error: ' . $e->getMessage());
            GlobalToastUtility::error('Failed to update About Company. Please try again.');
        }

        return redirect()->back();
    }

    /**
     * Update the partner's PIC (Person In Charge) information.
     */
    public function updatePIC(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'pic_name' => 'required|string|max:255',
            'pic_email' => 'required|email|max:255',
            'pic_phone_number' => 'required|string|max:20',
            'pic_position' => 'required|string|max:255',
        ]);

        try {
            $partner = Auth::user()->partnerProfile;

            $partner->update($validated);

            GlobalToastUtility::success('PIC information updated successfully.');
        } catch (QueryException $e) {
            Log::error('PIC Update Error: ' . $e->getMessage());
            GlobalToastUtility::error('Failed to update PIC information. Please try again.');
        }

        return redirect()->back();
    }

    public function updateWebsite(Request $request)
    {
        $validated = $request->validate([
            'website' => 'nullable|max:255'
        ]);

        try {
            $partner = Auth::user()->partnerProfile;

            $partner->update($validated);

            GlobalToastUtility::success('Website updated successfully.');
        } catch (QueryException $e) {
            Log::error('Website Update Error: ' . $e->getMessage());
            GlobalToastUtility::error('Failed to update Website. Please try again.');
        }

        return redirect()->back();
    }
}
