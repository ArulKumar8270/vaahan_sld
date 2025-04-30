<?php

namespace App\Repositories;

use App\Repositories\MainRepository;
use App\Models\Transportation;
use Arr;
use Str;

class TransportationRepository extends MainRepository {

	public function __construct(Transportation $transportation) {
		parent::__construct($transportation);
	}

	/**
	 * Returns Index all records.
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function index($input = null) {
		$count = 100;
		$items = $this->model
            ->DateFilter($input)
            ->NullFilterOn($input)
            ->IdFilterOn($input, 'id')
            ->StringFilterOn($input, 'date')
            ->StringFilterOn($input, 'material')
            ->StringFilterOn($input, 'location')
            ->StringFilterOn($input, 'vehicle_number')
            ->StringFilterOn($input, 'from_company_name')
            ->IdFilterOn($input, 'from_total_amount')
            ->StringFilterOn($input, 'from_phone_no')
            ->StringFilterOn($input, 'to_company_name')
            ->IdFilterOn($input, 'to_total_amount')
            ->StringFilterOn($input, 'to_phone_no')
            ->IdFilterOn($input, 'paid_amount')
            ->OrderByFilter($input)
            ->DeletedFilter($input)
            ->IncludeFilter($input);
		return $items;
	}

}