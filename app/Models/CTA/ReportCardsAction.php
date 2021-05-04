<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;

class ReportCardsAction extends Model
{
    protected $connection= 'cta';
    public $timestamps=false;
    protected $table = 'report_cards_actions';
    protected $fillable = ['reportCardID', 'actionTakenID'];
}
