<?php

namespace App\Http\Controllers\CTA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\CTA\ReportCard;

class ReportCardController extends Controller
{
    public function reportcard(Request $request){
        $id = $request->input('reportcard_id');
        $reportcard=ReportCard::where('id',$id)->first();
        return view('CTA.reportcard', ['reportcard'=>$reportcard]);
    }
}
