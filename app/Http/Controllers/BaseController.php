<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Traits\VgnControllerTrait;
use View;
use Validator;

class BaseController extends Controller
{
	use VgnControllerTrait;

    public static function showResponse($request = null, $input = []) {
		$requsestType = 'api';
		if($request->ajax() && !$request->is('api/*')) {
			$requsestType = 'ajax';
		}
		if(!$request->ajax() && !$request->is('api/*')) {
			$requsestType = 'web';
		}

		$data = Arr::has($input, 'data') ? $input['data'] : null;
		$webUrl = Arr::has($input, 'webUrl') ? $input['webUrl'] : null; // call blade file (eg: package::resource.index)
		$ajaxUrl = Arr::has($input, 'ajaxUrl') ? $input['ajaxUrl'] : null; // call blade file (eg: package::resource.index)
		$responseData = null;

		$defaultValidationRules = [
			'name' => 'nullable|string|max:255',
			'address' => 'nullable|string|max:500',
			'phone' => 'nullable|string|max:20',
			'mobile' => 'nullable|string|max:20',
			'email' => 'nullable|email|max:255',
			'password' => 'nullable|string|min:8',
			'dob' => 'nullable|date',
			'gender' => 'nullable|in:Male,Female,Other',
			'country' => 'nullable|string|max:100',
			'zipcode' => 'nullable|string|max:20',
			'title' => 'nullable|string|max:150',
			'question' => 'nullable|string',
			'subtitle' => 'nullable|string|max:200',
		];
	
		// Filter input fields that have validation rules in $defaultValidationRules
		$fieldsToValidate = array_intersect_key($request->all(), $defaultValidationRules);
	
		// Run validation only if there are fields to validate
		if (!empty($fieldsToValidate)) {
			$validator = Validator::make($fieldsToValidate, $defaultValidationRules);
	
			if ($validator->fails()) {
				// Validation failed, return errors or handle accordingly
				// For example, returning the validation errors
				return response()->json(['errors' => $validator->errors()], 422);
			}
		}

		switch ($requsestType) {
			case 'ajax':
				$view = View::make($ajaxUrl, ['item' => $data])->render();
				$responseData = response()->json(compact('view'));
				break;
			case 'web':
				$view = view($webUrl, ['item' => $data])->render();
				$responseData = $view;
				break;
			default:
				$responseData = response()->json([
					'data' => $data,
                    'message' => 'success',
                    'code' => Response::HTTP_OK,
                    'response' => Response::$statusTexts[Response::HTTP_OK]], Response::HTTP_OK);
				break;
		}
		return $responseData;
	}

    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        
        return response()->json($response, $code);
    }

}