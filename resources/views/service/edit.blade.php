@extends('layouts.app')
@section('content')
<style>
.bootstrap-datetimepicker-widget table td span {
    width: 0px!important;
}
.table-condensed>tbody>tr>td {
    padding: 3px;
}
</style>

<!-- page content -->
	<div class="right_col" role="main">
		<div class="page-title">
			<div class="nav_menu">
				<nav>
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Service')}}</span></a>
					</div>
					@include('dashboard.profile')
				</nav>
			</div>
		</div>
		<div class="x_content">
			<ul class="nav nav-tabs bar_tabs" role="tablist">
				@can('service_view')
					<li role="presentation" class=""><a href="{!! url('/service/list')!!}"><span class="visible-xs"></span> <i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.Services List')}}</a></li>
				@endcan
				@can('service_edit')
					<li role="presentation" class="active"><a href="{!! url('/service/list/edit/'.$service->id )!!}"><span class="visible-xs"></span><i class="fa fa-pencil-square-o" aria-hidden="true">&nbsp;</i><b>{{ trans('app.Edit Services')}}</b></a></li>
				@endcan
			</ul>
		</div>
            
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<form id="ServiceEdit-Form" method="post" action="update/{{ $service->id }}" enctype="multipart/form-data"  class="form-horizontal upperform">

							<div class="form-group">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Jobcard Number')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
									
										<input type="text"  name="jobno"  class="form-control" value="{{ $service->job_no }}" placeholder="{{ trans('app.Enter Job No')}}" readonly>
									</div>
								</div>

								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Customer Name')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<select name="Customername" id="sup_id" class="form-control select_customer_auto_search" required>
											<option value="">{{ trans('app.Select Select Customer')}}</option>

											@if(!empty($customer))
												@foreach($customer as $customers)
												 <option value="{{ $customers->id}}" <?php if($customers->id==$service->customer_id){echo"selected"; }?>>{{ getCustomerName($customers->id) }}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
							</div>
						  
							<div class="form-group" style="margin-top: 20px;">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Vehicle Name')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										  <select  name="vehicalname" class="form-control" >
											 <option value="">{{ trans('app.Select vehicle Name')}}</option>
											  @if(!empty($vehical))
													@foreach($vehical as $vehicals)
														<option value="{{ $vehicals->id}}" <?php if($vehicals->id==$service->vehicle_id){ echo"selected"; }?>>{{ $vehicals->modelname }}</option>
													@endforeach
												@endif	
										  </select>
									 </div>
								</div>

								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Date')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12 input-group date datepicker">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text" id="p_date" name="date" autocomplete="off"
										value="<?php  echo date( getDateFormat().' H:i:s',strtotime($service->service_date)); ?>" class="form-control" placeholder="<?php echo getDatepicker();  echo " hh:mm:ss"?>" onkeypress="return false;" required>
									</div>
								</div>
							</div>
						  
							<div class="form-group" style="margin-top: 15px;">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Title')}} </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" name="title" placeholder="{{ trans('app.Enter Title')}}" maxlength="30" value="{{ $service->title }}" class="form-control">
									</div>
								</div>

								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Assign To')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<select id="AssigneTo" name="AssigneTo"  class="form-control" required>
											<option value="">{{ trans('app.Select Assign To')}}</option>
											@if(!empty($employee))
											@foreach($employee as $employees)
											<option value="{{ $employees->id }}" <?php if($employees->id==$service->assign_to){ echo"selected";}?>> {{ $employees->name }}</option>	
											@endforeach
											@endif
										</select>
									</div>
								</div>
							</div>
						  
							<div class="form-group" style="margin-top: 15px;">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Repair Category')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<select name="repair_cat"  class="form-control" required>
											<option value="">{{ trans('app.-- Select Repair Category--')}}</option>
											<option value="breakdown" <?php if($service->service_category=='breakdown') { echo 'selected'; } ?> >{{ trans('app.Breakdown') }}</option>
											<option value="booked vehicle" <?php if($service->service_category=='booked vehicle') { echo 'selected'; } ?>>{{ trans('app.Booked Vehicle') }}</option>	
											<option value="repeat job" <?php if($service->service_category=='repeat job') { echo 'selected'; } ?>>{{ trans('app.Repeat Job') }}</option>	
											<option value="customer waiting" <?php if($service->service_category=='customer waiting') { echo 'selected'; } ?>>{{ trans('app.Customer Waiting') }}</option>	
										</select>
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12">{{ trans('app.Service Type')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<label class="radio-inline">
											<input type="radio" name="service_type" id="free"  value="free" required <?php if($service->service_type=='free') { echo 'checked'; } ?>>{{ trans('app.Free')}}</label>
										<label class="radio-inline">
											<input type="radio" name="service_type" id="paid"  value="paid" required <?php if($service->service_type=='paid') { echo 'checked'; } ?>> {{ trans('app.Paid')}}</label>
									</div>
								</div>
							</div>
						  
							<div class="form-group" style="margin-top: 15px;">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Details')}}</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<textarea name="details"  class="form-control" maxlength="100">{{ $service->detail }}</textarea> 
									</div>
								</div>

								<div id="dvCharge" style="display: none" class="has-feedback {{ $errors->has('charge') ? ' has-error' : '' }} my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12 currency" for="last-name">{{ trans('app.Fix Service Charge')}} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  id="charge_required" name="charge" class="form-control fixServiceCharge" placeholder="{{ trans('app.Enter Fix Service Charge')}}" maxlength="8" value="{{ $service->charge }}">
										@if ($errors->has('charge'))
										   <span class="help-block">
											   <strong>{{ $errors->first('charge') }}</strong>
										   </span>
										 @endif
									</div>
								</div> 	
							</div>
							
							<div class="form-group" style="margin-top: 15px;">
								<!-- <div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="reg_no">{{ trans('app.Registration No.')}}</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" name="reg_no" id="reg_no" placeholder="{{ trans('app.Enter Registration Number') }}" class="form-control" maxlength="15" value="{{ $regi_no }}">
									</div>
								</div> -->

							<!-- MOt Test Checkbox Start-->
							@if($service->mot_status == 1)
								<div class="motMainDiv">
									<label class="control-label col-md-2 col-sm-2 col-xs-12 motTextLabel" for="" >{{ trans('app.MOT Test') }}</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="checkbox" name="motTestStatusCheckbox" id="motTestStatusCheckbox" <?php if($service->mot_status==1) { echo 'checked'; } ?>>
									</div>
								</div>
							@endif
							<!-- MOt Test Checkbox End-->
							</div>

						<!-- Custom Filed data value -->
							@if(!empty($tbl_custom_fields))  
								<div class="col-md-12 col-xs-12 col-sm-12 space">
									<h4><b>{{ trans('app.Custom Fields')}}</b></h4>
									<p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
								</div>
									<?php
										$subDivCount = 0;
									?>
									@foreach($tbl_custom_fields as $myCounts => $tbl_custom_field)
								       <?php 
											if($tbl_custom_field->required == 'yes')
											{
												$required = "required";
												$red = "*";
											}else{
												$required = "";
												$red = "";
											}
											
											$tbl_custom = $tbl_custom_field->id;
											$userid = $service->id;
											$datavalue = getCustomDataService($tbl_custom,$userid);

											$subDivCount++;
										?>
											@if($myCounts%2 == 0)
												<div class="col-md-12 col-sm-6 col-xs-12">
											@endif
											<div class="form-group col-md-6  col-sm-6 col-xs-12">
												<label class="control-label col-md-4 col-sm-4 col-xs-12" for="account-no">{{$tbl_custom_field->label}} <label class="text-danger">{{$red}}</label></label>
												<div class="col-md-8 col-sm-8 col-xs-12">
													@if($tbl_custom_field->type == 'textarea')
														<textarea  name="custom[{{$tbl_custom_field->id}}]" class="form-control" placeholder="{{ trans('app.Enter')}} {{$tbl_custom_field->label}}" maxlength="100" {{$required}}>{{$datavalue}}</textarea>
													@elseif($tbl_custom_field->type == 'radio')
														<?php
															$radioLabelArrayList = getRadiolabelsList($tbl_custom_field->id)
														?>
														@if(!empty($radioLabelArrayList))
														<div style="margin-top: 5px;">
															@foreach($radioLabelArrayList as $k => $val)
																<input type="{{$tbl_custom_field->type}}"  name="custom[{{$tbl_custom_field->id}}]" value="{{$k}}"    <?php
																		//$formName = "product";
																		$getRadioValue = getRadioLabelValueForUpdateForAllModules($tbl_custom_field->form_name ,$service->id, $tbl_custom_field->id);

																 	if($k == $getRadioValue) { echo "checked"; }?> 

																> {{ $val }} &nbsp;
															@endforeach
														</div>
														@endif
													@elseif($tbl_custom_field->type == 'checkbox')
														<?php
															$checkboxLabelArrayList = getCheckboxLabelsList($tbl_custom_field->id)
														?>
														@if(!empty($checkboxLabelArrayList))
															<?php
																$getCheckboxValue = getCheckboxLabelValueForUpdateForAllModules($tbl_custom_field->form_name, $service->id, $tbl_custom_field->id);
															?>
															<div style="margin-top: 5px;">
															@foreach($checkboxLabelArrayList as $k => $val)
																<input type="{{$tbl_custom_field->type}}" name="custom[{{$tbl_custom_field->id}}][]" value="{{$val}}"
																<?php
																 	if($val == getCheckboxValForAllModule($tbl_custom_field->form_name, $service->id, $tbl_custom_field->id,$val)) 
																 			{ echo "checked"; }
																 	?>
																> {{ $val }} &nbsp;
															@endforeach
														</div>					
														@endif								
													@elseif($tbl_custom_field->type == 'textbox' || $tbl_custom_field->type == 'date')
														<input type="{{$tbl_custom_field->type}}" name="custom[{{$tbl_custom_field->id}}]"  class="form-control" placeholder="{{ trans('app.Enter')}} {{$tbl_custom_field->label}}" value="{{$datavalue}}" maxlength="30" {{$required}}>
													@endif
												</div>
											</div>
											@if($myCounts%2 != 0)
											</div>
											@endif
									@endforeach
									<?php 
										if ($subDivCount%2 != 0) {
											echo "</div>";
										}
									?>
								@endif					
						<!-- Custom Filed data value End-->

							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
									<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
									<button type="submit" class="btn btn-success">{{ trans('app.Update')}}</button>
								</div>
							</div>

						</form>
					</div>
					
					
				</div>
			</div>
		</div>
           
	</div>

   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
	
