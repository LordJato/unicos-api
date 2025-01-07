<?php

namespace App\Http\Repositories\Setting;

use Exception;
use App\Models\Company;
use Illuminate\Http\Response;
use App\Models\Setting\Department;
use Illuminate\Support\Facades\Auth;

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
        $search = $params['search'] ?? null;
        $offset = $params['offset'] ?? 0;
        $limit = $params['limit'] ?? 10;
        $orderBy = $params['orderBy'] ?? 'id';
        $orderDesc =  ($params['orderDesc'] ?? false) ? 'desc' : 'asc';

        $accounts = Department::when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
            ->orderBy($orderBy, $orderDesc)
            ->paginate($limit, ['*'], 'page', floor($offset / $limit) + 1);

        return [
            'total' => $accounts->total(),
            'records' => $accounts->items(),
            'offset' => $offset,
            'limit' => $limit
        ];
    }

    /**
     * Get Department by ID.
     *
     * @param int $id
     * @return Department|null
     * @throws Exception
     */
    public function getByID(int $id = 0): ?Department
    {

        $data = Department::find($id);

        if (empty($data)) {
            throw new Exception("Department does not exist.", Response::HTTP_NOT_FOUND);
        }

        return $data;
    }

    /**
     * Create Department.
     *
     * @param array $params
     * @return Department
     * @throws Exception
     */
    public function create(array $params): Department
    {
        $data = $this->prepareDataForDB($params);

        $create = Department::create($data);

        if (!$create) {
            throw new Exception("Could not create department, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $create->fresh();
    }

    /**
     * Update Department.
     *
     * @param array $params
     * @return Department|null
     */
    public function update(array $params): ?Department
    {
        $update = $this->getById($params['id']);

        $update->update($this->prepareDataForDB($params, $update));

        return $update->refresh();
    }

    /**
     * Soft delete Department.
     *
     * @param int $id
     * @return bool
     */
    public function softDelete(int $id, int $companyId): bool
    {

        $data = $this->getByID($id, $companyId);

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
            throw new Exception("Company id not found.", Response::HTTP_NOT_FOUND);
        }

        //check if name exist in company
        return [
            'company_id' => $companyId,
            'name' =>  $data['name'] ?? $model->name,
        ];
    }
}
