@extends('layouts.app')
@section('content')
<!-- page content -->
    <div class="right_col" role="main">
        <div class="">
			<div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Product')}}</span></a>
						</div>
						@include('dashboard.profile')
					</nav>
				</div>
            </div>
			@if(session('message'))
				<div class="row massage">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="checkbox checkbox-success checkbox-circle">
							@if(session('message') == 'Successfully Submitted')
								<label for="checkbox-10 colo_success"> {{trans('app.Successfully Submitted')}}  </label>
							@elseif(session('message')=='Successfully Updated')
								<label for="checkbox-10 colo_success"> {{ trans('app.Successfully Updated')}}  </label>
							@elseif(session('message')=='Successfully Deleted')
								<label for="checkbox-10 colo_success"> {{ trans('app.Successfully Deleted')}}  </label>
							@endif
						</div>
					</div>
				</div>
			@endif
            <div class="row" >
				<div class="col-md-12 col-sm-12 col-xs-12" >
					<div class="x_content">
						<ul class="nav nav-tabs bar_tabs" role="tablist">
							@can('product_view')
								<li role="presentation" class="active"><a href="{!! url('/product/list')!!}"><span class="visible-xs"></span> <i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Product List')}}</b></a></li>
							@endcan

							@can('product_add')
								<li role="presentation" class=""><a href="{!! url('/product/add')!!}"><span class="visible-xs"></span> <i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add Product')}} </a></li>
							@endcan
						</ul>
					</div>
					<div class="x_panel table_up_div">
						<table id="datatable" class="table table-striped jambo_table" style="margin-top:20px; width:100%;">
							<thead>
								<tr>
									<th>#</th>
									<th>{{ trans('app.Product Number')}}</th>
									<th>{{ trans('app.Manufacturer Name')}}</th>
									<th>{{ trans('app.Product Name')}}</th>
									<th>{{ trans('app.Price')}} (<?php echo getCurrencySymbols(); ?>)</th>
									<th>{{ trans('app.Supplier Name')}}</th>
									<th>{{ trans('app.Company Name')}}</th>

								<!-- Custom Field Data Label Name-->
									@if(!empty($tbl_custom_fields))
										@foreach($tbl_custom_fields as $tbl_custom_field)	
											<th>{{$tbl_custom_field->label}}</th>
										@endforeach
									@endif
								<!-- Custom Field Data End -->

									<th>{{ trans('app.Action')}}</th>
								</tr>
							</thead>
							<tbody>
							<?php $i = 1; ?>  
							@foreach ($product as $products)
								<tr>
									<td>{{ $i }}</td>
									<td>{{ $products->product_no }}</td>
									<td>{{	getProductName($products->product_type_id) }}</td>
									<td>{{ $products->name }}</td>
									<td>{{ $products->price }}</td>
									<td>{{ getSupplierFullName($products->supplier_id) }}</td>
									<td>{{ getCompanyNames($products->supplier_id) }}</td>

								<!-- Custom Field Data Value-->
									@if(!empty($tbl_custom_fields))
				
										@foreach($tbl_custom_fields as $tbl_custom_field)	
											<?php 
												$tbl_custom = $tbl_custom_field->id;
												$userid = $products->id;
																						
												$datavalue = getCustomDataProduct($tbl_custom,$userid);
											?>

											@if($tbl_custom_field->type == "radio")
												@if($datavalue != "")
													<?php
														$radio_selected_value = getRadioSelectedValue($tbl_custom_field->id, $datavalue);
													?>
													<td>{{$radio_selected_value}}</td>
												@else
													<td>{{ trans('app.Data not available') }}</td>
												@endif
											@else
												@if($datavalue != null)
													<td>{{$datavalue}}</td>
												@else
													<td>{{ trans('app.Data not available') }}</td>
												@endif
											@endif
										@endforeach
									@endif
								<!-- Custom Field Data End -->

									<td>
										@can('product_edit')
											<a href="{!! url('/product/list/edit/'.$products->id) !!}" ><button type="button" class="btn btn-round btn-success editBtnCss">{{ trans('app.Edit')}}</button></a>
										@endcan

										@can('product_delete')
											<a url="{!! url('/product/list/delete/'.$products->id) !!}" class="sa-warning"><button type="button" id="deleteBtnCss" class="btn btn-round btn-danger">{{ trans('app.Delete')}}</button></a>
										@endcan
									</td>
								</tr>
								<?php $i++; ?>
							@endforeach	
							</tbody>
						</table>
					</div>
				</div>
            </div>
        </div>
    </div>

 <!-- /page content --> 
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script>
$(document).ready(function() {
    $('#datatable').DataTable( {
		responsive: true,
        "language": {
			
			 "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo getLanguageChange(); 
			?>.json"
        }
    } );
} );
</script>
       
<script>
$('body').on('click', '.sa-warning', function() {
	  var url =$(this).attr('url');
	    
        swal({   
            title: "Are You Sure?",
			text: "You will not be able to recover this data afterwards!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#297FCA",   
            confirmButtonText: "Yes, delete!",   
            closeOnConfirm: false 
        }, function(){
			window.location.href = url;
             
        });
    }); 
 
</script>

@endsection