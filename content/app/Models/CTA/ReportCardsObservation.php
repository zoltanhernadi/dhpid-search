<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;

class ReportCardsObservation extends Model
{
    protected $connection= 'cta';
    public $timestamps=false;
    protected $table = 'report_cards_observations';
    protected $fillable = ['reportCardID', 'observationID', 'observationNumber', 'lineNumber'];
}
