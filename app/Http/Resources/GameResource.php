<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,
            'category'      => $this->category,
            'embed_url'     => $this->embed_url,
            'thumbnail'     => $this->thumbnail,
            'thumbnail_url' => $this->thumbnail_url,  // accessor
            'is_featured'   => $this->is_featured,
            'plays'         => $this->plays,
            'tags'          => $this->tags,
        ];
    }
}