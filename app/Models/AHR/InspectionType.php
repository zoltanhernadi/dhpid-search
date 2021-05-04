<?php

namespace App\Models\AHR;

use Illuminate\Database\Eloquent\Model;
use App\Models\DHPIDReferenceModel;

class InspectionType extends DHPIDReferenceModel {
    protected $table = "inspection_types";
}
