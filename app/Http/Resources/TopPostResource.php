<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TopPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'post_id' => $this->resource->id,
            'post_title' => $this->resource->title,
            'post_body' => $this->resource->body,
            'total_number_of_comments' => $this->resource->total_number_of_comments,
        ];
    }
}
