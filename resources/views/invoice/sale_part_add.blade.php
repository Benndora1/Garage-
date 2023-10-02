@extends('layouts.app')

@section('content')
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
				@can('invoice_add')
					<li role="presentation" class="active"><a href="{!! url('/invoice/add')!!}"><span class="visible-xs"></span> <i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Add Invoice')}}</b></a></li>
			 	@endcan
            </ul>
		</div>
        
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   	<div class="x_content">
                    	<form method="post" id="form_add" action="{{ url('/invoice/sale_part_invoice/store') }}" enctype="multipart/form-data"  name="Form" class="form-horizontal upperform salePartAddForm" >
							<div class="col-md-12 col-xs-12 col-sm-12">
					  			<h4><b>{{ trans('app.Invoice Details')}}</b></h4><hr>
							</div>
							
							<div class="row form-group" id="getid">
								<div class="col-md-12 col-sm-12 col-xs-12">
						  			<div class="col-md-6 col-sm-6 col-xs-12">
										<label class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Invoice For') }}</label>						
										<div class="col-md-8 col-sm-8 col-xs-12">
											<select name="Invoice_type" class="form-control invoicetype" sales_url="{!! url('invoice/sales_customer') !!}"  >
												<option value="">{{ trans('app.Select Type') }}</option>
												<option value="0">{{ trans('app.Service Invoice') }}</option>
												<option value="1">{{ trans('app.Sales Invoice') }}</option>
											</select>
										</div>
						  			</div>
						  		</div>
							</div>
                			
                			<div id="form_fields" style="display:none">
								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
										<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Invoice Number') }} <label class="color-danger">*</label></label>						
										<div class="col-md-8 col-sm-8 col-xs-12">
											<input type="text" name="Invoice_Number" class="form-control" value="{{ $code }}" readonly>
											<input type="hidden" name="paymentno" value="{{ $codepay }}">
										</div>
									</div>

									<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
										<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Customer Name') }} <label class="color-danger">*</label></label>						
										<div class="col-md-8 col-sm-8 col-xs-12 ">
											<select name="Customer" class="form-control select_cus customer_name" customer_url="{!! url('invoice/get_jobcard_no') !!}" vehicle_url ="{!! url('invoice/get_vehicle') !!}" required >
												@if(!empty($customer))
														<option>{{ trans('app.Select Customer') }}</option>
													@foreach($customer as $customers)
														<option value="{{ $customers->customer_id }}"><?php echo getCustomerName($customers->customer_id);//echo $customers->name.' '.$customers->lastname; ?></option>
													@endforeach
												@endif
												<!-- if redirect from jobcard list -->
												@if(!empty($customer_job))
													<option value="{{ $customer_job->customer_id }}" id="jobcard_list_job" selected><?php echo getCustomerName($customer_job->customer_id);?></option>
												@endif
												
												<!-- if redirect from sales list -->
												@if(!empty($tbl_sales))
													<option value="{{ $tbl_sales->customer_id }}" id="sales_list_id" selected><?php echo getCustomerName($tbl_sales->customer_id);?></option>
												@endif
											</select>
										</div>
									</div>
                    			</div>

								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<div class="col-md-6 col-sm-6 col-xs-12 form-group" id="job" style="display:none">
										<label class="control-label col-md-4 col-sm-4 col-xs-12" for="job_card">{{ trans('app.Jobcard Number') }} <label class="color-danger">*</label></label>						
										<div class="col-md-8 col-sm-8 col-xs-12">
											<select name="Job_card" id="jobcard" class="form-control job_number" job_url="{!! url('invoice/get_service_no') !!}" required>
									
												@if(!empty($customer_job))
													<option value="<?php echo $customer_job->job_no;?>" class="job_no" selected><?php echo $customer_job->job_no; ?></option>
												@endif
											</select>
										</div>
									</div>
									@if(!empty($customer_job))
										<input type="hidden" name="jobcard_no"  value="{{$customer_job->id}}">
										<input type="hidden" name="Invoice_type"  value="{{ 0 }}">
									@elseif(!empty($tbl_sales))
										<input type="hidden" name="jobcard_no"  value="{{$tbl_sales->id}}">
										<input type="hidden" name="Invoice_type"  value="{{ 2 }}">
									@else						
									  <input type="hidden" name="jobcard_no" class="servi_id" value="">
									@endif

									<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group" id="vehicle" style="display:none">
										<label class="control-label col-md-4 col-sm-4 col-xs-12" for="job_card">{{ trans('app.Select Part') }} <label class="color-danger">*</label></label>						
										<div class="col-md-8 col-sm-8 col-xs-12">
											<select name="Vehicle" id="" class="form-control" vehicle_amt="{!! url('invoice/get_vehicle_total') !!}" required readonly>
									
											@if(!empty($tbl_salessd))
												@foreach($tbl_salessd as $tbl_sale)
												<option value="<?php echo $tbl_sale->product_id;?>" class="vehi_id" selected><?php echo getPart($tbl_sale->product_id)->name; ?></option>
												@endforeach
											@endif
											</select>
										</div>
									</div>		  

									<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
	                        			<label class="control-label col-md-4 col-sm-4 col-xs-12 currency" for="cus_name">{{ trans('app.Total Amount') }} (<?php echo getCurrencySymbols(); ?>)<label class="color-danger">*</label></label>						
	                        			<div class="col-md-8 col-sm-8 col-xs-12 ">
											@if(!empty($tbl_sales))
												<?php    
													$total_sales= $tbl_sales->total_price;
												?>
												<input type="text" name="Total_Amount" class="form-control ttl_amount" value="@foreach($tbl_saless as $tbl_sale){{$tbl_sale->total_price}}@endforeach" readonly>
											
											@elseif(!empty($total_amount))
												<input type="text" name="Total_Amount" class="form-control ttl_amount" value="{{$total_amount}}" readonly>
											@else
												<input type="text" name="Total_Amount" class="form-control ttl_amount" value="" readonly>
											@endif
										</div>
									</div>					  
				    			</div>

								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
								  	<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
										<label class="control-label col-md-4 col-sm-4 col-xs-12" for="Date">{{ trans('app.Invoice Date')}} <label class="color-danger">*</label></label>
											
										<div class="col-md-8 col-sm-8 col-xs-12 input-group date datepicker" >
											<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
											<input type="text"  name="Date" autocomplete="off" class="form-control invoiceDate" id="date_of_birth" placeholder="<?php echo getDatepicker();?>" onkeypress="return false;" required >
										</div>
								  	</div>

								  	<div class="col-md-6 col-sm-6 col-xs-12 form-group">
			                        	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Discount (%)') }} </label>						
			                        	<div class="col-md-8 col-sm-8 col-xs-12">
											<input type="text" maxlength="3"  name="Discount" class="form-control discount" id="disc">
			                        	</div>
			                      	</div>
			                    </div>

								<div class="col-md-12 col-sm-12 col-xs-12 form-group">
									<div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        				<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Details') }}</label>						
                        				<div class="col-md-8 col-sm-8 col-xs-12">
											<textarea name="Details" class="form-control"></textarea>
                        				</div>
                      				</div>		


                      				<div class="col-md-6 col-sm-6 col-xs-12 form-group">
										<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Tax') }}	</label>						
										<div class="col-md-8 col-sm-8 col-xs-12">
											<table>
												<tbody>
												@foreach($tax as $taxes)
													<tr>
														<td>
															<input type="checkbox" id="tax" class="checkbox-inline check_tax sele_tax myCheckbox" name="Tax[]" value="<?php 
															echo $taxes->taxname.' '.$taxes->tax;?>" taxrate="{{$taxes->tax}}" style="height:20px; width:20px; margin-right:5px; position: relative; top: 6px; margin-bottom: 12px;" >
															
															<?php 
															echo $taxes->taxname.'&nbsp'.$taxes->tax; ?>%
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
												<option value="1">{{ trans('app.Half Paid') }}</option>
												<option value="2">{{ trans('app.Full Paid') }}</option>
												<option value="0">{{ trans('app.Unpaid') }}</option>
											</select>
			                        	</div>
			                      	</div>

									<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group paymentTypeMainDiv">
			                        	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Payment Type') }} <label class="color-danger">*</label></label>					
				                        <div class="col-md-8 col-sm-8 col-xs-12">
											<select name="Payment_type" class="form-control paymentType" required>
												<option value="">{{ trans('app.Select Payment Type') }}</option>
											@if(!empty($tbl_payments))
												@foreach($tbl_payments as $tbl_paymentss)
												<option value="{{$tbl_paymentss->id}}">{{ $tbl_paymentss->payment }}</option>
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
											<input type="text" name="paidamount" class="form-control paidamount" required="">
			                        	</div>
			                      	</div>
			                    
								  	<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
			                        	<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Grand Total') }} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label></label>						
			                        	<div class="col-md-8 col-sm-8 col-xs-12">
											<input type="text"  id="grandtotal" name="grandtotal" class="form-control grandtotal" readonly>
			                        	</div>
			                      	</div>
								</div>
                			</div>
					  		
					  		<input type="hidden" name="_token" value="{{csrf_token()}}">
                     
                      		<div class="form-group col-md-12 col-sm-12 col-xs-12">
                        		<div class="col-md-12 col-sm-12 col-xs-12 text-center">
                         			<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
                          			<button type="submit" class="btn btn-success submit submitButton" >{{ trans('app.Submit')}}</button>
                        		</div>
                      		</div>
                      	</form>
					</div>
				</div>
            </div>	
        </div>
   	</div>	
  

