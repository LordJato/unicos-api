<?php

namespace App\Repositories\v1\Setup;

use App\Models\Setup\CompanyEvent;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;


class CompanyEventRepository
{

    /**
     * Get all CompanyEvent.
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

        $accounts = CompanyEvent::when($search, fn($query, $search) => $query->where('title', 'like', $search . '%'))
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
     * Get CompanyEvent by ID.
     *
     * @param int $id
     * @return CompanyEvent|null
     * @throws HttpException
     */
    public function getByID(int $id = 0): ?CompanyEvent
    {

        $data = CompanyEvent::find($id);

        if (empty($data)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, "Company event does not exist.");
        }

        return $data;
    }

    /**
     * Create CompanyEvent.
     *
     * @param array $params
     * @return CompanyEvent
     * @throws HttpException
     */
    public function create(array $params): CompanyEvent
    {
        $data = $this->prepareDataForDB($params);

        $create = CompanyEvent::create($data);

        if (!$create) {
            throw new HttpException("Could not create company event, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $create->fresh();
    }

    /**
     * Update Company Event.
     *
     * @param int $id
     * @param array $params
     * @return CompanyEvent|null
     */
    public function update(int $id, array $params): ?CompanyEvent
    {
        $update = $this->getById($id);

        $update->update($this->prepareDataForDB($params, $update));

        return $update->refresh();
    }

    /**
     * Soft delete CompanyEvent.
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
     * @param CompanyEvent|null $model Existing account model (optional).
     *
     * @return array Prepared data.
     */
    public function prepareDataForDB(array $data, ?CompanyEvent $model = null): array
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
