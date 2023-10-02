@extends('layouts.app')
@section('content')
<style type="text/css">
	.table>tbody>tr>td { padding: 10px; }
	.submitButtonDiv { padding-left: 0px; }
</style>

<!-- page content -->
	<div class="right_col" role="main">
        <div class="">
            <div class="page-title">
				<div class="nav_menu">
					<nav>
					  	<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"> </i>
							<span class="titleup">&nbsp; {{ trans('app.Access Rights')}}</span>
							<!-- <span class="titleup">&nbsp {{ __('Access Rights') }}</span> -->
							</a>
					  	</div>
						@include('dashboard.profile')
					</nav>
				</div>
				@if(session('message'))
					<div class="row massage">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="checkbox checkbox-success checkbox-circle">
							  	<label for="checkbox-10 colo_success">  {{session('message')}} </label>
							</div>
						</div>
					</div>
				@endif
            </div>
			<div class="x_content">
                <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
					@can('generalsetting_view')
						<li role="presentation" class="suppo_llng_li floattab"><a href="{!! url('setting/general_setting/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-cogs">&nbsp;</i>{{ trans('app.General Settings') }}</a></li>
					@endcan

					@can('timezone_view')	
						<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('setting/timezone/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-cog">&nbsp;</i>{{ trans('app.Other Settings')}}</a></li>
					@endcan

					<!-- <li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('setting/accessrights/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-universal-access">&nbsp;</i>{{ trans('app.Access Rights')}}</a></li> -->
					
				<!-- New Access Rights Starting -->		
					@can('accessrights_view')			
						<li role="presentation" class="active suppo_llng_li_add floattab"><a href="{!! url('setting/accessrights/show')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-universal-access">&nbsp;</i><b> {{ trans('app.Access Rights')}}</b></a></li>
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
            <div class="row" >
				<div class="col-md-12 col-sm-12 col-xs-12" >
					<div class="x_panel">
				<!-- SUPER ADMIN Accordion Starting (New)-->
					@php
						$i = 0;
					@endphp
					@foreach ($get_rights as $q=>$get_right)
						@php
						$regex = json_decode($get_right->permissions);
						@endphp
						<div class=" col-md-12 col-xs-12 col-sm-12 panel-group">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title" style="padding: 10px;">
										<a data-toggle="collapse" href="#collapse{{$get_right->id}}" class="makePlusMinus{{$get_right->id}}" style="color:#5A738E">
											<i class="glyphicon glyphicon-plus"></i>  
											@if($get_right->role_name == "Customer")
												{{ trans('app.Customer') }}
											@elseif($get_right->role_name == "Employee")
												{{ trans('app.Employees') }}
											@elseif($get_right->role_name == "Support Staff")
												{{ trans('app.Support Staffs') }}
											@elseif($get_right->role_name == "Accountant")
												{{ trans('app.Accountants') }}
											@endif
										</a>
									</h4>
								</div>
								<div id="collapse{{$get_right->id}}" class="panel-collapse collapse">
									<!-- <div class="panel-body">
										<table class="table"> -->
											<!-- Observation Checcked Points -->
									<!-- </table>
									</div> -->
								<form name="" id="" method="post" action="{{ url('setting/accessrights/access_store',$get_right->id)}}" enctype="multipart/form-data">
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<table id="datatable" class="table table-striped table-bordered jambo_table">
										<thead>
											<tr>
												<th>{{ trans('app.Module Name')}}</th>
												<th>{{ trans('app.View')}}</th>
												<th>{{ trans('app.Add')}}</th>
												<th>{{ trans('app.Update')}}</th>
												<th>{{ trans('app.Delete')}}</th>
												<th>{{ trans('app.Own Data')}}</th>
											</tr>
										</thead>
										<tbody>
										
										<!-- Vehicle Access Rights Start -->
											<tr>
												<td>{{ trans('app.Vehicle')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="vehicle" name="vehicle[]" value="vehicle_view"
													@if(!empty($regex->vehicle_view))
													@if($regex->vehicle_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="vehicle_{{$i}}" name="vehicle[]" value="vehicle_add"
													@if(!empty($regex->vehicle_add))
													@if($regex->vehicle_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="vehicle_{{$i}}" name="vehicle[]" value="vehicle_edit"
													@if(!empty($regex->vehicle_edit))
													@if($regex->vehicle_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="vehicle_{{$i}}" name="vehicle[]" value="vehicle_delete"
													@if(!empty($regex->vehicle_delete))
													@if($regex->vehicle_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
											</tr>
										<!-- Vehicle Access Rights End -->

										<!-- Suppliers Access Rights Start -->
											<tr>
												<td>{{ trans('app.Supplier')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="supplier" name="supplier[]" value="supplier_view"
													@if(!empty($regex->supplier_view))
													@if($regex->supplier_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="supplier_{{$i}}" name="supplier[]" value="supplier_add"
													@if(!empty($regex->supplier_add))
													@if($regex->supplier_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="supplier_{{$i}}" name="supplier[]" value="supplier_edit"
													@if(!empty($regex->supplier_edit))
													@if($regex->supplier_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="supplier_{{$i}}" name="supplier[]" value="supplier_delete"
													@if(!empty($regex->supplier_delete))
													@if($regex->supplier_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- <input type="checkbox" class="supplier_{{$i}}" name="supplier[]" value="supplier_owndata"
													@if(!empty($regex->supplier_owndata))
													@if($regex->supplier_owndata == TRUE) {{'checked'}} @endif
													@endif
													> -->
												</td>
											</tr>
										<!-- Suppliers Access Rights End -->
										
										<!-- Product Access Rights Start -->
											<tr>
												<td>{{ trans('app.Product')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="product" name="product[]" value="product_view"
													@if(!empty($regex->product_view))
													@if($regex->product_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="product_{{$i}}" name="product[]" value="product_add"
													@if(!empty($regex->product_add))
													@if($regex->product_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="product_{{$i}}" name="product[]" value="product_edit"
													@if(!empty($regex->product_edit))
													@if($regex->product_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="product_{{$i}}" name="product[]" value="product_delete"
													@if(!empty($regex->product_delete))
													@if($regex->product_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- <input type="checkbox" class="product_{{$i}}" name="product[]" value="product_owndata"
													@if(!empty($regex->product_owndata))
													@if($regex->product_owndata == TRUE) {{'checked'}} @endif
													@endif
													> -->
												</td>
											</tr>
										<!-- Product Access Rights End -->

										<!-- Purchase Access Rights Start -->
											<tr>
												<td>{{ trans('app.Purchase')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="purchase" name="purchase[]" value="purchase_view"
													@if(!empty($regex->purchase_view))
													@if($regex->purchase_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="purchase_{{$i}}" name="purchase[]" value="purchase_add"
													@if(!empty($regex->purchase_add))
													@if($regex->purchase_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="purchase_{{$i}}" name="purchase[]" value="purchase_edit"
													@if(!empty($regex->purchase_edit))
													@if($regex->purchase_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="purchase_{{$i}}" name="purchase[]" value="purchase_delete"
													@if(!empty($regex->purchase_delete))
													@if($regex->purchase_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- <input type="checkbox" class="purchase_{{$i}}" name="purchase[]" value="purchase_owndata"
													@if(!empty($regex->purchase_owndata))
													@if($regex->purchase_owndata == TRUE) {{'checked'}} @endif
													@endif
													> -->
												</td>
											</tr>
										<!-- Purchase Access Rights End -->

										<!-- Stock Access Rights Start -->
											<tr>
												<td>{{ trans('app.Stock')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="stock" name="stock[]" value="stock_view"
													@if(!empty($regex->stock_view))
													@if($regex->stock_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="stock_{{$i}}" name="stock[]" value="stock_add"
													@if(!empty($regex->stock_add))
													@if($regex->stock_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- <input type="checkbox" class="stock_{{$i}}" name="stock[]" value="stock_edit"
													@if(!empty($regex->stock_edit))
													@if($regex->stock_edit == TRUE) {{'checked'}} @endif
													@endif
													> -->
												</td>
												<td>
													<!-- <input type="checkbox" class="stock_{{$i}}" name="stock[]" value="stock_delete"
													@if(!empty($regex->stock_delete))
													@if($regex->stock_delete == TRUE) {{'checked'}} @endif
													@endif
													> -->
												</td>
												<td>
													<!-- <input type="checkbox" class="stock_{{$i}}" name="stock[]" value="stock_owndata"
													@if(!empty($regex->stock_owndata))
													@if($regex->stock_owndata == TRUE) {{'checked'}} @endif
													@endif
													> -->
												</td>
											</tr>
										<!-- Stock Access Rights End -->

										<!-- Dashboard Access Rights Start -->
											<tr>
												<td>{{ trans('app.Dashboard')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="dashboard" name="dashboard[]" value="dashboard_view"
													@if(!empty($regex->dashboard_view))
													@if($regex->dashboard_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- <input type="checkbox" class="dashboard_{{$i}}" name="dashboard[]" value="dashboard_add"
													@if(!empty($regex->dashboard_add))
													@if($regex->dashboard_add == TRUE) {{'checked'}} @endif
													@endif
													> -->
												</td>
												<td>
													<!-- <input type="checkbox" class="dashboard_{{$i}}" name="dashboard[]" value="dashboard_edit"
													@if(!empty($regex->dashboard_edit))
													@if($regex->dashboard_edit == TRUE) {{'checked'}} @endif
													@endif
													> -->
												</td>
												<td>
													<!-- <input type="checkbox" class="dashboard_{{$i}}" name="dashboard[]" value="dashboard_delete"
													@if(!empty($regex->dashboard_delete))
													@if($regex->dashboard_delete == TRUE) {{'checked'}} @endif
													@endif
													> -->
												</td>
												<td>
													<input type="checkbox" class="dashboard_{{$i}}" name="dashboard[]" value="dashboard_owndata"
													@if(!empty($regex->dashboard_owndata))
													@if($regex->dashboard_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
											</tr>
										<!-- Dashboard Access Rights End -->

										<!-- Customer Access Rights Start -->
											<tr>
												<td>{{ trans('app.Customer')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="customer" name="customer[]" value="customer_view"
													@if(!empty($regex->customer_view))
													@if($regex->customer_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="customer_{{$i}}" name="customer[]" value="customer_add"
													@if(!empty($regex->customer_add))
													@if($regex->customer_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="customer_{{$i}}" name="customer[]" value="customer_edit"
													@if(!empty($regex->customer_edit))
													@if($regex->customer_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="customer_{{$i}}" name="customer[]" value="customer_delete"
													@if(!empty($regex->customer_delete))
													@if($regex->customer_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													@if($get_right->role_name == "Customer")
													<input type="checkbox" class="customer_{{$i}}" name="customer[]" value="customer_owndata"
													@if(!empty($regex->customer_owndata))
													@if($regex->customer_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif
												</td>
											</tr>
										<!-- Customer Access Rights End -->

										<!-- Employee Access Rights Start -->
											<tr>
												<td>{{ trans('app.Employee')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="employee" name="employee[]" value="employee_view"
													@if(!empty($regex->employee_view))
													@if($regex->employee_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="employee_{{$i}}" name="employee[]" value="employee_add"
													@if(!empty($regex->employee_add))
													@if($regex->employee_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="employee_{{$i}}" name="employee[]" value="employee_edit"
													@if(!empty($regex->employee_edit))
													@if($regex->employee_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="employee_{{$i}}" name="employee[]" value="employee_delete"
													@if(!empty($regex->employee_delete))
													@if($regex->employee_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													@if($get_right->role_name == "Employee")
													<input type="checkbox" class="employee_{{$i}}" name="employee[]" value="employee_owndata"
													@if(!empty($regex->employee_owndata))
													@if($regex->employee_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif
												</td>
											</tr>
										<!-- Employee Access Rights End -->

										<!-- Support Staff Access Rights Start -->
											<tr>
												<td>{{ trans('app.Support Staff')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="supportstaff" name="supportstaff[]" value="supportstaff_view"
													@if(!empty($regex->supportstaff_view))
													@if($regex->supportstaff_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="supportstaff_{{$i}}" name="supportstaff[]" value="supportstaff_add"
													@if(!empty($regex->supportstaff_add))
													@if($regex->supportstaff_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="supportstaff_{{$i}}" name="supportstaff[]" value="supportstaff_edit"
													@if(!empty($regex->supportstaff_edit))
													@if($regex->supportstaff_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="supportstaff_{{$i}}" name="supportstaff[]" value="supportstaff_delete"
													@if(!empty($regex->supportstaff_delete))
													@if($regex->supportstaff_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													@if($get_right->role_name == "Support Staff")
													<input type="checkbox" class="supportstaff_{{$i}}" name="supportstaff[]" value="supportstaff_owndata"
													@if(!empty($regex->supportstaff_owndata))
													@if($regex->supportstaff_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif
												</td>
											</tr>
										<!-- Support Staff Access Rights End -->
										
										<!-- Accountant Access Rights Start -->
											<tr>
												<td>{{ trans('app.Accountant')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="accountant" name="accountant[]" value="accountant_view"
													@if(!empty($regex->accountant_view))
													@if($regex->accountant_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="accountant_{{$i}}" name="accountant[]" value="accountant_add"
													@if(!empty($regex->accountant_add))
													@if($regex->accountant_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="accountant_{{$i}}" name="accountant[]" value="accountant_edit"
													@if(!empty($regex->accountant_edit))
													@if($regex->accountant_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="accountant_{{$i}}" name="accountant[]" value="accountant_delete"
													@if(!empty($regex->accountant_delete))
													@if($regex->accountant_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													@if($get_right->role_name == "Accountant")
													<input type="checkbox" class="accountant_{{$i}}" name="accountant[]" value="accountant_owndata"
													@if(!empty($regex->accountant_owndata))
													@if($regex->accountant_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif
												</td>
											</tr>
										<!-- Accountant Access Rights End -->

										<!-- Vehicle Type Access Rights Start -->
											<tr>
												<td>{{ trans('app.Vehicle Type')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="vehicletype" name="vehicletype[]" value="vehicletype_view"
													@if(!empty($regex->vehicletype_view))
													@if($regex->vehicletype_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="vehicletype_{{$i}}" name="vehicletype[]" value="vehicletype_add"
													@if(!empty($regex->vehicletype_add))
													@if($regex->vehicletype_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="vehicletype_{{$i}}" name="vehicletype[]" value="vehicletype_edit"
													@if(!empty($regex->vehicletype_edit))
													@if($regex->vehicletype_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="vehicletype_{{$i}}" name="vehicletype[]" value="vehicletype_delete"
													@if(!empty($regex->vehicletype_delete))
													@if($regex->vehicletype_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- @if($get_right->role_name == "Accountant")
													<input type="checkbox" class="vehicletype_{{$i}}" name="vehicletype[]" value="vehicletype_owndata"
													@if(!empty($regex->vehicletype_owndata))
													@if($regex->vehicletype_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif -->
												</td>
											</tr>
										<!-- Vehicle Type Access Rights End -->

										<!-- Vehicle Brand Access Rights Start -->
											<tr>
												<td>{{ trans('app.Vehicle Brand')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="vehiclebrand" name="vehiclebrand[]" value="vehiclebrand_view"
													@if(!empty($regex->vehiclebrand_view))
													@if($regex->vehiclebrand_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="vehiclebrand_{{$i}}" name="vehiclebrand[]" value="vehiclebrand_add"
													@if(!empty($regex->vehiclebrand_add))
													@if($regex->vehiclebrand_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="vehiclebrand_{{$i}}" name="vehiclebrand[]" value="vehiclebrand_edit"
													@if(!empty($regex->vehiclebrand_edit))
													@if($regex->vehiclebrand_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="vehiclebrand_{{$i}}" name="vehiclebrand[]" value="vehiclebrand_delete"
													@if(!empty($regex->vehiclebrand_delete))
													@if($regex->vehiclebrand_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- @if($get_right->role_name == "")
													<input type="checkbox" class="vehiclebrand_{{$i}}" name="vehiclebrand[]" value="vehiclebrand_owndata"
													@if(!empty($regex->vehiclebrand_owndata))
													@if($regex->vehiclebrand_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif -->
												</td>
											</tr>
										<!-- Vehicle Type Access Rights End -->

										<!-- Color Access Rights Start -->
											<tr>
												<td>{{ trans('app.Colors')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="colors" name="colors[]" value="colors_view"
													@if(!empty($regex->colors_view))
													@if($regex->colors_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="colors_{{$i}}" name="colors[]" value="colors_add"
													@if(!empty($regex->colors_add))
													@if($regex->colors_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="colors_{{$i}}" name="colors[]" value="colors_edit"
													@if(!empty($regex->colors_edit))
													@if($regex->colors_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="colors_{{$i}}" name="colors[]" value="colors_delete"
													@if(!empty($regex->colors_delete))
													@if($regex->colors_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- @if($get_right->role_name == "")
													<input type="checkbox" class="colors_{{$i}}" name="colors[]" value="colors_owndata"
													@if(!empty($regex->colors_owndata))
													@if($regex->colors_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif -->
												</td>
											</tr>
										<!-- Colors Access Rights End -->
										
										<!-- Service Access Rights Start -->
											<tr>
												<td>{{ trans('app.Service')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="service" name="service[]" value="service_view"
													@if(!empty($regex->service_view))
													@if($regex->service_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="service_{{$i}}" name="service[]" value="service_add"
													@if(!empty($regex->service_add))
													@if($regex->service_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="service_{{$i}}" name="service[]" value="service_edit"
													@if(!empty($regex->service_edit))
													@if($regex->service_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="service_{{$i}}" name="service[]" value="service_delete"
													@if(!empty($regex->service_delete))
													@if($regex->service_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- @if($get_right->role_name == "")
													<input type="checkbox" class="service_{{$i}}" name="service[]" value="service_owndata"
													@if(!empty($regex->service_owndata))
													@if($regex->service_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif -->
												</td>
											</tr>
										<!-- Service Access Rights End -->
										
										<!-- Invoice Access Rights Start -->
											<tr>
												<td>{{ trans('app.Invoice')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="invoice" name="invoice[]" value="invoice_view"
													@if(!empty($regex->invoice_view))
													@if($regex->invoice_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="invoice_{{$i}}" name="invoice[]" value="invoice_add"
													@if(!empty($regex->invoice_add))
													@if($regex->invoice_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="invoice_{{$i}}" name="invoice[]" value="invoice_edit"
													@if(!empty($regex->invoice_edit))
													@if($regex->invoice_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="invoice_{{$i}}" name="invoice[]" value="invoice_delete"
													@if(!empty($regex->invoice_delete))
													@if($regex->invoice_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- @if($get_right->role_name == "")
													<input type="checkbox" class="invoice_{{$i}}" name="invoice[]" value="invoice_owndata"
													@if(!empty($regex->invoice_owndata))
													@if($regex->invoice_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif -->
												</td>
											</tr>
										<!-- Invoice Access Rights End -->

										<!-- Jobcard Access Rights Start -->
											<tr>
												<td>{{ trans('app.JobCard')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="jobcard" name="jobcard[]" value="jobcard_view"
													@if(!empty($regex->jobcard_view))
													@if($regex->jobcard_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="jobcard_{{$i}}" name="jobcard[]" value="jobcard_add"
													@if(!empty($regex->jobcard_add))
													@if($regex->jobcard_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="jobcard_{{$i}}" name="jobcard[]" value="jobcard_edit"
													@if(!empty($regex->jobcard_edit))
													@if($regex->jobcard_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- <input type="checkbox" class="jobcard_{{$i}}" name="jobcard[]" value="jobcard_delete"
													@if(!empty($regex->jobcard_delete))
													@if($regex->jobcard_delete == TRUE) {{'checked'}} @endif
													@endif
													> -->
												</td>
												<td>
													<!-- @if($get_right->role_name == "")
													<input type="checkbox" class="jobcard_{{$i}}" name="jobcard[]" value="jobcard_owndata"
													@if(!empty($regex->jobcard_owndata))
													@if($regex->jobcard_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif -->
												</td>
											</tr>
										<!-- Jobcard Access Rights End -->
										
										<!-- Gatepass Access Rights Start -->
											<tr>
												<td>{{ trans('app.Gatepass')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="gatepass" name="gatepass[]" value="gatepass_view"
													@if(!empty($regex->gatepass_view))
													@if($regex->gatepass_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="gatepass_{{$i}}" name="gatepass[]" value="gatepass_add"
													@if(!empty($regex->gatepass_add))
													@if($regex->gatepass_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="gatepass_{{$i}}" name="gatepass[]" value="gatepass_edit"
													@if(!empty($regex->gatepass_edit))
													@if($regex->gatepass_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="gatepass_{{$i}}" name="gatepass[]" value="gatepass_delete"
													@if(!empty($regex->gatepass_delete))
													@if($regex->gatepass_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- @if($get_right->role_name == "")
													<input type="checkbox" class="gatepass_{{$i}}" name="gatepass[]" value="gatepass_owndata"
													@if(!empty($regex->gatepass_owndata))
													@if($regex->gatepass_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif -->
												</td>
											</tr>
										<!-- Gatepass Access Rights End -->

										<!-- Taxrate Access Rights Start -->
											<tr>
												<td>{{ trans('app.Tax Rates')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="taxrate" name="taxrate[]" value="taxrate_view"
													@if(!empty($regex->taxrate_view))
													@if($regex->taxrate_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="taxrate_{{$i}}" name="taxrate[]" value="taxrate_add"
													@if(!empty($regex->taxrate_add))
													@if($regex->taxrate_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="taxrate_{{$i}}" name="taxrate[]" value="taxrate_edit"
													@if(!empty($regex->taxrate_edit))
													@if($regex->taxrate_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="taxrate_{{$i}}" name="taxrate[]" value="taxrate_delete"
													@if(!empty($regex->taxrate_delete))
													@if($regex->taxrate_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- @if($get_right->role_name == "")
													<input type="checkbox" class="taxrate_{{$i}}" name="taxrate[]" value="taxrate_owndata"
													@if(!empty($regex->taxrate_owndata))
													@if($regex->taxrate_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif -->
												</td>
											</tr>
										<!-- Taxrate Access Rights End -->
										
										<!-- Payment Method Access Rights Start -->
											<tr>
												<td>{{ trans('app.Payment Method')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="paymentmethod" name="paymentmethod[]" value="paymentmethod_view"
													@if(!empty($regex->paymentmethod_view))
													@if($regex->paymentmethod_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="paymentmethod_{{$i}}" name="paymentmethod[]" value="paymentmethod_add"
													@if(!empty($regex->paymentmethod_add))
													@if($regex->paymentmethod_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="paymentmethod_{{$i}}" name="paymentmethod[]" value="paymentmethod_edit"
													@if(!empty($regex->paymentmethod_edit))
													@if($regex->paymentmethod_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="paymentmethod_{{$i}}" name="paymentmethod[]" value="paymentmethod_delete"
													@if(!empty($regex->paymentmethod_delete))
													@if($regex->paymentmethod_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- @if($get_right->role_name == "")
													<input type="checkbox" class="paymentmethod_{{$i}}" name="paymentmethod[]" value="paymentmethod_owndata"
													@if(!empty($regex->paymentmethod_owndata))
													@if($regex->paymentmethod_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif -->
												</td>
											</tr>
										<!-- Payment Method Access Rights End -->
										
										<!-- Income Access Rights Start -->
											<tr>
												<td>{{ trans('app.Income')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="income" name="income[]" value="income_view"
													@if(!empty($regex->income_view))
													@if($regex->income_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="income_{{$i}}" name="income[]" value="income_add"
													@if(!empty($regex->income_add))
													@if($regex->income_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="income_{{$i}}" name="income[]" value="income_edit"
													@if(!empty($regex->income_edit))
													@if($regex->income_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="income_{{$i}}" name="income[]" value="income_delete"
													@if(!empty($regex->income_delete))
													@if($regex->income_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
											</tr>
										<!-- Income Access Rights End -->

										<!-- Expense Access Rights Start -->
											<tr>
												<td>{{ trans('app.Expense')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="expense" name="expense[]" value="expense_view"
													@if(!empty($regex->expense_view))
													@if($regex->expense_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="expense_{{$i}}" name="expense[]" value="expense_add"
													@if(!empty($regex->expense_add))
													@if($regex->expense_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="expense_{{$i}}" name="expense[]" value="expense_edit"
													@if(!empty($regex->expense_edit))
													@if($regex->expense_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="expense_{{$i}}" name="expense[]" value="expense_delete"
													@if(!empty($regex->expense_delete))
													@if($regex->expense_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- @if($get_right->role_name == "")
													<input type="checkbox" class="expense_{{$i}}" name="expense[]" value="expense_owndata"
													@if(!empty($regex->expense_owndata))
													@if($regex->expense_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif -->
												</td>
											</tr>
										<!-- Expense Access Rights End -->
										
										<!-- Sales Access Rights Start -->
											<tr>
												<td>{{ trans('app.Sales')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="sales" name="sales[]" value="sales_view"
													@if(!empty($regex->sales_view))
													@if($regex->sales_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="sales_{{$i}}" name="sales[]" value="sales_add"
													@if(!empty($regex->sales_add))
													@if($regex->sales_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="sales_{{$i}}" name="sales[]" value="sales_edit"
													@if(!empty($regex->sales_edit))
													@if($regex->sales_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="sales_{{$i}}" name="sales[]" value="sales_delete"
													@if(!empty($regex->sales_delete))
													@if($regex->sales_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- @if($get_right->role_name == "")
													<input type="checkbox" class="sales_{{$i}}" name="sales[]" value="sales_owndata"
													@if(!empty($regex->sales_owndata))
													@if($regex->sales_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif -->
												</td>
											</tr>
										<!-- Sales Access Rights End -->
										
										<!-- Sales Part Module Access Rights Start -->
											<tr>
												<td>{{ trans('app.Sale Part')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="salespart" name="salespart[]" value="salespart_view"
													@if(!empty($regex->salespart_view))
													@if($regex->salespart_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="salespart_{{$i}}" name="salespart[]" value="salespart_add"
													@if(!empty($regex->salespart_add))
													@if($regex->salespart_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="salespart_{{$i}}" name="salespart[]" value="salespart_edit"
													@if(!empty($regex->salespart_edit))
													@if($regex->salespart_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="salespart_{{$i}}" name="salespart[]" value="salespart_delete"
													@if(!empty($regex->salespart_delete))
													@if($regex->salespart_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- @if($get_right->role_name == "")
													<input type="checkbox" class="sales_{{$i}}" name="sales[]" value="sales_owndata"
													@if(!empty($regex->sales_owndata))
													@if($regex->sales_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif -->
												</td>
											</tr>
										<!-- Sales Part Module Access Rights End -->
										
										<!-- Compliances (RTO) Module Access Rights Start -->
											<tr>
												<td>{{ trans('app.RTO')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="rto" name="rto[]" value="rto_view"
													@if(!empty($regex->rto_view))
													@if($regex->rto_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="rto_{{$i}}" name="rto[]" value="rto_add"
													@if(!empty($regex->rto_add))
													@if($regex->rto_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="rto_{{$i}}" name="rto[]" value="rto_edit"
													@if(!empty($regex->rto_edit))
													@if($regex->rto_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="rto_{{$i}}" name="rto[]" value="rto_delete"
													@if(!empty($regex->rto_delete))
													@if($regex->rto_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- @if($get_right->role_name == "")
													<input type="checkbox" class="sales_{{$i}}" name="sales[]" value="sales_owndata"
													@if(!empty($regex->sales_owndata))
													@if($regex->sales_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif -->
												</td>
											</tr>
										<!-- Compliances(RTO) Module Access Rights End -->
										
										<!-- Reports Module Access Rights Start -->
											<tr>
												<td>{{ trans('app.Report')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="report" name="report[]" value="report_view"
													@if(!empty($regex->report_view))
													@if($regex->report_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
												<td>
													
												</td>
												<td>
													
												</td>

												<td>
												</td>
											</tr>
										<!-- Compliances(RTO) Module Access Rights End -->
										
										<!-- Email Templates Module Access Rights Start -->
											<tr>
												<td>{{ trans('app.Email Templates')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="emailtemplate" name="emailtemplate[]" value="emailtemplate_view"
													@if(!empty($regex->emailtemplate_view))
													@if($regex->emailtemplate_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
												<td>
													<input type="checkbox" class="emailtemplate_{{$i}}" name="emailtemplate[]" value="emailtemplate_edit"
													@if(!empty($regex->emailtemplate_edit))
													@if($regex->emailtemplate_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
												<td>
													
												</td>
											</tr>
										<!-- Email Templates Module Access Rights End -->
										
										<!-- Custom Field Module Access Rights Start -->
											<tr>
												<td>{{ trans('app.Custom Field')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="customfield" name="customfield[]" value="customfield_view"
													@if(!empty($regex->customfield_view))
													@if($regex->customfield_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="customfield_{{$i}}" name="customfield[]" value="customfield_add"
													@if(!empty($regex->customfield_add))
													@if($regex->customfield_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="customfield_{{$i}}" name="customfield[]" value="customfield_edit"
													@if(!empty($regex->customfield_edit))
													@if($regex->customfield_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="customfield_{{$i}}" name="customfield[]" value="customfield_delete"
													@if(!empty($regex->customfield_delete))
													@if($regex->customfield_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- @if($get_right->role_name == "")
													<input type="checkbox" class="sales_{{$i}}" name="sales[]" value="sales_owndata"
													@if(!empty($regex->sales_owndata))
													@if($regex->sales_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif -->
												</td>
											</tr>
										<!-- Custom Field Module Access Rights End -->
										
										<!-- Observation Library Module Access Rights Start -->
											<tr>
												<td>{{ trans('app.Observation Library')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="observationlibrary" name="observationlibrary[]" value="observationlibrary_view"
													@if(!empty($regex->observationlibrary_view))
													@if($regex->observationlibrary_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="observationlibrary_{{$i}}" name="observationlibrary[]" value="observationlibrary_add"
													@if(!empty($regex->observationlibrary_add))
													@if($regex->observationlibrary_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="observationlibrary_{{$i}}" name="observationlibrary[]" value="observationlibrary_edit"
													@if(!empty($regex->observationlibrary_edit))
													@if($regex->observationlibrary_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="observationlibrary_{{$i}}" name="observationlibrary[]" value="observationlibrary_delete"
													@if(!empty($regex->observationlibrary_delete))
													@if($regex->observationlibrary_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- @if($get_right->role_name == "")
													<input type="checkbox" class="sales_{{$i}}" name="sales[]" value="sales_owndata"
													@if(!empty($regex->sales_owndata))
													@if($regex->sales_owndata == TRUE) {{'checked'}} @endif
													@endif
													>
													@endif -->
												</td>
											</tr>
										<!-- Observation Library Module Access Rights End -->

										<!-- Quotation Module Access Rights Start -->
											<tr>
												<td>{{ trans('app.Quotation')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="quotation" name="quotation[]" value="quotation_view"
													@if(!empty($regex->quotation_view))
													@if($regex->quotation_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="quotation_{{$i}}" name="quotation[]" value="quotation_add"
													@if(!empty($regex->quotation_add))
													@if($regex->quotation_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="quotation_{{$i}}" name="quotation[]" value="quotation_edit"
													@if(!empty($regex->quotation_edit))
													@if($regex->quotation_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="quotation_{{$i}}" name="quotation[]" value="quotation_delete"
													@if(!empty($regex->quotation_delete))
													@if($regex->quotation_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>													
												</td>
											</tr>
										<!-- Quotation Module Access Rights End -->
										
										<!-- General Setting Module Access Rights Start -->
											<tr>
												<td>{{ trans('app.General Settings')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="generalsetting" name="generalsetting[]" value="generalsetting_view"
													@if(!empty($regex->generalsetting_view))
													@if($regex->generalsetting_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
												<td>
													<input type="checkbox" class="generalsetting_{{$i}}" name="generalsetting[]" value="generalsetting_edit"
													@if(!empty($regex->generalsetting_edit))
													@if($regex->generalsetting_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
												<td>
													
												</td>
											</tr>
										<!-- General Setting Module Access Rights End -->
										
										<!-- Timezone Module Access Rights Start -->
											<tr>
												<td>{{ trans('app.Other Setting [Timezone]')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="timezone" name="timezone[]" value="timezone_view"
													@if(!empty($regex->timezone_view))
													@if($regex->timezone_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
												<td>
													<input type="checkbox" class="timezone_{{$i}}" name="timezone[]" value="timezone_edit"
													@if(!empty($regex->timezone_edit))
													@if($regex->timezone_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
												<td>
													
												</td>
											</tr>
										<!-- Timezone Module Access Rights End -->
										
										<!-- Language Module Access Rights Start -->
											<tr>
												<td>{{ trans('app.Other Setting [Language]')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="language" name="language[]" value="language_view"
													@if(!empty($regex->language_view))
													@if($regex->language_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
												<td>
													<input type="checkbox" class="language_{{$i}}" name="language[]" value="language_edit"
													@if(!empty($regex->language_edit))
													@if($regex->language_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
												<td>
													
												</td>
											</tr>
										<!-- Language Module Access Rights End -->

										<!-- Date Format Module Access Rights Start -->
											<tr>
												<td>{{ trans('app.Other Setting [Date Format]')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="dateformat" name="dateformat[]" value="dateformat_view"
													@if(!empty($regex->dateformat_view))
													@if($regex->dateformat_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
												<td>
													<input type="checkbox" class="dateformat_{{$i}}" name="dateformat[]" value="dateformat_edit"
													@if(!empty($regex->dateformat_edit))
													@if($regex->dateformat_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
												<td>
													
												</td>
											</tr>
										<!-- Date Format Module Access Rights End -->

										<!-- Currency Module Access Rights Start -->
											<tr>
												<td>{{ trans('app.Other Setting [Currency]')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="currency" name="currency[]" value="currency_view"
													@if(!empty($regex->currency_view))
													@if($regex->currency_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
												<td>
													<input type="checkbox" class="currency_{{$i}}" name="currency[]" value="currency_edit"
													@if(!empty($regex->currency_edit))
													@if($regex->currency_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
												<td>
													
												</td>
											</tr>
										<!-- Currency Module Access Rights End -->
										
										<!-- Access Rights Module Access Rights Start -->
											<tr>
												<td>{{ trans('app.Access Rights')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="accessrights" name="accessrights[]" value="accessrights_view"
													@if(!empty($regex->accessrights_view))
													@if($regex->accessrights_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
												<td>
													<input type="checkbox" class="accessrights_{{$i}}" name="accessrights[]" value="accessrights_edit"
													@if(!empty($regex->accessrights_edit))
													@if($regex->accessrights_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
												<td>
													
												</td>
											</tr>
										<!-- Currency Module Access Rights End -->

										<!-- Business Hours Module Access Rights Start -->
											<tr>
												<td>{{ trans('app.Business Hours')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="businesshours" name="businesshours[]" value="businesshours_view"
													@if(!empty($regex->businesshours_view))
													@if($regex->businesshours_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<input type="checkbox" class="businesshours_{{$i}}" name="businesshours[]" value="businesshours_add"
													@if(!empty($regex->businesshours_add))
													@if($regex->businesshours_add == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													<!-- <input type="checkbox" class="observationlibrary_{{$i}}" name="observationlibrary[]" value="observationlibrary_edit"
													@if(!empty($regex->observationlibrary_edit))
													@if($regex->observationlibrary_edit == TRUE) {{'checked'}} @endif
													@endif
													> -->
												</td>
												<td>
													<input type="checkbox" class="businesshours_{{$i}}" name="businesshours[]" value="businesshours_delete"
													@if(!empty($regex->businesshours_delete))
													@if($regex->businesshours_delete == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
											</tr>
										<!-- Business Hours Module Access Rights End -->
										
										<!-- Stripe Setting Module Access Rights Start -->
											<tr>
												<td>{{ trans('app.Stripe Settings')}}</td>
												<td class="">
													<input type="checkbox" data-row="{{$i}}" class="main_access" data-for="stripesetting" name="stripesetting[]" value="stripesetting_view"
													@if(!empty($regex->stripesetting_view))
													@if($regex->stripesetting_view == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
												<td>
													<input type="checkbox" class="stripesetting_{{$i}}" name="stripesetting[]" value="stripesetting_edit"
													@if(!empty($regex->stripesetting_edit))
													@if($regex->stripesetting_edit == TRUE) {{'checked'}} @endif
													@endif
													>
												</td>
												<td>
													
												</td>
												<td>
													
												</td>
											</tr>
										<!-- Stripe Setting Module Access Rights End -->


										</tbody>
									</table>

								
								@can('accessrights_edit')
									<div class="col-md-12 col-sm-12 col-xs-12 text-left submitButtonDiv">
										<button type="submit" class="btn btn-success">{{ trans('app.Submit')}}</button>
									</div>
								@endcan
								

								</form>
								</div>
							</div>
						</div>
					@endforeach
					<!-- SUPER ADMIN Accordion Ending -->
					</div>
				</div>
			</div>
        </div>
	</div>
<!-- page content end -->

<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- Adding by me(New) -->
<script src="{{ URL::asset('public/js/custom/accessrights/accessRightsJsFile.js') }}"></script>

<!-- language change in user selected  (For Jumbo_Table Inside of SUPER ADMIN (New))-->	
<script>
	$(document).ready(function() {
	    $('#datatable').DataTable( {
			responsive: true,
			"paging": false,
	   		"ordering": false,
	   		"searching": false,
	   		"info": false,
	        "language": {
				
					"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo getLanguageChange(); 
				?>.json"
	        }
	    } );
	} );
</script> 

<!-- This for SUPER ADMIN Accordion  (New)-->
<script>
   $(function() {
    
     function toggleIcon(e) {
         $(e.target)
             .prev('.panel-heading')
             .find(".plus-minus")
             .toggleClass('glyphicon-plus glyphicon-minus');
     }
     $('.panel-group').on('hidden.bs.collapse', toggleIcon);
     $('.panel-group').on('shown.bs.collapse', toggleIcon);
    
   });
</script>
	
@endsection