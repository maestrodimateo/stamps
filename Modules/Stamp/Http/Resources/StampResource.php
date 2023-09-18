<?php

namespace Modules\Stamp\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Admin\Http\Resources\UserResource;

class StampResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'qrcode' => asset($this->qrcode),
            'type' => TypeResource::make($this->whenLoaded('type')),
            'creator' => UserResource::make($this->whenLoaded('creator')),
        ];
    }
}
