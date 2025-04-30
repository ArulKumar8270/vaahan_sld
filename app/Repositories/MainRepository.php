<?php

namespace App\Repositories;

use App\Traits\ToolsTrait; 

class MainRepository {

    use ToolsTrait;

    protected $model;

    public function __construct($model) {
        $this->model = $model;
    }
}