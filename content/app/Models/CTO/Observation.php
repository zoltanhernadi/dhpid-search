<?php

namespace App\Models\CTO;

use Illuminate\Database\Eloquent\Model;
use App\Models\DHPIDRegulationModel;

class Observation extends DHPIDRegulationModel {
    protected $table = "observations";
    protected $connection = 'cto';

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
