<tr id="row_id_<?php echo $ids;?>">
	<td>
		<select class="form-control select_categorytype" name="product[category_id][]" row_did="" data-id="<?php echo $ids;?>" style="width:100%;" required>
			<option value="0">{{ trans('app.Vehicle')}}</option>
			<option value="1">{{ trans('app.Part')}}</option>
		</select>
	</td>
	<td>
		<select class="form-control select_producttype" name="product[Manufacturer_id][]" m_url="{!! url('/purchase/producttype/name') !!}" man_sel_url="{!! url('purchase/getfirstproductdata')!!}" row_did="<?php echo $ids;?>" data-id="<?php echo $ids;?>" row_id="<?php echo $ids;?>" style="width:100%;" required>
			<!-- <option value="">-{{ trans('app.Select item')}}-</option> -->
			@if(!empty($Select_product))
			@foreach ($Select_product as $Select_products)
			 <option value="{{ $Select_products->id }}" >{{ $Select_products->type }}</option>
			@endforeach
			@endif
		</select>
	</td>
	<td>
		<input type="hidden" value="" name="product[tr_id][]"/>
		<select name="product[product_id][]" class="form-control  productid select_productname_<?php echo $ids;?>"   row_did="<?php echo $ids;?>" url="<?php echo url('purchase/add/getproduct');?>" data-id="<?php echo $ids;?>" style="width:100%;" required="required">
			<!-- <option value="">{{ trans('app.--Select Product--')}}</option> -->
			<?php  foreach($product as $products) { ?>
			<option value="<?php echo $products->id;?>"><?php echo $products->name;?></option> <?php } ?>					  												
		</select>
    </td>
	<td>
		<input type="text" name="product[qty][]"  row_id="<?php echo $ids; ?>" class="quantity form-control qty qty_<?php echo $ids;?>" id="qty_<?php echo $ids;?>" value="1" style="width: 50%;" maxlength="8">
		<span class="qty_<?php echo $ids;?>">{{$first_product->product_no}}</span>
	</td>
	<td>
		<!-- <input type="text" name="product[price][]" class="product form-control prices price_<?php echo $ids;?>"  value="" id="price_<?php echo $ids;?>" style="width:100%;" readonly="true"> -->
		<input type="text" name="product[price][]" class="product form-control prices price_<?php echo $ids;?>"  value="{{$first_product->price}}" id="price_<?php echo $ids;?>" row_id="<?php echo $ids;?>" style="width:100%;" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
	</td>
	<td>
		<input type="text" name="product[total_price][]" class="product form-control total_price total_price_<?php echo $ids;?>"  value="{{$first_product->price}}" style="width:100%;"  id="total_price_<?php echo $ids;?>" readonly="true">
	</td>

	<td align="center">
		<span class="product_delete tax_<?php echo $ids;?>" data-id="<?php echo $ids;?>" id="tax_<?php echo $ids;?>"><i class="fa fa-trash fa-2x"></i> </span>

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