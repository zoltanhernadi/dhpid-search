<?php

namespace App\Http\Controllers\CTA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\CTA\Sponsor;
use App\Models\CTA\DrugTrial;
use App\Models\CTA\Inspection;
use App\Models\CTA\TrialPhase;

class SponsorController extends Controller
{
    public function sponsorPage(Request $request){
        $trialid = $request->input('trial_id');
        $id = $request->input('sponsor_id');
        $phaseid = $request->input('phase_id');
        $sponsor = Sponsor::where('id',$id)->first();
        $trial = DrugTrial::where('id', $trialid)->first();
        $inspections = Inspection::where(['trialID' => $trialid, 'phaseID' => $phaseid])->get();
        $phase = TrialPhase::where('id', $phaseid)->first();
        return view('CTA.sponsor', ['sponsor'=>$sponsor, 'trial' => $trial, 'inspections' => $inspections, 'phase' => $phase]);//, ['inspections'=>$inspections]);
    }
    //$inspections=DB::selection()
}
