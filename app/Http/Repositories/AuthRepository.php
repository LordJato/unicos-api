<?php

namespace App\Http\Repositories;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenResult;

class AuthRepository
{
    public function login(array $data) : array
    {
        $user = $this->getUserByEmail($data['email']);

        if (!$this->isValidPassword($user, $data)) {
            throw new Exception("Sorry, password does not match.", 401);
        }

        $tokenInstance = $this->createAuthToken($user);

        return $this->getAuthData($tokenInstance);
    }

    public function register(array $data): UserResource
    {
        $user = User::create($this->prepareDataForRegister($data));

        if (!$user) {
            throw new Exception("Sorry, user does not registered, Please try again.", 500);
        }

        return new UserResource($user);
    }

    public function logout() : bool {

        if(Auth::check()){
            $token = Auth::guard()->user()->token();
            $token->revoke();
            $token->delete();
            return true;
        }

        return false;
    }

    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function isValidPassword(User $user, array $data): bool
    {
        return Hash::check($data['password'], $user->password);
    }

    public function createAuthToken(User $user): PersonalAccessTokenResult
    {
        return $user->createToken('Personal Access Token');
    }

    public function getAuthData(PersonalAccessTokenResult $tokenInstance): array
    {
        return [
            'access_token' => $tokenInstance->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse($tokenInstance->token->expires_at)->toDateTimeString()
        ];
    }

    public function prepareDataForRegister(array $data): array
    {
        return [
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ];
    }
}
