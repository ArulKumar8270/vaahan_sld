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
use App\Repositories\DealerUserRepository;
use App\Repositories\DistributorUserRepository;
use App\Repositories\ManufacturerUserRepository;
use App\Repositories\SubDistributorUserRepository;
use App\Repositories\UserRepository;
use App\Helpers\Vgn;
use Carbon\Carbon;
use ErrorResponse;
use Session;

class DealerUserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    private $dealerUserRepository;

    public function __construct(DealerUserRepository $dealerUserRepo, DistributorUserRepository $distributorUserRepo, ManufacturerUserRepository $manufacturerUserRepo, SubDistributorUserRepository $subDistributorUserRepo, UserRepository $userRepo) {
        $this->dealerUserRepository = $dealerUserRepo;
        $this->distributorUserRepository = $distributorUserRepo;
        $this->manufacturerUserRepository = $manufacturerUserRepo;
        $this->subDistributorUserRepository = $subDistributorUserRepo;
        $this->userRepository = $userRepo;
        $this->repository = $this->getRepository();
	}

    public function getRepository() {
        return $this->dealerUserRepository;
    }

    public function resetPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'id' => 'required',
        ]);        
        
        if($validator->fails()){
            $error = $validator->errors()->first();
            throw new ErrorResponse($error,'422','info'); 
        }
        $input = $request->all();
        if(@$input['dealer_user'] == 1) {
            $updateData = $this->dealerUserRepository->index(['user_name' => $input['user_name']])->update(['password' => $input['password']]);
        }
        if(@$input['distributor_user'] == 1) {
            $updateData = $this->distributorUserRepository->index(['user_name' => $input['user_name']])->update(['password' => $input['password']]);
        }
        if(@$input['manufacturer_user'] == 1) {
            $updateData = $this->manufacturerUserRepository->index(['user_name' => $input['user_name']])->update(['password' => $input['password']]);
        }
        if(@$input['sub_distributor_user'] == 1) {
            $updateData = $this->subDistributorUserRepository->index(['user_name' => $input['user_name']])->update(['password' => $input['password']]);
        }
        if(!$updateData) {
            throw new ErrorResponse('Something Went Wrong Please Contact Admin','422','info'); 
        }
        $this->userRepository->index(['username' => $input['user_name'],'id' => $input['id']])->update(['password' => bcrypt($input['password'])]);
        return $this->sendResponse($updateData, 'Password Changed successfully.');
    }
    
}