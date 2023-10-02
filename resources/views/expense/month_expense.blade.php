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
		</div>
		<div class="x_content">
            <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
            	@can('expense_view')
					<li role="presentation" class=""><a href="{!! url('/expense/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Expense List')}}</a></li>
				@endcan
				@can('expense_add')
					<li role="presentation" class=""><a href="{!! url('/expense/add')!!}"><span class="visible-xs"></span> <i class="fa fa-plus-circle fa-lg i">&nbsp;</i>{{ trans('app.Add Expense')}}</a></li>
				@endcan
				@can('expense_view')
					<li role="presentation" class="active setSizeForMonthlyExpenseReportForSmallDevice"><a href="{!! url('/expense/month_expense')!!}"><span class="visible-xs"></span> <i class="fa fa-area-chart fa-lg">&nbsp;</i><b>{{ trans('app.Monthly Expense Reports')}}</b></a></li>
				@endcan
            </ul>
		</div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   <div class="x_content">
                    <form id="expenseMonthReportForm" method="post" action="{{ url('/expense/expense_report') }}" enctype="multipart/form-data"  class="form-horizontal upperform addMonthExpenseForm">
					<div class="col-md-12 col-xs-12 col-sm-12">
					  <h4><b>{{ trans('app.Expenses Details')}}</b></h4><hr style="margin-top:0px;">
					  <p class="col-md-12 col-xs-12 col-sm-12"></p>
					  </div>					  
                       
					  <div class="col-md-12 col-sm-12 col-xs-12 form-group  {{ $errors->has('start_date') ? ' has-error' : '' }} my-form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="st_date">{{ trans('app.Start Date') }} <label class="text-danger">*</label> 
                        </label>
						
                       <div class="col-md-5 col-sm-5 col-xs-12 input-group date start_date">
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                          <input type="text" id="start_date" name="start_date" autocomplete="off" class="form-control expStartDate" value="{{ old('start_date') }}" placeholder="<?php echo getDatepicker();?>" onkeypress="return false;"  required  />
                        </div>
							@if ($errors->has('start_date'))
									<span class="help-block denger" style="margin-left: 27%;">
										<strong>{{ $errors->first('start_date') }}</strong>
									</span>
								@endif
                      </div>
					  <div class="col-md-12 col-sm-12 col-xs-12 form-group {{ $errors->has('end_date') ? ' has-error' : '' }} my-form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="end_date">{{ trans('app.End Date') }} <label class="text-danger">*</label> 
                        </label>
						
						<div class="col-md-5 col-sm-5 col-xs-12 input-group date end_date">
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                          <input type="text" id="end_date" name="end_date" autocomplete="off" class="form-control expenseEndDate"  
                          value="{{ old('end_date') }}" placeholder="<?php echo getDatepicker();?>" onkeypress="return false;"  required  />
                        </div>
								@if ($errors->has('end_date'))
									<span class="help-block" style="margin-left: 27%;">
										<strong>{{ $errors->first('end_date') }}</strong>
									</span>
								@endif
                      </div>
					  <input type="hidden" name="_token" value="{{csrf_token()}}">
                     
                      <div class="form-group col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-9 col-sm-9 col-xs-12 text-center">
						  <a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
                          <button type="submit" class="btn btn-success addMonthExpenseSubmitButton">{{ trans('app.Submit')}}</button>
                        </div>
                      </div>

                    </form>
					</div>
              </div>
			  
            </div>
           </div>
		 </div> 
<!-- page content end -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<!-- datetimepicker-->
	<script>
		
	$(document).ready(function(){
	
    $(".start_date,.input-group-addon").click(function(){
			
		var dateend = $('#end_date').val('');
		
		});
		
		$(".start_date").datetimepicker({
			format: "<?php echo getDatepicker(); ?>",
			 minView: 2,
			autoclose: 1,
		}).on('changeDate', function (selected) {
			var startDate = new Date(selected.date.valueOf());
		
			$('.end_date').datetimepicker({
				format: "<?php echo getDatepicker(); ?>",
				 minView: 2,
				autoclose: 1,
			
			}).datetimepicker('setStartDate', startDate); 
		})
		.on('clearDate', function (selected) {
			 $('.end_date').datetimepicker('setStartDate', null);
		})
		
			$('.end_date').click(function(){
				
			var date = $('#start_date').val(); 
			if(date == '')
			{
				swal('First Select Start Date');
			}
			else{
				$('.end_date').datetimepicker({
				format: "<?php echo getDatepicker(); ?>",
				 minView: 2,
				autoclose: 1,
				})
				
			}
			});
});	
</script>

<script>
	/*If select box have value then error msg and has error class remove*/

	$(document).ready(function(){
   		$('.expStartDate').on('change',function(){

      		var dateValue = $(this).val();

	      	if (dateValue != null) {
	         	$('#start_date-error').css({"display":"none"});
	      	}

	      	if (dateValue != null) {
	         	$(this).parent().parent().removeClass('has-error');
	      	}
	   	});
   	});


   	$(document).ready(function(){
   		$('.expenseEndDate').on('change',function(){

      		var dateValue = $(this).val();

	      	if (dateValue != null) {
	         	$('#end_date-error').css({"display":"none"});
	      	}

	      	if (dateValue != null) {
	         	$(this).parent().parent().removeClass('has-error');
	      	}
	   	});
   	});
</script>

<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\StoreExpenseMonthlyReportFormRequest', '#expenseMonthReportForm'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

<!-- Form submit at a time only one -->
<script type="text/javascript">
    /*$(document).ready(function () {
        $('.addMonthExpenseSubmitButton').removeAttr('disabled'); //re-enable on document ready
    });
    $('.addMonthExpenseForm').submit(function () {
        $('.addMonthExpenseSubmitButton').attr('disabled', 'disabled'); //disable on any form submit
    });

    $('.addMonthExpenseForm').bind('invalid-form.validate', function () {
      $('.addMonthExpenseSubmitButton').removeAttr('disabled'); //re-enable on form invalidation
    });*/
</script>

@endsection