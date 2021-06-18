<?php

namespace App\Models\AHR;

use Illuminate\Database\Eloquent\Model;

class ReportCardRegulation extends Model
{
    public $timestamps=false;
    protected $fillable = ['id', 'en', 'fr'];
    protected $table = "report_card_regulations";

    //one to many relationship method for regulations and deficiencies
    public function observations() {
        return $this->hasMany('App\Models\AHR\Observation', 'regulationID');
    }
}
