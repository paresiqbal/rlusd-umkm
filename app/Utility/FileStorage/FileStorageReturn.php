<?php
namespace App\Utility\FileStorage;

use App\Models\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Override;

class FileStorageReturn
{
    private string $pathDb;
    private string $fileName;
    private string $path;
    private int $size;
    private string $disk;
    private string $mime_type;
    private string $extension;
    private Carbon $created_at;

    public static function makeFromFileModel(File $file): self
    {
        $filenameWithoutExtension = substr($file->filename, 0, strrpos($file->filename, '.'));
        $path = "";
        $disk = "";
        ;
        if (str_contains($file->path, 'public:')) {
            $path = str_replace('public:', '', $file->path);
            $disk = 'public';
        } else {
            $path = str_replace('local:', '', $file->path);
            $disk = 'local';
        }
        return new self($filenameWithoutExtension, $file->path, $path, $disk);
    }

    public function __construct(string $fileName, string $pathDb, string $path, string $disk)
    {
        $this->pathDb = $pathDb;
        $this->fileName = $fileName;
        $this->path = $path;
        $this->disk = $disk;
        // dd($this, Storage::disk($disk)->path($this->path), Storage::disk($disk)->exists($this->path));
        $file = new \SplFileObject($disk == 'public' ? Storage::disk('public')->path($path) : Storage::disk('local')->path($this->path));
        $this->size = $file->getSize();
        $this->mime_type = mime_content_type($file->getRealPath());
        $this->extension = $file->getExtension();
        $this->created_at = Carbon::now();
    }

    public function getPathDb(): string
    {
        return $this->pathDb;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getDisk(): string
    {
        return $this->disk;
    }

    public function getMimeType(): string
    {
        return $this->mime_type;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    /**
     * Get real path of file (Path attribute structure is like local:file_path or public:file_path so we need to remove the prefix)
     * @return string
     */
    public function getRealPath()
    {
        if ($this->disk == 'public') {
            $path = str_replace('public:', '', $this->path);
            return Storage::disk('public')->path($path);
        }
        $path = str_replace('local:', '', $this->path);
        return Storage::disk('local')->path($path);
    }

    public function getFileContent(): string
    {
        return file_get_contents($this->getRealPath());
    }
}
