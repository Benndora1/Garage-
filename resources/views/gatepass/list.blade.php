@extends('layouts.app')

@section('content')

<!-- page content start -->
	<div class="right_col" role="main">
		<!--gate pass view modal-->
		<div id="myModal-gateview" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg modal-xs">
 
			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header"> 
						<a href=""><button type="button" class="close">&times;</button></a>
						<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Gate Pass')}}</h4>
					</div>
					<div class="modal-body">
	
					</div>
				</div>
			</div>
		</div>
		<div class="">
		   <div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Gate Pass')}}</span></a>
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
							@can('gatepass_view')
								<li role="presentation" class="active"><a href="{!! url('/gatepass/list')!!}"><span class="visible-xs"></span> <i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Gatepass List')}}</b></span></a></li>
							@endcan
							@can('gatepass_add')
								<li role="presentation" class=""><a href="{!! url('/gatepass/add') !!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add Gatepass')}}</span></a></li>
							@endcan
						</ul>
					</div>
					<div class="x_panel table_up_div">
						<table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
							<thead>
								<tr>
									<th>#</th>
									<th>{{ trans('app.Gatepass No')}}</th>
									<th>{{ trans('app.Job No')}}</th>
									<th>{{ trans('app.Customer Name')}}</th>
									<th>{{ trans('app.Vehicle Name')}}</th>
									<th>{{ trans('app.Action')}}</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1; ?>   
								
								@foreach ($gatepass as $gatepasss)
									<tr>
										<td>{{ $i }}</td>
										<td>{{ $gatepasss->gatepass_no }}</td>
										<td>{{ $gatepasss->jobcard_id }}</td>
										<td>{{ getCustomerName($gatepasss->customer_id) }}</td>
										<td>{{ getVehicleName($gatepasss->vehicle_id) }}</td>
										<td>
												@can('gatepass_view')
													<button type="button" data-toggle="modal" data-target="#myModal-gateview" serviceid="" class="btn getgetpass btn-round btn-info" getpassid="{{ $gatepasss->jobcard_id }}">{{ trans('app.View')}}</button>
												@endcan
												@can('gatepass_edit')
													<a href="{!! url('/gatepass/list/edit/'.$gatepasss->id) !!}" ><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
												@endcan
												@can('gatepass_delete')
													<a url="{!! url('/gatepass/list/delete/'.$gatepasss->id) !!}" class="sa-warning"><button type="button" class="btn btn-round btn-danger">{{ trans('app.Delete')}}</button></a>
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
<!-- page content end -->


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
    } );
} );
</script>        
		
<script>
$(document).ready(function(){
	$('body').on('click', '.getgetpass', function() {
		var getpassid = $(this).attr('getpassid');
	 var url = "<?php echo url('/gatepass/gatepassview'); ?>";
		$.ajax({
			type:'GET',
			url:url,
			data:{getpassid:getpassid},
			success:function(response)
			{
				$('.modal-body').html(response.html);
			},
		});
	});
});
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