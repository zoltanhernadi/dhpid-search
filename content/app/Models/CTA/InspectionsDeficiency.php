<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;

class InspectionsDeficiency extends Model
{
    protected $connection= 'cta';
    public $timestamps=false;
    protected $table = 'inspections_deficiencies';
    protected $fillable = ['inspectionID', 'deficiencyID', 'observationNumber', 'lineNumber'];
}
