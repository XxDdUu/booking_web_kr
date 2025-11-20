<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\AuthCheckService;
use Validator;

class AuthCheckController extends Controller
{
    protected $authCheck;

    public function __construct(AuthCheckService $authCheck){
        $this->authCheck = $authCheck;
    }
    
    public function checkEmail(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()){
            return response()->json([
              'success' => false,
              'errors' => $validator->errors()  
            ], 422);
        }
        $email = $request->input('email');

        $exist = $this->authCheck->exists("email",$email);

        return response()->json([
            'success' => true,
            'email_exists' => $exist
        ]);
    }   
    public function checkPhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $phone = $request->input('phone');

        $exists = $this->authCheck->exists("phone",$phone);

        return response()->json([
            'success' => true,
            'phone_exists' => $exists
        ]);
    }
}
