<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;

class InspectionRegulation extends Model
{
    protected $connection= 'cta';
    public $timestamps=false;
    protected $fillable = ['id', 'en', 'fr'];

    //one to many relationship method for regulations and deficiencies
    public function deficiencies(){
        return $this->hasMany('App\Models\CTA\Deficiency', 'regulationID');
    }
}