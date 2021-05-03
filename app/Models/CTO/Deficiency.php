<?php

namespace App\Models\CTO;

use Illuminate\Database\Eloquent\Model;

class Deficiency extends DHPIDRegulationModel {
    protected $table = "deficiencies";

    public function inspection() {
        return $this->belongsTo('App\Models\CTO\Inspection', 'inspectionID');
    }

    public function regulation() {
        return $this->belongsTo('App\Models\CTO\InspectionRegulation', 'regulationID');
    }
}
