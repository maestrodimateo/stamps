<?php

namespace Modules\Admin\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Core\Http\Resources\GeoEntityResource;

class PersonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'firstname' => $this->firstname,
            'maiden_name' => $this->maiden_name,
            'birthdate' => $this->birthdate->format('d/m/Y'),
            'gender' => $this->gender,
            'phone' => $this->phone,
            'birthplace' => GeoEntityResource::make($this->whenLoaded('birthplace')),
        ];
    }
}
