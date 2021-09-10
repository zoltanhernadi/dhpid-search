@extends('layouts.layout')
@section('title')
    <title>{{__("Clinical trial inspections")}}</title>
@endsection
@section('translate')
    @if (Config::get('app.locale')=="en")
        <section id="wb-lng" class="col-xs-3 col-sm-12 pull-right text-right">
		    <h2 class="wb-inv">Language selection</h2>
		    <ul class="list-inline mrgn-bttm-0">
			    <li>
				    <a id="langfr" lang="fr" hreflang="fr" href="{{route(Route::currentRouteName(), ['sponsor_id'=> $sponsor->id, 'trial_id' =>$trial->id, 'phase_id' => $phase->id, 'language'=>'fr'])}}">
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
                    <a id="langen" lang="en" hreflang="en" href="{{route(Route::currentRouteName(), ['sponsor_id'=> $sponsor->id, 'trial_id' =>$trial->id, 'phase_id' => $phase->id, 'language'=>'en'])}}">
                        <span class="hidden-xs">English</span>
                        <abbr id="abfr" title="English" class="visible-xs h3 mrgn-tp-sm mrgn-bttm-0 text-uppercase">En</abbr>
                    </a>
                </li>
            </ul>
        </section>
    @endif
@endsection
@section ('content')
    <h1 id="wb-cont">{{__("Clinical trial inspection - site profile")}}</h1>
    <section class="panel panel-default">
  		<header class="panel-heading">
   			<h2 class="panel-title">{{__("Sponsor information")}}</h2>
		</header>
        <div class="panel-body container-fluid">
            <div class="row">
                <div class="col-sm-3 col-sm-offset-2"><label>{{__("Sponsor name")}}:</label></div>
                <div class="col-sm-6">{{$sponsor->sponsorName}}</div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-sm-offset-2"><label>{{__("Address")}}:</label></div>
                <div class="col-sm-6">
                    <p name="address">{{$sponsor->addrStreet}}
                        <br>
                        {{$sponsor->addrCity}}, {{$sponsor->addrProvince}}
                        <br>
                        {{$sponsor->addrCountry}}, {{$sponsor->addrPostalCode}}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-sm-offset-2"><label>{{__("Control number")}}:</label></div>
                <div class="col-sm-6">{{$trial->controlNumber}}</div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-sm-offset-2"><label>{{__("Region")}}:</label></div>
                <div class="col-sm-6">
                    <td>
                        @if(Config::get('app.locale')=="en")
                            {{$trial->region->en}}
                        @else
                            {{$trial->region->fr}}
                        @endif
                    </td>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-sm-offset-2"><label>{{__("Drug name")}}:</label></div>
                <div class="col-sm-6">{{$trial->drug->drugName}}</div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-sm-offset-2"><label>{{__("Trial phase")}}:</label></div>
                <div class="col-sm-6">    
                    <td>
                        @if(Config::get('app.locale')=="en")
                            {{$phase->en}}
                        @else
                            {{$phase->fr}}
                        @endif
                    </td>
                </div>
            </div>
        </div>
        <header class="panel-heading">
   			<h2 class="panel-title">{{__("Inspection information")}}</h2>
		</header>
        <div class="panel-body container-fluid">
            <div class="row">
                <div class="col-md-3 col-md-offset-2"><label>{{__("Inspection")}}:</label></div>
                <div class="col-md-7 table-responsive">
                    <table class="wb-tables table table-striped table-hover" data-wb-tables='{ "ordering" : true, "order": [[ 3, "desc" ]] }'>
                        <thead>
                            <tr>
                            <th scope="col">{{__('Inspection start date')}}</th>
                            <th scope="col">{{__('Inspection rating')}}</th>
                            <th scope="col">{{__('Inspection type')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inspections as $i)
                                <tr>
                                    <td>{{$i->inspectionStartDate}}</td>
                                    <td>
                                        @if($i->rating=='C')
                                            @if(isset($i->reportCard))
                                                <a href="{{route('ctareportcard',['reportcard_id'=> $i->reportCard->id, 'language' => app()->getLocale()])}}">{{__('Compliant')}}</a>
                                            @else
                                                @if (count($i->deficiencies) != 0)
                                                    <a href="{{route('ctadeficiencies',['inspection_id'=> $i->id, 'language' => app()->getLocale()])}}">{{__('Compliant')}}</a>
                                                @else
                                                    {{__('Compliant')}}
                                                @endif
                                            @endif
                                        @elseif($i->rating=='NC')
                                            <a href="{{route('ctareportcard',['reportcard_id'=> $i->reportCard->id, 'language' => app()->getLocale()])}}">{{__('Non-Compliant')}}</a>
                                        @else
                                            <a href="{{route('ctadeficiencies',['inspection_id'=> $i->id, 'language' => app()->getLocale()])}}">{{__($i->rating)}}</a>
                                        @endif
                                    </td>
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
