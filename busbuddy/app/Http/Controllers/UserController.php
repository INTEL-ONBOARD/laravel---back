<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class UserController extends Controller
{
    // Get All Users
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    // Create User
    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create($validatedData);
        Log::info('User created successfully', ['user_id' => $user->id]);

        return response()->json($user, 201);
    }

    // Show Single User
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }

    // Update User
    public function update(StoreUserRequest $request, $id)
    {
        $validatedData = $request->validated();

        $user = User::findOrFail($id);
        $user->update($validatedData);
        Log::info('User updated successfully', ['user_id' => $user->id]);

        return response()->json($user, 200);
    }

    // Delete User
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        Log::info('User deleted successfully', ['user_id' => $id]);

        return response()->json(null, 204);
    }

    public function verifyCaptcha(Request $request)
{
    $response = Http::post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => env('RECAPTCHA_SECRET_KEY'),
        'response' => $request->input('g-recaptcha-response'),
    ]);

    return json_decode($response->getBody(), true);
}
}
