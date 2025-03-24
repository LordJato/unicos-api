<?php

namespace App\Repositories\v1;

use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

        $data = Account::with('accountType')->when($search, fn($query, $search) => $query->where('name', 'like', $search . '%'))
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
     * Get Account by ID.
     *
     * @param int $id
     * @return Account|null
     * @throws HttpException
     */
    public function getByID(int $id): ?Account
    {
        $account = Account::find($id);

        if (empty($account)) {
            throw new HttpException(Response::HTTP_NOT_FOUND, "Account does not exist.");
        }

        return $account;
    }

    /**
     * Create Account.
     *
     * @param array $params
     * @return Account
     * @throws HttpException
     */
    public function create(array $params): Account
    {
        $data = $this->prepareDataForDB($params);

        $create = Account::create($data);

        if (!$create) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Could not create account, Please try again.");
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
            throw new HttpException(Response::HTTP_NOT_FOUND, "Account Type does not exist.");
        }
        return [
            'account_type_id' => $data['accountTypeId'] ?? $model->account_type_id,
            'name' => $data['name'] ?? $model->name,
        ];
    }

    /**
     * Get all Account Type.
     *
     */

    public function getAllAccountType(): Collection
    {
        return AccountType::all();
    }
}
