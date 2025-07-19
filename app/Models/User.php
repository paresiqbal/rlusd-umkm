<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Traits\HasVerifyTokenEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasVerifyTokenEmail;
    protected $primaryKey = "user_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = [
        "role",
        // "profile",
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function profile()
    {
        $role = $this->role()->first();
        // dd($role);
        return match ($role->role_name) {
            "freelancer" => $this->hasOne(FreelancerProfile::class, "user_id", "user_id"),
            "partner" => $this->hasOne(PartnerProfile::class, "user_id", "user_id"),
            "admin" => $this->hasOne(AdminProfile::class, "user_id", "user_id"),
            default => null
        };
    }

    public function freelancerProfile()
    {
        return $this->hasOne(FreelancerProfile::class, "user_id", "user_id");
    }

    public function partnerProfile()
    {
        return $this->hasOne(PartnerProfile::class, "user_id", "user_id");
    }

    public function adminProfile()
    {
        return $this->hasOne(AdminProfile::class, "user_id", "user_id");
    }

    public function partnerPostJobs()
    {
        return $this->hasMany(PostJob::class, 'created_by', 'user_id');
    }

    public function generateUsername($fullName)
    {
        // Normalize the full name by converting to lowercase and removing unwanted characters
        $username = str($fullName)->slug('_');

        // Check if the username already exists in the database
        $originalUsername = $username;

        // Generate a random number between 1000 and 9999
        $randomNumber = rand(1, 999999);

        // Append the random number if the username exists
        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . '_' . $randomNumber;
            // Regenerate the random number if the combination already exists
            $randomNumber = rand(1, 999999);
        }

        $this->username = $username;
    }
}
