<?php

namespace App\Services\Controllers\Traits;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property string $model
 * @method string model()
 * 
 */

trait ModelManager
{
    protected $model;

    final protected function findModel($value): Controller
    {
        $class = $this->resolveModelClass();

        $query = $class::query();

        $this->model = $this->modelQuery($query, $value);

        return $this;
    }

    protected function modelQuery(Builder $query, $value): Model
    {
        if(is_numeric($value)){
            $model = $query->where('id', $value)->first();
        }else{
            $model = $query->where('slug', $value)->first();
        }

        if(!$model){
            abort(404, $this->getPathfinder()->getName()." not found");
        }

        return $model;
    }

    final protected function getModel()
    {
        if (!$this->model) {
            $this->model = $this->newModel();
        }

        return $this->model;
    }

    final protected function newModel()
    {
        $class = $this->resolveModelClass();
        
        return new $class;
    }

    private function resolveModelClass()
    {
        if (method_exists($this, 'modelClass')) {
            $class = $this->modelClass();
        } elseif (property_exists($this, 'modelClass')) {
            $class = $this->modelClass;
        } else {
            $class = $this->getModelFullyQualifiedName();
        }

        return $class;
    }

    private function getModelFullyQualifiedName()
    {
        $class = $this->getPathfinder()->getName();

        return "\App\Models\\$class";
    }
}
