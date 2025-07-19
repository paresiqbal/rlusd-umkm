<?php
namespace App\Utility\FileStorage;

use App\Models\File as ModelsFile;
use App\Utility\FileStorage\FileStorageReturn;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileStorageUtility
{
    public static function getFile(ModelsFile $file)
    {
        $file = FileStorageReturn::makeFromFileModel($file);

        return $file->getFileContent();
    }

    /**
     * @inheritDoc
     */
    public static function storePublic($file, string $directory, ?string $filename = null, ?string $extension = null): FileStorageReturn
    {
        return self::storeFile($file, $directory, 'public', $filename, $extension);
    }

    /**
     * @inheritDoc
     */
    public static function storePrivate($file, string $directory, ?string $filename = null, ?string $extension = null): FileStorageReturn
    {
        return self::storeFile($file, $directory, 'local', $filename, $extension);
    }

    /**
     * Store file in specified disk
     *
     * @param string|File|UploadedFile $file file or base64 string
     * @param string $directoryPath directory path relative to storage.
     * @param string $disk 'public' or 'local'
     * @param string|null $filename filename
     * @param string|null $extension file extension, required when storing file with base64 string
     * @return FileStorageReturn
     */
    protected static function storeFile($file, string $directoryPath, string $disk, string $filename = null, ?string $extension = null): FileStorageReturn
    {
        // Clean directory path
        $directoryPath = trim($directoryPath, '/');

        // Generate filename
        if (! $filename) {
            $filename = time() . '-' . Str::random(16);
        }

        // Add extension if provided or get from file
        if ($extension) {
            $filename .= '.' . ltrim($extension, '.');
        } elseif (method_exists($file, 'getClientOriginalExtension')) {
            $filename .= '.' . $file->getClientOriginalExtension();
        } elseif (is_string($file) && strpos($file, 'data:image') === 0) {
            throw new \Exception('File extension is required when storing file with base64 string');
        }

        // Store the file
        if (is_string($file) && strpos($file, 'data:image') === 0) {
            // Handle base64 image
            $file = base64_decode(explode(',', $file)[1]);
        }

        // Generate paths
        $realPath = $directoryPath . '/' . $filename;
        $pathDb   = ($disk === 'public' ? 'public:' : 'local:') . $realPath;

        if ($disk === 'public') {
            Storage::disk($disk)->put($directoryPath . '/' . $filename, $file);
        } else {
            Storage::disk($disk)->putFileAs($directoryPath, $file, $filename);
        }

        return new FileStorageReturn($filename, $pathDb, $realPath, $disk);
    }
}
