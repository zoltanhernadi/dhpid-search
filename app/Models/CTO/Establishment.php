<?php

namespace App\Models\CTO;

use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    //public $timestamps=false;
    protected $table = "establishments";
    protected $fillable = ['id', 'referenceNumber', 'name', 'addrCity','addrProvince', 'addrStreet', 'addrPostalCode', 'addrCountry'];
    protected $connection = 'cto';

    public function activities() {
        return $this->belongsToMany('App\Models\CTO\Activity',
         'App\Models\CTO\EstablishmentsActivity', 
         'establishmentID', 
         'activityID'
        );
      }

    public function inspections() {
        return $this->hasMany('App\Models\CTO\Inspection', 'establishmentID');
    }

    public function reportcards() {
        $this->hasManyThrough(
            'App\Models\CTO\ReportCard',
            'App\Models\CTO\Inspection',
            'establishmentID',
            'inspectionID'
        );
    }
    // province function returns the full province name depending on current model province code
    public function province() {
        $provinces = [
            'AB' => 'Alberta',
            'BC' => 'British Columbia',
            'MB' => 'Manitoba',
            'NB' => 'New Brunswick',
            'NL' => 'Newfoundland and Labrador',
            'NT' => 'Northwest Territories',
            'NS' => 'Nova Scotia',
            'NU' => 'Nunavut',
            'ON' => 'Ontario',
            'PE' => 'Prince Edward Island',
            'QC' => 'Quebec',
            'SK' => 'Saskatchewan',
            'YT' => 'Yukon'
        ];
        return $provinces[$this->addrProvince];
    }
}
