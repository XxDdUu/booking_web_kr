<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthCheckService;
use Validator;

class AuthCheckController extends Controller
{
    protected $authCheck;
    
    public function checkEmail(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        
    }   
}
