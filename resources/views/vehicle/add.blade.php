@extends('layouts.app')
@section('content')
<style type='text/css'>
  .ui-datepicker-calendar,.ui-datepicker-month { display: none; }​
</style>

<!-- page content -->
	<div class="right_col" role="main">
		<div class="page-title">
			<div class="nav_menu">
				<nav>
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Vehicle')}}</span></a>
					</div>
					 @include('dashboard.profile')
				</nav>
			</div>
		</div>
		<div class="x_content">
			<ul class="nav nav-tabs bar_tabs" role="tablist">
				@can('vehicle_view')				
					<li role="presentation" class=""><a href="{!! url('/vehicle/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.Vehicle List')}}</a></li>
				@endcan

				@can('vehicle_add')
					<li role="presentation" class="active"><a href="{!! url('/vehicle/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Add Vehicle')}}</b></a></li>
				@endcan
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<form id="vehicleAdd-Form" action="{{ url('/vehicle/store') }}" method="post" enctype="multipart/form-data"  class="form-horizontal upperform vehicleAddForm">
							<input type="hidden" name="_token" value="{{csrf_token()}}">

							<div class="form-group" style="margin-top:20px;">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Vehicle Type')}} <label class="color-danger">*</label></label>
									<div class="col-md-2 col-sm-2 col-xs-12">
										 <select class="form-control select_vehicaltype" name="vehical_id" 
										 vehicalurl="{!! url('/vehicle/vehicaltypefrombrand') !!}" required>
											<option value="">{{ trans('app.Select Vehicle Type')}}</option>
										 @if(!empty($vehical_type))
											@foreach($vehical_type as $vehical_types)
												<option value="{{ $vehical_types->id }}">{{ $vehical_types->vehicle_type }}</option>
											@endforeach
										@endif
									    </select> 
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12 addremove">
										<button type="button" class="btn btn-default" data-target="#responsive-modal" data-toggle="modal">{{ trans('app.Add Or Remove')}}</button>
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Chasic No')}} <label class="color-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="chasicno"  value="{{ old('chasicno') }}" placeholder="{{ trans('app.Enter ChasicNo')}}" maxlength="30" class="form-control">
									</div>
								</div>
							</div>

						    <div class="form-group">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Vehicle Brand')}} <label class="color-danger">*</label></label>
									<div class="col-md-2 col-sm-2 col-xs-12">
										<select class="form-control   select_vehicalbrand" name="vehicabrand" >
											<option value="">Select Vehical Brand</option>
										 </select> 
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12 addremove">
										<button type="button" class="btn btn-default" data-target="#responsive-modal-brand" data-toggle="modal">{{ trans('app.Add Or Remove')}}</button>
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Model Years')}} <label class="color-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12 input-group date" id="myDatepicker2">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text"  name="modelyear" autocomplete="off"  class="form-control"/>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Fuel Type')}} <label class="color-danger">*</label></label>
									<div class="col-md-2 col-sm-2 col-xs-12">
										<select class="form-control select_fueltype " name="fueltype" required >
											<option value="">{{ trans('app.Select fuel type')}} </option>
												@if(!empty($fuel_type))
													@foreach($fuel_type as $fuel_types)
														<option value="{{ $fuel_types->id }}">{{ $fuel_types->fuel_type }}</option>
													@endforeach
												@endif
										</select> 
									</div>									
									<div class="col-md-2 col-sm-2 col-xs-12 addremove">
										<button type="button" class="btn btn-default" data-target="#responsive-modal-fuel" data-toggle="modal">{{ trans('app.Add Or Remove')}}</button>
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.No of Grear')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="gearno"  value="{{ old('gearno') }}" placeholder="{{ trans('app.Enter No of Gear')}}" maxlength="5" class="form-control">
									</div>
								</div>
							</div>
						  
							<div class="form-group">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Model Name')}} <label class="color-danger">*</label></label>
									<div class="col-md-2 col-sm-2 col-xs-12">
										<select class="form-control model_addname" name="modelname" required>
											<option value="">{{ trans('app.Select Model Name')}}</option>
										@if(!empty($model_name))
											@foreach ($model_name as $model_names)
											<option value="{{ $model_names->model_name }}">{{ $model_names->model_name }}</option>
											@endforeach
										@endif
										</select>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12 addremove">
										<button type="button" class="btn btn-default" data-target="#responsive-modal-vehi-model" data-toggle="modal">{{ trans('app.Add Or Remove')}}</button>
									</div>
								</div>

								<div class="{{ $errors->has('price') ? ' has-error' : '' }} my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">
									{{ trans('app.Price' )}} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="price"  value="{{ old('price') }}" placeholder="{{ trans('app.Enter Price')}}" class="form-control" maxlength="10" required>
										<!-- @if ($errors->has('price'))
										   <span class="help-block">
											   <strong>{{ $errors->first('price') }}</strong>
										   </span>
										@endif -->
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="{{ $errors->has('odometerreading') ? ' has-error' : '' }}">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Odometer Reading')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="odometerreading"  value="{{ old('odometerreading') }}" placeholder="{{ trans('app.Enter Odometer Reading')}}" maxlength="20"  class="form-control">
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Date Of Manufacturing')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12 input-group date datepicker">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text"  name="dom" autocomplete="off" class="form-control" placeholder="<?php echo getDatepicker();?>" onkeypress="return false;" />
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Gear Box')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="gearbox"  value="{{ old('gearbox') }}" placeholder="{{ trans('app.Enter Grear Box')}}" maxlength="30" class="form-control">
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Gear Box No')}}</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="gearboxno"  value="{{ old('gearboxno') }}" placeholder="{{ trans('app.Enter Gearbox No')}}" maxlength="30" class="form-control" >
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Engine No')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="engineno"  value="{{ old('engineno') }}" placeholder="{{ trans('app.Enter Engine No')}}" maxlength="30" class="form-control">
									</div>
								</div>
								
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Engine Size')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="enginesize"  value="{{ old('enginesize') }}" placeholder="{{ trans('app.Enter Engine Size')}}" maxlength="30" class="form-control">
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Key No')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="keyno"  value="{{ old('keyno') }}" placeholder="{{ trans('app.Enter Key No')}}" maxlength="30" class="form-control">
									</div>
								</div>
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Engine')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="engine"  value="{{ old('engine') }}" placeholder="{{ trans('app.Enter Engine')}}" maxlength="30" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Number Plate')}} <label class="text-danger"></label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="number_plate"  value="{{ old('number_plate') }}" placeholder="{{ trans('app.Enter Number Plate')}}" maxlength="30" class="form-control">
									</div>
								</div>
							</div>
							<div class=" col-md-12 col-sm-12 col-xs-12 form-group" style="padding:5px 0px 5px 0px">
							</div>
							<div class="form-group">
						
							<!-- Vehical images  -->
								<div class="col-md-6 col-sm-12 col-xs-12 form-group my-form-group">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<h2>{{ trans('app.Vehicle Images')}}</h2>
											<span> <h5 style="margin-left: 10px;"> {{ trans('app.Select Multiple Images')}} </h5> </span>
									</div>
										<div class="form-group col-md-10 col-sm-12 col-xs-12">
											<input type="file"  name="image[]"  class="form-control imageclass" id="images" onchange="preview_images();"  data-max-file-size="5M" multiple />
									
										</div>
										<div class="row classimage" id="image_preview"></div>
										
								</div>
								
						<!--vehicle color-->
								<div class="col-md-6 col-sm-12 col-xs-12 form-group ">
									<div class="col-md-6 col-sm-6 col-xs-6" style="padding-left:0px;">
										<h2>{{ trans('app.Vehicle Color')}} </h2></span>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6" style="padding-bottom: 33px;">
										<button type="button" id="add_new_color" class="btn btn-default newadd" url="{!! url('vehicle/add/getcolor')!!}">{{ trans('app.Add New')}}
										</button>
									</div>
									<div class="form-group col-md-12 col-sm-12 col-xs-12" style="padding-bottom:5px">
										<table class="table table-bordered addtaxtype"  id="tab_color" align="center">
											<thead>
												<tr>
													<th class="all">{{ trans('app.Colors')}}</th>
													<th>{{ trans('app.Action')}}</th>
												</tr>
											</thead>			
											<tbody>
												<tr id="color_id_1">
													<td>
														<select name="color[]" class="form-control color" id="tax_1" data-id="1">
															<option value="">{{ trans('app.Select Color')}}</option>
															@if(!empty($color))
																@foreach($color as $colors)
																	<option value="{{ $colors->id }}">{{ $colors->color }}</option>
																@endforeach
															@endif
														</select>
													</td>
													<td>
														<span class="" data-id="1"><i class="fa fa-trash"></i> {{ trans('app.Delete')}}</span>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="form-group">
					  
							<!-- Vehicle Description  -->
									<div class="col-md-6 col-sm-12 col-xs-12 form-group">
										<div class="col-md-6 col-sm-6 col-xs-6">
											<h2>{{ trans('app.Vehicle Description')}} </h2>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6" style="padding-bottom: 33px;">
											<button type="button" id="add_new_description" class="btn btn-default newadd" url="{!! url('vehicle/add/getDescription')!!}">{{ trans('app.Add New')}}
											</button>
										</div>		
										<div class="form-group col-md-12 col-sm-12 col-xs-12">
											<table class="table table-bordered addtaxtype"  id="tab_decription_detail" align="center">
												<thead>
													<tr>
														<th class="all">{{ trans('app.Description')}}</th>
														<th class="all">{{ trans('app.Action')}}</th>
													</tr>
												</thead>			
												<tbody>
													<tr id="row_id_1">
														<td>
															<textarea name="description[]" class="form-control" maxlength="100" id="tax_1" ></textarea> 
														</td>
														<td>
															<span class="" data-id="1"><i class="fa fa-trash"></i> {{ trans('app.Delete')}}</span>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
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

							<div class="form-group col-md-12 col-sm-12 col-xs-12">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
									<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
									<button type="submit" class="btn btn-success vehicleAddSubmitButton">{{ trans('app.Submit')}}</button>
								</div>
							</div>
						</form>
					</div>	

		   <!-- Vehicle Type  -->
					<div class="col-md-6">
						<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
										<h4 class="modal-title"> {{ trans('app.Add Vehicle Type')}}</h4>
									</div>
									<div class="modal-body">
									    <form name="" class="form-horizontal formaction" action="" method="">
											<table class="table vehical_type_class"  align="center" style="width:40em">
												<thead>
													<tr>
														<td class="text-center"><strong>{{ trans('app.Vehicle Type')}}</strong></td>
														<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
													</tr>
												</thead>
												<tbody>
													@if(!empty($vehical_type))
													@foreach ($vehical_type as $vehical_types)
													<tr class="del-{{ $vehical_types->id }}">
														<td class="text-center ">{{ $vehical_types->vehicle_type }}</td>
														<td class="text-center">
															<button type="button" vehicletypeid="{{ $vehical_types->id }}" 
															deletevehical="{!! url('/vehicle/vehicaltypedelete') !!}" class="btn btn-danger btn-xs deletevehicletype">X</button>
														</td>
													</tr>
													@endforeach
													@endif
												</tbody>
											</table>
											<div class="col-md-8 form-group data_popup">
												<label>{{ trans('app.Vehicle Type:')}} <span class="color-danger">*</span></label>
												<input type="text" class="form-control vehical_type" name="vehical_type" id="vehical_type" placeholder="{{ trans('app.Enter Vehicle Type')}}" maxlength="20" required />
											</div>
											<div class="col-md-4 form-group data_popup" style="margin-top:24px;">
												
												<button type="button" class="btn btn-success vehicaltypeadd" id="vehicleTypeSubmit" 
												url="{!! url('/vehicle/vehicle_type_add') !!}" >{{ trans('app.Submit')}}</button>
											</div>
										</form>
									</div>
								</div>
							</div>	
						</div>
					</div>
				<!-- End  Vehicle Type  -->
			
				<!-- Vehicle Brand -->
					<div class="col-md-6">
						<div id="responsive-modal-brand" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
										<h4 class="modal-title">{{ trans('app.Add Vehicle Brand')}}</h4>
									</div>
									<div class="modal-body">
									    <form class="form-horizontal" action="" method="">
											<table class="table vehical_brand_class"  align="center" style="width:40em">
												<thead>
													<tr>
														<td class="text-center"><strong>{{ trans('app.Vehicle Brand')}}</strong></td>
														<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
													</tr>
												</thead>
												<tbody>
													@if(!empty($vehical_brand))
													@foreach ($vehical_brand as $vehical_brands)
													<tr class="del-{{ $vehical_brands->id}}" >
													<td class="text-center ">{{ $vehical_brands->vehicle_brand }}</td>
													<td class="text-center">
													
													<button type="button" brandid="{{ $vehical_brands->id }}" 
													deletevehicalbrand="{!! url('/vehicle/vehicalbranddelete') !!}" class="btn btn-danger btn-xs deletevehiclebrands">X</button>
													</td>
													</tr>
													@endforeach
													@endif
												</tbody>
											</table>
											<div class="col-md-8 form-group data_popup">
												<label>{{ trans('app.Vehicle Type:')}} <span class="color-danger">*</span></label>
												<select class="form-control  vehical_id" name="vehical_id" id="vehicleTypeSelect" vehicalurl="{!! url('/vehicle/vehicalformtype') !!}" required >
													<option>{{ trans('app.Select Vehicle Type')}}</option>
														 @if(!empty($vehical_type))
															@foreach($vehical_type as $vehical_types)
																<option value="{{ $vehical_types->id }}">{{ $vehical_types->vehicle_type }}</option>
															@endforeach
														@endif
												</select> 
											</div>
											<div class="col-md-8 form-group data_popup">
												<label>{{ trans('app.Vehicle Brand:')}} <span class="color-danger">*</span></label>
												<input type="text" class="form-control vehical_brand" name="vehical_brand" id="vehical_brand" placeholder="{{ trans('app.Enter Vehicle brand')}}" maxlength="25" required />
											</div>
											<div class="col-md-4 form-group data_popup" style="margin-top:24px;">
												
												<button type="button" class="btn btn-success vehicalbrandadd " 
												   vehiclebrandurl="{!! url('/vehicle/vehicle_brand_add') !!}">{{ trans('app.Submit')}}</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				<!-- End Vehicle Brand -->	
		
				<!-- Fuel Type -->	
					<div class="col-md-6">
						<div id="responsive-modal-fuel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
										<h4 class="modal-title">{{ trans('app.Add Fuel Type')}}</h4>
									</div>
									<div class="modal-body">
									    <form class="form-horizontal" action="" method="post">
											<table class="table fuel_type_class"  align="center" style="width:40em">
												<thead>
													<tr>
														<td class="text-center"><strong>{{ trans('app.Fuel Type')}}</strong></td>
														<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
													</tr>
												</thead>
												<tbody>
													@if(!empty($fuel_type))
													@foreach ($fuel_type as $fuel_types)
													<tr class="del-{{ $fuel_types->id }} data_of_type" >
													<td class="text-center ">{{ $fuel_types->fuel_type }}</td>
													<td class="text-center">
													
													<button type="button" fuelid="{{ $fuel_types->id }}" 
													deletefuel="{!! url('/vehicle/fueltypedelete') !!}" class="btn btn-danger btn-xs fueldeletes">X</button>
													</td>
													</tr>
													@endforeach
													@endif
												</tbody>
											</table>
											<div class="col-md-8 form-group data_popup">
												<label>{{ trans('app.Fuel Type:')}} <span class="color-danger">*</span></label>
												<input type="text" class="form-control fuel_type" name="fuel_type" id="fuel_type" placeholder="{{ trans('app.Enter Fuel Type')}}" maxlength="20" required />
											</div>
											<div class="col-md-4 form-group data_popup" style="margin-top:24px;">
												
												<button type="button" class="btn btn-success fueltypeadd"  
												fuelurl="{!! url('/vehicle/vehicle_fuel_add') !!}">{{ trans('app.Submit')}}</button>
											</div>
										</form>
									</div>
								</div>
							</div>	
						</div>
					</div>
				<!-- end Fuel Type -->	

				<!-- Model Name -->
					<div class="col-md-6">
						<div id="responsive-modal-vehi-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
										<h4 class="modal-title">{{ trans('app.Add Model Name')}}</h4>
									</div>
									<div class="modal-body">
										<form class="form-horizontal" action="" method="post">
											<table class="table vehi_model_class"  align="center" style="width:40em">
												<thead>
													<tr>
														<td class="text-center"><strong>{{ trans('app.Model Name')}}</strong></td>
														<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
													</tr>
												</thead>
												<tbody>
										
													@if(!empty($model_name))
													@foreach ($model_name as $model_names)
													<tr class="mod-{{ $model_names->id }}" >
													<td class="text-center ">{{ $model_names->model_name }}</td>
													<td class="text-center">
													
													<button type="button" modelid="{{ $model_names->id }}" 
													deletemodel="{!! url('/vehicle/vehicle_model_delete') !!}" class="btn btn-danger btn-xs modeldeletes">X</button>
													</td>
													</tr>
													@endforeach
													@endif
												</tbody>
											</table>
											<div class="col-md-8 form-group data_popup">
												<label>{{ trans('app.Model Name :')}} <span class="color-danger">*</span></label>
												<input type="text" class="form-control vehi_modal_name" name="model_name" id="model_name" placeholder="{{ trans('app.Enter Model Name')}}" maxlength="20" required />
											</div>
											<div class="col-md-4 form-group data_popup" style="margin-top:24px;">
												
												<button type="button" class="btn btn-success vehi_model_add"  
												modelurl="{!! url('/vehicle/vehicle_model_add') !!}">{{ trans('app.Submit')}}</button>
											</div>
										</form>
									</div>
								</div>
							</div>	
						</div>
					</div>
				<!-- End Model Name -->
				</div>
			</div>
		</div>
	</div>
	

	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script>
    $('#myDatepicker2').datetimepicker({
       format: "yyyy",
		autoclose: 2,
		minView: 4,
		startView: 4,
		
    });
