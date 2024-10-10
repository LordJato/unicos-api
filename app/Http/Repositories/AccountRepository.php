<?php

namespace App\Repositories;

use App\Models\Account;
use Exception;
use Illuminate\Http\Response;

class AccountRepository {

    public function getAll(object $request): array
    {
        $search = $request->get('search');

        //filters
        $offset = $request->has('offset') ? (int)$request->get('offset') : 0;
        $limit = $request->has('limit') ? (int)$request->get('limit') : 10;
        $orderBy =  $request->has('orderBy') ? $request->get('orderBy') : 'id';
        $orderDesc =  $request->get('orderDesc') === 'true' ? 'desc' : 'asc';

        //$page =  $request->has('page') ? ((int)$request->get('page') - 1) * $limit : 0;

        $accounts = Account::where(function ($q) use ($search) {
            if ($search) {
                $q->where('name', 'like', '%'. $search);
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

    public function getByID(int $id): ?Account
    {
        $account = Account::find($id);

        if (empty($account)) {
            throw new Exception("Account does not exist.", Response::HTTP_NOT_FOUND);
        }

        return $account;
    }

    public function create(array $params): Account
    {

        $data = [
            'name' => $params['name'],  
            'is_active' => $params['is_active'] ?? 0
        ];

        $create = Account::create($data);

        if (!$create) {
            throw new Exception("Could not create account, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $create->fresh();
    }

    public function update(int $id, array $params): ?Account
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