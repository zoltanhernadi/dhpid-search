<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;
use App\Models\DHPIDReferenceModel;

class InspectionType extends DHPIDReferenceModel {

    protected $connection= 'cta';
}
