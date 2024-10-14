<?php

namespace App\Http\Repositories;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Laravel\Passport\PersonalAccessTokenResult;

class AuthRepository
{
    public function login(array $data): array
    {
        $user = $this->getUserByEmail($data['email']);

        
        if (!$user) {
            throw new Exception("User does not exist.", Response::HTTP_NOT_FOUND);
        }


        if (!$this->isValidPassword($user, $data)) {
            throw new Exception("Sorry, password does not match.", Response::HTTP_UNAUTHORIZED);
        }

        $tokenInstance = $this->createAuthToken($user);

        return $this->getAuthData($tokenInstance);
    }

    public function register(array $data): UserResource
    {
        $user = User::create($this->prepareDataForRegister($data));

        if (!$user) {
            throw new Exception("Sorry, user does not registered, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new UserResource($user);
    }

    public function logout(): bool
    {

        if (Auth::check()) {
            $token = Auth::guard()->user()->token();
            $token->revoke();
            $token->delete();
            return true;
        }

        return false;
    }

    public function forgotPassword(array $data) : string
    {
        $status = Password::sendResetLink(
            $data
        );

        switch ($status) {
            case Password::RESET_LINK_SENT:
                return $status;
            case Password::INVALID_USER:
                throw new Exception("Invalid email address", Response::HTTP_BAD_REQUEST);
            default:
                throw new Exception("Failed to send mail", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function resetPassword (array $data) : string {
        $status = Password::reset(
            $data,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
        
        if ($status == Password::PASSWORD_RESET) {
            return $status;
        }

        throw new Exception($status, Response::HTTP_INTERNAL_SERVER_ERROR);
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
            'email'    => $data['email'],
            'phone'    => $data['phone'],
            'password' => Hash::make($data['password']),
        ];
    }
}
