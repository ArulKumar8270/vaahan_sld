<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MainModel;

class Transportation extends MainModel
{

    protected $table = 'transportations';

    protected $isCachable = false;
    protected $cachePrefix = "transportations";
    protected $cacheCooldownSeconds = 86400;
    
    protected $fillable = [
        'date',
        'material',
        'location',
        'vehicle_number',
        'from_company_name',
        'from_total_amount',
        'from_phone_no',
        'to_company_name',
        'to_total_amount',
        'to_phone_number',
        'paid_amount',
    ];

    protected $appends = ['tableName'];
}
