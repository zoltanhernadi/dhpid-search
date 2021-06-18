<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;
use App\Models\DHPIDReferenceModel;

class Region extends DHPIDReferenceModel
{
    protected $connection= 'cta';
    public $timestamps=false;
    protected $fillable= [
        'en',
        'fr'
    ];
}
