@extends('layouts.app')

@section('content')

<!-- page content start-->
        <div class="right_col" role="main">
          <div class="">
           <div class="page-title">
             <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Payment Method')}}</span></a>
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
                    @can('paymentmethod_view')
                      <li role="presentation" class="active"><a href="{!! url('/payment/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Payment Method List')}}</b></a></li>
                    @endcan
                    @can('paymentmethod_add')
                      <li role="presentation" class="setMarginForAddPaymentMethodForSmallDevices"><a href="{!! url('/payment/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg i_pay">&nbsp;</i>{{ trans('app.Add Payment Method')}}</a></li>
                    @endcan
                  </ul>
                </div>
                <div class="x_panel">
                  <table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th class="th_width">{{ trans('app.Payment Type') }}</th>

                          @canany(['paymentmethod_edit','paymentmethod_delete'])
                            <th>{{ trans('app.Action')}}</th>
                          @endcanany

                        </tr>
                      </thead>
                          
                      <?php $i=1;?>
                        @foreach($payment_methods as $payment_method)
                          <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $payment_method->payment }}</td>

                            @canany(['paymentmethod_edit','paymentmethod_delete'])
                            <td>
                                @can('paymentmethod_edit')
                                  <a href="{!! url ('/payment/list/edit/'.$payment_method->id) !!}"> <button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
                                @endcan

                                @can('paymentmethod_delete')
                                  <a url="{!! url('/payment/list/delete/'.$payment_method->id)!!}" class="sa-warning"> <button type="button" class="btn btn-round btn-danger dgr">{{ trans('app.Delete')}}</button></a>
                                @endcan
                            </td>
                            @endcanany
                          </tr>
                          <?php $i++; ?>
                        @endforeach
                        <tbody>
                        </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
<!-- Page content code end -->

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
<!-- delete payment -->
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