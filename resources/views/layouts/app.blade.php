<!DOCTYPE html>
<html dir="" lang="en" >
<head>
    <meta content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	
	<link rel="icon" href="{{ URL::asset('fevicol.png') }}" type="image/gif" sizes="16x16">
    <title>{{ getNameSystem() }}</title>
	
	
    <!-- Bootstrap -->
    <link href= "{{ URL::asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ URL::asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
	 <!-- iCheck -->
    <link href="{{ URL::asset('vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <!-- <link href="{{ URL::asset('vendors/google-code-prettify/bin/prettify.min.css') }}" rel="stylesheet"> -->
    <!-- Select2 -->
    <link href="{{ URL::asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
   
    
	<!-- FullCalendar -->
    <link href="{{ URL::asset('vendors/fullcalendar/dist/fullcalendar.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('vendors/fullcalendar/dist/fullcalendar.print.css')}}" rel="stylesheet" media="print">
	<!-- bootstrap-daterangepicker -->
    <link href="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }} " rel="stylesheet">
    <link href="{{ URL::asset('vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
	<!-- dropify CSS -->
	<link rel="stylesheet" href="{{ URL::asset('vendors/dropify/dist/css/dropify.min.css') }}">
	
    <!-- Custom Theme Style -->
    <link href="{{ URL::asset('build/css/custom.min.css') }} " rel="stylesheet">
	
	 <!-- Own Theme Style -->
    <link href="{{ URL::asset('build/css/own.css') }} " rel="stylesheet">
	

	<!-- Our Custom stylesheet -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/responsive_styles.css') }}">

	<!-- MoT Custom stylesheet -->
	<link rel="stylesheet" type="text/css" href=" {{ URL::asset('public/css/custom_mot_styles.css') }} ">
   <!-- Datatables -->
    
    <link href="{{ URL::asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
	 <link href="{{ URL::asset('build/css/dataTables.responsive.css') }} " rel="stylesheet">
	 <link href="{{ URL::asset('build/css/dataTables.tableTools.css') }} " rel="stylesheet">
    <!-- <link href="{{ URL::asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet"> -->
    
    <link href="{{ URL::asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
	
	 <!-- AutoComplete CSS -->
	<link href="{{ URL::asset('build/css/themessmoothness.css') }}" rel="stylesheet">
	 <!-- Multiselect CSS -->
	<link href="{{ URL::asset('build/css/multiselect.css') }}" rel="stylesheet">
	 <!-- Slider Style -->
	<!-- <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/google_api_font.css') }}">
	@if(getValue()=='rtl')
	<link href="{!! URL::asset('build/css/bootstrap-rtl.min.css'); !!}" rel="stylesheet" id="rtl"/>
	@else
		
	@endif
	
	<!-- sweetalert -->
	<link href="{{ URL::asset('vendors/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
	
	<!-- <link href="{!! URL::asset('build/dist/css/select2.min.css'); !!}" rel='stylesheet' type='text/css'> -->
	<style>
	@media print
   {
     
      .noprint
      {
        display:none
      }
   }
	</style>
  </head>

