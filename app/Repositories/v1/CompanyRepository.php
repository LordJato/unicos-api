<?php

namespace App\Repositories\v1;

use Exception;
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
        $accountIdFilter = getCurrentUser()->hasRolesTo('super-admin') ? $params['accountId'] ?? null : null;

        $accounts = Company::when($accountIdFilter, fn($query, $accountIdFilter) => $query->where('account_id', $accountIdFilter))
            ->when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
            ->orderBy($params['orderBy'], $params['orderDesc'])
            ->paginate($params['limit'], ['*'], 'page', floor($params['offset'] / $params['limit']) + 1);

        return [
            'total' => $accounts->total(),
            'records' => $accounts->items(),
            'offset' =>  $params['offset'],
            'limit' => $params['limit']
        ];
    }

    /**
     * Get Company by ID.
     *
     * @param int $id
     * @return Company|null
     * @throws Exception
     */
    public function getByID(int $id): ?Company
    {
        $data = Company::find($id);

        if (empty($data)) {
            throw new Exception("Company does not exist.", Response::HTTP_NOT_FOUND);
        }

        return $data;
    }

    /**
     * Create Company.
     *
     * @param array $params
     * @return Company
     * @throws Exception
     */
    public function create(array $params): Company
    {

        $data = $this->prepareDataForDB($params);

        $create = Company::create($data);

        if (!$create) {
            throw new Exception("Could not create company, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
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

        return $update->refresh();
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
        return [
            'name' =>  $data['name'] ?? $model->name,
            'address' => $data['address'] ?? $model->address,
            'city' => $data['city'] ?? $model->city,
            'province' => $data['province'] ?? $model->province,
            'postal' => $data['postal'] ?? $model->postal,
            'country' => $data['country'] ?? $model->country,
            'email' => $data['email'] ?? $model->email,
            'phone' => $data['phone'] ?? $model->phone,
            'fax' => $data['fax'] ?? $model->fax,
            'tin' => $data['tin'] ?? $model->tin,
            'sss' => $data['sss'] ?? $model->sss,
            'philhealth' => $data['philhealth'] ?? $model->philhealth,
            'hdmf' => $data['hdmf'] ?? $model->hdmf
        ];
    }
}
