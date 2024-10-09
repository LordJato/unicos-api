<?php

namespace App\Http\Repositories;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function getAll(object $request) : array {
        $offset = $request->has('offset') ? $request->get('offset') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;
        $search = $request->get('search');

        $tenants = User::where(function ($q) use ($search) {
            if ($search) {
                $q->where('name', '=', $search . '%');
            }
        })
            ->limit($limit)
            ->offset(($offset - 1) * $limit)
            ->get()
            ->toArray();

        $data = [
            'total' => count($tenants),
            'records' => $tenants,
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