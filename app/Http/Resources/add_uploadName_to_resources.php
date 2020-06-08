<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class add_uploadName_to_resources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
