@extends('layouts.layout')
@section('title')
    <title>{{__("Donor sperm and ova inspections")}}</title>
@endsection
@section('translate')
    @if (Config::get('app.locale')=="en")
        <section id="wb-lng" class="col-xs-3 col-sm-12 pull-right text-right">
		    <h2 class="wb-inv">Language selection</h2>
		    <ul class="list-inline mrgn-bttm-0">
			    <li>
				    <a id="langfr" lang="fr" hreflang="fr" href="{{route(Route::currentRouteName(), ['establishment_id'=> $establishment->id, 'language'=>'fr'])}}">
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
                    <a id="langen" lang="en" hreflang="en" href="{{route(Route::currentRouteName(), ['establishment_id'=> $establishment->id, 'language'=>'en'])}}">
                        <span class="hidden-xs">English</span>
                        <abbr id="abfr" title="English" class="visible-xs h3 mrgn-tp-sm mrgn-bttm-0 text-uppercase">En</abbr>
                    </a>
                </li>
            </ul>
        </section>
    @endif
@endsection
@section ('content')
    <h1>{{__("Donor sperm and ova inspections")}}</h1>
    <section class="panel panel-default">
  		<header class="panel-heading">
   			<h2 class="panel-title">{{__("Establishment information")}}</h2>
		</header>
        <div class="panel-body container-fluid">
            <div class="row">
                <div class="col-sm-3 col-sm-offset-2"><label>{{__("Establishment name")}}:</label></div>
                <div class="col-sm-6">{{$establishment->name}}</div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-sm-offset-2"><label>{{__("Address")}}:</label></div>
                <div class="col-sm-3">
                    <p name="address">{{$establishment->addrStreet}}
                    <br>
                    @php
                        //checks to see if establishment country is in canada and if so calls province function which returns full name of province based on code
                    @endphp
                    @if($establishment->addrCountry == 'Canada')
                        {{$establishment->addrCity}}, {{__($establishment->province())}}
                    @else
                        {{$establishment->addrCity}}, {{$establishment->addrProvince}}
                    @endif
                    <br>
                    {{$establishment->addrCountry}}
                    <br>
                    {{$establishment->addrPostalCode}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-sm-offset-2"><label>{{__("Reference number")}}:</label></div>
                <div class="col-sm-3">{{$establishment->referenceNumber}}</div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-sm-offset-2"><label>{{__("Registration number")}}:</label></div>
                <div class="col-sm-3">{{$establishment->registrationNumber}}</div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-sm-offset-2"><label>{{__("Notification")}}:</label></div>
                <div class="col-sm-3">
                    @if($establishment->notification == 1)
                        {{__("Yes")}}
                    @else  
                        {{__("No")}}
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-sm-offset-2"><label>{{__("Activity(ies)")}}:</label></div>
                <div class="col-sm-3">
                    <ul>
                        @foreach($establishment->activities as $a)
                            @if(Config::get('app.locale')=="en")
                                <li>{{$a->en}}</li>
                            @else
                                <li>{{$a->fr}}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <header class="panel-heading">
   			<h2 class="panel-title">{{__("Inspection information")}}</h2>
		</header>
        <div class="panel-body container-fluid">
            <div class="row">
                <div class="col-md-3 col-md-offset-2"><label>{{__("Inspection")}}:</label></div>
                <div class="col-md-7">
                    <table class="wb-tables table table-striped table-hover" data-wb-tables='{ "ordering" : true, "order": [[ 3, "desc" ]] }'>
                        <thead>
                            <tr>
                            <th scope="col">{{__('Inspection start date')}}</th>
                            <th scope="col">{{__('Inspection rating')}}</th>
                            <th scope="col">{{__('Inspection type')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($establishment->inspections as $i)
                                <tr>
                                    <td>{{$i->inspectionStartDate}}</td>
                                    @if($i->rating=='C')
                                        <td><a href="{{route('reportcard',['reportcard_id'=> $i->reportCard->id, 'language' => app()->getLocale()])}}">{{__('Compliant')}}</a></td>
                                    @elseif($i->rating=='NC')
                                        <td><a href="{{route('reportcard',['reportcard_id'=> $i->reportCard->id, 'language' => app()->getLocale()])}}">{{__('Non-Compliant')}}</a></td>
                                    @else
                                        <td><a href="{{route('deficiencies',['inspection_id'=> $i->id, 'language' => app()->getLocale()])}}">{{__($i->rating)}}</a></td>
                                    @endif
                                    @if(Config::get('app.locale')=="en")
                                        <td>{{$i->inspectionType->en}}</td>
                                    @else
                                        <td>{{$i->inspectionType->fr}}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </section>
    
@endsection