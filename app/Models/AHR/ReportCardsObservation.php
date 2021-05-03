<?php

namespace App\Models\AHR;

use Illuminate\Database\Eloquent\Model;

class ReportCardsObservation extends Model
{
    public $timestamps=false;
    protected $table = 'report_cards_observations';
    protected $fillable = ['reportCardID', 'observationID', 'observationNumber', 'lineNumber'];
}
