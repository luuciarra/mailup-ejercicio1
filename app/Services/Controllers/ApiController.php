<?php

namespace App\Services\Controllers;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    use Traits\PathFinderManager,
        Traits\ModelManager,
        Traits\NamespaceManager,
        Traits\AuthorizationManager,
        Traits\ValidatorManager,
        Traits\ResourceManager, 
        Traits\ResponseManager,
        Traits\EventManager,
        Traits\MetaManager,
        Traits\RepositoryManager
    ;
    
    const CREATE = 'create';
    const UPDATE = 'update';
    const DELETE = 'delete';

    public function index()
    {
        $this->allow('viewAny')->resourceType("index");

        $this->setMeta();

        $class = $this->resolveModelClass();

        $query = $this->jsonQuery($class::tabulated($this->meta));

        $rows = $query->get();
        
        $totalRecords = $this->jsonQuery($class::filtered($this->meta))->count();

        $this->meta['total'] = $totalRecords;
        $this->meta['count'] = $rows->count();
        
        return $this->getResponse($rows, ['meta' => $this->getMeta()]);
    }

    public function show($id)
    {
        return $this->allow('view')->findModel($id)->resourceType("show")->getResponse();
    }

    public function store()
    {
        $this->action = self::CREATE;

        $this->allow($this->action)->validation()->applyRepository();

        return $this->resourceType("show")->getResponse()->setStatusCode(201);
    }

    public function update($id)
    {
        $this->action = self::UPDATE;

        $this->findModel($id)->allow($this->action)->validation()->applyRepository();

        return $this->resourceType("show")->getResponse()->setStatusCode(200);
    }

    public function destroy($id)
    {
        $this->action = self::DELETE;

        $response = $this->findModel($id)->allow($this->action)->getResponse();

        $this->applyRepository();
        
        return $response;
    }
}
