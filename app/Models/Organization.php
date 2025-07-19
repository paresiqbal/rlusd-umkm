<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $primaryKey = "organization_id";

    public function organization()
    {
        return $this->hasMany(Organization::class, 'organization_id', 'organization_id');
    }
}
