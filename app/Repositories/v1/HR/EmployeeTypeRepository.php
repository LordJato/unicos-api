<?php

namespace App\Repositories\v1\HR;

use App\Models\HR\EmployeeType;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EmployeeTypeRepository
{
    /**
     * Get all Employee Type.
     *
     * @param array $params
     * @return array
     */


    public function getAll(array $params): array
    {
        $search = $params['search'];

        $data = EmployeeType::when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
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
     * Get Employee Type by ID.
     *
     * @param int $id
     * @return EmployeeType|null
     * @throws HttpException
     */
    public function getByID(int $id): ?EmployeeType
    {
        $data = EmployeeType::find($id);

        if (empty($data)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, "Employee Type does not exist.");
        }

        return $data;
    }

    /**
     * Create EmployeeType.
     *
     * @param array $params
     * @return EmployeeType
     * @throws HttpException
     */
    public function create(array $params): EmployeeType
    {

        $data = $this->prepareDataForDB($params);

        $create = EmployeeType::create($data);

        if (!$create) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Could not create Employee Type, Please try again.");
        }

        return $create->fresh();
    }

    /**
     * Update Employee Type.
     *
     * @param int $id
     * @param array $params
     * @return EmployeeType|null
     */
    public function update(int $id, array $params): ?EmployeeType
    {
        $update = $this->getById($id);

        $update->update($this->prepareDataForDB($params, $update));

        return $update;
    }

    /**
     * Soft delete Employee Type.
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
     * @param EmployeeType|null $model Existing account model (optional).
     *
     * @return array Prepared data.
     */
    public function prepareDataForDB(array $data, ?EmployeeType $model = null): array
    {
        return [
            'account_id' =>  $data['account_id'] ?? $model->account_id,
            'name' => $data['name'] ?? $model->name,
            'grace_period' => $data['grace_period'] ?? $model->grace_period,
            'lunch_break' => $data['lunch_break'] ?? $model->lunch_break,
        ];
    }
}
