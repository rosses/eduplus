<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");
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
					<br />
					<a class="link_to_docs btn btn-lg btn-primary pull-right">Sube un archivo</a>
				</div>
			</div>
		</div>
	</div>
	
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
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">

					<div class="filter-section">
						<div class="themes-box">
							<select class="form-control inp-school white" id="libMateriaChanger">
							<?php
							$arr = DB::query("SELECT m.* FROM materia m WHERE m.active = 1 AND m.superior = 0 AND EXISTS(SELECT g.* FROM teacher_relations g WHERE g.materia_id = m.id AND g.teacher_id = %i) ORDER BY m.orden ASC", $_SESSION["id"]);
							
							foreach ($arr as $indice=>$a) {
							if (!$_POST["id"]) {
								$_POST["id"] = $a["id"];
							}
							?>
							<option value="<?=$a["id"];?>" <?=($_POST["id"] == $a["id"] ? "selected":"");?>><?=$a["name"];?></option>
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
							<button class="btn btn-default ajax-test-materia btn-filter <?=($_POST["eje"] == $eje["id"] ? "on" : "");?>" style="<?=($_POST["id"] == $eje["id"] ? "background-color: ".$materia->color.";" : "");?>" type="submit" data-materia="<?=$id_materia;?>">
								<span class="btn-border" style="background-color: <?=$materia->color;?>"></span>
								<i class="fa fa-folder"></i>
								<?=$eje["name"];?>
							</button>
							<?php } ?>

						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<div class="library-module">	
						<div class="themes-box">	
							<?php
							$f = DB::query("SELECT * FROM library_target WHERE materia_id = %i", $_POST["id"]);
							if (count($f)==0) {
								echo "<strong>No existen documentos disponibles en éste eje temático</strong>";
							}
							else {

							?>
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingOne">
									<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
											<?=DB::queryFirstField("select name from materia where id = %i",$_POST["id"]);?> <i class="fa fa-caret-down" aria-hidden="true"></i>
										</a>
									</h4>
								</div>

								<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
									<div class="panel-body">
										
										<div class="row m-b">
											<div class="col-xs-12 col-md-5">
												<!-- Nav tabs -->
												<ul class="nav nav-pills edu-navpill-2" role="tablist">
													<li role="presentation" class="active">
														<a href="#home1" aria-controls="home1" role="tab" data-toggle="tab">
															Test Normal (<?=count($f);?>)
														</a>
													</li>

													<li role="presentation">
														<a href="#profile" aria-controls="profile1" role="tab" data-toggle="tab">
															Test Random (0)
														</a>
													</li>
												</ul>
											</div>

											<div class="col-xs-12 col-md-4">
												<ul class="test-status-info">
													<li>
														<i class="fa fa-circle test-finished"></i> Realizados
													</li>

													<li>
														<i class="fa fa-circle test-pending"></i> Guardado
													</li>
												</ul>
											</div>
										</div>

										<div class="row">
											<div class="col-xs-12">

												<!-- Tab panes -->
												<div class="tab-content">
													<div role="tabpanel" class="tab-pane active" id="home1">
														<h5>test normales</h5>
												
														<ul class="test-list">
															<?php
															foreach ($f as $x) {
															?>
															<li>
																<a href='index.php?load=test&id=<?=$x["id"];?>'>
																	<i class="fa fa-circle <?php echo ($alumno->tests[$x["id"]] ? "test-finished" : "test-pending");?>"></i>

																	<span class="icon-row">
																		<img src="images/icon-test.png" alt="">	
																	</span>

																	<span class="name-1">
																		<?php echo $x["name"]; ?>
																	</span>

																	<!--
																	<span class="name-2">
																		Test Nº1
																	</span>
																	-->
																</a>
															</li>
															<?php
															}
															?>
														</ul>
													</div>
													<div role="tabpanel" class="tab-pane" id="profile1">
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
	</div>		

	<div id="pageBody">
		<div class="container-fluid">
			
			<div class="row">

			<?php

			if (!$_POST["eje"]) {
				$_POST["eje"] = 0;
			}
			?>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<div class="filter-section">
						<select class="form-control inp-school white" id="libMateriaChanger">
						<?php
						$arr = DB::query("SELECT m.* FROM materia m WHERE m.active = 1 AND m.superior = 0 AND EXISTS(SELECT g.* FROM teacher_relations g WHERE g.materia_id = m.id AND g.teacher_id = %i) ORDER BY m.orden ASC", $_SESSION["id"]);
						
						foreach ($arr as $indice=>$a) {
						if (!$_POST["id"]) {
							$_POST["id"] = $a["id"];
						}
						?>
						<option value="<?=$a["id"];?>" <?=($_POST["id"] == $a["id"] ? "selected":"");?>><?=$a["name"];?></option>
						<?php
						}
						?>		
						</select>

						<div class="themes-box">
							<a class="btn btn-default btn-eje btn-filter <?=($_POST["eje"] == 0 ? "active" : "");?>" data-materia="<?=$_POST["id"];?>" data-eje="0" style="white-space: normal;" type="submit">
								<img src="images/folder-icon.png" alt="">
								Contenidos generales (<?php 
									$q = "SELECT DISTINCT lf.* FROM library_target lt, library_files lf, library l WHERE lt.materia_id = '".$_POST["id"]."' AND lt.library_id = l.id AND lf.library_id = l.id AND lt.course_id = (SELECT ur.course_id FROM user_relations ur WHERE ur.user_id = '".$_SESSION["id"]."' LIMIT 1) AND (SELECT count(*) FROM library_target l2 WHERE lt.materia_id = l2.materia_id AND l2.library_id = lt.library_id) > 1";
									
									$numOfFiles = count(DB::query($q));
									if (!$numOfFiles){ echo "0"; }
									else { echo $numOfFiles; }
								?>)
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</a>
							<br />
								
							<h5>Ejes tem&aacute;ticos</h5>
							<?php
							$ejes = DB::query("SELECT * FROM eje e WHERE e.parent = %i AND e.library = 1 ORDER BY name ASC",$_POST["id"]);
							foreach ($ejes as $eje) {
							?>
							<a class="btn btn-default btn-eje btn-filter <?=($_POST["eje"] == $eje["id"] ? "active" : "");?>" data-materia="<?=$_POST["id"];?>" data-eje="<?=$eje["id"];?>" style="white-space: normal;" type="submit">
								<img src="images/folder-icon.png" alt="">
								<?=$eje["name"];?>
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
								(<?php 
									$q = "SELECT COUNT(*) FROM library_target lt, library_files lf, library l WHERE lt.eje_id = '".$eje["id"]."' AND lt.library_id = l.id AND lf.library_id = l.id AND lt.course_id = (SELECT ur.course_id FROM user_relations ur WHERE ur.user_id = '".$_SESSION["id"]."' LIMIT 1) AND (SELECT count(*) FROM library_target l2 WHERE l2.library_id = lt.library_id) = 1";
									//echo $q;
									$numOfFiles = DB::queryFirstField($q);
									if (!$numOfFiles){ echo "0"; }
									else { echo $numOfFiles; }
								?>)
							</a>
							<?php } ?>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<div class="library-module">
						<div class="panel panel-default">
							<!--
							<div class="panel-heading" role="tab" id="heading0">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse0" aria-expanded="true" aria-controls="collapse0">
										<?php
											if ($_POST["eje"] == 0) {
												echo "Contenidos Generales";
											}
											else {
												echo DB::queryFirstField("SELECT name FROM eje WHERE id = %i",$_POST["eje"]);
											}
										?>
										<i class="fa fa-caret-down" aria-hidden="true"></i>
									</a>
								</h4>
							</div>
							-->

							<div id="collapse0" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading0">
								<div class="panel-body">
									<ul class="item-row">
										<?php

										if ($_POST["folder"]) {											
											$sql = "SELECT * FROM library_files lf, library l WHERE lf.library_id = l.id AND lf.library_id = '".$_POST["folder"]."'";
											$libs = DB::query($sql);


										?>
										<h5><?=DB::queryFirstField("select titulo from library where id = '".$_POST["folder"]."'");?></h5>
										<hr />
										<?php
											if (count($libs)==0) {
												echo "<li style='width: 100%;'>No hay contenido activo</li>";
											}
											?>
											
											<?php
											foreach ($libs as $lib) {
											?>
											<li>
												<a href="<?=$lib["library_fileend"];?>" target="_blank">
													<span class="thumb">
														<img src="images/icon-library.png" alt="">
													</span>

													<span class="item-info">
														<span>
															<?php 
															echo $lib["library_original"];
															?>
														</span> 
													</span>
												</a>
											</li>
											<?php
											}
										}

										else {

											if ($_POST["eje"] == 0) {
												$sql = "SELECT DISTINCT l.* 
													   FROM library_target lt, library l 
													   WHERE lt.materia_id = '".$_POST["id"]."' AND lt.library_id = l.id AND 
													   EXISTS(SELECT * FROM user_relations ur WHERE ur.user_id = '".$_SESSION["id"]."' AND ur.course_id = lt.course_id) 
													   AND (SELECT COUNT(*) FROM library_target l2 WHERE l2.library_id = l.id AND l2.materia_id = lt.materia_id) > 1 
													   ORDER BY id DESC
													   ";
											} else {
												$sql = "SELECT * 
													   FROM library_target lt, library l 
													   WHERE lt.materia_id = '".$_POST["id"]."' AND lt.library_id = l.id AND 
													   EXISTS(SELECT * FROM user_relations ur WHERE ur.user_id = '".$_SESSION["id"]."' AND ur.course_id = lt.course_id) 
													   AND lt.eje_id = '".$_POST["eje"]."' 
													   AND (SELECT COUNT(*) FROM library_target l2 WHERE l2.library_id = l.id AND l2.materia_id = lt.materia_id) = 1
													   ORDER BY id DESC";
											}

											
											$libs = DB::query($sql);

											//echo $sql;

											if (count($libs)==0) {
												echo "<li style='width: 100%;'>No hay contenido activo</li>";
											}
											?>
											
											<?php
											foreach ($libs as $lib) {
											?>
											<li>
												<a href="#" data-eje="<?=$_POST["eje"];?>" class="link-folder" data-materia="<?=$_POST["id"];?>" data-folder="<?=$lib["id"];?>">
													<span class="thumb">
														<img src="images/icon-print.png" alt="">
													</span>

													<span class="item-info">
														<h5>
															<?=$lib["titulo"];?>
														</h5>

														<span>
															<?php 
															if ($lib["desde"]) {
																echo "desde: ".date("d/m/Y", strtotime($lib["desde"]))."<br>";
																if ($lib["hasta"] != "0000-00-00 00:00:00" && $lib["hasta"] != null) { 
																	echo "hasta: ".date("d/m/Y", strtotime($lib["hasta"]));
																}
															} else {
																echo "Siempre disponible";
															}
															?>
														</span>

														<button class="btn btn-default" type="">
															<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
														</button>
													</span>
												</a>
											</li>
											<?php
											}
										}
										?>
									</ul>
								</div>
							</div>


						<!--

						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingTwo">
								<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										Geometr&iacute;a <i class="fa fa-caret-down" aria-hidden="true"></i>
									</a>
								</h4>
							</div>

							<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
								<div class="panel-body">
									<ul class="item-row">
										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>

						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingThree">
								<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
										Medici&oacute;n <i class="fa fa-caret-down" aria-hidden="true"></i>
									</a>
								</h4>
							</div>

							<div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
								<div class="panel-body">
									<ul class="item-row">
										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						-->
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
		$.post("ajax/profe_lib.php", { id: $(this).attr('data-materia'), eje: $(this).attr('data-eje') }, function(data){
			$("#lib_container").html(data);
		});
	});

	$(".link-folder").click(function(e) {
		var eje = $(this).attr('data-eje');
		var materia = $(this).attr('data-materia');
		var folder = $(this).attr('data-folder');
		e.preventDefault();
		$.post("ajax/profe_lib.php", { id: materia, eje: eje, folder: folder }, function(data){
			$("#lib_container").html(data);
		});
	});

	$(".link_to_docs").click(function(e) {
		e.preventDefault();
		$.post("ajax/profe_lib_docs.php", { materia: <?=$_POST["id"];?>}, function(data){
			$("#lib_container").html(data);
		});
	})
});
</script>