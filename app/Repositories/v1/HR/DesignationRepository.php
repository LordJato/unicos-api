<?php

namespace App\Repositories\v1\HR;

use App\Models\HR\Designation;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DesignationRepository
{
    /**
     * Get all Designation.
     *
     * @param array $params
     * @return array
     */


    public function getAll(array $params): array
    {
        $search = $params['search'];

        $data = Designation::when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
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
     * Get Designation by ID.
     *
     * @param int $id
     * @return Designation|null
     * @throws HttpException
     */
    public function getByID(int $id): ?Designation
    {
        $data = Designation::find($id);

        if (empty($data)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, "Designation does not exist.");
        }

        return $data;
    }

    /**
     * Create Designation.
     *
     * @param array $params
     * @return Designation
     * @throws HttpException
     */
    public function create(array $params): Designation
    {

        $data = $this->prepareDataForDB($params);

        $create = Designation::create($data);

        if (!$create) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Could not create Designation, Please try again.");
        }

        return $create->fresh();
    }

    /**
     * Update Designation.
     *
     * @param int $id
     * @param array $params
     * @return Designation|null
     */
    public function update(int $id, array $params): Designation
    {
        $update = $this->getById($id);

        $update->update($this->prepareDataForDB($params, $update));

        return $update;
    }

    /**
     * Soft delete Designation.
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
     * @param Designation|null $model Existing account model (optional).
     *
     * @return array Prepared data.
     */
    public function prepareDataForDB(array $data, ?Designation $model = null): array
    {
        return [
            'title' =>  $data['title'] ?? $model->title,
            'description' => $data['description'] ?? $model->description,
            'slug' => $data['slug'] ?? $model->slug,
        ];
    }
}
