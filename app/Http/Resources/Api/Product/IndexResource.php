<?php

namespace App\Http\Resources\Api\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "image" => $this->image,
            "brand" => $this->brand,
            "category" => $this->category,
            "price" => $this->price,
            "price_string" => decimalformat($this->price),
            "discount" => $this->discount,
            "price_sale" => $this->price_sale,
            "price_sale_string" => decimalformat($this->price_sale),
            "has_stock" => $this->has_stock,
        ];
    }
}
