<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmploymentType extends Model
{
    protected $primaryKey = "employment_type_id";

    public function postJobs()
    {
        return $this->hasMany(PostJob::class, 'employment_type_id', 'employment_type_id');
    }
}
