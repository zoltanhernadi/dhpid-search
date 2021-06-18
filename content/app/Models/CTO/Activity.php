<?php

namespace App\Models\CTO;

use Illuminate\Database\Eloquent\Model;
use App\Models\DHPIDReferenceModel;

class Activity extends DHPIDReferenceModel {
    protected $table = "activities";
    protected $connection = 'cto';

    public function establishments() {
        return $this->belongsToMany(
        Establishment::class,
        'establishments_activities',
        'activityID', 'establishmentID');
    }
}
