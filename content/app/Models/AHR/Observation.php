<?php

namespace App\Models\AHR;

use Illuminate\Database\Eloquent\Model;
use App\Models\DHPIDRegulationModel;

class Observation extends DHPIDRegulationModel {
    protected $table = "observations";

    public function reportcard() {
        return $this->belongsToMany(
            'App\Models\AHR\ReportCard',
            'App\Models\AHR\ReportCardsObservation',
            'observationID',
            'reportcardID'
        )->withPivot('observationNumber','lineNumber')->orderBy('observationNumber','asc')->orderBy('lineNumber','asc');
    }

    public function regulation() {
        return $this->belongsTo('App\Models\AHR\ReportCardRegulation', 'regulationID');
    }
}
