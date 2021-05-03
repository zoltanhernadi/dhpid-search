<?php

namespace App\Models\CTO;

use Illuminate\Database\Eloquent\Model;

class Activity extends DHPIDReferenceModel {
    protected $table = "activities";

    public function establishments() {
        return $this->belongsToMany(
        Establishment::class,
        'establishments_activities',
        'activityID', 'establishmentID');
    }
}
