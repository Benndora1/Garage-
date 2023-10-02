@extends('layouts.app')
@section('content')

<style>
	.select2-container { width: 100% !important; }
</style>

<!-- page content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Product')}}</span></a>
              </div>
                  @include('dashboard.profile')
            </nav>
          </div>
    </div>
	<div class="x_content">
        <ul class="nav nav-tabs bar_tabs" role="tablist">
        	@can('product_view')
				<li role="presentation" class=""><a href="{!! url('/product/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Product List')}}</a></li>
			@endcan
			
			@can('product_add')
				<li role="presentation" class="active"><a href="{!! url('/product/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Add Product')}}</b></a></li>
			@endcan
		</ul>
	</div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                   <form id="productAdd-Form" method="post" action="{{ url('/product/store') }}" enctype="multipart/form-data"  class="form-horizontal upperform productAddForm">
                       <div class="form-group">							
							<div class="">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Product Number')}} <label class="color-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
								
									<input type="text" id="p_no" name="p_no"  class="form-control" value="{{$code}}" placeholder="{{ trans('app.Enter Product No')}}" readonly>
								</div>
							</div>

							<div class="my-form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Product Date')}} <label class="color-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12 input-group date datepicker">
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
									<input type="text" id="p_date" name="p_date" autocomplete="off" class="form-control productDate" value="{{ old('p_date') }}" placeholder="<?php echo getDatepicker();?>" onkeypress="return false;">
								</div>
							</div>						
                      </div>
                       <div class="form-group">
							<div class="my-form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Name')}} <label class="color-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="text" id="name" name="name" class="form-control" placeholder="{{ trans('app.Enter Product Name')}}" value="{{ old('name') }}" maxlength="30" required>
								</div>
							</div>
							<div class="my-form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Product Image')}} </label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="file" id="input-file-max-fs"  name="image"  class="form-control dropify" data-max-file-size="5M">
									<div class="dropify-preview">
										<span class="dropify-render"></span>
											<div class="dropify-infos">
												<div class="dropify-infos-inner">
													<p class="dropify-filename">
														<span class="file-icon"></span> 
														<span class="dropify-filename-inner"></span>
													</p>
												</div>
											</div>
									</div>
								</div>
							</div>							
						</div>

						<div class="form-group">
							<div class="">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Manufacturer Name')}}</label>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<select id="p_type" name="p_type"  class="form-control product_type_data">
										<option value="">--{{ trans('app.Select Manufacturing Name')}}--</option>
											@if(!empty($product))
												@foreach($product as $products)
													<option value="{{ $products->id }}">{{ $products->type }}</option>
												@endforeach
											@endif
									</select>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-12 addremove">
									<button type="button" data-target="#responsive-modal" data-toggle="modal" class="btn btn-default">{{ trans('app.Add Or Remove')}}</button>
								</div>
							</div>

							<div class="{{ $errors->has('price') ? ' has-error' : '' }} my-form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Price')}} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="text" id="price" name="price"  class="form-control" placeholder="{{ trans('app.Enter Product Price')}}" value="{{ old('price') }}" maxlength="10" required>
									 @if ($errors->has('price'))
								   <span class="help-block">
									   <strong>{{ $errors->first('price') }}</strong>
								   </span>
								 @endif
								</div>
							</div>
						</div>

						<div class="form-group">
						    <div class="">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Color Name')}}</label>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<select id="color_type" name="color"  class="form-control color_name_data">
										<option value="">{{ trans('app.-- Select Color --')}}</option>
											@if(!empty($color))
												@foreach($color as $colors)
													<option value="{{ $colors->id }}">{{ $colors->color }}</option>
												@endforeach
											@endif
									</select>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-12 addremove">
									<button type="button" data-target="#responsive-modal-color" data-toggle="modal" class="btn btn-default">{{ trans('app.Add Or Remove')}}</button>
								</div>
							</div>

							<div class="">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Warranty')}}</label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="text" id="warranty" name="warranty" class="form-control" placeholder="{{ trans('app.Enter Product Warranty')}}" value="{{ old('warranty') }}" maxlength="20">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="my-form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Unit Of Measurement')}} <label class="color-danger">*</label></label>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<select  name="unit"  class="form-control unit_product_data" required>
										<option value="">{{ trans('app.-- Select Unit --')}}</option>
										@foreach($unitproduct as $tbl_product_unit)
											<option value="{{$tbl_product_unit->id}}">{{$tbl_product_unit->name}}
										@endforeach
										</option>
									</select>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-12 addremove">
									<button type="button" data-target="#responsive-modal-unit" data-toggle="modal" class="btn btn-default">{{ trans('app.Add Or Remove')}}</button>
								</div>
							</div>

							<div class="my-form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Supplier')}} <label class="color-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<select  id="sup_id" name="sup_id"  class="form-control select_supplier_auto_search supplierDataFill">
									<option value="">{{ trans('app.-- Select Supplier --')}}</option>
									@if(!empty($supplier))
										@foreach ($supplier as $suppliers)
											<option value="{{ $suppliers->id }}">{{ $suppliers->company_name }}</option>
										@endforeach
									@endif
									</select>
								</div>
							</div>
						</div>
						
						<div class="form-group categoryMainDiv">
							<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								<label class="control-label col-md-4 col-sm-4 col-xs-12"> {{ trans('app.Category') }} <label class="color-danger">*</label></label>
								<div class="col-md-8 col-sm-8 col-xs-12 gender">
									<input type="radio" name="category" value="0" checked="" required>{{ trans('app.Vehicle') }}
									<input type="radio" name="category" value="1"> {{ trans('app.Part') }}
								</div>
							</div>
						</div>

				<!-- Start Custom Field, (If register in Custom Field Module)  -->
						@if(!empty($tbl_custom_fields))
							<div class="col-md-12 col-xs-12 col-sm-12 space">
								<h4><b>{{ trans('app.Custom Fields')}}</b></h4>
								<p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
							</div>
							<?php
								$subDivCount = 0;
							?>
							@foreach($tbl_custom_fields as $myCounts => $tbl_custom_field)
								<?php 
									if($tbl_custom_field->required == 'yes')
									{
										$required="required";
										$red="*";
									}else{
										$required="";
										$red="";
									}
									$subDivCount++;
								?>
								
								@if($myCounts%2 == 0)
									<div class="col-md-12 col-sm-6 col-xs-12">
								@endif
								<div class="form-group col-md-6 col-sm-6 col-xs-12">				
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="account-no">{{$tbl_custom_field->label}} <label class="text-danger">{{$red}}</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12">
									@if($tbl_custom_field->type == 'textarea')
										<textarea  name="custom[{{$tbl_custom_field->id}}]" class="form-control" placeholder="{{ trans('app.Enter')}} {{$tbl_custom_field->label}}" maxlength="100" {{$required}}></textarea>
									@elseif($tbl_custom_field->type == 'radio')
										
										<?php
											$radioLabelArrayList = getRadiolabelsList($tbl_custom_field->id)
										?>
										@if(!empty($radioLabelArrayList))
										<div style="margin-top: 5px;">
											@foreach($radioLabelArrayList as $k => $val)
												<input type="{{$tbl_custom_field->type}}"  name="custom[{{$tbl_custom_field->id}}]" value="{{$k}}" <?php if($k == 0) {echo "checked"; } ?> >{{ $val }} &nbsp;
											@endforeach
										</div>
										@endif
									@elseif($tbl_custom_field->type == 'checkbox')
										
										<?php
											$checkboxLabelArrayList = getCheckboxLabelsList($tbl_custom_field->id);
											$cnt = 0;
										?>

										@if(!empty($checkboxLabelArrayList))
										<div style="margin-top: 5px;">
											@foreach($checkboxLabelArrayList as $k => $val)
												<input type="{{$tbl_custom_field->type}}" name="custom[{{$tbl_custom_field->id}}][]" value="{{$val}}"> {{ $val }} &nbsp;
											<?php $cnt++; ?>
											@endforeach
											</div>
											<input type="hidden" name="checkboxCount" value="{{$cnt}}">
										@endif											
									@elseif($tbl_custom_field->type == 'textbox' || $tbl_custom_field->type == 'date')
										<input type="{{$tbl_custom_field->type}}"  name="custom[{{$tbl_custom_field->id}}]"  class="form-control" placeholder="{{ trans('app.Enter')}} {{$tbl_custom_field->label}}" maxlength="30" {{ $required }}>
									@endif
									</div>
								</div>
							@endforeach	
							<?php 
								if ($subDivCount%2 != 0) {
									echo "</div>";
								}
							?>				
						@endif
				<!-- End Custom Field -->
						
					  	<input type="hidden" name="_token" value="{{csrf_token()}}">
                      	<div class="form-group">
                        	<div class="col-md-12 col-sm-12 col-xs-12 text-center">
                          		<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
                          		<button type="submit" class="btn btn-success productSubmitButton">{{ trans('app.Submit')}}</button>
                        	</div>
                      	</div>
                    </form>
                </div>
				

				<!-- product type Add or Remove Model-->	
				 <div class="col-md-6">
							<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
								<div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
									<h4 class="modal-title">{{ trans('app.Manufacturer Name')}}</h4>
								  </div>
								  <div class="modal-body">
								   <form class="form-horizontal" action="" method="">
										<table class="table producttype"  align="center" style="width:40em">
										<thead>
										<tr>
											<td class="text-center"><strong>{{ trans('app.Manufacturer Name')}}</strong></td>
											<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
										</tr>
										</thead>
										<tbody>
										@foreach ($product as $products)
										<tr class="del-{{$products->id }} data_of_type" >
										<td class="text-center ">{{ $products->type }}</td>
										<td class="text-center">
										<button type="button" productid="{{ $products->id }}" deleteproduct="{!! url('prodcttypedelete') !!}" class="btn btn-danger btn-xs deleteproducted">X</button>
										</td>
										</tr>
										@endforeach
										</tbody>
										</table>
										 <div class="col-md-8 form-group data_popup">
											<label>{{ trans('app.Manufacturer Name')}}: <span class="text-danger">*</span></label>
												<input type="text" class="form-control product_type" name="product_type"  placeholder="{{ trans('app.Manufacturer Name')}}" maxlength="30" />
										</div>
										<div class="col-md-4 form-group data_popup" style="margin-top:24px;">
												<button type="button" class="btn btn-success addtype" producturl="{!! url('/product_type_add') !!}">{{ trans('app.Submit')}}</button>
										</div>
									</form>
								</div>
							  </div>
							</div>
						</div>
				</div>

				<!-- Color Add or Remove Model-->
					<div class="col-md-6">
							<div id="responsive-modal-color" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
								<div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
									<h4 class="modal-title">{{ trans('app.Color')}}</h4>
								  </div>
								   <div class="modal-body">
								   <form class="form-horizontal" action="" method="">
										<table class="table colornametype"  align="center" style="width:40em">
										<thead>
										<tr>
											<td class="text-center"><strong>{{ trans('app.Color Name')}}</strong></td>
											<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
										</tr>
										</thead>
										<tbody>
										@foreach ($color as $colors)
										<tr class="del-{{$colors->id }} data_color_name" >
										<td class="text-center ">{{ $colors->color }}</td>
										<td class="text-center">
										
										<button type="button" id="{{ $colors->id }}" deletecolor="{!! url('colortypedelete') !!}" class="btn btn-danger btn-xs deletecolors">X</button>
										</td>
										</tr>
										@endforeach
										</tbody>
										</table>
										 <div class="col-md-8 form-group data_popup">
											<label>{{ trans('app.Color Name')}}: <span class="text-danger">*</span></label>
												<input type="text" class="form-control c_name" name="c_name"  placeholder="{{ trans('app.Enter color name')}}" maxlength="20" />
										</div>
										<div class="col-md-4 form-group data_popup" style="margin-top:24px;">
												<button type="button" class="btn btn-success addcolor" colorurl="{!! url('/color_name_add') !!}">{{ trans('app.Submit')}}</button>
										</div>
									</form>
								</div>
								</div>
							 </div>
		                    </div>
					</div>
					
					<!-- Unit Add or Remove Model-->
					<div class="col-md-6">
							<div id="responsive-modal-unit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
								<div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
									<h4 class="modal-title">{{ trans('app.Unit Of Measurement')}}</h4>
								  </div>
								   <div class="modal-body">
								   <form class="form-horizontal" action="" method="" >
										<table class="table unitproductname"  align="center" style="width:40em">
										<thead>
										<tr>
											<td class="text-center"><strong>{{ trans('app.Unit Name')}}</strong></td>
											<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
										</tr>
										</thead>
										<tbody>
										@foreach ($unitproduct as $unitproducts)
										<tr class="delete-{{$unitproducts->id }} data_unit_name" >
										<td class="text-center ">{{ $unitproducts->name }}</td>
										<td class="text-center">
										<button type="button" unitid="{{ $unitproducts->id }}" u_url="{!! url('product/unitdelete') !!}" class="btn btn-danger btn-xs unitdelete">X</button>
										</td>
										</tr>
										@endforeach
										</tbody>
										</table>
										<div class="form-group" style="margin-top:20px;">
											<div class="col-md-10 form-group data_popup">
												<label>{{ trans('app.Unit Of Measurement')}}: <span class="text-danger">*</span></label>
												<input type="text" class="form-control u_name" name="unit_measurement"  placeholder="{{ trans('app.Enter Unit Of Measurement')}}" maxlength="30" />
											</div>
											<div class="col-md-2 form-group data_popup" style="margin-top:24px;">
												<button type="button" class="btn btn-success addunit" uniturl="{!! url('product/unit') !!}">{{ trans('app.Submit')}}</button>
											</div>
										</div>
									</form>
								</div>
								</div>
							 </div>
		                    </div>
					</div>
            </div>
        </div>
    </div>
