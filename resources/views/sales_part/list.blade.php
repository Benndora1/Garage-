@extends('layouts.app')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header"> 
					<a href=""><button type="button" class="close">&times;</button></a>
					<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Invoice')}}</h4>
				</div>
				<div class="modal-body">

				</div>
			</div>
		</div>
	</div>
	<div>
		<div class="page-title">
			<div class="nav_menu">
				<nav>
					<div class="nav toggle">
						@if(getActiveCustomer(Auth::user()->id)=='yes' || getActiveEmployee(Auth::user()->id)=='yes')
							<a id="menu_toggle"><i class="fa fa-bars"> </i><span class="titleup">&nbsp {{ trans('app.Part Sales')}}</span></a>
						@else
							<a id="menu_toggle"><i class="fa fa-bars"> </i><span class="titleup">&nbsp {{ trans('app.Purchase')}}</span></a>
						@endif
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
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_content">
					<ul class="nav nav-tabs bar_tabs" role="tablist">
					@if(getActiveCustomer(Auth::user()->id)=='yes' || getActiveEmployee(Auth::user()->id)=='yes')
						@can('salespart_view')
							<li role="presentation" class=""><a href="{!! url('/sales_part/list')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.List Of Part Sales')}}</span></a></li>
						@endcan
						@can('salespart_add')
							<li role="presentation" class=""><a href="{!! url('/sales_part/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add Part Sales')}}</span></a></li>
						@endcan
					@elseif(getCustomersactive(Auth::user()->id) == 'yes')
						@can('salespart_view')
							<li role="presentation" class="active"><a href="{!! url('/sales/list')!!}"><span class="visible-xs"></span> </span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Purchase List')}}</b></a></li>
						@endcan
						@can('salespart_add')
							<li role="presentation" class=""><a href="{!! url('/sales_part/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add Part Sales')}}</span></a></li>
						@endcan
					@endif
					</ul>
				</div>
				<div class="x_panel table_up_div">
					<table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
						<thead>
							<tr>
								<th>{{ trans('app.#')}}</th>
								<th>{{ trans('app.Bill Number')}}</th>
								<th>{{ trans('app.Customer Name')}}</th>
								<th>{{ trans('app.Date')}}</th>
								<th>{{ trans('app.Part Brand')}}</th>
								<th>{{ trans('app.Salesman')}}</th>
								<th>{{ trans('app.Action')}}</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>   
							@foreach ($sales as $sale)	
							<tr>
								<td>{{ $i }}</td>
								<td>{{ $sale->bill_no }}</td>
								<td>{{ getCustomerName($sale->customer_id) }}</td>
								<td>{{ date(getDateFormat(),strtotime($sale->date)) }}</td>
								<td>{{ getPart($sale->product_id)->name }}</td>
								<td>{{ getAssignedName($sale->salesmanname) }}</td>
								<td>
								@if(getUserRoleFromUserTable(Auth::User()->id) == 'admin' || getUserRoleFromUserTable(Auth::User()->id) == 'supportstaff' || getUserRoleFromUserTable(Auth::User()->id) == 'accountant' || getUserRoleFromUserTable(Auth::User()->id) == 'employee')

									<?php $sales_invoice = getInvoiceNumbers($sale->id); ?>

									@if($sales_invoice == "No data")
										@if(Gate::allows('salespart_add'))
											@can('salespart_add')
											<a href="{!! url('invoice/sale_part_invoice/add/'.$sale->id) !!}" ><button type="button" class="btn btn-round btn-info">{{ trans('app.Create Invoice')}}</button></a>
											@endcan
										@else
											@can('salespart_view')
											<a href="{!! url('invoice/add/') !!}" ><button type="button" class="btn btn-round btn-info" disabled>{{ trans('app.View Invoices')}}</button></a>
											@endcan
										@endif

									@else
										@can('salespart_view')
											<button type="button" data-toggle="modal" data-target="#myModal" saleid="{{ $sale->id }}" invoice_number="{{ getInvoiceNumbers($sale->id) }}" url="{!! url('/sales_part/list/modal') !!}" class="btn btn-round btn-info save">{{ trans('app.View Invoices')}}</button>
										@endcan
									@endif
									
									@can('salespart_edit')
										<a href="{!! url('sales_part/edit/'.$sale->id) !!}"><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
									@endcan
									@can('salespart_delete')
										{{--<a url="{!! url('sales_part/delete/'.$sale->id) !!}" class="sa-warning"><button type="button" class="btn btn-round btn-danger">{{ trans('app.Delete')}}</button></a>--}}
									@endcan

								@else

									<?php $sales_invoice = getInvoiceNumbers($sale->id); ?>
									@if($sales_invoice == "No data")
										@if(Gate::allows('salespart_add'))
											@can('salespart_add')
												<a href="{!! url('invoice/sale_part_invoice/add/'.$sale->id) !!}" ><button type="button" class="btn btn-round btn-info">{{ trans('app.Create Invoice')}}</button></a>
											@endcan
										@else
											@can('salespart_view')
												<a href="{!! url('invoice/add/') !!}" ><button type="button" class="btn btn-round btn-info" disabled>{{ trans('app.View Invoices')}}</button></a>
											@endcan
										@endif

									@else
										@can('salespart_view')
											<button type="button" data-toggle="modal" data-target="#myModal" saleid="{{ $sale->id }}" invoice_number="{{ getInvoiceNumbers($sale->id) }}" url="{!! url('/sales_part/list/modal') !!}" class="btn btn-round btn-info save">{{ trans('app.View Invoices')}}</button>
										@endcan
									@endif
										
									@can('salespart_edit')
										<a href="{!! url('sales_part/edit/'.$sale->id) !!}"><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
									@endcan
									@can('salespart_delete')
										{{--<a url="{!! url('sales_part/delete/'.$sale->id) !!}" class="sa-warning"><button type="button" class="btn btn-round btn-danger">{{ trans('app.Delete')}}</button></a>--}}
									@endcan
								@endif
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
<!-- page content end-->

<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- language change in user selected -->	
<script>
$(document).ready(function() {
    $('#datatable').DataTable( {
		responsive: true,
        "language": {
			"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo getLanguageChange(); 
			?>.json"
        }
    });
});
</script>
<script>
$('body').on('click', '.sa-warning', function() {
	var url = $(this).attr('url');
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
<script type="text/javascript">
$( document ).ready(function(){
	$('body').on('click', '.save', function() {
		$('.modal-body').html("");
		var saleid = $(this).attr("saleid");
		var invoice_number = $(this).attr("invoice_number");
		var url = $(this).attr('url');
		$.ajax({
			type: 'GET',
			url: url,
			data : {saleid:saleid,invoice_number:invoice_number},
			success: function (data)
			{
				$('.modal-body').html(data.html);
			},
			beforeSend:function(){
				$(".modal-body").html("<center><h2 class=text-muted><b>Loading...</b></h2></center>");
			},
			error: function(e) {
				alert("An error occurred: " + e.responseText);
				console.log(e);	
			}
		});
	});
});
</script>
@endsection