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
use App\Repositories\DealerRepository;
use App\Helpers\Vgn;
use Carbon\Carbon;
use ErrorResponse;
use Session;

class DealerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    private $dealerUserRepository;

    public function __construct(DealerRepository $dealerRepo) {
        $this->dealerRepository = $dealerRepo;
        $this->repository = $this->getRepository();
	}

    public function getRepository() {
        return $this->dealerRepository;
    }

    
    
}