<?php

namespace App\Services\Controllers\Traits;

use App\Services\Controllers\ApiController;
use Illuminate\Support\Facades\Gate;

/**
 *
 * @property bool $useAuthorize
 * @method bool useAuthorize()
 * 
 */

trait AuthorizationManager
{
    /**
     * @param string $action
     * @return ApiController
     * 
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function allow($action): ApiController
    {
        if ($this->mustApplyAuthorize($action)) {
            $this->authorize($action, $this->getModel());
        }

        return $this;
    }

    private function mustApplyAuthorize($action)
    {
        $mustApply = true;

        if (method_exists($this, 'useAuthorize')) {
            $mustApply = $this->useAuthorize($action);
        } elseif (property_exists($this, 'useAuthorize')) {
            $mustApply = $this->useAuthorize;
        }

        return $mustApply;
    }
}
