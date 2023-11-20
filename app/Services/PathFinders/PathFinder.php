<?php

namespace App\Services\PathFinders;

class PathFinder
{
    protected $path; // fully qualified name

    protected $namespace = 'App\\Http\\Controllers'; // Modificar para cada caso de uso. Ej.: para el caso de uso de la API, se debe cambiar el namespace por 'App\\Http\\Controllers\\Api'

    protected $suffix = 'Controller';

    public function __construct($path)
    {
        $this->path = $path;
    }

    public static function create($instance)
    {
        return new static(get_class($instance));
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getBase()
    {
        return \Str::before($this->path, '\\');
    }

    public function getProfile()
    {
        return $this->getFolders()->last();
    }

    public function getFolders()
    {
        $folders = \Str::of($this->path)
            ->replace($this->getBase(), '')
            ->replace($this->getName(), '')
            ->replaceLast($this->suffix, '')
            ->explode('\\')
            ->filter()
        ;

        return collect($folders);
    }

    public function getName()
    {
        return \Str::of($this->path)->afterLast('\\')->replace($this->suffix, '');
    }
}
