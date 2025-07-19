<?php

namespace App\Facades;

use App\Services\FileStorageService;
use Illuminate\Support\Facades\Facade;

class FileStorage extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return FileStorageService::class;
    }
}
