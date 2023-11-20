<?php

namespace App\Services\Controllers\Traits;

/**
 *
 * @property bool $useValidator
 * @method bool useValidator()
 * @property string $validator
 * @method string validator()
 * 
 */

trait ValidatorManager
{
    /**
     * Se eligó este nombre para evitar la colisión con el método validate de Laravel
     */
    protected function validation()
    {
        if ($this->mustApplyValidator()) {
            if($validator = $this->resolveValidator()) {
                request()->validate($validator->rules(), $validator->messages(), $validator->attributes());
            }
        }

        return $this;
    }

    private function mustApplyValidator()
    {
        $mustApply = true;

        if (method_exists($this, 'useValidator')) {
            $mustApply = $this->useValidator();
        } elseif (property_exists($this, 'useValidator')) {
            $mustApply = $this->useValidator;
        }

        return $mustApply;
    }

    private function resolveValidator()
    {
        if (method_exists($this, 'validator')) {
            $class = $this->validator();
        } elseif (property_exists($this, 'validator')) {
            $class = $this->validator;
        } else {
            $class = $this->getValidatorFullQualifyName();
        }

        return class_exists($class) ? new $class : null;
    }

    private function getValidatorFullQualifyName()
    {
        $model = $this->getPathfinder()->getName();

        $profile = $this->getPathfinder()->getProfile();

        return "App\Http\Requests\\".$profile."\\".$model."Request";
    }
}
