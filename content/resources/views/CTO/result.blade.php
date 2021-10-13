@extends ('layouts.ctolayout')
@section('title')
    <title>{{__("Cells, tissues and organs (CTO) inspections")}}</title>
@endsection
@section('ctometa')
<meta property="dcterms.subject" title="gccore" content='{{__("Cells, tissues and organs (CTO) inspections results page")}}'>
@endsection
@section('frswitch')
    <a id="langfr" lang="fr" hreflang="fr" href="{{route(Route::currentRouteName(), $params+['language'=>'fr'])}}">
@endsection
@section('enswitch')
    <a id="langen" lang="en" hreflang="en" href="{{route(Route::currentRouteName(), $params+['language'=>'en'])}}">
@endsection
@section('content')
    <h1 id="wb-cont">{{__("Cells, tissues and organs (CTO) inspections")}}</h1>
    <section class="panel panel-default">
  		<header class="panel-heading">
   			<h2 class="panel-title">{{__("Search results")}}</h2>
        </header>
        <div class="panel-body container-fluid table-responsive">
            @if($params['rating'] == 'NC')
                <p>{{__("Below are the results for non-compliant cells, tissues and organs (CTO) inspections in Canada.")}}</p>
                <p>{{__("You can also learn about what ")}}<a href='{{__("https://www.canada.ca/en/health-canada/services/inspecting-monitoring-drug-health-products/drug-health-product-inspections/about-cells-tissues-organs-cto-inspections.html#s3")}}'>{{__("non-compliant CTO inspections")}}</a>{{__(" involve.")}}</p>
            @else
                <p>{{__("Below are the results for cells, tissues and organs (CTO) inspections in Canada.")}}</p>
                <p>{{__("You can also learn about how ")}}<a href='{{__("https://www.canada.ca/en/health-canada/services/inspecting-monitoring-drug-health-products/drug-health-product-inspections/about-cells-tissues-organs-cto-inspections.html#s1")}}'>{{__("CTO inspections")}}</a>{{__(" are conducted in Canada and ")}}<a href='{{__("https://www.canada.ca/en/health-canada/services/inspecting-monitoring-drug-health-products/drug-health-product-inspections/about-cells-tissues-organs-cto-inspections.html#s2")}}'>{{__("what inspectors look for.")}}</a></p>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($inspections as $inspection)
                        <tr>
                            <td>{{$inspection->establishment->referenceNumber}}</td>
                            <td><a href="{{route('ctoestablishment',['establishment_id'=> $inspection->establishmentID, 'language' => app()->getLocale()])}}">{{$inspection->establishment->name}}</a></td>
                            @php
                                //checks to see if establishment country is in canada and if so calls province function which returns full name of province based on code
                            @endphp
                            <td>
                                @if($inspection->establishment->addrCountry == 'Canada')
                                    {{__($inspection->establishment->province())}}
                                @else
                                    {{$inspection->establishment->addrProvince}}
                                @endif
                            </td>
                            <td>{{$inspection->inspectionStartDate}}</td>
                            <td>
                                @if($inspection->rating=='C')
                                    @if(isset($inspection->reportCard))
                                        <a href="{{route('ctoreportcard',['reportcard_id'=> $inspection->reportCard->id, 'language' => app()->getLocale()])}}">{{__('Compliant')}}</a>
                                    @else
                                        @if (count($inspection->deficiencies) != 0)
                                            <a href="{{route('ctodeficiencies',['inspection_id'=> $inspection->id, 'language' => app()->getLocale()])}}">{{__('Compliant')}}</a>
                                        @else
                                            {{__('Compliant')}}
                                        @endif
                                    @endif
                                @elseif($inspection->rating=='NC')
                                    @if(isset($inspection->reportCard))
                                        <a href="{{route('ctoreportcard',['reportcard_id'=> $inspection->reportCard->id, 'language' => app()->getLocale()])}}">{{__('Non-Compliant')}}</a>
                                    @else
                                        {{__('Non-Compliant')}}
                                    @endif
                                @else
                                    <a href="{{route('ctodeficiencies',['inspection_id'=> $inspection->id, 'language' => app()->getLocale()])}}">{{__($inspection->rating)}}</a>
                                @endif
                            </td>
                            @if($inspection->establishment->currentlyRegistered == 1)
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
