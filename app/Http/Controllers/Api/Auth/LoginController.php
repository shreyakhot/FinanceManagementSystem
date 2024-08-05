<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Log\LogService;

class LoginController extends Controller
{
    private $logService;

    public function __construct()
    {
        $this->logService = new LogService();
    }
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="login  user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA
     **/
    public function login(Request $request)
    {
        $this->logService->info('inside login');

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $this->logService->info('inside if authanticated');

            $user = Auth::user();
            $this->logService->info('generate token');
            $tokenResult = $user->createToken('finance');
            $this->logService->info('token created');
            $user->accessToken = $tokenResult->accessToken;
            
            $this->logService->info('generate response');


            return response()->json([
                'email' => $user->email, 'id' => $user->id,  'accessToken' =>  $user->accessToken, 'Status' => true,
                'Message' => "Logged in Successfully!!"
            ], 200);
        } else {
            return response()->json([
                'Status' => false,
                'Message' => "Invalid Credentials!!"
            ]);
        }
    }
}
