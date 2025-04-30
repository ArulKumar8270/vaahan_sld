<?php

namespace App\Repositories;

use App\Repositories\MainRepository;
use App\Models\Registrations;
use Arr;
use Str;

class RegistrationsRepository extends MainRepository {

	public function __construct(Registrations $registrations) {
		parent::__construct($registrations);
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
            ->StringFilterOn($input, 'dealername')
            ->StringFilterOn($input, 'certificateno')
            ->StringFilterOn($input, 'vehicleregno')
            ->StringFilterOn($input, 'vehiclemanufacturingyear')
            ->StringFilterOn($input, 'chassisnum')
            ->StringFilterOn($input, 'engineno')
            ->StringFilterOn($input, 'vehiclemake')
            ->StringFilterOn($input, 'vehiclemodel')
            ->StringFilterOn($input, 'ownername')
            ->StringFilterOn($input, 'address')
            ->StringFilterOn($input, 'phoneo')
            ->StringFilterOn($input, 'rto')
            ->StringFilterOn($input, 'hologramnum')
            ->StringFilterOn($input, 'oldcertificatenum')
            ->StringFilterOn($input, 'oldcertificaterto')
            ->StringFilterOn($input, 'oldcertificatedate')
            ->StringFilterOn($input, 'remarks')
            ->StringFilterOn($input, 'red20mm')
            ->StringFilterOn($input, 'white20mm')
            ->StringFilterOn($input, 'red50mm')
            ->StringFilterOn($input, 'white50mm')
            ->StringFilterOn($input, 'yellow50mm')
            ->StringFilterOn($input, 'redReflector80mm')
            ->StringFilterOn($input, 'whiteReflector80mm')
            ->StringFilterOn($input, 'yellowReflector80mm')
            ->StringFilterOn($input, 'class3')
            ->StringFilterOn($input, 'class4')
            ->StringFilterOn($input, 'hologram')
            ->StringFilterOn($input, 'invoice_num')
            ->StringFilterOn($input, 'rcimage')
            ->StringFilterOn($input, 'frontimage')
            ->StringFilterOn($input, 'backimage')
            ->StringFilterOn($input, 'leftimage')
            ->StringFilterOn($input, 'rightimage')
            ->StringFilterOn($input, 'distributer_id')
            ->StringFilterOn($input, 'subdistributer_id')
            ->StringFilterOn($input, 'dealer_id')
            ->StringFilterOn($input, 'manufacturer_id')
            ->StringFilterOn($input, 'distributer_name')
            ->StringFilterOn($input, 'sub_distributer_name')
            ->StringFilterOn($input, 'dealer_name')
            ->StringFilterOn($input, 'manufacturer_name')
            ->StringFilterOn($input, 'sld_make')
            ->StringFilterOn($input, 'sld_model')
            ->StringFilterOn($input, 'sld_serial_no')
            ->StringFilterOn($input, 'rotor_seal_no')
            ->StringFilterOn($input, 'speed')
            ->StringFilterOn($input, 'testing_agency')
            ->StringFilterOn($input, 'tac_cop_no')
            ->OrderByFilter($input)
            ->DeletedFilter($input)
            ->IncludeFilter($input);
		return $items;
	}

}