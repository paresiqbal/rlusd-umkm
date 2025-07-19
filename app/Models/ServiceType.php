<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory;

    protected $table = 'service_types';
    protected $primaryKey = 'service_type_id';

    // If your table uses 'service_type_name' as a column for the name,
    // you might want to include it in the fillable array.
    protected $fillable = [
        'service_type_name',
    ];
}
