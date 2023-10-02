@extends('layouts.app')
@section('content')
<style>
.first_width,.second_width{width:82%;}
.table{margin-bottom:0px;}
.all{width:42%;}

</style>

<!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Vehicle Sale')}}</span></a>
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
                <ul class="nav nav-tabs bar_tabs" role="tablist">
                	@can('sales_view')
						<li role="presentation" class=""><a href="{!! url('/sales/list')!!}"><span class="visible-xs"></span> <i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.List Of Vehicle Sale')}}</span></a></li>
					@endcan
					@can('sales_edit')
						<li role="presentation" class="active"><a href="{!! url('/sales/list/edit/'.$editid)!!}"><span class="visible-xs"></span> <i class="fa fa-pencil-square-o" aria-hidden="true">&nbsp;</i><b>{{ trans('app.Edit Vehicle Sale')}}</b></span></a></li>
					@endcan
				</ul>
			</div>
            <div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_content">
							<form id="vehicleSalesEditForm" method="post" action="update/{{ $sales->id }}" enctype="multipart/form-data"  class="form-horizontal upperform">

								<div class="form-group">
									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Bill No')}} <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<input type="text" id="bill_no" name="bill_no" class="form-control" value="{{ $sales->bill_no }}" readonly>
										</div>
									</div>

									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Sales Date')}} <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12 input-group date datepicker">
										 <?php 
										   if($sales->date == '0000-00-00')
										   {
											$salesdate=getDatepicker();
										   }
										   else
										   {
											$salesdate=date(getDateFormat(),strtotime($sales->date));
										   }
										   ?>
											<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
											<input type="text" id="sales_date" name="date" autocomplete="off" class="form-control salesDate" placeholder="<?php echo getDateFormat();?>" value="{{ $salesdate }}" onkeypress="return false;" required>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Customer Name')}} <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<select class="form-control select_customer_auto_search customer_name" name="cus_name" id="supplier_select" required>
												<option value="">{{ trans('app.Select Customer')}}</option>
												@if(!empty($customer))
													@foreach($customer as $customers)
														<option value="{{ $customers->id }}" <?php if($customers->id==$sales->customer_id) { echo 'selected';}?>>{{ $customers->name.' '.$customers->lastname }}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
									<!-- <div class="has-feedback {{ $errors->has('qty') ? ' has-error' : '' }}">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Quantity')}} <label class="text-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<input type="text" id="qty" name="qty" min="0"  class="form-control"  url="{!! url('sales/add/getqty')!!}" value="{{ $sales->quantity }}" maxlength="5" required>
											@if ($errors->has('qty'))
												<span class="help-block">
													<strong>{{ $errors->first('qty') }}</strong>
												</span>
											@endif
										</div>
									</div> -->

									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Salesman')}} <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<select class="form-control" name="salesmanname" id="" required>
												<option value="">{{ trans('app.Select Name')}}</option>
												@if(!empty($employee))
													@foreach($employee as $employees)
														<option value="{{ $employees->id }}" <?php if($employees->id == $sales->salesmanname) {echo 'selected';} ?>>{{ $employees->name.' '.$employees->lastname }}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>									
								</div>

								<div class="form-group">
									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Select Vehicle Brand')}} <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<select class="form-control veh_brand" name="vehi_bra_name" id="vehi_bra_name" bran_url="{!! url('sales/edit/getmodel_name')!!}" required>
												<option value="">{{ trans('app.Select Vehicle Brand')}}</option>
												
												@foreach($brand as $brands)
												<option value="{{ $brands->id }}" <?php if($brands->id ==$sales->vehicle_brand) {echo "selected";}?>>{{ $brands->vehicle_brand }}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Chassis')}} </label>
										
										<div class="col-md-4 col-sm-4 col-xs-12">
										
										
											<select id="chassis_num" name="chassis"  class="form-control">
											
												<option value=""> {{ trans('app.Select Chassis Number') }} </option>
												<!-- Option Shows from controller -->
												@foreach($vehicale as $vehicles)
												<option value="<?php echo $vehicles->chassisno; ?>" <?php if($vehicles->id==$sales->vehicle_id) { echo "selected"; } ?>><?php echo $vehicles->chassisno; ?></option>
												@endforeach
											</select>
										</div>
									</div>
								</div>

								<div class="form-group">									
									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">Select Model <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<select class="form-control selectmodel" name="vehicale_name" id="vehicale_select" url="{!! url('sales/edit/getrecord')!!}" chasisurl="{!! url('sales/edit/getchasis') !!}" required>
												<option value="">{{ trans('app.Select Model')}}</option>
												@if(!empty($vehicale))
													@foreach($vehicale as $vehicales)
														<option class="modelnm" value="{{ $vehicales->id }}" modelname="<?php echo $vehicales->modelname; ?>" brand="<?php echo $vehicales->vehiclebrand_id;?>" vhi_type="<?php $vehicales->vehicletype_id;?>" <?php if($vehicales->id==$sales->vehicle_id) { echo 'selected';}?> >{{ $vehicales->modelname }}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>

									<div class="has-feedback {{ $errors->has('price') ? ' has-error' : '' }} my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Price')}} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
										
											<input type="text" id="price" name="price"  class="form-control" id="price" maxlength="10"  value="{{ $sales->price }}" readonly>
											@if ($errors->has('price'))
												<span class="help-block">
													<strong>{{ $errors->first('price') }}</strong>
												</span>
											@endif
										</div>
									</div>									
								</div>

								<div class="form-group">
									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Color')}} <label class="color-danger">*</label></label>
										<div class="col-md-2 col-sm-2 col-xs-12">
											<select id="color_type" name="color"  class="form-control color_name_data" required>
												<option value="">{{ trans('app.-- Select Color --')}}</option>
													@if(!empty($color))
														@foreach($color as $colors)
															<option value="{{ $colors->id }}" <?php if($colors->id==$sales->color_id) {echo 'selected';} ?> > {{ $colors->color }} </option>
														@endforeach
													@endif
											</select>
										</div>
										<div class="col-md-2 col-sm-2 col-xs-12 addremove">
											<button type="button" data-target="#responsive-modal-color" data-toggle="modal" class="btn btn-default">{{ trans('app.Add Or Remove')}}</button>
										</div>
									</div>

									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Total Price')}} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
										
											<input type="text" id="total_price" name="total_price"   class="form-control" value="{{ $sales->total_price }}" readonly>
										</div>
									</div>
								</div>

								<div class="form-group">									
								</div>

								<div class="form-group" style="margin-top:20px;">
									<div class="col-md-12">
									<h2 style="margin-left:10px;">{{ trans('app.Number of Services')}}</h2>
									</div>
								</div>

								<div class="form-group">
									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Interval')}} <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<select name="interval" id="interval" class="form-control"> 
												<option value="">{{ trans('app.Number of Interval')}}</option>
												<option value="1" <?php if($sales->interval == 1) {echo 'selected';} ?>>{{ trans('app.1 Month')}}</option>
												<option value="2"  <?php if($sales->interval == 2) {echo 'selected';} ?> >{{ trans('app.2 Month')}}</option>
												<option value="3"  <?php if($sales->interval == 3) {echo 'selected';} ?>>{{ trans('app.3 Month')}}</option>
											</select>
										</div>
									</div>

									<div class="">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Date Gap')}}</label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<select name="date_gape" id="date_gape" class="form-control" > 
												<option value="0" <?php if($sales->date_gap == 0) {echo 'selected';} ?>>{{ trans('app.1 Day')}}</option>
												<option value="3" <?php if($sales->date_gap == 3) {echo 'selected';} ?>>{{ trans('app.3 Day')}}</option>
												<option value="5" <?php if($sales->date_gap == 5) {echo 'selected';} ?>>{{ trans('app.5 Day')}}</option>
												<option value="10" <?php if($sales->date_gap == 10) {echo 'selected';} ?>>{{ trans('app.10 Day')}}</option>
											</select>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Number of Services')}} <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<select name="no_of_services" id="no_of_service" class="form-control no_of_service" url="{!! url('sales/add/getservices')!!}" > 
												<option value="0">{{ trans('app.Number of Services')}} </option>
												<option value="1" <?php if($sales->no_of_services == 1) {echo 'selected';} ?>>1</option>
												<option value="2" <?php if($sales->no_of_services == 2) {echo 'selected';} ?>>2</option>
												<option value="3" <?php if($sales->no_of_services == 3) {echo 'selected';} ?>>3</option>
												<option value="4" <?php if($sales->no_of_services == 4) {echo 'selected';} ?>>4</option>
												<option value="5" <?php if($sales->no_of_services == 5) {echo 'selected';} ?>>5</option>
												<option value="6" <?php if($sales->no_of_services == 6) {echo 'selected';} ?>>6</option>
												<option value="7" <?php if($sales->no_of_services == 7) {echo 'selected';} ?>>7</option>
												<option value="8" <?php if($sales->no_of_services == 8) {echo 'selected';} ?>>8</option>
												<option value="9" <?php if($sales->no_of_services == 9) {echo 'selected';} ?>>9</option>
												<option value="10" <?php if($sales->no_of_services == 10) {echo 'selected';} ?>>10</option>
												<option value="11" <?php if($sales->no_of_services == 11) {echo 'selected';} ?>>11</option>
												<option value="12" <?php if($sales->no_of_services == 12) {echo 'selected';} ?>>12</option>
											</select>
										</div>
									</div>

									<div class="my-form-group">
										<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Assign To')}} <label class="color-danger">*</label></label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<select class="form-control" name="assigne_to" id="assigne_to" required>
												<option value="">{{ trans('app.Select Name')}}</option>
												@if(!empty($employee))
													@foreach($employee as $employees)
														<option value="{{ $employees->id }}" <?php if($employees->id == $sales->assigne_to) {echo 'selected';} ?>>{{ $employees->name.' '.$employees->lastname }}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="" id="load_service_data">
										<table class="table" id="widthOfTableForResponsive" align="center" style="width: 80%;">
										<?php $i=1; ?>
										@if(!empty($sales_services))
											@foreach ($sales_services as $sales_service)
												<tr class="data_of_type">
													<td class="text-center">{{ $i }}</td>
													<td class="text-center"><input type="text" class="form-control first_width" value="{{ $sales_service->full_date }}" name="service[service_date][]" readonly></td>
													<td class="text-center"><input type="text" class="form-control second_width" name="service[service_text][]" value="{{ $sales_service->title }}" readonly></td>
													<td class="text-center"><input type="text" class="form-control second_width" name="service[service_job][]" value="{{ $sales_service->job_no }}" readonly></td>
												</tr>
												<?php $i++; ?>
											@endforeach
										@endif
										</table>
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
											$userid = $sales->id;
											$datavalue = getCustomDataSales($tbl_custom,$userid);

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
																	$getRadioValue = getRadioLabelValueForUpdateForAllModules($tbl_custom_field->form_name ,$sales->id, $tbl_custom_field->id);

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
															$getCheckboxValue = getCheckboxLabelValueForUpdateForAllModules($tbl_custom_field->form_name, $sales->id, $tbl_custom_field->id);
														?>
														<div style="margin-top: 5px;">
														@foreach($checkboxLabelArrayList as $k => $val)
															<input type="{{$tbl_custom_field->type}}" name="custom[{{$tbl_custom_field->id}}][]" value="{{$val}}"
															<?php
															 	if($val == getCheckboxValForAllModule($tbl_custom_field->form_name, $sales->id, $tbl_custom_field->id,$val)) 
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
				 
					  <!-- Color Add or Remove Model-->
							<div class="col-md-6">
								<div id="responsive-modal-color" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
									<div class="modal-dialog">
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
										<h4 class="modal-title">{{ trans('app.Color')}}</h4>
									  </div>
									   <div class="modal-body">
									   <form class="form-horizontal" action="" method="">
											
											<table class="table colornametype"  align="center" style="width:40em">
											<thead>
											<tr>
												<td class="text-center"><strong>{{ trans('app.Color Name')}}</strong></td>
												<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
											</tr>
											</thead>
											<tbody>
											@foreach ($color as $colors)
											<tr class="del-{{$colors->id }} data_color_name" >
											<td class="text-center ">{{ $colors->color }}</td>
											<td class="text-center">
											
											<button type="button" colorid="{{ $colors->id }}" deletecolor="{!! url('sales/colortypedelete') !!}" class="btn btn-danger btn-xs colordelete">X</button>
											</td>
											</tr>
											@endforeach
											
											</tbody>
											</table>
											
											 <div class="col-md-8 form-group data_popup">
												<label>{{ trans('app.Color Name')}}: <span class="text-danger">*</span></label>
													<input type="text" class="form-control c_name" name="c_name"  placeholder="{{ trans('app.Enter color name')}}" />
											</div>
											
											<div class="col-md-4 form-group data_popup" style="margin-top:24px;">
													<button type="button" class="btn btn-success addcolor" colorurl="{!! url('sales/color_name_add') !!}">{{ trans('app.Submit')}}</button>
											</div>
										
										</form>
									  
									  
									</div>
									</div>
								 </div>
								</div>
							</div>
					</div>
				</div>
            </div>
        </div>
	</div>
