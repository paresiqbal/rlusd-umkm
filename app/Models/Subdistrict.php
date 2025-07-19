<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    protected $primaryKey = 'subdistrict_id';

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }
}
