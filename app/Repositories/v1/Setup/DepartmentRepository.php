<?php

namespace App\Repositories\v1\Setup;

use Illuminate\Http\Response;
use App\Models\Setup\Department;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DepartmentRepository
{

    /**
     * Get all Department.
     *
     * @param array $params
     * @return array
     */
    public function getAll(array $params): array
    {
        $search = $params['search'];

        $data = Department::when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
            ->orderBy($params['orderBy'], $params['orderDesc'])
            ->paginate($params['limit'], ['*'], 'page', floor($params['offset'] / $params['limit']) + 1);

        return [
            'total' => $data->total(),
            'records' => $data->items(),
            'offset' =>  $params['offset'],
            'limit' => $params['limit']
        ];
    }

    /**
     * Get Department by ID.
     *
     * @param int $id
     * @return Department|null
     * @throws HttpException
     */
    public function getByID(int $id = 0): ?Department
    {

        $data = Department::find($id);

        if (empty($data)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, "Department does not exist.");
        }

        return $data;
    }

    /**
     * Create Department.
     *
     * @param array $params
     * @return Department
     * @throws HttpException
     */
    public function create(array $params): Department
    {
        $data = $this->prepareDataForDB($params);

        $create = Department::create($data);

        if (!$create) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Could not create department, Please try again.");
        }

        return $create->fresh();
    }

    /**
     * Update Department.
     *
     * @param int $id
     * @param array $params
     * @return Department|null
     */
    public function update(int $id, array $params): ?Department
    {
        $update = $this->getById($id);

        $update->update($this->prepareDataForDB($params, $update));

        return $update->refresh();
    }

    /**
     * Soft delete Department.
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
     * Prepares data for database insertion/update.
     *
     * @param array $data Incoming data.
     * @param Department|null $model Existing account model (optional).
     *
     * @return array Prepared data.
     */
    public function prepareDataForDB(array $data, ?Department $model = null): array
    {
        $currentUser = getCurrentUser();
        $companyId = $data['companyId'] ?? $model->company_id ?? $currentUser->company_id;

        if (!$companyId) {
            throw new HttpException(Response::HTTP_NOT_FOUND, "Company id not found.");
        }

        //check if name exist in company
        return [
            'company_id' => $companyId,
            'name' =>  $data['name'] ?? $model->name,
        ];
    }
}
