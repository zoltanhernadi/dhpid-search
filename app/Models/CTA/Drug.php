<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $connection= 'cta';
    public $timestamps=false;
    protected $fillable= [
        'drugName'
    ];
}
