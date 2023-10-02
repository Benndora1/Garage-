@extends('layouts.app')
@section('content')
<style>
.panel{border: 1px solid transparent!important; margin:0px;}
.panel-default {
    border-color: #ddd!important;
.x_panel{padding:0px}
}
</style>

<!-- page content -->
	<div class="right_col" role="main">
		<div class="">
			<div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Email Template')}}</span></a>  
						</div>
						@include('dashboard.profile')
					</nav>
				</div>
			</div>
			@if(session('message'))
				<div class="row massage">
					 <div class="col-md-12 col-sm-12 col-xs-12">
						<div class="checkbox checkbox-success checkbox-circle">
						 
						   <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Updated')}}  </label>
						</div>
					</div>
				</div>
			@endif
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_content">
						<ul class="nav nav-tabs bar_tabs" role="tablist">
							@can('emailtemplate_view')
								<li role="presentation" class="active"><a href="{!! url('/mail/mail')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Mail Templates')}}</b></a></li>
							@endcan
						</ul>
					</div>
					<div class="x_panel">
						<div class="container ">
							<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">  
								@foreach($mailformat as $mailformats)
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="headingOne">
											
												<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $mailformats->id }}" aria-expanded="true" aria-controls="collapseOne" class="emailacordin">
												<h4 class="panel-title">	<i class="plus-minus glyphicon glyphicon-plus pull-right"></i>
													{{ $mailformats->notification_label }}
												
											</h4></a>
										</div>
										<div id="collapse{{ $mailformats->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
											<div class="panel-body">
												<form class="form-horizontal" method="post" action="mail/emailformat/{{ $mailformats->id }}" name="parent_form">
												
												<input type="hidden" name="_token" value="{{csrf_token()}}">
												
													<div class="form-group">
														<label for="first_name" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('app.Email Subject')}} <span class="color-danger">*</span> </label>
														<div class="col-md-8 col-sm-8 col-xs-12">
															<input class="form-control validate[required]" name="subject" id="Member_Registration" placeholder="Enter email subject" value="{{ $mailformats->subject }}" required>
														</div>
													</div>
													<div class="form-group">
														<label for="first_name" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('app.Sender email')}} <span class="color-danger">*</span> </label>
														<div class="col-md-8 col-sm-8 col-xs-12">
															<input class="form-control validate[required]" name="send_from" id="Member_Registration" placeholder="Enter Sender Email" value="{{ $mailformats->send_from }}" required>
														</div>
													</div>
													<input class="form-control validate[required]" type="hidden" name="mail_id" id="mail_id"  value="">
														
													<div class="form-group">
														<label for="first_name" class="col-md-4 col-sm-4 col-xs-12 control-label">{{ trans('app.Registration Email Template')}} <span class="color-danger">*</span> </label>
														<div class="col-md-8 col-sm-8 col-xs-12">
															<textarea style="min-height:200px;" name="notification_text" class="form-control validate[required] txt_area" required><?php echo $mailformats->notification_text ?></textarea>
														</div>
													</div>
													<div class="form-group">
														<div class="col-md-8 col-sm-8 col-xs-12 col-sm-offset-4 col-md-offset-4">
															{{ trans('app.You can use following variables in the email template')}}<br>
															<label><strong><?php echo $mailformats->description_of_mailformate; ?><br></strong></label>
														</div>
													</div>
													<div class="form-group">
														<div class="col-md-8 col-sm-8 col-xs-12 col-sm-offset-4 col-md-offset-4">
															{{ ('Is Send')}}<br>
														</div>
														<div class="col-md-8 col-sm-8 col-xs-12 col-sm-offset-4 col-md-offset-4">
														<label class="radio-inline">
															<input type="radio" name="is_send"  value="0" @if($mailformats->is_send == 0) checked @endif>{{ ('Enable') }}
														</label>
														<label class="radio-inline">
															<input type="radio" name="is_send"  value="1" @if($mailformats->is_send == 1) checked @endif>{{ ('Disable') }}
														</label>
													</div>	
													</div>
													@can('emailtemplate_edit')
														<div class="col-md-12 col-sm-12 col-xs-12 text-center">        	
															<input type="submit" value="Save"  class="btn btn-success" >
														</div>
													@endcan
												</form>
											</div>
										</div>
									</div><br>
									@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- page content end -->


<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script>

$(function() {
 
  function toggleIcon(e) {
      $(e.target)
          .prev('.panel-heading')
          .find(".plus-minus")
          .toggleClass('glyphicon-plus glyphicon-minus');
  }
  $('.panel-group').on('hidden.bs.collapse', toggleIcon);
  $('.panel-group').on('shown.bs.collapse', toggleIcon);
 
});
</script>	

@endsection