<?php

namespace App\Http\Controllers\CTA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\CTA\Inspection;
use App\Models\CTA\Sponsor;
use App\Models\CTA\DrugTrial;
use App\Models\CTA\Drug;
use App;

class ResultController extends Controller
{
    public function receive(Request $request) {
        // First, see if the site is marked Offline
        $status = DB::connection('cta')->table('site_status')->select('online', 'message_en', 'message_fr')->orderBy('id', 'DESC')->limit(1)->get()->first();
        if (!$status->online) {
            // TODO: Check which language the user is using and send the appropriate message along
            if(app()->getLocale()=="en"){
                return back()->withInput($request->all())->with('er', array('status'=>$status->message_en));
            }
            else{
                return back()->withInput($request->all())->with('er', array('status'=>$status->message_fr));
            }
        }
        $sponsorName = $request->input('sponsorName');
        $controlNumber = $request->input('controlNumber');
        $region = $request->input('region');
        $drug = $request->input('drug');
        $rating = $request->input('rating');
        $phase = $request->input('phase');
        $startDate = $request->input('startDate');

        // First create the query builder for Inspections
        $inspections = Inspection::select('*');
        /* NOTE ABOUT JOINs
         * Calling $inspections->join() more than once will cause SQL errors.
         * Join to sponsors once now because it is cheap to do even if unneeded.
         */
        //$inspections->join('sponsors', 'inspections.sponsorID', '=', 'sponsors.id');
        /* NOTE ABOUT "OR WHERE" / ->orWhere()
         * Using Eloquent ->orWhere() for one search criterion affects all
         * other search criteria after it! Use with caution!
         */

        // Next add the filters which the user has specified
        if (!empty($sponsorName)) {
            $sids = Sponsor::where('sponsorName', 'LIKE', '%'.$sponsorName.'%')->get()->pluck('id');
            /*$sids = array();
            foreach ($sponsors as $s) {
                $sids[] = $s->id;
            }*/
            $tids = DrugTrial::select('id')->whereIn('sponsorID', $sids)->get()->pluck('id');
            /*$tids = array();
            foreach ($trials as $t) {
                $tids[] = $t->id;
            }*/
            $inspections->whereIn('trialID', $tids);
        }
        if (!empty($controlNumber)) {
            $tids = DrugTrial::select('id')->where('controlNumber', $controlNumber)->get()->pluck('id');
            /*$tids = array();
            foreach ($trials as $t) {
                $tids[] = $t->id;
            }*/
            $inspections->whereIn('trialID', $tids);
        }
        if (!empty($region)){
            $tids = DrugTrial::where('regionID', $region)->get()->pluck('id');
            /*$tids = array();
            foreach ($trials as $t) {
                $tids[] = $t->id;
            }*/
            $inspections->whereIn('trialID', $tids);
        }
        if (!empty($drug)){
            $drugids = Drug::where('drugName', 'LIKE', '%'.$drug.'%')->get()->pluck('id');
            $tids = DrugTrial::where('drugID', $drugids)->pluck('id');
            $inspections->whereIn('trialID', $tids);
        }
        if (!empty($phase)){
            $inspections->where('phaseID', $phase);
        }
        if (!empty($startDate)) {
            $inspections->where('inspectionStartDate', '>=', $startDate);
        }
        if (!empty($rating)) {
            $inspections->where('rating', $rating);
        }
        $params=$request->all();
        if (!isset($params['sponsorName'])) {
            $params['sponsorName'] = '';
        }
        if (!isset($params['controlNumber'])) {
            $params['controlNumber'] = '';
        }
        if (!isset($params['region'])) {
            $params['region'] = '';
        }
        if (!isset($params['drug'])) {
            $params['drug'] = '';
        }
        if (!isset($params['phase'])) {
            $params['phase'] = '';
        }
        if (!isset($params['startDate'])) {
            $params['endDate'] = '';
        }
        if (!isset($params['rating'])) {
            $params['rating'] = '';
        }
        //to be used in return array $inspections->get()
        return view('CTA.result', ['inspections' => $inspections->get(), 'params' => $params]);
    }
}
