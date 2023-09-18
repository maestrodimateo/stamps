<?php

namespace Modules\Admin\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'avatar' => fileUrl($this->avatar),
            'username' => $this->username,
            'password_changed' => $this->password_changed,
            'deleted_at' => $this->deleted_at,
            'last_login' => optional($this->last_login)->format('d/m/Y à H:i'),
            'person' => PersonResource::make($this->whenLoaded('person')),
            'permissions' => $this->when($this->permissions, $this->permissions),
            'role' => RoleResource::make($this->whenLoaded('role'))
        ];
    }
}
