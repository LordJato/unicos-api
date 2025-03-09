<?php

namespace App\Repositories\v1\Setup;

use App\Models\Setup\Holiday;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;


class HolidayRepository
{

    /**
     * Get all Holiday.
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

        $accounts = Holiday::when($search, fn($query, $search) => $query->where('title', 'like', $search . '%'))
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
     * Get Holiday by ID.
     *
     * @param int $id
     * @return Holiday|null
     * @throws HttpException
     */
    public function getByID(int $id = 0): ?Holiday
    {

        $data = Holiday::find($id);

        if (empty($data)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, "Holiday does not exist.");
        }

        return $data;
    }

    /**
     * Create Holiday.
     *
     * @param array $params
     * @return Holiday
     * @throws HttpException
     */
    public function create(array $params): Holiday
    {
        $data = $this->prepareDataForDB($params);

        $create = Holiday::create($data);

        if (!$create) {
            throw new HttpException("Could not create holiday, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $create->fresh();
    }

    /**
     * Update Holiday.
     *
     * @param int $id
     * @param array $params
     * @return Holiday|null
     */
    public function update(int $id, array $params): ?Holiday
    {
        $update = $this->getById($id);

        $update->update($this->prepareDataForDB($params, $update));

        return $update->refresh();
    }

    /**
     * Soft delete Holiday.
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
     * @param Holiday|null $model Existing account model (optional).
     *
     * @return array Prepared data.
     */
    public function prepareDataForDB(array $data, ?Holiday $model = null): array
    {

        //check if name exist in company
        return [
            'title' =>  $data['title'] ?? $model->title,
            'description' =>  $data['description'] ?? $model->description,
            'start_date' =>  $data['startDate'] ?? $model->_start_date,
            'end_date' =>  $data['endDate'] ?? $model->end_date,
        ];
    }
}
