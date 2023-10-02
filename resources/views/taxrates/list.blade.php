@extends('layouts.app')
@section('content')

<!-- page content start-->
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="nav_menu">
          <nav>
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Account Tax')}}</span></a>
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
            <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
              @can('taxrate_view')
                <li role="presentation" class="active"><a href="{!! url('/taxrates/list')!!}"><span class="visible-xs"></span> <i class="fa fa-list fa-lg">&nbsp;</i> <b>{{ trans('app.List Account Tax')}}</b></a></li>
              @endcan
              @can('taxrate_add')
                <li role="presentation" class="setMarginForAddAccountTaxForSmallDevices"><a href="{!! url('/taxrates/add')!!}"><span class="visible-xs"></span> <i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add Account Tax')}}</a></li>
              @endcan
            </ul>
          </div>
        <div class="x_panel">
        <table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
          <thead>
            <tr>
              <th>#</th>             
              <th>{{ trans('app.Account Tax Name') }}
              <th>{{ trans('app.Tax Rates') }}(%)</th>

              @canany(['taxrate_edit','taxrate_delete'])
                <th>{{ trans('app.Action')}}</th>
              @endcanany

            </tr>
          </thead>
          <tbody>
            <?php $i=1;?>
            @foreach($account as $accounts)
              <tr>
                <td>{{ $i }}</td>
                <td>{{ $accounts->taxname }}</td>
                <td>{{ $accounts ->tax }}</td>

                @canany(['taxrate_edit','taxrate_delete'])
                  <td> 
                    @can('taxrate_edit')
                      <a href="{!! url ('/taxrates/list/edit/'.$accounts->id) !!}"> <button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
                    @endcan
                    @can('taxrate_delete')           
                      <a url="{!! url('/taxrates/list/delete/'.$accounts->id)!!}" class="sa-warning"> <button type="button" class="btn btn-round btn-danger dgr">{{ trans('app.Delete')}}</button></a>
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
<!-- page content end-->
  
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
<!-- delete taxrates -->
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