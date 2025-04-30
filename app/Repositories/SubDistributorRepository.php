<?php

namespace App\Repositories;

use App\Repositories\MainRepository;
use App\Models\SubDistributor;
use Arr;
use Str;

class SubDistributorRepository extends MainRepository {

	public function __construct(SubDistributor $subDistributor) {
		parent::__construct($subDistributor);
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
            ->StringFilterOn($input, 'dealerName')
            ->StringFilterOn($input, 'red20mm')
            ->StringFilterOn($input, 'red50mm')
            ->StringFilterOn($input, 'white20mm')
            ->StringFilterOn($input, 'white50mm')
            ->StringFilterOn($input, 'yellow50mm')
            ->StringFilterOn($input, 'yellow80mm')
            ->StringFilterOn($input, 'redReflector80mm')
            ->StringFilterOn($input, 'whiteReflector80mm')
            ->StringFilterOn($input, 'yellowReflector80mm')
            ->StringFilterOn($input, 'class3')
            ->StringFilterOn($input, 'class4')
            ->StringFilterOn($input, 'hologram')
            ->StringFilterOn($input, 'invoiceNumber')
            ->StringFilterOn($input, 'distributer_id')
            ->StringFilterOn($input, 'subdistributer_id')
            ->StringFilterOn($input, 'dealer_id')
            ->StringFilterOn($input, 'manufacturer_id')
            ->StringFilterOn($input, 'distributer_name')
            ->StringFilterOn($input, 'sub_distributer_name')
            ->StringFilterOn($input, 'dealer_name')
            ->StringFilterOn($input, 'manufacturer_name')
            ->OrderByFilter($input)
            ->DeletedFilter($input)
            ->IncludeFilter($input);
		return $items;
	}

}