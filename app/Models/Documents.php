<?php

namespace App\Models;

use App\Models\MainModel;

class Documents extends MainModel
{
    protected $table = 'documents';

    protected $isCachable = false;
    protected $cachePrefix = "documents";
    protected $cacheCooldownSeconds = 86400;

    protected $fillable = array('id', 'image', 'document');

    protected $casts = [
        'is_refreshable' => 'boolean',
        'is_used' => 'boolean'
    ];

    protected $appends = ['tableName'];

    protected $searchable = [
        'columns' => [
            'documents.id' => 1,
            'documents.image' => 2,
            'documents.document' => 3,
        ]
    ];

}
