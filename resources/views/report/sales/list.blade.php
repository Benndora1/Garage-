@extends('layouts.app')
@section('content')

<?php include("vendors/chart/GoogleCharts.class.php"); ?>
<?php
$options = Array(
			'title' => $title_report,
			'titleTextStyle' => Array('color' => '#73879C','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'"Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif'),
			'legend' =>Array('position' => 'right',
					'textStyle'=> Array('color' => '#73879C','fontSize' => 14,'padding' => 30,'bold'=>true,'italic'=>false,'fontName' =>'"Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif')),
				
			'hAxis' => Array(
					'title' => $date_report,
					'titleTextStyle' => Array('color' => '#73879C','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'"Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif'),
					'textStyle' => Array('color' => '#73879C','fontSize' => 14),
					'maxAlternation' =>2,
					

			),
			'vAxis' => Array(
					'title' => $title,
				 'minValue' => 0,
					'maxValue' => 4,
					'width'=> 100,
				 'format' => '#',
					'titleTextStyle' => Array('color' => '#73879C','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'"Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif'),
					'textStyle' => Array('color' => '#73879C','fontSize' => 12)
			),
			 'colors'=>array(
				'#26b99a'
				),
			'bar' =>array(
				'groupWidth'=>'100'
				),
    


	);
foreach($Sales as $data)
{
	$datas = $data->counts;
	
}
	
	
$GoogleCharts = new GoogleCharts;
$chart_array=array();
		$chart_array[] = array('date','counts');
		foreach($Sales as $Saless)
			{
				$chart_array[] = array($Saless->date,(int)$Saless->counts);
			}
			
$chart = $GoogleCharts->load('column','sales_report')->get($chart_array,$options);
	
?>

<style>

</style>

<!-- CSS For Chart -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/js/49/css/tooltip.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/js/49/css/util.css') }}">

<div class="right_col" role="main">
	<div class="page-title">
        <div class="nav_menu">
		<nav>
			<div class="nav toggle">
				<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Report')}}</span></a>
			</div>
			@include('dashboard.profile')
        </nav>
        </div>
    </div>
	
	<div class="x_content">
        <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
			@can('report_view')
				<li role="presentation" class="active"><a href="{!! url('/report/salesreport')!!}" class="anchor_tag "><span class="visible-xs"></span> <i class="fa fa-tty image_icon"> </i> <b>{{ trans('app.Vehicle Sales')}}</b> </a></li>
			@endcan
			@can('report_view')
            	<li class=""><a href="{!! url('/report/servicereport') !!}" class="anchor_tag anchr"><i class="fa fa-slack image_icon"> </i> {{ trans('app.Services')}} </a></li>
			@endcan
			@can('report_view')
				<li class="setMarginForReportOnSmallDeviceProductStock"><a href="{!! url('/report/productreport') !!}" class="anchor_tag anchr"><i class="fa fa-product-hunt" aria-hidden="true"></i> {{ trans('app.Product Stock')}} </a></li>
			@endcan
			@can('report_view')
				<li class="setMarginForReportOnSmallDeviceProductUsage"><a href="{!! url('/report/productuses') !!}" class="anchor_tag anchr"><i class="fa fa-product-hunt" aria-hidden="true"></i> {{ trans('app.Product Usage')}} </a></li>
			@endcan
			@can('report_view')
				<li class="setMarginForReportOnSmallDeviceServiceByEmployee"><a href="{!! url('/report/servicebyemployee') !!}" class="anchor_tag anchr"><i class="fa fa-slack image_icon"> </i> {{ trans('app.Emp. Services')}}</a></li>
			@endcan
		</ul>
	</div>
	
	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <form method="post" action="{!! url('/report/record_sales')!!}" enctype="multipart/form-data"  class="form-horizontal upperform">
					
					<div class="col-md-6 col-sm-6 col-xs-12 form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
                        <label class="control-label col-md-3 col-sm-5 col-xs-12 currency" for="date">{{ trans('app.Start Date')}} <label class="color-danger">*</label>
                        </label>
                        <div class="col-md-9 col-sm-7 col-xs-12 input-group date start_date">
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                          
						 <input type="text" name="start_date" id="start_date" autocomplete="off" class="form-control" value="<?php if(!empty($s_date)) { echo date(getDateFormat(),strtotime($s_date));}else{ echo old('start_date'); }?>"  placeholder="<?php echo getDatepicker();?>" onkeypress="return false;" required />
						
                        </div>
						 @if ($errors->has('start_date'))
									<span class="help-block denger" style="margin-left: 27%;">
										<strong>{{ $errors->first('start_date') }}</strong>
									</span>
								@endif
                    </div>
					  
					<div class="col-md-6 col-sm-6 col-xs-12 form-group {{ $errors->has('end_date') ? ' has-error' : '' }}">
                        <label class="control-label col-md-3 col-sm-5 col-xs-12 currency" for="date">{{ trans('app.End Date')}} <label class="color-danger">*</label>
                        </label>
                        <div class="col-md-9 col-sm-7 col-xs-12 input-group date end_date">
						<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                          
						 <input type="text" name="end_date" id="end_date" autocomplete="off"  class="form-control" value="<?php if(!empty($e_date)) { echo date(getDateFormat(),strtotime($e_date));}else{ echo old('end_date'); }?>" placeholder="<?php echo getDatepicker();?>" required onkeypress="return false;" />
						 
                        </div>
						@if ($errors->has('end_date'))
							<span class="help-block denger" style="margin-left: 27%;">
										<strong>{{ $errors->first('end_date') }}</strong>
							</span>
						@endif
                    </div>   
                    
					<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                       <label class="control-label col-md-3 col-sm-5 col-xs-12"  for="option">{{ trans('app.Select salesman')}} </label>
                        </label>
                        <div class="col-md-9 col-sm-7 col-xs-12">
							<select class="form-control" name="s_salesman">
								<option value="all"<?php if($all_salesman=='all'){ echo 'selected'; } ?>>{{ trans('app.All')}}</option>
								@if(!empty($Select_salesman))
									@foreach ($Select_salesman as $Select_salesmans)
									 <option value="{{ $Select_salesmans->id }}" <?php if($Select_salesmans->id == $all_salesman) { echo  'selected'; } ?>>{{ $Select_salesmans->name }}</option>
									@endforeach
								@endif
							</select>
                        </div>
                    </div> 
					
					<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                       <label class="control-label col-md-3 col-sm-5 col-xs-12"  for="option">{{ trans('app.Select Customer')}} </label>
                        </label>
                        <div class="col-md-9 col-sm-7 col-xs-12">
							<select class="form-control" name="s_customer">
								<option value="all"<?php if($all_customer=='all'){ echo 'selected'; } ?>>{{ trans('app.All')}}</option>
								@if(!empty($Select_customer))
								@foreach ($Select_customer as $Select_customers)
								 <option value="{{ $Select_customers->id }}" <?php if($Select_customers->id == $all_customer) { echo  'selected'; } ?>>{{ $Select_customers->name }}</option>
								@endforeach
								@endif
							</select>
						 
                        </div>
                    </div> 
					
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-2 text-right">
							<button type="submit" class="btn btn-success colorname">{{ trans('app.Go')}}</button>
							<button type="button" onclick="myFunction()" class="btn btn-success" id="chartshow">{{ trans('app.View Chart')}}</button>
                        </div>
                    </div>
                    </form>
					
                </div>
            </div>
        </div>
    </div>
	
	
	@if(!empty($datas))
	<div class="row">
		<div id="chartdiv" style="visibility:hidden;height:0;float:left;width:100%;">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel tab_bottom">
					<div id="sales_report"></div>
				</div>
			</div>
		</div>
	</div>
	
	@endif
		
					
	<div class="row" >
        <div class="col-md-12 col-sm-12 col-xs-12">
		
			<div class="x_panel table_up_div">
                <table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
                    <thead>
                        <tr>
							<th>#</th>
							<th>{{ trans('app.Bill Number')}}</th>
							<th>{{ trans('app.Customer Name')}}</th>
							<th>{{ trans('app.Date')}}</th>
							<th>{{ trans('app.Vehicle Name')}}</th>
							<th>{{ trans('app.Salesman')}}</th>
							<th>{{ trans('app.Price')}} (<?php echo getCurrencySymbols(); ?>)</th>
						
							
							
                        </tr>
                    </thead>


                    <tbody>
					  <?php $i = 1; ?>   
						@if(!empty($salesreport))
						@foreach($salesreport as $salesreports)
						
                        <tr>
							<td>{{ $i }}</td>
							<td>{{	$salesreports->bill_no }}</td>
							<td>{{	getCustomerName($salesreports->customer_id) }}</td>
							<td>{{	 date(getDateFormat(),strtotime($salesreports->date)) }}</td>
							<td>{{	getVehicleName($salesreports->vehicle_id) }}</td>
							<td>{{	getAssignedName($salesreports->salesmanname) }}</td>
							<td>{{	$salesreports->price }}</td>
							
                        </tr>
                         <?php $i++; ?>
						@endforeach
						@endif
                    </tbody>
                </table>
            </div>
			
        </div>
         
    </div>
</div>
<!-- page content end -->
  
<!-- <script type="text/javascript" src="https://www.google.com/jsapi"></script>  -->

<!-- All Js file for Charts -->
<script type="text/javascript" src="{{ URL::asset('public/js/loader.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('public/js/49/loader.js') }}" defer="defer"></script>
<script type="text/javascript" src="{{ URL::asset('public/js/49/jsapi_compiled_default_module.js') }}" defer="defer"></script>
<script type="text/javascript" src="{{ URL::asset('public/js/49/jsapi_compiled_graphics_module.js') }}" defer="defer"></script>
<script type="text/javascript" src="{{ URL::asset('public/js/49/jsapi_compiled_ui_module.js') }}" defer="defer"></script>
<script type="text/javascript" src="{{ URL::asset('public/js/49/jsapi_compiled_corechart_module.js') }}" defer="defer"></script>


<script type="text/javascript">
	<?php if(!empty($chart)) {echo $chart; }?>
</script>
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
	
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

<!-- <script src="{{ URL::asset('build/js/jszip/3.1.3/jszip.min.js') }}" defer="defer"></script>
<script src="{{ URL::asset('build/js/pdfmake.min.js') }}" defer="defer"></script>
<script src="{{ URL::asset('build/js/vfs_fonts.js') }}" defer="defer"></script>
<script type="text/javascript" defer="defer" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="{{ URL::asset('build/js/vfs_fonts.js') }}"></script>


<!-- language change in user selected -->	
<script>
$(document).ready(function() {
    $('#datatable').DataTable( {
		responsive: true,
		dom: 'Bfrtip',
        buttons: [
            'pdf', 'print', 'excel'
        ],
        "language": {
			
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo getLanguageChange(); 
			?>.json"
        }
    } );
} );
</script>
	<script>
	
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
		
	</script>
	
	<script>
			function myFunction() {
				var x = document.getElementById("chartdiv");
				if (x.style.visibility === "hidden") {
					x.style.visibility = "inherit";
					x.style.height = "auto";
					x.style.float = "left";
					x.style.width = "100%";
					
				} else {
					x.style.visibility = "hidden";
					x.style.height = "0";
					x.style.float = "left";
					x.style.width = "100%";
				}
			}
	</script>

	
  
@endsection