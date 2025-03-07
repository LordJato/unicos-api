<?php

namespace App\Repositories\v1\Recruitment;

use App\Models\Recruitment\Opportunity;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OpportunityRepository
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

        $data = Opportunity::when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
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
     * Get Opportunity by ID.
     *
     * @param int $id
     * @return OpportunityResponsibility|null
     * @throws HttpException
     */
    public function getByID(int $id): ?Opportunity
    {
        $data = Opportunity::find($id);

        if (empty($data)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, "Opportunity does not exist.");
        }

        return $data;
    }

    /**
     * Create Opportunity.
     *
     * @param array $params
     * @return Opportunity
     * @throws Exception
     */
    public function create(array $params): Opportunity
    {

        $data = $this->prepareDataForDB($params);

        $create = Opportunity::create($data);

        if (!$create) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Could not create Opportunity, Please try again.");
        }

        return $create->fresh();
    }

    /**
     * Update Opportunity.
     *
     * @param array $params
     * @return Opportunity|null
     */
    public function update(array $params): Opportunity
    {
        $update = $this->getById($params['id']);

        $update->update($this->prepareDataForDB($params, $update));

        return $update->refresh();
    }

    /**
     * Soft delete Opportunity.
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
     * @param Opportunity|null $model Existing account model (optional).
     *
     * @return array Prepared data.
     */
    public function prepareDataForDB(array $data, ?Opportunity $model = null): array
    {
        return [
            'job_id' =>  $data['JobId'] ?? $model->job_id,
            'description' =>  $data['description'] ?? $model->description,
        ];
    }
}
