<?php

namespace App\Repositories\v1\Recruitment;

use Exception;
use App\Models\Recruitment\OpportunityResponsibility;
use Illuminate\Http\Response;

class OpportunityResponsibilityRepository
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

        $accounts = OpportunityResponsibility::when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
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
     * Get Opportunity Responsibility by ID.
     *
     * @param int $id
     * @return OpportunityResponsibility|null
     * @throws Exception
     */
    public function getByID(int $id): ?OpportunityResponsibility
    {
        $data = OpportunityResponsibility::find($id);

        if (empty($data)) {
            throw new Exception("Opportunity Responsibility does not exist.", Response::HTTP_NOT_FOUND);
        }

        return $data;
    }

    /**
     * Create Opportunity Responsibility.
     *
     * @param array $params
     * @return OpportunityResponsibility
     * @throws Exception
     */
    public function create(array $params): OpportunityResponsibility
    {

        $data = $this->prepareDataForDB($params);

        $create = OpportunityResponsibility::create($data);

        if (!$create) {
            throw new Exception("Could not create Opportunity Responsibility, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $create->fresh();
    }

    /**
     * Update Opportunity Responsibility.
     *
     * @param array $params
     * @return OpportunityResponsibility|null
     */
    public function update(array $params): OpportunityResponsibility
    {
        $update = $this->getById($params['id']);

        $update->update($this->prepareDataForDB($params, $update));

        return $update->refresh();
    }

    /**
     * Soft delete Opportunity Responsibility.
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
     * @param OpportunityResponsibility|null $model Existing account model (optional).
     *
     * @return array Prepared data.
     */
    public function prepareDataForDB(array $data, ?OpportunityResponsibility $model = null): array
    {
        return [
            'job_id' =>  $data['JobId'] ?? $model->job_id,
            'description' =>  $data['description'] ?? $model->description,
        ];
    }
}
