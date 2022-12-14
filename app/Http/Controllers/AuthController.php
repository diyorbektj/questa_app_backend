<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    /**
     * Register User
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::query()->create($data);
        $token = $user->createToken(User::USER_TOKEN);
        return response()->success([
            'user' => $user,
            'token' => $token->plainTextToken,
        ],'User has been register successfully', 201);
    }

    /**
     * Login a user
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request):JsonResponse
    {
        $isValid = $this->isValidCredential($request);
        if (!$isValid['success'])
        {
            return response()->error($isValid['message'], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user = $isValid['user'];
        $token = $user->createToken(User::USER_TOKEN);
        return response()->success([
            'user' => $user,
            'token' => $token->plainTextToken,
        ],'Login Successfully');
    }

    /**
     * Validate user credential
     * @param LoginRequest $request
     * @return array
     */
    public function isValidCredential(LoginRequest $request):array
    {
        $data = $request->validated();
        $user = User::query()->where('email', $data['email'])->first();

        if (!$user){
            return [
                'success' => false,
                'message' => 'Invalid Credential'
            ];
        }
        if(Hash::check($data['password'], $user->password))
        {
          return [
              'success' => true,
              'user' => $user
          ];
        }
        return [
            'success' => false,
            'message' => "Password is not matchted Credential"
        ];
    }

    /**
     * Login with token
     * @return JsonResponse
     */
    public function loginWithToken(): JsonResponse
    {
        return response()->success(
            auth()->user(),
            'Login Successfully'
        );
    }

    /**
     * Logout
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $user = User::query()->find(auth()->id())->currentAccessToken()->delete();
        return response()->success(
            null,
            "Logout successfully"
        );
    }
}
