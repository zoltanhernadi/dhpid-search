<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;

class DrugTrial extends Model
{
    protected $connection = 'cta';
    public $timestamps=false;
    protected $fillable = [
        'regionID',
        'drugID',
        'sponsorID',
        'controlNumber'
    ];

    public function region(){
        return $this->belongsTo(Region::class, 'regionID', 'id');
    }

    public function drug(){
        return $this->belongsTo(Drug::class, 'drugID', 'id');
    }

    public function sponsor(){
        return $this->belongsTo(Sponsor::class, 'sponsorID', 'id');
    }

    public function inspections(){
        return $this->hasmany(Inspection::class, 'trialID', 'id');
    }
}
