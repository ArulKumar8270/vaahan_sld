<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\MainModel;

class SubDistributorUser extends MainModel
{
    use SoftDeletes;

    protected $table = 'sub_distributor_user';

    protected $isCachable = false;
    protected $cachePrefix = "sub_distributor_user";
    protected $cacheCooldownSeconds = 86400;

    protected $fillable = [
        'name', 
        'phone_number', 
        'email_id', 
        'address', 
        'user_name', 
        'password', 
        'dealer_name', 
        'manufacturer_id', 
        'distributor_id', 
        'manufacturer_name', 
        'distributor_name', 
        'quantity', 
        'product_name', 
        'quantity_price',
        'created_at',
        'status'
    ];

    protected $appends = ['tableName'];

}
