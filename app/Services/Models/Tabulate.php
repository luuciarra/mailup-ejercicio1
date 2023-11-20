<?php

namespace App\Services\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

trait Tabulate
{
    public function scopeFiltered($query, $meta = [])
    {
        $query->tabulateQuery();

        if ($searchTerm = $meta['search'] ?? null) $query->searchQuery($searchTerm);

        if ($filters = $meta['filters'] ?? []) $query->filterQuery($filters);

        return $query;
    }

    public function scopeTabulated($query, $meta = [])
    {
        $perPage = $meta["perPage"];
        $since = ($meta["page"] - 1) * $perPage;

        return $query->filtered($meta)
            ->take($perPage)
            ->skip($since)
            ->sortTabulated($meta)
        ;
    }

    public function scopeTabulateQuery($query)
    {
        return $query;
    }

    public function scopeSearchQuery($query, $searchTerm)
    {
        return $query;
    }

    public function scopeFilterQuery($query, $filters)
    {
        $query->where(function ($query) use ($filters) {
            foreach ($filters as $filter) {
                extract(json_decode($filter, true));
                if (isset($value)) {
                    $method = 'filter'.\Str::studly($column);
                    if (method_exists($this,$method)) {
                        $this->$method($query, $value);
                    } else {
                        $query->where($column, $value);
                    }
                }
            }
        });

        return $query;
    }

    public function scopeSortTabulated($query, $meta)
    {
        $order_column = $meta["order_column"] ?? null;
        $order_dir = $meta["order_direction"] ?? "asc";

        if (isset($order_column) && $order_column != '') {
            if (strpos($order_column, '.') !== false) {
                $params = explode('.', $order_column);
                $this->orderByRelation($query, $params[0], $params[1], $order_dir);
            } else {
                $method = 'order'.\Str::studly($order_column);
                if (method_exists($this,$method)) {
                    $this->$method($query, $order_dir);
                } else {
                    $query->orderBy($order_column, $order_dir);
                }

            }
        } else {
            $this->defaultOrder($query);
        }

        return $query;
    }

    protected function defaultOrder($query)
    {
        if (method_exists($this, 'scopeOrdered')) {
            $query->ordered(); //Spatie eloquent order
        } else {
            $query->orderBy('id');
        }
    }

    protected function orderByRelation($query, $relation, $column, $order)
    {
        if ($this->$relation() instanceof HasOneOrMany) {
            $table = $this->$relation()->getRelated()->getTable();
            $query->orderByJoin("$table.$column", $order);
        } elseif ($this->$relation() instanceof BelongsTo) {
            $foreingKey = $this->$relation()->getForeignKeyName();
            $query->orderBy($foreingKey, $order);
        }
    }
}

