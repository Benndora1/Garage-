@extends('layouts.app')

@section('content')
<!-- Code Start -->
	<div class="right_col" role="main">
        <div class="">
            <div class="page-title">
               	<div class="nav_menu">
					<nav>
				  		<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Invoice')}}</span></a>
				  		</div>
						@include('dashboard.profile')
					</nav>
			  	</div>
			</div>
        </div>
		
		<div class="x_content">
            <ul class="nav nav-tabs bar_tabs" role="tablist">
            	@can('invoice_view')
					<li role="presentation" class=""><a href="{!! url('/invoice/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Invoice List')}}</a></li>
				@endcan
				@can('invoice_edit')
					<li role="presentation" class="active"><a href="{!! url('/invoice/list/edit/'.$invoice_edit->id) !!}"><span class="visible-xs"></span><b>{{ trans('app.Edit Invoice')}}</b></a></li>
				@endcan
			</ul>
		</div>
        
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   	<div class="x_content">
                    	<form method="post" id="form_add" action="{{ url('/invoice/list/edit/update/'.$invoice_edit->id) }}" enctype="multipart/form-data"  name="Form" class="form-horizontal upperform" onsubmit="return enableSample()">
						
							<div class="col-md-12 col-xs-12 col-sm-12">
						  		<h4><b>{{ trans('app.Invoice Details')}}</b></h4>
						  		<hr style="margin-top:0px;">
						  		<p class="col-md-12"></p>
						  	</div>
	                    	
	                    	<div class="col-md-12 col-sm-12 col-xs-12 form-group">  
								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Invoice Number') }} <label class="color-danger">*</label></label>						
									<div class="col-md-8 col-sm-8 col-xs-12">
										<input type="text" name="Invoice_Number" class="form-control" value="{{ $invoice_edit->invoice_number }}" readonly>
									</div>
								</div>

								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Customer Name') }} <label class="color-danger">*</label></label>						
									<div class="col-md-8 col-sm-8 col-xs-12">
										<select name="Customer" id="cust" class="form-control select_cus customer_name" customer_url="{!! url('invoice/get_jobcard_no') !!}" disabled>
											<option value="">{{ trans('app.Select Customer') }}</option>
											@foreach($customer as $customers)
											<option value="{{ $customers->customer_id }}" <?php if($customers->customer_id == $invoice_edit->customer_id){ echo 'selected'; } ?> ><?php echo getCustomerName($customers->customer_id); ?></option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								@if($invoice_edit->type == 1 || $invoice_edit->type == 0)
								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
									<?php if(getVehicleName($invoice_edit->job_card) == null) { ?>
												<label class="control-label col-md-4 col-sm-4 col-xs-12" for="job_card">{{ trans('app.Jobcard Number') }} <label class="color-danger">*</label> 
												</label>
									<?php } else {?>
												<label class="control-label col-md-4 col-sm-4 col-xs-12" for="job_card">{{ trans('app.Select Vehicle') }} <label class="color-danger">*</label> 
												</label>
									<?php } ?>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<select name="Job_card" id="jb" class="form-control job_number" disabled>
											@if(!empty($invoice_edit))
											<option class="job_no" value="<?php echo $invoice_edit->job_card; ?>"><?php if(getVehicleName($invoice_edit->job_card) == null) { echo $invoice_edit->job_card; } else { echo getVehicleName($invoice_edit->job_card); } ?></option>
											@endif
										</select>
										<input type="hidden" class="service_id" name="jobcard_no" value="{{ $invoice_edit->sales_service_id }}">
									</div>								
								</div>
						  		@endif

						  		<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12 currency" for="cus_name" style="padding-left:0px;">{{ trans('app.Total Amount') }} (<?php echo getCurrencySymbols();?>) <label class="color-danger">*</label> 
									</label>						
									<div class="col-md-8 col-sm-8 col-xs-12">
										<input type="text" id="ttl_amt" name="Total_Amount" class="form-control ttl_amount" value="{{ $invoice_edit->total_amount }}" readonly>
									</div>
								</div>	  								
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="Date">{{ trans('app.Invoice Date')}} <label class="color-danger">*</label></label>									
									<div class="col-md-8 col-sm-8 col-xs-12 input-group date datepicker" >
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text"  name="Date" autocomplete="off" id="date_of_birth"  class="form-control invoiceDate" value="{{ date(getDateFormat(),strtotime($invoice_edit->date)) }}" placeholder="<?php echo getDateFormat();?>" onkeypress="return false;" required >
									</div>
								</div>

								<div class="col-md-6 col-sm-6 col-xs-12 form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Discount (%)') }} </label>						
									<div class="col-md-8 col-sm-8 col-xs-12">
										<input type="text" name="Discount" maxlength="3" id="disc" class="form-control discount" value="{{ $invoice_edit->discount }}">
									</div>
								</div>								
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Details') }}</label>						
									<div class="col-md-8 col-sm-8 col-xs-12">
										<textarea name="Details" class="form-control">{{ $invoice_edit->details }}</textarea>
									</div>
								</div>

								<div class="col-md-6 col-sm-6 col-xs-12 form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Tax') }}
									</label>						
									<div class="col-md-8 col-sm-8 col-xs-12">
										<table>
											<tbody>
											<?php $edit_tax = explode(", ",$invoice_edit->tax_name); ?>
											@foreach($tax as $taxes)
												<tr>
													<td>
														<input type="checkbox" id="tax" class="checkbox-inline check_tax sele_tax myCheckbox" name="Tax[]" value="<?php 
														echo $taxes->taxname.' '.$taxes->tax;?>" taxrate="{{$taxes->tax}}" style="height:20px; width:20px; margin-right:5px; position: relative; top: 6px; margin-bottom: 12px;" <?php if(in_array($taxes->taxname.' '.$taxes->tax,$edit_tax)) { echo 'checked'; } ?>>
																									
														<?php 
														echo $taxes->taxname.'&nbsp'.$taxes->tax; ?>
													</td>
												</tr>
											@endforeach
											</tbody>
										</table>
									</div>
								</div>																
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Status') }} <label class="color-danger">*</label></label>						
									<div class="col-md-8 col-sm-8 col-xs-12">
										<select name="Status" class="form-control paymentStatusSelect" required>
											<option value="">{{ trans('app.Select Payment Status') }}</option>
											<option value="1" <?php if($invoice_edit->payment_status == '1'){ echo 'selected'; } ?>>{{ trans('app.Half Paid') }}</option>
											<option value="2" <?php if($invoice_edit->payment_status == '2'){ echo 'selected'; } ?>>{{ trans('app.Full Paid') }}</option>
											<option value="0" <?php if($invoice_edit->payment_status == '0'){ echo 'selected'; } ?>>{{ trans('app.Unpaid') }}</option>
										</select>
									</div>
								</div>

								<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group paymentTypeMainDiv">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Payment Type') }}	<label class="color-danger">*</label></label>					
									<div class="col-md-8 col-sm-8 col-xs-12">
										<select name="Payment_type" class="form-control paymentType">
											<option value="">{{ trans('app.Select Payment Type') }}</option>
										@if(!empty($tbl_payments))
											@foreach($tbl_payments as $tbl_paymentss)
											<option value="{{$tbl_paymentss->id}}" <?php if($invoice_edit->payment_type == $tbl_paymentss->id ){ echo 'selected'; } ?>>{{ $tbl_paymentss->payment  }} </option>
											@endforeach
										@endif	
										</select>
									</div>
								</div>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 form-group">   
							  	<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group paidAmountMainDiv">
		                        	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Paid Amount') }} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label></label>
		                        	<div class="col-md-8 col-sm-8 col-xs-12">
										<input type="text" name="paidamount" value="{{ $invoice_edit->amount_recevied }}" class="form-control paidamount">
										<input type="hidden" id="amount_recevied" value="{{$invoice_edit->amount_recevied}}">
		                       	 	</div>
		                      	</div>
		                    
							  	<div class="col-md-6 col-sm-6 col-xs-12 form-group">
		                        	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Grand Total') }} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label></label>						
		                        	<div class="col-md-8 col-sm-8 col-xs-12">
										<input type="text"  id="grandtotal" name="grandtotal" class="form-control grandtotal" value="{{ $invoice_edit->grand_total }}" readonly >
		                        	</div>
		                      	</div>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 form-group amountDueMainDiv">
						  		<div class="col-md-6 col-sm-6 col-xs-12 form-group color-danger">
									<label class="control-label col-md-4 col-sm-4 col-xs-12 color-danger" for="cus_name">{{ trans('app.Amount Due') }} (<?php echo getCurrencySymbols();?>) <label class="color-danger">*</label></label>				
									<div class="col-md-8 col-sm-8 col-xs-12">
										<input type="text" name="dueamount" id="dueamount" class="form-control dueamount" value="{{ $dueamount }}" readonly>
									</div>
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
										$userid = $invoice_edit->id;
										$datavalue = getCustomDataInvoice($tbl_custom,$userid);

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
																	$getRadioValue = getRadioLabelValueForUpdateForAllModules($tbl_custom_field->form_name ,$invoice_edit->id, $tbl_custom_field->id);

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
															$getCheckboxValue = getCheckboxLabelValueForUpdateForAllModules($tbl_custom_field->form_name, $invoice_edit->id, $tbl_custom_field->id);
														?>
														<div style="margin-top: 5px;">
														@foreach($checkboxLabelArrayList as $k => $val)
															<input type="{{$tbl_custom_field->type}}" name="custom[{{$tbl_custom_field->id}}][]" value="{{$val}}"
															<?php
															 	if($val == getCheckboxValForAllModule($tbl_custom_field->form_name, $invoice_edit->id, $tbl_custom_field->id,$val)) 
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
	                        	<div class="col-md-12 col-sm-12 col-xs-12 text-center">
	                          		<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
	                          		<button type="submit" class="btn btn-success submit" >{{ trans('app.Update')}}</button>
	                        	</div>
	                      	</div>
                    	</form>
					</div>
            	</div>	
        	</div>
    	</div>
	</div>	
