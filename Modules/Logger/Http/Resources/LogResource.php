<?php

namespace Modules\Logger\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
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
            'ip' => $this->when(auth()->user()->roleIs('superadmin'), $this->ip),
            'author_id' => $this->when(auth()->user()->roleIs('superadmin'), $this->author_id),
            'action' => $this->action,
            'description' => $this->description,
            'user_agent' => $this->when(auth()->user()->roleIs('superadmin'), $this->author_id),
            'author_fullname' => $this->author_fullname,
            'created_at' => $this->created_at->format('d/m/Y à H:i:s')
        ];
    }
}
