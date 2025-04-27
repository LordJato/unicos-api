<?php

namespace App\Repositories\v1\HR\Employee;

use App\Models\HR\EmployeeChildren;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ChildrenRepository
{
    /**
     * Get all Employee Children.
     *
     * @param array $params
     * @return array
     */


    public function getAll(array $params): array
    {
        $search = $params['search'];

        $data = EmployeeChildren::when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
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
     * Get Employee Children by ID.
     *
     * @param int $id
     * @return EmployeeChildren|null
     * @throws HttpException
     */
    public function getByID(int $id): ?EmployeeChildren
    {
        $data = EmployeeChildren::find($id);

        if (empty($data)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, "Employee Children does not exist.");
        }

        return $data;
    }

    /**
     * Create Employee Children.
     *
     * @param array $params
     * @return EmployeeChildren
     * @throws HttpException
     */
    public function create(array $params): EmployeeChildren
    {

        $data = $this->prepareDataForDB($params);

        $create = EmployeeChildren::create($data);

        if (!$create) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Could not create Employee Children, Please try again.");
        }

        return $create->fresh();
    }

    /**
     * Update Employee Children.
     *
     * @param int $id
     * @param array $params
     * @return EmployeeChildren|null
     */
    public function update(int $id, array $params): ?EmployeeChildren
    {
        $update = $this->getById($id);

        $update->update($this->prepareDataForDB($params, $update));

        return $update;
    }

    /**
     * Soft delete Employee Children.
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
     * @param EmployeeChildren|null $model Existing account model (optional).
     *
     * @return array Prepared data.
     */
    public function prepareDataForDB(array $data, ?EmployeeChildren $model = null): array
    {
        return [
            'title' =>  $data['title'] ?? $model->title,
            'description' => $data['description'] ?? $model->description,
            'slug' => $data['slug'] ?? $model->slug,
        ];
    }
}
