<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
class FileRepository
{
    public function store($file, string $folder): string
    {
        $disk = config('filesystems.default');

        // Lấy tên gốc
        $originalName = method_exists($file, 'getClientOriginalName')
            ? $file->getClientOriginalName()
            : ($file->originalName ?? 'file');

        // Tạo tên file an toàn
        $ext = $file->getClientOriginalExtension();
        $filename = time() . '_' . uniqid() . '.' . $ext;

        // Đường dẫn lưu
        $path = rtrim($folder, '/') . '/' . $filename;

        // Upload (KHÔNG ACL)
        try {
            Storage::disk($disk)->put(
                $path,
                file_get_contents($file->getRealPath())
            );
        } catch (\Throwable $e) {
            dd([
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }


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
