<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\District;
use App\Models\File;
use App\Models\FreelancerAchievement;
use App\Models\FreelancerEducation;
use App\Models\FreelancerExperience;
use App\Models\FreelancerProfile;
use App\Models\Province;
use App\Models\Skill;
use App\Models\Subdistrict;
use App\Models\User;
use App\Utility\FileStorage\FileStorageReturn;
use App\Utility\FileStorage\FileStorageUtility;
use App\Utility\GlobalToastUtility;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    private $filePath = "cv";

    public function show()
    {
        $user_id    = Auth::user()->user_id;
        $user       = User::find($user_id);
        $user->age  = Carbon::parse($user->profile->birthdate)->age;
        $main_skill = $user->profile->main_skill;
        $applications = Application::where('applicant_id', $user_id)->get();

        $provinces = Province::all();

        $districts = $user->province_id
            ? District::where('province_id', $user->province_id)->get()
            : collect();

        $subdistricts = $user->district_id
            ? Subdistrict::where('district_id', $user->district_id)->get()
            : collect();

        $data = [
            'user'             => $user,
            'userPhotoProfile' => $user->profile?->photoProfile?->publicUrl,
            'provinces'        => $provinces,
            'districts'        => $districts,
            'subdistricts'     => $subdistricts,
            'main_skill'       => $main_skill,
            'applications'     => $applications,
        ];

        return view('user.profiles.show', $data);
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

    public function updatePersonalData(Request $request)
    {
        $profile = $request->validate([
            'name'           => 'required|max:50',
            'birthdate'      => 'required|date',
            'gender'         => 'required',
            'address'        => 'required|max:250',
            'province_id'    => 'required|exists:provinces,province_id',
            'district_id'    => 'required|exists:districts,district_id,province_id,' . $request->province_id,
            'subdistrict_id' => 'required|exists:subdistricts,subdistrict_id,district_id,' . $request->district_id,
            'postal_code'    => 'required',
            'phone_number'   => 'required',
        ]);
        $profile_id = $request->post('profile_id');

        $model = FreelancerProfile::find($profile_id);

        $model->name           = $profile['name'];
        $model->birthdate      = $profile['birthdate'];
        $model->gender         = $profile['gender'];
        $model->address        = $profile['address'];
        $model->province_id    = $profile['province_id'];
        $model->district_id    = $profile['district_id'];
        $model->subdistrict_id = $profile['subdistrict_id'];
        $model->postal_code    = $profile['postal_code'];
        $model->phone_number   = $profile['phone_number'];

        try {

            $model->saveOrFail();

            GlobalToastUtility::success('Update berhasil');
        } catch (\Exception $e) {
            GlobalToastUtility::error('Update gagal. Silahkan mencoba beberapa saat lagi');
        }

        return redirect()->back();
    }

    public function updateAboutMe(Request $request)
    {
        $about_me = $request->validate([
            'about_me' => 'nullable|string|max:500',
        ]);

        $profile_id      = $request->post('profile_id');
        $model           = FreelancerProfile::find($profile_id);
        $model->about_me = $about_me['about_me'];

        try {
            $model->saveOrFail();

            GlobalToastUtility::success('Update berhasil');
        } catch (\Exception $e) {
            GlobalToastUtility::error('Update gagal. Silahkan mencoba beberapa saat lagi');
        }

        return redirect()->back();
    }

    public function storeWorkExperience(Request $request)
    {
        $work_experience = $request->validate([
            'job_title'             => 'required|string|max:50',
            'company_name'          => 'required|string|max:50',
            'employment_type'       => 'required',
            'job_desc'              => 'nullable|string|max:500',
            'project_link'          => 'nullable|string|max:100',
            'city'                  => 'required|string|max:50',
            'start_at'              => 'required|date',
            'end_at'                => 'nullable|date|after_or_equal:start_at',
            'currently_working'     => 'nullable|boolean',
            'freelancer_profile_id' => 'required',
        ]);

        $model = new FreelancerExperience;

        $model->job_title             = $work_experience['job_title'];
        $model->company_name          = $work_experience['company_name'];
        $model->employment_type       = $work_experience['employment_type'];
        $model->job_desc              = $work_experience['job_desc'];
        $model->project_link          = $work_experience['project_link'];
        $model->city                  = $work_experience['city'];
        $model->start_at              = $work_experience['start_at'];
        $model->freelancer_profile_id = $work_experience['freelancer_profile_id'];

        if (isset($work_experience['currently_working']) && $work_experience['currently_working']) {
            $model->end_at = null;
        } else {
            $model->end_at = $work_experience['end_at'];
        }

        try {
            $model->saveOrFail();
            GlobalToastUtility::success('Riwayat pekerjaan berhasil disimpan');
        } catch (QueryException $e) {
            GlobalToastUtility::error('Terjadi kesalahan. ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function updateWorkExperience(Request $request)
    {
        $work_experience = $request->validate([
            'job_title'             => 'required|max:50|string',
            'company_name'          => 'required|max:50|string',
            'employment_type'       => 'required',
            'job_desc'              => 'nullable|max:500',
            'project_link'          => 'nullable|max:100',
            'city'                  => 'required|max:50',
            'start_at'              => 'required|date',
            'end_at'                => 'nullable|date',
            'freelancer_profile_id' => 'required',
        ]);
        try {
            $model = FreelancerExperience::findOrFail($request->post('freelancer_experience_id'));

            $model->job_title       = $work_experience['job_title'];
            $model->company_name    = $work_experience['company_name'];
            $model->employment_type = $work_experience['employment_type'];
            $model->job_desc        = $work_experience['job_desc'];
            $model->project_link    = $work_experience['project_link'];
            $model->city            = $work_experience['city'];
            $model->start_at        = $work_experience['start_at'];
            $model->end_at          = $work_experience['end_at'];

            $model->saveOrFail();
            GlobalToastUtility::success('Riwayat pekerjaan berhasil disimpan');
        } catch (\Exception $e) {
            GlobalToastUtility::error('Terjadi kesalahan. ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function deleteWorkExperience($id)
    {
        try {
            DB::beginTransaction();

            FreelancerExperience::destroy($id);

            DB::table('freelancer_experiences_skills')
                ->where('freelancer_experience_id', '=', $id)
                ->delete();

            DB::commit();

            GlobalToastUtility::success('Data berhasil dihapus');
        } catch (\Exception $e) {
            GlobalToastUtility::error('Terjadi kesalahan');
        }

        return redirect()->back()->withFragment('user-profile-work-experience-edit');
    }

    public function storeEducation(Request $request)
    {
        $education = $request->validate([
            'school_name'           => 'required|max:100|string',
            'major'                 => 'nullable|max:50|string',
            'has_graduated'         => 'nullable',
            'education_desc'        => 'nullable|max:500',
            'graduate_year'         => 'nullable',
            'freelancer_profile_id' => 'required',
        ]);

        $model = new FreelancerEducation;

        $model->school_name           = $education['school_name'];
        $model->major                 = $education['major'];
        $model->education_desc        = $education['education_desc'];
        $model->graduate_year         = $education['graduate_year'];
        $model->freelancer_profile_id = $education['freelancer_profile_id'];

        try {
            $model->saveOrFail();
            GlobalToastUtility::success('Pendidikan berhasil disimpan');
        } catch (QueryException $e) {
            GlobalToastUtility::error('Terjadi kesalahan. ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function updateEducation(Request $request)
    {
        $education = $request->validate([
            'school_name'           => 'required|max:100|string',
            'major'                 => 'nullable|max:50|string',
            'education_desc'        => 'nullable|max:500',
            'graduate_year'         => 'nullable',
            'freelancer_profile_id' => 'required',
        ]);

        try {
            $model = FreelancerEducation::findOrFail($request->post('freelancer_educations_id'));

            $model->school_name    = $education['school_name'];
            $model->major          = $education['major'];
            $model->education_desc = $education['education_desc'];
            $model->graduate_year  = $education['graduate_year'];

            $model->saveOrFail();
            GlobalToastUtility::success('Pendidikan berhasil disimpan');
        } catch (\Exception $e) {
            GlobalToastUtility::error('Terjadi kesalahan. ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function deleteEducation($id)
    {
        try {

            FreelancerEducation::destroy($id);

            GlobalToastUtility::success('Data berhasil dihapus');
        } catch (\Exception $e) {
            GlobalToastUtility::error('Terjadi kesalahan');
        }

        return redirect()->back()->withFragment('user-profile-education-edit');
    }

    public function storeAchievement(Request $request)
    {
        $achievement = $request->validate([
            'achievement_title'      => 'required|max:100|string',
            'additional_information' => 'nullable|max:500',
            'achievement_year'       => 'nullable',
            'freelancer_profile_id'  => 'required',
        ]);

        $model = new FreelancerAchievement();

        $model->achievement_title      = $achievement['achievement_title'];
        $model->additional_information = $achievement['additional_information'];
        $model->achievement_year       = $achievement['achievement_year'];
        $model->freelancer_profile_id  = $achievement['freelancer_profile_id'];

        try {
            $model->saveOrFail();
            GlobalToastUtility::success('Prestasi berhasil disimpan');
        } catch (QueryException $e) {
            GlobalToastUtility::error('Terjadi kesalahan. ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function updateAchievement(Request $request)
    {
        $achievement = $request->validate([
            'achievement_title'      => 'required|max:100|string',
            'additional_information' => 'nullable|max:500',
            'achievement_year'       => 'nullable',
            'freelancer_profile_id'  => 'required',
        ]);

        try {
            $model = FreelancerAchievement::findOrFail($request->post('freelancer_achievements_id'));

            $model->achievement_title      = $achievement['achievement_title'];
            $model->additional_information = $achievement['additional_information'];
            $model->achievement_year       = $achievement['achievement_year'];
            $model->freelancer_profile_id  = $achievement['freelancer_profile_id'];

            $model->saveOrFail();
            GlobalToastUtility::success('Prestasi berhasil disimpan');
        } catch (\Exception $e) {
            GlobalToastUtility::error('Terjadi kesalahan. ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function deleteAchievement($id)
    {
        try {
            FreelancerAchievement::destroy($id);
            GlobalToastUtility::success('Prestasi berhasil dihapus');
        } catch (\Exception $e) {
            GlobalToastUtility::error('Terjadi kesalahan');
        }

        return redirect()->back()->withFragment('user-profile-achievement-edit');
    }


    public function storeSkill(Request $request)
    {
        $data = $request->validate([
            'skills'     => 'nullable|array',
            'skills.*'   => 'nullable',
            'main_skill'     => 'required|array',
            'main_skill.*'   => 'in:pendamping,konsultan',
        ]);

        $skills     = $data['skills'] ?? [];
        $main_skill = $data['main_skill'];
        $user       = Auth::user();
        $profile_id = $user->profile->freelancer_profile_id;

        // split array into new_skills and existing_skills
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

            $model = FreelancerProfile::findOrFail($profile_id);
            $model->skills()->sync($existing_skills);
            $model->main_skill = $main_skill;
            $model->save();
            GlobalToastUtility::success('Keahlian berhasil disimpan');
        } catch (\Exception $e) {
            GlobalToastUtility::error('Terjadi kesalahan');
        }

        return redirect()->back();
    }

    public function deleteSkill($skill_id)
    {
        $user       = Auth::user();
        $profile_id = $user->profile->freelancer_profile_id;

        try {
            $model = FreelancerProfile::findOrFail($profile_id);
            if ($model->skills->contains($skill_id)) {
                $model->skills()->detach($skill_id);
            }
            GlobalToastUtility::success('Keahlian berhasil disimpan');
        } catch (\Exception $e) {
            GlobalToastUtility::error('Terjadi kesalahan');
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

                        // Check file size (max 3MB)
                        if (strlen($image_data) > 2 * 1024 * 1024) {
                            $fail('Ukuran gambar tidak boleh lebih dari 3MB.');
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

            $photoProfile = $user->profile->photoProfile;

            // Delete old photo if exists
            if ($photoProfile) {
                try {
                    $fileReturn = FileStorageReturn::makeFromFileModel($photoProfile);
                    Storage::disk('public')->delete($fileReturn->getPath());
                    $photoProfile->delete();
                } catch (\Exception $e) {
                    // Log the error
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
            $file->fileable_id       = $profile->freelancer_profile_id;
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

    public function deletePhoto()
    {
        try {
            $user = Auth::user();
            $profile = $user->profile;
            if (! $profile || ! $profile->photoProfile) {
                GlobalToastUtility::error('Anda belum mengunggah foto profil');
                return redirect()->back();
            }
            $photo = $profile->photoProfile;
            $fileReturn = FileStorageReturn::makeFromFileModel($photo);
            Storage::disk('public')->delete($fileReturn->getPath());
            $photo->delete();
            $profile->file_photo_id = null;
            $profile->save();

            GlobalToastUtility::success('Foto profil berhasil dihapus');
        } catch (\Exception $e) {
            GlobalToastUtility::error('Terjadi kesalahan saat menghapus foto profil');
        }
        return redirect()->back();
    }

    public function showCV(Request $request)
    {
        /**
         * @var User
         */
        $user    = Auth::user();
        $profile = $user->profile;

        $freelancerFileCV = $profile->fileCV;

        if (empty($freelancerFileCV)) {
            abort(404);
        }
        // dd($freelancerFileCV);
        $fileContent = FileStorageUtility::getFile($freelancerFileCV);

        $response = response($fileContent)
            ->header('Content-Type', $freelancerFileCV->mime_type)
            ->header('Content-Disposition', 'inline; filename="' . $freelancerFileCV->filename . '"');

        // If browser can't preview, it will download automatically
        return $response;
    }

    public function updateCV(Request $request)
    {
        try {
            $request->validate([
                'cv_file' => 'required|file|mimetypes:application/pdf|max:3072', // max 3MB (3072 KB)
            ]);

            $user              = Auth::user();
            $freelancerProfile = FreelancerProfile::where('user_id', $user->user_id)->first();

            if ($request->hasFile('cv_file')) {
                // Delete old CV if exists
                // dd($freelancerProfile, $user->user_id);
                $freelancerFileCV = $freelancerProfile->fileCV;

                if ($freelancerFileCV) {
                    try {
                        $fileReturn = FileStorageReturn::makeFromFileModel($freelancerFileCV);
                        Storage::disk('local')->delete($fileReturn->getPath());
                    } catch (\Exception $e) {
                        // Log the error
                        Log::error('CV file delete error: ' . $e->getMessage());
                    }
                } else {
                    $freelancerFileCV = new File();
                }

                // Store new CV
                $file     = $request->file('cv_file');
                $fileName = time() . '_' . Str::random(16) . '_cv';

                $fileStored = FileStorageUtility::storePrivate($file, $this->filePath, $fileName, $extension = 'pdf');
                // Update database
                $freelancerFileCV->filename          = $fileName;
                $freelancerFileCV->original_filename = $fileName;
                $freelancerFileCV->path              = $fileStored->getPathDb();
                $freelancerFileCV->extension         = "pdf";
                $freelancerFileCV->mime_type         = $fileStored->getMimeType();
                $freelancerFileCV->size              = $fileStored->getSize();
                $freelancerFileCV->fileable_id       = $freelancerProfile->freelancer_profile_id;
                $freelancerFileCV->fileable_type     = FreelancerProfile::class;
                $freelancerFileCV->uploaded_from     = "Profile";
                $freelancerFileCV->created_by        = $user->id;
                $freelancerFileCV->save();

                // Update freelancer profile
                $freelancerProfile->file_cv_id = $freelancerFileCV->file_id;
                $freelancerProfile->save();

                GlobalToastUtility::success('CV berhasil diupload');
                return redirect()->back();
            }
            GlobalToastUtility::error("Tidak ada file yang diupload");

            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
            GlobalToastUtility::error('Terjadi kesalahan, silahkan coba lagi');
            return redirect()->back();
        }
    }

    public function deleteCV()
    {
        try {
            $user    = Auth::user();
            $profile = FreelancerProfile::where('user_id', $user->user_id)->first();

            if (! $profile || ! $profile->file_cv_id) {
                GlobalToastUtility::error('Anda belum mengunggah CV');
                return redirect()->back();
            }

            // Get the file record
            /**
             * @var File
             */
            $file = File::find($profile->file_cv_id);

            if ($file) {
                // Delete the file from storage
                $fileReturn = FileStorageReturn::makeFromFileModel($file);
                Storage::disk('local')->delete($fileReturn->getPath());
                $file->delete();
            }

            // Update the profile to remove the CV reference
            $profile->file_cv_id = null;
            $profile->save();

            GlobalToastUtility::success('CV berhasil dihapus');
            return redirect()->back();
        } catch (\Exception $e) {
            GlobalToastUtility::error('Terjadi kesalahan, silahkan coba lagi');
            return redirect()->back();
        }
    }

    public function showSKKNI(Request $request)
    {
        /**
         * @var User
         */
        $user    = Auth::user();
        $profile = $user->profile;

        $freelancerFileSKKNI = $profile->fileSKKNI;

        if (empty($freelancerFileSKKNI)) {
            abort(404);
        }
        // dd($freelancerFileSKKNI);
        $fileContent = FileStorageUtility::getFile($freelancerFileSKKNI);

        $response = response($fileContent)
            ->header('Content-Type', $freelancerFileSKKNI->mime_type)
            ->header('Content-Disposition', 'inline; filename="' . $freelancerFileSKKNI->filename . '"');

        // If browser can't preview, it will download automatically
        return $response;
    }

    public function updateSKKNI(Request $request)
    {
        try {
            $request->validate([
                'skkni_file' => 'required|file|mimetypes:application/pdf|max:3072', // max 3MB (3072 KB)
            ]);

            $user              = Auth::user();
            $freelancerProfile = FreelancerProfile::where('user_id', $user->user_id)->first();

            if ($request->hasFile('skkni_file')) {
                // Delete old SKKNI if exists
                // dd($freelancerProfile, $user->user_id);
                $freelancerFileSKKNI = $freelancerProfile->fileSKKNI;

                if ($freelancerFileSKKNI) {
                    try {
                        $fileReturn = FileStorageReturn::makeFromFileModel($freelancerFileSKKNI);
                        Storage::disk('local')->delete($fileReturn->getPath());
                    } catch (\Exception $e) {
                        // Log the error
                        Log::error('SKKNI file delete error: ' . $e->getMessage());
                    }
                } else {
                    $freelancerFileSKKNI = new File();
                }

                // Store new SKKNI
                $file     = $request->file('skkni_file');
                $fileName = time() . '_' . Str::random(16) . '_skkni';

                $fileStored = FileStorageUtility::storePrivate($file, $this->filePath, $fileName, $extension = 'pdf');
                // Update database
                $freelancerFileSKKNI->filename          = $fileName;
                $freelancerFileSKKNI->original_filename = $fileName;
                $freelancerFileSKKNI->path              = $fileStored->getPathDb();
                $freelancerFileSKKNI->extension         = "pdf";
                $freelancerFileSKKNI->mime_type         = $fileStored->getMimeType();
                $freelancerFileSKKNI->size              = $fileStored->getSize();
                $freelancerFileSKKNI->fileable_id       = $freelancerProfile->freelancer_profile_id;
                $freelancerFileSKKNI->fileable_type     = FreelancerProfile::class;
                $freelancerFileSKKNI->uploaded_from     = "Profile";
                $freelancerFileSKKNI->created_by        = $user->id;
                $freelancerFileSKKNI->save();

                // Update freelancer profile
                $freelancerProfile->file_skkni_id = $freelancerFileSKKNI->file_id;
                $freelancerProfile->save();

                GlobalToastUtility::success('SKKNI berhasil diupload');
                return redirect()->back();
            }
            GlobalToastUtility::error("Tidak ada file yang diupload");

            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
            GlobalToastUtility::error('Terjadi kesalahan, silahkan coba lagi');
            return redirect()->back();
        }
    }

    public function deleteSKKNI()
    {
        try {
            $user    = Auth::user();
            $profile = FreelancerProfile::where('user_id', $user->user_id)->first();

            if (! $profile || ! $profile->file_skkni_id) {
                GlobalToastUtility::error('Anda belum mengunggah SKKNI');
                return redirect()->back();
            }

            // Get the file record
            /**
             * @var File
             */
            $file = File::find($profile->file_skkni_id);

            if ($file) {
                // Delete the file from storage
                $fileReturn = FileStorageReturn::makeFromFileModel($file);
                Storage::disk('local')->delete($fileReturn->getPath());
                $file->delete();
            }

            // Update the profile to remove the SKKNI reference
            $profile->file_skkni_id = null;
            $profile->save();

            GlobalToastUtility::success('SKKNI berhasil dihapus');
            return redirect()->back();
        } catch (\Exception $e) {
            GlobalToastUtility::error('Terjadi kesalahan, silahkan coba lagi');
            return redirect()->back();
        }
    }

    public function showSKKK(Request $request)
    {
        /**
         * @var User
         */
        $user    = Auth::user();
        $profile = $user->profile;

        $freelancerFileSKKK = $profile->fileSKKK;

        if (empty($freelancerFileSKKK)) {
            abort(404);
        }
        // dd($freelancerFileSKKK);
        $fileContent = FileStorageUtility::getFile($freelancerFileSKKK);

        $response = response($fileContent)
            ->header('Content-Type', $freelancerFileSKKK->mime_type)
            ->header('Content-Disposition', 'inline; filename="' . $freelancerFileSKKK->filename . '"');

        // If browser can't preview, it will download automatically
        return $response;
    }

    public function updateSKKK(Request $request)
    {
        try {
            $request->validate([
                'skkk_file' => 'required|file|mimetypes:application/pdf|max:3072', // max 3MB (3072 KB)
            ]);

            $user              = Auth::user();
            $freelancerProfile = FreelancerProfile::where('user_id', $user->user_id)->first();

            if ($request->hasFile('skkk_file')) {
                // Delete old SKKK if exists
                // dd($freelancerProfile, $user->user_id);
                $freelancerFileSKKK = $freelancerProfile->fileSKKK;

                if ($freelancerFileSKKK) {
                    try {
                        $fileReturn = FileStorageReturn::makeFromFileModel($freelancerFileSKKK);
                        Storage::disk('local')->delete($fileReturn->getPath());
                    } catch (\Exception $e) {
                        // Log the error
                        Log::error('SKKK file delete error: ' . $e->getMessage());
                    }
                } else {
                    $freelancerFileSKKK = new File();
                }

                // Store new SKKK
                $file     = $request->file('skkk_file');
                $fileName = time() . '_' . Str::random(16) . '_skkk';

                $fileStored = FileStorageUtility::storePrivate($file, $this->filePath, $fileName, $extension = 'pdf');
                // Update database
                $freelancerFileSKKK->filename          = $fileName;
                $freelancerFileSKKK->original_filename = $fileName;
                $freelancerFileSKKK->path              = $fileStored->getPathDb();
                $freelancerFileSKKK->extension         = "pdf";
                $freelancerFileSKKK->mime_type         = $fileStored->getMimeType();
                $freelancerFileSKKK->size              = $fileStored->getSize();
                $freelancerFileSKKK->fileable_id       = $freelancerProfile->freelancer_profile_id;
                $freelancerFileSKKK->fileable_type     = FreelancerProfile::class;
                $freelancerFileSKKK->uploaded_from     = "Profile";
                $freelancerFileSKKK->created_by        = $user->id;
                $freelancerFileSKKK->save();

                // Update freelancer profile
                $freelancerProfile->file_skkk_id = $freelancerFileSKKK->file_id;
                $freelancerProfile->save();

                GlobalToastUtility::success('SKKK berhasil diupload');
                return redirect()->back();
            }
            GlobalToastUtility::error("Tidak ada file yang diupload");

            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
            GlobalToastUtility::error('Terjadi kesalahan, silahkan coba lagi');
            return redirect()->back();
        }
    }

    public function deleteSKKK()
    {
        try {
            $user    = Auth::user();
            $profile = FreelancerProfile::where('user_id', $user->user_id)->first();

            if (! $profile || ! $profile->file_skkk_id) {
                GlobalToastUtility::error('Anda belum mengunggah SKKK');
                return redirect()->back();
            }

            // Get the file record
            /**
             * @var File
             */
            $file = File::find($profile->file_skkk_id);

            if ($file) {
                // Delete the file from storage
                $fileReturn = FileStorageReturn::makeFromFileModel($file);
                Storage::disk('local')->delete($fileReturn->getPath());
                $file->delete();
            }

            // Update the profile to remove the SKKK reference
            $profile->file_skkk_id = null;
            $profile->save();

            GlobalToastUtility::success('SKKK berhasil dihapus');
            return redirect()->back();
        } catch (\Exception $e) {
            GlobalToastUtility::error('Terjadi kesalahan, silahkan coba lagi');
            return redirect()->back();
        }
    }

    public function showApplications(Request $request)
    {
        $applicant_id = Auth::user()->user_id;

        $query = Application::where('applicant_id', $applicant_id)
            ->with(['user.freelancerProfile', 'job.user.partnerProfile', 'job.user.partnerProfile.photoProfile']);

        if ($request->has('status')) {
            $status = $request->query('status');
            if ($status !== 'all') {
                $query->where('status', $status);
            }
        }

        $applications = $query->paginate(10);

        return view('user.profiles._components.personal-data', compact('applications'));
    }
}