<!-- page content end -->

<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>  
 <script>
	$('input[name=qty]').keyup(function(){
		$(this).val($(this).val().replace(/[^\d]/,''));
	});
</script>
<script type="text/javascript">
	$(function(){
		
			$('#vehicale_select').change(function(){
			
				var vehicale_id = $(this).val();
				var url = $(this).attr('url');
				var qty= $('#qty').val();
					$.ajax({
						type: 'GET',
						url: url,
						data : {vehicale_id:vehicale_id},
					
						success: function (response)
							 {	
								var res_cust = jQuery.parseJSON(response);
								
								var price_dta = res_cust.price;
								
								$('#price').attr('value',res_cust.price);
								
								total_price =  price_dta * 1;
								 $('#total_price').val(total_price);								
							},

					    beforeSend:function()
							{
								$('#price').attr('value','Loading...');
							},

					    error: function(e) 
							{
							 alert("An error occurred: " + e.responseText);
								console.log(e);
							}
						});


			});
			
			$('#vehicale_select').change(function(){
				
				
				
				var url = $(this).attr('chasisurl');
				var	modelname = $('option:selected', this).attr('modelname');
				var	vehicle_id = $('option:selected', this).val();
				
				
				
					$.ajax({
						type: 'GET',
						url: url,
						data : {modelname:modelname,vehicle_id:vehicle_id},
					
						success: function (response)
							 {	
								$('#chassis_num').html(response);
							 },

					    beforeSend:function()
							{
								$('#price').attr('value','Loading...');
							},

					    error: function(e) 
							{
							 alert("An error occurred: " + e.responseText);
								console.log(e);
							}
						});
			});
	});
