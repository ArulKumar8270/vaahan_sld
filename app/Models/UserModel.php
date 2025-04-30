<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\MainModel;
use App\Notifications\VerifyUserNotification;
use App\Traits\UserTrait;
use \DateTimeInterface;
use Carbon\Carbon;

class UserModel extends MainModel
{
    use SoftDeletes;
    use HasFactory;
    use UserTrait;

    protected $appends = ['tableName'];

    public const PAYMENT_FREQUENCY_SELECT = [
        'monthly' => 'Monthly',
        'yearly'  => 'Yearly',
    ];

    public const STATUS_SELECT = [
        'pending'  => 'Pending',
        'active'   => 'Active',
        'expired'  => 'Expired',
        'canceled' => 'Canceled',
    ];

    public $table = 'users';

    protected $hidden = [
        'remember_token',
        'password',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at',
        'verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'verified',
        'total_usage',
        'verified_at',
        'verification_token',
        'language_id',
        'razorpay_id',
        'remember_token',
        'google_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (self $user) {
            if (auth()->check()) {
                $user->verified    = 1;
                $user->verified_at = Carbon::now()->format(config('panel.date_format') . ' ' . config('panel.time_format'));
                $user->save();
            } elseif (! $user->verification_token) {
                $token     = Str::random(64);
                $usedToken = self::where('verification_token', $token)->first();

                while ($usedToken) {
                    $token     = Str::random(64);
                    $usedToken = self::where('verification_token', $token)->first();
                }

                $user->verification_token = $token;
                $user->save();

                $registrationRole = config('panel.registration_default_role');
                if (! $user->roles()->get()->contains($registrationRole)) {
                    $user->roles()->attach($registrationRole);
                }
                if(!isset($user->google_id)){
                $user->notifyNow(new VerifyUserNotification($user));
                }
            }
        });
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function userSubscription()
    {
        return $this->hasOne('App\Models\Subscription', 'user_id', 'id')->latest();
    }

    public function userPayments()
    {
        return $this->hasMany('App\Models\Payment', 'user_id', 'id');
    }

    public function contents()
    {
        return $this->hasMany('App\Models\Content', 'user_id', 'id');
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setVerifiedAtAttribute($value)
    {
        $this->attributes['verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function language()
    {
        return $this->belongsTo('App\Models\Language', 'language_id');
    }

    public function companies()
    {
        return $this->hasMany('App\Models\UserCompany', 'user_id', 'id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    
}