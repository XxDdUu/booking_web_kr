<?php

namespace App\Services\Admin;

use App\Repositories\Admin\LocationRepository;
use Illuminate\Support\Facades\Storage;
use App\Services\FileService;
use Log;
class LocationService
{
    protected LocationRepository $repo;
    protected FileService $fileService;

    public function __construct(LocationRepository $repo, FileService $fileService)
    {
        $this->repo = $repo;
        $this->fileService = $fileService;
    }
    public function getLocations()
    {
        $locations = $this->repo->getAll();

        return $locations->map(function ($location) {
            return [
                'locationID' => $location->locationID,
                'locationName' => $location->locationName,
                'address' => $location->address,
                'country' => $location->country,
                'pinCode' => $location->pinCode,

                'location_image_path' => $location->location_image_path,

                'image_url' => Storage::url($location->location_image_path),
            ];
        });

    }


    public function createLocation(array $data)
    {

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $this->fileService->uploadImage($data['image'], 'uploads/locations')['path'];
            

            $data['location_image_path'] = $path;
        }

        return $this->repo->create($data);
    }
    public function updateLocation(string $locationID, array $data)
    {

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {

            if (!empty($data['existing_image_path'])) {
                $this->fileService->deleteFile($data['existing_image_path']);
            }

            $upload = $this->fileService->uploadImage(
                $data['image'],
                'uploads/locations' 
            );

            $data['location_image_path'] = $upload['path'];
        }

        return $this->repo->update($locationID, $data);
    }

}
