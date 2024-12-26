<?php

namespace App\Http\Repositories\HR;

use Exception;
use App\Models\HR\Employee;
use Illuminate\Http\Response;

class EmployeeRepository
{
    /**
     * Get all Employee.
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

        $accounts = Employee::when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
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
     * Get Employee by ID.
     *
     * @param int $id
     * @return Employee|null
     * @throws Exception
     */
    public function getByID(int $id): ?Employee
    {
        $data = Employee::find($id);

        if (empty($data)) {
            throw new Exception("Employee does not exist.", Response::HTTP_NOT_FOUND);
        }

        return $data;
    }

    /**
     * Create Employee.
     *
     * @param array $params
     * @return Employee
     * @throws Exception
     */
    public function create(array $params): Employee
    {

        $data = $this->prepareDataForDB($params);

        $create = Employee::create($data);

        if (!$create) {
            throw new Exception("Could not create employee, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $create->fresh();
    }

    /**
     * Update Employee.
     *
     * @param int $id
     * @param array $params
     * @return Employee|null
     */
    public function update(int $id, array $params): Employee
    {
        $update = $this->getById($id);

        $update->update($this->prepareDataForDB($params, $update));

        return $update->refresh();
    }

    /**
     * Soft delete Employee.
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
    public function prepareDataForDB(array $data, ?Employee $model = null): array
    {
        return [
            'name' =>  $data['name'] ?? $model->name,
            'address' => $data['address'] ?? $model->address,
            'city' => $data['city'] ?? $model->city,
            'province' => $data['province'] ?? $model->province,
            'postal' => $data['postal'] ?? $model->postal,
            'country' => $data['country'] ?? $model->country,
            'email' => $data['email'] ?? $model->email,
            'phone' => $data['phone'] ?? $model->phone,
            'fax' => $data['fax'] ?? $model->fax,
            'tin' => $data['tin'] ?? $model->tin,
            'sss' => $data['sss'] ?? $model->sss,
            'philhealth' => $data['philhealth'] ?? $model->philhealth,
            'hdmf' => $data['hdmf'] ?? $model->hdmf
        ];
    }
}
