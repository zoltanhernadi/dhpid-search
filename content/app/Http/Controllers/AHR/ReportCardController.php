<?php

namespace App\Http\Controllers\AHR;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\AHR\ReportCard;

class ReportCardController extends Controller
{
    public function reportcard(Request $request){
        $establishmentName=$request->input('establishmentName');
        $referenceNum=$request->input('referenceNum');
        $location=$request->input('location');
        $province=$request->input('prov');
        $rating=$request->input('rating');
        $registered=$request->input('registered');
        $registrationNum=$request->input('registrationNum');
        $activity=$request->input('activity');
        $startDate=$request->input('startDate');
        $id = $request->input('reportcard_id');
        //print_r($id);
        //$inspections=DB::table('inspections')->where('Establishment_Name',$establishmentName)
        //->orwhere('Reference_Number',$referenceNum)
        //->orwhere('Location_EN',$location)
        //->orwhere('Province',$province)
        //->orwhere('Inspection_Rating',$rating)
        //->orwhere('Currently_Registered',$registered)
        //->orwhere('Registration_Number', $registrationNum)
        //->orwhere('Activities_EN',$activity)
        //->orwhere('Inspection_Start_Date',$startDate)
        //->get();
        //print_r($inspections);
        $reportcard=ReportCard::where('id',$id)->first();
        return view('AHR.reportcard', ['reportcard'=>$reportcard]);
    }
    //$inspections=DB::selection()
}
