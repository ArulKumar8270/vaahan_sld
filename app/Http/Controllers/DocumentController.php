<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;
use Carbon\Carbon;
use Storage;
use App\Helpers\Vgn;
use App\Repositories\DocumentRepository;
use App\Repositories\ImageRepository;
use Arr;
use Str;
use DB;
use ErrorResponse;

class DocumentController extends BaseController
{
    /**
     * The index function
     *
     * @return void
     */
    private $documentRepository;

    public function __construct(DocumentRepository $documentRepo, ImageRepository $imageRepo) {
        $this->documentRepository = $documentRepo;
        $this->imageRepository = $imageRepo;
        $this->repository = $this->getRepository();
	}

    public function getRepository() {
        return $this->documentRepository;
    }

    public function storeDataInit($input) {
        if (isset($input['image'])) { // Assuming 'class_image' is the input name for the file
            $input['image'] = $this->imageRepository->uploadAndGetUrl($input['image'],"image");
        }
        if (isset($input['document'])) { // Assuming 'class_image' is the input name for the file
            $input['document'] = $this->imageRepository->uploadAndGetUrl($input['document'],"document");
        }
        return $input;
    }
    
}