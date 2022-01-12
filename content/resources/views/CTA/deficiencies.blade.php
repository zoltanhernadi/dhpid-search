@extends('layouts.ctalayout')
@section('ctameta')
    <meta property="dcterms.subject" title="gccore" content='{{__("Clinical trial inspections deficiencies page")}}'>
@endsection
@section('frswitch')
    <a id="langfr" lang="fr" hreflang="fr" href="{{route(Route::currentRouteName(), ['inspection_id'=> $inspection->id, 'language'=>'fr'])}}">
@endsection
@section('enswitch')
    <a id="langen" lang="en" hreflang="en" href="{{route(Route::currentRouteName(), ['inspection_id'=> $inspection->id, 'language'=>'en'])}}">
@endsection
@section ('content')
    <h1 id="wb-cont">{{__("Clinical trial inspections")}}</h1>
    <section class="panel panel-default">
        <div class="panel-heading container-fluid">
            <div class="row">
                <h2 class="col-sm-6 mrgn-tp-0 h3 mrgn-bttm-0">{{__("Initial inspection deficiencies")}}</h2>
                <div class="col-sm-6 text-right">
                    @if($inspection->reportCard!=null)
                        <a href="{{route('ctareportcard',['reportcard_id'=> $inspection->reportCard->id, 'language' => app()->getLocale()])}}">{{__("Inspection report card")}}</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="panel-body container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <p>{{__("This report provides an overview of the initial deficiencies found during our inspection. We post this report within 3 days of an inspection as part of our commitment to openness and transparency. Within 30 days of the inspection, we post a more detailed final report card.")}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="active">
                                <th scope="col">{{__('Sponsor name')}}</th>
                                <th scope="col">{{__('Control number')}}</th>
                                <th scope="col">{{__('Inspection start date')}}</th>
                                <th scope="col">{{__('Inspection end date')}}</th>
                                <th scope="col">{{__('Type of inspection')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="{{route('ctasponsor',['sponsor_id'=> $inspection->sponsor->id, 'trial_id'=>$inspection->trialID, 'phase_id'=>$inspection->phaseID, 'language' => app()->getLocale()])}}">{{$inspection->sponsor->sponsorName}}</a></td>
                                <td>{{$inspection->drugTrial->controlNumber}}</td>
                                <td>{{$inspection->inspectionStartDate}}</td>
                                <td>{{$inspection->inspectionEndDate}}</td>
                                @if(Config::get('app.locale')=="en")
                                    <td>{{$inspection->inspectionType->en}}</td>
                                @else
                                    <td>{{$inspection->inspectionType->fr}}</td>
                                @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <header class="panel-heading">
   			<h2 class="panel-title">{{__("Categories of inspection deficiencies")}}</h2>
		</header>
        <div class="panel-body container-fluid">
            <div class="row">
                <div class="col-sm-12 table-responsive">
                    <table class="wb-tables table table-striped table-hover" data-wb-tables='{ "ordering" : true }'>
                        <thead>
                            <tr class="active">
                                <th class="sorting_asc" scope="col">{{__('Regulation')}}</th>
                                <th class="sorting_asc" scope="col">{{__('Deficiencies')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $check=false;
                                $innercheck=false;
                                foreach($inspection->deficiencies as $d){
                                    if($check==false){
                                        $dnum=$d->pivot->observationNumber;
                                        $check=true;
                                        echo '<tr>';
                                        if(Config::get('app.locale')=='en'){
                                            echo '<td>'.$d->regulation->en.'</td>';
                                        }
                                        else{
                                            echo '<td>'.$d->regulation->fr.'</td>';
                                        }
                                        echo '<td><ul>';
                                    }
                                    if($d->pivot->observationNumber == $dnum){
                                        if(Config::get('app.locale')=='en'){
                                            echo'<li>'.$d->en.'</li>';
                                        }
                                        else{
                                            echo'<li>'.$d->fr.'</li>';
                                        }
                                    }
                                    else{
                                        echo'</ul></tr>';
                                        echo '<tr>';
                                        if(Config::get('app.locale')=='en'){
                                            echo '<td>'.$d->regulation->en.'</td>';
                                        }
                                        else{
                                            echo '<td>'.$d->regulation->fr.'</td>';
                                        }
                                        echo '<td><ul>';
                                        if(Config::get('app.locale')=='en'){
                                            echo'<li>'.$d->en.'</li>';
                                        }
                                        else{
                                            echo'<li>'.$d->fr.'</li>';
                                        }
                                        $dnum=$d->pivot->observationNumber;
                                    }
                                }
                            @endphp
                           {{--  @foreach($inspection->deficiencies as $d)
                                <tr>
                                    @if(Config::get('app.locale')=="en")
                                        <td>{{$d->regulation->en}}</td>
                                        <td>{{$d->en}}</td>
                                    @else
                                        <td>{{$d->regulation->fr}}</td>
                                        <td>{{$d->fr}}</td>
                                    @endif
                                </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
        </div>
    </section>

@endsection
