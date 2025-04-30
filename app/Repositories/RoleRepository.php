<?php

namespace App\Repositories;

use App\Repositories\MainRepository;
use App\Models\Role;
use Arr;
use Str;

class RoleRepository extends MainRepository {

	public function __construct(Role $role) {
		parent::__construct($role);
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
            ->StringFilterOn($input, 'name')
            ->OrderByFilter($input)
            ->DeletedFilter($input)
            ->IncludeFilter($input);
		return $items;
	}

}