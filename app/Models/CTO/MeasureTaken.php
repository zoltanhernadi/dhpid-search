<?php

namespace App\Models\CTO;

use Illuminate\Database\Eloquent\Model;

class MeasureTaken extends DHPIDReferenceModel
{
    protected $table = 'measures_taken';

    public function reportcard() {
        return $this->hasManyThrough(
            'App\Models\CTO\ReportCard',
            'App\Models\CTO\ReportCardsMeasure',
            'measureTakenID',
            'reportCardID'
        );
    }
}
