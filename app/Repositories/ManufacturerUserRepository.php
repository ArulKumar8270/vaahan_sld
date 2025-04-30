<?php

namespace App\Repositories;

use App\Repositories\MainRepository;
use App\Models\ManufacturerUser;

class ManufacturerUserRepository extends MainRepository {

    public function __construct(ManufacturerUser $manufacturerUser) {
        parent::__construct($manufacturerUser);
    }

    /**
     * Returns Index all records.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index($input = null) {
        $items = $this->model
            ->DateFilter($input)
            ->NullFilterOn($input)
            ->IdFilterOn($input, 'id')
            ->StringFilterOn($input, 'name')
            ->StringFilterOn($input, 'phone_number')
            ->StringFilterOn($input, 'email_id')
            ->StringFilterOn($input, 'address')
            ->StringFilterOn($input, 'user_name')
            ->StringFilterOn($input, 'password')
            ->StringFilterOn($input, 'manufacturer')
            ->StringFilterOn($input, 'manufacturer_name')
            ->StringFilterOn($input, 'quantity')
            ->StringFilterOn($input, 'product_name')
            ->StringFilterOn($input, 'quantity_price')
            ->StringFilterOn($input, 'status')
            ->OrderByFilter($input)
            ->DeletedFilter($input)
            ->IncludeFilter($input);
        return $items;
    }
}
