@extends('layouts.ctalayout')
@section('ctameta')
<meta property="dcterms.subject" title="gccore" content='{{__("Clinical trial inspections results page")}}'>
@endsection
@section('frswitch')
    <a id="langfr" lang="fr" hreflang="fr" href="{{route(Route::currentRouteName(), $params+['language'=>'fr'])}}">
@endsection
@section('enswitch')
    <a id="langen" lang="en" hreflang="en" href="{{route(Route::currentRouteName(), $params+['language'=>'en'])}}">
@endsection
@section('content')
    <h1 id="wb-cont">{{__("Clinical trial inspections")}}</h1>
    <section class="panel panel-default">
  		<header class="panel-heading">
   			<h2 class="panel-title">{{__("Search results")}}</h2>
        </header>
        <div class="panel-body container-fluid table-responsive">
            @if($params['rating'] == 'NC')
                <p>{{__("Below are the results for non-compliant clinical trial inspections.")}}</p>
                <p>{{__("You can also learn about what ")}}<a href='{{__("https://www.canada.ca/en/health-canada/services/inspecting-monitoring-drug-health-products/drug-health-product-inspections/about-inspections-clinical-trials-human-drugs.html#s4b")}}'>{{__("non-compliant clinical trial inspections")}}</a>{{__(" involve.")}}</p>
            @else
                <p>{{__("Below are the results for clinical trial inspections in Canada.")}}</p>
                <p>{{__("You can also learn about how ")}}<a href='{{__("https://www.canada.ca/en/health-canada/services/inspecting-monitoring-drug-health-products/drug-health-product-inspections/about-inspections-clinical-trials-human-drugs.html#s1")}}'>{{__("clinical trial inspections")}}</a>{{__(" are conducted in Canada and ")}}<a href='{{__("https://www.canada.ca/en/health-canada/services/inspecting-monitoring-drug-health-products/drug-health-product-inspections/about-inspections-clinical-trials-human-drugs.html#s3")}}'>{{__("what inspectors look for.")}}</a></p>
            @endif
            <table class="wb-tables table table-striped table-hover" id="resultTable" data-wb-tables='{ "ordering" : true, "order": [[ 3, "desc" ]] }' describedby="dataset-filter_info">
                <thead>
                    <tr>
                        <th class="sorting_asc" scope="col">{{__("Control number")}}</th>
                        <th class="sorting_asc" scope="col">{{__("Sponsor name")}}</th>
                        <th class="sorting_asc" scope="col">{{__("Region")}}</th>
                        <th class="sorting_asc" scope="col">{{__("Inspection start date")}}</th>
                        <th class="sorting_asc" scope="col">{{__("Drug name")}}</th>
                        <th class="sorting_asc" scope="col">{{__("Trial phase")}}</th>
                        <th class="sorting_asc" scope="col">{{__("Rating")}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inspections as $inspection)
                        <tr>
                            <td>{{$inspection->drugTrial->controlNumber}}</td>
                            <td><a href="{{route('ctasponsor',['sponsor_id'=> $inspection->sponsor->id, 'trial_id' => $inspection->trialID, 'phase_id' => $inspection->phaseID, 'language' => app()->getLocale()])}}">{{$inspection->sponsor->sponsorName}}</a></td>
                            @if(Config::get('app.locale')=="en")
                                <td>{{__($inspection->drugTrial->region->en)}}</td>
                            @else
                                <td>{{__($inspection->drugTrial->region->fr)}}</td>
                            @endif
                            <td>{{$inspection->inspectionStartDate}}</td>
                            <td>{{$inspection->drugTrial->drug->drugName}}</td>
                            <td>
                                @if(Config::get('app.locale')=="en")
                                    {{__($inspection->trialPhase->en)}}
                                @else
                                    {{__($inspection->trialPhase->fr)}}
                                @endif
                            </td>
                            <td>
                                @if($inspection->rating=='C')
                                        @if(isset($inspection->reportCard))
                                            <a href="{{route('ctareportcard',['reportcard_id'=> $inspection->reportCard->id, 'language' => app()->getLocale()])}}">{{__('Compliant')}}</a>
                                        @else
                                            @if (count($inspection->deficiencies) != 0)
                                                <a href="{{route('ctadeficiencies',['inspection_id'=> $inspection->id, 'language' => app()->getLocale()])}}">{{__('Compliant')}}</a>
                                            @else
                                                {{__('Compliant')}}
                                            @endif
                                        @endif
                                @elseif($inspection->rating=='NC')
                                    @if(isset($inspection->reportCard))
                                        <a href="{{route('ctareportcard',['reportcard_id'=> $inspection->reportCard->id, 'language' => app()->getLocale()])}}">{{__('Non-Compliant')}}</a>
                                    @else
                                        {{__('Non-Compliant')}}
                                    @endif
                                @else
                                    <a href="{{route('ctadeficiencies',['inspection_id'=> $inspection->id, 'language' => app()->getLocale()])}}">{{__($inspection->rating)}}</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
         </div>
    </section>
@endsection