</div>

 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
	$('.datepicker').datetimepicker({
		format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
	});
</script>

<script>

            $(document).ready(function(){
                // Basic
                $('.dropify').dropify();

                // Translated
                $('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-déposez un fichier ici ou cliquez',
                        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                        remove:  'Supprimer',
                        error:   'Désolé, le fichier trop volumineux'
                    }
                });

                // Used events
                var drEvent = $('#input-file-events').dropify();

                drEvent.on('dropify.beforeClear', function(event, element){
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function(event, element){
                    alert('File deleted');
                });

                drEvent.on('dropify.errors', function(event, element){
                    console.log('Has Errors');
                });

                var drDestroy = $('#input-file-to-destroy').dropify();
                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function(e){
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        drDestroy.destroy();
                    } else {
                        drDestroy.init();
                    }
                })
            });
        
</script>


<!-- color add  model -->
<script>
$(document).ready(function(){

	$('.addcolor').click(function(){
		
		var c_name = $('.c_name').val();
		var url = $(this).attr('colorurl');

		function define_variable()
		{
			return {
				addcolor_value: $('.c_name').val(),
				addcolor_pattern: /^[(a-zA-Z0-9\s)]+$/,
			};
		}
		
		var call_var_addcoloradd = define_variable();		 

	        if(c_name == ""){
	            swal('Please enter color name');
	        }
	        else if (!call_var_addcoloradd.addcolor_pattern.test(call_var_addcoloradd.addcolor_value))
			{
				$('.c_name').val("");
				swal('Please enter only alphanumeric data');
			}
	        else if(!c_name.replace(/\s/g, '').length){
				$('.c_name').val("");
	        	swal('Only blank space not allowed');
	    }
        else
        {
			$.ajax({
			    	type: 'GET',
					url: url,
					data : {c_name:c_name},

					//Form submit at a time only one for addColorModel
		   			beforeSend : function () {
		 				$(".addcolor").prop('disabled', true);
		 			},
					
					success:function(data)
					{
					   	var newd = $.trim(data);
				        var classname = 'del-'+newd;

						if(data == '01')
						{
							swal('This Record is Duplicate');
						}
						else
						{
							$('.colornametype').append('<tr class="'+classname+' data_color_name"><td class="text-center">'+c_name+'</td><td class="text-center"><button type="button" id='+data+' deletecolor="{!! url('colortypedelete') !!}" class="btn btn-danger btn-xs deletecolors">X</button></a></td><tr>');
								
							$('.color_name_data').append('<option value='+data+'>'+c_name+'</option>');
								
							$('.c_name').val('');
						}

						//Form submit at a time only one for addColorModel
						$(".addcolor").prop('disabled', false);
						return false;
					},

					error: function(e) {
                 			alert("An error occurred: " + e.responseText);
                    		console.log(e);
                	}	  
	        });
		}
    });
});
</script>


