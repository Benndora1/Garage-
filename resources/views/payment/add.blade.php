@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
.checkbox-success{
	background-color: #cad0cc!important;
	 color:red;
}
</style>

<!-- page content start-->
	<div class="right_col" role="main">
        <div class="">
            <div class="page-title">
               <div class="nav_menu">
					<nav>
					  <div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Payment Method')}}</span></a>
					  </div>
						  @include('dashboard.profile')
					</nav>
				</div>
				@if(session('message'))
				<div class="row massage">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="checkbox checkbox-success checkbox-circle">
							<label for="checkbox-10 colo_success"> {{ trans('app.Duplicate Data')}} </label>
						</div>
					</div>
				</div>
				@endif
            </div>
				<div class="x_content">
					<ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
						@can('paymentmethod_view')
							<li role="presentation" class=""><a href="{!! url('/payment/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.Payment Method List')}}</a></li>
						@endcan
						@can('paymentmethod_add')
							<li role="presentation" class="active setMarginForAddPaymentMethodForSmallDevices"><a href="{!! url('/payment/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg i_pay">&nbsp;</i><b>{{ trans('app.Add Payment Method')}}</b></a></li>
						@endcan
					</ul>
				</div>
				<div class="clearfix"></div>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_content">
								<form action="{{ url('/payment/store') }}" method="post"  enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left upperform addPaymentForm" id="paymet-method-add-form">
									<div class="form-group has-feedback col-md-12 col-sm-12 col-xs-12 my-form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">{{ trans('app.Payment Type')}} <label class="color-danger">*</label></label>
										<div class="col-md-5 col-sm-5 col-xs-12">
										  <input type="text"  required="required" name="payment" placeholder="{{ trans('app.Enter Payment Type')}}" class="form-control col-md-7 col-xs-12" maxlength="20">
										</div>
									</div>
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<div class="form-group col-md-12 col-sm-12 col-xs-12">
										<div class="col-md-9 col-sm-9 col-xs-12 text-center">
											<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
											<button type="submit" class="btn btn-success addPaymentSubmitButton">{{ trans('app.Submit')}}</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
        </div>
    </div> 
<!-- Page content code end -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- For form field validate -->
{!! JsValidator::formRequest('App\Http\Requests\StorePaymentMethodRequest', '#paymet-method-add-form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

<!-- Form submit at a time only one -->
<script type="text/javascript">
    /*$(document).ready(function () {
        $('.addPaymentSubmitButton').removeAttr('disabled'); //re-enable on document ready
    });
    $('.addPaymentForm').submit(function () {
        $('.addPaymentSubmitButton').attr('disabled', 'disabled'); //disable on any form submit
    });

    $('.addPaymentForm').bind('invalid-form.validate', function () {
      $('.addPaymentSubmitButton').removeAttr('disabled'); //re-enable on form invalidation
    });*/
</script>

@endsection