</script>

<script>

$(document).ready(function(){
	
	$('.veh_brand').change(function(){
		
		var url = $(this).attr('bran_url');
		var brand_name = $(this).val();
		
		$.ajax({
			type : 'GET',
			url : url,
			data : {brand_name:brand_name},
			
			success:function(response)
			{
				
				$('.modelnm').remove();
				$('.selectmodel').append(response);
			},
			error:function(e)
			{
				alert("Somthing went wrong... :" + e.responseText);
				console.log(e);
			},
			
		});
		
	});
	
});


</script>

<script>
 $('body').on('keyup','#qty',function(){
			
            var qty= $('#qty').val();
			var price= $('#price').val();
			var url = $(this).attr('url');
			$.ajax({
						type: 'GET',
						url: url,
						data : {qty:qty,price:price},
						success: function (response)
							 {	
								
								total_price =  price * 1;
								 $('#total_price').val(total_price);
								
							},

							beforeSend:function()
							{
								
							},

					    error: function(e) 
							{
							 alert("An error occurred: " + e.responseText);
								console.log(e);
							}
						});

			


        });
</script>

<script>
	$(document).ready(function(){
		
		
		$("#no_of_service").change(function(){
			
			var interval=$("#interval").val();
			
			var date_gape=$("#date_gape").val();
			var no_service=$("#no_of_service").val();
			var url = $(this).attr('url');
			
			if(interval!='' || date_gape!='' || no_service!='')
			{
				if($("#interval").val() == ''){
				  swal({   
							title: "Interval",
							text: "Please select Interval!"   

						});
				  $('#no_of_service').html('<option value="0">No of service </option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>');
				  return false;
				}
			if(interval!='' && date_gape!='' && no_service!='') {
			 
					$("#date_gape").change(function(){
						$("#load_service_data").css("display", "none");
						 $('#no_of_service').html('<option value="0">No of service </option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>');
				  
					});
					
					$("#interval").change(function(){
						$("#load_service_data").css("display", "none");
						 $('#no_of_service').html('<option value="0">No of service </option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>');
				 
					});
					
					
					$("#no_of_service").change(function(){
						$("#load_service_data").css("display", "block");
					});
			 
			$.ajax({
                       type: 'GET',
                      url: url,
                     data : {interval:interval,date_gape:date_gape,no_service:no_service},
                     success: function (response)
                        {
							
                            $("#load_service_data").html(response);
						},
                    error: function(e) {
                   alert("An error occurred: " + e.responseText);
                    console.log(e);
                },
				beforeSend:function(){
					$("#load_service_data").html("<center><h3>Loading...</h3></center>");
				}
				
			}); 
			 
			 
			}
			}
			
			
		});
	});