<!-- Content Code end -->

<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<!-- Datetimepicker -->
	<script>
    $('.datepicker').datetimepicker({
       format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
    });
	</script>
	
	<!--For Tax Validation -->
<script type="text/javascript">
    $(document).ready(function(){
        
		$('#form_add').submit(function(){
			var dis = $('#disc').val();
	
			if(dis > 100)
			{
				//alert('Percentage must be less than or equal to 100');
				swal({   
						title: "Discount Rate",
						text: 'Percentage must be less than or equal to 100'
					});
				return false;
			}
			
        });
    });
	 
</script>

	<script>
	$(document).ready(function(){
		
		/*on keyup in discount*/
		$('body').on('keyup','#disc',function(){
		
				var total1 = $('.ttl_amount').val();
				var amountDueIs = $('#dueamount').val();
				
				//alert(total1);
				if(total1 != '')
				{
					var total = total1;
				}
				else
				{
					var total = 0;
				}
				
				var disc = $('#disc').val();
				if(disc != '')
				{
				 var discount= ( parseFloat(total) * parseFloat(disc)) / 100;
				 
				}
				else
				{
					var discount = 0;
				}
					
				var final = 0;
				$('.myCheckbox:checked').each(function(){        
					var values = $(this).attr('taxrate');
					final = parseFloat(values) + parseFloat(final);
				});
					
				var totalamount = parseFloat(total) - parseFloat(discount);
				var totaltax = (parseFloat(totalamount) * parseFloat(final)) / 100;
				var grandtotal = parseFloat(totalamount) + parseFloat(totaltax);
								
				$('#grandtotal').val(grandtotal);
				/*After discount due amount is greater and grand total is less after discount is zero*/
				/*if (grandtotal >= amountDueIs) {					
					
				}
				else{
					$('#disc').val("");
				}*/
				
		});
		// changes taxt
		$('body').on( 'click','.myCheckbox', function(){
		
			var total1 = $('.ttl_amount').val();
				if(total1 != '')
				{
					var total =total1;
				}
				else
				{
					var total =0;
				}
					var disc = $('#disc').val();
					if(disc != '')
					{
					 var discount= ( parseFloat(total) * parseFloat(disc)) / 100;
					 
					}
					else
					{
						var discount = 0;
					}
					
					var final = 0;
						$('.myCheckbox:checked').each(function(){        
							var values = $(this).attr('taxrate');
							final = parseFloat(values) + parseFloat(final);
						});
						
						var totalamount = parseFloat(total) - parseFloat(discount);
						var totaltax = (parseFloat(totalamount) * parseFloat(final)) / 100;
						var grandtotal = parseFloat(totalamount) + parseFloat(totaltax);
						
					$('#grandtotal').val(grandtotal); 
		});
		
		//paid amount
		$('body').on('keyup','.paidamount',function(){

			var paidamount = $(this).val();			
			var dueamount = $('#dueamount').val();
			var amount_recevied = $('#amount_recevied').val();
			var totalgrand = parseInt(dueamount) + parseInt(amount_recevied)
			
			var statusValue = $('select[name=Status]').val();
			var rgs = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)$/g;

			if (statusValue == 1) {
				if (parseInt(paidamount) > parseInt(dueamount)) {
					$(this).val(dueamount/2);
					swal({   
						title: "Pay Amount",
						text: 'Please pay half or less than due amount, because you select half pay'
					});
				}
				else if(parseInt(paidamount) == parseInt(dueamount)){
					$(this).val(dueamount/2);
					swal({   
						title: "Pay Amount",
						text: 'Please pay half or less than due amount, because you select half pay'
					});
				}
				else if(parseInt(paidamount) == 0){
					$(this).val(dueamount/2);
					swal({   
						title: "Pay Amount",
						text: 'Please pay half or less than due amount amount, because you select half pay'
					});
				}
				else if(!paidamount.replace(/\s/g, '').length){
					$(this).val("");
					/*swal({   
						title: "Invalid Input Alert",
						text: 'Please enter only numeric data'
					});*/
				}
				else if (!rgs.test(paidamount)){
					$(this).val("");
					/*swal({   
						title: "Invalid Input Alert",
						text: 'Please enter only numeric data'
					});*/
				}
			}
			else if(statusValue == 2)
			{
				if (parseInt(paidamount) > parseInt(dueamount)) {
					$(this).val(dueamount);
					swal({   
						title: "Pay Amount",
						text: 'Please pay only due amount, because you select full pay'
					});
				}
				else if(parseInt(paidamount) < parseInt(dueamount)){
					$(this).val(dueamount);
					swal({   
						title: "Pay Amount",
						text: 'Please pay only due amount, because you select full pay'
					});
				}
				else if(parseInt(paidamount) == 0){
					$(this).val(dueamount);
					swal({   
						title: "Pay Amount",
						text: 'Please pay only due amount, because you select full pay'
					});
				}
				else if(!paidamount.replace(/\s/g, '').length){
					$(this).val("");
					/*swal({   
						title: "Invalid Input Alert",
						text: 'Please enter only numeric data'
					});*/
				}
				else if (!rgs.test(paidamount)){
					$(this).val("");
					/*swal({   
						title: "Invalid Input Alert",
						text: 'Please enter only numeric data'
					});*/
				}
			}
			else if(statusValue == 0)
			{
				$(this).val(0);
			}

			/*if(parseInt(paidamount) <= parseInt(totalgrand))
			{
				
			}
			else{
				 
				swal({   
					title: "Pay Amount",
					text: 'please enter an amount less than dueamount + paidamount'  

					});
				if(amount_recevied == 0)
				{					
					var paidamount = $(this).val('');	
				}else
				{
					var paidamount = $(this).val(amount_recevied);
				}					
					return false;
					
			}*/
			
		});
		
		//jobcard number 
		$('body').on('change','.select_cus',function(){
			
			var url = $(this).attr('customer_url');
			var cus_name = $('.select_cus :selected').val();
			
			$.ajax({
				type:'GET',
				url:url,
				data:{ cus_name:cus_name },
				
				success:function(response)
				{
					$('.job_no').remove();
					$('.job_number').append(response);
				},
				error:function(e)
				{
					console.log(e);
				}
			});
		});
		
	});
	</script>
	<script>
	$(document).ready(function(){
		
		$('body').on('change','.job_number',function(){
			
			var url = $(this).attr('job_url');
			var job_no = $('.job_number :selected').val();
			
			$.ajax({
				type:'GET',
				url:url,
				data:{ job_no:job_no },
				
				success:function(response)
				{
					var s_id = $.trim(response);
					$('.service_id').val(s_id);
				},
				error:function(e)
				{
					console.log(e);
				}
			});
		});
		
	});
	</script>
	
