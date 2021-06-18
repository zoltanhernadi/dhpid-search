<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;

class ReportCardRegulation extends Model
{
    protected $connection= 'cta';
    protected $fillable = ['id', 'en', 'fr'];
    public $timestamps=false;
    //one to many relationship method for regulations and observations
    public function observations(){
        return $this->hasMany('App\Models\CTA\Observation', 'regulationID');
    }
}
