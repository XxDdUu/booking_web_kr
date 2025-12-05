<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Services\FileService;
use App\Http\Controllers\Controller;
class FileController extends Controller
{   
    protected FileService $fileService;

    public function __construct(FileService $fileService) 
    {
        $this->fileService = $fileService;
    }
    public function upload(Request $request)
    {
        Log::info('controller-hit');
        // $request->validate([
        //     'image' => 'required|file|mimes:jpg,png,jpeg,gif,webp,svg|max:2048',
        // ]);
        $file = $request->file('image');
        // store file under /storage/app/public/uploads
        $fileData = $this->fileService->uploadImage($file);
        return response()->json([
            'message' => 'Image uploaded successfully',
            ...$fileData
        ]);
    }

    public function get($filename)
    {
        $data = $this->fileService->getImage($filename);

        if (!$data) {
            return response()->json(['error' => 'Not found'], 404);
        }

        return response($data['content'], 200)
            ->header('Content-Type', $data['mime']);
    }
}
