@extends('layouts.app')
@section('content')
<style>
.checkbox-success{
	background-color: #cad0cc!important;
	 color:red;
}
</style>

	<div class="right_col" role="main">
        <div class="">
            <div class="page-title">
				<div class="nav_menu">
					<nav>
					  <div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Vehicle Brand')}}</span></a>
					  </div>
						  @include('dashboard.profile')
					</nav>
				</div>
            </div>
			<div class="clearfix"></div>
			@if(session('message'))
				<div class="row massage">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="checkbox checkbox-success checkbox-circle">
						 
						 <label for="checkbox-10 colo_success"> {{ trans('app.Duplicate Data')}} </label>
						</div>
					</div>
				</div>
			@endif
            <div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_content">
						<div class="">
							<ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
								@can('vehiclebrand_view')
									<li role="presentation" class=""><a href="{!! url('/vehiclebrand/list')!!}" class="anchr"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.Vehicle Brand List')}}</a></li>
								@endcan
								@can('vehiclebrand_edit')
									<li role="presentation" class="active setMarginForAddVehicleBrandForSmallDevices"><a href="{!! url('/vehiclebrand/list/edit/'.$editid)!!}" class="anchr"><span class="visible-xs"></span> <i class="fa fa-pencil-square-o" aria-hidden="true">&nbsp;</i><b>{{ trans('app.Edit Vehicle Brand')}}</b></a></li>
								@endcan
							</ul>
						</div>
                  
						<div class="x_panel">
							<form id="vehicleBrandEdit-Form" action="update/{{$vehicalbrands->id}}"  method="post"  enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">

								<div class="form-group col-md-12 col-sm-12 col-xs-12 my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">{{ trans('app.Vehicle Types')}} <label class="color-danger">*</label>
									</label>
									<div class="col-md-5 col-sm-5 col-xs-12">
									<select name="vehicaltypes" class="form-control col-md-7 col-xs-12" >
									   <option value="">{{ trans('app.Select Vehicle Type')}}</option>
										@if(!empty($vehicaltypes))
									  @foreach($vehicaltypes as $vehicaltypess)
										 <option value="{{ $vehicaltypess->id }}" 
										 <?php if($vehicaltypess->id==$vehicalbrands->vehicle_id) { echo"selected"; } ?>> {{ $vehicaltypess->vehicle_type }}</option>
									  @endforeach
								   @endif
									</select>
									</div>
								</div>

								<div class="form-group col-md-12 col-sm-12 col-xs-12 my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">{{ trans('app.Vehicle Brand')}} <label class="color-danger">*</label>
									</label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="text"  required="required" name="vehicalbrand" value="{{$vehicalbrands->vehicle_brand}}" class="form-control col-md-7 col-xs-12 vehicalbrand" maxlength="30">
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
											$userid = $vehicalbrands->id;
											$datavalue = getCustomDataVehicleBrand($tbl_custom,$userid);

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
																		$getRadioValue = getRadioLabelValueForUpdateForAllModules($tbl_custom_field->form_name ,$vehicalbrands->id, $tbl_custom_field->id);

																 	if($k == $getRadioValue) { echo "checked"; }?> 

																> {{ $val }} &nbsp;
															@endforeach									</div>	
														@endif

													@elseif($tbl_custom_field->type == 'checkbox')
													<?php
															$checkboxLabelArrayList = getCheckboxLabelsList($tbl_custom_field->id)
														?>
														@if(!empty($checkboxLabelArrayList))
															<?php
																$getCheckboxValue = getCheckboxLabelValueForUpdateForAllModules($tbl_custom_field->form_name, $vehicalbrands->id, $tbl_custom_field->id);
															?>
															<div style="margin-top: 5px;">
															@foreach($checkboxLabelArrayList as $k => $val)
																<input type="{{$tbl_custom_field->type}}" name="custom[{{$tbl_custom_field->id}}][]" value="{{$val}}"
																<?php
																 	if($val == getCheckboxValForAllModule($tbl_custom_field->form_name, $vehicalbrands->id, $tbl_custom_field->id,$val)) 
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
								<div class="form-group col-md-12 col-sm-12 col-xs-12">
									<div class="col-md-9 col-sm-9 col-xs-12 text-center">
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
	</div> 

<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>

<script>
	/*If address have any white space then make empty address value*/
   	$('body').on('keyup', '.vehicalbrand', function(){

      var vehicalbrandValue = $(this).val();

      if (!vehicalbrandValue.replace(/\s/g, '').length) {
         $(this).val("");
      }
   	});
</script>

<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\VehicleBrandAddEditFormRequest', '#vehicleBrandEdit-Form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

@endsection