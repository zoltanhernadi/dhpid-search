<?php

namespace App\Http\Controllers\CTA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\CTA\Inspection;

class InitialDeficienciesController extends Controller
{
    public function deficiencies(Request $request){
        $id = $request->input('inspection_id');
        $inspection=Inspection::where('id',$id)->first();
        return view('CTA.deficiencies', ['inspection'=>$inspection]);//, ['inspections'=>$inspections]);
    }
    //$inspections=DB::selection()
}