<body id="app-layout" class="nav-md">
   <div class="container body">
    <div class="main_container">
       <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title hidden-xs" style="border: 0; ">
              <a href="{!! url('/')!!}" class="site_title">
			  <img src="{{ URL::asset('public/general_setting/'.getLogoSystem())}}"
			   class="profilepic" ></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
				 @if(!empty(Auth::user()->id))
					 @if(Auth::user()->role=='admin')
						  <a href="{!! url('/setting/profile')!!}"><img src="{{ URL::asset('public/admin/'.Auth::user()->image)}}" alt="..." class="img-circle profile_img"></a>
					@endif
					 @if(Auth::user()->role=='Customer')
						 <a href="{!! url('/setting/profile')!!}"><img src="{{ URL::asset('public/customer/'.Auth::user()->image)}}" alt="..." class="img-circle profile_img"></a>
					@endif
					
					@if(Auth::user()->role=='Supplier')
						 <a href="{!! url('/setting/profile')!!}"><img src="{{ URL::asset('public/supplier/'.Auth::user()->image)}}" alt="..." class="img-circle profile_img"></a>
					@endif
					
					@if(Auth::user()->role=='employee')
						 <a href="{!! url('/setting/profile')!!}"><img src="{{ URL::asset('public/employee/'.Auth::user()->image)}}" alt="..." class="img-circle profile_img"></a>
					@endif
					
					 @if(Auth::user()->role=='accountant')
						 <a href="{!! url('/setting/profile')!!}"><img src="{{ URL::asset('public/accountant/'.Auth::user()->image)}}" alt="..." class="img-circle profile_img"></a>
					@endif
					
					@if(Auth::user()->role=='supportstaff')
						 <a href="{!! url('/setting/profile')!!}"><img src="{{ URL::asset('public/supportstaff/'.Auth::user()->image)}}" alt="..." class="img-circle profile_img"></a>
					@endif
				@endif
              </div>
              <div class="profile_info">
                <span>{{ trans('app.Welcome')}}</span>
				 @if(!empty(Auth::user()->id))
                <h2>{{ Auth::user()->name }}</h2>
				@endif
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
					@can('dashboard_view')
                  		<li><a href="{!! url('/') !!}"><i class="fa fa-home"></i> {{ trans('app.Dashboard')}} </a> </li>
				  	@endcan
				  
					@canany(['supplier_view','product_view','purchase_view','stock_view'])
				   	<li><a><i class="fa fa-user image_icon"></i> {{ trans('app.Inventory')}} <span class="fa fa-chevron-down"></span></a>
                    	<ul class="nav child_menu">
                    		@can('supplier_view')
							<li><a href="{!! url('/supplier/list')!!}">{{ trans('app.Supplier')}}</a></li>
							@endcan
							@can('product_view')
							<li><a href="{!! url('/product/list') !!}">{{ trans('app.Product')}}</a></li>
							@endcan
							@can('purchase_view')
							<li><a href="{!! url('/purchase/list')!!}">{{ trans('app.Purchase')}}</a></li>
							@endcan
							@can('stock_view')
							<li><a href="{!! url('/stoke/list')!!}">{{ trans('app.Stock')}}</a></li>
							@endcan
                    	</ul>
				  	</li>
				 	@endcanany
				 	
				 
                	@canany(['customer_view','employee_view','supportstaff_view','accountant_view'])
				 	<li><a><i class="fa fa-edit"></i> {{ trans('app.Users')}} <span class="fa fa-chevron-down"></span></a>
	                    <ul class="nav child_menu">
							@can('customer_view')
	                      	<li><a href="{!! url('/customer/list')!!}">{{ trans('app.Customers')}}</a></li>
						 	@endcan

						 	@can('employee_view')
	                      		<li><a href="{!! url('/employee/list')!!}">{{ trans('app.Employees')}}</a></li>
	                      	@endcan
					     
						 	@can('supportstaff_view')
						  	<li><a href="{!! url('/supportstaff/list')!!}">{{ trans('app.Support Staff')}}</a></li>
					     	@endcan
						 
						 	@can('accountant_view')
	                      		<li><a href="{!! url('/accountant/list')!!}">{{ trans('app.Accountant')}}</a></li>
					     	@endcan					  
	                    </ul>
                  	</li>
                	@endcanany
				
					@canany(['vehicle_view','vehicletype_view','vehiclebrand_view','colors_view'])
                	<li><a><i class="fa fa-motorcycle"></i> {{ trans('app.Vehicles')}} <span class="fa fa-chevron-down"></span></a>
                    	<ul class="nav child_menu">
                    		@can('vehicle_view')
                      			<li><a href="{!! url('/vehicle/list') !!}">{{ trans('app.List Vehicle')}}</a></li>
                      		@endcan
                      		@can('vehicletype_view')
                      			<li><a href="{!! url('/vehicletype/list') !!}">{{ trans('app.List Vehicle Type')}}</a></li>
                      		@endcan
                      		@can('vehiclebrand_view')
                      			<li><a href="{!! url('/vehiclebrand/list') !!}">{{ trans('app.List Vehicle Brand')}}</a></li>
                      		@endcan
                      		@can('colors_view')
					   			<li><a href="{!! url('/color/list') !!}"> {{ trans('app.Colors')}}</a></li>
					   		@endcan
                    	</ul>
                	</li>
                	@endcanany

					@can('service_view')
                  		<li><a href="{!! url('/service/list') !!}"><i class="fa fa-slack image_icon"></i>{{ trans('app.Services')}}</a></li>
					@endcan

					@can('quotation_view')
						<li><a href="{!! url('/quotation/list') !!}"><i class="fa fa-file-text-o"></i> {{ trans('app.Quotation')}} </a> </li>
					@endcan

					@can('invoice_view')
                  		<li><a href="{!! url('/invoice/list') !!}" ><i class="fa fa-file-text-o"></i>{{ trans('app.Invoices')}}</a></li>
					@endcan

					@canany(['jobcard_view','gatepass_view'])			
                	<li><a><i class="fa fa-table"></i> {{ trans('app.Job Card')}} <span class="fa fa-chevron-down"></span></a>
                    	<ul class="nav child_menu">
                      	@can('jobcard_view')
                      		<li><a href="{!! url('/jobcard/list')!!}">{{ trans('app.Job Card')}}</a></li>
                      	@endcan
                      	@can('gatepass_view')
                      		<li><a href="{!! url('/gatepass/list')!!}">{{ trans('app.Gate Pass')}}</a></li>
                      	@endcan
                    	</ul>
                	</li>
                	@endcanany
				
					@canany(['taxrate_view','paymentmethod_view','income_view','expense_view'])
					<li><a><i class="fa fa-tasks image_icon"></i>{{ trans('app.Accounts & Tax Rates')}} <span class="fa fa-chevron-down"></span></a>
                    	<ul class="nav child_menu">
                    	@can('taxrate_view')
                      		<li><a href="{!! url('/taxrates/list') !!}">{{ trans('app.List Tax Rates')}}</a></li>
                      	@endcan
                      	@can('paymentmethod_view')
                      		<li><a href="{!! url('/payment/list') !!}">{{ trans('app.List Payment Method')}} </a></li>
                      	@endcan
                      	@can('income_view')
					  		<li><a href="{!! url('/income/list')!!}">{{ trans('app.Income')}}</a></li>
					  	@endcan
					  	@can('expense_view')
                      		<li><a href="{!! url('/expense/list')!!}">{{ trans('app.Expenses')}}</a></li>
                      	@endcan
                    	</ul>
                	</li>
                	@endcanany

					@can('sales_view')
						<li><a href="{!! url('/sales/list') !!}"><i class="fa fa-tty image_icon"></i>{{ trans('app.Vehicle Sale')}} </a> </li>
					@endcan

					@can('salespart_view')
						<li><a href="{!! url('/sales_part/list') !!}"><i class="fa fa-tty image_icon"></i>{{ trans('app.Part Sales')}} </a> </li>
					@endcan

					@can('rto_view')
				  		<li><a href="{!! url('/rto/list') !!}"><i class="fa fa-clone"></i>{{ trans('app.Compliance')}}</a></li>
					@endcan

					@can('report_view')
				  		<li><a href="{!! url('/report/salesreport') !!}"><i class="fa fa-bar-chart-o"></i>{{ trans('app.Reports')}} </a></li>
					@endcan
				 
					@can('emailtemplate_view')
				  		<li><a href="{!! url('/mail/mail') !!}"><i class="fa fa-envelope"></i>{{ trans('app.Email Templates')}}</a></li>
					@endcan
				 
					@can('customfield_view')
				  		<li><a href="{!! url('/setting/custom/list') !!}"><i class="fa fa-user"></i>{{ trans('app.Custom Fields')}}</a> </li>
					@endcan
				
					@can('observationlibrary_view')
				 		<li><a href="{!! url('/observation/list') !!}" ><i class="fa fa-universal-access"></i>{{ trans('app.Observation library')}}</a></li> 
					@endcan
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
			
				@if(getActiveAdmin(Auth::User()->id) == 'yes')
					<a data-toggle="tooltip" data-placement="top" href="{!! url('/setting/general_setting/list') !!}" title="Settings"> <span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>
				@else
					@if(Gate::allows('generalsetting_view'))
						@can('generalsetting_view')
						<a data-toggle="tooltip" data-placement="top" href="{!! url('/setting/general_setting/list') !!}" title="Settings"> <span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>
						@endcan
					@else
						@can('timezone_view')
							<a data-toggle="tooltip" data-placement="top" href="{!! url('/setting/timezone/list') !!}" title="Settings"> <span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>
						@endcan
					@endif
				@endif
             
              <a title="Logout" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
				</form>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>
        <!-- top navigation -->
        <div class="top_nav">
         
        <!-- /top navigation -->
		@yield('content')
		 
	   <footer>
          <div>
             <span class="footerbottom">{{ trans('app.All rights reserved by Garage System.')}}</span>
          </div>
         
        </footer>
   </div>
	
  </div>
 <!-- jQuery -->
    
    <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
	<script src="{{ URL::asset('build/js/jquery-ui.js') }}" defer="defer"></script>
    <!-- Bootstrap -->
    <script src="{{ URL::asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}" defer="defer"></script>
    <!-- FastClick -->
    <script src="{{ URL::asset('vendors/fastclick/lib/fastclick.js') }}" defer="defer"></script>
    <!-- NProgress -->
    <script src="{{ URL::asset('vendors/nprogress/nprogress.js') }}" defer="defer"></script>
    <!-- Chart.js -->
    <script src="{{ URL::asset('vendors/Chart.js/dist/Chart.min.js') }}" defer="defer"></script>
    <!-- jQuery Sparklines -->
    <script src="{{ URL::asset('vendors/jquery-sparkline/dist/jquery.sparkline.min.js') }}" defer="defer"></script>
    <!-- Flot -->
    <script src="{{ URL::asset('vendors/Flot/jquery.flot.js') }}" defer="defer"></script>
    <script src="{{ URL::asset('vendors/Flot/jquery.flot.pie.js') }}" defer="defer"></script>
    <script src="{{ URL::asset('vendors/Flot/jquery.flot.time.js') }}" defer="defer"></script>
    <script src="{{ URL::asset('vendors/Flot/jquery.flot.stack.js') }}" defer="defer"></script>
    <script src="{{ URL::asset('vendors/Flot/jquery.flot.resize.js') }}" defer="defer"></script>
    <!-- Flot plugins -->
    <script src="{{ URL::asset('vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}" defer="defer"></script>
    <script src="{{ URL::asset('vendors/flot-spline/js/jquery.flot.spline.min.js') }}" defer="defer"></script>
    <script src="{{ URL::asset('vendors/flot.curvedlines/curvedLines.js') }}" defer="defer"></script>
    <!-- DateJS -->
    <script src="{{ URL::asset('vendors/DateJS/build/date.js') }}" defer="defer"></script>
    <!-- FullCalendar -->
    <script src="{{ URL::asset('vendors/moment/min/moment.min.js')}}" defer="defer"></script>
    <script src="{{ URL::asset('vendors/fullcalendar/dist/fullcalendar.min.js')}}" defer="defer"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="{{ URL::asset('build/js/custom.min.js') }}" defer="defer"></script>
	<script src="{{ URL::asset('vendors/sweetalert/sweetalert.min.js')}}" defer="defer"></script>
	
	<script src="{{ URL::asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	
    <script src="{{ URL::asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}" defer="defer"></script>
    <script src="{{ URL::asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}" defer="defer"></script>
    <script src="{{ URL::asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}" defer="defer"></script>
    <script src="{{ URL::asset('vendors/datatables.net-buttons/js/buttons.flash.min.js') }}" defer="defer"></script>
    <script src="{{ URL::asset('vendors/datatables.net-buttons/js/buttons.html5.min.js') }}" defer="defer"></script>
    <script src="{{ URL::asset('vendors/datatables.net-buttons/js/buttons.print.min.js') }}" defer="defer"></script>
    <script src="{{ URL::asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}" defer="defer"></script>
    <script src="{{ URL::asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}" defer="defer"></script>
    <script src="{{ URL::asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}" defer="defer"></script>
    <script src="{{ URL::asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}" defer="defer"></script>
    <script src="{{ URL::asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}" defer="defer"></script>
	<!-- dropify scripts-->
	<script src="{{ URL::asset('vendors/dropify/dist/js/dropify.min.js')}}" defer="defer"></script>
	<script src="{{ URL::asset('vendors/iCheck/icheck.min.js')}}" defer="defer"></script>
	<!-- slider scripts-->
	
	<script src="{{ URL::asset('vendors/slider/jssor.slider.mini.js')}}" defer="defer"></script>
	<!-- bootstrap-daterangepicker -->
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}" defer="defer"></script>
	<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}" defer="defer"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}" defer="defer"></script>
    
	
	 <!-- Filter  -->
	
    <script src="{{ URL::asset('build/js/jszip.min.js') }}" defer="defer"></script>
    
	 <!-- Autocomplete Js  -->
	<script src="{{ URL::asset('build/js/jquery.circliful.min.js') }}" defer="defer"></script>
	
	<!-- Multiselect Js  -->
	<script src="{{ URL::asset('build/js/bootstrap-multiselect.js') }}" defer="defer"></script>

	<script src="{{ URL::asset('build/dist/js/select2.min.js') }}" type='text/javascript' defer="defer"></script>
	
	<!-- For form field validate Using Proengsoft -->
	<script type="text/javascript" src="{{ URL::asset('build/jquery-validate/1.19.2/jquery.validate.min.js') }}"></script>


	<script type="text/javascript">
		$(document).ready(function(){
			$('form').bind("keypress", function(e) {
			  if (e.keyCode == 13) {               
				e.preventDefault();
				return false;
			  }
			});
		});
	</script>

	<script type="text/javascript">
	    var csrf_token = document.querySelector("meta[name='csrf-token']").getAttribute("content");
	    function csrfSafeMethod(method) {
	        // these HTTP methods do not require CSRF protection
	        return (/^(GET|HEAD|OPTIONS)$/.test(method));
	    }
	    var o = XMLHttpRequest.prototype.open;
	    XMLHttpRequest.prototype.open = function(){
	        var res = o.apply(this, arguments);
	        var err = new Error();
	        if (!csrfSafeMethod(arguments[0])) {
	            this.setRequestHeader('anti-csrf-token', csrf_token);
	        }
	        return res;
	    };
 	</script>
</body>
</html>
