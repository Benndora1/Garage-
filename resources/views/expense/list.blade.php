@extends('layouts.app')

@section('content')

<!-- page content -->
    <div class="right_col" role="main">
        <div class="">
        	<div class="page-title">
              	<div class="nav_menu">
            		<nav>
              			<div class="nav toggle">
                			<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Expense')}}</span></a>
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
	                   		@can('expense_view')
								<li role="presentation" class="active"><a href="{!! url('/expense/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Expense List')}}</b>
								</a></li>
							@endcan
							@can('expense_add')
								<li role="presentation" class=""><a href="{!! url('/expense/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg i">&nbsp;</i>{{ trans('app.Add Expense')}}
								</a></li>
							@endcan
							@can('expense_view')
								<li role="presentation" class="setSizeForMonthlyExpenseReportForSmallDevice"><a href="{!! url('/expense/month_expense')!!}"><span class="visible-xs"></span> <i class="fa fa-area-chart fa-lg">&nbsp;</i>{{ trans('app.Monthly Expense Reports')}}</a></li>			
							@endcan
						</ul>
					</div>
			 		
			 		<div class="x_panel table_up_div">
	                   <table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
	                      	<thead>
	                        	<tr>
									<th>#</th>
									<th>{{ trans('app.Expense Label')}}</th>
									<th>
										{{ trans('app.Expense Amount')}} (<?php echo getCurrencySymbols(); ?>)
									</th>
			                        <th>{{ trans('app.Status')}}</th>
									<th>{{ trans('app.Date')}}</th>

								<!-- Custom Field Data Label Name-->
									@if(!empty($tbl_custom_fields))
										@foreach($tbl_custom_fields as $tbl_custom_field)	
											<th>{{$tbl_custom_field->label}}</th>
										@endforeach
									@endif
								<!-- Custom Field Data End -->

									@canany(['expense_edit','expense_delete'])
			                        	<th>{{ trans('app.Action')}}</th>
			                        @endcan

		                        </tr>
	                      	</thead>

		                    <tbody>
							  	<?php $i = 1; ?>   
										
								@foreach ($expense as $expenses)
		                        <tr>
									<td>{{ $i }}</td>
									
									<td>{{ $expenses->main_label }}</td>
									
									<td>{{ getSumOfExpense($expenses->tbl_expenses_id) }}</td>
									
									@if($expenses->status==1)<td>Paid</td>
									
									@elseif($expenses->status==2)<td>Unpaid</td>
									
									@else($expenses->status==0)<td>Partially Paid</td>
									@endif
									
									<td>{{  date(getDateFormat(),strtotime($expenses->date)) }}</td>

								<!-- Custom Field Data Value-->
									@if(!empty($tbl_custom_fields))
				
										@foreach($tbl_custom_fields as $tbl_custom_field)	
											<?php 
												$tbl_custom = $tbl_custom_field->id;
												$userid = $expenses->tbl_expenses_id;
																						
												$datavalue = getCustomDataExpenses($tbl_custom,$userid);
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
									
									@canany(['expense_edit','expense_delete'])
		                        	<td>
		                        		@can('expense_edit')
											<a href="{!! url('/expense/edit/'.$expenses->tbl_expenses_id) !!}" ><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
										@endcan
										@can('expense_delete')
											<a url="{!! url('/expense/delete/'.$expenses->tbl_expenses_id) !!}" class="sa-warning">
											<button type="button" class="btn btn-round btn-danger dgr">{{ trans('app.Delete')}}</button></a>
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
<!-- delete Expense -->        
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