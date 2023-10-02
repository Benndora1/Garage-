@extends('layouts.app')
@section('content')

<style>
	.error_color{color:red; font-weight:bold;}
</style>

<!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"> </i><span class="titleup">&nbsp {{ trans('app.General Settings')}}</span></a>
						</div>
						@include('dashboard.profile')
					</nav>
				</div>
				@if(session('message'))
				<div class="row massage">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="checkbox checkbox-success checkbox-circle">
							 <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Updated')}}  </label>
						</div>
					</div>
				</div>
				@endif
            </div>
			<div class="x_content">
				<ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
					
					@can('generalsetting_view')
						<li role="presentation" class="suppo_llng_li floattab"><a href="{!! url('setting/general_setting/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-cogs">&nbsp;</i><b>{{ trans('app.General Settings')}}</b></a></li>
					@endcan
					@can('timezone_view')
						<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('setting/timezone/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-cog">&nbsp;</i>{{ trans('app.Other Settings')}}</a></li>
					@endcan

					<!-- <li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('setting/accessrights/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-universal-access">&nbsp;</i> {{ trans('app.Access Rights')}}</a></li> -->

				<!-- New Access Rights Starting -->
					@can('accessrights_view')					
						<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('setting/accessrights/show')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-universal-access">&nbsp;</i>{{ trans('app.Access Rights')}}</a></li>
					@endcan
				<!-- New Access Rights Ending -->
					
					@can('businesshours_view')
						<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('setting/hours/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-hourglass-end">&nbsp;</i>{{ trans('app.Business Hours')}}</a></li>
					@endcan

					@can('stripesetting_view')
						<li role="presentation" class="active suppo_llng_li_add floattab"><a href="{!! url('setting/stripe/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-cc-stripe">&nbsp;</i>{{ trans('app.Stripe Settings')}}</a></li>
					@endcan
					
					
				</ul>
			</div>
            <div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_content">

						@can('stripesetting_view')
							<form id="stripe_settings_edit_form" method="post" action="{{ url('setting/stripe/store') }}" enctype="multipart/form-data" class="form-horizontal upperform">
					
								<div class="col-md-12 col-sm-12 col-xs-12">
								  	<h4><b>{{ trans('app.Stripe API Key Information')}} :  {{trans('app.Update Your Live Stripe Keys Here !')}} </b></h4>
								  	<p class="col-md-12 col-sm-12 col-xs-12 ln_solid"></p>
								</div>

								<div class="form-group col-md-12 col-sm-12 col-xs-12  has-feedback my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="publish_key">{{ trans('app.Stripe Publishable key')}} <label class="color-danger">*</label>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name="publish_key" class="form-control" placeholder="{{ trans('app.Enter Stripe Publishable Key') }}" required maxlength="50" value="{{ $settings_data->publish_key }}">
										@if ($errors->has('publish_key'))
										   <span class="help-block">
											   <span class="error_color">{{ $errors->first('publish_key') }}</span>
										   </span>
										@endif
									</div>
								</div>
					
								<div class="form-group col-md-12 col-sm-12 col-xs-12  has-feedback my-form-group">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="secret_key">{{ trans('app.Stripe Secret key')}} <label class="color-danger">*</label>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name="secret_key" class="form-control" placeholder="{{ trans('app.Enter Stripe Secret Key') }}" required value="{{ $settings_data->secret_key }}">
										@if ($errors->has('secret_key'))
										   <span class="help-block">
											   <span class="error_color">{{ $errors->first('secret_key') }}</span>
										   </span>
										@endif
									</div>
								</div>

								<input type="hidden" name="stripe_id" value="{{$settings_data->stripe_id}}">	
								<input type="hidden" name="_token" value="{{ csrf_token() }}">

								@can('stripesetting_edit')
									<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">  
										<div class="col-md-9 col-sm-9 col-xs-12 text-center" >
											<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
											<input type="submit" class="btn btn-success"  value="{{ trans('app.Update')}}"/>
										</div>
									</div>
								@endcan
							</form>
						@endcan
						</div>
					</div>
				</div>
            </div>
        </div>
	</div>
<!-- page content end -->

<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>

<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\StoreStripeSettingEditFormRequest', '#stripe_settings_edit_form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

@endsection