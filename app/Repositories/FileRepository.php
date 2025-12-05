<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
class FileRepository
{
    public function store($file, string $folder): string
    {
        $disk = config('filesystems.default');

        // Ensure folder exists
        $storagePath = ($disk === 'public') ? $folder : $folder;

        if (!\Storage::disk($disk)->exists($storagePath)) {
        \Storage::disk($disk)->makeDirectory($storagePath);
        }

        $originalName = method_exists($file, 'getClientOriginalName')
            ? $file->getClientOriginalName()
            : ($file->originalName ?? 'file');

        $filename = time() . '_' . $originalName;

        return Storage::disk($disk)
        ->putFileAs($folder, $file, $filename);
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
