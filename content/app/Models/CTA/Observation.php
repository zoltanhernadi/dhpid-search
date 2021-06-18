<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;
use App\Models\DHPIDRegulationModel;

class Observation extends DHPIDRegulationModel {

    protected $connection= 'cta';

    public function regulation(){
        return $this->belongsTo('App\Models\CTA\ReportCardRegulation', 'regulationID');
    }

    public function reportcard() {
        return $this->belongsToMany(
            'App\Models\CTA\ReportCard',
            'App\Models\CTA\ReportCardsObservation',
            'observationID',
            'reportcardID'
        )->withPivot('observationNumber','lineNumber')->orderBy('observationNumber','asc')->orderBy('lineNumber','asc');
    }
}