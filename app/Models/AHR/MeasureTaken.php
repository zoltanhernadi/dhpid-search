<?php

namespace App\Models\AHR;

use Illuminate\Database\Eloquent\Model;

class MeasureTaken extends DHPIDReferenceModel
{
    protected $table = 'measures_taken';

    public function reportcard() {
        return $this->hasManyThrough(
            'App\Models\AHR\ReportCard',
            'App\Models\AHR\ReportCardsMeasure',
            'measureTakenID',
            'reportCardID'
        );
    }
}
