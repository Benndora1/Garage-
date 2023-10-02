<script src="{{ URL::asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script>
		 $(document).ready(function() {
		$('.adddatatable').DataTable({
			responsive: true,
			paging: false,
			lengthChange: false,
			searching: false,
			ordering: false,
			info: false,
			autoWidth: true,
			sDom: 'lfrtip'
		
		});
	});
</script>

	<div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ trans('app.Quotation Service Details')}}</h4>
    </div>
    <div class="modal-body" >
		<div class="row">
			<div class="col-md-7 col-sm-7 col-xs-12">
			
				<h3><?php echo $logo->system_name; ?></h3>
				<div class="col-md-6 col-sm-12 col-xs-12 printimg">
					<img src="{{ URL::asset('public/general_setting/'.$logo->logo_image)}}" width="200px" height="70px">
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 ">
					<p>
					<?php 
					echo $logo->address." ";
					echo "<br>".getCityName($logo->city_id);
					echo ", ".getStateName($logo->state_id);
					echo ", ".getCountryName($logo->country_id);
					echo "<br>".$logo->email;
					echo "<br>".$logo->phone_number; 
					?>
					</p>
				</div>
			</div>
			<div class="col-md-5 col-sm-5 col-xs-12">
				<table class="table">
				  <tbody>
					<tr>
					  <th>{{ trans('app.Name:')}}</th>
					  <td class="cname"><?php echo getCustomerName($custo_info->id) ?></td>
					</tr>
					<tr>
					  <th>{{ trans('app.Address:')}}</th>
					  <td class="cname"><?php echo getCustomerAddress($custo_info->id).", "?> <?php echo (getCityName($custo_info->city_id) != null) ? getCityName($custo_info->city_id) .", " : '' ?> <?php echo getStateName($custo_info->state_id).", ".getCountryName($custo_info->country_id); ?></td>
					</tr>
					<tr>
					  <th>{{ trans('app.Contact:')}}</th>
					  <td class="cname"><?php echo $custo_info->mobile_no;; ?></td>
					</tr>
					<tr>
					  <th>{{ trans('app.Email :')}}</th>
					  <td class="cname"><?php echo $custo_info->email; ?></td>
					</tr>
					@if(getCustomerCompanyName($custo_info->id) != "")
					<tr>
					  <th>{{ trans('app.Company Name')}}:</th>
					  <td class="cname"><?php echo getCustomerCompanyName($custo_info->id) ?></td>
					</tr>
					@endif
				  </tbody>
				 </table>
			</div>
		</div>		
		<hr>		
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">	
					<table class="table table-bordered adddatatable" width="100%">
						<thead>
							<tr>
								<th class="cname text-center">{{ trans('app.Quotation Number')}}</th>
								<!-- <th class="cname text-center">{{ trans('app.Coupon Number')}}</th> -->
								<th class="cname text-center">{{ trans('app.Vehicle Name')}}</th>
								<!-- <th class="cname text-center">{{ trans('app.Regi. No.')}}</th> -->
								<th class="cname text-center">{{ trans('app.Number Plate')}}</th>
								<!-- <th class="cname text-center">{{ trans('app.In Date')}}</th>
								<th class="cname text-center">{{ trans('app.Out Date')}}</th>							 -->
								<th class="cname text-center">{{ trans('app.Date')}}</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="cname text-center"><?php echo getQuotationNumber($service_data->job_no); ?></td>

								<td class="cname text-center"><?php echo getVehicleName($service_data->vehicle_id) ?></td>
								<td class="cname text-center"><?php echo getVehicleNumberPlate($service_data->vehicle_id);  ?></td>
								<td class="cname text-center"><?php echo date(getDateFormat(),strtotime($service_data->service_date)); ?></td>					
							</tr>
						</tbody>
					</table>
					<table class="table table-bordered adddatatable" width="100%">
						<thead>
							<tr>
								<!-- <th class="cname text-center">{{ trans('app.Assigned To')}}</th> -->
								<th class="cname text-center">{{ trans('app.Repair Category')}}</th>
								<th class="cname text-center">{{ trans('app.Service Type')}}</th>
								<th class="cname text-center">{{ trans('app.Details')}}</th>
							</tr>	
						</thead>
						<tbody>
							<tr>
								<!-- <td class="cname text-center"><?php echo getAssignedName($service_data->assign_to); ?></td> -->
								<td class="cname text-center"><?php echo ucwords($service_data->service_category); ?></td>
								<td class="cname text-center"><?php echo ucwords($service_data->service_type); ?></td>
								<td class="cname text-center"><?php echo $service_data->detail; ?></td>
							</tr>			
					  </tbody>
					</table>
					<hr>
					
					<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
						<tbody>
							<tr class="printimg">
								<td class="cname">{{ trans('app.SERVICE CHARGES')}}</td>
							</tr>
						</tbody>
					</table>
					<table class="table table-bordered adddatatable" width="100%" border="1" style="border-collapse:collapse;">
						<thead>				
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">{{ trans('app.Category')}}</th>
								<th class="text-center">{{ trans('app.Observation Point')}}</th>
								<th class="text-center">{{ trans('app.Product Name')}}</th>
								<th class="text-center">{{ trans('app.Price')}} (<?php echo getCurrencySymbols(); ?>)</th>
								<th class="text-center">{{ trans('app.Quantity')}} </th>
								<th class="text-center">{{ trans('app.Total Price')}} (<?php echo getCurrencySymbols(); ?>) </th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$total1=0;
							$i = 1 ; 
							if(!empty($all_data))
							{
								foreach($all_data as $ser_proc)
								{
								?>
								<tr>
									<td class="text-center cname"><?php echo $i++; ?></td>
									<td class="text-center cname"> <?php echo $ser_proc->category; ?></td>
									<td class="text-center cname"> <?php echo $ser_proc->obs_point; ?></td>
									<td class="text-center cname"> <?php echo getProduct($ser_proc->product_id); ?></td>
									<td class="text-center cname"> <?php echo $ser_proc->price; ?></td>
									<td class="text-center cname"><?php echo $ser_proc->quantity;?></td>
									<td class="text-center cname"><?php echo $ser_proc->total_price;?></td>
									
									<?php  if(!empty($ser_proc->total_price)){ $total1 += $ser_proc->total_price; }?>
								</tr>
								<?php 
								} 
							}
							?>
						 </tbody>
					</table>
					<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
							<tr class="printimg">
								<td class="cname" colspan="7">{{ trans('app.OTHER SERVICE CHARGES')}}</td>
							</tr>
					</table>
					<table class="table table-bordered adddatatable" width="100%" border="1" style="border-collapse:collapse;">
						<thead>	
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">{{ trans('app.Charge for')}}</th>
								<th class="text-center">{{ trans('app.Product Name')}}</th>
								<th class="text-center">{{ trans('app.Price')}} (<?php echo getCurrencySymbols(); ?>)</th>
								<th class="text-center">{{ trans('app.Total Price')}} (<?php echo getCurrencySymbols(); ?>) </th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$total2=0;
							$i = 1 ; 
							if(!empty($all_data2))
							{
								foreach($all_data2 as $ser_proc2)
								{
								?>
								<tr>
									<td class="text-center cname"><?php echo $i++; ?></td>
									<td class="text-center cname">{{ trans('app.Other Charges')}}</td>
									<td class="text-center cname"><?php echo $ser_proc2->comment; ?></td>
									<td class="text-center cname"><?php echo $ser_proc2->total_price; ?></td>
									<td class="text-center cname"><?php echo $ser_proc2->total_price; ?></td>
									<?php if(!empty($ser_proc2->total_price)){ $total2 += $ser_proc2->total_price; }  ?>
								</tr>
								<?php 
								}
							}
							?>
						</tbody>
					</table>

			<!-- MOT Test Service Charge Details Start -->
				<?php  
					//$service_data->mot_status
                  	$mot_status = $service_data->mot_status;
                  	$total3=0;
                           
                  	if ($mot_status == 1) 
                  	{
                  
               	?>

					<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
							<tr class="printimg">
								<td class="cname">{{ trans('app.MOT TEST SERVICE CHARGE') }}</td>
							</tr>
					</table>

					<table class="table table-bordered adddatatable" width="100%" border="1" style="border-collapse:collapse;">
						<thead>	
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">{{ trans('app.MOT Charge Detail') }}</th>
								<th class="text-center">{{ trans('app.MOT Test') }}</th>
								<th class="text-center">{{ trans('app.Price') }} (<?php echo getCurrencySymbols(); ?>)</th>
								<th class="text-center">{{ trans('app.Total Price') }} (<?php echo getCurrencySymbols(); ?>)</th>
							</tr>
						</thead>
						<tbody>
                        	<tr>
                           		<td class="text-center cname">1</td>
                           		<td class="text-center cname">{{ trans('app.MOT Testing Charges') }}</td>
                           		<td class="text-center cname">{{ trans('app.Completed') }}</td>
                           		<td class="text-center cname"><?php echo number_format((float) 0, 2); ?></td>
                           		<td class="text-center cname"><?php echo number_format((float) 0, 2); ?></td>
                           		<?php $total3 += 0;  ?>
                        	</tr>
                     	</tbody>
                  	</table>
               	<?php
                  	} 
               	?>
            <!-- MOT Test Service Charge Details Ebd -->


			<!-- For Custom Field -->
				@if(!empty($tbl_custom_fields))
					<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
							<tr class="printimg">
								<td class="cname" colspan="">{{ trans('app.OTHER INFORMATION') }}</td>
							</tr>
					</table>
						
					<table class="table table-bordered adddatatable" width="100%" border="1" style="border-collapse:collapse;">
						@foreach($tbl_custom_fields as $tbl_custom_field)	
							<?php 
								$tbl_custom = $tbl_custom_field->id;
								$userid = $service_data->id;
																		
								$datavalue = getCustomDataService($tbl_custom,$userid);
							?>
							@if($datavalue != null)
								<tr>
									<th class="text-center">{{$tbl_custom_field->label}} :</th>
									<td class="text-center cname">{{$datavalue}}</td>
								</tr>
							@else
								<tr>
									<th class="text-center">{{$tbl_custom_field->label}} :</th>
									<td class="text-center cname">{{ trans('app.Data not available') }}</td>
								</tr>
							@endif
						@endforeach
					</table>
				@endif
			<!-- For Custom Field End -->
					
					<hr>
                  	<table class="table table-bordered" style="border-collapse:collapse;">
                     	<tr>
                        	<td class="text-center cname"><b>{{ trans('app.Fix Service Charge')}}<b></td>
                        	<td class="text-right cname"><?php $fix = $service_data->charge; if(!empty($fix)) { echo number_format($fix, 2); } else { echo 'Free Service'; } ?></td>
                     </tr>
                     <tr>
                        <td class="text-right cname"><b>{{ trans('app.Total Service Amount')}} (<?php echo getCurrencySymbols(); ?>) :</b></td>
                        <td class="text-right cname" ><b><?php $total_amt = $total1 + $total2 + $total3 + $fix; echo number_format($total_amt, 2);  ?></b></td>
                     </tr>
                	<?php 
                        if(!empty($service_taxes))
                        {
                        	$all_taxes = 0;
                        	$total_tax = 0;
                        	foreach($service_taxes as $ser_tax)
                        	{ 
                        		//$taxes_to_count = preg_replace("/[^0-9,.]/", "", $ser_tax);
                        		$taxes_to_count = getTaxPercentFromTaxTable($ser_tax);
                        		$all_taxes = ($total_amt*$taxes_to_count)/100;  
                        		$total_tax +=  $all_taxes;
                    ?>
                   	<tr>
                    	<td class="text-right cname"><b><?php echo getTaxNameAndPercentFromTaxTable($ser_tax);  ?> (%) :</b></td>
                    	<td class="text-right cname" ><b><?php $all_taxes; echo number_format($all_taxes, 2); ?></b></td>
                 	</tr>
                 	<?php 
                    		}
                    	}
                    	else
                    	{
                    		$total_tax = 0;
                    	}
                    ?>
                     <!-- <tr>
                        <td class="text-right cname"><b>{{ trans('app.Tax')}} 15 (%)(<?php echo getCurrencySymbols(); ?>) :</b></td>
                        <td class="text-right cname" ><b><?php $tax = ($total_amt*15)/100; echo number_format($tax, 2);  ?></b></td>
                     </tr> -->
                     <tr>
                        <td class="text-right cname"><b>{{ trans('app.Grand Total')}} (<?php echo getCurrencySymbols(); ?>) :</b></td>
                        <td class="text-right cname" ><b><?php $grd_total = $total_amt+$total_tax; echo number_format($grd_total, 2);  ?></b></td>
                     </tr>
                  </table>
			</div>
		</div>
	</div>
	
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('app.Close')}}</button>
    </div>