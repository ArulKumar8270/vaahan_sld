<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\DateFilterTrait;
use App\Traits\FilterTrait;
use App\Traits\VgnModelTrait;
use Auth;

class MainModel extends Model {
    use SoftDeletes, HasFactory, DateFilterTrait, FilterTrait, VgnModelTrait;

    // protected $appends = ['tableName'];

    // protected $dates = ['deleted_at'];

    protected $perPage = 25;

    // public static function boot() {
    //     parent::boot();
    //     static::creating(function ($model) {
    //         $user = Auth::guard('sanctum')->user();
    //         if($user) {
    //             if($user->is_admin && $user->table === "prompts") {
    //                 $model->created_by = $user->id;
    //             }
    //             elseif ($user && $user->table != "prompts") {
    //                 $model->created_by = $user->id;
    //             } else {
    //                 $model->created_by = null;
    //             }
    //         }
    //     });
    //     static::updating(function ($model) {
    //         $user = Auth::guard('sanctum')->user();
    //         if($user) {
    //             if($user->is_admin && $user->table === "prompts") {
    //                 $model->updated_by = $user->id;
    //             }
    //             elseif ($user && $user->table != "prompts") {
    //                 $model->updated_by = $user->id;
    //             } else {
    //                 $model->updated_by = null;
    //             }
    //         }
    //     });
    // }

    /** Assign the dataType Attribuite. **/
    public function getTableNameAttribute() {
        return $this->attributes['tableName'] = $this->getTable();
    }

    /** Assign the ClassName Attribuite. **/
    public function getClassNameAttribute() {
        return $this->attributes['className'] = get_class($this);
    }

    /** Get the CreatedByName Attribuite. **/
    public function getCreatedByNameAttribute() {
        $userName = @$this->createdBy()->first()->name;
        return $this->attributes['createdByName'] = ($userName) ? ucfirst($userName) : 'System Admin';
    }

    /** Get the UpdatedByName Attribuite. **/
    public function getUpdatedByNameAttribute() {
        $user = @$this->updatedBy()->first()->name;
        return $this->attributes['updatedByName'] = ($userName) ? ucfirst($userName) : 'System Admin';
    }

    /** Get the CreatedByAvatar Attribuite. **/
    public function getCreatedByAvatarAttribute() {
        $userAvatar = @$this->createdBy()->first()->avatar_url;
        return $this->attributes['createdByAvatar'] = ($userAvatar) ? $userAvatar : null;
    }

}