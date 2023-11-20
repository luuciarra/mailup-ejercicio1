<?php

namespace App\Models;

use App\Services\Models\ApiModel;

class Product extends ApiModel
{
    protected $fillable = [
        "name",
        "image",
        "brand",
        "category",
        "description",
        "price",
        "discount",
        "price_sale",
        "stock",
    ];

    public $appends = ["hasStock"];

    /**
     *  GETTERS
     */
    public function getHasStockAttribute()
    {
        return $this->stock > 0;
    }

    // Tabulate
    public function scopeTabulateQuery($query)
    {
        return $query->whereRequest("category");
    }

    public function scopeSearchQuery($query, $searchTerm)
    {
        $searchTerm = strtolower($searchTerm);

        return $query->where("name", "LIKE", "%$searchTerm%");
    }
}
