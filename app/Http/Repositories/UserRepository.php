<?php

namespace App\Http\Repositories;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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

    public function create(array $params): array
    {

        $data = [
            'name' => $params['name'],
            'is_active' => $params['is_active'] ?? 0
        ];

        $create = User::create($data);

        if (!$create) {
            throw new Exception("Could not create tenant, Please try again.", 500);
        }

        return $data;
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
}