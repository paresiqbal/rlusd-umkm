<?php
namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;

trait HasVerifyTokenEmail
{
    public function generateTokenEmail()
    {
        $key = $this->getKey();
        $token = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        Cache::set($key, $token, 60 * 30); // 30 minutes
        return $token;
    }

    public function getTokenEmail(): string
    {
        $key = $this->getKey();
        return Cache::get($key);
    }

    public function removeTokenEmail(): bool
    {
        $key = $this->getKey();
        return Cache::forget($key);
    }

    public function verifyTokenEmail(string $token): bool
    {
        $key = $this->getKey();
        return Cache::get($key) == $token;
    }

    public function getKey(): string
    {
        $prefix = config("cache-prefix.email-token", "EP-");
        $key = "{$prefix}{$this->user_id}";
        return $key;
    }

    // abstract public function emailVerifyKey(): string;
}
