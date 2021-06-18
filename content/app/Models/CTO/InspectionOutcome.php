<?php

namespace App\Models\CTO;

use Illuminate\Database\Eloquent\Model;
use App\Models\DHPIDReferenceModel;

class InspectionOutcome extends DHPIDReferenceModel {
    protected $table = "inspection_outcomes";
    protected $connection = 'cto';
}
