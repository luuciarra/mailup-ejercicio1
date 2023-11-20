<?php

namespace App\Services\Controllers\Traits;

trait ResponseManager
{
    final public function json()
    {
        $class = $this->resolveModelClass();

        $rows = $this->jsonQuery($class::tabulated())->get();
        
        $totalRecords = $this->jsonQuery($class::filtered())->count();

        return [
            'rows' => $this->getResponse($rows)->getOriginalContent(),
            'totalRecords' => $totalRecords,
            'totalRecords' => $totalRecords,
        ];
    }

    protected function jsonQuery($query)
    {
        return $query;
    }
}
