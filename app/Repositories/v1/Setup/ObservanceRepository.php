<?php

namespace App\Repositories\v1\Setup;

use Exception;
use App\Enums\ObservanceType;
use Illuminate\Http\Response;
use App\Models\Setup\Observance;

class ObservanceRepository
{

    /**
     * Get all Observance.
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

        $accounts = Observance::when($search, fn($query, $search) => $query->where('title', 'like', $search . '%'))
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
     * @return Observance|null
     * @throws Exception
     */
    public function getByID(int $id = 0): ?Observance
    {

        $data = Observance::find($id);

        if (empty($data)) {
            throw new Exception("Observance does not exist.", Response::HTTP_NOT_FOUND);
        }

        return $data;
    }

    /**
     * Create Observance.
     *
     * @param array $params
     * @return Observance
     * @throws Exception
     */
    public function create(array $params): Observance
    {
        $data = $this->prepareDataForDB($params);

        $create = Observance::create($data);

        if (!$create) {
            throw new Exception("Could not create observance, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $create->fresh();
    }

    /**
     * Update Observance.
     *
     * @param array $params
     * @return Observance|null
     */
    public function update(array $params): ?Observance
    {
        $update = $this->getById($params['id']);

        $update->update($this->prepareDataForDB($params, $update));

        return $update->refresh();
    }

    /**
     * Soft delete Observance.
     *
     * @param array $params
     * @return bool
     */
    public function softDelete(array $params): bool
    {
        $data = $this->getByID($params['id']);

        return $data->delete();
    }

    /**
     * Prepares data for database insertion/update.
     *
     * @param array $data Incoming data.
     * @param Observance|null $model Existing account model (optional).
     *
     * @return array Prepared data.
     */
    public function prepareDataForDB(array $data, ?Observance $model = null): array
    {
        $observanceTypeId = $data['observanceTypeId'] ?? $model->observance_type_id;

        throw new Exception("Please enter correct observance type", Response::HTTP_NOT_FOUND);

        //check if name exist in company
        return [
            'observance_type_id' => $observanceTypeId,
            'title' =>  $data['title'] ?? $model->title,
            'description' =>  $data['description'] ?? $model->description,
            'start_date' =>  $data['startDate'] ?? $model->_start_date,
            'end_date' =>  $data['endDate'] ?? $model->end_date,
        ];
    }
}
