<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests\Api\UserRequest;
use App\Http\Requests\Api\UserLoginRequest;


use App\Repositories\Api\UserRepository;

use App\Http\Resources\Api\UserResource;

class UserController extends Controller
{

    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return $this->buildApiResponse([
            'user' => new UserResource($this->userRepository->index())
        ]);
    }

    public function store(UserRequest $request)
    {
        return $this->buildApiResponse([
            'user' => new UserResource($this->userRepository->store($request->get('user')))
        ]);
    }


    public function login(UserLoginRequest $request)
    {
        return $this->buildApiResponse([
            'user' => new UserResource($this->userRepository->login($request->get('user')))
        ]);
    }
}
