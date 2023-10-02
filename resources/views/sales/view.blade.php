@extends('layouts.app')
@section('content')
		<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Sales',$userid)=='yes')
    <div class="right_col" role="main">
        <div class="">
			<div class="page-title">
              <div class="nav_menu">
                <nav>
				  <div class="nav toggle">
					<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp Sales Management</span></a> 
				  </div>
                  @include('dashboard.profile')
                </nav>
                </div>
            </div>
			@if(session('message'))
			<div class="row massage">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="checkbox checkbox-success checkbox-circle">
						<label for="checkbox-10 colo_success">  {{session('message')}} </label>
					</div>
				</div>
			</div>
			@endif
            <div class="row" >
				<div class="col-md-12 col-sm-12 col-xs-12" >
					<div class="x_content">
						<ul class="nav nav-tabs bar_tabs" role="tablist">
							<li role="presentation" class=""><a href="{!! url('/sales/list')!!}"><span class="visible-xs"></span> <i class="fa fa-list fa-lg">&nbsp;</i>List Of Sales</span></a></li>
							<li role="presentation" class=""><a href="{!! url('/sales/add')!!}"><span class="visible-xs"></span> <i class="fa fa-plus-circle fa-lg">&nbsp;</i>Add Sales</span></a></li>
			
							<li role="presentation" class="active"><a href="{!! url('/sales/list/'.$viewid)!!}"><span class="visible-xs"></span> <i class="fa fa-user">&nbsp; </i><b>View Sales</b></span></a></li>
						</ul>
					</div>
                </div>
				<div class="col-md-12" style="padding:0 50px;margin-top:20px;">
					<table width="90%" border="0">
						<tbody>
							<tr>
								<td width="70%">
									<img style="max-height:80px;" src="{{ URL::asset('public/employee/download (1).jpg') }}">
								</td>
								<td align="left" width="20%">
									<h5>Bill Number : {{ $sales->bill_no }} </h5>
									<h5>Date : {{ $sales->date }} </h5>
									<h5>Status : {{ $sales->status }}</h5>
									<h5>Sale Amount :{{ $sales->total_price }}</h5>
								</td>
							</tr>
						</tbody>
					</table>
					<hr/>
					<table width="90%" border="0">
						<tbody>
							<tr>
								<td width="70%" align="left">
									<h4>Payment To </h4>
								</td>
								<td align="left" width="20%">
									<h4>Bill To </h4>
								</td>
							</tr>
							<tr>
								<td valign="top" width="70%" align="left">
								{{ getCustomerAddress($sales->customer_id) }} 					</td>
								<td valign="top" width="20%" align="left">
									<b>Name : </b> {{ getCustomerName($sales->customer_id) }}<br><b>Remark : </b><br><b>Mobile : </b>{{ getCustomerMobile($sales->customer_id) }}	<br><b>Email : </b>{{ getCustomerEmail($sales->customer_id) }}				</td>
							</tr>
						</tbody>
					</table>
					<hr/>
					<table class="table table-bordered" width="90%" border="1" style="border-collapse:collapse;">
						<thead>
							<tr>
								<th class="text-center">Vehicle</th>
								<th class="text-center"> Model</th>
								<th class="text-center">Type </th>
								<th class="text-center">Color </th>
								<th class="text-center">Chasis No </th>
								<th class="text-center">Engine No </th>
							</tr>
						</thead>
						<tbody>
						
							<tr>
								<td class="text-center">{{ $vehicale->modelname }}</td>
								<td class="text-center">{{ $vehicale->modelname }}</td>
								<td class="text-center">{{ getVehicleType($vehicale->vehicletype_id) }}</td>
								<td class="text-center">{{ getVehicleColor($sales->color_id) }}</td>
								<td class="text-center">{{ $vehicale->chassiscno }}</td>
								<td class="text-center">{{ $vehicale->engineno }}</td>
							</tr>
						</tbody>
					</table>
					<hr/>
					<table class="table table-bordered" width="90%" border="1" style="border-collapse:collapse;">
						<thead>
							<tr>
								<th class="text-center">Tax Name</th>
								<th class="text-center">Tax (%)</th>
								<th class="text-center">Amount ( <?php echo getCurrencySymbols(); ?> )</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$total = 0;
							?>
							@if(!empty($taxes))
							@foreach($taxes as $taxes)
									<tr>
									<td class="text-center">{{ $taxes->tax_name }}</td>
									<td class="text-center">{{ $taxes->tax }}</td>
									<td class="text-center">{{ getTotalAmonut($taxes->tax,$taxes->tax_name,$sales->total_price) }} ( <?php echo getCurrencySymbols(); ?> )</td>
									<?php $total += getTotalAmonut($taxes->tax,$taxes->tax_name,$sales->total_price); ?>
									</tr>
							@endforeach
							@else
									<tr>
								<td colspan="3" class="text-center">No Data Available</td>
								</tr>
							@endif	
						</tbody>
					</table>
		
					<table class="table" style="border:1px solid #ddd"  width="90%">
						<tr>
							<td colspan="2" class="text-right" align="right">Total Tax Amount ( <?php echo getCurrencySymbols(); ?> ) :</td>
							<td colspan="2" class="text-center" align="center"><b><?php echo $total; ?></b></td>
						</tr>
					</table>
					<hr/>
					<h3 class="text-center">Statement Of Accounts</h3>
					<table class="table table-bordered" width="90%" border="1" style="border-collapse:collapse;">
						<thead>
							<tr>
								<th class="text-center">RTO / Registration / C.R. Temp Tax</th>
								<th class="text-center">Number Plate Charges</th>
								<th class="text-center">Muncipal Road Tax</th>
							</tr>
						</thead>
						<tbody>
						@if(!empty($rto))
							<tr>
								<td class="text-center">{{ $rto->registration_tax }}</td>
								<td class="text-center">{{ $rto->number_plate_charge }}</td>
								<td class="text-center">{{ $rto->muncipal_road_tax }}</td>
								<?php $total_rto_charge = getTotalRto($sales->vehicle_id) ;?>
							</tr>
						@else
							<tr>
								<td colspan="3" class="text-center">No Data Available</td>
							</tr>
						@endif	
						</tbody>
					</table>
					
					<table class="table" style="border:1px solid #ddd"  width="90%">
						<tr>
							<td colspan="2" class="text-right" align="right">Total Rto Charges Amount ( <?php echo getCurrencySymbols(); ?> ):</td>
							<td colspan="2" class="text-center" align="center"><b><?php echo $total_rto_charge; ?> </b></td>
						</tr>
					</table>
					
					<table class="table" style="border:1px solid #ddd"  width="90%">
						<tr>
							<?php $sales_price = $sales->total_price ?>
							<td colspan="2" class="text-right" align="right">Total Sales Amount ( <?php echo getCurrencySymbols(); ?> ):</td>
							<td colspan="2" class="text-center" align="center"><b><?php echo $total_rto_charge+$total+$sales_price; ?> </b></td>
						</tr>
					</table>
				</div>
            </div>
        </div>
    </div>
@else
	<div class="right_col" role="main">
		<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
            <div class="nav toggle" style="padding-bottom:16px;">
				<span class="titleup">&nbsp {{ trans('app.You are not authorize this page.')}}</span>
            </div>
        </div>
	</div>
	
@endif   
		 <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
        <!-- /page content -->
<script>
 $('.sa-warning').click(function(){
	
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