<?php

namespace App\Models\CTO;

use Illuminate\Database\Eloquent\Model;

class ReportCardRegulation extends Model
{
    public $timestamps=false;
    protected $fillable = ['id', 'en', 'fr'];
    protected $table = "report_card_regulations";
    protected $connection= 'cto';

    //one to many relationship method for regulations and deficiencies
    public function observations() {
        return $this->hasMany('App\Models\CTO\Observation', 'regulationID');
    }
}
