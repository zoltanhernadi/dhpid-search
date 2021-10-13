@extends('layouts.ctalayout')
@section('ctameta')
<meta property="dcterms.subject" title="gccore" content='{{__("Clinical trial inspections report card")}}'>
@endsection
@section('frswitch')
    <a id="langfr" lang="fr" hreflang="fr" href="{{route(Route::currentRouteName(), ['reportcard_id'=> $reportcard->id, 'language'=>'fr'])}}">
@endsection
@section('enswitch')
    <a id="langen" lang="en" hreflang="en" href="{{route(Route::currentRouteName(), ['reportcard_id'=> $reportcard->id, 'language'=>'en'])}}">
@endsection
@section('content')
    <h1 id="wb-cont">{{__("Clinical trial inspections")}}</h1>
    <section class="panel panel-default">
        <div class="panel-heading container-fluid">
            <div class="row">
                <h2 class="col-sm-6 mrgn-tp-0 h3 mrgn-bttm-0">{{__("Inspection report card summary")}}</h2>
                <div class="col-sm-6 text-right">
                    <a href="{{route('ctadeficiencies',['inspection_id'=> $reportcard->inspection->id, 'language' => app()->getLocale()])}}">{{__("Initial inspection deficiencies report")}}</a>
                </div>
            </div>
        </div>
        <div class="panel-body container-fluid">
            <div class="row">
                <div class="col-sm-12 table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="active">
                                <th scope="col">{{__('Sponsor name')}}</th>
                                <th scope="col">{{__('Control number')}}</th>
                                <th scope="col">{{__('Inspection start date')}}</th>
                                <th scope="col">{{__('Type of inspection')}}</th>
                                <th scope="col">{{__('Rating')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="{{route('ctasponsor',['sponsor_id'=> $reportcard->inspection->sponsor->id, 'trial_id'=>$reportcard->inspection->trialID, 'phase_id'=>$reportcard->inspection->phaseID, 'language' => app()->getLocale()])}}">{{$reportcard->inspection->sponsor->sponsorName}}</a></td>
                                <td>{{$reportcard->inspection->drugTrial->controlNumber}}</td>
                                <td>{{$reportcard->inspection->inspectionStartDate}}</td>
                                @if(Config::get('app.locale')=="en")
                                    <td>{{$reportcard->inspection->inspectionType->en}}</td>
                                @else
                                    <td>{{$reportcard->inspection->inspectionType->fr}}</td>
                                @endif
                                @if($reportcard->inspection->rating=='C')
                                    <td>{{__('Compliant')}}</td>
                                @elseif($reportcard->inspection->rating=='NC')
                                    <td>{{__('Non-Compliant')}}</td>
                                @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <header class="panel-heading container-fluid">
            <div class="row">
                <h2 class="col-sm-6 panel-title mrgn-top-0">{{__("Summary of observations")}}</h2>
            </div>
        </header>
        <div class="panel-body container-fluid">
            <div class="row">
                <div class="col-sm-12 table-responsive">
                    <table class="wb-tables table table-striped table-hover" data-wb-tables='{ "ordering" : true }'>
                        <thead>
                            <tr class="active">
                                <th class="sorting_asc" scope="col">{{__('Observation number')}}</th>
                                <th class="sorting_asc" scope="col">{{__('Regulation')}}</th>
                                <th class="sorting_asc" scope="col">{{__('Summary of observation')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $check=false;
                                $innercheck=false;
                                foreach($reportcard->observations as $o){
                                    if($check==false){
                                        $onum=$o->pivot->observationNumber;
                                        $check=true;
                                        echo '<tr>';
                                        echo '<td>'.$o->pivot->observationNumber.'</td>';
                                        if(Config::get('app.locale')=='en'){
                                            echo '<td>'.$o->regulation->en.'</td>';
                                        }
                                        else{
                                            echo '<td>'.$o->regulation->fr.'</td>';
                                        }
                                        echo '<td><ul>';
                                    }
                                    if($o->pivot->observationNumber == $onum){
                                        if(Config::get('app.locale')=='en'){
                                            echo'<li>'.$o->en.'</li>';
                                        }
                                        else{
                                            echo'<li>'.$o->fr.'</li>';
                                        }
                                    }
                                    else{
                                        echo'</ul></tr>';
                                        echo '<tr>';
                                        echo '<td>'.$o->pivot->observationNumber.'</td>';
                                        if(Config::get('app.locale')=='en'){
                                            echo '<td>'.$o->regulation->en.'</td>';
                                        }
                                        else{
                                            echo '<td>'.$o->regulation->fr.'</td>';
                                        }
                                        echo '<td><ul>';
                                        if(Config::get('app.locale')=='en'){
                                            echo'<li>'.$o->en.'</li>';
                                        }
                                        else{
                                            echo'<li>'.$o->fr.'</li>';
                                        }
                                        $onum=$o->pivot->observationNumber;
                                    }
                                }
                            @endphp
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel-heading container-fluid">
            <div class="row">
                <h2 class="col-sm-6 panel-title" style="margin: 0;">{{__("Inspection outcome")}}</h2>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    @foreach($reportcard->outcomes as $outcome)
                        @if(Config::get('app.locale')=="en")
                            <p>{{$outcome->en}}</p>
                        @else
                            <p>{{$outcome->fr}}</p>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="panel-heading container-fluid">
            <div class="row">
                <h2 class="col-sm-6 panel-title" style="margin: 0;">{{__("Measures taken by Health Canada")}}</h2>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <ul>
                        @foreach($reportcard->actionsTaken as $m)
                            @if(Config::get('app.locale')=="en")
                                <li>{{$m->en}}</li>
                            @else
                                <li>{{$m->fr}}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

@endsection
