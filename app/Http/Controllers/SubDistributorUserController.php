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
use App\Repositories\SubDistributorUserRepository;
use App\Helpers\Vgn;
use Carbon\Carbon;
use ErrorResponse;
use Session;

class SubDistributorUserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    private $subDistributorUserRepository;

    public function __construct(SubDistributorUserRepository $subDistributorUserRepo) {
        $this->subDistributorUserRepository = $subDistributorUserRepo;
        $this->repository = $this->getRepository();
	}

    public function getRepository() {
        return $this->subDistributorUserRepository;
    }

    
    
}