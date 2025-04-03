<?php

namespace App\Repositories\v1\HR\Employee;

use App\Models\HR\EmployeeEmergency;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EmployeeEmergencyRepository
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

        $data = EmployeeEmergency::when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
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
     * Get Employee Emergency by ID.
     *
     * @param int $id
     * @return EmployeePersonal|null
     * @throws HttpException
     */
    public function getByID(int $id): ?EmployeeEmergency
    {
        $data = EmployeeEmergency::find($id);

        if (empty($data)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, "Employee Emergency does not exist.");
        }

        return $data;
    }

    /**
     * Create Employee Emergency.
     *
     * @param array $params
     * @return EmployeePersonal
     * @throws EmployeeEmergency
     */
    public function create(array $params): EmployeeEmergency
    {

        $data = $this->prepareDataForDB($params);

        $create = EmployeeEmergency::create($data);

        if (!$create) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Could not create Employee Emergency, Please try again.");
        }

        return $create->fresh();
    }

    /**
     * Update Employee Emergency.
     *
     * @param int $id
     * @param array $params
     * @return EmployeeEmergency|null
     */
    public function update(int $id, array $params): EmployeeEmergency
    {
        $update = $this->getById($id);

        $update->update($this->prepareDataForDB($params, $update));

        return $update;
    }

    /**
     * Soft delete Employee Emergency.
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
     * @param EmployeeEmergency|null $model Existing account model (optional).
     *
     * @return array Prepared data.
     */
    public function prepareDataForDB(array $data, ?EmployeeEmergency $model = null): array
    {
        return [
            'title' =>  $data['title'] ?? $model->title,
            'description' => $data['description'] ?? $model->description,
            'slug' => $data['slug'] ?? $model->slug,
        ];
    }
}
