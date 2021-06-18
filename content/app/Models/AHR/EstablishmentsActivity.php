<?php

namespace App\Models\AHR;

use Illuminate\Database\Eloquent\Model;

class EstablishmentsActivity extends Model
{
    public $timestamps=false;
    protected $table = 'establishments_activities';
    protected $fillable = ['establishmentID', 'activityID'];
}
