<?php

namespace App\Services\Controllers\Traits;

/**
 *
 * @property bool $useRepository
 * @method bool useRepository()
 * @property string $repository
 * @method string repository()
 * 
 */

trait RepositoryManager
{
    protected $action;

    private $eventsMap = [
        self::CREATE => [
            'beforeEvent' => 'beforeCreate',
            'afterEvent' => 'afterCreate',
        ],
        self::UPDATE => [
            'beforeEvent' => 'beforeUpdate',
            'afterEvent' => 'afterUpdate',
        ],
        self::DELETE => [
            'beforeEvent' => 'beforeDelete',
            'afterEvent' => 'afterDelete',
        ],
    ];

    public function applyRepository()
    {
        extract($this->eventsMap[$this->action]);

        $data = $this->getData();
        $this->getModel()->fill($data);

        $this->$beforeEvent();
        $this->beforeSave();

        $this->applyAction($data);

        $this->$afterEvent();
        $this->afterSave();

        return $this;
    }

    public function applyAction($data)
    {
        switch ($this->action) {
            case self::CREATE:
                $this->getModel()->save();
                break;
            case self::UPDATE:
                $this->getModel()->save();
                break;
            case self::DELETE:
                $this->getModel()->delete();
                break;
        }
    }
    
    protected function getData()
    {
        return request()->all();
    }
}
