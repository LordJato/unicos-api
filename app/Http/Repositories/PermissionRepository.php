<?php

namespace App\Http\Repositories;

use Exception;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class PermissionRepository
{

    /**
     * Get all Permission.
     *
     * @param array $params
     * @return array
     */

    public function getAll(array $params): array
    {
        $search = $params['search'];

        $accounts = Permission::when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
            ->orderBy($params['orderBy'], $params['orderDesc'])
            ->paginate($params['limit'], ['*'], 'page', floor($params['offset'] / $params['limit']) + 1);

        return [
            'total' => $accounts->total(),
            'records' => $accounts->items(),
            'offset' =>  $params['offset'],
            'limit' => $params['limit']
        ];
    }

    /**
     * Get Permission by ID.
     *
     * @param int $id
     * @return Permission|null
     * @throws Exception
     */
    public function getByID(int $id): ?Permission
    {
        $data = Permission::find($id);

        if (empty($data)) {
            throw new Exception("Permission does not exist.", Response::HTTP_NOT_FOUND);
        }

        return $data;
    }

    /**
     * Create Permission.
     *
     * @param array $params
     * @return Permission
     * @throws Exception
     */
    public function create(array $params): Permission
    {

        $prepareData = $this->prepareDataForDB($params);

        $create = Permission::create($prepareData);

        if (!$create) {
            throw new Exception("Could not create permission, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $create->fresh();
    }

    /**
     * Update Permission.
     *
     * @param array $params
     * @return Permission|null
     */
    public function update(array $params): ?Permission
    {
        $update = $this->getById($params['id']);

        $update->update($this->prepareDataForDB($params));

        return $update->refresh();
    }

    /**
     * Soft delete Permission.
     *
     * @param int $id
     * @return bool
     */
    public function softDelete(int $id): bool
    {

        $data = $this->getByID($id);

        return $data->delete();
    }

    /**
     * Force delete Permission on Database.
     *
     * @param int $id
     * @return bool
     */
    public function forceDelete(int $id): bool
    {

        $data = $this->getByID($id);

        return $data->forceDelete();
    }

    /**
     * Prepares data for database insertion/update.
     *
     * @param array $data Incoming data.
     * @param Permission|null $model Existing account model (optional).
     *
     * @return array Prepared data.
     */
    public function prepareDataForDB(array $data, ?Permission $model = null): array
    {

        $name = $data['name'] ?? $model->name;

        return [
            'name' => $name,
            'slug'    => Str::slug($name)
        ];
    }
}
