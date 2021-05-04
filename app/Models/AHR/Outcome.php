<?php

namespace App\Models\AHR;

use Illuminate\Database\Eloquent\Model;
use App\Models\DHPIDReferenceModel;

class Outcome extends DHPIDReferenceModel {
    protected $table = "outcomes";
}
