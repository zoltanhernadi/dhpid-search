@extends ('layouts.ahrlayout')
@section('ahrmeta')
<meta property="dcterms.subject" title="gccore" content='{{__("Donor sperm and ova inspections search page")}}'>
@endsection
@section('frswitch')
    <a id="langfr" lang="fr" hreflang="fr" href="{{route(Route::currentRouteName(), ['language'=>'fr'])}}">
@endsection
@section('enswitch')
    <a id="langen" lang="en" hreflang="en" href="{{route(Route::currentRouteName(), ['language'=>'en'])}}">
@endsection
@section ('content')
    <h1 id="wb-cont">{{__("Donor sperm and ova inspections")}}</h1>
    <p>{{__("In Canada, donor sperm and ova (eggs) must meet safety standards before it can be used in assisted human reproduction (AHR). On February 24, 2020, new regulations came into force regarding the safety of sperm and ova which outline requirements for all establishments and health professionals who process, import, distribute or make use of donor sperm or ova (eggs) for the purpose of AHR.")}}</p>
    <p>{{__("To learn more about the donor sperm and ova inspections we conduct, visit ")}} <a href='{{__("https://www.canada.ca/en/health-canada/services/drugs-health-products/compliance-enforcement/assisted-human-reproduction/inspections.html")}}'>{{__("about donor sperm and ova inspections")}}</a> {{__("or browse these inspection results:")}}</p>
    <ul>
        <li><a href="{{route('result', ['language' => app()->getLocale()]) }}">{{__("Donor sperm and ova inspections in Canada search results")}}</a></li>
        <li><a href="{{route('result', ['establishmentName'=>'','referenceNum'=>'','location'=>'','prov'=>'','rating'=>'NC','registered'=>'','registrationNum'=>'','notification'=>'','activity'=>'','startDate'=>'','endDate'=>'','language' => app()->getLocale()])}}">{{__("Non-compliant donor sperm and ova inspections in Canada search results")}}</a></li>
	</ul>
	<p>{{__("You can also do your own search for donor sperm and ova inspections. These results are updated regularly.")}}</p>
    <p>{{__("Information")}} <a href='{{__("https://www.canada.ca/en/health-canada/services/inspecting-monitoring-drug-health-products/drug-health-product-inspections/about-donor-semen-inspections.html")}}'>{{__("about donor semen inspections")}}</a> {{__("conducted previously pursuant to the")}} <i>{{__("Processing and Distribution of Semen for Assisted Conception Regulations")}}</i> {{__("are available in the")}} <a href="{{__('https://www.drug-inspections.canada.ca/ds/index-en.html')}}">{{__("Drug and Health Product Inspection Database.")}}</a></p>
    <div role="alert" tabindex="0" id='topError'>
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
		<form action="{{route('result', ['language' => app()->getLocale()])}}" role="form" class="form-horizontal" id="form" novalidate>
			<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-4 control-label" for="establishmentName">{{__("Establishment name")}}:</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="establishmentName" id="establishmentName" size="10" value="{{ old('establishmentName') }}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="referenceNum">{{__("Reference number")}}:</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="referenceNum" id="referenceNum" size="10" value="{{ old('referenceNum') }}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="location">{{__("Location")}}:</label>
						<div class="col-md-8">
							<select class="form-control" name="location" id="location">
								<option label=" "></option>
								<option value="Canada">Canada</option>
								<option value="Other">{{__('Other')}}</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="prov">Province:</label>
						<div class="col-md-8">
							<select class="form-control" name="prov" id="prov">
								<option label=" "></option>
								<option value="AB">Alberta</option>
								<option value="BC">{{__('British Columbia')}}</option>
								<option value="MB">Manitoba</option>
								<option value="NB">{{__('New Brunswick')}}</option>
								<option value="NL">{{__('Newfoundland and Labrador')}}</option>
								<option value="NT">Northwest Territories</option>
								<option value="NS">{{__('Nova Scotia')}}</option>
								<option value="NU">Nunavut</option>
								<option value="ON">Ontario</option>
								<option value="PE">{{__('Prince Edward Island')}}</option>
								<option value="QC">{{__('Quebec')}}</option>
								<option value="SK">Saskatchewan</option>
								<option value="YT">Yukon</option>
							</select>
						</div>
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
					<div class="form-group">
						<label class="col-sm-4 control-label" for="registered">{{__("Currently registered")}}:</label>
						<div class="col-md-8">
							<select class="form-control" name="registered" id="registered">
								<option label=" "></option>
								<option value="Y">{{__('Yes')}}</option>
								<option value="N">{{__('No')}}</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="registrationNum">{{__("Registration number")}}:</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="registrationNum" id="registrationNum" size="10" value="{{ old('registrationNum') }}">
						</div>
					</div>
                    <div class="form-group">
						<label class="col-sm-4 control-label" for="notification">{{__("Notification")}}:</label>
						<div class="col-md-8">
							<select class="form-control" name="notification" id="notification">
								<option label=" "></option>
								<option value="Y">{{__('Yes')}}</option>
								<option value="N">{{__('No')}}</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="activity">{{__("Activity")}}:</label>
						<div class="col-md-8">
							<select class="form-control" name="activity" id="activity">
								<option label=" "></option>
								<option value="Processing">{{__('Processing')}}</option>
								<option value="Importing">{{__('Importing')}}</option>
								<option value="Distributing">{{__('Distributing')}}</option>
								<option value="Making use">{{__('Making use')}}</option>
							</select>
						</div>
					</div>
					<div class="form-group">
                            <label class="col-sm-4 control-label" for="startDate">{{__("Inspection start date")}}:</label>
						    <div class="col-md-8">
							    <input class="form-control" type="date" name="startDate" id="startDate" data-rule-dateiso="true" value="{{ old('startDate') }}" min="2012-01-01" />
						    </div>
                        @if(isset($er['startDate']) && !isset($er['site']))
                            <section class="col-sm-4 alert alert-danger">
                                <h5>{{__('Invalid Inspection Dates')}}</h5>
                                {{__($er['startDate'])}}
                            </section>
                        @else
                            <div id="startError"></div>
                        @endif
					</div>
					<div class="form-group">
                            <label class="col-sm-4 control-label" for="endDate">{{__("Inspection end date")}}:</label>
                            <div class="col-md-8">
                                <input class="form-control" type="date" name="endDate" id="endDate" data-rule-dateiso="true" value="{{ old('endDate') }}" min="2012-01-01" />
                            </div>
                        @if(isset($er['endDate']) && !isset($er['site']))
                            <section class=" col-sm-4 alert alert-danger">
                                <h5>{{__('Invalid Inspection Dates')}}</h5>
                                {{__($er['endDate'])}}
                            </section>
                        @else
                            <div id="endError"></div>
                        @endif
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
	<p>{{__("If you have further questions, please")}} <a href="mailto:hc.bpcp-pcpb.sc@canada.ca">{{__("email Biological Product Compliance Program")}}</a></p>
	<script>
	$('#location').on('change',function(e){
            e.preventDefault();
			if ($.trim(this.value) === 'Other'){
				$('#prov').val('').prop('disabled',true).closest('div').hide("slow");
			}else{
				$('#prov').prop('disabled', false).closest('div').show('slow');
			}
		}).change();

        $('#endDate').focusout(function(){
            datesChecker();
        });
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
            var edate = new Date($('#endDate').val());
            var min = new Date('2012-01-01');
            var count = 0;
            if(sdate == "Invalid Date" && $('#startDate').val() != ''){
                $('#topError').show();
                var html = "<section class='alert alert-danger'><h3>{{__('Error')}}</h3>{{__('Inspection start date - Please enter a value less than or equal to ')}}"+now.toISOString().split('T')[0]+".</section>";
                var list = "<li id='1'><a href='#startDate'>{{__('Inspection start date - Please enter a value less than or equal to ')}}"+now.toISOString().split('T')[0]+".</a></li>";
                $('#startError').empty();
                $('#startError').append(html);
                $('#0').remove();
                $('#1').remove();
                $('#2').remove();
                $('#3').remove();
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
                $('#3').remove();
                $('#errorList').append(list);
                $('#form').attr('onsubmit','return false;');
                $('#submit').attr('disabled', true);
                count++;
            }
            else if(sdate>now){
                $('#topError').show();
                var html = "<section class='alert alert-danger'><h3>{{__('Error')}}</h3>{{__('Inspection start date - Please enter a value less than or equal to ')}}"+now.toISOString().split('T')[0]+".</section>";
                var list = "<li id='1'><a href='#startDate'>{{__('Inspection start date - Please enter a value less than or equal to ')}}"+now.toISOString().split('T')[0]+".</a></li>";
                $('#startError').empty();
                $('#startError').append(html);
                $('#0').remove();
                $('#1').remove();
                $('#2').remove();
                $('#3').remove();
                $('#errorList').append(list);
                $('#form').attr('onsubmit','return false;');
                $('#submit').attr('disabled', true);
                count++;
            }
            else{
                $("#startError").empty();
                $('#0').remove();
                $('#1').remove();
                $('#2').remove();
                $('#3').remove();
            }
            if($('#startDate').val()=='' && $('#endDate').val()!=''){
                $('#topError').show();
                var html = "<section class='alert alert-danger'><h3>{{__('Error')}}</h3>{{__('Inspection end date - Please enter inspection end date greater than or equal to inspection start date.')}}</section>";
                var list = "<li id='2'><a href='#endDate'>{{__('Inspection end date - Please enter inspection end date greater than or equal to inspection start date.')}}</a></li>";
                $('#startError').empty();
                $('#endError').empty();
                $('#endError').append(html);
                $('#0').remove();
                $('#1').remove();
                $('#2').remove();
                $('#3').remove();
                $('#4').remove();
                $('#5').remove();
                $('#6').remove();
                $('#errorList').append(list);
                $('#form').attr('onsubmit','return false;');
                $('#submit').attr('disabled', true);
                count++;
            }
            else if(edate == "Invalid Date" && $('#endDate').val() != ''){
                $('#topError').show();
                var html = "<section class='alert alert-danger'><h3>{{__('Error')}}</h3>{{__('Inspection end date - Please enter a value less than or equal to ')}}"+now.toISOString().split('T')[0]+".</section>";
                var list = "<li id='3'><a href='#endDate'>{{__('Inspection end date - Please enter a value less than or equal to ')}}"+now.toISOString().split('T')[0]+".</a></li>";
                $("#endError").empty();
                $('#endError').append(html);
                $('#3').remove();
                $('#4').remove();
                $('#5').remove();
                $('#6').remove();
                $('#errorList').append(list);
                $('#form').attr('onsubmit','return false;');
                $('#submit').attr('disabled', true);
                count++;
            }
            else if(edate>now){
                $('#topError').show();
                var html = "<section class='alert alert-danger'><h3>{{__('Error')}}</h3>{{__('Inspection end date - Please enter a value less than or equal to ')}}"+now.toISOString().split('T')[0]+".</section>";
                var list = "<li id='4'><a href='#endDate'>{{__('Inspection end date - Please enter a value less than or equal to ')}}"+now.toISOString().split('T')[0]+".</a></li>";
                $("#endError").empty();
                $('#endError').append(html);
                $('#3').remove();
                $('#4').remove();
                $('#5').remove();
                $('#6').remove();
                $('#errorList').append(list);
                $('#form').attr('onsubmit','return false;');
                $('#submit').attr('disabled', true);
                count++;
            }
            else if(sdate>edate){
                $('#topError').show();
                var html = "<section class='alert alert-danger'><h3>{{__('Error')}}</h3>{{__('Inspection end date - Please enter inspection end date greater than or equal to inspection start date.')}}</section>";
                var list = "<li id='5'><a href='#endDate'>{{__('Inspection end date - Please enter inspection end date greater than or equal to inspection start date.')}}</a></li>";
                $("#endError").empty();
                $('#endError').append(html);
                $('#3').remove();
                $('#4').remove();
                $('#5').remove();
                $('#6').remove();
                $('#errorList').append(list);
                $('#form').attr('onsubmit','return false;');
                $('#submit').attr('disabled', true);
                count++;
            }
            else if (edate<min){
                $('#topError').show();
                var html = "<section class='alert alert-danger'><h3>{{__('Error')}}</h3>{{__('Inspection end date - Please enter a value greater than or equal to ')}}"+min.toISOString().split('T')[0]+".</section>";
                var list = "<li id='6'><a href='#endDate'>{{__('Inspection end date - Please enter a value greater than or equal to ')}}"+min.toISOString().split('T')[0]+".</a></li>";
                $('#endError').empty();
                $('#endError').append(html);
                $('#3').remove();
                $('#4').remove();
                $('#5').remove();
                $('#6').remove();
                $('#errorList').append(list);
                $('#form').attr('onsubmit','return false;');
                $('#submit').attr('disabled', true);
                count++;
            }
            else{
                $("#endError").empty();
                $('#3').remove();
                $('#4').remove();
                $('#5').remove();
                $('#6').remove();
            }
            if(count==0){
                $('#topError').hide();
                $('#startError').empty();
                $('#errorList').empty();
                $('#endError').empty();
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
