<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;
use App\Repositories\TransportationRepository;
use Carbon\Carbon;
use Storage;
use Arr;
use Str;
use DB;
use ErrorResponse;

class TransportationController extends BaseController
{
    /**
     * The index function
     *
     * @return void
     */
    private $transportationRepository;

    public function __construct(TransportationRepository $transportationRepo) {
        $this->transportationRepository = $transportationRepo;
        $this->repository = $this->getRepository();
	}

    public function getRepository() {
        return $this->transportationRepository;
    }

    // public function storeDataInit($input) {
    //     dd($input);
    // }
    
}