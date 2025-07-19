<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $primaryKey = 'application_id';

    protected $fillable = [
        'application_id',
        'post_job_id',
        'applicant_id',
        'status',
        'note',
    ];

    public function job()
    {
        return $this->belongsTo(PostJob::class, 'post_job_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'applicant_id', 'user_id');
    }
}
