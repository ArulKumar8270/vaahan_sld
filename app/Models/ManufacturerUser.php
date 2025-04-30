<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\MainModel;

class ManufacturerUser extends MainModel
{
    use SoftDeletes;

    protected $table = 'manufacturer_user';

    protected $isCachable = false;
    protected $cachePrefix = "manufacturer_user";
    protected $cacheCooldownSeconds = 86400;

    protected $fillable = [
        'name', 
        'phone_number', 
        'email_id', 
        'address', 
        'user_name', 
        'password', 
        'manufacturer', 
        'manufacturer_name', 
        'quantity', 
        'product_name', 
        'quantity_price',
        'status'
    ];

    protected $appends = ['tableName'];

}
