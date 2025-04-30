<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait RoleTrait {

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function users() {
        return $this->hasMany('App\Models\User');
    }

}