</script>

<!-- color add  model -->
<script>
$(document).ready(function(){
	$('.addcolor').click(function(){
		
		var c_name = $('.c_name').val();
		
		var url = $(this).attr('colorurl');

		if(c_name == ""){
            swal('Please Enter Color Name!');
			}else{
					$.ajax({
						type: 'GET',
						url: url,
						data : {c_name:c_name},
						success:function(data)
					  {
						  var newd = $.trim(data);
				          var classname = 'del-'+newd;
						if(data == '01')
								{
									swal("Duplicate Data !!! Please try Another... ");
								}else
								{
									$('.colornametype').append('<tr class="'+classname+' data_color_name"><td class="text-center">'+c_name+'</td><td class="text-center"><button type="button" colorid='+data+' deletecolor="{!! url('sales/colortypedelete') !!}" class="btn btn-danger btn-xs colordelete">X</button></a></td><tr>');
									$('.color_name_data').append('<option value='+data+'>'+c_name+'</option>');
									$('.c_name').val('');
									
								}
							},
							error: function(e) {
							alert("An error occurred: " + e.responseText);
							console.log(e);
						}
	              });
			}
		    
        });
  });
</script>
<!-- color Delete  model -->
<script>
$(document).ready(function(){
	
	$('body').on('click','.colordelete',function(){
		
	var colorid = $(this).attr('colorid');
	var url = $(this).attr('deletecolor');
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
								data:{colorid:colorid},
								success:function(data){
											$('.del-'+colorid).remove();
											$(".color_name_data option[value="+colorid+"]").remove();
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
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<!-- datetimepicker-->
	<script>
    $('.datepicker').datetimepicker({
       format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
    });
</script>

<!-- Using Slect2 make auto searchable dropdown -->
<script>
	/*$(document).ready(function () {
 		
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
	});*/

	$(document).ready(function(){
   		// Initialize select2
   		$(".select_customer_auto_search").select2();
   	});
</script>


<script>
	/*If select box have value then error msg and has error class remove*/
	$('body').on('change','.salesDate',function(){

		var dateValue = $(this).val();

		if (dateValue != null) {
			$('#sales_date-error').css({"display":"none"});
		}

		if (dateValue != null) {
			$(this).parent().parent().removeClass('has-error');
		}
	});

	$(document).ready(function(){

		$('.customer_name').on('change',function(){

			var customerValue = $('select[name=cus_name]').val();
			
			if (customerValue != null) {
				$('#supplier_select-error').css({"display":"none"});
			}

			if (customerValue != null) {
				$(this).parent().parent().removeClass('has-error');
			}
		});
	});
</script>

<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\StoreVehicleSaleAddEditFormRequest', '#vehicleSalesEditForm'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

@endsection