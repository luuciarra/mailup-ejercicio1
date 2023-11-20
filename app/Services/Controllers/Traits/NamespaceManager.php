<?php

namespace App\Services\Controllers\Traits;

/**
 *
 * @property string $path
 * @method string path()
 * 
 */

trait NamespaceManager
{
    protected function getPath()
    {
        if (method_exists($this, 'path')) {
            return $this->path();
        }

        return property_exists($this, 'path') ? $this->path : $this->resolvePath();
    }

    private function resolvePath()
    {
        return str_replace('.', '/', $this->getViewFolder());
    }
}
