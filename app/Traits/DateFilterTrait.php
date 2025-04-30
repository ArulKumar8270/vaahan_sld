<?php

namespace App\Traits;
use Arr;
use Str;
use Config;
use Carbon\Carbon;

/******* Available Index *********
 * Date Filter:
 * DateBetween($query, $column = 'created_at', $fromDate, $toDate)
 * DateAbove($query, $column = 'created_at', $date = null)
 * DateBelow($query, $column = 'created_at', $date = null)
 * DateFrom($query, $column = 'created_at', $date = null)
 * DateUpto($query, $column = 'created_at', $date = null)
 * DateFilter($query, $input = null, $filterBy = "created_at")
 * MonthFilter($query, $column = 'created_at', $input = null)
 ******* Index *********/

trait DateFilterTrait {

	/** Get Data Between Two Dates */
	public function scopeDateBetween($query, $column = 'created_at', $fromDate = null, $toDate = null) {
		if($fromDate && $toDate && $column) {
			return $query->whereBetween($column, [$fromDate, $toDate]);
		} else {
			return $query;
		}
	}

	public function scopeDateAbove($query, $column = 'created_at', $date = null) {
		$date = ($date) ? $date : Carbon::now();
		return $query->where($column, '>=', $date);
	}

	public function scopeDateBelow($query, $column = 'created_at', $date = null) {
		$date = ($date) ? $date : Carbon::now();
		return $query->where($column, '<=', $date);
	}

	public function scopeDateFrom($query, $column = 'created_at', $date = null) {
		$date = ($date) ? $date : Carbon::now();
		return $query->where($column, '>=', $date);
	}

	public function scopeDateUpto($query, $column = 'created_at', $date = null) {
		$date = ($date) ? $date : Carbon::now();
		return $query->where($column, '<=', $date);
	}

	/**
	 * Scope Date Filter.
	 * @input $input = [] with contains from_date and to_date
	 * @input $filterBy = String (Optional) used to Filter Column
	 * @return $query
	 */
	public function scopeDateFilter($query, $input = null, $filterBy = "created_at", $relation = null, $tableName = null) {
		$fromDate = ($input && Arr::has($input, 'from_date') &&
			$input['from_date'] != '' &&
			$input['from_date'] != null) ? Carbon::parse($input['from_date']) : null;
		$toDate = ($input && Arr::has($input, 'to_date') &&
			$input['to_date'] != '' &&
			$input['to_date'] != null) ? Carbon::parse($input['to_date'])->addDays(1) :
		($input && (Arr::has($input, 'from_date') &&
			$input['from_date'] != '' &&
			$input['from_date'] != null) ? Carbon::parse($input['from_date'])->addDays(1) : null);

		if ($relation) {
			$outputQuery = $query->when((($fromDate != null) && ($toDate != null) && ($relation != null)),
				function ($query) use ($fromDate, $toDate, $filterBy, $relation, $tableName) {
					return $query->whereHas($relation, function ($q) use ($fromDate, $toDate, $filterBy, $tableName) {
						$column = ($tableName) ? $tableName.'.'.$filterBy : $filterBy;
						return $q->whereBetween($column, [$fromDate, $toDate]);
					});
				});
		} else {
			$outputQuery = $query->when((($fromDate != null) && ($toDate != null)),
				function ($query) use ($fromDate, $toDate, $filterBy, $tableName) {
					$column = ($tableName) ? $tableName.'.'.$filterBy : $filterBy;
					return $query->whereBetween($column, [$fromDate, $toDate]);
				});
		}
		return $outputQuery;
	}


	/**
	 * Scope Date Before Filter.
	 * @input $input = [] with contains date_before
	 * @input $filterBy = String (Optional) used to Filter Column
	 * @return $query
	 */
	public function scopeDateBeforeFilter($query, $input = null, $filterBy = "created_at", $relation = null, $tableName = null) {
		$dateBefore = ($input && Arr::has($input, 'date_before') &&
			$input['date_before'] != '' &&
			$input['date_before'] != null) ? Carbon::parse($input['date_before'])->timezone(Config::get('app.timezone')) : null;

		$outputQuery = $query->when(($dateBefore != null), function($q) use($dateBefore, $filterBy, $tableName) {
			$column = ($tableName) ? $tableName.'.'.$filterBy : $filterBy;
			return $q->where($column, '<=', $dateBefore);
		});
		return $outputQuery;
	}

