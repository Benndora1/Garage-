@extends('layouts.app')
@section('content')
<style>
.table>tbody>tr>td { padding:5px;}
.price {
 font-size: 15px; coloe:#555 !important;}
 
	.select2-container { width: 100% !important; }
</style>

<!-- page content -->
	<div class="right_col" role="main">
		<div class="page-title">
			<div class="nav_menu">
				<nav>
				  <div class="nav toggle">
					<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Purchase')}}</span></a>
				  </div>
					  @include('dashboard.profile')
				</nav>
			</div>
		</div>
		<div class="x_content">
			<ul class="nav nav-tabs bar_tabs" role="tablist">
				@can('purchase_view')
					<li role="presentation" class=""><a href="{!! url('/purchase/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Purchase List')}}</a></li>
				@endcan

				@can('purchase_add')
					<li role="presentation" class="active"><a href="{!! url('/purchase/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Add Purchase')}}</b></a></li>
				@endcan
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<form id="purchaseAdd-Form" method="post" action="{{ url('/purchase/store') }}" enctype="multipart/form-data"  class="form-horizontal upperform purchaseAddForm">

							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Purchase No')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" id="p_no" name="p_no" value="{{$code}}" class="form-control" value="" readonly>
									</div>
								</div>

								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Purchase Date')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12 input-group date datepicker">
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										<input type="text" id="pur_date" name="p_date" autocomplete="off" class="form-control purchaseDate" placeholder="<?php echo getDatepicker();?>" onkeypress="return false;" required />
									</div>
									
									</style>
								</div>
							</div>

							<div class="form-group mobileNumberDivPurchasePage" style="margin-top: 15px;">
								<div class="my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Supplier Name')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<select class="form-control col-md-7 col-xs-12 select_supplier_auto_search" name="s_name" id="supplier_select" url="{!! url('purchase/add/getrecord')!!}" required>
										  <option value="">{{ trans('app.select supplier')}}</option>
										  @if(!empty($supplier))
											@foreach ($supplier as $suppliers)
												<option value="{{ $suppliers->id }}">{{ $suppliers->company_name }}</option>
											@endforeach
										@endif
										</select>
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Mobile No')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" id="mobile" name="mobile"  class="form-control" placeholder="{{ trans('app.Enter Mobile No')}}" readonly>
									</div>
								</div>
							</div>

							<div class="form-group" style="margin-top: 20px;">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Email')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" id="email" name="email" class="form-control" placeholder="{{ trans('app.Enter Email')}} " readonly>
									</div>
								</div>

								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Billing Address')}} <label class="color-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<textarea  id="address" name="address" class="form-control"  readonly></textarea>
									</div>
								</div>
							</div>

							<div class="col-md-12 col-xs-12 col-sm-12 form-group" style="margin-top:20px;">
								<div class="col-md-10 col-sm-8 col-xs-8 header">
									<h4><b>{{ trans('app.Purchase Details')}}</b></h4>
								</div>
								<div class="col-md-2 col-sm-4 col-xs-4">
									<button type="button" id="add_new_product" class="btn btn-default" url="{!! url('purchase/add/getproductname')!!}" style="margin:5px 0px;">{{ trans('app.Add New')}} </button>
								</div>
							</div>

							<div class="col-md-12 col-xs-12 col-sm-12 form-group">
								<table class="table table-bordered adddatatable" id="tab_taxes_detail" align="center">
									<thead>
										<tr>
											<th class="actionre">{{ trans('app.Category') }}</th>
											<th class="actionre">{{ trans('app.Manufacturer Name')}}</th>
											<th class="actionre">{{ trans('app.Product Name')}}</th>
											<th class="actionre">{{ trans('app.Quantity')}}</th>
											<th class="actionre" style="width:10%;">{{ trans('app.Price')}} (<?php echo getCurrencySymbols(); ?>)</th>
											<th class="actionre" style="width:13%;">{{ trans('app.Amount')}} (<?php echo getCurrencySymbols(); ?>)</th>
											<th class="actionre">{{ trans('app.Action')}}</th>
										</tr>
									</thead>
									<tbody>
										<tr id="row_id_1">
											<td>
												<select class="form-control select_categorytype" name="product[category_id][]" row_did="1" data-id="1" style="width:100%;" required>
													<option value="0">{{ trans('app.Vehicle')}}</option>
													<option value="1">{{ trans('app.Part')}}</option>
												</select>
											</td>
											<td class="my-form-group">
												<input type="hidden" value="1" name="product[tr_id][]"/>
												<select required class="form-control select_producttype" name="product[Manufacturer_id][]" m_url="{!! url('/purchase/producttype/name') !!}" man_sel_url="{!! url('purchase/getfirstproductdata')!!}" row_did="1" row_id="1" data-id="1" style="width:100%;" >
													<!-- <option value="">-{{ trans('app.Select item')}}-</option> -->
													@if(!empty($Select_product))
													@foreach ($Select_product as $Select_products)
													 <option value="{{ $Select_products->id }}" >{{ $Select_products->type }}</option>
													@endforeach
													@endif
												</select>
											</td>
											<td class="my-form-group">
												<select name="product[product_id][]" class="form-control  productid select_productname_1"  url="{!! url('purchase/add/getproduct')!!}" row_did="1" data-id="1" style="width:100%;" required="required">
													<!-- <option value="">{{ trans('app.--Select Product--')}}</option> -->
													  @if(!empty($product))
													  @foreach($product as $products)
													  <option value="{{ $products->id }}">{{$products->name}}</option>
													  @endforeach
													  @endif		
												</select>
											</td>
											<td>
												<input type="number" name="product[qty][]" url="{!! url('purchase/add/getqty')!!}" class="quantity form-control qty qty_1" id="qty_1" row_id="1" value="1" maxlength="8" style="width: 50%;">
												<span class="qty_1">{{$first_product->product_no}}</span>
											</td>
											<td>
												<!-- <input type="text" name="product[price][]" class="product form-control prices price_1" value="" id="price_1" style="width:100%;" readonly="true"> -->
												<input required type="text" name="product[price][]" class="product form-control prices price_1" value="{{$first_product->price}}" id="price_1" style="width:100%;" row_id="1" style="width:100%;" >
											</td>
											<td>
												<input type="text" name="product[total_price][]" class="product form-control total_price total_price_1"  value="{{$first_product->price}}" style="width:100%;" id="total_price_1" readonly="true">
											</td>
											<td align="center">
												<span class="product_delete" style="width:100%;" data-id="0"><i class="fa fa-trash fa-2x"></i> </span>
											</td>
										</tr>
									</tbody>
								</table>
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
							<div class="form-group" style="margin-top:30px;">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
								  <a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
								  <button type="submit" class="btn btn-success purchaseSubmitButton">{{ trans('app.Submit')}}</button>
								</div>
							</div>
						</form>
					</div>		
				</div>
			</div>
		</div>
	</div>

   
<script src="{{ URL::asset('build/js/jquery.min.js') }}"></script>

<script>
		 $(document).ready(function() {
		$('.adddatatable').DataTable({
			/*Solved by Arjun [Bug list row number: 670]*/
			responsive: true,
			paging: false,
			lengthChange: false,
			searching: false,
			ordering: false,
			info: false,
			autoWidth: true,
			sDom: 'lfrtip'
		
		});
	});
</script>
<script>
$(document).ready(function(){
	
	$('body').on('change','.select_producttype',function(){	
		
		var row_id = $(this).attr('row_did');
		var m_id = $(this).val();
		var url = $(this).attr('m_url');
		$.ajax({
			type:'GET',
			url: url,
			data:{ m_id:m_id },
			success:function(response){
				$('.select_productname_'+row_id).html(response);
			}
		});
	});
	
});

</script>
<script type="text/javascript">

	$("#add_new_product").click(function(){
		var row_id = $("#tab_taxes_detail > tbody > tr").length;
		var url = $(this).attr('url');
		$.ajax({
		   	type: 'GET',
		  	url: url,
		 	data : {row_id:row_id},
			 	
			 beforeSend : function () {
			 	$("#add_new_product").prop('disabled', true);
			 },
			 success: function (response)
			{
			   // $("#tab_taxes_detail > tbody").append(response.html);
				$('.adddatatable').DataTable().row.add($(response.html)).draw();
				$("#add_new_product").prop('disabled', false);
				return false;
			},
			error: function(e) {
		 		alert("An error occurred: " + e.responseText);
				console.log(e);
			}
       	});
	});



	$('body').on('click','.product_delete',function(){
		
		var row_id = $(this).attr('data-id');
		
		$('table#tab_taxes_detail tr#row_id_'+row_id).fadeOut();
		$('table#tab_taxes_detail tr#row_id_'+row_id).html('<option value="">Select product</option>');
		$('table#tab_taxes_detail tr#row_id_'+row_id).html('<input type="text" name="" class="form-control qty" value="" id="tax_1" readonly="true">');
		$('table#tab_taxes_detail tr#row_id_'+row_id).html('<input type="text" name="" class="form-control price" value="" id="tax_1" readonly="true">');
		$('table#tab_taxes_detail tr#row_id_'+row_id).html('<input type="text" name="" class="form-control total_price" value="" id="tax_1" readonly="true">');
		$('table#tab_taxes_detail tr#row_id_'+row_id).html('<span class="product_delete" data-id="0"></span>');
		return false;
	});
	
	
	$('body').on('change','.productid','.qty',function(){
		
		var row_id = $(this).attr('row_did');
		var p_id = $(this).val();
		
		var qty= $('.qty_'+row_id).val();
		var price= $('.price_'+row_id).val();
		var url = $(this).attr('url');
		
		$.ajax({
                     type: 'GET',
                     url: url,
                     data : {p_id:p_id},
                     success: function (response)
                        {	
							var json_obj = jQuery.parseJSON(response);
							var price = json_obj['price'];
							var total_price =  price * qty;
							$('.price_'+row_id).val(price);
							$('.total_price_'+row_id).val(total_price);
							var product_no = json_obj['product_no'];
							$('.qty_'+row_id).html(product_no);
						},
						
                    error: function(e) {
                 alert("An error occurred: " + e.responseText);
                    console.log(e);
                }
       });
	});
</script>

<script type="text/javascript">

 $('body').on('change','.qty',function(){
	 
			var row_id = $(this).attr('row_id');			
            var p_id = $('.select_productname_'+row_id).val();
			var priceVal = $('.price_'+row_id).val();

			if(p_id == '')
			{
				alert('first select product name');
				$('.qty_'+row_id).val('1');
			}
			else if(this.value == ""){
				$('.qty_'+row_id).val('1');
				$('.total_price_'+row_id).val(priceVal * 1);
			}
			else
			{
				if (/\D/g.test(this.value))
				{
				    $('.qty_'+row_id).val('1');
				    $('.total_price_'+row_id).val(priceVal * 1);
				}
				else
				{
					var qty= $('.qty_'+row_id).val();
					
					var price= $('.price_'+row_id).val();
					
					var url = $(this).attr('url');
					$.ajax({
								type: 'GET',
								url: url,
								data : {qty:qty,price:price},
								success: function (response)
									 {	
										total_price =  price * qty;
										$('.total_price_'+row_id).val(total_price);
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
				}
			}
        });
</script>
 
<script>
	$(function(){
			$('#supplier_select').change(function(){
				var supplier_id = $(this).val();
				var url = $(this).attr('url');
				
					$.ajax({
						type: 'GET',
						url: url,
						data : {supplier_id:supplier_id},
						success: function (response)
							 {	
								 var res_supplier = jQuery.parseJSON(response);
								
								$('#mobile').attr('value',res_supplier.mobile_no);
								$('#email').attr('value',res_supplier.email);
								$('#address').text(res_supplier.address);
							},

							beforeSend:function()
							{
								$('#mobile').attr('value','Loading..');
								$('#email').attr('value','Loading..');
								$('#address').attr('value','Loading..');
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script>
     $(".datepicker").datetimepicker({
		
		format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
	});
</script>


<!-- Using Slect2 make auto searchable dropdown for supplier select -->
<script>
	$(document).ready(function(){
   		// Initialize select2
   		$(".select_supplier_auto_search").select2();
   	});
</script>


<!-- Price field should editable and editable price should change the Total-Amount (on-time editable price ) -->
<script>
   $(document).ready(function(){
      	$('body').on('change','.prices',function(){

         	var row_id = $(this).attr('row_id');
         	var qty = $('.qty_'+row_id).val();
         	var price = $('.price_'+row_id).val();
         	var total_price =  price * qty;

         	if (price == 0 || price == null) {
            	$('.price_'+row_id).val("");
            	$('.price_'+row_id).attr('required', true);
         	}
         	else
         	{
            	$('.price_'+row_id).val(price);
            	$('.total_price_'+row_id).val(total_price);
         	}             
      	});
   	});
</script>


<!-- Select product type time chages all value of selected product -->
<script>
   $(document).ready(function(){

      	$('body').on('change','.select_producttype',function(){

      		var row_id = $(this).attr('row_id');
      		var selected_option_value = $(this,':selected').val();      		
      		var url = $(this).attr('man_sel_url');

      		$.ajax({
      			type: "GET",
      			url: url,
      			data:{productTypeId:selected_option_value},
      			success: function(response){
      				//alert(response.success +"----" + response.data +"-----"+response.product_number);
      				if (response.success == 'yes') {
      					$('.price_'+row_id).val(response.data);
      					$('.total_price_'+row_id).val(response.data);
      					$('.qty_'+row_id).val(1);
      					$('.qty_'+row_id).text(response.product_number);      					
      				}
      			}
      		});     
      	});
   	});
</script>

<!-- Key up time price field should value with 1 -->
<script>
	$('body').on('keyup','.prices',function(){
	 
		var row_id = $(this).attr('row_id');		
        var price = $('.price_'+row_id).val();
		
		if(price == '')
		{
			$('.price_'+row_id).val(1);
		}
		else
		{
			if (/\D/g.test(this.value))
			{
			    $('.price_'+row_id).val(1);
			}
		}
	});


	/*If date field have value then error msg and has error class remove*/
	$('body').on('change','.purchaseDate',function(){

		var pDateValue = $(this).val();

		if (pDateValue != null) {
			$('#pur_date-error').css({"display":"none"});
		}

		if (pDateValue != null) {
			$(this).parent().parent().removeClass('has-error');
		}
	});

	

	/*If select box have value then error msg and has error class remove*/
	$(document).ready(function(){
		$('#supplier_select').on('change',function(){

			var supplierValue = $('select[name=s_name]').val();
			
			if (supplierValue != null) {
				$('#supplier_select-error').css({"display":"none"});
			}

			if (supplierValue != null) {
				$(this).parent().parent().removeClass('has-error');
			}
		});
	});

</script>

<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\PurchaseAddEditFormRequest', '#purchaseAdd-Form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

<!-- Form submit at a time only one -->
<script type="text/javascript">
    /*$(document).ready(function () {
        $('.purchaseSubmitButton').removeAttr('disabled'); //re-enable on document ready
    });
    $('.purchaseAddForm').submit(function () {
        $('.purchaseSubmitButton').attr('disabled', 'disabled'); //disable on any form submit
    });

    $('.purchaseAddForm').bind('invalid-form.validate', function () {
      $('.purchaseSubmitButton').removeAttr('disabled'); //re-enable on form invalidation
    });*/
</script>

@endsection