<!-- color Delete  model -->
<script>
$(document).ready(function(){
	$('body').on('click','.deletecolors',function(){
	var colorid = $(this).attr('id');
	var url = $(this).attr('deletecolor');
	 swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
         function(isConfirm){
				if (isConfirm) {
				$.ajax({
				type:'GET',
				url:url,
				data:{colorid:colorid},
				success:function(data){
					
					$('.del-'+colorid).remove();
					 $(".color_name_data option[value="+colorid+"]").remove();
					swal("Done!","It was succesfully deleted!","success");
							}
						});
				}else{
						swal("Cancelled", "Your imaginary file is safe :)", "error");
						} 
				})
		});
	});
</script>

<!-- Product type add add  model -->
<script>
$(document).ready(function(){
	$('.addtype').click(function(){
		
		var product_type = $('.product_type').val();
		var url = $(this).attr('producturl');
		
		function define_variable()
		{
			return {
				product_type_value: $('.product_type').val(),
				product_type_pattern: /^[(a-zA-Z0-9\s)]+$/,
			};
		}
		
		var call_var_product_typeadd = define_variable();		 

	        if(product_type == ""){
	            swal('Please enter product type');
	        }
	        else if (!call_var_product_typeadd.product_type_pattern.test(call_var_product_typeadd.product_type_value))
			{
				$('.product_type').val("");
				swal('Please enter only alphanumeric data');
			}
	        else if(!product_type.replace(/\s/g, '').length){
				$('.product_type').val("");
	        	swal('Only blank space not allowed');
	    }
        else
        {
            $.ajax({
                       
                type: 'GET',
				url: url,
				data : {product_type:product_type},

				//Form submit at a time only one for addProductType(Manufacture Name)
	   			beforeSend : function () {
	 				$(".addtype").prop('disabled', true);
	 			},

				success:function(data)			 
                {
					var newd = $.trim(data);
				    var classname = 'del-'+newd;
							   
					if(data == '01')
					{
						swal('This Record is Duplicate');
					}
					else
					{
						$('.producttype').append('<tr class="'+classname+' data_of_type"><td class="text-center">'+product_type+'</td><td class="text-center"><button type="button" productid='+data+' deleteproduct="{!! url('prodcttypedelete') !!}" class="btn btn-danger btn-xs deleteproducted">X</button></a></td><tr>');
								
						$('.product_type_data').append('<option value='+data+'>'+product_type+'</option>');
									
						$('.product_type').val('');
					}

					//Form submit at a time only one for addProductType(Manufacture Name)
					$(".addtype").prop('disabled', false);
					return false;
				},
                   	
                error: function(e) {
                 		alert("An error occurred: " + e.responseText);
                    	console.log(e);
                }
       		});
            
        }
		
	});
});
</script>

