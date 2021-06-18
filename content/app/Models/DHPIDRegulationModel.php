<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * This superclass is used for tables which have a foreign key "regulationID"
 */
abstract class DHPIDRegulationModel extends Model {
    public $timestamps=false;
    protected $fillable = ['id', 'en', 'fr', 'regulationID'];
}
