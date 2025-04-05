<?php

namespace App\Repositories\v1\Recruitment;

use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\Recruitment\OpportunityBenefit;
use Illuminate\Http\Response;

class OpportunityBenefitRepository
{
    /**
     * Get all Opportunity Benefit.
     *
     * @param array $params
     * @return array
     */


    public function getAll(array $params): array
    {
        $search = $params['search'];

        $data = OpportunityBenefit::when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
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
     * Get Opportunity Benefit by ID.
     *
     * @param int $id
     * @return OpportunityBenefit|null
     * @throws HttpException
     */
    public function getByID(int $id): ?OpportunityBenefit
    {
        $data = OpportunityBenefit::find($id);

        if (empty($data)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, "Opportunity Responsibility does not exist.");
        }

        return $data;
    }

    /**
     * Create Opportunity Benefit.
     *
     * @param array $params
     * @return OpportunityBenefit
     * @throws HttpException
     */
    public function create(array $params): OpportunityBenefit
    {

        $data = $this->prepareDataForDB($params);

        $create = OpportunityBenefit::create($data);

        if (!$create) {
            throw new HttpException("Could not create Opportunity Responsibility, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $create->fresh();
    }

    /**
     * Update Opportunity Benefit.
     *
     * @param array $params
     * @return OpportunityBenefit
     */
    public function update(int $id, array $params): OpportunityBenefit
    {
        $update = $this->getById($id);

        $update->update($this->prepareDataForDB($params, $update));

        return $update->refresh();
    }

    /**
     * Soft delete Opportunity Benefit.
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
     * Force delete Opportunity Benefit.
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
     * @param OpportunityBenefit|null $model Existing account model (optional).
     *
     * @return array Prepared data.
     */
    public function prepareDataForDB(array $data, ?OpportunityBenefit $model = null): array
    {
        return [
            'job_id' =>  $data['JobId'] ?? $model->job_id,
            'description' =>  $data['description'] ?? $model->description,
        ];
    }
}
