<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\MainModel;

class DealerUser extends MainModel
{
    use SoftDeletes;

    protected $table = 'dealer_user';

    protected $isCachable = false;
    protected $cachePrefix = "dealer_user";
    protected $cacheCooldownSeconds = 86400;

    protected $fillable = [
        'name', 
        'phone_number', 
        'email_id', 
        'address', 
        'user_name', 
        'password', 
        'manufacturer_id', 
        'distributor_id',
        'distributor_name',
        'manufacturer_name',
        'sub_distributer_name',
        'dealer_name',
        'sub_distributor_id',
        'quantity', 
        'product_name', 
        'quantity_price',
        'status',
        'created_at'
    ];

    protected $appends = ['tableName'];

}
