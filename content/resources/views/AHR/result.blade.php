@extends('layouts.ahrlayout')
@section('ahrmeta')
    <meta property="dcterms.subject" title="gccore" content='{{__("Donor sperm and ova inspections results page")}}'>
@endsection
@section('frswitch')
    <a id="langfr" lang="fr" hreflang="fr" href="{{route(Route::currentRouteName(), $params+['language'=>'fr'])}}">
@endsection
@section('enswitch')
    <a id="langen" lang="en" hreflang="en" href="{{route(Route::currentRouteName(), $params+['language'=>'en'])}}">
@endsection
@section('content')
    <h1 id="wb-cont">{{__("Donor sperm and ova inspections")}}</h1>
    <section class="panel panel-default">
  		<header class="panel-heading">
   			<h2 class="panel-title">{{__("Search results")}}</h2>
        </header>
        <div class="panel-body container-fluid table-responsive">
            @if($params['rating'] == 'NC')
                <p>{{__("Below are the results for non-compliant donor sperm and ova inspections in Canada.")}}</p>
                <p>{{__("You can also learn about what ")}}<a href='{{__("https://www.canada.ca/en/health-canada/services/drugs-health-products/compliance-enforcement/assisted-human-reproduction/inspections.html#a3")}}'>{{__("non-compliant donor sperm and ova inspections")}}</a>{{__(" involve.")}}</p>
            @else
                <p>{{__("Below are the results for the donor sperm and ova inspections in Canada.")}}</p>
                <p>{{__("You can also learn about how ")}}<a href='{{__("https://www.canada.ca/en/health-canada/services/drugs-health-products/compliance-enforcement/assisted-human-reproduction/inspections.html")}}'>{{__("donor sperm and ova inspections")}}</a>{{__(" are conducted in Canada and ")}}<a href='{{__("https://www.canada.ca/en/health-canada/services/drugs-health-products/compliance-enforcement/assisted-human-reproduction/inspections.html#a2")}}'>{{__("what inspectors look for.")}}</a></p>
            @endif
            <table class="wb-tables table table-striped table-hover" id="resultTable" data-wb-tables='{ "ordering" : true, "order": [[ 3, "desc" ]] }' describedby="dataset-filter_info">
                <thead>
                    <tr>
                        <th class="sorting_asc" scope="col">{{__("Reference number")}}</th>
                        <th class="sorting_asc" scope="col">{{__("Establishment name")}}</th>
                        <th class="sorting_asc" scope="col">Province</th>
                        <th class="sorting_asc" scope="col">{{__("Inspection start date")}}</th>
                        <th class="sorting_asc" scope="col">{{__("Rating")}}</th>
                        <th class="sorting_asc" scope="col">{{__("Currently registered")}}</th>
                        <th class="sorting_asc" scope="col">{{__("Currently notified")}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inspections as $inspection)
                        <tr>
                            <td>{{$inspection->establishment->referenceNumber}}</td>
                            <td><a href="{{route('establishment',['establishment_id'=> $inspection->establishmentID, 'language' => app()->getLocale()])}}">{{$inspection->establishment->name}}</a></td>
                            @php
                                //checks to see if establishment country is in canada and if so calls province function which returns full name of province based on code
                            @endphp
                            @if($inspection->establishment->addrCountry == 'Canada')
                                <td>{{__($inspection->establishment->province())}}</td>
                            @else
                                <td>{{$inspection->establishment->addrProvince}}</td>
                            @endif
                            <td>{{$inspection->inspectionStartDate}}</td>
                            @if($inspection->rating=='C')
                                <td><a href="{{route('reportcard',['reportcard_id'=> $inspection->reportCard->id, 'language' => app()->getLocale()])}}">{{__('Compliant')}}</a></td>
                            @elseif($inspection->rating=='NC')
                                <td><a href="{{route('reportcard',['reportcard_id'=> $inspection->reportCard->id, 'language' => app()->getLocale()])}}">{{__('Non-Compliant')}}</a></td>
                            @else
                                <td><a href="{{route('deficiencies',['inspection_id'=> $inspection->id, 'language' => app()->getLocale()])}}">{{__($inspection->rating)}}</a></td>
                            @endif
                            @if($inspection->establishment->currentlyRegistered == 1)
                                <td>{{__('Yes')}}</td>
                            @else
                                <td>{{__('No')}}</td>
                            @endif
                            @if($inspection->establishment->notification == 1)
                                <td>{{__('Yes')}}</td>
                            @else
                                <td>{{__('No')}}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
         </div>
    </section>
@endsection
