<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;
use App\Models\DHPIDRegulationModel;

class Deficiency extends DHPIDRegulationModel {

    protected $connection= 'cta';

    public function regulation(){
        return $this->belongsTo('App\Models\CTA\InspectionRegulation', 'regulationID');
    }

    public function inspection() {
        return $this->belongsTo('App\Models\CTA\Inspection', 'inspectionID');
    }

}