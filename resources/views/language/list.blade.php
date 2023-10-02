@extends('layouts.app')
@section('content')

<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Settings',$userid)=='yes')
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
             <div class="nav_menu">
              <nav>
                <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"> </i><span class="titleup">&nbsp {{ trans('app.Language List')}}</span></a>
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
                   <ul class="nav nav-tabs bar_tabs" role="tablist">
						<li role="presentation" class="active"><a href="{!! url('setting/list')!!}"><span class="visible-xs"><i class="ti-info-alt"></i></span> {{ trans('app.Change Language')}}</a></li>
						<li role="presentation" class=""><a href="{!! url('setting/timezone/list')!!}"><span class="visible-xs"><i class="ti-info-alt"></i></span> {{ trans('app.Change Timezone')}}</a></li>
						<li role="presentation" class=""><a href="{!! url('setting/accessrights/list')!!}"><span class="visible-xs"><i class="ti-info-alt"></i></span> {{ trans('app.Access Rights')}}</a></li>
						<li role="presentation" class=""><a href="{!! url('setting/general_setting/list')!!}"><span class="visible-xs"><i class="ti-info-alt"></i></span> {{ trans('app.General Settings')}}</a></li>
						<li role="presentation"><a href="{!! url('setting/hours/list')!!}"><span class="visible-xs"><i class="ti-info-alt"></i></span> {{ trans('app.Business Hours')}}</a></li>
						
					</ul>
			</div>
           
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  
                   <div class="x_content">
                   
					
                    <form method="post" action="{{ url('setting/language/store') }}" enctype="multipart/form-data"  class="form-horizontal upperform">

                       
					   
					   <div class="form-group has-feedback">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Country">{{ trans('app.Select Language')}} </label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                          <select class="form-control col-md-9 col-xs-12" name="language">
                          
									<option value="en" <?php if($user->language =='en') { echo 'selected'; }?>>English</option>
									<option value="de" <?php if($user->language =='de') { echo 'selected'; }?>>Spanish</option>
									<option value="gr" <?php if($user->language =='gr') { echo 'selected'; }?>>Greek</option>
									<option value="ar" <?php if($user->language =='ar') { echo 'selected'; }?>>Arabic</option>
									<option value="ger" <?php if($user->language =='ger') { echo 'selected'; }?>>German</option>
									<option value="pt" <?php if($user->language =='pt') { echo 'selected'; }?>>Portuguese</option>
									<option value="fr" <?php if($user->language =='fr') { echo 'selected'; }?>>french</option>
									<option value="it" <?php if($user->language =='it') { echo 'selected'; }?>>Italian</option>
									<option value="sv" <?php if($user->language =='sv') { echo 'selected'; }?>>Swedish</option>
									<option value="dt" <?php if($user->language =='dt') { echo 'selected'; }?>>Dutch</option>
									<option value="hi" <?php if($user->language =='hi') { echo 'selected'; }?>>Hindi</option>
									<option value="zhcn" <?php if($user->language =='zhcn') { echo 'selected'; }?>>Chinese (Simplified)</option>
						</select>
                        
						
                        </div>
                      </div>
					  
					   
                          
					  
					  <input type="hidden" name="_token" value="{{csrf_token()}}">
                     
                      <div class="form-group">
                        <div class="col-md-5 col-sm-5 col-xs-12 col-md-offset-3">
                         
                          <button type="submit" class="btn btn-success">{{ trans('app.Submit')}}</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>
           </div>
		 </div>
	@else
	<div class="right_col" role="main">
		<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
           
              <div class="nav toggle" style="padding-bottom:16px;">
               <span class="titleup">&nbsp {{ trans('app.You are not authorize this page.')}}</span>
              </div>

              
                
           
          </div>
       
		
	</div>
	
@endif   
		 <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>  

@endsection