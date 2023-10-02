@extends('layouts.app')
@section('content')

<!-- page content -->
    <div class="right_col" role="main">
        <div class="">
			<div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Employee')}}</span></a>
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
        <div class="row" >
			<div class="col-md-12 col-sm-12 col-xs-12" >
				<div class="x_content">
					<ul class="nav nav-tabs bar_tabs" role="tablist">
						@can('employee_view')
							<li role="presentation" class="active"><a href="{!! url('/employee/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Employee List')}}</b></a></li>
						@endcan
						
						@can('employee_add')
							<li role="presentation" class=""><a href="{!! url('/employee/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i> {{ trans('app.Add Employee')}}</a></li>
						@endcan
					</ul>
				</div>
				<div class="x_panel">
					<table id="datatable" class="table table-striped  jambo_table" style="margin-top:20px;" >
						<thead>
						
						
							<tr>
								<th>#</th>
								<th>{{ trans('app.Image')}}</th>
								<th>{{ trans('app.First Name')}}</th>
								<th>{{ trans('app.Last Name')}}</th>
								<th>{{ trans('app.Email')}}</th>
								<th>{{ trans('app.Mobile Number')}}</th>
								
								@if(getUserRoleFromUserTable(Auth::User()->id) != 'Customer')
									<th>{{ trans('app.Action')}}</th>
								@endif

								@if(getUserRoleFromUserTable(Auth::User()->id) == 'Customer')
									@if(Gate::allows('employee_add') || Gate::allows('employee_edit') || Gate::allows('employee_delete'))
										<th>{{ trans('app.Action')}}</th>
									@endif
								@endif
							</tr>
						
						</thead>
						<tbody>
							<?php $i = 1; ?>   
						@foreach($user as $users)
							<tr>
								<td>{{ $i }}</td>
								<td><img src="{{ URL::asset('public/employee/'.$users->image) }}"  width="50px" height="50px" class="img-circle"></td>
								<td>{{ $users->name }}</td>
								<td>{{ $users->lastname }}</td>
								<td>{{ $users->email }}</td>
								<td>{{ $users->mobile_no }}</td>
								
								@if(getUserRoleFromUserTable(Auth::User()->id) != 'Customer')
								<td>
									@if(getUserRoleFromUserTable(Auth::User()->id) == 'admin' || 	getUserRoleFromUserTable(Auth::User()->id) == 'supportstaff' || getUserRoleFromUserTable(Auth::User()->id) == 'accountant' || getUserRoleFromUserTable(Auth::User()->id) == 'employee')
										
										@can('employee_view')
											<a href="{!! url('/employee/view/'.$users->id) !!}"><button type="button" class="btn btn-round btn-info">{{ trans('app.View')}}</button></a>
										@endcan
										@can('employee_edit')
											<a href="{!! url('/employee/edit/'.$users->id) !!}" ><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
										@endcan
										@can('employee_delete')
											<a url="{!! url('/employee/list/delete/'.$users->id) !!}" class="sa-warning"><button type="button" class="btn btn-round btn-danger">{{ trans('app.Delete')}}</button></a>
										@endcan
									@endif

									@if(Auth::User()->id == $users->id)
										@if(!Gate::allows('employee_edit'))
											@can('employee_owndata')
											<a href="{!! url('/employee/edit/'.$users->id) !!}" ><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
											@endcan
										@endif
									@endif
								</td>
								@endif

								@if(getUserRoleFromUserTable(Auth::User()->id) == 'Customer')
									@if(Gate::allows('employee_add') || Gate::allows('employee_edit') || Gate::allows('employee_delete'))
									<td>
										@can('employee_view')
											<a href="{!! url('/employee/view/'.$users->id) !!}"><button type="button" class="btn btn-round btn-info">{{ trans('app.View')}}</button></a>
										@endcan
										@can('employee_edit')
											<a href="{!! url('/employee/edit/'.$users->id) !!}" ><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
										@endcan
										@can('employee_delete')
											<a url="{!! url('/employee/list/delete/'.$users->id) !!}" class="sa-warning"><button type="button" class="btn btn-round btn-danger">{{ trans('app.Delete')}}</button></a>
										@endcan
									</td>
									@endif
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