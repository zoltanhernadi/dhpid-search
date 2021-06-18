<?php

namespace App\Models\AHR;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    //public $timestamps=false;
    protected $table = "inspections";
    protected $fillable = ['id', 'establishmentID', 'inspectionStartDate', 'inspectionEndDate', 'rating', 'inspectionTypeID'];

    public function establishment() {
        return $this->belongsTo('App\Models\AHR\Establishment', 'establishmentID');
    }

    public function deficiencies() {
        // Use hasManyThrough() instead of hasMany() to obtain extra
        // fields like Observation Number and Line Number.
        return $this->belongsToMany(
            'App\Models\AHR\Deficiency', 
            'App\Models\AHR\InspectionsDeficiency', 
            'inspectionID', 
            'deficiencyID');
    }

    public function inspectionType(){
        return $this->hasOne('App\Models\AHR\InspectionType','id','inspectionTypeID');
    }

    public function reportCard(){
        return $this->hasOne('App\Models\AHR\ReportCard','inspectionID');
    }
}
