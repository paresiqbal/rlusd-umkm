<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostJob extends Model
{
    use HasFactory;

    protected $table = 'post_jobs';
    protected $primaryKey = 'post_job_id';

    protected $fillable = [
        'role',
        'number_sdm',
        'job_desc',
        'min_education_id',
        'employment_type_id',
        'job_type_id',
        'province_id',
        'district_id',
        'subdistrict_id',
        'min_salary',
        'max_salary',
        'created_by',
        'qualifications',
        'status',
        'country_id',
        'address',
        'job_category_id',
        'approved_at',
        'approved_by',
        'is_hidden_salary',
        'genders',
        'closed_post_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function employmentType()
    {
        return $this->belongsTo(EmploymentType::class, 'employment_type_id', 'employment_type_id');
    }

    public function jobType()
    {
        return $this->belongsTo(JobType::class, 'job_type_id', 'job_type_id');
    }

    public function education()
    {
        return $this->belongsTo(Education::class, 'min_education_id', 'education_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }

    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class, 'subdistrict_id', 'subdistrict_id');
    }

    public function skills()
    {
        return $this->belongsToMany(
            Skill::class,
            'post_jobs_skills',
            'post_job_id',
            'skill_id'
        )->withTimestamps();
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'post_job_id');
    }

    // Many-to-many relationship with ServiceType
    public function serviceTypes()
    {
        return $this->belongsToMany(
            ServiceType::class,
            'post_job_service_type',
            'post_job_id',
            'service_type_id'
        )->withTimestamps();
    }
}
