<?php

namespace App\Repositories\v1;

use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\Company;
use Illuminate\Http\Response;

class CompanyRepository
{
    /**
     * Get all Comapanies.
     *
     * @param array $params
     * @return array
     */
    public function getAll(array $params): array
    {
        $search = $params['search'];
        $dataIdFilter = getCurrentUser()->hasRolesTo('super-admin') ? $params['accountId'] ?? null : null;

        $data = Company::when($dataIdFilter, fn($query, $dataIdFilter) => $query->where('account_id', $dataIdFilter))
            ->when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
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
     * Get Company by ID.
     *
     * @param int $id
     * @return Company|null
     * @throws HttpException
     */
    public function getByID(int $id): ?Company
    {
        $data = Company::find($id);

        if (empty($data)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, "Company does not exist.");
        }

        return $data;
    }

    /**
     * Create Company.
     *
     * @param array $params
     * @return Company
     * @throws HttpException
     */
    public function create(array $params): Company
    {

        $data = $this->prepareDataForDB($params);

        $create = Company::create($data);

        if (!$create) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Could not create company, Please try again.");
        }

        return $create->fresh();
    }

    /**
     * Update Company.
     * 
     * @param int $id
     * @param array $params
     * @return Company|null
     */
    public function update(int $id, array $params): Company
    {
        $update = $this->getById($id);

        $update->update($this->prepareDataForDB($params, $update));

        return $update;
    }

    /**
     * Soft delete Company.
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
     * @param Company|null $model Existing account model (optional).
     *
     * @return array Prepared data.
     */
    public function prepareDataForDB(array $data, ?Company $model = null): array
    {
        return array_merge($model?->only([
            'name', 'address', 'city', 'province', 'postal', 'country',
            'email', 'phone', 'fax', 'tin', 'sss', 'philhealth', 'hdmf'
        ]) ?? [], $data);
    }
}
