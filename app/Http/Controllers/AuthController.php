<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use App\Helpers\Vgn;
use ErrorResponse;
use Validator;

class AuthController extends BaseController
{
    public function index(Request $request)
    {
        $products = User::all();
        return $this->sendResponse($products, 'Products retrieved successfully.');
    }

    public function register(Request $request) :JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            $error = $validator->errors()->first();
            throw new ErrorResponse($error,'405','info'); 
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->showResponse($request, ['data' => $success]);
    }

    public function login(Request $request) : JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;
            return $this->sendResponse($success, 'User login successfully.');
        } else { 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function changePassword(Request $request) {
        $authUser = Auth::guard('sanctum')->user();
        if(! $authUser) {
            throw new ErrorResponse($error,'405','info');
        }
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'conform_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            $error = $validator->errors()->first();
            throw new ErrorResponse($error,'405','info'); 
        }
        $input = $request->all();
        $password = Arr::has($input, 'password') ? $input['password'] : null;
        $confirmPassword = Arr::has($input, 'conform_password') ? $input['conform_password'] : null;
            
            if ($authUser && $authUser->id) {
                $updateData = ['password' => bcrypt($password)];
               $authUser->fill($updateData)->save();
            } else {
                throw new ErrorResponse('UnAuthorized Access, Token Not Available',405,'info');
            }
        
        return Wlc::successMessage('Password Changed Successfully');
    }

    public function forgotPassword(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        
        if($validator->fails()){
            $error = $validator->errors()->first();
            throw new ErrorResponse($error,'405','info'); 
        }

        $input = $request->all();
        $userCheck = User::where('email',$input['email'])->first();
        // Email Verification Takes Place
        
        if($input['email'] == $userCheck->email) {
            $validator = Validator::make($request->all(), [
                'password' => 'required',
                'confirm_password' => 'required|same:password',
            ]);
    
            if($validator->fails()){
                $error = $validator->errors()->first();
                throw new ErrorResponse($error,'405','info'); 
            }
            $password = Arr::has($input, 'password') ? $input['password'] : null;
            $confirmPassword = Arr::has($input, 'confirm_password') ? $input['confirm_password'] : null;
                if ($userCheck && $userCheck->id) {
                    $updateData = ['password' => bcrypt($password)];
                    $userCheck->fill($updateData)->save();
                    $userCheck->tokens()->delete();
                }
                return Wlc::successMessage('Password Resetted Successfully,Please Login To Continue');
        } else {
            throw new ErrorResponse('You Are Not Having Any Privilages to do this','405','critical'); 
        }
        
    }
}