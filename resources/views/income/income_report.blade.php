@extends('layouts.app')
@section('content')

<!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
               <div class="nav_menu">
		            <nav>
		             	<div class="nav toggle">
		                	<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Income')}}</span></a>
		              	</div>
		                @include('dashboard.profile')
		            </nav>
       			</div>
    		</div>
	
			@if(session('message'))
				<div class="row massage">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="checkbox checkbox-success checkbox-circle">
		                 	<label for="checkbox-10 colo_success"> {{session('message')}} </label>
		                </div>
					</div>
				</div>
			@endif
        </div>
		<div class="x_content">
            <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
            	@can('income_view')
					<li role="presentation" class=""><a href="{!! url('/income/list')!!}" class="anchr"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Income List')}}</a></li>
				@endcan
				@can('income_add')
					<li role="presentation" class=""><a href="{!! url('/income/add')!!}" class="anchr"><span class="visible-xs"></span> <i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add Income')}}</a></li>
				@endcan
				@can('income_view')
					<li role="presentation" class="active"><a href="{!! url('/income/month_income')!!}" class="anchr"><span class="visible-xs"></span> <i class="fa fa-area-chart fa-lg">&nbsp;</i><b>{{ trans('app.Monthly Income Reports')}}</b></a></li>
				@endcan
            </ul>
		</div>    
        
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   <div class="x_content">
                    <form method="post" action="{{ url('/income/income_report') }}" enctype="multipart/form-data"  class="form-horizontal upperform">
					<div class="col-md-12 col-xs-12 col-sm-12">
					  <h4><b>{{ trans('app.Income Details')}}</b></h4><hr style="margin-top:0px;">
					  <p class="col-md-12 col-xs-12 col-sm-12"></p>
					  </div>
                       
					   
					<div class="col-md-12">
						<div class="col-md-2">
							<b>{{ trans('app.Start Date')}} :</b> {{  date(getDateFormat(),strtotime($start_date)) }}
						</div>
						<div class="col-md-2">
							<b>{{ trans('app.End Date')}} :</b> {{  date(getDateFormat(),strtotime($end_date)) }}
						</div>
					</div>
					  
					  
					  
				<div class="x_panel table_up_div">
                   	<table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
                    	<thead>
	                    	<tr>
								<th>#</th>
							 	<th>{{ trans('app.Customer Name')}}</th>
							 	<th>{{ trans('app.Invoice Number')}}</th>
							 	<th>{{ trans('app.Amount')}}( <?php echo getCurrencySymbols(); ?> )</th>
							 	<th>{{ trans('app.Status')}}</th>
							 	<th>{{ trans('app.Date')}}</th>
							 	<th>{{ trans('app.Main Label')}}</th>
							 	<th>{{ trans('app.Income Label')}}</th>                        
	                        </tr>
                      	</thead>

                      	<tbody>
					  		<?php $i = 1; ?>   
							@if(!empty($month_income))
							@foreach ($month_income as $month_incomes)
                        	<tr>
								<td>{{ $i }}</td>
								<td>{{ getCustomerName($month_incomes->customer_id) }}</td>
								<td>{{ $month_incomes->invoice_number }}</td>
								<td>{{ $month_incomes->income_amount }}</td>
								@if($month_incomes->status==2)<td>Paid</td>
							
								@elseif($month_incomes->status==0)<td>Unpaid</td>
							
								@else($month_incomes->status==1)<td>Partially Paid</td>
								@endif
								<td>{{  date(getDateFormat(),strtotime($month_incomes->date)) }}</td>
								<td>{{ $month_incomes->main_label }}</td>
								<td>{{ $month_incomes->income_label }}</td>
                        	</tr>
                         	<?php $i++; ?>
								@endforeach	
							@endif
                      	</tbody>
                    </table>
                </div>
					  
				<input type="hidden" name="_token" value="{{csrf_token()}}">
            </form>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script>
    $('.datepicker').datetimepicker({
       format: "yyyy-mm-dd",
		autoclose: 1,
		minView: 2,
    });
</script>
@endsection