</script>


<!-- vehicle type -->
<script>
    $(document).ready(function(){
		
		$('.vehicaltypeadd').click(function(){
			
		 	var vehical_type= $('.vehical_type').val();
		 	var url = $(this).attr('url');
        	
        	function define_variable()
			{
				return {
					vehicle_type_value: $('.vehical_type').val(),
					vehicle_type_pattern: /^[(a-zA-Z0-9\s)]+$/,
				};
			}
		
			var call_var_vehicletypeadd = define_variable();		 

	        if(vehical_type == ""){
	            swal('Please enter vehicle type');
	        }
	        else if (!call_var_vehicletypeadd.vehicle_type_pattern.test(call_var_vehicletypeadd.vehicle_type_value))
			{
				$('.vehical_type').val("");
				swal('Please enter only alphanumeric data');
			}
	        else if(!vehical_type.replace(/\s/g, '').length){
				$('.vehical_type').val("");
	        	swal('Only blank space not allowed');
	        }
	        else{ 
				$.ajax({
					type:'GET',
					url:url,

		   			data :{vehical_type:vehical_type},

		   			//Form submit at a time only one for vehicleTypeAdd
		   			beforeSend : function () {
		 				$(".vehicaltypeadd").prop('disabled', true);
		 			},

		   			success:function(data)
		   			{
			   			var newd = $.trim(data);
				   
			   			var classname = 'del-'+newd;
				   
			   			if (newd == '01')
			   			{
				   			swal('Duplicate Data !!! Please try Another...');
			   			}
			   			else
			   			{
			   				$('.vehical_type_class').append('<tr class="'+classname+'"><td class="text-center">'+vehical_type+'</td><td class="text-center"><button type="button" vehicletypeid='+data+' deletevehical="{!! url('/vehicle/vehicaltypedelete') !!}" class="btn btn-danger btn-xs deletevehicletype">X</button></a></td><tr>');
				   
							$('.select_vehicaltype').append('<option value='+data+'>'+vehical_type+'</option>');
							$('.vehical_type').val('');
					
							$('.vehical_id').append('<option value='+data+'>'+vehical_type+'</option>');
								$('.vehical_type').val('');
				   		}

				   		//Form submit at a time only one for vehicleTypeAdd
				   		$(".vehicaltypeadd").prop('disabled', false);
						return false;
			   		},
		 		});
			}
		});

	});
