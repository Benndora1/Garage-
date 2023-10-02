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
									<li role="presentation" class=""><a href="{!! url('/vehiclebrand/list')!!}" class="anchr"><span class="visible-xs"></span> <i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.VehicleBrand List')}}</a></li>
								@endcan
								@can('vehiclebrand_add')
									<li role="presentation" class="active setMarginForAddVehicleBrandForSmallDevices"><a href="{!! url('/vehiclebrand/add')!!}" class="anchr"><span class="visible-xs"></span> <i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Add VehicleBrand')}}</b></a></li>
								@endcan
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_panel">
						<br />
							<form id="vehicleBrandAdd-Form" action="{{ url('/vehiclebrand/store') }}" method="post"  enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left vehicleBrandAddForm">

								<div class="form-group col-md-12 col-sm-12 col-xs-12 my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">{{ trans('app.Vehicle Types')}} <label class="color-danger">*</label></label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<select name="vehicaltypes" class="form-control col-md-7 col-xs-12" required="required" >
											<option value="">{{ trans('app.Select Vehicle Type')}}</option>
												@if(!empty($vehicaltypes))
											  @foreach($vehicaltypes as $vehicaltypess)
												 <option value="{{ $vehicaltypess->id }}">{{ $vehicaltypess->vehicle_type }}</option>
											  @endforeach
										   @endif
										</select>
									</div>
								</div>

								<div class="form-group col-md-12 col-sm-12 col-xs-12 my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">{{ trans('app.Vehicle Brand')}} <label class="color-danger">*</label>
									</label>
									<div class="col-md-5 col-sm-5 col-xs-12">
									  <input type="text"  required="required" name="vehicalbrand" placeholder="{{ trans('app.Enter Vehicle Brand')}}" class="form-control col-md-7 col-xs-12 vehicalbrand" maxlength="30">
									</div>
								</div>
								
							<!-- Start Custom Field, (If register in Custom Field Module)  -->
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
											$required="required";
											$red="*";
										}else{
											$required="";
											$red="";
										}

										$subDivCount++;
									?>
									
										@if($myCounts%2 == 0)
											<div class="col-md-12 col-sm-6 col-xs-12">
										@endif	
										<div class="form-group col-md-6 col-sm-6 col-xs-12">				
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="account-no">{{$tbl_custom_field->label}} <label class="text-danger">{{$red}}</label></label>
											<div class="col-md-8 col-sm-8 col-xs-12">
											@if($tbl_custom_field->type == 'textarea')
												<textarea  name="custom[{{$tbl_custom_field->id}}]" class="form-control" placeholder="{{ trans('app.Enter')}} {{$tbl_custom_field->label}}" maxlength="100" {{$required}}></textarea>
											@elseif($tbl_custom_field->type == 'radio')
												
												<?php
													$radioLabelArrayList = getRadiolabelsList($tbl_custom_field->id)
												?>
												@if(!empty($radioLabelArrayList))
												<div style="margin-top: 5px;">
													@foreach($radioLabelArrayList as $k => $val)
														<input type="{{$tbl_custom_field->type}}"  name="custom[{{$tbl_custom_field->id}}]" value="{{$k}}" <?php if($k == 0) {echo "checked"; } ?> >{{ $val }} &nbsp;
													@endforeach
													</div>								
												@endif
											@elseif($tbl_custom_field->type == 'checkbox')
												
												<?php
													$checkboxLabelArrayList = getCheckboxLabelsList($tbl_custom_field->id);
													$cnt = 0;
												?>

												@if(!empty($checkboxLabelArrayList))
													<div style="margin-top: 5px;">
													@foreach($checkboxLabelArrayList as $k => $val)
														<input type="{{$tbl_custom_field->type}}" name="custom[{{$tbl_custom_field->id}}][]" value="{{$val}}"> {{ $val }} &nbsp;
													<?php $cnt++; ?>
													@endforeach
												</div>
													<input type="hidden" name="checkboxCount" value="{{$cnt}}">
												@endif											
											@elseif($tbl_custom_field->type == 'textbox' || $tbl_custom_field->type == 'date')
												<input type="{{$tbl_custom_field->type}}"  name="custom[{{$tbl_custom_field->id}}]"  class="form-control" placeholder="{{ trans('app.Enter')}} {{$tbl_custom_field->label}}" maxlength="30" {{ $required }}>
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
							<!-- End Custom Field -->

								<input type="hidden" name="_token" value="{{csrf_token()}}">
							    <div class="form-group col-md-12 col-sm-12 col-xs-12">
									<div class="col-md-9 col-sm-9 col-xs-12 text-center">
										<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
										<button type="submit" class="btn btn-success vehicleBrandAddSubmitButton">{{ trans('app.Submit')}}</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>   

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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
{!! JsValidator::formRequest('App\Http\Requests\VehicleBrandAddEditFormRequest', '#vehicleBrandAdd-Form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

<!-- Form submit at a time only one -->
<script type="text/javascript">
    /*$(document).ready(function () {
        $('.vehicleBrandAddSubmitButton').removeAttr('disabled'); //re-enable on document ready
    });
    $('.vehicleBrandAddForm').submit(function () {
        $('.vehicleBrandAddSubmitButton').attr('disabled', 'disabled'); //disable on any form submit
    });

    $('.vehicleBrandAddForm').bind('invalid-form.validate', function () {
      $('.vehicleBrandAddSubmitButton').removeAttr('disabled'); //re-enable on form invalidation
    });*/
</script>

@endsection