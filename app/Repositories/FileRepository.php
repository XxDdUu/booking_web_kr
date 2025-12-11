<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
class FileRepository
{
    protected string $disk;

    public function __construct()
    {
        $this->disk = config('filesystems.default');
    }
    public function store($file, string $folder): string
    {

        $originalName = method_exists($file, 'getClientOriginalName')
            ? $file->getClientOriginalName()
            : ($file->originalName ?? 'file');

        // Tạo tên file an toàn
        $ext = $file->getClientOriginalExtension();
        $filename = time() . '_' . uniqid() . '.' . $ext;

        $path = rtrim($folder, '/') . '/' . $filename;

        Storage::disk($this->disk)->put(
            $path,
            file_get_contents($file)
        );
        
        return $path;
    }


    public function delete(?string $path)
    {
        if (!$path) return;

        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }

    public function get($path)
    {
        return Storage::get($path);
    }

    public function mime($path)
    {
        return Storage::mimeType($path) ?? 'application/octet-stream';
    }

    public function exists($path)
    {
        return Storage::exists($path);
    }
}