</script>

<!-- vehical Type delete-->
<script>
$(document).ready(function(){
	
	$('body').on('click','.deletevehicletype',function(){
		
		var vtypeid = $(this).attr('vehicletypeid');
		
		var url = $(this).attr('deletevehical');
		
		swal({
		     title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
         function(isConfirm){
				if (isConfirm) {
					$.ajax({
							type:'GET',
							url:url,
							data:{vtypeid:vtypeid},
							success:function(data){
		
								$('.del-'+vtypeid).remove();
								$(".select_vehicaltype option[value="+vtypeid+"]").remove();
								swal("Done!","It was succesfully deleted!","success");
					}
					});
				}else{
						swal("Cancelled", "Your imaginary file is safe :)", "error");
						} 
				})
	
		});
	});
</script>


<!-- vehical brand -->
<script>
    $(document).ready(function(){
		
		$('.vehicalbrandadd').click(function(){
			 		
        	var vehical_id = $('.vehical_id').val();
			var vehical_brand= $('.vehical_brand').val();
			var url = $(this).attr('vehiclebrandurl');

			function define_variable()
			{
				return {
					vehicle_brand_value: $('.vehical_brand').val(),
					vehicle_brand_pattern: /^[(a-zA-Z0-9\s)]+$/,
				};
			}
			
			var call_var_vehiclebrandadd = define_variable();		

			if ($("#vehicleTypeSelect")[0].selectedIndex <= 0) {

				swal('Please first select vehicle type');
			}
			else{
				if(vehical_brand == ""){
		            swal('Please enter vehicle brand');
		        }
		        else if (!call_var_vehiclebrandadd.vehicle_brand_pattern.test(call_var_vehiclebrandadd.vehicle_brand_value))
				{
					$('.vehical_brand').val("");
					swal('Please enter only alphanumeric data');

				}
		        else if(!vehical_brand.replace(/\s/g, '').length){
		       		// var str = "    ";
					$('.vehical_brand').val("");
		        	swal('Only blank space not allowed');
		        }
		        else{ 
					$.ajax({
				   		type:'GET',
				   		url:url,
	             
				   		data :{vehical_id:vehical_id, vehical_brand:vehical_brand},

				   		//Form submit at a time only one for vehicleBrandAdd
			   			beforeSend : function () {
			 				$(".vehicalbrandadd").prop('disabled', true);
			 			},

				   		success:function(data)
	               		{ 
				       		var newd = $.trim(data);
					   		var classname = 'del-'+newd;
	                  
				    		if (newd == "01")
				       		{
				 	     		swal('Duplicate Data !!! Please try Another...');
					   		}
					   		else
					   		{
						   		$('.vehical_brand_class').append('<tr class="'+classname+'"><td class="text-center">'+vehical_brand+'</td><td class="text-center"><button type="button" brandid='+data+' deletevehicalbrand="{!! url('vehicle/vehicalbranddelete') !!}" class="btn btn-danger btn-xs deletevehiclebrands">X</button></a></td><tr>');
								
								$('.select_vehicalbrand').append('<option value='+data+'>'+vehical_brand+'</option>');
								
								$('.vehical_brand').val('');
							}

							//Form submit at a time only one for vehicleBrandAdd
							$(".vehicalbrandadd").prop('disabled', false);
							return false;
				   		},
				   
			 		});
				}
			}
		});
	});
</script>

<!-- vehical brand delete-->

	<script>
	$(document).ready(function(){
		$('body').on('click','.deletevehiclebrands',function(){
			
		var vbrandid = $(this).attr('brandid');
		var url = $(this).attr('deletevehicalbrand');
		swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
         function(isConfirm){
				if (isConfirm) {  
				$.ajax({
						type:'GET',
						url:url,
						data:{vbrandid:vbrandid},
						success:function(data){
							 $('.del-'+vbrandid).remove();
							 $(".select_vehicalbrand option[value="+vbrandid+"]").remove();
							swal("Done!","It was succesfully deleted!","success");
						}
					});
				}else{
						swal("Cancelled", "Your imaginary file is safe :)", "error");
					} 
				})
	});
	});
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Fuel type -->
<script>
    $(document).ready(function(){
		
		$('.fueltypeadd').click(function(){
			 
		 	var fuel_type = $('.fuel_type').val();
		 	var url = $(this).attr('fuelurl');
        	
        	function define_variable()
			{
				return {
					vehicle_fuel_value: $('.fuel_type').val(),
					vehicle_fuel_pattern: /^[(a-zA-Z0-9\s)]+$/,
				};
			}
			
			var call_var_vehiclefueladd = define_variable();
			
	        if(fuel_type == ""){
	            swal('Please enter fuel type');
	        }
	        else if (!call_var_vehiclefueladd.vehicle_fuel_pattern.test(call_var_vehiclefueladd.vehicle_fuel_value))
			{
				$('.fuel_type').val("");
				swal('Please enter only alphanumeric data');

			}
	        else if(!fuel_type.replace(/\s/g, '').length){
	       		// var str = "    ";
				$('.fuel_type').val("");
	        	swal('Only blank space not allowed');
	        }
	        else{  
				$.ajax({
			   		type:'GET',
			   		url:url,

			   		data :{fuel_type:fuel_type},
			   		
			   		//Form submit at a time only one for fuelType
		   			beforeSend : function () {
		 				$(".fueltypeadd").prop('disabled', true);
		 			},

			   		success:function(data)
			   		{ 
				       var newd = $.trim(data);
					   var classname = 'del-'+newd;
				   
				   		if(newd == '01')
				   		{
					   		swal('Duplicate Data !!! Please try Another...');
				   		}
				   		else
				   		{
				    		$('.fuel_type_class').append('<tr class="'+classname+'"><td class="text-center">'+fuel_type+'</td><td class="text-center"><button type="button" fuelid='+data+' deletefuel="{!! url('/vehicle/fueltypedelete') !!}" class="btn btn-danger btn-xs fueldeletes">X</button></a></td><tr>');
					
								$('.select_fueltype').append('<option value='+data+'>'+fuel_type+'</option>');
								
								$('.fuel_type').val('');
				   		}

				   		//Form submit at a time only one for fuelType
						$(".fueltypeadd").prop('disabled', false);
						return false;
			   		},
			   
				});
			}
		});
	});
