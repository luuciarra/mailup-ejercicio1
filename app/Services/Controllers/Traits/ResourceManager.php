<?php

namespace App\Services\Controllers\Traits;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\File;

/**
 *
 * @property bool $useResource
 * @method bool useResource()
 * @property string $resource
 * @method string resource()
 * 
 */

trait ResourceManager
{
    private $resourceType = "Json";

    protected function resourceType($type)
    {
        $this->resourceType = ucfirst($type);

        return $this;
    }

    protected function getResponse($data=null, $additional = [])
    {
        if ($this->mustApplyResource($data)) {
            if($resource = $this->resolveResource()) {
                return $this->resourceResponse($data, $resource)->additional($additional)->response();
            }
        }

        return $this->arrayResponse($data);
    }

    private function resourceResponse($data, $resource)
    {
        return (!$data) ? new $resource($this->getModel()) : $resource::collection($data);
    }

    private function arrayResponse($data)
    {
        $response = (!$data) ? $this->getModel()->toArray() : $data->toArray();

        return response()->json($response);
    }

    private function mustApplyResource($data)
    {
        if (method_exists($this, 'useResource')) {
            $mustApply = $this->useResource();
        } elseif (property_exists($this, 'useResource')) {
            $mustApply = $this->useResource;
        } else {
            $mustApply = !$data || $data instanceof \Illuminate\Support\Collection;
        }

        return $mustApply;
    }

    private function resolveResource()
    {
        if (method_exists($this, 'resource')) {
            $class = $this->resource();
        } elseif (property_exists($this, 'resource')) {
            $class = $this->resource;
        } else {
            $class = $this->getResourceFullQualifyName();
        }

        return class_exists($class) ? $class : null;
    }

    private function getResourceFullQualifyName()
    {
        $model = $this->getPathfinder()->getName();

        $profile = $this->getPathfinder()->getProfile();

        $resource = "";

        // Resource específico para la función json
        if($this->resourceType){
            $resource = "app\Http\Resources\\{$profile}\\{$model}\\{$this->resourceType}Resource";
        }

        // Resource por perfil
        if (!File::exists($this->getResourceBasePath($resource))) {
            $resource = "app\Http\Resources\\{$profile}\\{$model}Resource";
        }

        // Resource general
        if (!File::exists($this->getResourceBasePath($resource))) {
            $resource = "app\Resources\\{$model}Resource";
        }

        $resource = ucfirst($resource);

        return $resource;
    }

    private function getResourceBasePath($resource)
    {
        return str_replace('\\', '/', base_path("$resource.php"));
    }
}
