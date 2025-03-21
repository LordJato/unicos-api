<?php

namespace App\Repositories\v1;

use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Http\Resources\v1\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class AuthRepository
{
    /**
     * Login user.
     *
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function login(array $data): bool
    {
        $user = $this->getUserByEmail($data['email']);
 
        if (!$this->isValidPassword($user, $data)) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, "Sorry, email and password do not match.");
        }

        return true;
    }


    /**
     * Register user.
     *
     * @param array $data
     * @return UserResource
     * @throws HttpException
     */
    public function register(array $data): UserResource
    {
     
        $user = User::create($this->prepareDataForRegister($data));

        if (!$user) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Sorry, user does not registered, Please try again.");
        }

        return new UserResource($user);
    }

    /**
     * Forgot password.
     *
     * @param array $data
     * @return string
     * @throws HttpException
     */

    public function forgotPassword(array $data): string
    {
        $status = Password::sendResetLink($data);

        switch ($status) {
            case Password::RESET_LINK_SENT:
                return $status;
            case Password::INVALID_USER:
                throw new HttpException(Response::HTTP_BAD_REQUEST, "Invalid email address");
            default:
                throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Failed to send mail");
        }
    }

    /**
     * Reset password.
     *
     * @param array $data
     * @return string
     * @throws HttpException
     */
    public function resetPassword(array $data): string
    {
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

        throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, $status);
    }

    /**
     * Get user by email.
     *
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Validate password.
     *
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function isValidPassword(User $user, array $data): bool
    {
        return Hash::check($data['password'], $user->password);
    }

    /**
     * Prepare registration data.
     *
     * @param array $data
     * @return array
     */
    private function prepareDataForRegister(array $data): array
    {
        return [
            'account_id' => $data['accountId'] ?? Auth::user()->accountId ?? null,
            'email'    => $data['email'],
            'phone'    => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
        ];
    }
}
