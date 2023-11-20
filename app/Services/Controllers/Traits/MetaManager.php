<?php

namespace App\Services\Controllers\Traits;

trait MetaManager
{
    protected $meta;

    private function setMeta()
    {
        request()->validate([
            "page" => "nullable|numeric",
            "perPage" => "nullable|numeric",
            "order_direction" => "nullable|in:asc,desc,ASC,DESC"
        ]);

        $page = (int) request()->input("page", 1);

        $perPage = (int) request()->input("perPage", 10);

        $search = request()->input("search");

        $this->meta = [
            "page" => $page,
            "perPage" => $perPage,
            'search' => $search,
            "order_column" => request()->input("order_column"),
            "order_direction" => request()->input("order_direction", "ASC"),
        ];
    }

    private function getMeta()
    {
        if($this->meta["total"] ?? false){
            $this->meta["more_pages"] = $this->meta["perPage"] * $this->meta["page"] < $this->meta["total"];
            $this->meta["total_pages"] = ceil($this->meta["total"] / $this->meta["perPage"]);
        }
        return $this->meta;
    }
}
