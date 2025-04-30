<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\MainModel;

class DistributorUser extends MainModel
{
    use SoftDeletes;

    protected $table = 'distributor_user';

    protected $isCachable = false;
    protected $cachePrefix = "distributor_user";
    protected $cacheCooldownSeconds = 86400;

    protected $fillable = [
        'name', 
        'phone_number', 
        'email_id', 
        'address', 
        'user_name', 
        'password', 
        'sub_distributor_name', 
        'manufacturer_id',
        'manufacturer_name' ,
        'quantity', 
        'product_name', 
        'quantity_price',
        'status'
    ];

    protected $appends = ['tableName'];

}
