<?php

namespace App\Models\CTO;

use Illuminate\Database\Eloquent\Model;

class InspectionRegulation extends Model
{
    public $timestamps=false;
    protected $fillable = ['id', 'en', 'fr'];
    protected $table = "inspection_regulations";
    protected $connection= 'cto';

    //one to many relationship method for regulations and deficiencies
    public function deficiencies() {
        return $this->hasMany('App\Models\CTO\Deficiency', 'deficiencyID');
    }
}