	public function scopeDateBeforeRawFilter($query, $input = null, $filterBy = "created_at", $relation = null, $tableName = null) {
		if(!$tableName) { return $query; }
		$dateBefore = ($input && Arr::has($input, 'date_before') && $input['date_before'] != '' && !is_null($input['date_before'])) ? Carbon::parse($input['date_before'])->timezone(Config::get('app.timezone')) : null;
		if(is_null($dateBefore)) { return $query; }
		$outputQuery = $query->when(($dateBefore != null), function($q) use ($dateBefore, $filterBy, $tableName) {
			$column = ($tableName) ? $tableName.'.'.$filterBy : $filterBy;
			return $q->where($column, '<=', $dateBefore);
		});
		return $outputQuery;
	}

	/**
	 * Scope Date After Filter.
	 * @input $input = [] with contains date_after
	 * @input $filterBy = String (Optional) used to Filter Column
	 * @return $query
	 */
	public function scopeDateAfterFilter($query, $input = null, $filterBy = "created_at", $relation = null, $tableName = null) {
		$dateAfter = ($input && Arr::has($input, 'date_after') && $input['date_after'] != '' && !is_null($input['date_after'])) ? Carbon::parse($input['date_after'])->timezone(Config::get('app.timezone')) : null;
		if(is_null($dateAfter)) { return $query; }
		$outputQuery = $query->when(($dateAfter != null), function($q) use($dateAfter, $filterBy, $tableName) {
			$column = ($tableName) ? $tableName.'.'.$filterBy : $filterBy;
			return $q->where($column, '>=', $dateAfter);
		});
		return $outputQuery;
	}

	/**
	 * Scope Day Filter.
	 * @input $input = [] with contains Day, Month and year
	 * @input $filterBy = String (Optional) used to Filter Column
	 * @return $query
	 */
	public function scopeDayFilter($query, $input = null, $column = 'created_at', $tableName = null) {
		$day = ($input && Arr::has($input, 'day')) ? $input['day'] : null;
		$month = ($input && Arr::has($input, 'month')) ? $input['month'] : null;
		$year = ($input && Arr::has($input, 'year')) ? $input['year'] : null;

		return $query->when(($day && $month && $year), function ($query) use ($day, $month, $year, $column, $tableName) {
			$columnOn = ($tableName) ? $tableName.'.'.$column : $column;
			return $query->whereDay($columnOn, $day)
				->whereMonth($columnOn, $month)
				->whereYear($columnOn, $year);
		});
	}

	/**
	 * Scope Month Filter.
	 * @input $input = [] with contains month and year
	 * @input $filterBy = String (Optional) used to Filter Column
	 * @return $query
	 */
	public function scopeMonthFilter($query, $input = null, $column = 'created_at', $tableName = null) {
		$month = ($input && Arr::has($input, 'month')) ? $input['month'] : null;
		$year = ($input && Arr::has($input, 'year')) ? $input['year'] : null;

		return $query->when(($month && $year), function ($query) use ($month, $year, $column, $tableName) {
			$columnOn = ($tableName) ? $tableName.'.'.$column : $column;
			return $query->whereMonth($columnOn, $month)
				->whereYear($columnOn, $year);
		});
	}

	/**
	 * Scope Year Filter.
	 * @input $input = [] with contains year
	 * @input $filterBy = String (Optional) used to Filter Column
	 * @return $query
	 */
	public function scopeYearFilter($query, $input = null, $column = 'created_at', $tableName = null) {
		$year = ($input && Arr::has($input, 'year')) ? $input['year'] : null;

		return $query->when(($year), function ($query) use ($year, $column) {
			$columnOn = ($tableName) ? $tableName.'.'.$column : $column;
			return $query->whereYear($columnOn, $year);
		});
	}


///*** RAW Table Record Filters *** /////

