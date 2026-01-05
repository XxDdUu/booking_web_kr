<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class RegisteredUserController extends Controller
{
    public function store(RegisterRequest $request){
        $validated = $request->validated([
            'name' => ['string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'required_without:phone'],
            'phone' => ['required', 'string', 'max:255', 'unique:users', 'required_without:email'],
            'password' => ['required', 'confirmed', Rule\Password::default()],
        ]);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);
        event(new Registered($user));

        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }
}
