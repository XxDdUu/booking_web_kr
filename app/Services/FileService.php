<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use App\Repositories\FileRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
class FileService
{
    public function __construct(
        protected FileRepository $repo
    ) {}

    public function uploadImage(UploadedFile $file, string $folder = 'uploads')
    {
        $diskName = env('FILESYSTEM_DRIVER', 'public');

        $path = $this->repo->store($file, $folder);

        $url = \Storage::disk($diskName)->url($path);

        return [
            'original_name' => $file->getClientOriginalName(),
            'stored_name' => basename($path),
            'path' => $path,
            'url' => $url,
        ];
    }

    public function getImage($filename, $folder = 'uploads')
    {   
        $path = $folder . '/' . $filename;

        if (!$this->repo->exists($path)) {
            return null;
        }

        return [
            'content' => $this->repo->get($path),
            'mime' => $this->repo->mime($path)
        ];
    }
}
