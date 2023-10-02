@extends('layouts.app')
@section('content')
<style>
</style>

<!-- page content -->
    <div class="right_col" role="main">
        <div class="">
			<div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Customer')}}</span></a>
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
						@can('customer_view')
						<li role="presentation" class="active"><a href="{!! url('/customer/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Customer List') }}</b></a></li>
						@endcan

						@can('customer_add')
						 	<li role="presentation" class=""><a href="{!! url('/customer/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i> {{ trans('app.Add Customer') }}</a></li>
						@endcan
					
					</ul>
				</div>
				<div class="x_panel bgr">
					<table id="datatable" class="table datatable table-striped jambo_table" style="margin-top:20px; width:100%;">
						<thead>
							<tr>
								<th>#</th>
								<th>{{ trans('app.Image')}}</th>
								<th>{{ trans('app.First Name') }}</th>
								<th>{{ trans('app.Last Name') }}</th>
								<th>{{ trans('app.Email') }}</th>
								<th>{{ trans('app.Mobile Number') }}</th>
								<th>{{ trans('app.Action')}}</th>
							</tr>
						</thead>
						<tbody>
						<?php $i=1;?>
						@if(!empty($customer))
							@foreach($customer as $customers)
								<tr>
									<td>{{ $i }}</td>
									<td><img src="{{ url('public/customer/'.$customers->image) }}"  width="50px" height="50px" class="img-circle" ></td>
									<td>{{ $customers -> name }}</td>
									<td>{{ $customers -> lastname}}</td>
									<td>{{ $customers -> email }}</td>
									<td>{{ $customers -> mobile_no }}</td>
									<td> 
										@can('customer_view')
											<a href="{!! url('/customer/list/'.$customers->id) !!}"><button type="button" class="btn btn-round btn-info">{{ trans('app.View')}}</button></a>
										@endcan
										 
										@can('customer_edit')
											<a href="{!! url ('/customer/list/edit/'.$customers->id) !!}"> <button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
										@endcan

										@can('customer_delete')
											<a  url="{!! url('/customer/list/delete/'.$customers->id)!!}" class="deletecustomers"> <button type="button" class="btn btn-round btn-danger">{{ trans('app.Delete')}}</button></a>
										@endcan
									
										@if(getUserRoleFromUserTable(Auth::User()->id) == 'Customer')
											@if(!Gate::allows('customer_edit'))
												@can('customer_owndata')
													<a href="{!! url ('/customer/list/edit/'.$customers->id) !!}"> <button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
												@endcan
											@endif	
										@endif
								    </td>
								</tr>
								<?php $i++; ?>
							@endforeach
						@endif  
						
						</tbody>
					</table>
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

$(document).ready(function(){
	$('body').on('click', '.deletecustomers', function() {
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
  }); 
 
</script>

@endsection