<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<!--datetimepicker -->
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
			
			$(document).ready(function(){
			// Initialize select2
			$("#selUser").select2();
			}); 
	
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
	
	<!-- For JobCard Number -->
	<script>
	$(document).ready(function(){
		$('body').on('change','.select_cus',function(){
			
			var type = $(".invoicetype option:selected").val();
			
			if(type == 0)
			{
				var url = $(this).attr('customer_url');
				var cus_name = $('.select_cus :selected').val();
				
				$.ajax({
					type:'GET',
					url:url,
					data:{ cus_name:cus_name },
					
					success:function(response)
					{
						if($.trim(response) == '')
						{
							//alert("Invoice is already created...");
							swal({   
								title: "Invoice Alert",
								text: 'Invoice is already created...'
							});

							$('.job_number').html('<option value="">Select Jobcard</option>');
							return false;
						}
						$('.job_number').html('<option value="">Select Jobcard</option>');
						$('.job_number').append(response);
						$('.ttl_amount').val('0');
						$('#grandtotal').val('0');
					},
					error:function(e)
					{
						console.log(e);
					}
				});
			}
			else
			{
				var vehi_url = $(this).attr('vehicle_url');
				var cus_name = $('.select_cus :selected').val();
				$.ajax({
					type:"GET",
					url:vehi_url,
					data:{ cus_name:cus_name },
					success:function(response)
					{
						
						if($.trim(response) == '')
						{
							//alert("Invoice is already created...");
							swal({   
								title: "Invoice Alert",
								text: 'Invoice is already created...'
							});

							$('.vehi_name').html('<option value="">Select Vehicle</option>');
							return false;
						}
						$('.vehi_name').html('<option value="">Select Vehicle</option>');
						$('.vehi_name').append(response);
						$('.ttl_amount').val('0');
						$('#grandtotal').val('0');
					},
					error:function(e)
					{
						console.log(e);
					}
				});
			}
			
		});
		
	});
	</script>
	
	<script>
	$(document).ready(function(){
		//change jobcard number
		$('body').on('change','.job_number',function(){
			
			var url = $(this).attr('job_url');
			
			var job_no = $('.job_number :selected').val();

			$.ajax({
				type:'GET',
				url:url,
				data:{ job_no:job_no },
				
				success:function(response)
				{					
					$('.ttl_amount').val(response[1]);
					$('.servi_id').val(response[0]);
					
					var total = $('.ttl_amount').val();
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
					
					
				},
				error:function(e)
				{
					console.log(e);
				}
			});
		});
		
		//change vehicle name 
		$('body').on('change','.vehi_name',function(){
			
			var vehicle_url = $(this).attr('vehicle_amt');
			var vehi_id = $('.vehi_name :selected').val();
			
			$.ajax({
				type:'GET',
				url:vehicle_url,
				data:{ vehi_id:vehi_id },
				
				success:function(response)
				{
					
					$('.ttl_amount').val(response[1]);
					$('.servi_id').val(response[0]);
					var total = $('.ttl_amount').val();
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
				},
				error:function(e)
				{
					console.log(e);
				}
			});
		});
		
		
		/*on keyup in discount*/

		$('body').on('keyup','#disc',function(){
		
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
		/*$('body').on('keyup','.paidamount',function(){

			var paidamount = $(this).val();
			var totalgrand = $('#grandtotal').val();
			if(parseInt(paidamount) <= parseInt(totalgrand))
			{
				
			}
			else{
				swal({   
					title: "Pay Amount",
					text: 'please enter an amount less than total amount'  

					});
				var paidamount = $(this).val('');		
				
				return false;					
			}			
		});*/

	});
</script>

<script>
$(document).ready(function(){
	
		//-------if redirect from jobcard list-------
		var sales_list_id = $('#sales_list_id').val();
		
		if(sales_list_id != null)
		{
			$("#form_fields").show();
			$("#vehicle").show();
			$("#job").hide();
			$("#getid").hide();
			$("#vhi").removeAttr('required',true );
			$("#jobcard").attr('required',false );
		}
		//-------if redirect from jobcard list-------
		var job_list_no = $('#jobcard_list_job').val();	
		if(job_list_no != null)
		{
			$("#form_fields").show();
			$("#vehicle").hide();
			$("#getid").hide();
			$("#job").show();
			$("#vhi").removeAttr('required', false);
			$("#jobcard").attr('required', true);
		}
		
		
		var  ttl_amount = $('.ttl_amount').val();
		var  ttl_amount1 = $('#grandtotal').val(ttl_amount);
		
		//--------------------------------------------
		$('body').on('change','.invoicetype',function(){
			
			var type = $(".invoicetype option:selected").val();
			$('#form_fields').slideDown(900);
			if(type == 0)
			{
				$("#vehicle").hide();
				$("#job").show();
				$("#vhi").removeAttr('required', false);
				$("#jobcard").attr('required', true);
			}
			else
			{
				$("#job").hide();
				$("#vehicle").show();
				$("#jobcard").removeAttr('required', false);
				$("#vhi").attr('required', true);
			}
			var sales_url = $(this).attr('sales_url');
			
			$.ajax({
				type:'GET',
				url:sales_url,
				data:{ type:type },
				success:function(response)
				{
					$('.customer_name').html("");
					$('.customer_name').html('<option value="">{{ trans('app.Select Customer')}}</option>');
					$('.customer_name').append(response);
				},
				error:function(e)
				{
					console.log(e);
				}
			});
		});
			
});
</script>


<!-- When option selected as an unpaid after paid amount textbox is disable -->
<script>
	$('body').on('change','.paymentStatusSelect',function(){

		var statusValue = $('select[name=Status]').val();
		var grandTotalValue = $('.grandtotal').val();

		if (statusValue != null) 
		{
			if (statusValue == 1) {
				$('.paidAmountMainDiv').css({"display":""});
				$('.paymentTypeMainDiv').css({"display":""});
				$('.paidamount').val(grandTotalValue / 2);
			}
			else if (statusValue == 2){				
				$('.paidAmountMainDiv').css({"display":""});
				$('.paymentTypeMainDiv').css({"display":""});
				$('.paidamount').val(grandTotalValue);
			}
			else if (statusValue == 0)			{
				$('.paidAmountMainDiv').css({"display":"none"});
				$('.paymentTypeMainDiv').css({"display":"none"});
				$('.paidamount').val("");
				$('.paymentType').val("");						
			}
		}
	});

	/* discount field accept only numbers */
	$('body').on('keyup','.discount', function(){

		var discountAmt = $(this).val();
		var rgx = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)$/g;

		if (discountAmt > 100) {
			$(this).val(0);
		}
		else if(!discountAmt.replace(/\s/g, '').length){
			$(this).val("");
		}
		else if (!rgx.test(discountAmt)){
			$(this).val("");
		}
	});


	//paid amount
	$('body').on('keyup','.paidamount',function(){

		var paidamount = $(this).val();
		var totalgrand = $('#grandtotal').val();
		var statusValue = $('select[name=Status]').val();

		var rgs = /^([0-9]+[\.]?[0-9]?[0-9]?|[0-9]+)$/g;

		if (statusValue == 1) {
			if (parseInt(paidamount) > parseInt(totalgrand)) {
				$(this).val(totalgrand/2);
				//alert("Please pay half or less than grand total amount, because you select half pay");
				swal({   
					title: "Pay Amount",
					text: 'Please pay half or less than grand total amount, because you select half pay'
				});
			}
			else if(parseInt(paidamount) == parseInt(totalgrand)){
				$(this).val(totalgrand/2);
				//alert("Please pay half or less than grand total amount, because you select half pay");
				swal({   
					title: "Pay Amount",
					text: 'Please pay half or less than grand total amount, because you select half pay'
				});
			}
			else if(parseInt(paidamount) == 0){
				$(this).val(totalgrand/2);
				swal({   
					title: "Pay Amount",
					text: 'Please pay half or less than grand total amount, because you select half pay'
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
		else if(statusValue == 2){
			if (parseInt(paidamount) > parseInt(totalgrand)) {
				$(this).val(totalgrand);
				//alert("Please pay only grand total amount, because you select full pay");
				swal({   
					title: "Pay Amount",
					text: 'Please pay only grand total amount, because you select full pay'
				});
			}
			else if(parseInt(paidamount) < parseInt(totalgrand)){
				$(this).val(totalgrand);
				//alert("Please pay only grand total amount, because you select full pay");
				swal({   
					title: "Pay Amount",
					text: 'Please pay only grand total amount, because you select full pay'
				});
			}
			else if(parseInt(paidamount) == 0){
				$(this).val(totalgrand/2);
				swal({   
					title: "Pay Amount",
					text: 'Please pay only grand total amount, because you select full pay'
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
				
	});
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

	/*$(document).ready(function(){

		$('.customer_name').on('change',function(){

			var customerValue = $('select[name=Customer]').val();
			
			if (customerValue != null) {
				$('#customer_select_box-error').css({"display":"none"});
			}

			if (customerValue != null) {
				$(this).parent().parent().removeClass('has-error');
			}
		});
	});*/
</script>

<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\InvoiceAddEditFormRequest', '#form_add'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>


<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Form submit at a time only one -->
<script type="text/javascript">
    /*$(document).ready(function () {
        $('.submitButton').removeAttr('disabled'); //re-enable on document ready
    });
    $('.salePartAddForm').submit(function () {
        $('.submitButton').attr('disabled', 'disabled'); //disable on any form submit
    });

    $('.salePartAddForm').bind('invalid-form.validate', function () {
      $('.submitButton').removeAttr('disabled'); //re-enable on form invalidation
    });*/
</script>


@endsection