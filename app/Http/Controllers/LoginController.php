<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Models\User;
use Google_Client;
use Google_Service_Oauth2;
use ErrorResponse;

class LoginController extends BaseController
{
    /**
     * The index function
     *
     * @return void
     */
    private $userRepository;

    public function __construct(UserRepository $userRepo,RoleRepository $roleRepo) {
        $this->userRepository = $userRepo;
        $this->RoleRepository = $roleRepo;
        $this->repository = $this->getRepository();
	}

    public function getRepository() {
        return $this->userRepository;
    }

    public function index(Request $request)
    {
        // Catch the error from validator.
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);        
        
        if($validator->fails()){
            $error = $validator->errors()->first();
            throw new ErrorResponse($error,'422','info'); 
        }

        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return $this->sendError('The user account not exist.',['error'=>'The user account not exist.'],404);
        }
        if (!Hash::check($request->password, $user->password)) {
            return $this->sendError('The password does not belong to the user account.',['error'=>'The password does not belong to the user account.'],401);
        }
        // if($user->verified == 0) {
        //     return $this->sendError('You Are Not verified Yet Please Contact ADMIN',['error'=>'You Are Not verified Yet Please Contact ADMIN'],401);
        // }

        $success['access_token'] =  $user->createToken('api-token')->plainTextToken;
        $success['type'] =  'bearer';
        $success['user'] =  $this->userRepository->index(['id' => $user->id])->first();
        $success['user_role'] =  $user->role->name;
        return $this->sendResponse($success, 'User Loggedin successfully.');
    
    }

     public function register(Request $request) {
 
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);        
        
        if($validator->fails()){
            $error = $validator->errors()->first();
            throw new ErrorResponse($error,'422','info'); 
        }

        $input = $request->all();
        $input['email'] = @$input['email'] ?: $input['username'].'@'.'vaahansafety.org';
        $input['password'] = bcrypt($input['password']);
        $input['role_id'] = @$input['role_id'] ?: 5;
        $user = User::create($input);
        if($user->verified == 0) {
            throw new ErrorResponse('Please Login to Continue','422','info');
        }
    
        $success = [];
        $success['access_token'] =  $user->createToken('api-token')->plainTextToken;
        $success['user'] =  $this->userRepository->index(['id' => $user->id])->first();
     
        return $this->showResponse($request, ['data' => $success]);
    }

    public function approveUser(Request $request) {
        $input = $request->all();
        $user = Auth::guard('sanctum')->user();
        if($user) {
            $input['id'] = $user->id;
            $user = $this->userRepository->index($input)->first();
            return Vgn::showResponse($request, ['data' => $user]);
        } else {
            throw new ErrorResponse('Token Invalid','422','error'); 
        }
    }

}