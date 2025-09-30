<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'category_id'=>$this->category_id,
            'categories'=>$this->category,
            'title'=>$this->title,
            'image'=>$this->image,
            'content'=>$this->content,
            'original_url'=>$this->original_url,
            'published_at'=>$this->published_at,
        ];
    }
}
