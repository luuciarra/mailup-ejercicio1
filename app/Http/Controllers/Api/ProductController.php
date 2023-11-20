<?php

namespace App\Http\Controllers\Api;

use App\Services\Controllers\ApiController;

class ProductController extends ApiController{
    protected function beforeSave()
    {
        if(request()->input("price_sale")){
            $this->model->discount = (($this->model->price - $this->model->price_sale)*100) / $this->model->price;
        }

        if(request()->input("discount")){
            $this->model->price_sale = $this->model->price - ($this->model->price * $this->model->discount / 100);
        }
    }
}
