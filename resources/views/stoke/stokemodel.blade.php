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

<script language="javascript">
			function printdiv(el) {
				
			var restorepage = $('body').html();
			var printcontent = $('#' + el).clone();
			$('body').empty().html(printcontent);
			window.print();
			$('body').html(restorepage);

			}
</script>	  
		<div id="stockprint" style="margin-left:10px;">
			<table width="100%" border="0">
				<tbody>
					<tr>
						<td align="left">
						<?php $nowdate = date("Y-m-d");?>
							{{ trans('app.Date')}} :<?php echo  date(getDateFormat(),strtotime($nowdate)); ?> </td>
					</tr>
				</tbody>
			</table> <br/><br/>
			<table width="100%" border="0">
				<tbody>
					<tr>
						<td width="70%">
						
							<span style="float:left;">
								<h4>{{$logo->system_name}}</h4>
								<img src="../public/vehicle/service.png" style="width: 245px; height: 90px;">
								
								<img src="../public/general_setting/<?php echo $logo->logo_image ?>" width="230px" height="70px" style="position: absolute; top: 120px; left: 25px;">
								
							</span>
						</td>
											
					</tr>
				</tbody>
			</table>
			<br/>
			</hr>
			<table width="100%" border="0">
				<tbody>
					<tr>
						<td align="left">
							<h4>{{ trans('app.Stock Information')}}</h4>
						</td>					
					</tr>				
				</tbody>
			</table>			
			<table class="table table-bordered adddatatable" width="100%" border="1" style="border-collapse:collapse;">			
				<thead>
					<tr>
						<th class="text-center">{{ trans('app.Category')}}</th>
						<th class="text-center">{{ trans('app.Product Code')}}</th>
						<th class="text-center">{{ trans('app.Manufacturer Name')}}</th>
						<th class="text-center">{{ trans('app.Product Name')}}</th>
						<th class="text-center">{{ trans('app.Purchase Date')}}</th>
						<th class="text-center">{{ trans('app.Supplier Name')}}</th>
						<th class="text-center">{{ trans('app.Quantity')}}</th>
					</tr>
				</thead>
				<tbody>
				
					<?php  $total=0;
					if(!empty($stockdata))
					{
						
					 foreach($stockdata as $stockdatas)
					 {?>
					<tr>
						<td class="text-center"><?php echo getCategory($stockdatas->category); ?></td>
						<td class="text-center"><?php echo $stockdatas->product_no; ?></td>
						<td class="text-center"><?php echo getProductName($stockdatas->product_type_id); ?></td>
						<td class="text-center"><?php echo $stockdatas->name; ?></td>
						<td class="text-center"><?php echo  date(getDateFormat(),strtotime($stockdatas->date)); ?></td>
						<td class="text-center"><?php echo getSupplierName($stockdatas->supplier_id);?></td>
						<td class="text-center"><?php echo $stockdatas->qty;?></td>						
						<?php $total += $stockdatas->qty;	?>							
					</tr>
					<?php } } ?>						
				</tbody>			
			</table>			
			<table class="table" style="border:1px solid #ddd" width="100%">
				<tbody>
					<tr>
						<td colspan="2" class="text-right" align="right">{{ trans('app.Total Stock:')}} &nbsp; &nbsp; <?php echo $total;?></td>			
					</tr>
				</tbody>
			</table>
			<table class="table" style="border:1px solid #ddd" width="100%">
				<tbody>
					<tr>
						<td colspan="2" class="text-right" align="right">{{ trans('app.Sales Stock:')}} &nbsp; &nbsp; <?php echo $celltotal;?></td>			
					</tr>
				</tbody>
			</table>
			<table class="table" style="border:1px solid #ddd" width="100%">
				<tbody>
					<tr>
						<td colspan="2" class="text-right" align="right">{{ trans('app.Service Stock')}}: &nbsp; &nbsp; <?php echo $product_service_stocks_total;?></td>			
					</tr>
				</tbody>
			</table>
			<table class="table" style="border:1px solid #ddd" width="100%">
				<tbody>
					<tr> <?php $Currentstock = $total - $sale_service_stock; ?>
						<td colspan="2" class="text-right" align="right">{{ trans('app.Current Stock:')}} &nbsp; &nbsp; <?php echo $Currentstock;?></td>		
					</tr>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default printbtn" id="" onclick="printdiv('stockprint')">{{ trans('app.Print')}} </button>
			<a href="{!! url('/stoke/list')!!}" class="prints"><input type="submit" class="btn btn-default " value="Close"></a>
		</div>