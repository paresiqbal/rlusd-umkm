<?php

namespace App\Models;

use App\Models\Traits\HasPhotoProfile;
use Illuminate\Database\Eloquent\Model;

class PartnerProfile extends Model
{
    use HasPhotoProfile;

    protected $primaryKey = "partner_profile_id";

    protected $fillable = [
        'user_id',
        'partner_name',
        'email',
        'address',
        'phone_number',
        'postal_code',
        'province_id',
        'district_id',
        'subdistrict_id',
        'organization_id',
        'about_company',
        'file_photo_id',
        'pic_name',
        'pic_email',
        'pic_phone_number',
        'pic_position',
        'website',
    ];

    /**
     * Relationship with Province.
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }

    /**
     * Relationship with District.
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }

    /**
     * Relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relationship with the logo file.
     */
    public function logoFile()
    {
        return $this->belongsTo(File::class, 'file_photo_id', 'file_id');
    }

    /**
     * Relationship with the organization.
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'organization_id');
    }
}