<script>
	function enableSample() {
	/*document.getElementById('cust').disabled=false;
	document.getElementById('jb').disabled=false;
	document.getElementById('ttl_amt').disabled=false;*/
	}
</script>


<script>
	/* discount field accept only numbers */
	$('body').on('keyup','.discount', function(){

		var discountAmt = $(this).val();
		var useRegex = /^[0-9]*\d?(\.\d{1,2})?$/;

		if (discountAmt > 100) {
			$(this).val(0);
		}
		else if(!discountAmt.replace(/\s/g, '').length){
			$(this).val("");
		}
		else if (!useRegex.test(discountAmt)){
			$(this).val("");
		}
	});


	/*$('body').on('change','.paymentStatusSelect',function(){

		var statusValue = $('select[name=Status]').val();
		var grandTotalValue = $('.grandtotal').val();
		var dueAmount = $('.dueamount').val();

		if (statusValue != null) 
		{
			if (statusValue == 1) {
				$('.paidamount').val(dueAmount / 2);
			}
			else if (statusValue == 2){				
				$('.paidamount').val(dueAmount);
			}			
			else if (statusValue == 0)
			{
				if (dueAmount < grandTotalValue) {
					swal({   
						title: "Pay Amount",
						text: 'Please select half pay or full pay'
					});
					$(this).val(1);
				}
				else if(dueAmount == grandTotalValue)	{
					$('.paidamount').val(0);
				}
			}
		}
	});*/
