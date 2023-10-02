@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
<style>
.select2-container--default .select2-selection--single {
    background-color: #fff;
   border: 1px solid #ccc;
    border-radius: 0px;
    min-height: 32px;
   width:100%;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {   
    line-height: 20px;
}
.setProperText { padding-top: 0px !important; }
.select2-container { width: 100% !important; }
</style>

<!-- page content -->
<div class="right_col" role="main">
   <div class="">
      <div class="page-title">
         <div class="nav_menu">
            <nav>
               <div class="nav toggle">
                  <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Income')}}</span></a>
               </div>
               @include('dashboard.profile')
            </nav>
         </div>
      </div>
   </div>
   @if(session('message'))
         <style>
            .checkbox-success{
               background-color: #cad0cc!important;
               color:red;
            }
         </style> 

         <div class="row massage">
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="checkbox checkbox-success checkbox-circle">
               @if(session('message') == 'amount')
                  <label for="checkbox-10 colo_success"> {{trans('app.please enter an total Income Entry less than Outstanding Amount')}}  </label>
               @endif
               </div>
            </div>
         </div>
         @endif
   <div class="x_content">
      <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
         @can('income_view')
            <li role="presentation" class=""><a href="{!! url('/income/list')!!}" class="anchr"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Income List')}}</a></li>
         @endcan
         @can('income_add')
            <li role="presentation" class="active setSizeForAddIncomeForSmallDevice"><a href="{!! url('/income/add')!!}" class="anchr"><span class="visible-xs"></span> <i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Add Income')}}</b></a></li>
         @endcan
         @can('income_view')
            <li role="presentation" class="setSizeForMonthlyIncomeReportForSmallDevice"><a href="{!! url('/income/month_income')!!}" class="anchr"><span class="visible-xs"></span> <i class="fa fa-area-chart fa-lg">&nbsp;</i>{{ trans('app.Monthly Income Reports')}}</a></li>
         @endcan
      </ul>
   </div>

   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_content">
               <form method="post" id="addIncomeForm" action="{{ url('/income/store') }}" enctype="multipart/form-data"  class="form-horizontal upperform addIncomeForm" id="add-income-form">
                  
                  <div class="col-md-12 col-xs-12 col-sm-12">
                     <h4><b>{{ trans('app.Income Details')}}</b></h4>
                     <hr style="margin-top:0px;">
                     <p class="col-md-12 col-xs-12 col-sm-12"></p>
                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-12 form-group ">
                     <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="invoice" style="padding: 8px 0px;">{{ trans('app.Invoice Number') }} <label class="color-danger">*</label></label>
                        <div class="col-md-9 col-sm-9 col-xs-12 ">
                           <select name="invoice" id="selUser" class="form-control job_number invoiceNumber" job_url="{!! url('invoice/get_invoice') !!}"  required>
                              <option value="">{{ trans('app.Select Invoice')}}</option>
                              @foreach ($left_invoice as $invoice) 
                              <option value="{{ $invoice->invoice_number }}" job="<?php echo $invoice->job_card; ?>">{{ $invoice->invoice_number }}</option>
                              @endforeach
                           </select>
                           @if ($errors->has('invoice'))
                           <span class="help-block">
                           <strong>{{ $errors->first('invoice') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>

                     <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group outstandingMainDiv">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 setProperText" for="invoice"style="padding: 8px 0px;" >{{ trans('app.Outstanding Amount') }} (<?php echo getCurrencySymbols();?>)  
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                           <input type="text" name="Total_Amount" class="form-control ttl_amount" value="" readonly placeholder="{{ trans('app.Total Amount of Invoice')}}">
                     <input type="hidden" name="paymentno" value="{{ $codepay }}">
                        </div>
                     </div>
                     <input type="hidden" name="cus_id" class="servi_id" value="">
                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-12 form-group my-form-group">
                     <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">{{ trans('app.Status') }} <label class="color-danger">*</label> 
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                           <select name="status" id="status" class="form-control" required>
                              <option value="">{{ trans('app.Select Status')}}</option>
                              <option value="2">{{ trans('app.Paid')}}</option>
                              <option value="0">{{ trans('app.Unpaid')}}</option>
                              <option value="1">{{ trans('app.Partially Paid')}}</option>
                           </select>
                           @if ($errors->has('status'))
                           <span class="help-block">
                           <strong>{{ $errors->first('status') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>

                     <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="main_label">{{ trans('app.Main Label') }} <label class="color-danger">*</label> 
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                           <input type="text" id="main_label" name="main_label"  class="form-control"  
                              value="{{ old('main_label') }}" maxlength="30"  placeholder="{{ trans('app.Enter Main Label')}}"  required  />
                           @if ($errors->has('main_label'))
                           <span class="help-block">
                           <strong>{{ $errors->first('main_label') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                     <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="date">{{ trans('app.Date') }} <label class="color-danger">*</label> 
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12 input-group date datepicker">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                           <input type="text" id="income_date" name="date" autocomplete="off" class="form-control incomeDate"   value="" placeholder="<?php echo getDatepicker();?>" onkeypress="return false;"  required  autocomplete="off"/>
                        </div>
                     </div>
                <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cus_name">{{ trans('app.Payment Type') }} <label class="color-danger">*</label></label>                 
                        <div class="col-md-9 col-sm-9 col-xs-12">
                     <select name="Payment_type" class="form-control" required>
                        <option value="">{{ trans('app.Select Payment Type') }}</option>
                        @if(!empty($tbl_payments))
                           @foreach($tbl_payments as $tbl_paymentss)
                           <option value="{{$tbl_paymentss->id}}">{{ $tbl_paymentss->payment }}</option>
                           @endforeach
                        @endif      
                     </select>
                        </div>
                      </div>
                  </div>
                  <div class="items">
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group has-feedback {{ $errors->has('income_entry[]') ? ' has-error' : '' }}">
                           <label class="control-label col-md-3 col-sm-3 col-xs-12 currency" for="income_entry" style="padding: 8px 0px;">{{trans('app.Income Entry')}} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label> </label>
                           <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" id="income_entry"  class="form-control text-input incomeEntryFirst"  value="" maxlength="10" name="income_entry[]" placeholder="{{ trans('app.Income Amount')}}" required>
                        @if ($errors->has('income_entry[]'))
                           <span class="help-block">
                              <strong>{{ $errors->first('income_entry[]') }}</strong>
                           </span>
                         @endif
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                           <label class="control-label col-md-3 col-sm-3 col-xs-12" for="income_label">{{trans('app.Income Label')}}</label>
                           <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" id="income_label" class="form-control text-input"  value="" name="income_label[]" maxlength="30" placeholder="{{ trans('app.Income Entry Label')}}">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                     <div class="col-md-12 col-sm-12 col-xs-12  text-center">
                        <button type="button" id="add_new_entry" class="btn btn-primary add_button" name="add_new_entry" >{{ trans('app.Add More Fields')}}</button>
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

                           @if($myCounts%2 != 0)
                              </div>
                           @endif

                        @endforeach 
                        <?php 
                           if ($subDivCount%2 != 0) {
                              echo "</div>";
                           }
                        ?>          
                     @endif
               <!-- End Custom Field -->

                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <div class="form-group col-md-12 col-sm-12 col-xs-12">
                     <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
                        <button type="submit" class="btn btn-success addIncomeSubmitButton">{{ trans('app.Submit')}}</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <div class="hide copy">
            <div class="remove_fields">
               <div class="col-md-12 col-sm-12 col-xs-12 form-group ">
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12 currency" for="income_entry" style="padding: 8px 0px;">{{trans('app.Income Entry')}} (<?php echo getCurrencySymbols(); ?>)<label class="text-danger">*</label> </label>
                     <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" id="income_entry" class="form-control text-input extraIncomeTextbox"  value="0" name="income_entry[]" maxlength="10" placeholder="{{ trans('app.Income Amount')}}" required>
                     </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group ">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="income_label">{{trans('app.Income Label')}}</label>
                     <div class="col-md-7 col-sm-7 col-xs-12">
                        <input type="text" id="income_label" class="form-control text-input" value="" name="income_label[]" maxlength="30" placeholder="{{ trans('app.Income Entry Label')}}">
                     </div>
                     <div class="col-sm-2 col-xs-2 addmoredelete">
                        <button type="button" class="btn btn-primary del" style="margin-top:0;">{{ trans('app.Delete')}}
                        </button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- page content end -->

<script src="{{ URL::asset('build/js/jquery.min.js') }}"></script>   
   
<script>
   $(document).ready(function() {
   
        $(".add_button").click(function(){ 
      
            var html = $(".copy").html();
            $(".items").after(html);
        });
   
        $("body").on("click",".del",function(){ 
            $(this).parents('.remove_fields').remove();
        });
      });
</script>
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
      
      $('body').on('change','.job_number',function(){
         
         var url = $(this).attr('job_url');
         var job_no = $('.job_number :selected').attr('job');
         var invoiceid = $(this).val();
         
      
         $.ajax({
            type:'GET',
            url:url,
            data:{ job_no:job_no,invoiceid:invoiceid },
            
            success:function(response)
            {
               if(response == 01)
               {
                  alert("No Data Found");
                  $('.ttl_amount').val('');
                  $('.servi_id').val('');
               }
               else
               {
                  $('.ttl_amount').val(response[1]);
                  var dd = $('.servi_id').val(response[2]);
               
               }
            },
            error:function(e)
            {
               console.log(e);
            }
         });
      });
      
   });
   
   $(document).ready(function(){
   // Initialize select2
   $("#selUser").select2();
   });
</script>

<script>
   /*If select box have value then error msg and has error class remove*/
   $('body').on('change','.incomeDate',function(){

      var dateValue = $(this).val();

      if (dateValue != null) {
         $('#income_date-error').css({"display":"none"});
      }

      if (dateValue != null) {
         $(this).parent().parent().removeClass('has-error');
      }
   });


   $(document).ready(function(){

      $('.invoiceNumber').on('change',function(){

         var invoiceValue = $('select[name=invoice]').val();
         
         if (invoiceValue != null) {
            $('#selUser-error').css({"display":"none"});
         }

         if (invoiceValue != null) {
            $(this).parent().parent().removeClass('has-error');
         }
      });
   });

   $('body').on('keyup', '.extraIncomeTextbox', function(){

      var extraIncomeVal = $(this).val();
      var rex = /^[0-9]*\d?(\.\d{1,2})?$/;

      if (!extraIncomeVal.replace(/\s/g, '').length) {
         $(this).val(0);
      }
      else if (!rex.test(extraIncomeVal)) {
         $(this).val("");
      }
   });

   $('body').on('keyup', '.incomeEntryFirst', function(){

      var incomeVal = $(this).val();
      var rex = /^[0-9]*\d?(\.\d{1,2})?$/;

      if (incomeVal == 0) {
         $(this).val("");
      }
      else if (!rex.test(incomeVal)) {
         $(this).val("");
      }   
   });
</script>

<!-- For form field validate -->
{!! JsValidator::formRequest('App\Http\Requests\StoreIncomeRequest', '#addIncomeForm'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>


<!-- Form submit at a time only one -->
<script type="text/javascript">
    /*$(document).ready(function () {
        $('.addIncomeSubmitButton').removeAttr('disabled'); //re-enable on document ready
    });
    $('.addIncomeForm').submit(function () {
        $('.addIncomeSubmitButton').attr('disabled', 'disabled'); //disable on any form submit
    });

    $('.addIncomeForm').bind('invalid-form.validate', function () {
      $('.addIncomeSubmitButton').removeAttr('disabled'); //re-enable on form invalidation
    });*/
</script>


@endsection