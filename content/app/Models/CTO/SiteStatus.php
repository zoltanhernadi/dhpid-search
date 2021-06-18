<?php

namespace App\Models\CTO;

use Illuminate\Database\Eloquent\Model;

class SiteStatus extends Model
{
        protected $table = 'site_status';
        protected $fillable = ['online','message_en', 'message_fr'];
        protected $connection='cto';


}