</script>


<script>
	/*If select box have value then error msg and has error class remove*/
	$('body').on('change','.invoiceDate',function(){

		var dateValue = $(this).val();

		if (dateValue != null) {
			$('#date_of_birth-error').css({"display":"none"});
		}

		if (dateValue != null) {
			$(this).parent().parent().removeClass('has-error');
		}
	});

	$(document).ready(function(){

		$('.customer_name').on('change',function(){

			var customerValue = $('select[name=Customer]').val();
			
			if (customerValue != null) {
				$('#cust-error').css({"display":"none"});
			}

			if (customerValue != null) {
				$(this).parent().parent().removeClass('has-error');
			}
		});
	});



	//$('body').on('change','.paymentStatusSelect',function(){

	$(document).ready(function(){
		var statusValue = $('select[name=Status]').val();
		var grandTotalValue = $('.grandtotal').val();
		var dueAmount = $('.dueamount').val();

		if (statusValue != null)
		{
			if (statusValue == 1) {
				$('.paidAmountMainDiv').css({"display":""});
				$('.paymentTypeMainDiv').css({"display":""});
				$('.amountDueMainDiv').css({"display":""});			
				$('.paidamount').val(grandTotalValue / 2);
			}
			else if (statusValue == 2){				
				$('.paidAmountMainDiv').css({"display":""});
				$('.paymentTypeMainDiv').css({"display":""});
				$('.amountDueMainDiv').css({"display":""});
				$('.paidamount').val(grandTotalValue);
			}
			else if (statusValue == 0)			{
				$('.paidAmountMainDiv').css({"display":"none"});
				$('.paymentTypeMainDiv').css({"display":"none"});
				$('.amountDueMainDiv').css({"display":"none"});
				$('.paidamount').val("");
				$('.paymentType').val("");						
			}
		}
	});



	$('body').on('change','.paymentStatusSelect',function(){

		var statusValue = $('select[name=Status]').val();
		var grandTotalValue = $('.grandtotal').val();
		var dueAmount = $('.dueamount').val();

		if (statusValue != null)
		{
			if (statusValue == 1) {
				$('.paidAmountMainDiv').css({"display":""});
				$('.paymentTypeMainDiv').css({"display":""});
				$('.amountDueMainDiv').css({"display":""});			
				$('.paidamount').val(grandTotalValue / 2);
			}
			else if (statusValue == 2){				
				$('.paidAmountMainDiv').css({"display":""});
				$('.paymentTypeMainDiv').css({"display":""});
				$('.amountDueMainDiv').css({"display":""});
				$('.paidamount').val(grandTotalValue);
			}
			else if (statusValue == 0)			{
				$('.paidAmountMainDiv').css({"display":"none"});
				$('.paymentTypeMainDiv').css({"display":"none"});
				$('.amountDueMainDiv').css({"display":"none"});
				$('.paidamount').val("");
				$('.paymentType').val("");						
			}
		}
	});
</script>

<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\InvoiceAddEditFormRequest', '#form_add'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

@endsection