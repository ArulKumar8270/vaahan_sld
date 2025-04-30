<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;

class ImageRepository {

    public function uploadAndGetUrl($imageFile,$name)
    {
        $imageName = $name.time().'.'.$imageFile->getClientOriginalExtension();
        $imageFile->storeAs('public/images', $imageName); // Storing the image

        return asset('storage/images/'.$imageName); // Generating and returning URL path
    }
}
