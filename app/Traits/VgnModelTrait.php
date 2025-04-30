<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Traits\BooleanTrait;
use App\Traits\DateFilterTrait;
use App\Traits\FilterTrait;
use App\Traits\SearchableTrait;
use Carbon\Carbon;
use Request;
use ErrorResponse;

/******* Available Index *********
 * MorphTo Relations & Filters:
 * resource()
 * person()
 * for()
 * moneyTo()
 * moneyFrom()
 ******* Index *********/

trait VgnModelTrait {

	use BooleanTrait, DateFilterTrait, FilterTrait, SearchableTrait;

	/** Resource MorphTo */
	public function resource() {
		return $this->morphTo();
	}

	/** Person MorphTo */
	public function person() {
		return $this->morphTo();
	}

	/** Model MorphTo */
	public function model() {
		return $this->morphTo();
	}

	/** Whom MorphTo */
	public function whom() {
		return $this->morphTo()->withTrashed();
	}

	/** From MorphTo */
	public function from() {
		return $this->morphTo()->withTrashed();
	}

	/** For MoneyTo */
	public function for() {
		return $this->morphTo()->withTrashed();
	}

	/** MoneyTo MorphTo */
	public function moneyTo() {
		return $this->morphTo()->withTrashed();
	}

	/** MoneyFrom MorphTo */
	public function moneyFrom() {
		return $this->morphTo()->withTrashed();
	}

	/** MoneyFrom MorphTo */
	public function getDistanceMilesAttribute() {
		$miles = $this->GetMiles();
		return $this->attributes['distanceMiles'] = @$miles;
	}

	/** MoneyFrom MorphTo */
	public function getDistanceKmphAttribute() {
        $miles = $this->GetMiles();
	  	$kmph = $miles * 1.609344;
		return $this->attributes['distanceKmph'] = @$kmph;
	}

}
