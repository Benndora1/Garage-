@extends('layouts.app')
@section('content')

<style>
input[type=radio] {
    margin: 10px 0 0!important;
    margin-top: 1px\9;
    width: 25px;
    line-height: normal;
}

.select2-container { width: 100% !important; }

</style>

<!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
				<div class="nav_menu">
					<nav>
					  <div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"> </i><span class="titleup">&nbsp 
						{{ trans('app.Custom Field')}}</span></a>
					  </div>
						  @include('dashboard.profile')
					</nav>
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
            </div>
			<div class="x_content">
                <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
                	@can('customfield_view')
						<li role="presentation" class=""><a href="{!! url('setting/custom/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.List Custom Field')}}</a></li>
					@endcan
					@can('customfield_edit')
						<li role="presentation" class="active setSizeForAddCustomFieldForSmallDevice"><a href="{!! url('setting/custom/list/edit/'.$id)!!}"><span class="visible-xs"></span><i class="fa fa-pencil-square-o" aria-hidden="true">&nbsp;</i><b> {{ trans('app.Edit Custom Field')}}</b></a></li>
					@endcan
				</ul>
			</div>
			
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_content">
							<form id="customFieldEditForm" method="post" action="update/{{$tbl_custom_fields->id}}" enctype="multipart/form-data"  class="form-horizontal upperform">

								<div class="form-group has-feedback my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Country">{{ trans('app.Form Name')}} <label class="color-danger">*</label>
									</label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<select class="form-control col-md-9 col-xs-12 select_form_name" id="select_form_name" name="formname" disabled="">
											<option value="">{{ trans('app.Select Form Name')}}</option>
											<option value="supplier"<?php if($tbl_custom_fields->form_name == 'supplier'){echo "selected";}?>>{{ trans('app.Supplier')}}</option>
											<option value="customer"<?php if($tbl_custom_fields->form_name == 'customer'){echo "selected";}?>>{{ trans('app.Customer')}}</option>
											<option value="employee"<?php if($tbl_custom_fields->form_name == 'employee'){echo "selected";}?>>{{ trans('app.Employee')}}</option>

											<option value="product" <?php if($tbl_custom_fields->form_name == 'product'){echo "selected";}?>>{{ trans('app.Product')}}</option>
											<option value="purchase" <?php if($tbl_custom_fields->form_name == 'purchase'){echo "selected";}?>>{{ trans('app.Purchase')}}</option>
											<option value="vehicle" <?php if($tbl_custom_fields->form_name == 'vehicle'){echo "selected";}?>>{{ trans('app.Vehicle')}}</option>
											<option value="vehicletype" <?php if($tbl_custom_fields->form_name == 'vehicletype'){echo "selected";}?>>{{ trans('app.Vehicle Type')}}</option>
											<option value="vehiclebrand" <?php if($tbl_custom_fields->form_name == 'vehiclebrand'){echo "selected";}?>>{{ trans('app.Vehicle Brand')}}</option>
											<option value="color" <?php if($tbl_custom_fields->form_name == 'color'){echo "selected";}?>>{{ trans('app.Color')}}</option>
											<option value="service" <?php if($tbl_custom_fields->form_name == 'service'){echo "selected";}?>>{{ trans('app.Service')}}</option>
											<option value="invoice" <?php if($tbl_custom_fields->form_name == 'invoice'){echo "selected";}?>>{{ trans('app.Invoice')}}</option>
											<option value="income" <?php if($tbl_custom_fields->form_name == 'income'){echo "selected";}?>>{{ trans('app.Income')}}</option>
											<option value="expense" <?php if($tbl_custom_fields->form_name == 'expense'){echo "selected";}?>>{{ trans('app.Expense')}}</option>
											<option value="sales" <?php if($tbl_custom_fields->form_name == 'sales'){echo "selected";}?>>{{ trans('app.Sales')}}</option>
											<option value="salepart" <?php if($tbl_custom_fields->form_name == 'salepart'){echo "selected";}?>>{{ trans('app.Sale Part')}}</option>
											<option value="rto" <?php if($tbl_custom_fields->form_name == 'rto'){echo "selected";}?>>{{ trans('app.RTO')}}</option>

											<option value="supportstaff"<?php if($tbl_custom_fields->form_name == 'supportstaff'){echo "selected";}?>>{{ trans('app.Support Staff')}}</option>
											<option value="accountant"<?php if($tbl_custom_fields->form_name == 'accountant'){echo "selected";}?>>{{ trans('app.Accountant')}}</option>
										</select>
									</div>
								</div>

								<div class="form-group has-feedback my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('app.Label')}} <label class="color-danger">*</label>
									</label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="text" name="labelname" class="form-control" placeholder="{{ trans('app.Enter Label Name') }}" required maxlength="20" value="{{$tbl_custom_fields->label}}">
									</div>
								</div>

								<div class="form-group has-feedback my-form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Country">{{ trans('app.Type')}} <label class="color-danger">*</label>
									</label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<select class="form-control col-md-9 col-xs-12 fieldTypename" name="typename" disabled="">
											<option value="">{{ trans('app.Select Type')}}
											<option value="textbox"<?php if($tbl_custom_fields->type == 'textbox'){echo "selected";}?>>{{ trans('app.TextBox')}}</option>
											
											<option value="date"<?php if($tbl_custom_fields->type == 'date'){echo "selected";}?>>{{ trans('app.Date')}}</option>
											<option value="textarea"<?php if($tbl_custom_fields->type == 'textarea'){echo "selected";}?>>{{ trans('app.Textarea')}} </option>
											<option value="radio" <?php if($tbl_custom_fields->type == 'radio'){echo "selected";}?>>{{ trans('app.Radio')}}</option>
											<option value="checkbox" <?php if($tbl_custom_fields->type == 'checkbox'){echo "selected";}?>>{{ trans('app.Checkbox')}} </option>
										</select>
									</div>
								</div>
								
							<!-- If Selected radio then show this Add radio label part -->					<div class="form-group radio_add_part_div" style="margin-bottom: 10px;">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="radio_add_part">{{ trans('app.Radio Field Label')}} <label class="color-danger">*</label></label>							
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="" name="radios_add" class="form-control r_label r_label_inputbox" placeholder="{{ trans('app.Enter radio label name')}}">
									</div>
									<div class="col-md-1 col-sm-1 col-xs-12">
										<button type="button" data-toggle="modal" data-target="#mymodal" class="btn btn-default add_more_radio" custom_field_id_btn="{{$tbl_custom_fields->id}}">{{ trans('app.Add')}}</button>
									</div>		
								</div>
								
								<div class="form-group radio_add_display_part_div" style="">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="radio_add_part"></label>	
									<div class="col-md-5 col-sm-5 col-xs-12" id="radio_label" >
										@if(!empty($radio_labels_data))
										@foreach($radio_labels_data as $key => $radio_label)
									        <div class="radio_label radio_label_{{$key}}">
									        	<i class="fa fa-trash delete_r_label text-danger" aria-hidden="true" radio_label_name="{{ $radio_label }}" row_id="{{$key}}" custom_field_id="{{$tbl_custom_fields->id}}" style="padding-left: 10px;"></i>
									        	<input type="hidden" value="{{ $radio_label }}" id="" class="input_radio_label_{{$key}}" name="r_label[]">
												<label>{{ $radio_label }}</label>
											</div>
										@endforeach
										@endif
					            	</div>
				            	</div>				            	
							
							<!-- If Select radio then show this -->


							<!-- If Selected checkbox then show this Add checkbox label part -->
								<div class="form-group checkbox_add_part_div" style="margin-bottom: 10px;">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="checkbox_add_part">{{ trans('app.Checkbox Field Label')}} <label class="color-danger">*</label></label>									
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="" name="checkbox_add" class="form-control c_label c_label_inputbox" placeholder="{{ trans('app.Enter checkbox label name')}}">
									</div>
									<div class="col-md-1 col-sm-1 col-xs-12">
										<button type="button" data-toggle="modal" data-target="#mymodal" class="btn btn-default add_more_checkbox" custom_field_id_btn="{{$tbl_custom_fields->id}}">{{ trans('app.Add')}}</button>
									</div>		
								</div>
								
								<div class="form-group checkbox_add_display_part_div" style="">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="checkbox_add_part"></label>
									<div class="col-md-5 col-sm-5 col-xs-12" id="checkbox_label" >
										@if(!empty($checkbox_labels_data))
											@foreach($checkbox_labels_data as $key => $checkbox_label)
										        <div class="checkbox_label checkbox_label_{{$key}}">
										        	<i class="fa fa-trash delete_c_label text-danger" aria-hidden="true" checkbox_label_name="{{ $checkbox_label }}" row_id="{{$key}}" custom_field_id="{{$tbl_custom_fields->id}}" style="padding-left: 10px;"></i>
										        	<input type="hidden" value="{{ $checkbox_label }}" id="" class="input_checkbox_label_{{$key}}" name="c_label[]">
													<label>{{ $checkbox_label }}</label>
												</div>
											@endforeach
										@endif
					            	</div>
				            	</div>			            	
							<!-- If Select radio then show this -->

								<div class="form-group has-feedback">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('app.Required')}} <label class="color-danger">*</label>
									</label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="radio"  name="required" value="yes" <?php if($tbl_custom_fields->required =='yes') { echo "checked"; }?>>{{ trans('app.Yes')}} 
										<input type="radio" name="required" value="no" <?php if($tbl_custom_fields->required =='no') { echo "checked"; }?>> {{ trans('app.No')}}
									</div>
								</div>
								
								<div class="form-group has-feedback">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('app.Always visible')}} <label class="color-danger">*</label>
									</label>
									<div class="col-md-5 col-sm-5 col-xs-12">
										<input type="radio"  name="visable" value="yes" <?php if($tbl_custom_fields->always_visable =='yes') { echo "checked"; }?>>{{ trans('app.Yes')}} 
										<input type="radio" name="visable" value="no" <?php if($tbl_custom_fields->always_visable =='no') { echo "checked"; }?>> {{ trans('app.No')}}
									</div>
								</div>
								
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<div class="form-group col-md-12 col-sm-12 col-xs-12">
									<div class="col-md-9 col-sm-9 col-xs-12 text-center">
									  <a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
									  <button type="submit" class="btn btn-success updateButton">{{ trans('app.Update')}}</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- page content end -->	
   
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>  

