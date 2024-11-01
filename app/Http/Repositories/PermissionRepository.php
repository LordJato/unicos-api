<?php

namespace App\Http\Repositories;

use Exception;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class PermissionRepository
{

    public function getAll(object $request): array
    {
        $search = $request->get('search');

        //filters
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $orderBy = $request->input('orderBy', 'id');
        $orderDesc = $request->boolean('orderDesc') ? 'desc' : 'asc';

        $accounts = Permission::when($search, function ($query, $search) {
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

    public function getByID(int $id): ?Permission
    {
        $data = Permission::find($id);

        if (empty($data)) {
            throw new Exception("Permission does not exist.", Response::HTTP_NOT_FOUND);
        }

        return $data;
    }

    public function create(array $data): Permission
    {

        $prepareData = $this->prepareDataForDB($data);

        $create = Permission::create($prepareData);

        if (!$create) {
            throw new Exception("Could not create permission, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $create->fresh();
    }

    public function update(array $data) : Permission
    {
        $update = $this->getById($data['id']);
        
        $update->update($this->prepareDataForDB($data, $update));

        return $update->refresh();
    }

    public function softDelete(int $id): bool
    {

        $data = $this->getByID($id);

        return $data->delete();
    }

    public function forceDelete(int $id): bool
    {

        $data = $this->getByID($id);

        return $data->forceDelete();
    }

    public function prepareDataForDB(array $data, ?Permission $model = null ): array
    {
        $toSlug = Str::slug($data['name'], '-');

        return [
            'name' =>  $data['name'] ?? $model->name,
            'slug'    => $toSlug,
        ];
    }
}