	/**
	 * Scope Date Filter.
	 * @input $input = [] with contains from_date and to_date
	 * @input $filterBy = String (Optional) used to Filter Column
	 * @return $query
	 */
	public function scopeDateRawFilter($query, $input = null, $filterBy = "created_at", $tableName = null, $relation = null) {
		if(!$tableName) { return $query; }
		$filterBy = Arr::has($input, 'filter_by') ? $input['filter_by'] : $filterBy;
		$fromDate = ($input && Arr::has($input, 'from_date') &&
			$input['from_date'] != '' &&
			$input['from_date'] != null) ? Carbon::parse($input['from_date']) : null;
		$toDate = ($input && Arr::has($input, 'to_date') &&
			$input['to_date'] != '' &&
			$input['to_date'] != null) ? Carbon::parse($input['to_date']) :
			($input && (Arr::has($input, 'from_date') &&
				$input['from_date'] != '' &&
				$input['from_date'] != null) ? Carbon::parse($input['from_date'])->addDays(1) : null);
		if ($relation) {
			$outputQuery = $query->when((($fromDate != null) && ($toDate != null) && ($relation != null)),
				function ($query) use ($fromDate, $toDate, $filterBy, $tableName, $relation) {
					return $query->whereHas($relation, function ($q) use ($fromDate, $toDate, $tableName, $filterBy) {
						return $q->whereBetween($tableName.'.'.$filterBy, [$fromDate, $toDate]);
					});
				});
		} else {
			$outputQuery = $query->when((($fromDate != null) && ($toDate != null)),
				function ($query) use ($fromDate, $toDate, $tableName, $filterBy) {
					return $query->whereBetween($tableName.'.'.$filterBy, [$fromDate, $toDate]);
				});
		}
		return $outputQuery;
	}

	public function scopeDayBeforeFilterOn($query, $input = null, $tableName = null) {
		$dayBefore = ($input && Arr::has($input, 'day_before') &&
			$input['day_before'] != '' &&
			$input['day_before'] != null) ? $input['day_before'] : null;

		if(is_null($dayBefore)) { return $query; }
		$columnName = explode('|', $dayBefore)[0];
		$dateValue = explode('|', $dayBefore)[1];
		if(is_null($columnName) || is_null($dateValue) || $dateValue === 'null') { return $query; }
		$date = ($dateValue && $dateValue !== '' && $dateValue === 'null') ? Carbon::parse($dateValue)->timezone(Config::get('app.timezone')) : null;
		if(is_null($date)) { return $query; }
		$outputQuery = $query->when(($date != null && $columnName != null), function($q) use($date, $columnName, $tableName) {
			$column = ($tableName) ? $tableName.'.'.$columnName : $columnName;
			return $q->where($column, '<=', $date);
		});
		return $outputQuery;
	}

	public function scopeDayAfterFilterOn($query, $input = null, $tableName = null) {
		$dayAfter = ($input && Arr::has($input, 'day_after') &&
			$input['day_after'] != '' &&
			$input['day_after'] != null) ? $input['day_after'] : null;

		if(is_null($dayAfter)) { return $query; }
		$columnName = explode('|', $dayAfter)[0];
		$dateValue = explode('|', $dayAfter)[1];
		if(is_null($columnName) || is_null($dateValue) || $dateValue === 'null') { return $query; }
		$date = ($dateValue && $dateValue !== '' && $dateValue !== 'null') ? Carbon::parse($dateValue)->timezone(Config::get('app.timezone')) : null;
		if(is_null($date)) { return $query; }
		$outputQuery = $query->when(($date != null && $columnName != null), function($q) use($date, $columnName, $tableName) {
			$column = ($tableName) ? $tableName.'.'.$columnName : $columnName;
			return $q->where($column, '>=', $date);
		});
		return $outputQuery;
	}
}