<?php

namespace App\Models\CTO;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    //public $timestamps=false;
    protected $table = "inspections";
    protected $fillable = ['id', 'establishmentID', 'inspectionStartDate', 'inspectionEndDate', 'rating', 'inspectionTypeID'];
    protected $connection = 'cto';

    public function establishment() {
        return $this->belongsTo('App\Models\CTO\Establishment', 'establishmentID');
    }

    public function deficiencies() {
        // Use hasManyThrough() instead of hasMany() to obtain extra
        // fields like Observation Number and Line Number.
        return $this->belongsToMany(
            'App\Models\CTO\Deficiency',
            'App\Models\CTO\InspectionsDeficiency',
            'inspectionID',
            'deficiencyID'
        )->withPivot('observationNumber','lineNumber')->orderBy('observationNumber','asc')->orderBy('lineNumber', 'asc');
    }

    public function inspectionType() {
        return $this->hasOne('App\Models\CTO\InspectionType', 'id', 'inspectionTypeID');
    }

    public function reportCard() {
        return $this->hasOne('App\Models\CTO\ReportCard', 'inspectionID');
    }
}
