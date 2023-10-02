@extends('layouts.app')
@section('content')

<style>
.right_side .table_row, .member_right .table_row {
    border-bottom: 1px solid #dedede;
    float: left;
    width: 100%;
	padding: 1px 0px 4px 2px;
}
.table_row .table_td {
  padding: 8px 8px !important;
}
.report_title {
    float: left;
    font-size: 20px;
    width: 100%;
}
</style>

<!-- page content -->
	<div class="right_col" role="main">
		<div class="">
			<div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Supplier')}}</span></a>
						</div>
						@include('dashboard.profile')
					</nav>
				</div>
			</div>
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
		<div class="row" >
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_content">
					<ul class="nav nav-tabs bar_tabs" role="tablist">
						@can('supplier_view')
							<li role="presentation" class=""><a href="{!! url('/supplier/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Supplier List')}}</a></li>
						@endcan
						@can('supplier_view')
							<li role="presentation" class="active"><a href="{!! url('/supplier/list/'.$viewid)!!}"><span class="visible-xs"></span><i class="fa fa-user">&nbsp; </i><b> {{ trans('app.View Supplier')}}</b></a></li>
						@endcan
					</ul>
				</div>
				<div class="row">
					<div class="col-md-8 col-sm-12 col-xs-12 main_left">
						<div class="x_panel">
							<div class="col-md-6 col-sm-6 col-xs-12 left_side">
								<img src="{{ URL::asset('public/supplier/'.$user->image) }}" class="cimg"> 
							</div>
							<div class="col-md-6 col-sm-6 right_side">
								<div class="table_row">
									<div class="col-md-5 col-sm-6 table_td">
										<i class="fa fa-user"></i> 
										<b>{{ trans('app.Name')}}</b>	
									</div>
									<div class="col-md-7 col-sm-6 table_td">
										<span class="txt_color">
										{{ $user->name.' '.$user->lastname }}
										</span>
									</div>
								</div>
								<div class="table_row">
									<div class="col-md-5 col-sm-6 table_td">
										<i class="fa fa-envelope"></i> 
										<b>{{ trans('app.Email')}}</b> 	
									</div>
									<div class="col-md-7 col-sm-6 table_td">
										<span class="txt_color">{{ $user->email }}</span>
									</div>
								</div>
								<div class="table_row">
									<div class="col-md-5 col-sm-6 table_td"><i class="fa fa-phone"></i> <b>{{ trans('app.Mobile No')}}</b> </div>
									<div class="col-md-7 col-sm-6 table_td">
										<span class="txt_color">
											<span class="txt_color">{{ $user->mobile_no }} </span>
										</span>
									</div>
								</div>
								<!-- Remove DoB -->
								<!-- <div class="table_row">
									<div class="col-md-5 col-sm-6 table_td">
										<i class="fa fa-calendar"></i><b> {{ trans('app.Date Of Birth')}}</b>	
									</div>
									<div class="col-md-7 col-sm-6 table_td">
										<span class="txt_color">{{  date(getDateFormat(),strtotime($user->birth_date ))}}</span>
									</div>
								</div> -->

								<!-- Remove Gender -->
								<!-- <div class="table_row">
									<div class="col-md-5 col-sm-6 table_td">
										<i class="fa fa-mars"></i> <b>{{ trans('app.Gender')}}</b>
									</div>
									<div class="col-md-7 col-sm-6 table_td">
										<span class="txt_color">
										@if($user->gender =='1')
										  <?php echo"male ";?>
										  @else
											<?php echo"female";?>
										@endif
													 </span>
									</div>
								</div> -->

								<div class="table_row">
									<div class="col-md-5 col-sm-6 table_td">
										<i class="fa fa-map-marker"></i> <b>{{ trans('app.Address')}}</b>		</div>
									<div class="col-md-7 col-sm-6 table_td">
										<span class="txt_color">
										  {{ $user->address }},<br/>
										  <?php echo (getCityName($user->city_id) != null) ? getCityName($user->city_id) .",<br>" : "";?>
										  {{ getStateName($user->state_id)}}, {{ getCountryName($user->country_id)}}.
										</span>
									</div>
								</div>
							</div>           
						</div>
					</div>
					<div class="col-md-4 col-sm-12 col-xs-12 morinfo">
						<div class="x_panel">
							<div class="col-md-12 col-sm-12 right_side">
								<span class="report_title">
									<span class="fa-stack cutomcircle">
										<i class="fa fa-align-left fa-stack-1x"></i>
									</span> 
									<span class="shiptitle">{{ trans('app.More Info')}}</span>		
								</span>
						@if(!empty($tbl_custom_fields))		
							@foreach($tbl_custom_fields as $tbl_custom_field)	
								<?php 
								$tbl_custom=$tbl_custom_field->id;
								$userid=$user->id;
							
								$datavalue=getCustomData($tbl_custom,$userid);
								?>
								@if($tbl_custom_field->type == "radio")
										@if($datavalue != "")
											<?php
												$radio_selected_value = getRadioSelectedValue($tbl_custom_field->id, $datavalue);
											?>
										
											<div class="table_row">									
												<div class="col-md-6 col-sm-12 table_td">
													<b>{{$tbl_custom_field->label}}</b>
												</div>
												<div class="col-md-6 col-sm-12 table_td">
													<span class="txt_color">{{$radio_selected_value}}</span>
												</div>						
											</div>
										@endif
									@else
										@if($datavalue != "")
											<div class="table_row">									
												<div class="col-md-6 col-sm-12 table_td">
													<b>{{$tbl_custom_field->label}}</b>
												</div>
												<div class="col-md-6 col-sm-12 table_td">
													<span class="txt_color">{{$datavalue}}</span>
												</div>						
											</div>
										@endif
									@endif												
							@endforeach
						@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<!-- /page content -->

@endsection