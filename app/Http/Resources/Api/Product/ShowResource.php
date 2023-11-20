<?php

namespace App\Http\Resources\Api\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
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
            "description" => $this->description,
            "price" => (float) $this->price,
            "price_string" => decimalformat($this->price),
            "discount" => (int) $this->discount,
            "price_sale" => (float) $this->price_sale,
            "price_sale_string" => decimalformat($this->price_sale),
            "stock" => (int) $this->stock,
            "has_stock" => $this->has_stock,
        ];
    }
}
