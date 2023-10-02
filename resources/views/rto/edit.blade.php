@extends('layouts.app')
@section('content')

<style>
	.select2-container {
		width: 100% !important;
	}
</style>

<!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Compliance Management')}}</span></a> 
						</div>
						@include('dashboard.profile')
					</nav>
                </div>
				@if(session('message'))
				<div class="row massage">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="checkbox checkbox-success checkbox-circle">
							<input id="checkbox-10" type="checkbox" checked="">
							<label for="checkbox-10 colo_success">  {{session('message')}} </label>
						</div>
					</div>
				</div>
				@endif
            </div>
			<div class="x_content">
                <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
                	@can('rto_view')
						<li role="presentation" class=""><a href="{!! url('/rto/list')!!}"><span class="visible-xs"></span> <i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.List Of RTO Taxes')}}</span></a></li>
					@endcan
					@can('rto_add')
						<li role="presentation" class="active"><a href="{!! url('/rto/list/edit/'.$editid)!!}"><span class="visible-xs"></span> <i class="fa fa-pencil-square-o" aria-hidden="true">&nbsp;</i><b>{{ trans('app.Edit RTO Taxes')}}</b></span></a></li>
					@endcan
				</ul>
			</div>
            <div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_content">
							<form id="rtoTaxEditForm" method="post" action="update/{{ $rto->id }}" enctype="multipart/form-data"  class="form-horizontal upperform">
								
								<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="v_id">{{ trans('app.Vehicle Name')}}  <label class="color-danger">*</label></label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<select class="form-control vehicleNameSelect" name="v_id" id="vehicle_names" required>
											<option value="">{{ trans('app.-- Select Vehicle --')}}</option>
											@if(!empty($vehicle))
												@foreach ($vehicle as $vehicles)
													<option value="{{ $vehicles->id }}" <?php if($vehicles->id == $rto->vehicle_id) {echo 'selected';}?>>{{ $vehicles->modelname }}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
					  
								<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback {{ $errors->has('rto_tax') ? ' has-error' : '' }} my-form-group" style="margin-top: 1%;">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="rto_tax">{{ trans('app.RTO / Registration C.R. Temp Tax')}} <label class="color-danger">*</label></label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="number" id="rto_tax" name="rto_tax" value="{{ $rto->registration_tax }}" maxlength="10" class="form-control" required>
										@if ($errors->has('rto_tax'))
										   <span class="help-block">
											   <strong>{{ $errors->first('rto_tax') }}</strong>
										   </span>
										 @endif
									</div>
								</div>
					  
								<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback {{ $errors->has('num_plate_tax') ? ' has-error' : '' }} my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="num_plate_tax">{{ trans('app.Number Plate charge')}} <label class="color-danger">*</label>
									</label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="number" id="num_plate_tax" name="num_plate_tax"  value="{{ $rto->number_plate_charge }}" class="form-control" maxlength="10" required>
										@if ($errors->has('num_plate_tax'))
										   <span class="help-block">
											   <strong>{{ $errors->first('num_plate_tax') }}</strong>
										   </span>
										 @endif
									</div>
								</div>
					  
								<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback {{ $errors->has('mun_tax') ? ' has-error' : '' }} my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="mun_tax">{{ trans('app.Municipal Road Tax')}} <label class="color-danger">*</label></label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="number" id="mun_tax" name="mun_tax"  value="{{ $rto->muncipal_road_tax }}" maxlength="10" class="form-control" required>
										 @if ($errors->has('mun_tax'))
										   <span class="help-block">
											   <strong>{{ $errors->first('mun_tax') }}</strong>
										   </span>
										 @endif
									</div>
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
											$userid = $rto->id;
											$datavalue = getCustomDataRto($tbl_custom,$userid);

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
																	$getRadioValue = getRadioLabelValueForUpdateForAllModules($tbl_custom_field->form_name ,$rto->id, $tbl_custom_field->id);

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
															$getCheckboxValue = getCheckboxLabelValueForUpdateForAllModules($tbl_custom_field->form_name, $rto->id, $tbl_custom_field->id);
														?>
														<div style="margin-top: 5px;">
														@foreach($checkboxLabelArrayList as $k => $val)
															<input type="{{$tbl_custom_field->type}}" name="custom[{{$tbl_custom_field->id}}][]" value="{{$val}}"
															<?php
															 	if($val == getCheckboxValForAllModule($tbl_custom_field->form_name, $rto->id, $tbl_custom_field->id,$val)) 
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
                     
								<div class="form-group col-md-12 col-sm-12 col-xs-12 ">
									<div class="col-md-9 col-sm-9 col-xs-12 text-center">
									  <a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
									  <button type="submit" class="btn btn-success">{{ trans('app.Update')}}</button>
									</div>
								</div>
							</form>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<p>* {{ trans('app.RTO')}} = {{ trans('app.Regional Transport Office')}}</p>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
	</div>
<!-- page content end-->

<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

<script>
	$(document).ready(function(){
   		// Initialize select2
   		$("#vehicle_names").select2();
   	});
</script>

<script>
	/*If select box have value then error msg and has error class remove*/
	$(document).ready(function(){

		$('.vehicleNameSelect').on('change',function(){

			var vehicleValue = $('select[name=v_id]').val();
			
			//alert(vehicleValue);
			if (vehicleValue != null) {
				//$('#vehicle_names-error').css({"display":"none"});				
				//$('#vehicle_names-error').css({"color":"#ffffff"});
				$('#vehicle_names-error').attr('style', 'display: none !important');
			}

			if (vehicleValue != null) {
				$(this).parent().parent().removeClass('has-error');
			}
		});
	});
</script>

<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\StoreRtoTaxAddEditFormRequest', '#rtoTaxEditForm'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

@endsection