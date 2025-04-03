<?php

namespace App\Repositories\v1\HR\Employee;

use App\Models\HR\EmployeePersonal;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EmployeePersonalRepository
{
    /**
     * Get all Employee Personal.
     *
     * @param array $params
     * @return array
     */


    public function getAll(array $params): array
    {
        $search = $params['search'];

        $data = EmployeePersonal::when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
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
     * Get Employee Personal by ID.
     *
     * @param int $id
     * @return EmployeePersonal|null
     * @throws HttpException
     */
    public function getByID(int $id): ?EmployeePersonal
    {
        $data = EmployeePersonal::find($id);

        if (empty($data)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, "Employee Personal does not exist.");
        }

        return $data;
    }

    /**
     * Create Employee Personal.
     *
     * @param array $params
     * @return EmployeePersonal
     * @throws HttpException
     */
    public function create(array $params): EmployeePersonal
    {

        $data = $this->prepareDataForDB($params);

        $create = EmployeePersonal::create($data);

        if (!$create) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Could not create Employee Personal, Please try again.");
        }

        return $create->fresh();
    }

    /**
     * Update Employee Personal.
     *
     * @param int $id
     * @param array $params
     * @return EmployeePersonal|null
     */
    public function update(int $id, array $params): EmployeePersonal
    {
        $update = $this->getById($id);

        $update->update($this->prepareDataForDB($params, $update));

        return $update;
    }

    /**
     * Soft delete Employee Personal.
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
     * @param EmployeePersonal|null $model Existing account model (optional).
     *
     * @return array Prepared data.
     */
    public function prepareDataForDB(array $data, ?EmployeePersonal $model = null): array
    {
        return [
            'title' =>  $data['title'] ?? $model->title,
            'description' => $data['description'] ?? $model->description,
            'slug' => $data['slug'] ?? $model->slug,
        ];
    }
}
