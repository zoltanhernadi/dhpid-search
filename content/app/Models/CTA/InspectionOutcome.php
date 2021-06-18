<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;
use App\Models\DHPIDReferenceModel;

class InspectionOutcome extends DHPIDReferenceModel {

    protected $connection= 'cta';
    protected $table = "inspection_outcomes";
}
