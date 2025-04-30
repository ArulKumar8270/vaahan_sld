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
use App\Repositories\UserRepository;
use App\Helpers\Vgn;
use Carbon\Carbon;
use ErrorResponse;
use Session;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    private $userRepository;

    public function __construct(UserRepository $userRepo) {
        $this->userRepository = $userRepo;
        $this->repository = $this->getRepository();
	}

    public function getRepository() {
        return $this->userRepository;
    }

    public function indexDataInit($input) {
        // $input = $request->all();
        $input['with'] = 'role';
        // $input['select'] = ['id','role_id'];
        // $data = $this->repository->all($input);
        return $input;
    }

    public function getUser(Request $request)
    {
        $input = $request->all();
        $user = Auth::guard('sanctum')->user();
        if($user) {
            $input['id'] = $user->id;
            $input['with'] = "role";
            $user = $this->userRepository->index($input)->first();
            return Vgn::showResponse($request, ['data' => $user]);
        } else {
            throw new ErrorResponse('Token Invalid','422','error'); 
        }
    
    }

    public function approveUser(Request $request) {
        $input = $request->all();
        $user = Auth::guard('sanctum')->user();
        if(isset($user)) {
            $input['id'] = $user->id;
            $input['with'] = "role";
            $userData = $this->userRepository->index($input)->first();
            if($userData->role->name == "Admin") {
                $customers = $this->userRepository->index()->get();
            } else {
                throw new ErrorResponse('You Are Not have eligible criteria to do this action Contact ADMIN', 405, 'info');
            }
        } else {
            throw new ErrorResponse('Restricted Actions Contact Support', 409, 'developers');
        }
    }

    public function logout(Request $request)
    {
        $authUser = Auth::guard('sanctum')->user();

        // Revoke the user's current access token
        $authUser->tokens()->delete();

        return Vgn::successMessage('Logged Out Successfully');
    }

    public function createUser() {
        $validator = Validator::make($request->all(), [
            'email' => 'required_without:mobile|email|unique:users,email',
            'mobile' => [
                'required_without:email',
                'regex:/^(\+?\d{1,3}[-\s]?)?\(?\d{3}\)?[-\s]?\d{3}[-\s]?\d{4}$/',
                'unique:users,mobile'
            ],
            'password' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('email') && $errors->first('email') === 'The email has already been taken.') {
                throw new ErrorResponse('Email already exists', 409, 'info');
            } elseif ($errors->has('mobile') && $errors->first('mobile') === 'The mobile has already been taken.') {
                throw new ErrorResponse('Mobile number already exists', 409, 'info');
            } else {
                $error = $errors->first();
                throw new ErrorResponse($error, 422, 'info');
            }
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['role_id'] = @$input['role_id'] ?: 3;
        $user = User::create($input);
        if($user->verified == 0) {
            throw new ErrorResponse('Please Login to Continue','422','info');
        }
    
        $success = [];
        $success['access_token'] =  $user->createToken('api-token')->plainTextToken;
        $success['user'] =  $this->userRepository->index(['id' => $user->id])->first();
     
        return $this->showResponse($request, ['data' => $success]);
    }
    
}