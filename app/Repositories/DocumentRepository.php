<?php

namespace App\Repositories;

use App\Repositories\MainRepository;
use App\Models\Documents;
use Arr;
use Str;

class DocumentRepository extends MainRepository {

	public function __construct(Documents $documents) {
		parent::__construct($documents);
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
            ->StringFilterOn($input, 'image')
            ->StringFilterOn($input, 'document')
            ->OrderByFilter($input)
            ->DeletedFilter($input)
            ->IncludeFilter($input);
		return $items;
	}

}