<?php

namespace App\Http\Controllers\CTO;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\CTO\Inspection;

class InitialDeficienciesController extends Controller
{
    public function deficiencies(Request $request){
        $establishmentName=$request->input('establishmentName');
        $referenceNum=$request->input('referenceNum');
        $location=$request->input('location');
        $province=$request->input('prov');
        $rating=$request->input('rating');
        $registered=$request->input('registered');
        $registrationNum=$request->input('registrationNum');
        $activity=$request->input('activity');
        $startDate=$request->input('startDate');
        $id = $request->input('inspection_id');
        //print_r($province);
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
        $inspection=Inspection::where('id',$id)->first();
        return view('CTO.deficiencies', ['inspection'=>$inspection]);//, ['inspections'=>$inspections]);
    }
    //$inspections=DB::selection()
}
