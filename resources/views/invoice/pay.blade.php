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
				@canany(['invoice_edit','invoice_delete'])
					<li role="presentation" class="active"><a href="{!! url('/invoice/pay/'.$tbl_invoices->id) !!}"><span class="visible-xs"></span><b>{{ trans('app.Pay Payment')}}</b></a></li>
				@endcanany
			</ul>
		</div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_content">
                    <form id="invoicePayPaymentForm" method="post"  action="update/{{$tbl_invoices->id}}" enctype="multipart/form-data"  name="Form" class="form-horizontal upperform payForm" onsubmit="return enableSample()">
						<div class="col-md-12 col-xs-12 col-sm-12">
					  		<h4><b>{{ trans('app.Payment Information')}}</b></h4><hr style="margin-top:0px;">
					  		<p class="col-md-12"></p>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						  	<div class="col-md-6 col-sm-6 col-xs-12 form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Invoice Number') }} <label class="color-danger">*</label>
								</label>						
								<div class="col-md-8 col-sm-8 col-xs-12">
									<input type="text" name="" class="form-control" value="{{ $tbl_invoices->invoice_number }}" readonly>
								</div>
						  	</div>
						  	<div class="col-md-6 col-sm-6 col-xs-12 form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Payment Number') }} <label class="color-danger">*</label> 
								</label>						
								<div class="col-md-8 col-sm-8 col-xs-12">
									<input type="text" name="paymentno" class="form-control" value="{{ $code }}" readonly>
								</div>
							</div>
						</div>
                    	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="Date">{{ trans('app.Payment Date')}} <label class="color-danger">*</label></label>
								
								<div class="col-md-8 col-sm-8 col-xs-12 input-group date datepicker" >
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
									<input type="text"  name="Date" id="date_of_birth" autocomplete="off" class="form-control invoiceDate" placeholder="<?php echo getDatepicker();?>" onkeypress="return false;" required >
								</div>
					    	</div>

							<div class="col-md-6 col-sm-6 col-xs-12 form-group color-danger">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Amount Due') }} (<?php echo getCurrencySymbols();?>) </label>						
								<div class="col-md-8 col-sm-8 col-xs-12">
									<input type="text" name="Invoice_Number" id="dueamount" class="form-control" value="{{ $dueamount }}" readonly>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">  
							<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Payment Type') }} <label class="color-danger">*</label></label>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<select name="Payment_type" class="form-control" required>
										<option value="">{{ trans('app.Select Payment Type') }}</option>
										@if(!empty($tbl_payments))
											@foreach($tbl_payments as $tbl_paymentss)
												<option value="{{$tbl_paymentss->id}}">{{ $tbl_paymentss->payment }}</option>
											@endforeach
										@endif	
									</select>
								</div>
							</div>
					  
					  		<div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
                        		<label class="control-label col-md-4 col-sm-4 col-xs-12" style="    padding: 8px;" for="cus_name">{{ trans('app.Amount Received') }} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label></label>						
                        		<div class="col-md-8 col-sm-8 col-xs-12">
									<input type="text" name="receiveamount" class="form-control paidamount" id="amountreceived"  required>
								</div>
                      		</div>
                    	</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group">  
							<div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        		<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Note') }}</label>						
                        		<div class="col-md-8 col-sm-8 col-xs-12">
									<textarea name="note" class="form-control" maxlength="100" ></textarea>
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
<!-- Datetimepicker -->
<script>
    $('.datepicker').datetimepicker({
       format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
    });
</script>
	
<!-- For checking Amount Received is Less than or Equal to Due Amount -->	
<script>
	$(document).ready(function(){
		$('body').on('keyup','#amountreceived',function(){
			
			var dueamount = $('#dueamount').val();
			var amount = $('#amountreceived').val();

			if(parseFloat(amount) <= parseFloat(dueamount))
			{
				//Nothing to do.
			}
			else
			{
				swal({   
					title: "Pay Amount",
					text: 'Please enter an amount less than Amount Due'  

					});
				var amount = $('#amountreceived').val('');
					return false;
			}
		});		
	});


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
</script>

<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\StorePayPaymentFormRequest', '#invoicePayPaymentForm'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>


<!-- Form submit at a time only one -->
<script type="text/javascript">
    /*$(document).ready(function () {
        $('.submitButton').removeAttr('disabled'); //re-enable on document ready
    });
    $('.payForm').submit(function () {
        $('.submitButton').attr('disabled', 'disabled'); //disable on any form submit
    });

    $('.payForm').bind('invalid-form.validate', function () {
      $('.submitButton').removeAttr('disabled'); //re-enable on form invalidation
    });*/
</script>	

@endsection