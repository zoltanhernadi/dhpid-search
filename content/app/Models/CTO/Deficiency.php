<?php

namespace App\Models\CTO;

use Illuminate\Database\Eloquent\Model;
use App\Models\DHPIDRegulationModel;

class Deficiency extends DHPIDRegulationModel {
    protected $table = "deficiencies";
    protected $connection = 'cto';

    public function inspection() {
        return $this->belongsTo('App\Models\CTO\Inspection', 'inspectionID');
    }

    public function regulation() {
        return $this->belongsTo('App\Models\CTO\InspectionRegulation', 'regulationID');
    }
}
