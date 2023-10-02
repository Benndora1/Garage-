<html>
<head>
<script language="javascript">
   function PrintElem(el) {
     
      var restorepage = $('body').html();
      var printcontent = $('#' + el).clone();
      $('body').empty().html(printcontent);
      window.print();      
      $('body').html(restorepage);
      window.location.reload();
   
   }
</script>
<script src="{{ URL::asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
      
</head>
<body>
   <div id="salesdata" class="col-md-12">
      <style>
         b, strong {
         font-weight: 500;
         }
         th {
         font-weight: 500;
         }
      </style>
      <table width="100%" border="0">
         <tbody>
            <tr>
               <td align="right">
                  <?php $nowdate = date("Y-m-d");?>
                  <strong>{{ trans('app.Date')}} : </strong><?php echo  date(getDateFormat(),strtotime($nowdate)); ?> 
               </td>
            </tr>
         </tbody>
      </table>
      <br/>
      <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px;">
               <h3 class="text-center"><?php echo $logo->system_name; ?></h3>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-12">
               
               <div class="col-md-6 col-sm-12 col-xs-12 printimg">
                  <img src="{{ URL('public/vehicle/service.png')}}" style="width: 225px; height: 90px;">
                  <img src="{{ url::asset('public/general_setting/'.$logo->logo_image)}}" width="230px" height="70px" style="position: absolute; top: 10px; left: 0px;">
               </div>
               <div class="col-md-6 col-sm-12 col-xs-12">
                  <p>
                     <?php 
                     //echo $logo->address ? ', <br>' : '';
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
               <table class="table" width="100%" style="border-collapse:collapse;">
                  <tr>
                     <th class="cname">{{ trans('app.Bill Number :')}} </th>
                     <td class="cname"> <?php echo $sales->bill_no;?> </td>
                  </tr>
                  <tr>
                     <th class="cname">{{ trans('app.Invoice Number')}} : </th>
                     <td class="cname"> <?php echo getInvoiceNumbersForSalepartInvoice($sales->id); ?> </td>
                  </tr>
                  <tr>
                     <th class="cname">{{ trans('app.Date :')}} </th>
                     <td class="cname"> <?php echo  date(getDateFormat(),strtotime($invioce->date)) ;?></td>
                  </tr>
                  <tr>
                     <th class="cname">{{ trans('app.Status :')}} </th>
                     <td class="cname"><?php if($invioce->payment_status == 0)
                              { echo"Unpaid"; }
                              elseif($invioce->payment_status == 1)
                              { echo"Partially Paid"; }
                              elseif($invioce->payment_status == 2)
                              { echo"Paid";}
                              else
                              {echo"Unpaid";}
                           ?></td>
                  </tr>
                  <tr>
                     <th class="cname">{{ trans('app.Sale Amount :')}} (<?php echo getCurrencySymbols(); ?>) </th>
                     <td class="cname"><?php echo number_format($invioce->grand_total, 2);;?></td>
                  </tr>
               </table>
         </div>
      <hr/>
      <table width="100%" border="0" style="margin-left:10px;">
         <thead>
            <tr>
               <td width="75%" align="left">
                  <h4>{{ trans('app.Payment To')}} </h4>
               </td>
               <td align="left" width="25%">
                  <h4>{{ trans('app.Bill To')}} </h4>
               </td>
            </tr>
         </thead>
         <tbody>
            <tr>
               <td valign="top" width="75%" align="left">
                  <?php echo getCustomerAddress($sales->customer_id);?><br/><?php echo (getCustomerCity($sales->customer_id) != null) ? getCustomerCity("$sales->customer_id") .", <br>":''; ?><?php echo getCustomerState("$sales->customer_id,");echo", ";echo getCustomerCountry($sales->customer_id);?>
               </td>
               <td valign="top" width="25%" align="left">
                  <b>{{ trans('app.Name :')}} </b> <?php echo getCustomerName($sales->customer_id);?><br><b>{{ trans('app.Mobile :')}} </b><?php echo  getCustomerMobile($sales->customer_id); ?>  <br><b>{{ trans('app.Email :')}} </b><?php echo getCustomerEmail($sales->customer_id);?>
               </td>
            </tr>
         </tbody>
      </table>
      <hr/>


      <!-- For Custom Field Customer Module (User table) -->
      @if(!empty($tbl_custom_fields_customers))
      <table class="table table-bordered adddatatable" width="100%" border="1" style="border-collapse:collapse;">
         <tr class="printimg cname">
               <th class="text-center cname" colspan="2">
                  {{ trans('app.CUSTOMER OTHER DETAILS') }}
               </th>
         </tr>

         @foreach($tbl_custom_fields_customers as $tbl_custom_fields_customer)  
            <?php 
               $tbl_custom = $tbl_custom_fields_customer->id;
               $userid = $sales->customer_id;
                                                      
               $datavalue = getCustomData($tbl_custom,$userid);
            ?>
            @if($tbl_custom_fields_customer->type == "radio")
               @if($datavalue != "")
                  <?php
                     $radio_selected_value = getRadioSelectedValue($tbl_custom_fields_customer->id, $datavalue);
                  ?>
                  <tr>
                     <th class="text-center cname">{{$tbl_custom_fields_customer->label}} :</th>
                     <td class="text-center cname">{{$radio_selected_value}}</td>
                  </tr>
               @else
                  <tr>
                     <th class="text-center cname">{{$tbl_custom_fields_customer->label}} :</th>
                     <td class="text-center cname">{{ trans('app.Data not available') }}</td>
                  </tr>
               @endif
            @else
               @if($datavalue != null)
                  <tr>
                     <th class="text-center cname">{{$tbl_custom_fields_customer->label}} :</th>
                     <td class="text-center cname">{{$datavalue}}</td>
                  </tr>
               @else
                  <tr>
                     <th class="text-center cname">{{$tbl_custom_fields_customer->label}} :</th>
                     <td class="text-center cname">{{ trans('app.Data not available') }}</td>
                  </tr>
               @endif
            @endif
         @endforeach
      </table>
      <hr/>
      @endif
   <!-- For Custom Field End Customer Module (User table)-->


      <table class="table table-bordered adddatatable" width="100%" border="1" style="border-collapse:collapse;">
         <thead>
         <tr class="printimg cname">
               <th class="text-center cname" colspan="4">
                  {{ trans('app.Part Details')}}</th>
         </tr>
            <tr>
            <th class="text-center cname">{{ trans('app.Type')}} </th>
               <th class="text-center cname">{{ trans('app.Model')}}</th>
            </tr>
         </thead>
         <tbody>
       @foreach($saless as $d)
            <tr>
               <td class="text-center cname">{{ trans('app.Part')}}</td>
               <td class="text-center cname"><?php echo getPart($d->product_id)->name; ?></td>
            </tr>
      @endforeach
         </tbody>
      </table>
      <hr/>

   <!-- For Custom Field -->
      @if(!empty($tbl_custom_fields_salepart))
      <table class="table table-bordered adddatatable" width="100%" border="1" style="border-collapse:collapse;">
         <tr class="printimg cname">
               <th class="text-center cname" colspan="2">
                  {{ trans('app.OTHER INFORMATION') }}
               </th>
         </tr>

         @foreach($tbl_custom_fields_salepart as $tbl_custom_fields_saleparts)  
            <?php 
               $tbl_custom = $tbl_custom_fields_saleparts->id;
               $userid = $sales->id;
                                                      
               $datavalue = getCustomDataSalepart($tbl_custom,$userid);
            ?>

            @if($tbl_custom_fields_saleparts->type == "radio")
               @if($datavalue != "")
                  <?php
                     $radio_selected_value = getRadioSelectedValue($tbl_custom_fields_saleparts->id, $datavalue);
                  ?>
                  <tr>
                     <th class="text-center cname">{{$tbl_custom_fields_saleparts->label}} :</th>
                     <td class="text-center cname">{{$radio_selected_value}}</td>
                  </tr>
               @else
                  <tr>
                     <th class="text-center cname">{{$tbl_custom_fields_saleparts->label}} :</th>
                     <td class="text-center cname">{{ trans('app.Data not available') }}</td>
                  </tr>
               @endif
            @else
               @if($datavalue != null)
                  <tr>
                     <th class="text-center cname">{{$tbl_custom_fields_saleparts->label}} :</th>
                     <td class="text-center cname">{{$datavalue}}</td>
                  </tr>
               @else
                  <tr>
                     <th class="text-center cname">{{$tbl_custom_fields_saleparts->label}} :</th>
                     <td class="text-center cname">{{ trans('app.Data not available') }}</td>
                  </tr>
               @endif
            @endif
         @endforeach
      </table>
      @endif
   <!-- For Custom Field End -->

      <hr/>
      <table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
         <thead>
       
            <tr class="printimg">
            <th class="text-center cname">{{ trans('app.Description')}}</th>
            <th class="text-center cname">{{ trans('app.Amount')}} (<?php echo getCurrencySymbols(); ?>)</th>
            </tr>
         
         </thead>
         <tbody>
       @foreach($saless as $d)
            <tr>
               <td class="text-right cname"><?php echo $vehicale->name;echo" :"; ?></td>
               <td class="text-right cname" width="20%"><?php $total_price = $d->total_price; echo number_format($total_price, 2);?></td>
            </tr>
         @endforeach
            <tr>
               <td class="text-right cname" colspan="1"></td>
            </tr>
            <tr>
               
               <td class="text-right cname"><b>{{ trans('app.Total Amount')}} :</b></td>
               
               <td class="text-right cname"><b><?php $total_amt = $salesps->total_price; echo number_format($salesps->total_price, 2); ?></b></td>
            </tr>
            <tr>
               <td class="text-right cname">{{ trans('app.Discount')}} (<?php echo $invioce->discount.'%';?>) :</td>
               <td class="text-right cname"><?php $discount = ($total_amt*$invioce->discount)/100; echo number_format($discount, 2); ?></td>
            </tr>
            <tr>
               <td class="text-right cname"><b>{{ trans('app.Total')}} :</b></td>
               <td class="text-right cname"><?php $after_dis_total = $total_amt - $discount; echo number_format($after_dis_total, 2);?></td>
            </tr>
            <tr>
               <td class="cname" colspan="2"></td>
            </tr>
            <?php
               if(!empty($taxes)) 
               {
               $total_tax = 0;
               $taxes_amount = 0;
                  foreach($taxes as $tax)
                  {
                     $taxes_per = preg_replace("/[^0-9,.]/", "", $tax);
                     
                     $taxes_amount = ($after_dis_total*$taxes_per)/100;
                     
                     $total_tax +=  $taxes_amount;
                  ?>
            <tr>
               <td class="text-right cname"><?php echo $tax; ?> (%) :</td>
               <td class="text-right cname"><?php echo number_format($taxes_amount, 2);?> </td>
            </tr>
            <?php }
               $final_grand_total = $after_dis_total+$total_tax;
               }
               else
               {
               $final_grand_total = $after_dis_total;
               }?>   
            <tr>
               <td class="text-right cname"><b>{{ trans('app.Grand Total')}} (<?php echo getCurrencySymbols(); ?>) :</b></td>
               <td class="text-right cname"><b><?php $final_grand_total; echo number_format($final_grand_total, 2);?></b></td>
            </tr>
         <?php  
               $paid_amount = $invioce->paid_amount; 
               $Adjustmentamount = $final_grand_total - $paid_amount; ?>
          <tr>
            <td class="text-right cname" width="81.5%"><b>{{ trans('app.Adjustment Amount')}} (<?php echo getCurrencySymbols(); ?>) :</b></td>
            <td class="text-right cname"><b><?php $paid_amount; echo number_format($paid_amount, 2);?></b></td>
          </tr>
          
          <tr>
            <td class="text-right cname" width="81.5%"><b>{{ trans('app.Amount Due') }} ({{ getCurrencySymbols()}}) :</b></td>
            <td class="text-right cname"><b><?php $Adjustmentamount; echo number_format($Adjustmentamount, 2);?></b></td>
          </tr>
         </tbody>
      </table>
   </div>

   <div class="modal-footer">
      <div class="col-md-6 col-sm-6 col-xs-3 modal-footer mpPayWithCardButtonForSmallDevices">
         @if(Auth::user()->role!='employee')
            @if($Adjustmentamount != 0 && $Adjustmentamount < 999999   && $p_key != null)
               <script src="https://js.stripe.com/v3/"></script>
               <form method="post" action="{{ url('invoice/stripe')}}" class="medium" id="medium">
                  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                  <input type='hidden' name="invoice_amount" value="{{$Adjustmentamount}}">
                  <input type='hidden' name="invoice_id" value="{{$invioce->id}}">
                  <input type='hidden' name="invoice_no" value="{{$invioce->invoice_number}}">
                  <input type='hidden' name="p_key" value="{{$p_key}}">
                  <input type="submit" 
                     class="submit2  btn btn-default text-right" 
                     value="{{ trans('app.Pay with card')}}" 
                     data-key="<?php echo $p_key; ?>" 
                     data-email="{{ getCustomerEmail($sales->customer_id)}}" 
                     data-name="{{$logo->system_name}}" 
                     data-description="Invoice Number - {{$invioce->invoice_number}}" 
                     data-amount="{{$Adjustmentamount * 100}}"
                     data-locale="auto"
                     data-currency="{{strtolower(getCurrencyCode())}}" />

                  <script src="https://checkout.stripe.com/v2/checkout.js"></script>
                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
                  <script>
                     $(document).ready(function() {
                        $('.submit2').on('click', function(event) {
                           event.preventDefault();
                              var $button = $(this),
                              $form = $button.parents('form');
                              var opts = $.extend({}, $button.data(), {
                                 token: function(result) {
                                    $form.append($('<input>').attr({
                                       type: 'hidden',
                                       name: 'stripeToken',
                                       value: result.id
                                    })).submit();
                                 }
                              });
                           StripeCheckout.open(opts);
                        });
                     });
                  </script>
               </form>         
            @endif
         @endif
      </div>
      
      <div class="col-md-6 col-sm-6 col-xs-9 modal-footer mpPrintPdfCloseButtonForSmallDevices" style="text-align:left;">
         <button type="button" class="btn btn-default printbtn" id="" onclick="PrintElem('salesdata')">{{ trans('app.Print')}} </button>
         <a href="{{ url('invoice/salespartpdf/'.$invioce->id)}}" class="prints tagAforPdfBtn"><button type="button" class="btn btn-default pdfButton" style="margin-left: 15px;" >{{ trans('app.PDF')}}</button></a>
         <a href="" class="prints tagAforCloseBtn"><button type="button" data-dismiss="modal" class="btn btn-default closeButton" style="margin-left: 15px;">{{ trans('app.Close')}}</button></a>
      </div>

      @if($Adjustmentamount > 999999)
      <div class="col-md-12 col-sm-12 col-xs-12">
         <h3 class="text-danger" style="text-align: center;">
            <b>{{trans('app.You can not pay more than 999999 using the card.')}}</b>
         </h3>
      </div>
      @endif

      @if($p_key == null)
      <div class="col-md-12 col-sm-12 col-xs-12">
         <h4 class="text-danger" style="text-align: center;">
            <b>{{trans('app.Please update stripe API key details to take payment directly from the card!')}}</b>
         </h4>
      </div>
      @endif
   </div>
</body>

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
</html>