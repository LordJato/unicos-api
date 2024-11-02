<?php

namespace App\Http\Repositories;

use Exception;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class RoleRepository
{

    public function getAll(object $request): array
    {
        $search = $request->get('search');

        //filters
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $orderBy = $request->input('orderBy', 'id');
        $orderDesc = $request->boolean('orderDesc') ? 'desc' : 'asc';

        $accounts = Role::with('permissions')->when($search, function ($query, $search) {
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

    public function getById(int $id): ?Role
    {
        $data = Role::find($id);

        if (empty($data)) {
            throw new Exception("Role does not exist.", Response::HTTP_NOT_FOUND);
        }

        return $data;
    }

    public function create(array $data): Role
    {

        $prepareData = $this->prepareDataForDB($data);

        $create = Role::create($prepareData);

        if (!$create) {
            throw new Exception("Could not create role, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $create->fresh();
    }

    public function update(array $data) : Role
    {
        $update = $this->getById($data['id']);
        
        $update->update($this->prepareDataForDB($data, $update));

        return $update->refresh();
    }

    public function softDelete(int $id): bool
    {

        $data = $this->getById($id);

        return $data->delete();
    }

    public function forceDelete(int $id): bool
    {

        $data = $this->getById($id);

        return $data->forceDelete();
    }

    public function prepareDataForDB(array $data, ?Role $model = null ): array
    {
        $toSlug = Str::slug($data['name'], '-');

        return [
            'name' =>  $data['name'] ?? $model->name,
            'slug'    => $toSlug,
        ];
    }
}
