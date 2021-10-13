@extends('layouts.ctalayout')
@section('ctameta')
<meta property="dcterms.subject" title="gccore" content='{{__("Clinical trial inspections search page")}}'>
@endsection
@section('frswitch')
    <a id="langfr" lang="fr" hreflang="fr" href="{{route(Route::currentRouteName(), ['language'=>'fr'])}}">
@endsection
@section('enswitch')
    <a id="langen" lang="en" hreflang="en" href="{{route(Route::currentRouteName(), ['language'=>'en'])}}">
@endsection
@section ('content')
    <h1 id="wb-cont">{{__("Clinical trial inspections")}}</h1>
    <p>{{__("Clinical trials in Canada for human drugs must meet high safety standards. Canada inspects clinical trials to reduce the risks to people participating in the trials.")}}</p>
    <p>{{__("To learn more about the clinical trial inspections we conduct, you can visit ")}} <a href='{{__("https://www.canada.ca/en/health-canada/services/inspecting-monitoring-drug-health-products/drug-health-product-inspections/about-inspections-clinical-trials-human-drugs.html")}}'>{{__("about clinical trial inspections")}}</a> {{__("or browse these inspection results:")}}</p>
    <ul>
        <li><a href="{{ route('ctaresult', ['language' => app()->getLocale()]) }}">{{__("Clinical trial inspections search results")}}</a></li>
        <li><a href="{{route('ctaresult', ['sponsorName'=>'','controlNumber'=>'','region'=>'','drug'=>'', 'rating'=>'NC','phase'=>'', 'startDate'=>'','endDate'=>'','language' => app()->getLocale()])}}">{{__("Non-compliant clinical trial inspections search results")}}</a></li>
	</ul>
	<p>{{__("You can also do your own search for clinical trial inspections. These results are updated regularly. Please note that the name of a drug could change over the course of a clinical trial.")}}</p>
    <div role="alert" id='topError' tabindex="0">
        <section class='alert alert-danger'>
            <div id='Title'>
            </div>
            <ul id="errorList"></ul>
        </section>
    </div>
    <div role="alert" tabindex="0">
        @if (session('er')==true)
            @php
                $er=session('er');
            @endphp
            @if(isset($er['status']))
                <section class="alert alert-danger">
                    <h2>{{__('Error')}}</h2>
                    <p>{{__($er['status'])}}</p>
                </section>
            @else
                @foreach($er as $e)
                    <section class="alert alert-danger">
                        <h2>{{__('Error')}}</h2>
                        <p>{{__($e)}}</p>
                    </section>
                @endforeach
            @endif
        @endif
    </div>
    <section class="panel panel-default">
  		<header class="panel-heading">
   			<h2 class="panel-title">{{__("Search")}}</h2>
		</header>
		<form action="{{route('ctaresult', ['language' => app()->getLocale()])}}" role="form" class="form-horizontal" id="form" novalidate>
			<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-4 control-label" for="sponsorName">{{__("Sponsor name")}}:</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="sponsorName" id="sponsorName" size="10" value="{{ old('sponsorName') }}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="controlNumber">{{__("Control number")}}:</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="controlNumber" id="controlNumber" size="10" value="{{ old('controlNum') }}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="region">{{__("Region")}}:</label>
						<div class="col-md-8">
							<select class="form-control" name="region" id="region">
								<option label=" "></option>
								<option value=1>Alberta</option>
								<option value=2>{{__('Atlantic (New Brunswick, Nova Scotia, Prince Edward Island, Newfoundland and Labrador)')}}</option>
								<option value=3>{{__('British Columbia')}}</option>
								<option value=4>Ontario</option>
								<option value=5>{{__('Manitoba and Saskatchewan')}}</option>
								<option value=6>{{__('Quebec')}}</option>
                            </select>
						</div>
					</div>
                    <div class="form-group">
						<label class="col-sm-4 control-label" for="drug">{{__("Drug name")}}:</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="drug" id="drug" size="10" value="{{ old('drug') }}">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-sm-4 control-label" for="phase">{{__("Trial phase")}}:</label>
						<div class="col-md-8">
							<select class="form-control" name="phase" id="phase">
								<option label=" "></option>
								<option value=1>Phase 1</option>
								<option value=2>Phase 1/2</option>
								<option value=3>Phase 2</option>
								<option value=4>Phase 2/3</option>
								<option value=5>Phase 3</option>
								<option value=6>{{__('Other')}}</option>
                            </select>
						</div>
					</div>
					<div class="form-group">
                            <label class="col-sm-4 control-label" for="startDate">{{__("Inspection start date")}}:</label>
						    <div class="col-md-8">
							    <input class="form-control" type="date" name="startDate" id="startDate" data-rule-dateiso="true" value="{{ old('startDate') }}" min="2012-01-01" />
						    </div>
                        @if(isset($er['startDate']) && !isset($er['site']))
                            <section class=" col-sm-4 alert alert-danger">
                                <h5>{{__('Invalid Inspection Dates')}}</h5>
                                {{__($er['startDate'])}}
                            </section>
                        @else
                            <div id="startError"></div>
                        @endif
					</div>
                    <div class="form-group">
						<label class="col-sm-4 control-label" for="rating">{{__("Rating")}}:</label>
						<div class="col-md-8">
							<select class="form-control" name="rating" id="rating">
								<option label=" "></option>
								<option value="C">{{__('Compliant')}}</option>
								<option value="NC">{{__('Non-Compliant')}}</option>
								<option value="Inspection in progress">{{__('Inspection in progress')}}</option>
							</select>
						</div>
					</div>
			</div>
			<footer class="panel-footer">
						<div class="foot text-center">
							<button id="submit" type="submit" class="btn btn-primary">{{__("Submit")}}</button>
							<button onClick="window.location.reload();" type="reset" class="btn btn-default">{{__("Reset")}}</button>
						</div>
			</footer>
		</form>
        </section>
	<p>{{__("If you have further questions, please email ")}} <a href="mailto:gcp_bpc@hc-sc.gc.ca">{{__("Health Canada")}}</a></p>
	<script>
        $('#startDate').focusout(function(){
            datesChecker();
        });

        $(document).ready(function(){
            $('#startDate').attr('max', function(){
                return new Date().toISOString().split('T')[0];
            });
        });

        $(document).ready(function(){
            $('#endDate').attr('max', function(){
                return new Date().toISOString().split('T')[0];
            });
        });

        window.onload=datesChecker();
        function datesChecker(){
            var now = new Date();
            var sdate = new Date($('#startDate').val());
            var min = new Date('2012-01-01');
            var count =0;
            if(sdate == "Invalid Date" && $('#startDate').val() != ''){
                $('#topError').show();
                var html = "<section class='alert alert-danger'><h3>{{__('Error')}}</h3>{{__('Inspection start date - Please enter a value less than or equal to ')}}"+now.toISOString().split('T')[0]+".</section>";
                var list = "<li id='1'><a href='#startDate'>{{__('Inspection start date - Please enter a value less than or equal to ')}}"+now.toISOString().split('T')[0]+".</a></li>";
                $('#startError').empty();
                $('#startError').append(html);
                $('#0').remove();
                $('#1').remove();
                $('#2').remove();
                $('#errorList').append(list);
                $('#form').attr('onsubmit','return false;');
                $('#submit').attr('disabled', true);
                count++;
            }
            else if (sdate<min){
                $('#topError').show();
                var html = "<section class='alert alert-danger'><h3>{{__('Error')}}</h3>{{__('Inspection start date - Please enter a value greater than or equal to ')}}"+min.toISOString().split('T')[0]+".</section>";
                var list = "<li id='0'><a href='#startDate'>{{__('Inspection start date - Please enter a value greater than or equal to ')}}"+min.toISOString().split('T')[0]+".</a></li>";
                $('#startError').empty();
                $('#startError').append(html);
                $('#0').remove();
                $('#1').remove();
                $('#2').remove();
                $('#errorList').append(list);
                $('#form').attr('onsubmit','return false;');
                $('#submit').attr('disabled', true);
                count++;
            }
            else if(sdate>now){
                $('#topError').show();
                var html = "<section class='alert alert-danger'><h3>{{__('Error')}}</h3>{{__('Inspection start date - Please enter a value less than or equal to ')}}"+now.toISOString().split('T')[0]+".</section>";
                var list = "<li id='2'><a href='#startDate'>{{__('Inspection start date - Please enter a value less than or equal to ')}}"+now.toISOString().split('T')[0]+".</a></li>";
                $('#startError').empty();
                $('#startError').append(html);
                $('#0').remove();
                $('#1').remove();
                $('#2').remove();
                $('#errorList').append(list);
                $('#form').attr('onsubmit','return false;');
                $('#submit').attr('disabled', true);
                count++;
            }
            if(count==0){
                $('#topError').hide();
                $('#startError').empty();
                $('#errorList').empty();
                $('#form').attr('onsubmit','return true;');
                $('#submit').attr('disabled', false);
            }
            else if(count==1){
                $('#Title').empty();
                $('#Title').append("<h2 id='errorTitle'>{{__('The form could not be submitted because ')}}"+count+"{{__(' error was found')}}</h2>");
            }
            else{
                $('#Title').empty();
                $('#Title').append("<h2 id='errorTitle'>{{__('The form could not be submitted because ')}}"+count+"{{__(' errors were found.')}}");
            }
        }
	</script>
@endsection
