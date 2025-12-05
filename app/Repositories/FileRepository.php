<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
class FileRepository
{
    public function store($file, string $folder): string
    {
        
        $disk = config('filesystems.default');

        // Tạo tên file
        $originalName = method_exists($file, 'getClientOriginalName')
            ? $file->getClientOriginalName()
            : ($file->originalName ?? 'file');

        $filename = time() . '_' . $originalName;

        // Đường dẫn lưu
        $path = rtrim($folder, '/') . '/' . $filename;

        Storage::disk($disk)->put(
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
