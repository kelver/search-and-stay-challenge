<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookStoreResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'identify' => $this->uuid,
            'name' => $this->name,
            'author' => $this->author,
            'isbn' => $this->isbn,
            'value' => $this->value,
            'created_at' => $this->created_at,
        ];
    }
}
