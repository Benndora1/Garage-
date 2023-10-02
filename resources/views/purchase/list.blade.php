@extends('layouts.app')
@section('content')

<!-- page content -->	
    <div class="right_col" role="main">
		<div id="purchaseview" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
		<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header"> 
						<a href=""><button type="button" class="close">&times;</button></a>
						<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Purchase')}}</h4>
						
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
						<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Purchase')}}</span></a>
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
							@can('purchase_view')
								<li role="presentation" class="active"><a href="{!! url('/purchase/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b> {{ trans('app.Purchase List')}}</b></a></li>
							@endcan

							@can('purchase_add')
								<li role="presentation" class=""><a href="{!! url('/purchase/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i> {{ trans('app.Add Purchase')}}</a></li>
							@endcan
						</ul>
					</div>
					<div class="x_panel bgr">
						<table id="datatable" class="example table table-striped responsive-utilities jambo_table" style="margin-top:20px; width:100%;">
							<thead>
								<tr>
									<th>{{ trans('app.#')}}</th>
									<th>{{ trans('app.Purchase Code')}}</th>
									<th>{{ trans('app.Supplier Name')}}</th>
									<th>{{ trans('app.Email')}}</th>
									<th>{{ trans('app.Mobile')}}</th>
									<th>{{ trans('app.Date')}}</th>
									<th>{{ trans('app.Action')}}</th>
								</tr>
							</thead>
							<tbody>
							<?php $i=1;?>
							@foreach($purchase as $purchases)
							<tr>
								<td>{{ $i }}</td>
								<td>{{$purchases->purchase_no}}</td>
								<td>{{ getCompanyNames($purchases->supplier_id)}}</td>
								<td>{{$purchases->email}}</td>
								<td>{{$purchases->mobile}}</td>
								<td>{{ date(getDateFormat(),strtotime($purchases->date)) }}</td>
								<td> 
									@can('purchase_view')
										<button type="button" data-toggle="modal" data-target="#purchaseview" purchaseid="{{ $purchases->id }}" url="{!! url('/purchase/list/modalview') !!}" class="btn btn-round btn-info purchasesave">{{ trans('app.View')}}</button>
									@endcan
									@can('purchase_edit')
										<a href="{!! url ('/purchase/list/edit/'.$purchases->id) !!}"> <button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
									@endcan

									@can('purchase_delete')
										<a url="{!! url('/purchase/list/delete/'.$purchases->id)!!}" class="sa-warning buttonOfAtag"> <button type="button" class="btn btn-round btn-danger threeBtnInOneLine">{{ trans('app.Delete')}}</button></a>
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

<!-- /page content -->
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
<script type="text/javascript">

$( document ).ready(function(){

$('body').on('click', '.purchasesave', function() {	  
	  $('.modal-body').html("");
	   
       var purchaseid = $(this).attr("purchaseid");
	   
	   var url = $(this).attr('url');
	
       $.ajax({
       type: 'GET',
       url: url,
       data : {purchaseid:purchaseid},
       success: function (data)
		{            
			$('.modal-body').html(data.html);
	    },
		beforeSend:function()
		{
			$(".modal-body").html("<center><h2 class=text-muted><b>Loading...</b></h2></center>");
		},
		error: function(e) 
		{
		}
		});

       });
   });

</script>

@endsection