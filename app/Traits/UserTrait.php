<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait UserTrait {

    public function role() {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }

    public function roles() {
        return $this->hasMany('App\Models\Role');
    }

}