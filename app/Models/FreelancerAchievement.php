<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreelancerAchievement extends Model
{
    protected $table = 'freelancer_achievements';
    protected $primaryKey = 'freelancer_achievements_id';

    protected $fillable = [
        'achievement_title',
        'achievement_year',
        'additional_information',
        'freelancer_profile_id',
    ];

    public function profile()
    {
        return $this->belongsTo(FreelancerProfile::class, 'freelancer_profile_id', 'freelancer_profile_id');
    }
}
