@extends('layouts.app')
@section('content')

<!-- page content -->
        <div class="right_col" role="main">
			<div class="">
				<div class="page-title">
					<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Custom Field')}}</span></a>
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
							<ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
								@can('customfield_view')
									<li role="presentation" class="active"><a href="{!! url('setting/custom/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.List Custom Field')}}</b></a></li>
								@endcan
								@can('customfield_add')
									<li role="presentation" class="setSizeForAddCustomFieldForSmallDevice"><a href="{!! url('setting/custom/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i> {{ trans('app.Add Custom Field')}}</a></li>
								@endcan
							</ul>
						</div>
			
						<div class="x_panel table_up_div">
							<table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
								<thead>
									<tr>
										<th>#</th>
										<th>{{ trans('app.Form Name')}}</th>
										<th>{{ trans('app.Label')}}</th>
										<th>{{ trans('app.Type')}}</th>
										<th>{{ trans('app.Required')}}</th>
										
										@canany(['customfield_edit','customfield_delete'])
			                        		<th>{{ trans('app.Action')}}</th>
			                        	@endcan
									</tr>
								</thead>
								<tbody>
									<?php $i = 1; ?> 
									@foreach ($tbl_custom_fields as $tbl_custom_field)
									<tr>
										<td>{{ $i }}</td>
										<td>{{ $tbl_custom_field->form_name}}</td>
										<td>{{ $tbl_custom_field->label}}</td>
										<td>{{ ucfirst($tbl_custom_field->type)}}</td>
										<td>{{ ucfirst($tbl_custom_field->required)}}</td>

										@canany(['customfield_edit','customfield_delete'])
										<td>
											@can('customfield_edit')
												<a href="{!! url('/setting/custom/list/edit/'.$tbl_custom_field->id) !!}" ><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
											@endcan
											@can('customfield_delete')
												<a url="{!! url('/setting/custom/list/delete/'.$tbl_custom_field->id) !!}" class="sa-warning"><button type="button" class="btn btn-round btn-danger dgr">{{ trans('app.Delete')}}</button></a>
											@endcan
										</td>
										@endcanany
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
<!-- delete customefield -->
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