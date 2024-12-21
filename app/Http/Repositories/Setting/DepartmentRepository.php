<?php

namespace App\Http\Repositories\Setting;

use Exception;
use App\Models\Company;
use Illuminate\Http\Response;
use App\Models\Setting\Department;
use Illuminate\Support\Facades\Auth;

class DepartmentRepository
{

    public function getAll(object $request): array
    {
        $search = $request->get('search');

        //filters
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $orderBy = $request->input('orderBy', 'id');
        $orderDesc = $request->boolean('orderDesc') ? 'desc' : 'asc';
        $companyId = $request->input('company_id');

        $accounts = Department::where('company_id', $companyId)
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', $search . '%');
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
            throw new Exception("Department does not exist.", Response::HTTP_NOT_FOUND);
        }

        return $data;
    }

    public function create(array $data): Company
    {

        $data['account_id'] = Auth::user()->account_id;

        $company = $this->prepareDataForDB($data);

        $create = Company::create($company);

        if (!$create) {
            throw new Exception("Could not create department, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $create->fresh();
    }

    public function update(int $id, array $data)
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

    public function prepareDataForDB(array $data, ?Department $department = null ): array
    {
        return [
            'account_id' => $data['company_id'] ?? $department->company_id,
            'name' =>  $data['name'] ?? $department->name,
        ];
    }
}
