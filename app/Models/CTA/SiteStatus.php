<?php

namespace App\Models\CTA;

use Illuminate\Database\Eloquent\Model;

class SiteStatus extends Model
{
    protected $connection= 'cta';
    protected $table = 'site_status';
    protected $fillable = ['online', 'message_en', 'message_fr'];
}
