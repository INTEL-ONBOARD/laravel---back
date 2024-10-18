<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    // Registration
    public function register(RegisterRequest $request)
    {
        // reCAPTCHA verification
        $response = $request->input('captcha');
        $secretKey = env('RECAPTCHA_SECRET');

        $responseData = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $response,
        ]);

        $responseData = json_decode($responseData->getBody(), true);

        if (!$responseData['success']) {
            return response()->json(['error' => 'Invalid reCAPTCHA'], 422);
        }

        // Create the user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'contact' => $request->contact,
            'bio' => $request->bio,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        Log::info('User registered successfully', ['user_id' => $user->id]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    // Login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'message' => 'Login successful',
                'user' => $user
            ], 200);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }
}
