<?php

namespace App\Http\Repositories;

use Exception;
use App\Models\Company;
use Illuminate\Http\Response;

class CompanyRepository
{

    public function getAll(object $request): array
    {
        $search = $request->get('search');

        //filters
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $orderBy = $request->input('orderBy', 'id');
        $orderDesc = $request->boolean('orderDesc') ? 'desc' : 'asc';

        $accounts = Company::when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
            ->orderBy($orderBy, $orderDesc)
            ->paginate($limit, ['*'], 'page', floor($offset / $limit) + 1);

        $data = [
            'total' => $accounts->total(),
            'records' => $accounts->items(),
            'offset' => $offset,
            'limit' => $limit
        ];

        return $data;
    }

    public function getByID(int $id): ?Company
    {
        $data = Company::find($id);

        if (empty($data)) {
            throw new Exception("Company does not exist.", Response::HTTP_NOT_FOUND);
        }

        return $data;
    }

    public function create(array $data): Company
    {

        $company = $this->prepareDataForDB($data);

        $create = Company::create($company);

        if (!$create) {
            throw new Exception("Could not create company, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $create->fresh();
    }

    public function update(int $id, array $data) : Company
    {
        $update = $this->getById($id);
        
        $update->update($this->prepareDataForDB($data, $update));

        return $update->refresh();
    }

    public function softDelete(int $id): bool
    {

        $data = $this->getByID($id);

        return $data->delete();
    }

    public function prepareDataForDB(array $data, ?Company $company = null ): array
    {
        return [
            'account_id' => $data['account_id'] ?? $company->account_id ?? null,
            'name' =>  $data['name'] ?? $company->name,
            'address' => $data['address'] ?? $company->address,
            'city' => $data['city'] ?? $company->city,
            'province' => $data['province'] ?? $company->province,
            'postal' => $data['postal'] ?? $company->postal,
            'country' => $data['country'] ?? $company->country,
            'email' => $data['email'] ?? $company->email,
            'phone' => $data['phone'] ?? $company->phone,
            'fax' => $data['fax'] ?? $company->fax,
            'tin' => $data['tin'] ?? $company->tin,
            'sss' => $data['sss'] ?? $company->sss,
            'philhealth' => $data['philhealth'] ?? $company->philhealth,
            'hdmf' => $data['hdmf'] ?? $company->hdmf
        ];
    }
}
