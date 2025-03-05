<?php

namespace App\Repositories\v1\HR;

use App\Models\HR\Employee;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        $search = $params['search'];

        $accounts = Employee::when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
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
     * Get Employee by ID.
     *
     * @param int $id
     * @return Employee|null
     * @throws HttpException
     */
    public function getByID(int $id): ?Employee
    {
        $data = Employee::find($id);

        if (empty($data)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, "Employee does not exist.");
        }

        return $data;
    }

    /**
     * Create Employee.
     *
     * @param array $params
     * @return Employee
     * @throws HttpException
     */
    public function create(array $params): Employee
    {

        $data = $this->prepareDataForDB($params);

        $create = Employee::create($data);

        if (!$create) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Could not create employee, Please try again.");
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
