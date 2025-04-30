<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\MainModel;
use App\Traits\DealerTrait;

class Dealer extends MainModel
{
    use SoftDeletes,DealerTrait;

    protected $table = 'dealer';

    protected $isCachable = false;
    protected $cachePrefix = "dealer";
    protected $cacheCooldownSeconds = 86400;

    protected $fillable = array('id', 'dealerName', 'red20mm', 'red50mm', 'white20mm', 'white50mm', 'yellow50mm', 'yellow80mm', 'redReflector80mm', 'whiteReflector80mm', 'yellowReflector80mm', 'class3', 'class4', 'hologram', 'invoiceNumber','distributer_id','subdistributer_id','dealer_id','manufacturer_id','distributer_name','sub_distributer_name','dealer_name','manufacturer_name','created_at');

    protected $appends = ['tableName'];

}
