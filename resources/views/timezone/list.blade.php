@extends('layouts.app')
@section('content')

<!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"> </i><span class="titleup">&nbsp {{ trans('app.Settings')}}</span></a>
						</div>
						@include('dashboard.profile')
					</nav>
				</div>
				
				
				@if(Session::has('message'))
				<div class="row massage">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="checkbox checkbox-success checkbox-circle">
						     
							<label for="checkbox-10 colo_success"> {{ trans('app.Successfully Updated')}} </label>
						</div>
					</div>
				</div>
				@endif
            </div>
			<div class="x_content">
                <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
					
	                @can('generalsetting_view')
						<li role="presentation" class="suppo_llng_li floattab"><a href="{!! url('setting/general_setting/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-cogs">&nbsp;</i>{{ trans('app.General Settings')}}</a></li>
					@endcan
					@can('timezone_view')
						<li role="presentation" class="active suppo_llng_li_add floattab"><a href="{!! url('setting/timezone/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-cog i">&nbsp;</i><b>{{ trans('app.Other Settings')}}</b></a></li>
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
						<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('setting/stripe/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-cc-stripe">&nbsp;</i>{{ trans('app.Stripe Settings')}}</a></li>
					@endcan
				</ul>
			</div>
            <div class="clearfix"></div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_content">
						<form id="other_setting_edit_form" method="post" action="{{ url('setting/currancy/store') }}" enctype="multipart/form-data"  class="form-horizontal upperform">
							
							@can('timezone_view')
								<div class="col-md-12 col-sm-12 col-xs-12 space">
									<h4><b>{{ trans('app.Timezone') }}</b></h4>
									<p class="col-md-12 col-sm-12 col-xs-12 ln_solid"></p>
								</div>
								
								<div class="col-md-12 col-sm-12 col-xs-12 "> 
									<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback my-form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Country">{{ trans('app.Select Timezone')}} <label class="color-danger">*</label>
										</label>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" name="timezone" required>
											 
												<option value="">Please, select timezone</option>
												 @if(!empty($currancy))
													 @foreach($currancy as $currancys)
														<option value="{{$currancys->timezone}}" <?php if($user->timezone == $currancys->timezone){echo"selected";} ?>>{{$currancys->timezone}}</option>
													@endforeach
												@endif
													
											</select>
										</div>
									</div>
								</div>
							@endcan

							@can('language_view')
								<div class="col-md-12 col-sm-12 col-xs-12 space">
									<h4><b>{{ trans('app.Language')}}</b></h4>
									<p class="col-md-12 col-sm-12 col-xs-12 ln_solid"></p>
								</div>
								
								<div class="col-md-12 col-xs-12 col-sm-12"> 
									<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback my-form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Country">{{ trans('app.Select Language')}} <label class="color-danger">*</label></label>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" name="language">
												<option value="en" <?php if($user->language =='en') { echo 'selected'; }?>>English</option>
												<option value="de" <?php if($user->language =='de') { echo 'selected'; }?>>Spanish</option>
												<option value="gr" <?php if($user->language =='gr') { echo 'selected'; }?>>Greek</option>
												<option value="ar" <?php if($user->language =='ar') { echo 'selected'; }?>>Arabic</option>
												<option value="ger" <?php if($user->language =='ger') { echo 'selected'; }?>>German</option>
												<option value="pt" <?php if($user->language =='pt') { echo 'selected'; }?>>Portuguese</option>
												<option value="fr" <?php if($user->language =='fr') { echo 'selected'; }?>>french</option>
												<option value="it" <?php if($user->language =='it') { echo 'selected'; }?>>Italian</option>
												<option value="sv" <?php if($user->language =='sv') { echo 'selected'; }?>>Swedish</option>
												<option value="dt" <?php if($user->language =='dt') { echo 'selected'; }?>>Dutch</option>
												<option value="hi" <?php if($user->language =='hi') { echo 'selected'; }?>>Hindi</option>
												<option value="zhcn" <?php if($user->language =='zhcn') { echo 'selected'; }?>>Chinese (Simplified)</option>
												<option value="id" <?php if($user->language =='id') { echo 'selected'; }?>>Indonesian</option>
											</select>
										</div>
									</div>
								</div>
							@endcan

					<!-- Date and Currency Start -->
							@can('dateformat_view')
								<div class="col-md-12 col-sm-12 col-xs-12 space">
										<h4><b>{{ trans('app.Date Format') }}</b></h4>
										<p class="col-md-12 col-sm-12 col-xs-12 ln_solid"></p>
								</div>	
								
								<div class="col-md-12 col-xs-12 col-sm-12">   
									<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback my-form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('app.Select Date Format')}}  <label class="color-danger">*</label>
										</label>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" name="dateformat" required>
												<option value="">{{ trans('app.Select Date Format')}}</option>
												<option value="Y-m-d" <?php if($tbl_settings->date_format =='Y-m-d'){echo"selected";}?>><?php echo 'yyyy-mm-dd'; ?></option>
												<option value="m-d-Y" <?php if($tbl_settings->date_format =='m-d-Y'){echo"selected";}?>><?php echo 'mm-dd-yyyy'; ?></option>
												<option value="d-m-Y" <?php if($tbl_settings->date_format =='d-m-Y'){echo"selected";}?>><?php echo 'dd-mm-yyyy'; ?></option>
												<!-- <option value="M-d-Y" <?php if($tbl_settings->date_format =='M-d-Y'){echo"selected";}?>><?php echo 'MM-dd-yyyy'; ?></option> -->
											</select>
										</div>
									</div>
								</div>
							@endcan

							@can('currency_view')
								<div class="col-md-12 col-sm-12 col-xs-12 space">
									<h4><b>{{ trans('app.Currency') }}</b></h4>
									<p class="col-md-12 col-sm-12 col-xs-12 ln_solid"></p>
								</div>	
								
								<div class="col-md-12 col-xs-12 col-sm-12">   
									<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback my-form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('app.Select Currency')}}  <label class="color-danger">*</label>
										</label>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" name="Currency" required>
												<option value="">{{ trans('app.Select Currency')}}</option>
											@if(!empty($currencies))
												@foreach($currencies as $currancyss)
													<option value="{{$currancyss->id}}" <?php if($currancyss->id == $tbl_settings->currancy){echo"selected";}?>>{{$currancyss->country}} - {{$currancyss->currency}} - {{$currancyss->code}} - {{$currancyss->symbol}}</option>
												@endforeach
											@endif
											</select>
										</div>
									</div>
								</div>
							@endcan
					<!-- Date and Currency End -->	
							<input type="hidden" name="_token" value="{{csrf_token()}}">

							@canany(['timezone_edit','language_edit','dateformat_edit','currency_edit'])
								<div class="col-md-12 col-xs-12 col-sm-12 form-group space">   
									<div class="col-md-9 col-sm-9 col-xs-12 text-center">
										<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
										<button type="submit" class="btn btn-success btn_success_margin">{{ trans('app.Update')}}</button>
									</div>
								</div>
							@endcanany
						</form>	
						</div>
						
					</div>
				</div>
            </div>
        </div>
	</div>
<!-- page content end -->

<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>


<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\StoreOtherSettingEditFormRequest', '#other_setting_edit_form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>


@endsection