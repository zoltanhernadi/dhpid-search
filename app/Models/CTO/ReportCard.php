<?php

namespace App\Models\CTO;

use Illuminate\Database\Eloquent\Model;

class ReportCard extends Model
{
    //public $timestamps=false;
    protected $fillable = ['reportCardID', 'inspectionID'];
    protected $table = "report_cards";
    protected $connection = 'cto';

    public function establishment() {
        return $this->hasOneThrough(
            'App\Models\CTO\Establishment',
            'App\Models\CTO\Inspection',
            'inspectionID',
            'establishmentID'
        );
    }

    public function inspection() {
        return $this->belongsTo('App\Models\CTO\Inspection', 'inspectionID');
    }

    public function measuresTaken() {
        return $this->belongsToMany(
            'App\Models\CTO\MeasureTaken',
            'App\Models\CTO\ReportCardsMeasure',
            'reportCardID',
            'measureTakenID'
        );
    }

    public function outcomes() {
        return $this->belongsToMany(
            'App\Models\CTO\InspectionOutcome',
            'App\Models\CTO\ReportCardsOutcome',
            'reportCardID',
            'outcomeID'
        );
    }

    public function observations() {
        return $this->belongsToMany(
            'App\Models\CTO\Observation', 
            'App\Models\CTO\ReportCardsObservation', 
            'reportCardID', 
            'observationID'
        )->withPivot('observationNumber','lineNumber')
         ->orderBy('observationNumber','asc')
         ->orderBy('lineNumber', 'asc');
    }
}
