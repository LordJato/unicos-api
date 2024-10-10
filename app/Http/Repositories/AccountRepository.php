<?php

namespace App\Repositories;

use App\Models\Account;
use Exception;
use Illuminate\Http\Response;

class AccountRepository
{

    public function getAll(object $request): array
    {
        $search = $request->get('search');

        //filters
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);
        $orderBy = $request->input('orderBy', 'id');
        $orderDesc = $request->boolean('orderDesc') ? 'desc' : 'asc';

        $accounts = Account::when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
            ->orderBy($orderBy, $orderDesc)
            ->paginate($limit, ['*'], 'page', floor($offset / $limit) + 1);  // Paginate instead of limit/offset

        $data = [
            'total' => $accounts->total(),  // Total count is handled by paginate
            'records' => $accounts->items(), // Use items() for the current page records
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
