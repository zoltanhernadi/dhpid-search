<?php

namespace App\Http\Controllers\AHR;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\AHR\Establishment;
use App\Models\AHR\Inspection;

class EstablishmentController extends Controller
{
    public function establishmentPage(Request $request){
        $establishmentName=$request->input('establishmentName');
        $referenceNum=$request->input('referenceNum');
        $location=$request->input('location');
        $province=$request->input('prov');
        $rating=$request->input('rating');
        $registered=$request->input('registered');
        $registrationNum=$request->input('registrationNum');
        $activity=$request->input('activity');
        $startDate=$request->input('startDate');
        $id = $request->input('establishment_id');

        $establishment=Establishment::where('id',$id)->first();
        // Fetch all Establishments having the same Reference Number
        $references=Establishment::where('referenceNumber',$establishment->referenceNumber)->get();
        // Fetch all Inspections belonging to this Reference Number
        $inspections = array();
        foreach ($references as $r) {
            // We use first() to obtain one record assuming that each Establishment record is
            // associated with one and only one Inspection record.
            array_push($inspections, Inspection::where('establishmentID',$r->id)->first());
        }
        $establishment->inspections=$inspections;
        return view('AHR.establishment', ['establishment'=>$establishment]);//, ['inspections'=>$inspections]);
    }
}
