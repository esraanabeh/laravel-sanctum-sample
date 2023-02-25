<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>$this->id,
            'attributes' => [
                'title' => $this->title,
                'topic' => $this->topic,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ],
            'writer' => [
                'id'=>$this->user->id,
                'writer name' => $this->user->name,
                'writer email' => $this->user->email
            ]
        ];
    }
}
