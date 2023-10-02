<script language="javascript">
			function PrintElem(el) {
			  
				var restorepage = $('body').html();
				var printcontent = $('#' + el).clone();
				$('body').empty().html(printcontent);
				window.print();
				$('body').html(restorepage);

			}
</script>
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
</head>
<body>	
		<div id="getpassprint" style="margin-left:10px;">
			
			<table width="100%" border="0">
				<tbody>
					<tr>
						<td align="left">
						<?php $nowdate = date("Y-m-d");?>
							{{ trans('app.Date')}} : <?php echo  date(getDateFormat(),strtotime($nowdate)); ?> </td>
					</tr>
				</tbody>
			</table> <br/>
		
			<div class="row">
				<div class="col-md-4 col-sm-4 col-xs-12">
						<span style="float:left;" class="printimg">
							<img src="../public/vehicle/service.png" style="width: 240px; height: 90px;">
							<img src="..//public/general_setting/<?php echo $setting->logo_image ?>" width="230px" height="70px" style="position: absolute; top: 10px; left: 15px;">
						</span>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12">
							<h3 align="center" class="modal-title"><?php echo $setting->system_name; ?> </h3>
							<h5 align="center"> <?php echo $setting->address; ?></h5>
				</div>
			<hr/>		
				
				<div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-8 col-sm-offset-8">
							<h5>{{ trans('app.Gate Pass No. :')}} <?php echo $getpassdata->gatepass_no; ?></h5>
				</div>
		</div>
					<div class="modal-body">
						<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;" >
				
	            			<tbody> 	
	            				<tr>
	            					<h3 align="center"><u>{{ trans('app.Gate Pass')}}</u></h3><br>
	            				</tr>

	            				<tr class="printimg">
	            					<td color="white" align="center" colspan="2" style="padding:0px;"><b><h4>{{ trans('app.Gate Pass Details')}}</h4></b></td>
	            				</tr>
							
	            				<tr>
	            					<td class="cname">{{ trans('app.Name:')}}</td>
	            					<td class="cname"> <?php echo $getpassdata->name.' '.$getpassdata->lastname; ?></td>
	            				</tr>
	            				
	            				<tr>
	            					<td class="cname">{{ trans('app.Jobcard Number:')}}</td>
	            					<td class="cname"> <?php echo $getpassdata->jobcard_id; ?></td>
	            				</tr>
	            				           				
	            				<tr>
	            					<td class="cname">{{ trans('app.Vehicle Name:')}}</td>
	            					<td class="cname"><?php echo $getpassdata->modelname; ?></td>
	            				</tr>
	            				
	            				<tr>
	            					<td class="cname">{{ trans('app.Service Date:')}}</td>
	            					<td class="cname">											{{date(getDateFormat(),strtotime($getpassdata->service_date)) }}</td>
	            				</tr>
	            				
								<tr>
	            					<td class="cname">{{ trans('app.Vehicle Out Date:')}}</td>
	            					<td class="cname">{{date(getDateFormat(),strtotime($getpassdata->service_out_date)) }}</td>
	            				</tr>
								
	            				<tr>
	            					<td class="cname"> {{ trans('app.Created On:')}}</td>
	            					<td class="cname">{{date(getDateFormat(),strtotime($getpassdata->created_at)) }}</td>
	            				</tr>
	            				
	            				<tr>
	            					<td class="cname">{{ trans('app.Created By:')}}</td>
	            					<td class="cname"><?php echo getAssignTo($getpassdata->create_by); ?></td>
	            				</tr>
                              </tbody>
	               			</table>
					</div></div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default printbtn" id="" onclick="PrintElem('getpassprint')">{{ trans('app.Print')}} </button>
						<a href="" class="prints"><button type="button" class="btn btn-default">{{ trans('app.Close')}}</button></a>
				    </div>