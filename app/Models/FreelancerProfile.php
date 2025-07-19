<?php

namespace App\Models;

use App\Models\Traits\HasPhotoProfile;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;

class FreelancerProfile extends Model
{
    use HasPhotoProfile;

    protected $primaryKey = "freelancer_profile_id";
    protected $fillable = ['name', 'birthdate', 'birthplace', 'phone_number', 'gender', 'country_id', 'province_id', 'district_id',  'subdistrict_id', 'postal_code', 'address', 'about_me', 'rating', 'file_photo_id', 'file_cv_id', 'file_skkni_id', 'file_skkk_id', 'status', 'main_skill', 'approved_at', 'approved_by'];

    public function experiences()
    {
        return $this->hasMany(FreelancerExperience::class, 'freelancer_profile_id', 'freelancer_profile_id');
    }

    public function educations()
    {
        return $this->hasMany(FreelancerEducation::class, 'freelancer_profile_id', 'freelancer_profile_id');
    }

    public function achievements()
    {
        return $this->hasMany(FreelancerAchievement::class, 'freelancer_profile_id', 'freelancer_profile_id');
    }

    public function skills()
    {
        return $this->belongsToMany(
            Skill::class,
            'freelancer_profile_skills',
            'freelancer_profile_id',
            'skill_id',
            'freelancer_profile_id',
            'skill_id'
        )->withTimestamps();
    }

    public function photoFile()
    {
        return $this->belongsTo(File::class, 'file_photo_id', 'file_id');
    }

    public function fileCV()
    {
        return $this->belongsTo(File::class, 'file_cv_id', 'file_id');
    }

    public function fileSKKNI()
    {
        return $this->belongsTo(File::class, 'file_skkni_id', 'file_id');
    }

    public function fileSKKK()
    {
        return $this->belongsTo(File::class, 'file_skkk_id', 'file_id');
    }

    public function applyJob()
    {
        return $this->hasMany(Application::class, 'applicant_id', 'freelancer_profile_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }
}
