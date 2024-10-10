<?php

namespace App\Http\Repositories;

use App\Helpers\Message;
use App\Models\Company;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class CompanyRepository {
    public function getAll(object $request): array
    {

        if(!Gate::allows('view-all-company')){
            throw new Exception(Message::FORBIDDEN, Response::HTTP_FORBIDDEN);
        }

        $search = $request->get('search');

        //filters
        $offset = $request->has('offset') ? (int)$request->get('offset') : 0;
        $limit = $request->has('limit') ? (int)$request->get('limit') : 10;
        $orderBy =  $request->has('orderBy') ? $request->get('orderBy') : 'id';
        $orderDesc =  $request->get('orderDesc') === 'true' ? 'desc' : 'asc';

        //$page =  $request->has('page') ? ((int)$request->get('page') - 1) * $limit : 0;

        $accounts = Company::where(function ($q) use ($search) {
            if ($search) {
                $q->where('name', 'like', searchString($search));
            }
        })
            ->limit($limit)                                           
            ->offset($offset) 
            ->orderBy($orderBy, $orderDesc)
            ->get();

        $data = [
            'total' => count($accounts),
            'records' => $accounts,
            'offset' => $offset,
            'limit' => $limit
        ];

        return $data;
    }

    public function getByID(int $id): ?Company
    {

        if(!Gate::allows('view-company')){
            throw new Exception(Message::FORBIDDEN, Response::HTTP_FORBIDDEN);
        }

        $account = Company::find($id);

        if (empty($account)) {
            throw new Exception("Account does not exist.", Response::HTTP_NOT_FOUND);
        }

        return $account;
    }

    public function create(array $params): Company
    {

        if(!Gate::allows('create-company')){
            throw new Exception("This action is Unauthorized", Response::HTTP_UNAUTHORIZED);
        }

        $data = [
            'account_id' => $params['account_id'] ?? NULL,
            'name' => $params['name'],
            'address' => $params['address'],
            'city' => $params['city'],
            'province' => $params['province'],
            'postal' => $params['postal'],
            'country' => $params['country'],
            'email' => $params['email'],
            'phone' => $params['phone'],
            'fax' => $params['fax'],
            'TIN' => $params['TIN'],
            'SSS' => $params['SSS'],
            'PhilHealth' => $params['PhilHealth'],
            'HDMF' => $params['HDMF'],
            'work_hrs_per_day' => $params['work_hrs_per_day'],
            'is_active' => $params['is_active'] ?? 0
        ];

        $create = Company::create($data);

        if (!$create) {
            throw new Exception("Could not create company, Please try again.", 500);
        }

        return $create->fresh();
    }

    public function update(int $id, array $params): ?Company
    {
        $account = $this->getById($id);

        $account->name = $params['name'];
        $account->is_active = $params['is_active'];
        
        if ($account->save()) {
            $account = $this->getById($id);
        }

        return $account;
    }
}