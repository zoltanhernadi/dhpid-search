<?php

namespace App\Models\AHR;

use Illuminate\Database\Eloquent\Model;

class ReportCard extends Model
{
    //public $timestamps=false;
    protected $fillable = ['reportCardID', 'inspectionID'];
    protected $table = "report_cards";

    public function establishment() {
        return $this->hasOneThrough(
            'App\Models\AHR\Establishment',
            'App\Models\AHR\Inspection',
            'inspectionID',
            'establishmentID'
        );
    }

    public function inspection() {
        return $this->belongsTo('App\Models\AHR\Inspection', 'inspectionID');
    }

    public function measuresTaken() {
        return $this->belongsToMany(
            'App\Models\AHR\MeasureTaken',
            'App\Models\AHR\ReportCardsMeasure',
            'reportCardID',
            'measureTakenID'
        );
    }

    public function outcomes() {
        return $this->belongsToMany(
            'App\Models\AHR\Outcome',
            'App\Models\AHR\ReportCardsOutcome',
            'reportCardID',
            'outcomeID'
        );
    }

    public function observations() {
        return $this->belongsToMany(
            'App\Models\AHR\Observation', 
            'App\Models\AHR\ReportCardsObservation', 
            'reportCardID', 
            'observationID')->withPivot('observationNumber','lineNumber')->orderBy('observationNumber','asc')->orderBy('lineNumber', 'asc');
    }
}
