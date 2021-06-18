<?php

namespace App\Models\AHR;

use Illuminate\Database\Eloquent\Model;
use App\Models\DHPIDRegulationModel;

class Deficiency extends DHPIDRegulationModel {
    protected $table = "deficiencies";

    public function inspection() {
        return $this->belongsTo('App\Models\AHR\Inspection', 'inspectionID');
    }

    public function regulation(){
        return $this->belongsTo('App\Models\AHR\InspectionRegulation', 'regulationID');
    }
}
