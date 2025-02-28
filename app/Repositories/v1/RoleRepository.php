<?php

namespace App\Repositories\v1;

use Exception;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class RoleRepository
{

    /**
     * Get all Role.
     *
     * @param array $params
     * @return array
     */

    public function getAll(array $params): array
    {
        $search = $params['search'];

        $accounts = Role::when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
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
     * Get Role by ID.
     *
     * @param int $id
     * @return Role|null
     * @throws Exception
     */
    public function getById(int $id): ?Role
    {
        $data = Role::find($id);

        if (empty($data)) {
            throw new Exception("Role does not exist.", Response::HTTP_NOT_FOUND);
        }

        return $data;
    }

    /**
     * Create Role.
     *
     * @param array $params
     * @return Permission
     * @throws Exception
     */
    public function create(array $params): Role
    {

        $prepareData = $this->prepareDataForDB($params);

        $create = Role::create($prepareData);

        if (!$create) {
            throw new Exception("Could not create role, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $create->fresh();
    }

    /**
     * Update Role.
     *
     * @param int $id
     * @param array $params
     * @return Role|null
     */
    public function update($id, array $params): Role
    {
        $update = $this->getById($id);

        $update->update($this->prepareDataForDB($params, $update));

        return $update->refresh();
    }

    /**
     * Soft delete Role.
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
     * Force delete Role on Database.
     *
     * @param int $id
     * @return bool
     */
    public function forceDelete(int $id): bool
    {

        $data = $this->getById($id);

        return $data->forceDelete();
    }

    /**
     * Prepares data for database insertion/update.
     *
     * @param array $data Incoming data.
     * @param Role|null $model Existing account model (optional).
     *
     * @return array Prepared data.
     */
    public function prepareDataForDB(array $data, ?Role $model = null): array
    {
        $name = $data['name'] ?? $model->name;

        return [
            'name' => $name,
            'slug'    => Str::slug($name)
        ];
    }
}
