<?php

namespace App\Models\CTO;

use Illuminate\Database\Eloquent\Model;
use App\Models\DHPIDReferenceModel;

class InspectionType extends DHPIDReferenceModel {
    protected $table = "inspection_types";
    protected $connection = 'cto';
}