<!-- Product Type Delete  model -->
<script>
$(document).ready(function(){
	
	$('body').on('click','.deleteproducted',function(){
		var ptypeid = $(this).attr('productid');
		var url = $(this).attr('deleteproduct');
					
	 swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
         function(isConfirm){
				if (isConfirm) {
					
					$.ajax({
						type:'GET',
						url:url,
						data:{ptypeid:ptypeid},
						 success: function () {
							 
							 $('.del-'+ptypeid).remove();
								$(".product_type_data option[value="+ptypeid+"]").remove();
							 
							swal("Done!","It was succesfully deleted!","success");
							}
						});
				}else{
						swal("Cancelled", "Your imaginary file is safe :)", "error");
						} 
				})
	
			
		});
	});
</script>


<!-- Unit add  model -->
<script>
$(document).ready(function(){

	$('.addunit').click(function(){
		
		var unit_measurement = $('.u_name').val();		
		var url = $(this).attr('uniturl');

		function define_variable()
		{
			return {
				unit_measurement_value: $('.u_name').val(),
				unit_measurement_pattern: /^[(a-zA-Z0-9\s)]+$/,
			};
		}

		var call_var_unit_measurementadd = define_variable();		 

        if(unit_measurement == ""){
            swal('Please enter unit of measurement');
        }
        else if (!call_var_unit_measurementadd.unit_measurement_pattern.test(call_var_unit_measurementadd.unit_measurement_value))
		{
			$('.u_name').val("");
			swal('Please enter only alphanumeric data');
		}
        else if(!unit_measurement.replace(/\s/g, '').length){
			$('.u_name').val("");
        	swal('Only blank space not allowed');
	    }
        else
        {
			$.ajax({
			    	
			    	type: 'GET',
					url: url,
					data : {unit_measurement:unit_measurement},

					//Form submit at a time only one for addUnitModel
	  				beforeSend : function () {
	 					$(".addunit").prop('disabled', true);
	 				},
					success:function(data)
					{
					   	var newd = $.trim(data);
				        var deleteclass = 'delete-'+newd;
				           
						if(data == '01')
						{
							swal('This Record is Duplicate');
						}
						else
						{
							$('.unitproductname').append('<tr class="'+deleteclass+' data_unit_name"><td class="text-center">'+unit_measurement+'</td><td class="text-center"><button type="button" unitid='+data+' u_url="{!! url('product/unitdelete') !!}" class="btn btn-danger btn-xs unitdelete">X</button></a></td></tr>');
								
							$('.unit_product_data').append('<option value='+data+'>'+unit_measurement+'</option>');
								
							$('.u_name').val('');	
						}

						//Form submit at a time only one for addUnitModel
						$(".addunit").prop('disabled', false);
						return false;         
					},
					
					error: function(e) {
                 			alert("An error occurred: " + e.responseText);
                    		console.log(e);
                	}  
	        });
		}
	});
   
   	$('body').on('click','.unitdelete',function(){     
	
		var unitid = $(this).attr('unitid');
	   
		var url = $(this).attr('u_url');
		swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
         function(isConfirm){
				if (isConfirm) {
				$.ajax({
					type:'GET',
					url:url,
					data:{unitid:unitid},
					success:function(data){
				
						$('.delete-'+unitid).remove();
						$(".unit_product_data option[value="+unitid+"]").remove();
						swal("Done!","It was succesfully deleted!","success");
					}
					});
				}else{
						swal("Cancelled", "Your imaginary file is safe :)", "error");
						} 
				})
			});
	
	});
 
