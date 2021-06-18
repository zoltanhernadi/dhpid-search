<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;

class TrialPhase extends Model
{
    protected $connection= 'cta';
    public $timestamps=false;
    protected $fillable= [
        'en',
        'fr'
    ];
}
