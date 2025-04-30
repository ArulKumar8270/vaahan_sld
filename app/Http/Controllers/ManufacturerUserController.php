<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
// use App\Http\Resources\UserCollection;
use App\Http\Controllers\BaseController as BaseController;
use App\Repositories\ManufacturerUserRepository;
use App\Helpers\Vgn;
use Carbon\Carbon;
use ErrorResponse;
use Session;

class ManufacturerUserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    private $manufacturerUserRepository;

    public function __construct(ManufacturerUserRepository $manufacturerUserRepo) {
        $this->manufacturerUserRepository = $manufacturerUserRepo;
        $this->repository = $this->getRepository();
	}

    public function getRepository() {
        return $this->manufacturerUserRepository;
    }

    
    
}