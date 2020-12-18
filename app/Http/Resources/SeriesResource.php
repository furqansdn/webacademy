<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SeriesResource extends JsonResource
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
            'title' => $this->title,
            'slug'  => $this->slug,
            'description' => $this->description,
            'banner' => $this->banner,
            'lesson' => $this->lessons,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
