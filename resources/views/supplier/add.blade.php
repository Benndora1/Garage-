@extends('layouts.app')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
   <div class="">
      <div class="page-title">
         <div class="nav_menu">
            <nav>
               <div class="nav toggle">
                  <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Supplier')}}</span></a>
               </div>
               @include('dashboard.profile')
            </nav>
         </div>
      </div>
   </div>
   <div class="x_content">
      <ul class="nav nav-tabs bar_tabs" role="tablist">
         @can('supplier_view')
            <li role="presentation" class=""><a href="{!! url('/supplier/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Supplier List')}}</a></li>
         @endcan

         @can('supplier_add')
            <li role="presentation" class="active"><a href="{!! url('/supplier/add')!!}"><span class="visible-xs"></span> <i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Add Supplier')}}</b></a></li>
         @endcan
      </ul>
   </div>
   <div class="clearfix"></div>
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="x_content">
               <form id="supplier_add_form" method="post" action="{{ url('/supplier/store') }}" enctype="multipart/form-data"  class="form-horizontal upperform supplierAddForm">
                  <div class="col-md-12 col-xs-12 col-sm-12 space">
                     <h4><b>{{ trans('app.Personal Information')}}</b></h4>
                     <p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
                  </div>

               <!-- FirstName and LastName Field -->                  
                  <div class="col-md-12 col-sm-6 col-xs-12">
                     <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="firstname">{{ trans('app.First Name')}}</label>
                        
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <input type="text" id="firstname" name="firstname" max="5" class="form-control" value="{{ old('firstname') }}"  placeholder="{{ trans('app.Enter First Name')}}" maxlength="50" >

                           @if ($errors->has('firstname'))
                              <span class="help-block">
                                 <strong>{{ $errors->first('firstname') }}</strong>
                              </span>
                           @endif
                        </div>
                     </div>
                  
                     <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="lastname">{{ trans('app.Last Name')}}</label>
                        
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <input type="text" id="lastname" name="lastname" class="form-control" value="{{ old('lastname') }}" placeholder="{{ trans('app.Enter Last Name')}}" maxlength="50" >
                        
                           @if ($errors->has('lastname'))
                              <span class="help-block">
                                 <strong>{{ $errors->first('lastname') }}</strong>
                              </span>
                           @endif
                        </div>
                     </div>
                  </div>
               <!-- FirstName and LastName Field End-->
            
               <!-- CompanyName and Email Field -->
                  <div class="col-md-12 col-sm-6 col-xs-12">  
                     <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
                        <label for="displayname" class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Company Name')}} <label class="color-danger">*</label></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <input type="text" id="displayname" class="form-control companyname"  name="displayname" value="{{ old('displayname') }}" placeholder="{{ trans('app.Enter Company Name')}}" maxlength="100">
                  
                           @if ($errors->has('displayname'))
                              <span class="help-block" style="color:#a94442">
                                 <strong>{{ $errors->first('displayname') }}</strong>
                              </span>
                           @endif
                        </div>
                     </div>

                     <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="email">{{ trans('app.Email')}} <label class="color-danger">*</label></label>
                        
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <input type="text" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="{{ trans('app.Enter Email')}}"  maxlength="50">
                        
                           @if ($errors->has('email'))
                              <span class="help-block">
                                 <strong>{{ $errors->first('email') }}</strong>
                              </span>
                           @endif
                        </div>
                     </div>
                  </div>
               <!-- CompanyName and Email Field End-->

               <!-- Mobile and Landline Field -->
                  <div class="col-md-12 col-sm-6 col-xs-12">
                     <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group {{ $errors->has('mobile') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="mobile">{{ trans('app.Mobile No')}} <label class="color-danger">*</label></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <input type="text" id="mobile" name="mobile" class="form-control" value="{{ old('mobile') }}" maxlength="16" minlength="6" placeholder="{{ trans('app.Enter Mobile No')}}">
                        
                           @if ($errors->has('mobile'))
                           <span class="help-block">
                              <strong>{{ $errors->first('mobile') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>

                     <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group {{ $errors->has('landlineno') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="landlineno">{{ trans('app.Landline No')}}<label class="color-danger"></label></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <input type="text" id="landlineno" name="landlineno" class="form-control" value="{{ old('landlineno') }}" maxlength="16" minlength="6" placeholder="{{ trans('app.Enter LandLine No')}}">
                        
                           @if ($errors->has('landlineno'))
                              <span class="help-block">
                                 <strong>{{ $errors->first('landlineno') }}</strong>
                              </span>
                           @endif
                        </div>
                     </div>   
                  </div>
               <!-- Mobile and Landline Field End -->

               <!-- Gender and DoB Field -->
                  <!-- <div class="col-md-12 col-sm-6 col-xs-12"> -->
                     <!-- Remove Gender from Supplier Module -->
                     <!-- <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Gender')}} <label class="color-danger">*</label></label>
                        <div class="col-md-8 col-sm-8 col-xs-12 gender">
                           <input type="radio"  name="gender" value="1" checked>{{ trans('app.Male')}} 
                           <input type="radio" name="gender" value="2" >{{ trans('app.Female')}}
                        </div>
                     </div> -->

                     <!-- Remove DOB Field from Supplier Module -->
                     <!-- <div class="col-md-6 col-sm-6 col-xs-12 form-group {{ $errors->has('dob') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Date Of Birth')}} </label>
                        <div class="col-md-8 col-sm-8 col-xs-12 input-group date datepicker">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                           <input type="text" id="date_of_birth" class="form-control"  name="dob" value="{{ old('dob') }}"   placeholder="<?php echo getDatepicker();?>" readonly />
                        </div>
                     
                        @if ($errors->has('dob'))
                        <span class="help-block">
                           <strong style="margin-left:27%;">{{ $errors->first('dob') }}</strong>
                        </span>
                        @endif
                     </div> -->
                  <!-- </div> -->
               <!-- Gender and DoB Field End -->

               <!-- ContactPerson and Image Field -->
                  <div class="col-md-12 col-sm-6 col-xs-12">
                     <!-- Remove ContactPerson Field from Supplier Module -->
                     <!-- <div class="col-md-6 col-sm-6 col-xs-12 form-group {{ $errors->has('contact_person') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Contact Person')}}</label>
                     
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <input type="text" id="" class="form-control"  name="contact_person" value="{{ old('contact_person') }}" placeholder="{{ trans('app.Enter Contact Person Name')}}" maxlength="25">
                        
                           @if ($errors->has('contact_person'))
                              <span class="help-block">
                                 <strong>{{ $errors->first('contact_person') }}</strong>
                              </span>
                           @endif
                        </div>
                     </div> -->

                     <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group {{ $errors->has('image') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="image">{{ trans('app.Image')}} </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <!--  <input type="file" id="input-file-max-fs"  name="image"  class="form-control dropify" data-max-file-size="5M"> -->
                              <input type="file" id="image" name="image" value="{{ old('image') }}" class="form-control chooseImage">

                           <!-- @if ($errors->has('image'))
                              <span class="help-block">
                                 <strong>{{ $errors->first('image') }}</strong>
                              </span>
                           @endif -->
                           
                           <!-- <div class="dropify-preview">
                              <span class="dropify-render"></span>
                              <div class="dropify-infos">
                                 <div class="dropify-infos-inner">
                                    <p class="dropify-filename">
                                       <span class="file-icon"></span> 
                                       <span class="dropify-filename-inner"></span>
                                    </p>
                                 </div>
                              </div>
                           </div> -->
                              <img src="#" id="imagePreview" alt="User Image" class="imageHideShow" style="width: 20%; display: none; padding-top: 8px;">
                        </div>
                     </div>
                  </div>
               <!-- ContactPerson and Image Field -->
               
               <!-- Address Part -->
                  <div class="col-md-12 col-xs-12 col-sm-12 space">
                     <h4><b>{{ trans('app.Address')}}</b></h4>
                     <p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
                  </div>
               
                  <div class="col-md-12 col-sm-6 col-xs-12">
                     <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="country_id">{{ trans('app.Country')}} <label class="color-danger">*</label></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <select class="form-control select_country" name="country_id" countryurl="{!! url('/getstatefromcountry') !!}">
                              <option value="">{{ trans('app.Select Country')}}</option>
                                 @foreach ($country as $countrys)
                              <option value="{{ $countrys->id }}">{{$countrys->name }}</option>
                                 @endforeach
                           </select>
                        </div>
                     </div>
                     
                     <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="state">{{ trans('app.State')}} </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <select class="form-control state_of_country" name="state" stateurl="{!! url('/getcityfromstate') !!}">
                           </select>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-12 col-sm-6 col-xs-12">
                     <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="city">{{ trans('app.Town/City')}}</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <select class="form-control city_of_state" name="city" value="{{ old('firstname') }}">
                           </select>
                        </div>
                     </div>
                     
                     <div class="col-md-6 col-sm-6 col-xs-12 form-group my-form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="address">{{ trans('app.Address')}} <label class="color-danger">*</label>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <textarea id="address" name="address" class="form-control addressTextarea" maxlength="100">{{ old('address') }}</textarea>
                        </div>
                     </div>
                  </div>
                  <!-- Address Part End-->

               <!-- CustomField Part -->
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
               <!-- Custom Field Part End-->

               <!-- Submit and Cancel Part -->
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <div class="form-group col-md-12 col-sm-12 col-xs-12">
                     <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
                        <button type="submit" class="btn btn-success supplierSubmitButton">{{ trans('app.Submit')}}</button>
                     </div>
                  </div>
               <!-- Submit and Cancel Part End-->
               </form>
            <!-- Form Part End-->
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Content page end -->
  
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>  
<script>
   $(document).ready(function(){
      
      $('.select_country').change(function(){
         countryid = $(this).val();
         var url = $(this).attr('countryurl');
         $.ajax({
            type:'GET',
            url: url,
            data:{ countryid:countryid },
            success:function(response){
               $('.state_of_country').html(response);
            }
         });
      });
      
      $('body').on('change','.state_of_country',function(){
         stateid = $(this).val();
         
         var url = $(this).attr('stateurl');
         $.ajax({
            type:'GET',
            url: url,
            data:{ stateid:stateid },
            success:function(response){
               $('.city_of_state').html(response);
            }
         });
      });
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

<script>
   $('.datepicker').datetimepicker({
      format: "<?php echo getDatepicker(); ?>",
      autoclose: 1,
      minView: 2,
      endDate: new Date(),
   });

   /*If address have any white space then make empty address value*/
   $('body').on('keyup', '.addressTextarea', function(){

      var addressValue = $(this).val();

      if (!addressValue.replace(/\s/g, '').length) {
         $(this).val("");
      }
   });
</script>

<!-- For image preview at selected image -->
<script>
   function readUrl(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#imagePreview').attr('src', e.target.result);
            }            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#image").change(function(){
        readUrl(this);
        $("#imagePreview").css("display","block");
    });

   $('body').on('change','.chooseImage',function(){
      var imageName = $(this).val();
      var imageExtension = /(\.jpg|\.jpeg|\.png)$/i;

      if (imageExtension.test(imageName)) {
         $('.imageHideShow').css({"display":""});
      }
      else {
         $('.imageHideShow').css({"display":"none"});
      }     
   });

   $('body').on('keyup', '.companyname', function(){

      var companyName = $(this).val();

      if (!companyName.replace(/\s/g, '').length) {
         $(this).val("");
      }
   });

   $('body').on('keyup', '#firstname', function(){

      var firstName = $(this).val();

      if (!firstName.replace(/\s/g, '').length) {
         $(this).val("");
      }
   });

   $('body').on('keyup', '#lastname', function(){

      var lastName = $(this).val();

      if (!lastName.replace(/\s/g, '').length) {
         $(this).val("");
      }
   });
</script>

<!-- For form field validate -->
{!! JsValidator::formRequest('App\Http\Requests\SupplierAddEditFormRequest', '#supplier_add_form'); !!}
<script type="text/javascript" src="{{ asset('public/vendor/jsvalidation/js/jsvalidation.js') }}"></script>

<!-- Form submit at a time only one -->
<script type="text/javascript">
    /*$(document).ready(function () {
        $('.supplierSubmitButton').removeAttr('disabled'); //re-enable on document ready
    });
    $('.supplierAddForm').submit(function () {
        $('.supplierSubmitButton').attr('disabled', 'disabled'); //disable on any form submit
    });

    $('.supplierAddForm').bind('invalid-form.validate', function () {
      $('.supplierSubmitButton').removeAttr('disabled'); //re-enable on form invalidation
    });*/
</script>

@endsection