<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $primaryKey = 'file_id';

    protected $appends = ['public_url'];

    public function publicUrl(): Attribute
    {
        return Attribute::make(get: function ($value, $attributes) {
            if (str_contains($attributes['path'], 'public:')) {
                $path = str_replace('public:', '', $attributes['path']);
                return url('storage/' . $path);
            }
            return null;
        });
    }
}
