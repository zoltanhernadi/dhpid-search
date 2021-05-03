<?php

namespace App\Models\AHR;

use Illuminate\Database\Eloquent\Model;

class Activity extends DHPIDReferenceModel {
    protected $table = "activities";

    public function establishments() {
        return $this->hasOneThrough(
            'App\Models\AHR\Establishment',
            'App\Models\AHR\EstablishmentsActivity',
            'activityID',
            'establishmentID'
        );
    }
}
