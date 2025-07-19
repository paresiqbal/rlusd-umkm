<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreelancerExperience extends Model
{
    protected $table = 'freelancer_experiences';
    protected $primaryKey = 'freelancer_experience_id';

    public function profile()
    {
        return $this->belongsTo(FreelancerProfile::class, 'freelancer_profile_id', 'freelancer_profile_id');
    }

}
