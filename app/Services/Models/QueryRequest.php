<?php

namespace App\Services\Models;

trait QueryRequest
{
    public function scopeWhereRequest($query, $params)
    {
        $params = $this->getParams($params);

        foreach ($params as $param) {
            $relation = null;

            if(strpos($param, ".")){
                $relation = \Str::of($param)->before(".");
                $param = \Str::of($param)->afterLast(".");
            }

            if (request()->has($param)) {
                if($relation){
                    $query->whereHas("$relation", function($q) use ($param){
                        $q->where($param, request()->input($param));
                    });
                }else{
                    $query->where($param, request()->input($param));
                }
            }
        }

        return $query;
    }

    public function scopeWhereInRequest($query, $params)
    {
        $params = $this->getParams($params);

        foreach ($params as $param) {
            $relation = null;

            if(strpos($param, ".")){
                $relation = \Str::of($param)->before(".");
                $param = \Str::of($param)->afterLast(".");
            }

            if (request()->has($param)) {
                if($relation){
                    $query->whereHas("$relation", function($q) use ($param){  
                        $q->whereIn($param, request()->input($param));
                    });
                }else{
                    $query->whereIn($param, request()->input($param));
                }
            }
        }

        return $query;
    }
    
    public function scopeWhereBetweenRequest($query, $params)
    {
        $params = $this->getParams($params);

        foreach ($params as $param) {
            if (request()->hasAny([$param."Range", $param])) {
                $query->whereBetween($param, request()->get($param."Range") ?? request()->input($param));
            }
        }

        return $query;
    }

    private function getParams($params)
    {
        if(is_string($params)){
            return [$params];
        }

        if (!is_array($params)) {
            $params = func_get_args();
            array_shift($params);
        }

        return $params;
    }
    
}
