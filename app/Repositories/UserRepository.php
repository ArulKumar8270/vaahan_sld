<?php

namespace App\Repositories;

use App\Repositories\MainRepository;
use App\Models\UserModel;
use Arr;
use Str;

class UserRepository extends MainRepository {

	public function __construct(UserModel $user) {
		parent::__construct($user);
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
            ->StringFilterOn($input, 'email')
			->StringFilterOn($input, 'username')
            // ->StringFilterOn($input, 'email_verified_at')
			// ->IdFilterOn($input, 'language_id')
			->StringFilterOn($input, 'verification_token',false)
			->StringFilterOn($input, 'status')
            ->OrderByFilter($input)
            ->DeletedFilter($input)
            ->IncludeFilter($input);
		return $items;
	}

}