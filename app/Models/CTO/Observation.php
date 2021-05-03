<?php

namespace App\Models\CTO;

use Illuminate\Database\Eloquent\Model;

class Observation extends DHPIDRegulationModel {
    protected $table = "observations";

    public function reportcard() {
        return $this->belongsToMany(
            'App\Models\CTO\ReportCard',
            'App\Models\CTO\ReportCardsObservation',
            'observationID',
            'reportcardID'
        )->withPivot('observationNumber','lineNumber')->orderBy('observationNumber','asc')->orderBy('lineNumber','asc');
    }

    public function regulation() {
        return $this->belongsTo('App\Models\CTO\ReportCardRegulation', 'regulationID');
    }
}
