@extends('layouts.app')
@section('content')

<!-- page content -->
    <div class="right_col" role="main">
		<div class="">
			<div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Color')}}</span></a>
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
						   @elseif(session('message')=='This color is used with a vehicle record. So you can not delete it.')
						   <label for="checkbox-10 colo_success"> {{ trans('app.This color is used with a vehicle record. So you can not delete it.')}}  </label>
						   @endif
							
						</div>
					</div>
				</div> 
			@endif
				<div class="row" >
					<div class="col-md-12 col-sm-12 col-xs-12" >
						<div class="x_content">
							<ul class="nav nav-tabs bar_tabs" role="tablist">
								@can('colors_view')
									<li role="presentation" class="active"><a href="{!! url('/color/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Color List')}}</b></a></li>
								@endcan
								@can('colors_add')
									<li role="presentation" class=""><a href="{!! url('/color/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add Color')}}</a></li>
								@endcan
							</ul>
						</div>
						<div class="x_panel ">
							<table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
								<thead>
									<tr>
										<th>#</th>
										<th>{{ trans('app.Color Name')}}</th>

									<!-- Custom Field Data Label Name-->
										@if(!empty($tbl_custom_fields))
											@foreach($tbl_custom_fields as $tbl_custom_field)	
												<th>{{$tbl_custom_field->label}}</th>
											@endforeach
										@endif
									<!-- Custom Field Data End -->

									@canany(['colors_edit','colors_delete'])
										<th>{{ trans('app.Action')}}</th>
									@endcanany

									</tr>
								</thead>
								<tbody>
									<?php $i = 1; ?>   
									
									@foreach ($color as $colors)
									<tr>
										<td>{{ $i }}</td>
										<td>{{ $colors->color }}</td>

									<!-- Custom Field Data Value-->
										@if(!empty($tbl_custom_fields))
					
											@foreach($tbl_custom_fields as $tbl_custom_field)	
											<?php 
												$tbl_custom = $tbl_custom_field->id;
												$userid = $colors->id;
																						
												$datavalue = getCustomDataColors($tbl_custom,$userid);
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

										@if(Gate::allows('colors_edit') || Gate::allows('colors_delete'))
										<td>
											@can('colors_edit')
												<a href="{!! url('/color/list/edit/'.$colors->id) !!}" ><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
											@endcan
											@can('colors_delete')
												<a url="{!! url('/color/list/delete/'.$colors->id) !!}" class="sa-warning"><button type="button" class="btn btn-round btn-danger dgr">{{ trans('app.Delete')}}</button></a>
											@endcan
										</td>
										@endif
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
<!-- delete color -->
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