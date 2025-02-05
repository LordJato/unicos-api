<?php

namespace App\Http\Repositories;

use Exception;
use App\Models\User;
use Illuminate\Http\Response;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository
{

    /**
     * Get all Users.
     *
     * @param array $params
     * @return array
     */

    public function getAll(array $params): array
    {
        $search = $params['search'];

        $users = User::when($search, fn($query, $search) => $query->where('email', 'like', $search . '%'))
        ->orderBy($params['orderBy'], $params['orderDesc'])
        ->paginate($params['limit'], ['*'], 'page', floor($params['offset'] / $params['limit']) + 1);

        return [
            'total' => $users->total(),
            'records' => $users->items(),
            'offset' =>  $params['offset'],
            'limit' => $params['limit']
        ];
    }

    /**
     * Get User by ID.
     *
     * @param int $id
     * @return User|null
     * @throws Exception
     */
    public function getById(int $id): ?User
    {
        $user = User::find($id);

        if (empty($user)) {
            throw new Exception("User does not exist.", Response::HTTP_NOT_FOUND);
        }

        return $user;
    }

    /**
     * Create User.
     *
     * @param array $params
     * @return User|null
     * @throws Exception
     */
    public function create(array $params): ?User
    {

        $user = User::create($this->prepareDataForDB($params));

        if (!$user) {
            throw new Exception("Sorry, user does not registered, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $user;
    }

    /**
     * Update User.
     *
     * @param array $params
     * @return User|null
     */

    public function update(int $id, array $params): ?User
    {
        $update = $this->getById($id);

        $update->update($this->prepareDataForDB($params, $update));

        return $update->refresh();
    }

    /**
     * Soft delete Account.
     *
     * @param int $id
     * @return bool
     */
    public function softDelete(int $id): bool
    {

        $data = $this->getById($id);

        return $data->delete();
    }

    /**
     * Prepares data for database insertion/update.
     *
     * @param array $data Incoming data.
     * @param User|null $model Existing account model (optional).
     *
     * @return array Prepared data.
     */
    public function prepareDataForDB(array $data, ?User $model = null): array
    {
        $phone = $data['phone'] ?? ($model ? $model->phone : null);

        return [
            'account_id' => $data['account_id'] ?? $model->account_id,
            'email'    => $data['email'] ?? $model->email,
            'phone'    => $phone,
            'password' => $data['password'] ? Hash::make($data['password']) : Hash::make($model->password),
        ];
    }

    public function syncRolesWithPermissions(array $data): UserResource
    {

        $roles = $data['roles'];
        $userId = $data['userId'];

        $user = $this->getById($userId);

        $getPemissionIds = $user->getAllPermissionIdByRoles($roles);

        $user->roles()->sync($roles);
        $user->permissions()->sync($getPemissionIds);


        return new UserResource($user);
    }
}
