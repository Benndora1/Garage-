@extends('layouts.app')
@section('content')
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Inventory',$userid)=='yes')
	<div class="right_col" role="main">
		<div class="page-title">
			<div class="nav_menu">
				<nav>
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Stock')}}</span></a>
					</div>
					@include('dashboard.profile')
				</nav>
			</div>
		</div>
		<div class="x_content">
			<ul class="nav nav-tabs bar_tabs" role="tablist">
				<li role="presentation" class=""><a href="{!! url('/stoke/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Stock List')}}</a></li>
				<li role="presentation" class="active"><a href="{!! url('/stoke/edit/'.$stock->id)!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Edit Stock')}}</b></a></li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">   
						 <form action="update/{{$stock->id}}"  method="post" enctype="multipart/form-data"  class="form-horizontal upperform">
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Product Name')}} <label class="text-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
									
										<select name="product" class="form-control  productid"  required="required">
												<option value="">{{ trans('app.--Select Product--')}}</option>
												  @if(!empty($product))
												  @foreach($product as $products)
												  <option value="{{ $products->id }}"<?php if($products->id == $stock->product_id){ echo"selected";} ?>>{{$products->name}}</option>
												  @endforeach
												  @endif
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.No of Stock')}} <label class="text-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="qty" value="{{$stock->no_of_stoke}}"class="form-control" required>
									</div>
								</div>
							</div>
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<div class="form-group">
								<div class="col-md-12 col-sm-6 col-xs-12 col-md-offset-2">
									<button type="submit" class="btn btn-success">{{ trans('app.Update')}}</button>
								</div>
							</div>
						</form>   				
					</div>
				</div>
			</div>
		</div>
	</div>
@else
	<div class="right_col" role="main">
		<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
              <div class="nav toggle" style="padding-bottom:16px;">
               <span class="titleup">&nbsp {{ trans('app.You Are Not Authorize This page.')}}</span>
              </div>
        </div>
	</div>
@endif 
@endsection