<!-- <script>
	$(document).ready(function(){
   		// Initialize select2
   		$("#select_form_name").select2();
   	});
</script> -->

<script>
	/*If field selected type is not radio or checkbox then don't display this */
	$('body').on('change','.fieldTypename',function(){
		var valueIs = $(this).val();

		/*if (valueIs == 'radio') {
			$('.radio_add_part_div').css({"display":""});
			$('.radio_add_display_part_div').css({"display":""});
		}
		else {
			$('.radio_add_part_div').css({"display":"none"});
			$('.radio_add_display_part_div').css({"display":"none"});
		}*/	

		if (valueIs == 'radio') 
		{
			$('.radio_add_part_div').css({"display":""});
			$('.radio_add_display_part_div').css({"display":""});

			$('.checkbox_add_part_div').css({"display":"none"});
			$('.checkbox_add_display_part_div').css({"display":"none"});
		}
		else if(valueIs == 'checkbox') 
		{
			$('.checkbox_add_part_div').css({"display":""});
			$('.checkbox_add_display_part_div').css({"display":""});

			$('.radio_add_part_div').css({"display":"none"});
			$('.radio_add_display_part_div').css({"display":"none"});
		}
		else 
		{
			$('.radio_add_part_div').css({"display":"none"});
			$('.radio_add_display_part_div').css({"display":"none"});
			$('.checkbox_add_part_div').css({"display":"none"});
			$('.checkbox_add_display_part_div').css({"display":"none"});
		}
	});	

	/************** For Add radio labels /***************/
	$('body').on('click','.add_more_radio',function(){
		var text = $('.r_label').val();
		var custom_field_id = $(this).attr('custom_field_id_btn');
		//var rowid = $(this).attr('row_id');
		var url = '{{url('custom_field/add_radio_label_data')}}';

		if(text != '')
		{
			var valueString = $('input[name="r_label[]"]').map(function () {
			    return this.value;
			}).get();

			var len=valueString.length;

			if (len >= 2) 
			{	
				var flag = 0;
				for(i=0; i<len; i++)
				{					
			  		if(valueString[i] == text)
			  		{
			      		swal("Duplicate data are not allowed");
			      		$('.r_label').val('');
			      		flag = 1;
			  		}
				}
				
				if(flag == 0)
				{
			        $('#radio_label').append('<div class="radio_label radio_label_'+len+'" id="demo" ><i class="fa fa-trash delete_r_label text-danger" aria-hidden="true" style="padding-left: 10px;"></i>  <input type="hidden" value="'+text+'"  name="r_label[]" class="radioLabelArray"><label>'+text+'</label></div>');
					$('.r_label').val('');
					$('.duplicate_radio').remove();
			  	}
			}
			else
			{
				if (valueString == text) {
					swal("Duplicate data are not allowed");
					$('.r_label').val('');
				}
				else 
				{
					$('#radio_label').append('<div class="radio_label radio_label_'+len+'" id="demo" ><i class="fa fa-trash delete_r_label text-danger" aria-hidden="true" style="padding-left: 10px;"></i>  <input type="hidden" value="'+text+'"  name="r_label[]" class="radioLabelArray"><label>'+text+'</label></div>');
					$('.r_label').val('');
					$('.duplicate_radio').remove();
				}
			}

			/*$.ajax({
				type:'GET',
				url:url,
				data:{radio_label_name:text, custom_field_id:custom_field_id},
				success:function(data){
					if (data == 1) 
					{
						window.location.reload();
					}
					else if (data == 2)
					{
						swal("Duplicate data not allowed");
						$('.r_label').val('');
					}
					else
					{
						$('.radio_label_'+rowid).css({"display":"none"});
						$('.input_radio_label_'+rowid).remove();	
					}
				},
				error: function(e) 
				{
					alert("An error occurred: " + e.responseText);
					console.log(e);
				},
			});*/
		}
		else
		{
			swal("Enter radio label name");
		}
	});

	/*********** For delete radio labels *************/
	$('body').on('click','.delete_r_label',function(){
		$(this).parents('.radio_label').remove();
	});

	/*$('body').on('click','.delete_r_label',function(){
		var rowid = $(this).attr('row_id');
		var url = '{{url('custom_field/delete_radio_label_data')}}';
		var custom_field_id = $(this).attr('custom_field_id');		
		var radio_label_name = $(this).attr('radio_label_name');
		var formName = $('select[name=formname]').val();

		$.ajax({
			type:'GET',
			url:url,
			data:{radio_label_name:radio_label_name, custom_field_id:custom_field_id},
			success:function(data)
			{
				if (data == 1) 
				{
					window.location.reload();
				}
				else
				{
					$('.radio_label_'+rowid).css({"display":"none"});
					$('.input_radio_label_'+rowid).remove();	
				}
			},
			error: function(e) 
			{
				alert("An error occurred: " + e.responseText);
				console.log(e);
			},
		});		
	});*/
