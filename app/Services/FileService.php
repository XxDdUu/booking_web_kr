<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use App\Repositories\FileRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Psy\Util\Str;
class FileService
{
    public function __construct(
        protected FileRepository $repo
    ) {}

    public function uploadImage(UploadedFile $file, string $folder = 'uploads')
    {
        $diskName = config('filesystems.default');

        $path = $this->repo->store($file, $folder);

        $url = $this->getUrl($path);

        return [
            'original_name' => $file->getClientOriginalName(),
            'stored_name' => basename($path),
            'path' => $path,
            'url' => $url,
        ];
    }

    public function getUrl(string $path): string
    {
        $disk = config('filesystems.default');
        return \Storage::disk($disk)->url($path);
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
    public function deleteFile(string $path)
    {
        return $this->repo->delete($path);
    }
}