</script>

<!-- Using Slect2 make auto searchable dropdown for supplier select -->
<script>
	$(document).ready(function(){
   		// Initialize select2
   		$(".select_supplier_auto_search").select2();
   	});


	/*If date field have value then error msg and has error class remove*/
	$('body').on('change','.productDate',function(){

		var outDateValue = $(this).val();

		if (outDateValue != null) {
			$('#p_date-error').css({"display":"none"});
		}

		if (outDateValue != null) {
			$(this).parent().parent().removeClass('has-error');
		}
	});

	

	/*If select box have value then error msg and has error class remove*/
	$(document).ready(function(){
		$('#sup_id').on('change',function(){

			var supplierValue = $('select[name=sup_id]').val();
			
			if (supplierValue != null) {
				$('#sup_id-error').css({"display":"none"});
			}

			if (supplierValue != null) {
				$(this).parent().parent().removeClass('has-error');
			}
		});
	});
</script>


<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\ProductAddEditFormRequest', '#productAdd-Form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>


<!-- Form submit at a time only one -->
<script type="text/javascript">
    /*$(document).ready(function () {
        $('.productSubmitButton').removeAttr('disabled'); //re-enable on document ready
    });
    $('.productAddForm').submit(function () {
        $('.productSubmitButton').attr('disabled', 'disabled'); //disable on any form submit
    });

    $('.productAddForm').bind('invalid-form.validate', function () {
      $('.productSubmitButton').removeAttr('disabled'); //re-enable on form invalidation
    });*/
</script>



@endsection