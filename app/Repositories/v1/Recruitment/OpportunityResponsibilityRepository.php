<?php

namespace App\Repositories\v1\Recruitment;

use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\Recruitment\OpportunityResponsibility;
use Illuminate\Http\Response;

class OpportunityResponsibilityRepository
{
    /**
     * Get all Opportunity Responsibility.
     *
     * @param array $params
     * @return array
     */


    public function getAll(array $params): array
    {
        $search = $params['search'];

        $data = OpportunityResponsibility::when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
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
     * Get Opportunity Responsibility by ID.
     *
     * @param int $id
     * @return OpportunityResponsibility|null
     * @throws HttpException
     */
    public function getByID(int $id): ?OpportunityResponsibility
    {
        $data = OpportunityResponsibility::find($id);

        if (empty($data)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, "Opportunity Responsibility does not exist.");
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
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Could not create Opportunity Responsibility, Please try again.");
        }

        return $create->fresh();
    }

    /**
     * Update Opportunity Responsibility.
     *
     * @param int $id
     * @param array $params
     * @return OpportunityResponsibility|null
     */
    public function update(int $id, array $params): OpportunityResponsibility
    {
        $update = $this->getById($id);

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
     * Soft delete Opportunity Responsibility.
     *
     * @param int $id
     * @return bool
     */
    public function forceDelete(int $id): bool
    {

        $data = $this->getByID($id);

        return $data->forceDelete();
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
