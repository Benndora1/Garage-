@extends('layouts.app')
@section('content')

<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
               <div class="nav_menu">
                <nav>
				  <div class="nav toggle">
					<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Observation Point')}}</span></a>
				  </div>
                  @include('dashboard.profile')
                </nav>
                </div>
              @if(session('message'))
				<div class="row massage">
			 <div class="col-md-12 col-sm-12 col-xs-12">
				<div class="checkbox checkbox-success checkbox-circle">
                  <input id="checkbox-10" type="checkbox" checked="">
                  <label for="checkbox-10 colo_success">  {{session('message')}} </label>
                </div>
				</div>
				</div>
 
 
		@endif
            </div>
			 <div class="x_content">
                   <ul class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" class=""><a href="{!! url('/observation_point/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.List Of Observation Point')}}</span></a></li>
			
           <li role="presentation" class=""><a href="{!! url('/observation_point/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add Observation Point')}}</span></a></li>
           <li role="presentation" class="active"><a href="{!! url('/observation_point/list/edit/'.$editid)!!}"><span class="visible-xs"></span><i class="fa fa-pencil-square-o" aria-hidden="true">&nbsp;</i><b>{{ trans('app.Edit Observation Point')}}</b></span></a></li>
			
            </ul>
			</div>
          
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                 
                   <div class="x_content">
                   
					
                    <form method="post" action="update/{{ $tbl_observation_points->id }}" enctype="multipart/form-data"  class="form-horizontal upperform">

                       
					   
					   
					  
					   <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="margin-top:15px;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rto_tax">{{ trans('app.Observation Type')}} <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
							<select class="form-control" name="o_type_id" required>
							<option value="">{{ trans('app.Select Observation Type')}}</option>
							@if(!empty($tbl_observation_types))
								@foreach ($tbl_observation_types as $tbl_observation_type)
									<option value="{{ $tbl_observation_type->id }}" <?php if($tbl_observation_type->id == $tbl_observation_points->observation_type_id) { echo 'selected';} ?>>{{ $tbl_observation_type->type }}</option>
								@endforeach
							@endif
							</select>
                        </div>
                      </div>
					  
					  
					   <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="margin-top:15px;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rto_tax">{{ trans('app.Observation Point')}} <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" class="form-control" name="o_point" value="{{ $tbl_observation_points->observation_point }}" required/>
                        </div>
                      </div>
					  
					  
					  
					  <input type="hidden" name="_token" value="{{csrf_token()}}">
                     
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                       
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
		 <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>  


@endsection