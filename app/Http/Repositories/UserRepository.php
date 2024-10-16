<?php

namespace App\Http\Repositories;
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

    public function update(int $id, array $params): ?User
    {
        $tenant = $this->getById($id);
        $tenant->name = $params['name'];
        $tenant->is_active = $params['is_active'];
        
        if ($tenant->save()) {
            $tenant = $this->getById($id);
        }

        return $tenant;
    }

    public function getAuthUser() : User {
        return Auth::user();
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
}