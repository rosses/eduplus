<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");

if ($_POST["remove"]) {
	DB::delete("library_files", "file_id=%i", $_POST["remove"]);

	$count = DB::queryFirstField("SELECT COUNT(*) FROM library_files WHERE library_id = %i",$_POST["library_id"]);
	if ($count == 0) { 
		DB::delete("library","id=%i",$_POST["library_id"]);
		DB::delete("library_target","library_id=%i",$_POST["library_id"]);
	}
	die();
}
else if ($_POST["remove_library_id"]) {
	DB::delete("library","id=%i",$_POST["remove_library_id"]);
	DB::delete("library_target","library_id=%i",$_POST["remove_library_id"]);
	DB::delete("library_files","library_id=%i",$_POST["remove_library_id"]);
	die();
}
?>
<div id="pageContainerInner" class="no-menu-helper">
	<div id="pageBody">
		<div class="container-fluid">
			<?php 
			if ($_POST["success"]) {
			?>
			<div id="successCLoad" class="alert alert-success"><strong>Tu última publicación fue exitosa.</strong></div>
			<script type="text/javascript">
				setTimeout(function() {
					$("#successCLoad").fadeOut();
				},3000);
			</script>
			<?php
			}
			?>
			<div class="row">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<form id="new_library" method="POST" action="">
					<div class="white-box">
						<div class="module-row">
							<div class="folder-carousel">
								<h4>
									Sube un documento o un grupo de archivos en un mismo paquete
								</h4>
							</div>
						</div>
						<div class="module-row">
							<div class="form-group">
								
								<div class="row">
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

										<select class="form-control inp-school-b" id="materia">
										<option value="">Seleccione materia</option>
										<?php
										//tr.*, c.id course_id, c.name course_name, 
										$trs = DB::query("SELECT m.id materia_id, m.name materia_name
														  FROM teacher_relations tr, course c, materia m 
														  WHERE tr.teacher_id = %i AND tr.course_id = c.id AND tr.materia_id = m.id GROUP BY materia_id, materia_name ORDER BY c.id ASC",$_SESSION["id"]);
										foreach ($trs as $tr) {

											//if (!$_POST["rel"]) { $_POST["rel"] = $tr["course_id"]."-".$tr["materia_id"]; }
											/*
											if (!$curso && !$materia) {
												$xd = explode("-",$_POST["rel"]);	
												$curso = $xd[0];
												$materia = $xd[1];
											}
											*/
											//".($tr["materia_id"] == $materia && $tr["course_id"] == $curso ? "selected" : "")."
											//echo "<option value='".$tr["course_id"]."-".$tr["materia_id"]."'>".$tr["course_name"]." / ".$tr["materia_name"]."</option>";
											echo "<option value='".$tr["materia_id"]."' ".($_POST["materia"] == $tr["materia_id"] ? "selected" : "").">".$tr["materia_name"]."</option>";
										}
										?>
										</select>
									</div>

									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<input type="text" class="form-control inp-school" id="group_title" maxlength="25" placeholder="Titulo del grupo de documentos">
									</div>
								</div>
							</div>
						</div>

						<div class="module-row">
							<div class="form-group">
								
								<div class="row">
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<div class="panel panel-info">
										  <div class="panel-heading">
											Cursos de destino
										  </div>
										  <div class="panel-body">
										  	<div id="cursos_destino_div">
										  		Seleccione una materia para seleccionar
										  	</div>
										  </div>
										 </div>
									</div>
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<div class="panel panel-info">
										  <div class="panel-heading">
											Ejes asociados
										  </div>
										  <div class="panel-body">
										  	<div id="ejes_destino_div">
										  		Seleccione una materia para seleccionar
										  	</div>
										  </div>
										</div>
									</div>
								</div>
							</div>
						</div>


						
						<div class="module-row">
							<div class="panel panel-info">
							  <div class="panel-heading">
								Disponibilidad del grupo de documentos
							  </div>
							  <div class="panel-body">
								
								<input type="radio" name="disponible" value="1" onclick="jQuery('#customDate').hide();" checked id="disponible_siempre" /> <label for="disponible_siempre">Siempre</label>
								<br />
								<input type="radio" name="disponible" value="2" onclick="jQuery('#customDate').show();" id="disponible_custom" /> <label for="disponible_custom">Personalizar disponibilidad</label>
								<br /><br />
								<div id="customDate" style="display:none;">
									<div class="row">
										<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
											<div class="form-group">
								                <label for="fecha_inicio" class="col-md-12 control-label">Desde D&iacute;a</label>
								               
								                <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
								                    <input class="form-control inp-school" size="16" type="text" value="" readonly>
													<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								                </div>

												<input type="hidden" id="fecha_inicio" value="" /><br/>
								            </div>
										</div>

										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
											<div class="form-group">
												<label for="">Hora</label>
												<!--<input type="text"  id="hora_inicio" class="form-control inp-school horamask">-->
												<select id="hora_inicio" class="form-control">
													<?php 
													for ($i=0;$i<24;$i++) {
														echo '<option value="'.($i < 10 ? "0".$i : $i).'">'.($i < 10 ? "0".$i : $i).'</option>';
													}
													?>													
												</select>
											</div>
										</div>

										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" style="display:none;">
											<div class="form-group">
												<label for="">Minuto</label>
												<input type="text"  id="minuto_inicio" class="form-control inp-school minutomask" value="00" readonly="readonly">
											</div>
										</div>

									</div>

									
									<div class="row">
										<div class="col-md-12">
											<input type="checkbox" id="no_end"> <label for="no_end">Sin fecha de término</label>
										</div>
										<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 fecha_termino_div">
											<div class="form-group">

								                <label for="fecha_termino" class="col-md-12 control-label">Hasta D&iacute;a</label>
								               
								                <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="fecha_termino" data-link-format="yyyy-mm-dd">
								                    <input class="form-control inp-school" id="fecha_termino2" size="16" type="text" value="" readonly>
													<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								                </div>

												<input type="hidden" id="fecha_termino" value="" /><br/>
								            </div>
										</div>

										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 fecha_termino_div">
											<div class="form-group">
												<label for="">Hora</label>
												<!--<input type="text" id="hora_termino" class="form-control inp-school horamask">-->
												<select id="hora_termino" class="form-control">
													<?php 
													for ($i=0;$i<24;$i++) {
														echo '<option value="'.($i < 10 ? "0".$i : $i).'">'.($i < 10 ? "0".$i : $i).'</option>';
													}
													?>													
												</select>

											</div>
										</div>

										<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 fecha_termino_div" style="display: none;">
											<div class="form-group">
												<label for="">Minuto</label>
												<input type="text" id="minuto_termino" readonly="readonly" class="form-control inp-school minutomask" value="00">
											</div>
										</div>

									</div>
								</div>
							  </div>
							</div>
						</div>

						<div class="module-row">
							<div class="panel panel-info">
							  <div class="panel-heading">
								Restringir por rendimiento
							  </div>
							  <div class="panel-body">
								<div class="row">
									<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
										<select id="visibilidad" class="form-control inp-school-b">
											<option value="0">Sin restricciones</option>
											<option value="3">Alumnos sobre el 80% de rendimiento</option>
											<option value="2">Alumnos entre 50% y 80% de rendimiento</option>
											<option value="1">Alumnos bajo el 50% de rendimiento</option>
										</select>
									</div>
									<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
									<small>* Los alumnos pueden variar el rendimiento en cualquier momento lo que puede dejar estos documentos fuera de destino</small>
									</div>
								</div>
							  </div>
							</div>
						</div>

						<div class="module-row">
							<div class="panel panel-info">
							  <div class="panel-heading">
								Sube uno o varios archivos a esta configuración
							  </div>
							  <div class="panel-body">
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

										<div class="attached-list">
											<ul class="attached-items">
												<li style="display:none" id="templateForUpload">
													<div class="row">
														<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
															<img src="images/icon-attached.png" class="icon" alt="">
														</div>

														<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
															[file]
														</div>

														<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
															<ul class="actions">
																<li>
																	<a href="#" class="deleteRowUpload">Eliminar</a>
																</li>
															</ul>
														</div>

														<div class="col-xs-3 col-xs-offset-1 col-sm-3 col-sm-offset-1 col-md-3 col-md-offset-1 col-lg-3 col-lg-offset-1">
															<span class="icon-btn" style="right: initial; left: -30px; top:0;">
																<i class="fa fa-refresh fa-spin" aria-hidden="true"></i>
															</span>
															<div class="upload-progress">
																<div class="progress">
																	<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
																	</div>
																</div>
																[hidden_data]
																<p>[tam] Espere...</p>
															</div>
														</div>
													</div>
												</li>
											</ul>
										</div>
										<!--
										<div class="file-box big">
											<div class="vcenter">
												<div class="tabcell">
													<i class="fa fa-cloud-upload" aria-hidden="true"></i> Tambi&eacute;n puedes arrastrar tu archivo ac&aacute;
												</div>

												 <div class="form-group">
												    <input type="file" id="changeFileLibUpload">
												</div>
											</div>
										</div>
										-->
										<div class="file-box big dropzone" id="file-box">
										</div>
										
									</div>
								</div>
							  </div>
							</div>
						</div>
						<div class="module-row">
							<button class="btn-full-width" id="makePublish">Generar publicación</button>
						</div>
					</div>
					</form>
					<div id="new_library_load" class="text-center" style="display:none;">
						<i class="fa fa-spin fa-2x fa-refresh"></i>
						<br /><br />
						<h4>Procesando...</h4>
					</div>
				</div>
				
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<div class="white-box">
						<div class="module-row">
							<div class="form-group">
								<label class="sr-only" for="">Buscar archivos</label>
								<input type="email" class="form-control" id="" placeholder="Buscar archivos...">
							</div>
						</div>

						<div class="module-row">
							<div class="folder-carousel">
								<h4><img src="http://api.eduplus.enlanube.cl/files/resources/docs.png" class="lib-icon" alt="">Tus últimos documentos</h4>
							</div>
							<br />
							<?php
							$query = DB::query("SELECT * FROM library WHERE teacher_id = %i",$_SESSION["id"]);
							foreach($query as $q) {
							?>
							<div class="module-row">
								<div class="file-uploaded">
									<div class="vcenter">
										<div class="tabcell">
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="text-right" style="padding: 10px;">
														<a href="#" class="removeLibrary" data-id="<?=$q["id"];?>"><i class="fa fa-times"></i>&nbsp;&nbsp;eliminar</a>
													</div>
													<div class="doc-info">
														<img src="images/icon-doc-uploaded.png" alt="">
														<h5><?=$q["titulo"];?></h5>
														<?php 
														$files = DB::query("select * from library_files WHERE library_id = %i",$q["id"]);
														foreach ($files as $file) {
														?>
														<div class="row" style="padding-top: 7px; padding-bottom: 7px;">
															<div class="col-md-2">
																<img src="images/icon-doc-uploaded.png" alt="" style="max-width: 15px; margin-right: 6px;">	
															</div>
															<div class="col-md-8" style="font-size: 13px;">
																<?=$file["library_original"];?>	
															</div>
															<div class="col-md-2">
																<a href="#" class="removeDocument" data-library-id="<?=$file["library_id"];?>" data-lf="<?=$file["file_id"];?>"><i class="fa fa-times"></i></a>	
															</div>
														</div>
														<?php
														}
														?>
													</div>
												</div>

											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
							}
							?>
						</div>

					</div>
				</div>
				
			</div>	
		</div>
		<br />
		<br />
		<br />
	</div>
</div>


<script type="text/javascript">
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
	$('.horamask').mask('YZ', {
		placeholder: "00",
		translation: {
		  'Y': {
		    pattern: /[0-1]/, optional: true
		  },
		  'Z': {
		    pattern: /[0-9]/, optional: false
		  }
		}
	});
	$('.minutomask').mask('YZ', {
		placeholder: "00",
		translation: {
		  'Y': {
		    pattern: /[0-5]/, optional: true
		  },
		  'Z': {
		    pattern: /[0-9]/, optional: false
		  }
		}
	});
	/*
	$('.select2').select2({
		placeholder: "Seleccione materia",
		allowClear: false
	});*/

	$("#makePublish").click(function(e) {
		e.preventDefault();
		var titulo = $.trim($("#group_title").val());
		//var target = $.trim($("#group_target").val());
		var materia = $.trim($("#materia").val());
		var visibilidad = $.trim($("#visibilidad").val());
		var fecha_inicio = $.trim($("#fecha_inicio").val());
		var fecha_termino = $.trim($("#fecha_termino").val());
		var hora_inicio = $.trim($("#hora_inicio").val());
		var hora_termino = $.trim($("#hora_termino").val());
		var minuto_inicio = $.trim($("#minuto_inicio").val());
		var minuto_termino = $.trim($("#minuto_termino").val());
		var sin_termino = ($("#no_end").is(":checked") ? 1 : 0);
		var planificada = ($("#disponible_siempre").is(":checked") ? 0 : 1);
		var uploadPending=false;
		var allFiles = myDropzone.getAcceptedFiles();

		var checkedVals = $('.select_ejes:checkbox:checked').map(function() {
		    return this.value;
		}).get();
		
		var select_ejes = checkedVals.join(",");

		var checkedVals2 = $('.select_cursos:checkbox:checked').map(function() {
		    return this.value;
		}).get();

		var select_cursos = checkedVals2.join(",");


		var archivos = [];
		for (var i=0;i<allFiles.length;i++) {
			if (allFiles[i].status == "uploading") {
				uploadPending=true;
				break;
			}
			else if (allFiles[i].status == "success") { 
				archivos.push(allFiles[i].xhr.responseText);
			}
		}
		
		if (materia=="") {
			modal("Error","Debe seleccionar una materia");
		}
		else if (titulo == "") {
			modal("Error","Debe ingresar un titulo");
		}
		else if (archivos.length == 0) {
			modal("Error","Debe cargar a lo menos un archivo a la publicación");
		}
		else if (uploadPending == true) {
			modal("Error","Debe esperar que suban todos los archivos antes de publicar");	
		}
		else if (planificada == 1 && (fecha_inicio=="" || hora_inicio=="" || minuto_inicio=="") ) {
			modal("Error","Si vas a planificar la publicación debes parametrizar el inicio correctamente");
		}
		else if (planificada == 1 && sin_termino == 0 && (fecha_termino=="" || minuto_termino == "" || hora_termino == "")) {
			modal("Error","Si vas a planificar la publicación debes parametrizar el término correctamente");	
		}
		else if (select_cursos == "" || select_ejes == "") {
			modal("Error", "Debe seleccionar a lo menos 1 eje y 1 curso de destino");
		}
		else if (1 == 2) {
			// validar fecha termino > inicio y inicio >= 0
		}
		else {
			$("#new_library").hide();
			$("#new_library_load").show();

			$.post("http://api.eduplus.enlanube.cl/ws.php", {
				nombre: titulo,
				materia: materia,
				visibilidad: visibilidad,
				archivos: archivos.join('*'),
				planificada: planificada,
				teacher_id: <?=$_SESSION["id"];?>,
				fecha_inicio: fecha_inicio,
				fecha_termino: fecha_termino,
				hora_inicio: hora_inicio,
				hora_termino: hora_termino,
				minuto_inicio: minuto_inicio,
				minuto_termino: minuto_termino,
				select_cursos: select_cursos,
				select_ejes: select_ejes,
				sin_termino: sin_termino,
				action: "addResourcesTeacher"
			}, function(data) {
				$.post("ajax/profe_lib_docs.php", {success: 1}, function(data2){
					$("#lib_container").html(data2);
				});				
			},"json");
		}
	});

	$("#no_end").change(function(e) {
		if ($(this).is(":checked")) {
			$(".fecha_termino_div").hide();
			$("#fecha_termino").prop('disabled',true);
			$("#fecha_termino2").prop('disabled',true);
			$("#hora_termino").prop('disabled',true);
			$("#minuto_termino").prop('disabled',true);
		}
		else {
			$(".fecha_termino_div").show();
			$("#fecha_termino").prop('disabled',false);
			$("#fecha_termino2").prop('disabled',false);
			$("#hora_termino").prop('disabled',false);
			$("#minuto_termino").prop('disabled',false);
		}
	});

	$(".removeLibrary").click(function(e) {
		e.preventDefault();
		if (confirm('¿Está seguro de eliminar este directorio?')) {
			$.post("ajax/profe_lib_docs.php", { remove_library_id: $(this).attr('data-id') });
			$(this).closest('.module-row').remove();
		}
	});

	$(".removeDocument").click(function(e) {
		e.preventDefault();
		if (confirm('¿Está seguro de eliminar este documento?')) {
			$.post("ajax/profe_lib_docs.php", { library_id: $(this).attr('data-library-id'), remove: $(this).attr('data-lf')});
			var subs = $(this).closest('.doc-info').children("div").length;
			if (subs == 1) {
				$(this).closest('.module-row').remove();
			}
			else {
				$(this).parent().parent().remove();	
			}
		}
	});

	$("#materia").change(function(e) {
		$.post("ajax/profe_check_cursos.php", { materia: $(this).val() }, function(data) {
			$("#cursos_destino_div").html(data);
		});
		$.post("ajax/profe_check_ejes.php", { materia: $(this).val() }, function(data) {
			$("#ejes_destino_div").html(data);
		});
	});

	<?php
	if ($_POST["materia"]) {
	?>
	$("#materia").change();
	<?php
	}
	?>
	/*
 	$("#changeFileLibUpload").change(function(e) {
 		console.log(this);
 		var file = $(this)[0].files[0];
 		var $clone = $("#templateForUpload").html();
 		var z = hr(file.size,true);
 		$clone = $clone.replace("[tam]",z);
 		$clone = $clone.replace("[file]",file.name);
 		$clone = $clone.replace("[hidden_data]",'<input type="hidden" name="files[]" value="" />');
 		$(".attached-items").append($clone);
 	})*/
 	Dropzone.autoDiscover = false;
 	var myDropzone = new Dropzone("div#file-box", { 
							url: "http://api.eduplus.enlanube.cl/ws.php?uploadTeacher=1&session=<?=$_SESSION["id"];?>", 
							dictDefaultMessage: "Clic para subir tus archivos o arrastralos",
							acceptedFiles: ".xls,.xlsx,.doc.,.docx,.ppt,.pptx,.jpg,.jpeg,.gif,.png,.pdf",
							addRemoveLinks: true,
							dictCancelUpload: "Cancelar",
							dictCancelUploadConfirmation: "Confirmar",
							dictRemoveFile: "Eliminar",
							createImageThumbnails: false
					});


</script>


