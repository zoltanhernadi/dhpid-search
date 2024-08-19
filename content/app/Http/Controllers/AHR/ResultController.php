<?php

namespace App\Http\Controllers\AHR;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\AHR\Inspection;
use App\Models\AHR\Establishment;
use App\Models\AHR\Activity;
use App\Models\AHR\EstablishmentsActivity;
use App;

class ResultController extends Controller
{
    public function receive(Request $request){
        // First, see if the site is marked Offline
        $status = DB::table('site_status')->select('online', 'message_en', 'message_fr')->orderBy('id', 'DESC')->limit(1)->get()->first();
        if (!$status->online) {
            // TODO: Check which language the user is using and send the appropriate message along
            if(app()->getLocale()=="en"){
                return back()->withInput($request->all())->with('er', array('status'=>$status->message_en));
            }
            else{
                return back()->withInput($request->all())->with('er', array('status'=>$status->message_fr));
            }
        }
        $establishmentName = $request->input('establishmentName');
        $referenceNum = $request->input('referenceNum');
        $location = $request->input('location');
        $province = $request->input('prov');
        $rating = $request->input('rating');
        $registered = $request->input('registered');
        $registrationNum = $request->input('registrationNum');
        $notification = $request->input('notification');
        $activity = $request->input('activity');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // First create the query builder for Inspections
        $inspections = Inspection::select('*');
        /* NOTE ABOUT JOINs
         * Calling $inspections->join() more than once will cause SQL errors.
         * Join to establishments once now because it is cheap to do even if unneeded.
         */
        $inspections->join('establishments', 'inspections.establishmentID', '=', 'establishments.id');
        /* NOTE ABOUT "OR WHERE" / ->orWhere()
         * Using Eloquent ->orWhere() for one search criterion affects all
         * other search criteria after it! Use with caution!
         */

        // Next add the filters which the user has specified
        if (!empty($establishmentName)) {
            $establishments = Establishment::select('id')->where('name', 'LIKE', '%'.$establishmentName.'%')->get();
            $eids = array();
            foreach ($establishments as $e) {
                $eids[] = $e->id;
            }
            $inspections->whereIn('inspections.establishmentID', $eids);
        }
        if (!empty($referenceNum)) {
            $establishments = Establishment::select('id')->where('referenceNumber', $referenceNum)->get();
            $eids = array();
            foreach ($establishments as $e) {
                $eids[] = $e->id;
            }
            $inspections->whereIn('inspections.establishmentID', $eids);
        }
        // if location ‘other’ is selected, option to select province should disappear.
        if ($location == 'Canada') {
            $inspections->where('establishments.addrCountry', 'Canada');
        } elseif ($location == 'Other') {
            $inspections->where('establishments.addrCountry', '!=', 'Canada');
        }
        if (!empty($province)) {
            $inspections->where('establishments.addrProvince', $province);
        }
        if (!empty($rating)) {
            $inspections->where('rating', $rating);
        }
        if ($registered == 'Y') {
            $inspections->where('establishments.currentlyRegistered', '1');
        } elseif ($registered == 'N') {
            $inspections->where('establishments.currentlyRegistered', '0');
        }
        if (!empty($registrationNum)) {
            $inspections->where('establishments.registrationNumber', $registrationNum);
        }
        if ($notification == 'Y') {
            $inspections->where('establishments.notification', '1');
        } elseif ($notification == 'N') {
            $inspections->where('establishments.notification', '0');
        }
        if (!empty($activity)) {
            $a = Activity::select('id')->where('en', $activity)->first();
            $inspections->join('establishments_activities', 'establishments.id', '=', 'establishments_activities.establishmentID')
                        ->where('establishments_activities.activityID', $a->id);
        }
        if (!empty($startDate)) {
            $inspections->where('inspections.inspectionStartDate', '>=', $startDate);
            if (!empty($endDate)) {
                $inspections->where('inspectionEndDate', '<=', $endDate);
            }
        } elseif (empty($startDate) && !empty($endDate)) {
            return back()->withInput($request->all())->with('er', array('endDate'=>'Inspection end date - Please enter inspection end date greater than or equal to inspection start date'));
        }
        $params=$request->all();
        if (!isset($params['establishmentName'])) {
            $params['establishmentName'] = '';
        }
        if (!isset($params['referenceNum'])) {
            $params['referenceNum'] = '';
        }
        if (!isset($params['location'])) {
            $params['location'] = '';
        }
        if (!isset($params['prov'])) {
            $params['prov'] = '';
        }
        if (!isset($params['rating'])) {
            $params['rating'] = '';
        }
        if (!isset($params['registered'])) {
            $params['registered'] = '';
        }
        if (!isset($params['registrationNum'])) {
            $params['registrationNum'] = '';
        }
        if (!isset($params['notification'])) {
            $params['notification'] = '';
        }
        if (!isset($params['activity'])) {
            $params['activity'] = '';
        }
        if (!isset($params['startDate'])) {
            $params['startDate'] = '';
        }
        if (!isset($params['endDate'])) {
            $params['endDate'] = '';
        }

        return view('AHR.result', ['inspections' => $inspections->get(), 'params' => $params]);
    }
}
