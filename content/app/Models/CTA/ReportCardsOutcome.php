<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;

class ReportCardsOutcome extends Model
{
    protected $connection= 'cta';
    public $timestamps=false;
    protected $table = 'report_cards_outcomes';
    protected $fillable = ['reportCardID', 'OutcomeID'];
}