</script>

<!-- Fuel  Type delete-->
<script>
$(document).ready(function(){
	
	$('body').on('click','.fueldeletes',function(){
   
	
	var fueltypeid = $(this).attr('fuelid');
	var url = $(this).attr('deletefuel');
	swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
         function(isConfirm){
				if (isConfirm) {
								$.ajax({
								type:'GET',
								url:url,
								data:{fueltypeid:fueltypeid},
								success:function(data)
									{
										$('.del-'+fueltypeid).remove();
										$(".select_fueltype option[value="+fueltypeid+"]").remove();
										swal("Done!","It was succesfully deleted!","success");
									}
								});
							}else{
									swal("Cancelled", "Your imaginary file is safe :)", "error");
								} 
						})
	
				});
		});
</script>

<!-- Add Vehicle Model -->
<script>
	$(document).ready(function(){

		$('.vehi_model_add').click(function(){
			var model_name = $('.vehi_modal_name').val();
			var model_url = $(this).attr('modelurl');
			
			function define_variable()
			{
				return {
					vehicle_model_value: $('.vehi_modal_name').val(),
					vehicle_model_pattern: /^[(a-zA-Z0-9\s)]+$/,
				};
			}
		
			var call_var_vehiclemodeladd = define_variable();		 

	        if(model_name == ""){
            	swal('Please enter model name');
        	}
	        else if (!call_var_vehiclemodeladd.vehicle_model_pattern.test(call_var_vehiclemodeladd.vehicle_model_value))
			{
				$('.vehi_modal_name').val("");
				swal('Please enter only alphanumeric data');
			}
	        else if(!model_name.replace(/\s/g, '').length){
				$('.vehi_modal_name').val("");
	        	swal('Only blank space not allowed');
	        }
			else{	
				$.ajax({
					
					type:'GET',
					url:model_url,
					data:{model_name:model_name},

					//Form submit at a time only one for addVehicleModel
		   			beforeSend : function () {
		 				$(".vehi_model_add").prop('disabled', true);
		 			},
				
					success:function(data)
					{					
						var newd = $.trim(data);
						var classname = 'mod-'+newd;
				
				
						if(newd == '01')
						{
							swal("Duplicate Data !!! Please try Another... ");
						}
						else
						{
							$('.vehi_model_class').append('<tr class="'+classname+'"><td class="text-center">'+model_name+'</td><td class="text-center"><button type="button" modelid='+data+' deletemodel="{!! url('/vehicle/vehicle_model_delete') !!}" class="btn btn-danger btn-xs modeldeletes">X</button></a></td><tr>');
							
							/*$('.model_addname').append('<option value='+model_name+'>'+model_name+'</option>');*/
							$('.model_addname').append("<option value='"+model_name+"'>"+model_name+"</option>");
							$('.vehi_modal_name').val('');
						}

						//Form submit at a time only one for addVehicleModel
						$(".vehi_model_add").prop('disabled', false);
						return false;
					},
				});
			}
		});
		
	
		$('body').on('click','.modeldeletes',function(){
			
			var mod_del_id = $(this).attr('modelid');
			var del_url = $(this).attr('deletemodel');
			
			swal({
				title: "Are you sure?",
				text: "You will not be able to recover this imaginary file!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, delete it!",
				closeOnConfirm: false
			},
			function(isConfirm){
				if (isConfirm) 
				{
					$.ajax({
						
						type:'GET',
						url:del_url,
						data:{mod_del_id:mod_del_id},
						success:function(data)
						{
							$('.mod-'+mod_del_id).remove();
							$(".model_addname option[value="+mod_del_id+"]").remove();
							swal("Done!","It was succesfully deleted!","success");
						}
					});
				}
				else
				{
					swal("Cancelled", "Your imaginary file is safe :)", "error");
				} 
			})
		});	
	});

