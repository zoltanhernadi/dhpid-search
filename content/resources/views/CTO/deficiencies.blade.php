@extends ('layouts.layout')
@section('title')
    <title>{{__("Cells, tissues and organs (CTO) inspections")}}</title>
@endsection
@section('translate')
    @if (Config::get('app.locale')=="en")
        <section id="wb-lng" class="col-xs-3 col-sm-12 pull-right text-right">
		    <h2 class="wb-inv">Language selection</h2>
		    <ul class="list-inline mrgn-bttm-0">
			    <li>
				    <a id="langfr" lang="fr" hreflang="fr" href="{{route(Route::currentRouteName(), ['inspection_id'=> $inspection->id, 'language'=>'fr'])}}">
					    <span class="hidden-xs">Français</span>
					     <abbr id="abfr" title="Français" class="visible-xs h3 mrgn-tp-sm mrgn-bttm-0 text-uppercase">Fr</abbr>
				    </a>
			    </li>
		    </ul>
	    </section>
    @elseif (Config::get('app.locale')=="fr")
        <section id="wb-lng" class="col-xs-3 col-sm-12 pull-right text-right">
            <h2 class="wb-inv">Language selection</h2>
            <ul class="list-inline mrgn-bttm-0">
                <li>
                    <a id="langen" lang="en" hreflang="en" href="{{route(Route::currentRouteName(), ['inspection_id'=> $inspection->id, 'language'=>'en'])}}">
                        <span class="hidden-xs">English</span>
                        <abbr id="abfr" title="English" class="visible-xs h3 mrgn-tp-sm mrgn-bttm-0 text-uppercase">En</abbr>
                    </a>
                </li>
            </ul>
        </section>
    @endif
@endsection
@section ('content')
    <h1 id="wb-cont">{{__("Cells, tissues and organs (CTO) inspections")}}</h1>
    <section class="panel panel-default">
        <div class="panel-heading container-fluid">
            <div class="row">
                <h2 class="col-sm-6 mrgn-tp-0 h3 mrgn-bttm-0">{{__("Initial inspection deficiencies")}}</h2>
                <div class="col-sm-6 text-right"> 
                    @if($inspection->reportCard!=null)
                        <a href="{{route('ctoreportcard',['reportcard_id'=> $inspection->reportCard->id, 'language' => app()->getLocale()])}}">{{__("Inspection report card")}}</a>
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
                                <th scope="col">{{__('Establishment name')}}</th>
                                <th scope="col">{{__('Reference number')}}</th>
                                <th scope="col">{{__('Inspection start date')}}</th>
                                <th scope="col">{{__('Inspection end date')}}</th>
                                <th scope="col">{{__('Inspection type')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="{{route('ctoestablishment',['establishment_id'=> $inspection->establishment->id, 'language' => app()->getLocale()])}}">{{$inspection->establishment->name}}</a></td>
                                <td>{{$inspection->establishment->referenceNumber}}</td>
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
                            @foreach($inspection->deficiencies as $d)
                                <tr>
                                    @if(Config::get('app.locale')=="en")
                                        <td>{{$d->regulation->en}}</td>
                                        <td>{{$d->en}}</td>
                                    @else
                                        <td>{{$d->regulation->fr}}</td>
                                        <td>{{$d->fr}}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </section>

@endsection
