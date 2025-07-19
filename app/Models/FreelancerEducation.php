<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreelancerEducation extends Model
{
    protected $table = 'freelancer_educations';
    protected $primaryKey = 'freelancer_educations_id';

    public function profile()
    {
        return $this->belongsTo(FreelancerProfile::class, 'freelancer_profile_id', 'freelancer_profile_id');
    }
}
