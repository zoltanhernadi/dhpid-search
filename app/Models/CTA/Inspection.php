<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    protected $connection= 'cta';
    protected $fillable=[
        'inspectionID',
        'trialID',
        'phaseID',
        'inspectionStartDate',
        'inspectionEndDate',
        'rating',
        'inspectionTypeID',
    ];

    public function sponsor() {
        return $this->hasOneThrough(Sponsor::class, DrugTrial::class, 'id', 'id', 'trialID', 'sponsorID');
    }

    public function deficiencies() {
        // Use hasManyThrough() instead of hasMany() to obtain extra
        // fields like Observation Number and Line Number.
        return $this->belongsToMany(
            'App\Models\CTA\Deficiency', 
            'App\Models\CTA\InspectionsDeficiency', 
            'inspectionID', 
            'deficiencyID'
        );
    }

    public function inspectionType() {
        return $this->hasOne('App\Models\CTA\InspectionType', 'id', 'inspectionTypeID');
    }

    public function reportCard() {
        return $this->hasOne('App\Models\CTA\ReportCard', 'inspectionID');
    }

    public function trialPhase(){
        return $this->belongsTo(TrialPhase::class, 'phaseID');
    }

    public function drugTrial(){
        return $this->belongsTo(DrugTrial::class, 'trialID', 'id');
    }
}
