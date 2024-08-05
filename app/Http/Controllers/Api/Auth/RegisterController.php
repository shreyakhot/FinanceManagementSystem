<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\userRoleMapping;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\Log\LogService;
use App\Http\Requests\RegisterUserRequest;

class RegisterController extends Controller
{
    private $logService;

    public function __construct()
    {
        $this->logService = new LogService();
    }

    /**
    * @OA\Post(
    *     path="/api/register",
    *     summary="Register a new user",
    *     @OA\RequestBody(
    *         required=true,
    *         @OA
    **/
    public function registerUser(RegisterUserRequest  $request)
    {
       
        try {
            $this->logService->info('inside registerUser');

            // Log request data
            $this->logService->info('Request Data: ', $request->all());

            $user = User::create([
                'fullName' => $request->input('fullName'),
                'userName' => $request->input('userName'),
                'email' => $request->input('email'),
                'contactNo' => $request->input('contactNo'),
                'password' => Hash::make($request->input('password')),
            ]);

           userRoleMapping::create([
                'userId' => $user->id,
                'roleId' => 2,
            ]);

            $this->logService->info('User created successfully');

            $response = response()->json(['user' => $user], 201);

            $this->logService->info('Response: ', $response->getContent());

            return $response;
            
        } catch (\Exception $e) {
            $this->logService->error('Error creating user: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
