<?php

namespace App\Repositories\v1\Recruitment\Opportunity;

use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\Recruitment\OpportunityRequirement;
use Illuminate\Http\Response;

class RequirementRepository
{
    /**
     * Get all Employee.
     *
     * @param array $params
     * @return array
     */


    public function getAll(array $params): array
    {
        $search = $params['search'];

        $data = OpportunityRequirement::when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
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
     * Get Opportunity Requirement by ID.
     *
     * @param int $id
     * @return OpportunityRequirement|null
     * @throws Exception
     */
    public function getByID(int $id): ?OpportunityRequirement
    {
        $data = OpportunityRequirement::find($id);

        if (empty($data)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, "Opportunity Requirement does not exist.");
        }

        return $data;
    }

    /**
     * Create Opportunity Requirement.
     *
     * @param array $params
     * @return OpportunityRequirement
     * @throws Exception
     */
    public function create(array $params): OpportunityRequirement
    {

        $data = $this->prepareDataForDB($params);

        $create = OpportunityRequirement::create($data);

        if (!$create) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Could not create Opportunity Requirement, Please try again.");
        }

        return $create->fresh();
    }

    /**
     * Update Opportunity Requirement.
     *
     * @param int $id
     * @param array $params
     * @return OpportunityRequirement|null
     */
    public function update(int $id, array $params): OpportunityRequirement
    {
        $update = $this->getById($id);

        $update->update($this->prepareDataForDB($params, $update));

        return $update->refresh();
    }

    /**
     * Soft delete Opportunity Requirement.
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
     * Force delete Opportunity Requirement.
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
     * @param OpportunityRequirement|null $model Existing account model (optional).
     *
     * @return array Prepared data.
     */
    public function prepareDataForDB(array $data, ?OpportunityRequirement $model = null): array
    {
        return [
            'job_id' =>  $data['JobId'] ?? $model->job_id,
            'description' =>  $data['description'] ?? $model->description,
        ];
    }
}
