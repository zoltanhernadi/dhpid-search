<?php

namespace App\Models\CTO;

use Illuminate\Database\Eloquent\Model;

class InspectionsDeficiency extends Model
{
    public $timestamps=false;
    protected $table = 'inspections_deficiencies';
    protected $fillable = ['inspectionID', 'deficiencyID', 'observationNumber', 'lineNumber'];
    protected $connection= 'cto';
}