<!--Datetime picker -->
	<script>
    $('.datepicker').datetimepicker({
        format: "<?php echo getDatetimepicker(); ?>",
		autoclose:1,
    });
	</script>
<!--Service type free and paid -->	
	<script>
    $(function() {
        $("input[name='service_type']").html(function () {
            if ($("#paid").is(":checked")) {
                $("#dvCharge").show();
                $("#charge_required").attr('required', true);
            } else {
                $("#dvCharge").hide();
				$("#charge_required").removeAttr('required', false);
            }
        });
		
		$("input[name='service_type']").click(function () {
            if ($("#paid").is(":checked")) {
                $("#dvCharge").show();
                $("#charge_required").attr('required', true);
            } else {
                $("#dvCharge").hide();
				$("#charge_required").removeAttr('required', false);
            }
        });
    });
</script>

<!-- Using Slect2 make auto searchable dropdown -->
<script>
	$(document).ready(function () {
 		
 		var sendUrl = '{{ url('service/customer_autocomplete_search') }}';
    	
    	$('.select_customer_auto_search').select2({
        	ajax: {
            	url: sendUrl,
            	dataType: 'json',
            	delay: 250,
            	processResults: function (data) {
                	return {
                    	results: $.map(data, function (item) {
                        	return {
                            	text: item.name +" "+ item.lastname,
                            	id: item.id
                        	};
                    	})
                	};
            	},
            	cache: true
        	}
    	});
	});

	$(document).ready(function(){
   		// Initialize select2
   		$(".select_customer_auto_search").select2();
   	});
</script>


<script>
	/*If date field have value then error msg and has error class remove*/
	$('body').on('change','#p_date',function(){

		var pDateValue = $(this).val();

		if (pDateValue != null) {
			$('#p_date-error').css({"display":"none"});
		}

		if (pDateValue != null) {
			$(this).parent().parent().removeClass('has-error');
		}
	});
	

	/*If select box have value then error msg and has error class remove*/
	$(document).ready(function(){
		$('#sup_id').on('change',function(){

			var supplierValue = $('select[name=Customername]').val();
			
			if (supplierValue != null) {
				$('#sup_id-error').css({"display":"none"});
			}

			if (supplierValue != null) {
				$(this).parent().parent().removeClass('has-error');
			}
		});
	});


	/*Inside fix service text box only enter numbers data*/	
	$('.fixServiceCharge').on('keyup', function(){
	 
		var valueIs = $(this).val();

	 	if (/\D/g.test(valueIs))
		{
			$(this).val("");
		}
		else if(valueIs == 0)
		{
			$(this).val("");
		}
	});
</script>

<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\ServiceAddEditFormRequest', '#ServiceEdit-Form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

@endsection