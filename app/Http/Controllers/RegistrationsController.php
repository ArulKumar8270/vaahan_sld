<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;
use Carbon\Carbon;
use Storage;
use App\Helpers\Vgn;
use App\Repositories\RegistrationsRepository;
use App\Repositories\ImageRepository;
use Arr;
use Str;
use DB;
use ErrorResponse;

class RegistrationsController extends BaseController
{
    /**
     * The index function
     *
     * @return void
     */
    private $registrationsRepository;

    public function __construct(RegistrationsRepository $registrationsRepo, ImageRepository $imageRepo) {
        $this->registrationsRepository = $registrationsRepo;
        $this->imageRepository = $imageRepo;
        $this->repository = $this->getRepository();
	}

    public function indexDataInit($input) {
        $input['order'] = 'created_at|desc';
        return $input;
    }

    public function getRepository() {
        return $this->registrationsRepository;
    }

    public function processString($input) {
        // Remove special characters and spaces, and extract first four characters
        $cleanedInput = preg_replace('/[^a-zA-Z0-9]/', '', $input);
        $cleanedInput = substr($cleanedInput, 0, 4);

        // If the cleaned input is less than 4 characters, pad it with zeros
        $cleanedInput = str_pad($cleanedInput, 4, '0', STR_PAD_RIGHT);

        // Concatenate "3M" with the extracted characters
        $result = $cleanedInput . '3M'; // Assuming you want the result in uppercase

        // Generate a 6-digit random number
        $randomNumber = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Concatenate the random number with the result
        $result .= $randomNumber;

        return $result;
    }

    public function storeDataInit($input) {
        if(isset($input['rto'])) {
            $input['certificateno'] = $this->processString($input['rto']);
        }
        if (isset($input['rcimage'])) { // Assuming 'class_image' is the input name for the file
            $input['rcimage'] = $this->imageRepository->uploadAndGetUrl($input['rcimage'],"rcimage");
        }
        if (isset($input['frontimage'])) { // Assuming 'class_image' is the input name for the file
            $input['frontimage'] = $this->imageRepository->uploadAndGetUrl($input['frontimage'],"frontimage");
        }
        if (isset($input['backimage'])) { // Assuming 'class_image' is the input name for the file
            $input['backimage'] = $this->imageRepository->uploadAndGetUrl($input['backimage'],"backimage");
        }
        if (isset($input['leftimage'])) { // Assuming 'class_image' is the input name for the file
            $input['leftimage'] = $this->imageRepository->uploadAndGetUrl($input['leftimage'],"leftimage");
        }
        if (isset($input['rightimage'])) { // Assuming 'class_image' is the input name for the file
            $input['rightimage'] = $this->imageRepository->uploadAndGetUrl($input['rightimage'],"rightimage");
        }
        return $input;
    }
    
}