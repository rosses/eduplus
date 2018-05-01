<div id="pageContainerInner" class="blue-page-bg">
	<div id="menuHelper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
					<a href="#" class="logo-helper">
						<img src="images/logo-helper.png" alt="">
					</a>
				</div>

				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<div class="search-cont">
						<div class="vcenter">
							<div class="tabcell">
								<select class="form-control inp-school-b" id="estaDetalleCurso">
									<?php
									$trs = DB::query("SELECT c.id course_id, c.name course_name
													  FROM teacher_relations tr, course c
													  WHERE tr.teacher_id = %i AND tr.course_id = c.id GROUP BY c.id, c.name ORDER BY c.id ASC",$_SESSION["id"]);
									foreach ($trs as $tr) {
										echo "<option value='".$tr["course_id"]."'>".$tr["course_name"]."</option>";
									}
									?>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<div class="search-cont">
						<div class="vcenter">
							<div class="tabcell">
								<select class="form-control inp-school-b" id="estaDetalleMateria">
								</select>
							</div>
						</div>
					</div>
				</div>
				<!--
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<div class="form-group">
		                <label for="dtp_input2" class="col-md-2 control-label">Desde</label>
		               
		                <div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
		                    <input class="form-control inp-school" size="16" type="text"  value="<?=date("d/m/2017");?>" readonly>
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
		                </div>

						<input type="hidden" id="dtp_input2" value="" /><br/>
		            </div>
				</div>

				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<div class="form-group">
		                <label for="dtp_input2" class="col-md-2 control-label">Hasta</label>
		               
		                <div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
		                    <input class="form-control inp-school" size="16" type="text" value="<?=date("d/m/Y");?>"  readonly>
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
		                </div>

						<input type="hidden" id="dtp_input2" value="" /><br/>
		            </div>
				</div>
				
				<div class="col-xs-12 col-sm-1 col-sm-offset-3 col-md-1 col-md-offset-3 col-lg-1 col-lg-offset-3">
					<img src="images/progress-circle_01.png" width="100%;" alt="">
				</div>
				-->
			</div>
		</div>
	</div>


	<div id="loadingpageBody" class="text-center" style="display:none;">
		<br />
		<br />
		<i class="fa fa-4x fa-spin fa-circle-o-notch"></i>
		<br />
		<br />
		<br />
	</div>
	
	<div id="pageBody" style="">

	</div>

</div>
<!--
<script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
-->
<script type="text/javascript">
	var isFirstLoad = 0;
	/*
    $('.form_datetime').datetimepicker({
        //language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('.form_time').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });
	*/    
	$(document).ready(function() {
		isFirstLoad = 1;
		$("#estaDetalleCurso").change();
	});
    
</script>