</script>


<script>
	/************** For Add checkbox labels /***************/
	$('body').on('click','.add_more_checkbox',function(){
		var text = $('.c_label').val();
		var custom_field_id = $(this).attr('custom_field_id_btn');
		//var rowid = $(this).attr('row_id');
		var url = '{{url('custom_field/add_checkbox_label_data')}}';

		if(text != '')
		{
			var valueString = $('input[name="c_label[]"]').map(function () {
			    return this.value;
			}).get();

			var len=valueString.length;

			if (len >= 2) 
			{	
				var flag = 0;
				for(i=0; i<len; i++)
				{					
			  		if(valueString[i] == text)
			  		{
			      		swal("Duplicate data are not allowed");
			      		$('.c_label').val('');
			      		flag = 1;
			  		}
				}

				if(flag == 0)
				{
			        $('#checkbox_label').append('<div class="label_checkbox" id="demo" ><i class="fa fa-trash delete_c_label text-danger" aria-hidden="true" style="padding-left: 10px;"></i>  <input type="hidden" value="'+text+'"  name="c_label[]" class="checkboxLabelArray"><label>'+text+'</label></div>');
					$('.c_label').val('');
					$('.duplicate_checkbox').remove();
			  	}
			}
			else
			{
				if (valueString == text) {
					swal("Duplicate data are not allowed");
					$('.c_label').val('');
				}
				else 
				{
					$('#checkbox_label').append('<div class="label_checkbox" id="demo" ><i class="fa fa-trash delete_c_label text-danger" aria-hidden="true" style="padding-left: 10px;"></i>  <input type="hidden" value="'+text+'"  name="c_label[]" class="checkboxLabelArray"><label>'+text+'</label></div>');
					$('.c_label').val('');
					$('.duplicate_checkbox').remove();
				}
			}

			/*$.ajax({
				type:'GET',
				url:url,
				data:{checkbox_label_name:text, custom_field_id:custom_field_id},
				success:function(data)
				{
					if (data == 1) 
					{
						window.location.reload();
					}
					else if (data == 2)
					{
						swal("Duplicate data not allowed");
						$('.c_label').val('');
					}
					else
					{
						$('.checkbox_label_'+rowid).css({"display":"none"});
						$('.input_checkbox_label_'+rowid).remove();	
					}
				},
				error: function(e) 
				{
					alert("An error occurred: " + e.responseText);
					console.log(e);
				},
			});*/
		}
		else
		{
			swal("Enter checkbox label name");
		}
	});

	/*********** For delete checkbox labels *************/
	$('body').on('click','.delete_c_label',function(){
		$(this).parents('.checkbox_label').remove();
	});

	/*$('body').on('click','.delete_c_label',function(){
		var rowid = $(this).attr('row_id');
		var url = '{{url('custom_field/delete_checkbox_label_data')}}';
		var custom_field_id = $(this).attr('custom_field_id');		
		var checkbox_label_name = $(this).attr('checkbox_label_name');
		var formName = $('select[name=formname]').val();

		$.ajax({
			type:'GET',
			url:url,
			data:{checkbox_label_name:checkbox_label_name, custom_field_id:custom_field_id},
			success:function(data)
			{
				if (data == 1) 
				{
					window.location.reload();
				}
				else
				{
					$('.checkbox_label_'+rowid).css({"display":"none"});
					$('.input_checkbox_label_'+rowid).remove();	
				}
			},
			error: function(e) 
			{
				alert("An error occurred: " + e.responseText);
				console.log(e);
			},
		});		
	});*/


	/*Check page load time which one is selected(radio or checkbox)*/
	$(document).ready(function(){
   		var selectTepyIs = $('select[name=typename]').val();

   		if (selectTepyIs == "radio") {
   			$('.radio_add_part_div').css({"display":""});
			$('.radio_add_display_part_div').css({"display":""});

			$('.checkbox_add_part_div').css({"display":"none"});
			$('.checkbox_add_display_part_div').css({"display":"none"});

			$('.fieldTypename').attr("disabled","true");
			
   		}
   		else if (selectTepyIs == "checkbox"){

			$('.checkbox_add_part_div').css({"display":""});
			$('.checkbox_add_display_part_div').css({"display":""});

			$('.radio_add_part_div').css({"display":"none"});
			$('.radio_add_display_part_div').css({"display":"none"});

			$('.fieldTypename').attr("disabled","true");
   		}
   		else {   			
			$('.radio_add_part_div').css({"display":"none"});
			$('.radio_add_display_part_div').css({"display":"none"});
			$('.checkbox_add_part_div').css({"display":"none"});
			$('.checkbox_add_display_part_div').css({"display":"none"});
			$('.fieldTypename').attr("disabled","true");
   		}
   	});

	/*Submit time check if radio or checkbox selected then label value should not empty*/
	$('body').on('click','.updateButton',function(e){
		
		var c_len = $("#checkbox_label > div").length;
		var r_len = $("#radio_label > div").length;
		var selectTepyIs = $('select[name=typename]').val();

		if(selectTepyIs == "radio") 
		{			
			if (r_len <= 0) {
				swal("Please enter radio label name on textbox after click on Add button.");
				e.preventDefault();					
			}		
		}
		else if(selectTepyIs == "checkbox")
		{
			if (c_len <= 0) {
				swal("Please enter checkbox label name on textbox after click on Add button.");
				e.preventDefault();
			}
		}
	});


	/*radion label add time check for special symbols*/
	$('body').on('keyup', '.r_label_inputbox', function(){

      	var inputText = $(this).val();

      	if (!inputText.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
      	else if(!inputText.match(/^[a-zA-Z][a-zA-Z0-9\s\.\@\-\_]*$/)){
      		if(inputText.match(/^[0-9]*$/)){
      			$(this).val("");
      			swal("At first position only alphabets are allowed.");
      		}
      		else {
      			$(this).val("");
      			swal("Special symbols are not allowed.");
      		}
      	}
   	});


	/*checkbox label add time check for special symbols*/
   	$('body').on('keyup', '.c_label_inputbox', function(){

      	var inputText = $(this).val();

      	if (!inputText.replace(/\s/g, '').length) {
         	$(this).val("");
      	}
      	else if(!inputText.match(/^[a-zA-Z][a-zA-Z0-9\s\.\@\-\_]*$/)){
      		if(inputText.match(/^[0-9]*$/)){
      			$(this).val("");
      			swal("At first position only alphabets are allowed.");
      		}
      		else {
      			$(this).val("");
      			swal("Special symbols are not allowed.");
      		}
      	}
   	});
</script>

<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\StoreCustomFieldAddEditFormRequest', '#customFieldEditForm'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

@endsection