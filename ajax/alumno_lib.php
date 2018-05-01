<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");
$alumno = new Alumno($_SESSION["id"]);
$alumno->getMaterias();
$alumno->getCourses();
?>
<div id="pageContainerInner">
	<div id="menuHelper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
					<a href="#" class="logo-helper">
						<img src="images/logo-helper.png" alt="">
					</a>
				</div>

				<div class="col-xs-12 col-sm-4 col-sm-offset-3 col-md-4 col-md-offset-3 col-lg-4 col-lg-offset-3">
					<div class="search-cont">
						<div class="vcenter">
							<div class="tabcell">
								<div class="search-box">
									<input type="text" class="form-control" placeholder="Buscar...">
									<button type="submit" class="btn btn-default">
										<i class="fa fa-folder-open-o" aria-hidden="true"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					
				</div>
			</div>
		</div>
	</div>

	<div id="pageBody">
		<div class="container-fluid">

			<div class="row">
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">

					<div class="filter-section">
						<div class="themes-box">
							<select class="form-control inp-school white" id="libMateriaChanger">
							<?php
							foreach ($alumno->materias as $id_materia=>$materia) {
							if (!$_POST["id"]) {
								$_POST["id"] = $id_materia;
							}
							?>
							<option value="<?=$id_materia;?>" <?=($_POST["id"] == $id_materia ? "selected":"");?>><?=$materia["name"];?></option>
							<?php
							}
							?>		
							</select>
							<hr />
							<h5>EJES TEMÁTICOS</h5>

							<?php
							$materia = new Materia($_POST["id"]);
							foreach ($materia->getEjes() as $eje) {
								if (!$_POST["eje"]) {
									$_POST["eje"] = $eje["id"];
								}
								?>
								<button class="btn btn-default btn-eje btn-filter <?=($_POST["eje"] == $eje["id"] ? "on" : "");?>" style="<?=($_POST["eje"] == $eje["id"] ? "background-color: ".$materia->color.";" : "");?>" type="submit" data-eje="<?=$eje["id"];?>" data-materia="<?=$materia->id;?>">
									<span class="btn-border" style="background-color: <?=$materia->color;?>"></span>
									<i class="fa fa-folder"></i>
										<?=$eje["name"];?>
								</button>
							<?php 
							if ($_POST["eje"] == $eje["id"]) { $thisEje = $eje; } 
							} ?>

						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<div class="library-module">	
						<div class="themes-box">	
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingOne">
									<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
											<?=$thisEje["name"];?> <i class="fa fa-caret-down" aria-hidden="true"></i>
										</a>
									</h4>
								</div>

								<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
									<div class="panel-body">
										
										<div class="row">
											<div class="col-xs-12 col-md-12">
												<!-- Nav tabs -->
												<ul class="nav nav-pills nav-pills-render" role="tablist">
													<li role="presentation" class="<?=($alumno->performance[$_POST["eje"]]==3 ? "active" : "");?>">
														<a href="#low" aria-controls="low" role="tab" data-toggle="tab">
															Rendimiento bajo <img src="images/icon-x.png" />
														</a>
													</li>

													<li role="presentation" class="<?=($alumno->performance[$_POST["eje"]]==2 ? "active" : "");?>">
														<a href="#medium" aria-controls="medium" role="tab" data-toggle="tab">
															Rendimiento medio <img src="images/icon-dot.png" />
														</a>
													</li>

													<li role="presentation" class="<?=($alumno->performance[$_POST["eje"]]==1 ? "active" : "");?>">
														<a href="#high" aria-controls="high" role="tab" data-toggle="tab">
															Rendimiento alto <img src="images/icon-check-on.png" />
														</a>
													</li>
												</ul>
											</div>
										</div>

										<div class="row">
											<div class="col-xs-12">
												<?php
												$high = $alumno->getFilesEje($_POST["eje"], 1);
												$low = $alumno->getFilesEje($_POST["eje"], 3);
												$medium = $alumno->getFilesEje($_POST["eje"], 2);
												?>
												<!-- Tab panes -->
												<div class="tab-content">
													<div role="tabpanel" class="tab-pane <?=($alumno->performance[$_POST["eje"]]==3 ? "active" : "");?>" id="low">
														<?php
														if ($alumno->performance[$_POST["eje"]]==3) {
														?>
														<div class="alert alert-info"><b>Actualmente</b> este es tu nivel de rendimiento para <b><?=$materia->name;?> / <?=$thisEje["name"];?></b>, estos son los documentos orientados para tí</div>
														<?php
														}
														?>
														<br />
														<?php if (count($low)==0) { echo "No hay documentos disponibles."; } ?>
														<ul class="test-list">
															<?php foreach ($low as $file) { ?>
															<li>
																<a href='<?=$file["library_fileend"];?>' target="_blank">
																	<?php if ($file["library_planificada"]==1 && $file["sin_termino"]==0) { ?> <i class="fa fa-clock-o" title="Hasta <?=date("d/m/Y H:i",strtotime($file["library_hasta"]));?>"></i> <?php } ?>
																	<span class="icon-row"><img src="images/icon-test.png" alt=""></span>
																	<span class="name-1">Subido por:<br/><?php echo $file["teacher_name"];?></span>
																	<span class="name-2"><?php echo $file["library_name"]; ?></span>
																</a>
															</li>
															<?php } ?>
														</ul>
													</div>
													<div role="tabpanel" class="tab-pane <?=($alumno->performance[$_POST["eje"]]==2 ? "active" : "");?>" id="medium">
														<?php
														if ($alumno->performance[$_POST["eje"]]==2) {
														?>
														<div class="alert alert-info"><b>Actualmente</b> este es tu nivel de rendimiento para <b><?=$materia->name;?> / <?=$thisEje["name"];?></b>, estos son los documentos orientados para tí</div>
														<?php
														}
														?>
														<br />
														<?php if (count($medium)==0) { echo "No hay documentos disponibles."; } ?>
														<ul class="test-list">
															<?php foreach ($medium as $file) { ?>
															<li>
																<a href='<?=$file["library_fileend"];?>' target="_blank">
																	<?php if ($file["library_planificada"]==1 && $file["sin_termino"]==0) { ?> <i class="fa fa-clock-o" title="Hasta <?=date("d/m/Y H:i",strtotime($file["library_hasta"]));?>"></i> <?php } ?>
																	<span class="icon-row"><img src="images/icon-test.png" alt=""></span>
																	<span class="name-1">Subido por:<br/><?php echo $file["teacher_name"];?></span>
																	<span class="name-2"><?php echo $file["library_name"]; ?></span>
																</a>
															</li>
															<?php } ?>
														</ul>
													</div>
													<div role="tabpanel" class="tab-pane <?=($alumno->performance[$_POST["eje"]]==1 ? "active" : "");?>" id="high">
														<?php
														if ($alumno->performance[$_POST["eje"]]==1) {
														?>
														<div class="alert alert-info"><b>Actualmente</b> este es tu nivel de rendimiento para <b><?=$materia->name;?> / <?=$thisEje["name"];?></b>, estos son los documentos orientados para tí</div>
														<?php
														}
														?>
														<br />
														<?php if (count($high)==0) { echo "No hay documentos disponibles."; } ?>
														<ul class="test-list">
															<?php foreach ($high as $file) { ?>
															<li>
																<a href='<?=$file["library_fileend"];?>' target="_blank">
																	<?php if ($file["library_planificada"]==1 && $file["sin_termino"]==0) { ?> <i class="fa fa-clock-o" title="Hasta <?=date("d/m/Y H:i",strtotime($file["library_hasta"]));?>"></i> <?php } ?>
																	<span class="icon-row"><img src="images/icon-test.png" alt=""></span>
																	<span class="name-1">Subido por:<br/><?php echo $file["teacher_name"];?></span>
																	<span class="name-2"><?php echo $file["library_name"]; ?></span>
																</a>
															</li>
															<?php } ?>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>		
</div>

<script type="text/javascript">
$(document).ready(function() {
	$(".btn-eje").click(function(e) {
		e.preventDefault();
		$.post("ajax/alumno_lib.php", { id: $(this).attr('data-materia'), eje: $(this).attr('data-eje') }, function(data){
			$("#lib_container").html(data);
		});
	});
});
</script>