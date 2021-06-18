<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;

class ReportCard extends Model
{
    protected $connection= 'cta';
    protected $fillable = ['reportCardID', 'inspectionID'];

    public function inspection() {
        return $this->belongsTo('App\Models\CTA\Inspection', 'inspectionID');
    }

    public function actionsTaken() {
        return $this->belongsToMany(
            'App\Models\CTA\ActionTaken',
            'App\Models\CTA\ReportCardsAction',
            'reportCardID',
            'actionTakenID'
        );
    }

    public function outcomes() {
        return $this->belongsToMany(
            'App\Models\CTA\InspectionOutcome',
            'App\Models\CTA\ReportCardsOutcome',
            'reportCardID',
            'outcomeID'
        );
    }

    public function observations() {
        return $this->belongsToMany(
            'App\Models\CTA\Observation', 
            'App\Models\CTA\ReportCardsObservation', 
            'reportCardID', 
            'observationID'
        )->withPivot('observationNumber','lineNumber')
         ->orderBy('observationNumber','asc')
         ->orderBy('lineNumber', 'asc');
    }
}
