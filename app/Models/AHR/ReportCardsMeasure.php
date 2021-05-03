<?php

namespace App\Models\AHR;

use Illuminate\Database\Eloquent\Model;

class ReportCardsMeasure extends Model
{
    public $timestamps=false;
    protected $table = 'report_cards_measures';
    protected $fillable = ['reportCardID', 'measuresTakenID'];
}
