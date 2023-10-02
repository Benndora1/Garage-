@extends('layouts.app')
@section('content')

<!-- page content -->	
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Employee')}}</span></a>
						</div>
						@include('dashboard.profile')
					</nav>
				</div>
			</div>
        </div>
		<div class="x_content">
            <ul class="nav nav-tabs bar_tabs" role="tablist">
            	@can('employee_view')
					<li role="presentation" class=""><a href="{!! url('/employee/list')!!}" ><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Employee List')}}</a></li>
				@endcan
			
				@can('employee_add')
					<li role="presentation" class="active"><a href="{!! url('/employee/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Add Employee')}}</b></a></li>
				@endcan
            </ul>
		</div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_content">
						<form id="employee_add_form" method="post" action="{!! url('employee/store') !!}" enctype="multipart/form-data"  class="form-horizontal upperform employeeAddForm">
							<div class="col-md-12 col-xs-12 col-sm-12 space">
								<h4><b>{{ trans('app.Personal Information')}}</b></h4>
								<p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
							</div>
						
							<div class="col-md-12 col-sm-6 col-xs-12">  
								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('firstname') ? ' has-error' : '' }}">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="firstname">{{ trans('app.First Name')}} <label class="color-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12">
									  <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}"  placeholder="{{ trans('app.Enter First Name')}}" class="form-control" maxlength="50">
												   @if ($errors->has('firstname'))
										   <span class="help-block">
											 <strong>{{ $errors->first('firstname') }}</strong>
										   </span>
										 @endif
									</div>
								</div>

								<input type="hidden" name="_token" value="{{csrf_token()}}">
							   	
							   	<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('lastname') ? ' has-error' : '' }}">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="lastname">{{ trans('app.Last Name')}} <label class="color-danger">*</label> </label>
									<div class="col-md-8 col-sm-8 col-xs-12">
									  <input type="text" id="lastname" name="lastname"  value="{{ old('lastname') }}" placeholder="{{ trans('app.Enter Last Name')}}" class="form-control" maxlength="50">
										
										@if ($errors->has('lastname'))
										   <span class="help-block">
											 <strong>{{ $errors->first('lastname') }}</strong>
										   </span>
										 @endif
									</div>
								</div>
							</div>

							<div class="col-md-12 col-sm-6 col-xs-12">  
							   <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('displayname') ? ' has-error' : '' }}">
									<label for="displayname" class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Display Name')}} <label class="color-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<input type="text" id="displayname" class="form-control" value="{{ old('displayname') }}" placeholder="{{ trans('app.Enter Display Name')}}" maxlength="25"  name="displayname">
										@if ($errors->has('displayname'))
										   <span class="help-block">
											 <strong>{{ $errors->first('displayname') }}</strong>
										   </span>
										 @endif
									</div>
								</div>

								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback">
									<label class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Gender')}} <label class="color-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12 gender">
										<input type="radio"  name="gender" value="1" checked>{{ trans('app.Male')}} 
										<input type="radio" name="gender" value="2">{{ trans('app.Female')}}
									</div>
								</div>
							</div>

							<div class="col-md-12 col-sm-6 col-xs-12">  
								<div class="col-md-6 col-sm-6 col-xs-12 form-group {{ $errors->has('dob') ? ' has-error' : '' }}">
									<label class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Date Of Birth')}}</label>
									<div class="col-md-8 col-sm-8 col-xs-12 input-group date datepicker1">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text" id="date_of_birth" autocomplete="off" class="form-control" placeholder="<?php echo getDatepicker();?>" name="dob" value="{{ old('dob') }}" onkeypress="return false;">

										<!-- @if ($errors->has('dob'))
										<span id="date_of_birth-error" class="help-block">
											<strong >{{ $errors->first('dob') }}</strong>
										</span>
										@endif -->
									</div>
								</div>

								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="email">{{ trans('app.Email')}} <label class="color-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<input type="text" id="email" name="email" value="{{ old('email') }}" placeholder="{{ trans('app.Enter Email')}}"class="form-control" maxlength="50">
										@if ($errors->has('email'))
										<span class="help-block">
											<strong>{{ $errors->first('email') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>

							<div class="col-md-12 col-sm-6 col-xs-12">  
								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="password">{{ trans('app.Password')}} <label class="color-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<input type="password" id="password" placeholder="{{ trans('app.Enter Password')}}" name="password"  class="form-control" maxlength="20">

										@if ($errors->has('password'))
										<span class="help-block">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
										@endif
									</div>
								</div>

								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
									<label class="control-label col-md-4 col-sm-4 col-xs-12 currency" style=""for="Password">{{ trans('app.Confirm Password') }} <label class="color-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<input type="password"  name="password_confirmation" placeholder="{{ trans('app.Enter Confirm Password')}}" class="form-control col-md-7 col-xs-12" maxlength="20">
										@if ($errors->has('password_confirmation'))
										<span class="help-block">
											<strong>{{ $errors->first('password_confirmation') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>

							<div class="col-md-12 col-sm-6 col-xs-12">  
								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('mobile') ? ' has-error' : '' }}">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="mobile">{{ trans('app.Mobile No')}} <label class="color-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}" placeholder="{{ trans('app.Enter Mobile No')}}"class="form-control" maxlength="16" minlength="6">
										@if ($errors->has('mobile'))
										<span class="help-block">
											<strong>{{ $errors->first('mobile') }}</strong>
										</span>
										@endif
									</div>
								</div>

								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('landlineno') ? ' has-error' : '' }}">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="landlineno">{{ trans('app.Landline No')}} <label class="color-danger"></label></label>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<input type="text" id="landlineno" name="landlineno" value="{{ old('landlineno') }}" placeholder="{{ trans('app.Enter LandLine No')}}" maxlength="16" minlength="6" class="form-control">
										@if ($errors->has('landlineno'))
										<span class="help-block">
											<strong>{{ $errors->first('landlineno') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>

							<div class="col-md-12 col-sm-6 col-xs-12">  
								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group {{ $errors->has('join_date') ? ' has-error' : '' }}">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="join_date">{{ trans('app.Join Date')}} <label class="color-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12 input-group date datepicker">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text" id="join_date" class="form-control leftdate joinDate" placeholder="<?php echo getDatepicker();?>" value="{{ old('join_date') }}"  name="join_date" readonly>

										@if ($errors->has('join_date'))
										<span class="help-block">
											<strong>{{ $errors->first('join_date') }}</strong>
										</span>
										@endif
									</div>								
								</div>

								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="designation">{{ trans('app.Designation')}} <label class="color-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<input type="text" id="" class="form-control" value="{{ old('designation') }}" name="designation" maxlength="30" placeholder="{{ trans('app.Designation')}}">
										@if ($errors->has('designation'))
										<span class="help-block" style="color:#a94442;">
											<strong>{{ $errors->first('designation') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>

							<div class="col-md-12 col-sm-6 col-xs-12">	
								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group {{ $errors->has('left_date') ? ' has-error' : '' }}">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="left_date">{{ trans('app.Left Date')}}</label>
									<div class="col-md-8 col-sm-8 col-xs-12 input-group date datepicker2">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text" id="left_date" class="form-control" placeholder="<?php echo getDatepicker();?>"  name="left_date" value="{{ old('left_date') }}" readonly >
									</div>

									@if ($errors->has('left_date'))
										<span class="help-block" style="margin-left: 27%;">
											<strong>{{ $errors->first('left_date') }}</strong>
										</span>
									@endif
								</div>

								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('image') ? ' has-error' : '' }}">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="image">{{ trans('app.Image')}}</label>
									<div class="col-md-8 col-sm-8 col-xs-12">
									  	<input type="file" id="image" name="image"  class="form-control chooseImage">
									  	<!-- @if ($errors->has('image'))
											<span class="help-block">
												<strong>{{ $errors->first('image') }}</strong>
											</span>
										@endif -->

										<img src="#" id="imagePreview" alt="User Image" class="imageHideShow" style="width: 20%; display: none; padding-top: 8px;">
									</div>
								</div>
							</div>

							<div class="col-md-12 col-xs-12 col-sm-12 space">
								<h4><b>{{ trans('app.Address')}}</b></h4>
								<p class="colo-md-12 col-xs-12 col-sm-12 ln_solid"></p>
							</div>

							<div class="col-md-12 col-sm-6 col-xs-12">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="country_id">{{ trans('app.Country')}} <label class="color-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<select class="form-control col-md-7 col-xs-12 select_country" name="country_id" countryurl="{!! url('/getstatefromcountry') !!}">
											<option value="">{{ trans('app.Select Country')}}</option>
											@foreach ($country as $countrys)
												<option value="{{ $countrys->id }}">{{$countrys->name }}</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="state">{{ trans('app.State')}} </label>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<select class="form-control col-md-7 col-xs-12 state_of_country" name="state" stateurl="{!! url('/getcityfromstate') !!}">
										</select>								 
									</div>
								</div>
							</div>

							<div class="col-md-12 col-sm-6 col-xs-12">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="city">{{ trans('app.Town/City')}}</label>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<select class="form-control col-md-7 col-xs-12 city_of_state" name="city">
										</select>
									</div>
								</div>

								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="address">{{ trans('app.Address')}} <label class="color-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<textarea id="address" name="address" class="form-control addressTextarea" maxlength="100">{{ old('address')}}</textarea>
									</div>
								</div>
							</div>
					<!-- Custom field -->
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
													<input type="{{$tbl_custom_field->type}}" name="custom[{{$tbl_custom_field->id}}][]" value="{{$val}}"> {{ $val }}&nbsp;
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
						<!-- Custom field -->
							<div class="form-group col-md-12 col-sm-12 col-xs-12">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
									<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
									<button type="submit" class="btn btn-success employeeSubmitButton">{{ trans('app.Submit')}}</button>
								</div>
							</div>
						</form>
					</div>
                </div>
            </div>
        </div>
    </div>
    

<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>  

<script>
$(document).ready(function(){
	
	$('.select_country').change(function(){
		countryid = $(this).val();
		var url = $(this).attr('countryurl');
		$.ajax({
			type:'GET',
			url: url,
			data:{ countryid:countryid },
			success:function(response){
				$('.state_of_country').html(response);
			}
		});
	});
	
	$('body').on('change','.state_of_country',function(){
		stateid = $(this).val();
		
		var url = $(this).attr('stateurl');
		$.ajax({
			type:'GET',
			url: url,
			data:{ stateid:stateid },
			success:function(response){
				$('.city_of_state').html(response);
			}
		});
	});
});
</script>

<!-- For image preview at selected image -->
<script>
	function readUrl(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#imagePreview').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#image").change(function(){
        readUrl(this);
        $("#imagePreview").css("display","block");
    });
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

<script>
$(document).ready(function(){
	
	$('.datepicker1').datetimepicker({
        format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
		endDate: new Date(),
    });
	
	
    
		$(".datepicker,.input-group-addon").click(function(){	
		var dateend = $('#left_date').val('');
		
		});
		
		$(".datepicker").datetimepicker({
			format: "<?php echo getDatepicker(); ?>",
			 minView: 2,
			autoclose: 1,
		}).on('changeDate', function (selected) {
			var startDate = new Date(selected.date.valueOf());
		
			$('.datepicker2').datetimepicker({
				format: "<?php echo getDatepicker(); ?>",
				 minView: 2,
				autoclose: 1,
			
			}).datetimepicker('setStartDate', startDate); 
		})
		.on('clearDate', function (selected) {
			 $('.datepicker2').datetimepicker('setStartDate', null);
		})
		
			$('.datepicker2').click(function(){
				
			var date = $('#join_date').val(); 
			if(date == '')
			{
				swal('First Select Join Date');
			}
			else{
				$('.datepicker2').datetimepicker({
				format: "<?php echo getDatepicker(); ?>",
				 minView: 2,
				autoclose: 1,
				})
				
			}
			});
});	
	
</script>

<script>
	/*If address have any white space then make empty address value*/
   	$('body').on('keyup', '.addressTextarea', function(){

      var addressValue = $(this).val();

      if (!addressValue.replace(/\s/g, '').length) {
         $(this).val("");
      }
   	});

   	$('body').on('keyup', '#firstname', function(){

      	var firstName = $(this).val();

      	if (!firstName.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '#lastname', function(){

      	var lastName = $(this).val();

      	if (!lastName.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	$('body').on('keyup', '#displayname', function(){

      	var displayName = $(this).val();

      	if (!displayName.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
   	});

   	/*If date field have value then error msg and has error class remove*/
   	$(document).ready(function(){

   		$('.joinDate').on('change',function(){

			var DateValue = $(this).val();

			if (DateValue != null) {
				$('#join_date-error').css({"display":"none"});
			}

			if (DateValue != null) {
				$(this).parent().parent().removeClass('has-error');
			}
		});
   	});
	
	$('body').on('change','.chooseImage',function(){
		var imageName = $(this).val();
		var imageExtension = /(\.jpg|\.jpeg|\.png)$/i;

		if (imageExtension.test(imageName)) {
			$('.imageHideShow').css({"display":""});
		}
		else {
			$('.imageHideShow').css({"display":"none"});
		}		
	});
</script>

<!-- For form field validate -->
{!! JsValidator::formRequest('App\Http\Requests\EmployeeAddEditFormRequest', '#employee_add_form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>


<!-- Form submit at a time only one -->
<script type="text/javascript">
    /*$(document).ready(function () {
        $('.employeeSubmitButton').removeAttr('disabled'); //re-enable on document ready
    });
    $('.employeeAddForm').submit(function () {
        $('.employeeSubmitButton').attr('disabled', 'disabled'); //disable on any form submit
    });

    $('.employeeAddForm').bind('invalid-form.validate', function () {
      $('.employeeSubmitButton').removeAttr('disabled'); //re-enable on form invalidation
    });*/
</script>

@endsection