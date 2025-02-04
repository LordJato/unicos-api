<?php

namespace App\Http\Repositories;

use Exception;
use App\Models\Account;
use App\Enums\AccountType;
use Illuminate\Http\Response;

class AccountRepository
{
    /**
     * Get all Accounts.
     *
     * @param array $params
     * @return array
     */

    public function getAll(array $params): array
    {
        $search = $params['search'];

        $accounts = Account::when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
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
     * Get Account by ID.
     *
     * @param int $id
     * @return Account|null
     * @throws Exception
     */
    public function getByID(int $id): ?Account
    {
        $account = Account::find($id);

        if (empty($account)) {
            throw new Exception("Account does not exist.", Response::HTTP_NOT_FOUND);
        }

        return $account;
    }

    /**
     * Create Account.
     *
     * @param array $params
     * @return Account
     * @throws Exception
     */
    public function create(array $params): Account
    {
        $data = $this->prepareDataForDB($params);

        $create = Account::create($data);

        if (!$create) {
            throw new Exception("Could not create account, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $create->fresh();
    }

    /**
     * Update Account.
     *
     * @param int $id
     * @param array $params
     * @return Account|null
     */
    public function update(int $id, array $params): ?Account
    {
        $update = $this->getById($id);

        $update->update($this->prepareDataForDB($params, $update));

        return $update->refresh();
    }

    /**
     * Soft delete Account.
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
     * @param Account|null $model Existing account model (optional).
     *
     * @return array Prepared data.
     */
    public function prepareDataForDB(array $data, ?Account $model = null): array
    {
        if (!enum_exists(AccountType::class, $data['accountTypeId'] ?? $model->account_type_id)) {
            throw new Exception("Account Type does not exist.", Response::HTTP_NOT_FOUND);
        }
        return [
            'account_type_id' => $data['accountTypeId'] ?? $model->account_type_id,
            'name' => $data['name'] ?? $model->name,
        ];
    }
}
