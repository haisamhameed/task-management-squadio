<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\LoginRequest;
use App\Repositories\UserRepositoryInterface;
use App\Http\Requests\User\RegistrationRequest;

class UserController extends Controller
{
    use ApiResponseTrait;
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function register(RegistrationRequest $request)
    {
        $fields = $request->validated();
        
        $user = $this->userRepository->createUser($fields);

        return $this->successResponse('User registered successfully', [
            'user' => new UserResource($user),
            'token' => $this->userRepository->userToken($user)
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $fields = $request->validated();

        $user = $this->userRepository->findByEmail($fields['email']);

        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return $this->errorResponse('Invalid credentials', [], 401);
        }

        return $this->successResponse('User logged in successfully', [
            'user' => new UserResource($user),
            'token' => $this->userRepository->userToken($user)
        ],201);
    }
}
