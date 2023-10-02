@extends('layouts.app')
@section('content')

<!-- Start page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="nav_menu">
                  <nav>
                      <div class="nav toggle">
                          <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Support Staff')}}</span></a>
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
                    <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
                        @can('supportstaff_view')
                        <li role="presentation" class="active">
                            <a href="{!! url('/supportstaff/list')!!}">
                                <span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Supportstaff List') }}</b>
                            </a>
                        </li>
                        @endcan
                        @can('supportstaff_add')
                        <li role="presentation" class=" setTabAddSupportStaffOnSmallDevice">
                            <a href="{!! url('/supportstaff/add')!!}">
                                <span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i> {{ trans('app.Add Supportstaff') }}
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
                <div class="x_panel bgr">
                    <table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>{{ trans('app.Image')}}</th>
                              <th >{{ trans('app.First Name') }}</th>
                              <th>{{ trans('app.Last Name') }}</th>
                              <th>{{ trans('app.Email') }}</th>
                              <th>{{ trans('app.Mobile Number') }}</th>
                              
                            @if(getUserRoleFromUserTable(Auth::User()->id) != 'Customer')
                              <th>{{ trans('app.Action')}}</th> 
                            @elseif(getUserRoleFromUserTable(Auth::User()->id) == 'Customer')
                              @if(Gate::allows('supportstaff_add') || Gate::allows('supportstaff_edit') || Gate::allows('supportstaff_delete'))
                                <th>{{ trans('app.Action')}}</th>
                              @endif
                            @endif
                          </tr>
                      </thead>
                      <tbody>
                          <?php $i=1;?>
                              @foreach($supportstaff as $supportstaffs)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>
                                        <img src="{{ url('public/supportstaff/'.$supportstaffs->image) }}"  width="50px" height="50px" class="img-circle" >
                                    </td>
                                    <td>{{ $supportstaffs -> name }}</td>
                                    <td>{{ $supportstaffs -> lastname}}</td>
                                    <td>{{ $supportstaffs -> email }}</td>
                                    <td>{{ $supportstaffs -> mobile_no }}</td>
                                     
                                  @if(getUserRoleFromUserTable(Auth::User()->id) != 'Customer')
                                    <td>
                                    @if(getUserRoleFromUserTable(Auth::User()->id) == 'admin' ||  getUserRoleFromUserTable(Auth::User()->id) == 'supportstaff' || getUserRoleFromUserTable(Auth::User()->id) == 'accountant' || getUserRoleFromUserTable(Auth::User()->id) == 'employee')
                                      @can('supportstaff_view')
                                        <a href="{!! url('/supportstaff/list/'.$supportstaffs->id) !!}"><button type="button" class="btn btn-round btn-info">{{ trans('app.View')}}</button></a>
                                      @endcan
                                      @can('supportstaff_edit')
                                        <a href="{!! url ('/supportstaff/list/edit/'.$supportstaffs->id) !!}"><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
                                      @endcan
                                      @can('supportstaff_delete')
                                        <a url="{!! url('/supportstaff/list/delete/'.$supportstaffs->id)!!}" class="sa-warning"><button type="button" class="btn btn-round btn-danger">{{ trans('app.Delete')}}</button></a>
                                      @endcan
                                      
                                      @if(Auth::User()->id == $supportstaffs->id)
                                        @if(!Gate::allows('supportstaff_edit'))
                                          @can('supportstaff_owndata')
                                            <a href="{!! url ('/supportstaff/list/edit/'.$supportstaffs->id) !!}"><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
                                          @endcan
                                        @endif
                                      @endif
                                    @endif
                                    </td>
                                  @endif

                                  @if(getUserRoleFromUserTable(Auth::User()->id) == 'Customer')
                                    @if(Gate::allows('supportstaff_add') || Gate::allows('supportstaff_edit') || Gate::allows('supportstaff_delete'))
                                    <td>
                                      @can('supportstaff_view')
                                        <a href="{!! url('/supportstaff/list/'.$supportstaffs->id) !!}"><button type="button" class="btn btn-round btn-info">{{ trans('app.View')}}</button></a>
                                      @endcan
                                      @can('supportstaff_edit')
                                        <a href="{!! url ('/supportstaff/list/edit/'.$supportstaffs->id) !!}"><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
                                      @endcan
                                      @can('supportstaff_delete')
                                        <a url="{!! url('/supportstaff/list/delete/'.$supportstaffs->id)!!}" class="sa-warning"><button type="button" class="btn btn-round btn-danger">{{ trans('app.Delete')}}</button></a>
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
<!-- End page content -->

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