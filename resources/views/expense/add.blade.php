@extends('layouts.app')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
   <div class="">
      <div class="page-title">
         <div class="nav_menu">
            <nav>
               <div class="nav toggle">
                  <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Expense')}}</span></a>
               </div>
               @include('dashboard.profile')
            </nav>
         </div>
      </div>
   </div>

   <div class="x_content">
      <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
         @can('expense_view')
            <li role="presentation" class=""><a href="{!! url('/expense/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Expense List')}}</a></li>
         @endcan
         @can('expense_add')
            <li role="presentation" class="active setSizeForAddExpenseReportForSmallDevice"><a href="{!! url('/expense/add')!!}"><span class="visible-xs"></span> <i class="fa fa-plus-circle fa-lg i">&nbsp;</i><b>{{ trans('app.Add Expense')}}</b></a></li>
         @endcan
         @can('expense_view')
            <li role="presentation" class="setSizeForMonthlyExpenseReportForSmallDevice"><a href="{!! url('/expense/month_expense')!!}"><span class="visible-xs"></span> <i class="fa fa-area-chart fa-lg">&nbsp;</i>{{ trans('app.Monthly Expense Reports')}}</a></li>
         @endcan
      </ul>
   </div>

   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_content">
               <form id="expenseAddForm" method="post" action="{{ url('/expense/store') }}" enctype="multipart/form-data"  class="form-horizontal upperform addExpenseForm">
                  <div class="col-md-12 col-xs-12 col-sm-12">
                     <h4><b>{{ trans('app.Expenses Details')}}</b></h4>
                     <hr style="margin-top:0px;">
                     <p class="col-md-12 col-xs-12 col-sm-12"></p>
                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                     <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="main_label">{{ trans('app.Main Label') }} <label class="color-danger">*</label> 
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                           <input type="text" id="main_label" name="main_label"  class="form-control mainLabel" value="" placeholder="{{ trans('app.Enter Main Label')}}" maxlength="30" required  />
                           @if ($errors->has('main_label'))
                           <span class="help-block">
                           <strong>{{ $errors->first('main_label') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>

                     <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">{{ trans('app.Status') }} <label class="color-danger">*</label> 
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                           <select name="status" id="status" class="form-control" required>
                              <option value="">{{ trans('app.Select Status')}}</option>
                              <option value="1">{{ trans('app.Paid')}}</option>
                              <option value="2">{{ trans('app.Unpaid')}}</option>
                              <option value="0">{{ trans('app.Partially Paid')}}</option>
                           </select>
                           @if ($errors->has('status'))
                           <span class="help-block">
                           <strong>{{ $errors->first('status') }}</strong>
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
                           <input type="text" id="outdate_gatepass" name="date" autocomplete="off" class="form-control expenseDate"  value="" placeholder="<?php echo getDatepicker();?>" onkeypress="return false;" required  />
                        </div>
                     </div>
                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                     <div class="items">
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
                           <label class="control-label col-md-3 col-sm-3 col-xs-12 currency" for="expense_entry" style="padding:8px 0px 0px 0px;">{{trans('app.Expense Entry')}} (<?php echo getCurrencySymbols(); ?>) <label class="color-danger">*</label></label>
                           <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="number" id="expense_entry" class="form-control text-input"  value="" name="expense_entry[]" placeholder="{{ trans('app.Expense Amount')}}" maxlength="10" required>
                           </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                           <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expense_label">{{trans('app.Expense Label')}}</label>
                           <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" id="expense_label" class="form-control text-input"  value="" name="expense_label[]" placeholder="{{ trans('app.Expense Entry Label')}}" maxlength="30">
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                     <div class="col-md-12 col-sm-12 col-xs-12 text-center">
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
                        <button type="submit" class="btn btn-success addExpenseSubmitButton">{{ trans('app.Submit')}}</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <!-- Add More Field Button call from here to create new Textbox (Start) -->
         <div class="hide copy">
            <div class="remove_fields">
               <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group" style="padding-left: 0px;">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12 currency" for="expense_entry" style="padding:8px 0px 0px 0px;">
                        {{trans('app.Expense Entry')}} (<?php echo getCurrencySymbols(); ?>)
                        <label class="color-danger">*</label> 
                     </label>
                     <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="number" id="expense_entry" class="form-control text-input SetSizeAddExpenseEntryTextBox extraExtenseTextbox" value="0" name="expense_entry[]" maxlength="10" placeholder="{{ trans('app.Expense Amount')}}" required>
                     </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group givePaddingToDiv">
                     <label class="control-label col-md-3 col-sm-3 col-xs-12 expenseLabel" for="expense_label">{{trans('app.Expense Label')}}</label>
                     <div class="col-md-7 col-sm-7 col-xs-12">
                        <input type="text" id="expense_label" class="form-control text-input SetSizeAddExpenseLabelTextBox" value="" name="expense_label[]" placeholder="{{ trans('app.Expense Entry Label')}}" maxlength="30">
                     </div>
                     <div class="col-sm-2 col-xs-2 addmoredelete">
                        <button type="button" class="btn btn-primary del deleteButton" style="margin-top:0;">
                           {{ trans('app.Delete')}}
                        </button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Add More Field Button call from here to create new Textbox (End) -->
      </div>
   </div>
</div>
<!-- page content end -->
  
<script src="{{ URL::asset('build/js/jquery.min.js') }}"></script>

<!-- JQuery for create extra textbox and extra textbox also remove -->  
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
   /*If select box have value then error msg and has error class remove*/
   $('body').on('change','.expenseDate',function(){

      var dateValue = $(this).val();

      if (dateValue != null) {
         $('#outdate_gatepass-error').css({"display":"none"});
      }

      if (dateValue != null) {
         $(this).parent().parent().removeClass('has-error');
      }
   });

   $('body').on('keyup', '.mainLabel', function(){

      var mainLabelName = $(this).val();

      if (!mainLabelName.replace(/\s/g, '').length) {
         $(this).val("");
      }
   });

   $('body').on('keyup', '.extraExtenseTextbox', function(){

      var extraexpenseVal = $(this).val();

      if (!extraexpenseVal.replace(/\s/g, '').length) {
         $(this).val(0);
      }
   });
</script>

<!-- Form field validation -->
{!! JsValidator::formRequest('App\Http\Requests\StoreExpenseAddEditFormRequest', '#expenseAddForm'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>


<!-- Form submit at a time only one -->
<script type="text/javascript">
    /*$(document).ready(function () {
        $('.addExpenseSubmitButton').removeAttr('disabled'); //re-enable on document ready
    });
    $('.addExpenseForm').submit(function () {
        $('.addExpenseSubmitButton').attr('disabled', 'disabled'); //disable on any form submit
    });

    $('.addExpenseForm').bind('invalid-form.validate', function () {
      $('.addExpenseSubmitButton').removeAttr('disabled'); //re-enable on form invalidation
    });*/
</script>

@endsection