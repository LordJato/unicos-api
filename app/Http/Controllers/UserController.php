<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Traits\ResponseTrait;
use Exception;

class UserController extends Controller
{
    use ResponseTrait;

    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function index()
    {
        try {
            return $this->responseSuccess($this->userRepository->getAll(request()), "Users fetched successfully");
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    public function profile()
    {
        try {

            $profile = $this->userRepository->getAuthUser();

            return $this->responseSuccess($profile, 'User fetched successfully');
            
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }
}