</script>
<!-- End Add Vehicle Model -->


<!-- vehical Type from brand -->

<script>
$(document).ready(function(){
	
	$('.select_vehicaltype').change(function(){
		vehical_id = $(this).val();
		var url = $(this).attr('vehicalurl');

		$.ajax({
			type:'GET',
			url: url,
			data:{ vehical_id:vehical_id },
			success:function(response){
				$('.select_vehicalbrand').html(response);
			}
		});
	});
	
});

</script>

<!-- Vehical Description-->
<script>
$("#add_new_description").click(function(){

		var row_id = $("#tab_decription_detail > tbody > tr").length;
		
		var url = $(this).attr('url');
		$.ajax({
                       type: 'GET',
                      url: url,
                     data : {row_id:row_id},
                     beforeSend: function() { 
				      $("#add_new_description").prop('disabled', true); // disable button
				    },
                     success: function (response)
                        {	
						
                            $("#tab_decription_detail > tbody").append(response.html);
                            $("#add_new_description").prop('disabled', false); // enable button
							return false;
						},
                    error: function(e) {
                 alert("An error occurred: " + e.responseText);
                    console.log(e);
                }
       });
	});
$('body').on('click','.delete_description',function(){
	
		var row_id = $(this).attr('data-id');
	
		$('table#tab_decription_detail tr#row_id_'+row_id).remove();		
		return false;
	});
