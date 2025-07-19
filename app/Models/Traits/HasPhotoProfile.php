<?php

namespace App\Models\Traits;

use App\Models\File;

trait HasPhotoProfile
{
    public function photoProfile()
    {
        return $this->belongsTo(File::class, 'file_photo_id', 'file_id');
    }
}
