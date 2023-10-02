<tr id="row_id_<?php echo $ids;?>">
	
	<td class="tbl_td_selectManufac_error_<?php echo $ids;?>">
		<!-- <input type="hidden" value="1" name="product[tr_id][]"/> -->
		<select class="form-control select_producttype select_producttype_<?php echo $ids;?>" name="product[Manufacturer_id][]" m_url="{!! url('/purchase/producttype/names') !!}" row_did="<?php echo $ids;?>" data-id="1" style="width:100%;" required="true">
			<option value="">-{{ trans('app.Select Manufacturing Name')}}-</option>
				@if(!empty($manufacture_name))
					@foreach ($manufacture_name as $manufacture_nm)
				 		<option value="{{ $manufacture_nm->id }}" >{{ $manufacture_nm->type }}</option>
					@endforeach
				@endif
		</select>

		<span id="select_producttype_error_<?php echo $ids;?>" class="help-block error-help-block color-danger" style="display: none">Manufacturer name is required.</span>
	</td>
	<td class="tbl_td_selectProductname_error_<?php echo $ids;?>">
		<input type="hidden" value="" name="product[tr_id][]"/>
		<select name="product[product_id][]" class="form-control  productid select_productname_<?php echo $ids;?>" id="productid"  row_did="<?php echo $ids;?>" url="<?php echo url('purchase/add/getproduct');?>" data-id="<?php echo $ids;?>" style="width:100%;" required="true">
			<option value="">{{ trans('app.--Select Product--')}}</option>
			<?php  foreach($product as $products) { ?>
			<option value="<?php echo $products->id;?>"><?php echo $products->name;?></option> <?php } ?>					  												
		</select>

		<span id="select_productname_error_<?php echo $ids;?>" class="help-block error-help-block color-danger" style="display: none">Product name is required.</span>
    </td>
	<td class="tbl_td_quantity_error_<?php echo $ids;?>">
		<input type="text" name="product[qty][]"  row_id="<?php echo $ids; ?>" class="quantity form-control qty qty_<?php echo $ids;?> qtyt" id="qty_<?php echo $ids;?>" autocomplete="off"  value="" prd_url="{{url('/sale_part/get_available_product')}}" style="width: 50%;" maxlength="8" required="true">
		<span class="qty_<?php echo $ids;?>"></span>

		<span id="quantity_error_<?php echo $ids;?>" class="help-block error-help-block color-danger" style="display: none">Quantity is required.</span>
	</td>
	<td class="tbl_td_price_error_<?php echo $ids;?>">
		<!-- <input type="text" name="product[price][]" class="product form-control prices price_<?php echo $ids;?>"  value="" id="price_<?php echo $ids;?>" style="width:100%;" readonly="true"> -->
		<input type="text" name="product[price][]" class="product form-control prices price_<?php echo $ids;?>"  value="" id="price_<?php echo $ids;?>" row_id="<?php echo $ids;?>" style="width:100%;" required="true">

		<span id="price_error_<?php echo $ids;?>" class="help-block error-help-block color-danger" style="display: none">Price is required.</span>
	</td>
	<td class="tbl_td_totaPrice_error_<?php echo $ids;?>">
		<input type="text" name="product[total_price][]" class="product form-control total_price total_price_<?php echo $ids;?>"  value="" style="width:100%;"  id="total_price_<?php echo $ids;?>" readonly="true" required="true">

		<span id="total_price_error_<?php echo $ids;?>" class="help-block error-help-block color-danger" style="display: none">Total price is required.</span>
	</td>

	<td align="center">
		<span class="product_delete tax_<?php echo $ids;?>" style="cursor: pointer;" data-id="<?php echo $ids;?>" id="tax_<?php echo $ids;?>"><i class="fa fa-trash"></i> </span>

	</td>
</tr>

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
<script type="text/javascript">
 $('body').on('keyup','.qty',function(){
			var row_id = $(this).attr('row_id');
			
            var qty= $('#qty_'+row_id).val();
			
			var price= $('#price_'+row_id).val();
			
			var url = $(this).attr('url');
			$.ajax({
						type: 'GET',
						url: url,
						data : {qty:qty,price:price},
						success: function (response)
							 {	
								total_price =  price * qty;
								$('#total_price_'+row_id).val(total_price);
							},
							beforeSend:function()
							{
							},
					    error: function(e) 
							{
							 alert("An error occurred: " + e.responseText);
								console.log(e);
							}
						});
        });
</script>
 
<script>
	$(function(){
			$('#supplier_select').change(function(){
				var supplier_id = $(this).val();
				var url = $(this).attr('url');
				
					$.ajax({
						type: 'GET',
						url: url,
						data : {supplier_id:supplier_id},
						success: function (response)
							 {	
								 var res_supplier = jQuery.parseJSON(response);
								
								$('#mobile').attr('value',res_supplier.mobile_no);
								$('#email').attr('value',res_supplier.email);
								$('#address').text(res_supplier.address);
							},

							beforeSend:function()
							{
								$('#mobile').attr('value','Loading..');
								$('#email').attr('value','Loading..');
								$('#address').attr('value','Loading..');
							},

					    error: function(e) 
							{
							 alert("An error occurred: " + e.responseText);
								console.log(e);
							}
						});
			});
	});
</script>