</script>

<!-- vehical color -->
<script>
$("#add_new_color").click(function(){
		var color_id = $("#tab_color > tbody > tr").length;
		
		var url = $(this).attr('url');
        
		$.ajax({
                       type: 'GET',
                      url: url,
                     data : {color_id:color_id},
                     beforeSend: function() { 
				      $("#add_new_color").prop('disabled', true); // disable button
				    },
                     success: function (response)
                        {	
						   
                            $("#tab_color > tbody").append(response.html);
                            $("#add_new_color").prop('disabled', false); // disable button
							return false;
						},
                    error: function(e) {
                 alert("An error occurred: " + e.responseText);
                    console.log(e);
                }
       });
	});
$('body').on('click','.remove_color',function(){
	
		var color_id = $(this).attr('data-id');
	
		$('table#tab_color tr#color_id_'+color_id).remove();		
		return false;
	});
</script>

<!-- Vehical image-->

<script>

            $(document).ready(function(){
                // Basic
                $('.dropify').dropify();

                // Translated
                $('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-déposez un fichier ici ou cliquez',
                        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                        remove:  'Supprimer',
                        error:   'Désolé, le fichier trop volumineux'
                    }
                });

                // Used events
                var drEvent = $('#input-file-events').dropify();

                drEvent.on('dropify.beforeClear', function(event, element){
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function(event, element){
                    alert('File deleted');
                });

                drEvent.on('dropify.errors', function(event, element){
                    console.log('Has Errors');
                });

                var drDestroy = $('#input-file-to-destroy').dropify();
                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function(e){
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        drDestroy.destroy();
                    } else {
                        drDestroy.init();
                    }
                })
            });
        
