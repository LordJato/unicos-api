<?php

namespace App\Http\Repositories;

use App\Http\Resources\UserResource;
use Exception;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function getAll(object $request) : array {
        $search = $request->get('search');

        //filters
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $orderBy = $request->input('orderBy', 'id');
        $orderDesc = $request->boolean('orderDesc') ? 'desc' : 'asc';

        $accounts = User::when($search, function ($query, $search) {
            $query->where('name', 'like', $search . '%');
        })
            ->orderBy($orderBy, $orderDesc)
            ->paginate($limit, ['*'], 'page', floor($offset / $limit) + 1);

        $data = [
            'total' => $accounts->total(),
            'records' => $accounts->items(),
            'offset' => $offset,
            'limit' => $limit
        ];

        return $data;
    }

    public function getByID(int $id): ?User
    {
        $user = User::find($id);

        if (empty($user)) {
            throw new Exception("User does not exist.", Response::HTTP_NOT_FOUND);
        }

        return $user;
    }

    public function create(array $data): ?User
    {

        $user = User::create($this->prepareDataForRegister($data));

        if (!$user) {
            throw new Exception("Sorry, user does not registered, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $user;
    }

    public function update(int $id, array $data) : User
    {
        $update = $this->getById($id);
        
        $update->update($this->prepareDataForRegister($data, $update));

        return $update->refresh();
    }

    public function softDelete(int $id): bool
    {

        $data = $this->getByID($id);

        return $data->delete();
    }

    public function prepareDataForRegister(array $data): array
    {

        return [
            'account_id' => $data['account_id'],
            'email'    => $data['email'],
            'phone'    => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
        ];
    }

    public function getAuthUser(){
        return new UserResource(Auth::user());
    }
}