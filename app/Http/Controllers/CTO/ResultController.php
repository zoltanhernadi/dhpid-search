<?php

namespace App\Http\Controllers\CTO;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\CTO\Inspection;
use App\Models\CTO\Establishment;
use App\Models\CTO\Activity;
use App\Models\CTO\EstablishmentsActivity;
use App;

class ResultController extends Controller
{
    public function receive(Request $request) {
        // First, see if the site is marked Offline
        $status = DB::connection('cto')->table('site_status')->select('online', 'message_en', 'message_fr')->orderBy('id', 'DESC')->limit(1)->get()->first();
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
        $activity = $request->input('activity');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // First create the query builder for Inspections
        $inspections = Inspection::select('*');
        /* NOTE ABOUT JOINs
         * Calling $inspections->join() more than once will cause SQL errors.
         * Join to establishments once now because it is cheap to do even if unneeded.
         */
        //$inspections->join('establishments', 'inspections.establishmentID', '=', 'establishments.id');
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
        if (!empty($province)) {
            $establishments = Establishment::select('id')->where('addrProvince', $province)->get();
            $eids = array();
            foreach ($establishments as $e) {
                $eids[] = $e->id;
            }
            $inspections->whereIn('inspections.establishmentID', $eids);
        }
        if (!empty($rating)) {
            $inspections->where('rating', $rating);
        }
        if ($registered == 'Y') {
            $establishments = Establishment::select('id')->where('currentlyRegistered', '1')->get();
            $eids = array();
            foreach ($establishments as $e) {
                $eids[] = $e->id;
            }
            $inspections->whereIn('inspections.establishmentID', $eids);
        } elseif ($registered == 'N') {
            $establishments = Establishment::select('id')->where('currentlyRegistered', '0')->get();
            $eids = array();
            foreach ($establishments as $e) {
                $eids[] = $e->id;
            }
            $inspections->whereIn('inspections.establishmentID', $eids);
        }
        if (!empty($registrationNum)) {
            $establishments = Establishment::select('id')->where('registrationNumber', $registrationNum)->get();
            $eids = array();
            foreach ($establishments as $e) {
                $eids[] = $e->id;
            }
            $inspections->whereIn('inspections.establishmentID', $eids);
        }
        if (!empty($activity)) {
            $a=Activity::where(['en' => $activity])->first();
            $establishments=$a->establishments()->get();
            $eids = array();
            foreach ($establishments as $e) {
                $eids[] = $e->id;
            }
            $inspections->whereIn('inspections.establishmentID', $eids);
        }
        if (!empty($startDate)) {
            $inspections->where('inspectionStartDate', '>=', $startDate);
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
        if (!isset($params['activity'])) {
            $params['activity'] = '';
        }
        if (!isset($params['startDate'])) {
            $params['endDate'] = '';
        }
        if (!isset($params['endDate'])) {
            $params['endDate'] = '';
        }
        //to be used in return array $inspections->get()
        return view('CTO.result', ['inspections' => $inspections->get(), 'params' => $params]);
    }
}
