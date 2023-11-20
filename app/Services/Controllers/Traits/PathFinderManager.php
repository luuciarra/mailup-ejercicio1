<?php

namespace App\Services\Controllers\Traits;

use App\Services\PathFinders\PathFinder;

/**
 *
 * @property string $pathfinder
 * @method string pathfinder()
 * 
 */

trait PathFinderManager
{
    /**
     * @return PathFinder
     */
    protected function getPathfinder(): PathFinder
    {
        if(!$pathfinder = $this->resolvePathFinder()) {
            $pathfinder = PathFinder::create($this);
        }

        return $pathfinder;
    }

    private function resolvePathFinder()
    {
        $class = null;

        if (method_exists($this, 'pathfinder')) {
            $class = $this->pathfinder();
        } elseif (property_exists($this, 'pathfinder')) {
            $class = $this->pathfinder;
        }

        return class_exists($class) ? $class::create($this) : null;
    }
}
