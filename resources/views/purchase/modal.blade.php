
<script language="javascript">
	function printdiv(el) {
		var restorepage = $('body').html();
		var printcontent = $('#' + el).clone();
		$('body').empty().html(printcontent);
		window.print();
		$('body').html(restorepage);
	}
</script>
		
<script>
		$(document).ready(function() {
			$('.adddatatable').DataTable({
				responsive: true,
				paging: false,
				lengthChange: false,
				ordering: false,
				searching: false,
				info: false,
				autoWidth: true,
				sDom: 'lfrtip'	
			});
		});
</script>
	
		<div id="div_print" style="margin-left:10px;" >
			
			<table width="100%" border="0">
				<tbody>
					<tr>
						<td align="left">
						<?php $nowdate = date("Y-m-d");?>
							{{ trans('app.Date')}} :<?php echo  date(getDateFormat(),strtotime($nowdate)); ?> </td>
					</tr>
				</tbody>
			</table> <br/><br/>
			<table width="100%" border="0" class="adddatatable">
				<tbody>
					<tr>
						<td width="70%">
						
							<span style="float:left;">
								<h4>{{$logo->system_name}}</h4>
								<img src="../public/vehicle/service.png" style="width: 235px; height: 90px;">

								<img src="../public/general_setting/<?php echo $logo->logo_image ?>" width="230px" height="70px" style="position: absolute; top: 125px; left: 25px;">
								
							</span>
						</td>
						<td width="30%">
							{{ trans('app.Purchase Number :')}} <?php echo $purchas->purchase_no; ?><br>							
							{{ trans('app.Date :')}}<?php echo  date(getDateFormat(),strtotime( $purchas->date)); ?> <br>				
						</td>
					</tr>
				</tbody>
			</table>
			<br/>
			</hr>
			<table width="100%" border="0" class="adddatatable">
				<thead>
					<tr>
						<td align="left" width="70%" style="float:left;">
							<h4>{{ trans('app.Other information')}}</h4>
						</td>
						<td align="left" style="" width="30%">
							<h4>{{ trans('app.Supplier Detail')}}</h4>
						</td>
					</tr>
					
				</thead>
				<tbody>
					<tr>
						<td valign="top" align="left" width="70%">
						
							{{ trans('app.Billing Address:')}} <?php echo $purchas->address; ?><br>	</td>				
						<td valign="top" align="left" width="30%">
							<span style="width:100%; float:left;">{{ trans('app.Name :')}} <?php echo getSupplierName($purchas->supplier_id); ?> </span>
							<span style="width:100%; float:left;">{{ trans('app.Email :')}}<?php echo $purchas->email; ?>	</span></td>
					</tr>
				</tbody>
			</table>
			</hr>
			<table class="adddatatable" width="100%" border="0">
				<tbody>
					<tr>
						<td align="left">
							<h4>{{ trans('app.Product Information')}}</h4>
						</td>					
					</tr>			
				</tbody>
			</table>
			<br/>
			<table class="table table-bordered adddatatable" width="100%" border="1" style="border-collapse:collapse;">			
				<thead>
					<tr>
						<th class="text-center">{{ trans('app.Category')}}</th>
						<th class="text-center">{{ trans('app.Product Number')}}</th>
						<th class="text-center">{{ trans('app.Manufacturer Name')}}</th>
						<th class="text-center">{{ trans('app.Product Name')}}</th>
						<th class="text-center">{{ trans('app.Qty')}}</th>
						<th class="text-center">
							{{ trans('app.Price')}} ( <?php echo getCurrencySymbols(); ?> )
						</th>
						<th class="text-center">
							{{ trans('app.Total Amount')}} ( <?php echo getCurrencySymbols(); ?> )
						</th>
					</tr>
				</thead>
				<tbody>
			   
					<?php 
					$total = 0;
					if(!empty($purchasdetails))
					{
					foreach($purchasdetails as $purchasdetail)
					{ ?>
						<tr>
							<td class="text-center">
								<?php echo getCategory($purchasdetail->category); ?>
							</td>
							<td class="text-center">
								<?php echo getProductcode($purchasdetail->product_id); ?>
							</td>
							<td class="text-center">
								<?php echo getProductName(getproducttyid($purchasdetail->product_id)); ?>
							</td>
							<td class="text-center">
								<?php echo getProduct($purchasdetail->product_id); ?>
							</td>
							<td class="text-center"><?php echo $purchasdetail->qty; ?></td>
							<td class="text-center"><?php echo $purchasdetail->price; ?></td>
							<td class="text-center"><?php echo $purchasdetail->total_amount; ?></td>
															
						</tr>
						<?php $total += $purchasdetail->total_amount; ?>
					<?php } } ?>
				</tbody>			
			</table>


			<!-- For Custom Field -->
				@if(!empty($tbl_custom_fields))
					<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
							<tr class="printimg">
								<td class="cname" colspan="2">{{ trans('app.OTHER INFORMATION') }}</td>
							</tr>
				
						@foreach($tbl_custom_fields as $tbl_custom_field)	
							<?php 
								$tbl_custom = $tbl_custom_field->id;
								$userid = $purchas->id;
																		
								$datavalue = getCustomDataPurchase($tbl_custom,$userid);
							?>

							@if($tbl_custom_field->type == "radio")
								@if($datavalue != "")
									<?php
										$radio_selected_value = getRadioSelectedValue($tbl_custom_field->id, $datavalue);
									?>
								
									<tr>
										<th class="text-center">{{$tbl_custom_field->label}} :</th>
										<td class="text-center cname">{{$radio_selected_value}}</td>
									</tr>
								@else
									<tr>
										<th class="text-center">{{$tbl_custom_field->label}} :</th>
										<td class="text-center cname">{{ trans('app.Data not available') }}</td>
									</tr>
								@endif
							@else
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
							@endif																
						@endforeach
					</table>
				@endif
			<!-- For Custom Field End -->

			<table class="table" style="border:1px solid #ddd" width="100%">
				<tbody>
					<tr>
						<td colspan="2" class="text-right" align="right">{{ trans('app.Grand Total')}} ( <?php echo getCurrencySymbols(); ?> ): &nbsp; &nbsp;<?php echo $total; ?> </td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="modal-footer">
			<!-- <input type="submit" class="btn btn-default"  onClick="printdiv('div_print');" value=" Print "> -->
			
			<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('app.Close')}}</button>
	
		</div>