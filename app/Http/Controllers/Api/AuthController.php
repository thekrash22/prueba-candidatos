<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    private $userRepository;
    public function __construct(UserRepositoryInterface $userRepository){
        $this->userRepository = $userRepository;
    }
    public function register(RegisterRequest $request){
        try {
            $user = $this->userRepository->save(request()->all());
            return ApiResponseHelper::successResponse($user,201);
        }catch (\Exception $exception){
            return ApiResponseHelper::errorResponse($exception->getMessage(),500);
        }
    }


    public function login(AuthLoginRequest $request)
    {
        try {
            $credentials = $request->only(['email', 'password']);
            $auth = $this->userRepository->login($credentials);
            return ApiResponseHelper::successResponse($auth,200);
        }catch (HttpResponseException $exception){

            return ApiResponseHelper::errorResponse($exception->getResponse()->getContent(),Response::HTTP_UNAUTHORIZED);
        }

    }

    public function logout()
    {

        try {
            $logout = $this->userRepository->logout();
            return ApiResponseHelper::successResponse($logout, Response::HTTP_OK);

        }catch (\Exception $exception){
            return ApiResponseHelper::errorResponse($exception->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function refresh()
    {
        try {
            return ApiResponseHelper::successResponse($this->userRepository->refresh(),Response::HTTP_OK);
        }
        catch (\Exception $exception){
            return ApiResponseHelper::errorResponse($exception->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
