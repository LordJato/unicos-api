<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userRoles = $this->roles->pluck('slug');
        $userPermissions = $this->permissions->pluck('slug');

        return [
            "email" => $this->email,
            "account_id" => $this->account_id,
            "company_id" => $this->company_id,
            "created_at" => $this->created_at->format('Y-m-d'),
            "roles" => $userRoles,
            "permissions" => $userPermissions,
        ];
    }
}
