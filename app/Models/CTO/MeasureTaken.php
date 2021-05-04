<?php

namespace App\Models\CTO;

use Illuminate\Database\Eloquent\Model;
use App\Models\DHPIDReferenceModel;

class MeasureTaken extends DHPIDReferenceModel
{
    protected $table = 'measures_taken';
    protected $connection = 'cto';

    public function reportcard() {
        return $this->hasManyThrough(
            'App\Models\CTO\ReportCard',
            'App\Models\CTO\ReportCardsMeasure',
            'measureTakenID',
            'reportCardID'
        );
    }
}
