<?php

namespace App\Models\AHR;

use Illuminate\Database\Eloquent\Model;

/**
 * This superclass is used for all 2-column reference tables
 */
abstract class DHPIDReferenceModel extends Model {
    public $timestamps=false;
    protected $fillable = ['id', 'en', 'fr'];

    /**
     * Look up a reference string ID by both EN and FR text.
     *
     * Return numeric ID on success, 0 on failure.
     */
    public function get_id_by_text($en, $fr) {
        $result = $this::select('id')->where([['en', $en], ['fr', $fr]])->first();
        return intval($result->id);
    }
}
