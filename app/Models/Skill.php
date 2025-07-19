<?php

namespace App\Models;

use App\Services\Lightcast\SkillCollection;
use Illuminate\Database\Eloquent\Attributes\CollectedBy;
use Illuminate\Database\Eloquent\Model;

#[CollectedBy(SkillCollection::class)]
class Skill extends Model
{
    protected $table = 'skills';
    protected $primaryKey = 'skill_id';

    public function freelancer_profiles()
    {
        return $this->belongsToMany(
            FreelancerProfile::class,
            'freelancer_profile_skills',
            'skill_id',
            'freelancer_profile_id',
            'skill_id',
            'freelancer_profile_id'
        )->withTimestamps();
    }
}