</script>
<!-- images show in multiple in for loop -->

<script>
$(document).ready(function(){
    $(".imageclass").click(function(){
        $(".classimage").empty();
    });
});
</script>
  <script>
		function preview_images() 
		{
		 	var total_file=document.getElementById("images").files.length;
		 
		 	for(var i=0;i<total_file;i++)
		 	{
			 
		  		$('#image_preview').append("<div class='col-md-3 col-sm-3 col-xs-12' style='padding:5px;'><img class='uploadImage' src='"+URL.createObjectURL(event.target.files[i])+"' width='100px' height='60px'> </div>");
		 	}
		}
		
	</script>	
<!--  new image append -->
<script>
$("#add_new_images").click(function(){
		var image_id = $("#tab_images > tbody > tr").length;
		
		var url = $(this).attr('url');

		$.ajax({
                       type: 'GET',
                       url: url,
                     data : {image_id:image_id},
                     success: function (response)
                        {	
						   
                            $("#tab_images > tbody").append(response);
							return false;
						},
                    error: function(e) {
                 alert("An error occurred: " + e.responseText);
                    console.log(e);
                }
       });
	});
$('body').on('click','.trash_accounts',function(){
	
		var image_id = $(this).attr('data-id');
		
		$('table#tab_images tr#image_id_'+image_id).fadeOut();	
		return false;
	});
</script>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

<script>
    $('.datepicker').datetimepicker({
       format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
    });
</script>


<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\VehicleAddEditFormRequest', '#vehicleAdd-Form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

<!-- Form submit at a time only one -->
<script type="text/javascript">
    /*$(document).ready(function () {
        $('.vehicleAddSubmitButton').removeAttr('disabled'); //re-enable on document ready
    });
    $('.vehicleAddForm').submit(function () {
        $('.vehicleAddSubmitButton').attr('disabled', 'disabled'); //disable on any form submit
    });

    $('.vehicleAddForm').bind('invalid-form.validate', function () {
      $('.vehicleAddSubmitButton').removeAttr('disabled'); //re-enable on form invalidation
    });*/
</script>

@endsection