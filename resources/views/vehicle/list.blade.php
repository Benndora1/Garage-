@extends('layouts.app')
@section('content')

<!-- page content -->
	<div class="right_col" role="main">
        <div class="">
			<div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Vehicle')}}</span></a>
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
							@can('vehicle_view')
								<li role="presentation" class="active"><a href="{!! url('/vehicle/list')!!}"><span class="visible-xs"></span> <i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Vehicle List') }}</b></a></li>
							@endcan

							@can('vehicle_add')
								<li role="presentation" class=""><a href="{!! url('/vehicle/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i>
								{{ trans('app.Add Vehicle') }}</a></li>
							@endcan						
						</ul>
					</div>
					<div class="x_panel">
						<table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
							<thead>
								<tr>
									<th>#</th>
									<th>{{ trans('app.Image')}}</th>
									<th>{{ trans('app.Model Name') }}</th>
									<th>{{ trans('app.Type') }}</th>
									<th>{{  trans('app.Price')}}  (<?php echo getCurrencySymbols(); ?>)</th>
									<th>{{  trans('app.Date Of Manufacturing')}}</th>
									<th>{{ trans('app.Engine No')}}</th>
									<th>{{ trans('app.Number Plate')}}</th>
									<th>{{ trans('app.Action')}}</th>
								</tr>
							</thead>
							<tbody>
						   <?php $i=1;?>
							@if(!empty($vehical))
								@foreach($vehical as $vehicals)
								<tr>
									<td>{{ $i }}</td>
										<?php  $vehicleimage = getVehicleImage($vehicals->id); ?>
									<td><img src="{{ URL::asset('public/vehicle/'.$vehicleimage) }}"  width="50px" height="50px" class="img-circle" ></td>
									<td>{{ $vehicals->modelname }}</td>
									<td>{{ getVehicleType($vehicals->vehicletype_id) }}</td>
									<td>{{ $vehicals->price }}</td>
									<td>
										@if(!empty($vehicals->dom))
											{{ date(getDateFormat(),strtotime($vehicals->dom)) }}
										@else
											{{ trans('app.Not Added') }}
										@endif										
									</td>
									<td>{{ $vehicals->engineno??trans('app.Not Added') }}</td>
									<td>{{ $vehicals->number_plate??trans('app.Not Added') }}</td>
									<td> 
									
										@can('vehicle_view')
											<a href="{!! url('/vehicle/list/view/'.$vehicals->id) !!}"><button type="button" class="btn btn-round btn-info">{{ trans('app.View')}}</button></a>
										@endcan

										@can('vehicle_edit')
											<a href="{!! url ('/vehicle/list/edit/'.$vehicals->id) !!}"> <button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
										@endcan
										
										@can('vehicle_delete')
											<a url="{!! url('/vehicle/list/delete/'.$vehicals->id)!!}" class="sa-warning buttonOfAtag"> <button type="button" class="btn btn-round btn-danger">{{ trans('app.Delete')}}</button></a>
										@endcan
									</td>
								</tr>
								<?php $i++; ?>
								@endforeach
							@endif
							<tbody>
							</tbody>
						</table>
					</div>
                </div>
            </div>
        </div>
    </div>

<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
 <!-- language change in user selected -->	
<script>
$(document).ready(function() {
    $('#datatable').DataTable( {
		responsive: true,
		sDom: "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
        "language": {
			
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo getLanguageChange(); 
			?>.json"
        }
    } );
} );
</script>
<!-- delete vehical -->
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