<?php

namespace App\Models\AHR;

use Illuminate\Database\Eloquent\Model;

class ReportCardsOutcome extends Model
{
    public $timestamps=false;
    protected $table = 'report_cards_outcomes';
    protected $fillable = ['reportCardID', 'inspectionOutcomeID'];
}
