<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;
use App\Models\DHPIDReferenceModel;

class ActionTaken extends DHPIDReferenceModel
{
    protected $connection = 'cta';
    protected $table="actions_taken";

    public function reportcard() {
        return $this->hasManyThrough(
            'App\Models\CTA\ReportCard',
            'App\Models\CTA\ReportCardsMeasure',
            'measureTakenID',
            'reportCardID'
        );
    }

}
