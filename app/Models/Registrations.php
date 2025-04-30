<?php

namespace App\Models;

use App\Models\MainModel;
use App\Traits\RegistrationsTrait;

class Registrations extends MainModel
{
    use RegistrationsTrait;

    protected $table = 'registrations';

    protected $isCachable = false;
    protected $cachePrefix = "registrations";
    protected $cacheCooldownSeconds = 86400;

    protected $fillable = array('id', 'date', 'dealername', 'certificateno', 'vehicleregno', 'vehiclemanufacturingyear','chassisnum','engineno','vehiclemake','vehiclemodel','ownername','address','phoneo','rto','hologramnum','oldcertificatenum','oldcertificaterto','oldcertificatedate','remarks','red20mm','white20mm','red50mm','white50mm','yellow50mm','redReflector80mm','whiteReflector80mm','yellowReflector80mm','class3','class4','hologram','invoice_number','rcimage','frontimage','backimage','leftimage','rightimage','distributer_id','subdistributer_id','dealer_id','manufacturer_id','distributer_name','sub_distributer_name','dealer_name','manufacturer_name','sld_make','sld_model','sld_serial_no','rotor_seal_no','color','speed','testing_agency','tac_cop_no','created_at');

    protected $appends = ['tableName'];

}
