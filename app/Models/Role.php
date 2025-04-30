<?php

namespace App\Models;

use App\Models\MainModel;
use App\Traits\RoleTrait;

class Role extends MainModel
{
    use RoleTrait;

    protected $table = 'roles';

    protected $isCachable = false;
    protected $cachePrefix = "roles";
    protected $cacheCooldownSeconds = 86400;

    protected $fillable = array('id', 'name');

    protected $appends = ['tableName'];

    protected $searchable = [
        'columns' => [
            'roles.id' => 1,
            'roles.image' => 2,
        ]
    ];

}
