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
                   		@can('income_view')
							<li role="presentation" class="active"><a href="{!! url('/income/list')!!}" class="anchr"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Income List')}}</b></a></li>
						@endcan
						@can('income_add')
							<li role="presentation" class=""><a href="{!! url('/income/add')!!}" class="anchr"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add Income')}}</a></li>
						@endcan
						@can('income_view')
							<li role="presentation" class="setSizeForMonthlyIncomeReportForSmallDevice"><a href="{!! url('/income/month_income')!!}" class="anchr"><span class="visible-xs"></span> <i class="fa fa-area-chart fa-lg">&nbsp;</i>{{ trans('app.Monthly Income Reports')}}</a></li>
						@endcan
					</ul>
					</div>
			 	<div class="x_panel table_up_div">
                   <table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
                      <thead>
                        <tr>
							<th>#</th>
						 	<th>{{ trans('app.Customer Name')}}</th>
						 	<th>{{ trans('app.Invoice Number')}}</th>
						 	<th>{{ trans('app.Amount')}} (<?php echo getCurrencySymbols(); ?>)</th>
                         	<th>{{ trans('app.Payment Type')}}</th>
						 	<th>{{ trans('app.Date')}}</th>
                         	<th>{{ trans('app.Main Label')}}</th>

	                    <!-- Custom Field Data Label Name-->
							@if(!empty($tbl_custom_fields))
								@foreach($tbl_custom_fields as $tbl_custom_field)	
									<th>{{$tbl_custom_field->label}}</th>
								@endforeach
							@endif
						<!-- Custom Field Data End -->

							@canany(['income_edit','income_delete'])
                         		<th>{{ trans('app.Action')}}</th>
                         	@endcanany
                        </tr>
                      </thead>

                      <tbody>
					  <?php $i = 1; ?>   
								
						@foreach ($income as $incomes)
						@if(getSumOfIncome($incomes->tbl_income_id) != 0)
                        <tr>
							<td>{{ $i }}</td>							
							<td>{{ getCustomerName($incomes->customer_id) }}</td>
							<td>{{ $incomes->invoice_number }}</td>
							<td>{{ number_format(getSumOfIncome($incomes->tbl_income_id),2) }}</td>
							<td>{{ GetPaymentMethod($incomes->payment_type) }}</td>
							<td>{{  date(getDateFormat(),strtotime($incomes->date)) }}</td>
							<td>{{ $incomes->main_label }}</td>

						<!-- Custom Field Data Value-->
							@if(!empty($tbl_custom_fields))
		
								@foreach($tbl_custom_fields as $tbl_custom_field)	
									<?php 
										$tbl_custom = $tbl_custom_field->id;
										$userid = $incomes->tbl_income_id;
																				
										$datavalue = getCustomDataIncome($tbl_custom,$userid);
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

						<!-- Have Access Right then do it -->
							@canany(['income_edit','income_delete'])
                          	<td>
                          		@can('income_edit')
						  			<a href="{!! url('/income/edit/'.$incomes->tbl_income_id) !!}" ><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
						  		@endcan
						  		@can('income_delete')
						  			<a url="{!! url('/income/delete/'.$incomes->tbl_income_id) !!}" class="sa-warning"><button type="button" class="btn btn-round btn-danger dgr">{{ trans('app.Delete')}}</button></a>
						  		@endcan
						  	</td>
						  	@endcanany

                        </tr>
                        <?php $i++; ?>
						@endif
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
<!-- delete income -->
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