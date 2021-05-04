<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $connection= 'cta';
    public $timestamps=false;
    protected $fillable = [
        'id',
        'sponsorName',
        'registrationNumber',
        'addrCity',
        'addrProvince',
        'addrStreet',
        'addrPostalCode',
        'addrCountry',
    ];

    protected function trial(){
        return $this->hasMany(DrugTrial::class, 'sponsorID', 'id');
    }
}