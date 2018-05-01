<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");
?>
<div id="pageContainerInner">
	<div id="menuHelper" class="no-space">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
					<a href="#" class="logo-helper">
						<!-- <img src="images/logo-helper.png" alt=""> -->
					</a>
				</div>

				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">


					<div class="search-cont">
						<div class="vcenter">
							<div class="tabcell">
								<select class="form-control inp-school-b" id="reforzamientoChanger">
								<?php
								$trs = DB::query("SELECT tr.*, c.id course_id, c.name course_name, m.id materia_id, m.name materia_name
												  FROM teacher_relations tr, course c, materia m 
												  WHERE tr.teacher_id = %i AND tr.course_id = c.id AND tr.materia_id = m.id ORDER BY c.id ASC",$_SESSION["id"]);
								foreach ($trs as $tr) {
									if (!$_POST["rel"]) { $_POST["rel"] = $tr["course_id"]."-".$tr["materia_id"]; }

									if (!$curso && !$materia) {
										$xd = explode("-",$_POST["rel"]);	
										$curso = $xd[0];
										$materia = $xd[1];
									}
									
									echo "<option value='".$tr["course_id"]."-".$tr["materia_id"]."' ".($tr["materia_id"] == $materia && $tr["course_id"] == $curso ? "selected" : "").">".$tr["course_name"]." / ".$tr["materia_name"]."</option>";
								}
								?>
								</select>
							</div>
						</div>
					</div>
				</div>
				
				<?php
					if (!$_POST["group"]) {
						$_POST["group"] = "group80";
					}
				?>
				<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">

					<div class="search-cont">
						<div class="vcenter">
							<div class="tabcell">
								<div class="status-icon-row text-center">
									<button class="group_call btn btn-status btn-a btn-img <?=($_POST["group"]=="group80" ? "on":"");?>" data-group="group80" data-rel="<?=$_POST["rel"];?>">
										<img src="images/icon-check-on.png" width="100%;" alt="">
										<span><i class="fa fa-arrow-up"></i> 80%</span>
									</button>

									<button class="group_call btn btn-status btn-b btn-img <?=($_POST["group"]=="group50" ? "on":"");?>" data-rel="<?=$_POST["rel"];?>" data-group="group50">
										<img src="images/icon-dot.png" width="100%;" alt="">
										<span><i class="fa fa-arrow-up"></i> 50%</span>
									</button>

									<button class="group_call btn btn-status btn-c btn-img <?=($_POST["group"]=="group0" ? "on":"");?>" data-rel="<?=$_POST["rel"];?>" data-group="group0">
										<img src="images/icon-x.png" width="100%;" alt="">
										<span><i class="fa fa-arrow-down"></i> 50%</span>
									</button>
								</div>
							</div>
						</div>
					</div>

				</div>
	
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<div class="search-cont">
						<div class="vcenter">
							<div class="tabcell">
								<!--
								<select class="form-control inp-school-b">
									<option value="" disabled selected>Puntaje</option>
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
									<option>5</option>
								</select>
								-->
							</div>
						</div>
					</div>
				</div>


				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<a href="#" class="logo-helper">
						<?php
						$oCurso = new CursoMateria($curso,$materia);
						$oCurso->getGrupos();
						?>
		                <div class="c100 p<?=$oCurso->promedioPorcentaje;?>">
		                    <span><?=$oCurso->promedioPorcentaje;?>%</span>
		                    <div class="meta"><?=$oCurso->promedioPuntos;?> pts</div>
		                    <div class="slice">
		                        <div class="bar"></div>
		                        <div class="fill"></div>
		                    </div>
		                </div>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div id="pageBody">
		<div id="reinforcementSection">
			<div class="container"> <!-- -fluid -->
				<div class="row">
					<div class="col-xs-12">
						<?php
						if ($_POST["upload"]) {
						$eje = DB::queryFirstRow("select * from eje where id = %i",$_POST["upload"]);
						?>
						<div class="mainbox">
							<div class="row">
								<div class="col-xs-12 col-md-2 text-center">
									<a class="btn btn-default edu-btn-icon-back group_call" data-group="<?=$_POST["group"];?>" data-rel="<?=$_POST["rel"];?>" href="#" role="button">
										<i class="fa fa-arrow-left"></i>
										<img src="<?=$eje["icon"];?>" width="100%" alt="">
									</a>
								</div>

								<div class="col-xs-12 col-md-8">
									<h5 class="text-center m-tb float-left basicrow">Material de Reforzamiento para <?=$eje["name"];?></h5>

									<div class="mod-user-8 m-tb float-left basicrow">
										<ul>
											<?php
												$group = $oCurso->getGrupos($_POST["upload"]);
												$iterar = $group[$_POST["group"]]["alumnos"];
												if (count($iterar)==0) {
													echo "No hay alumnos activos";
												}
												else {
													foreach ($iterar as $alumno) {
													?>
													<li>
														<span class="student-thumb img-circle">
															<img src="<?=$alumno->image;?>" alt="<?=$alumno->getName(1);?>" title="<?=$alumno->getName(1);?>">
														</span>
														<br /><?=$alumno->getName(1);?>
													</li>
													<?php
													} 
												}
											?>
										</ul>
									</div>

									<div class="instruction-row text-center blue-light float-left">
										Acá puedes subir el material desde tu computadora o seleccionar el material desde la bibloteca de Edu Plus
									</div>

									<ul class="nav nav-pills edu-navpill-2 wide m-tb float-left basicrow">
										<li role="presentation" class="active">
											<a href="#"><i class="fa fa-paperclip"></i><span>Adjuntar archivo desde el PC</a></span>
										</li>

										<li role="presentation">
											<a href="#"><i class="fa fa-folder"></i><span>Adjuntar desde Edu Plus</a></span>
										</li>
									</ul>

									<div class="module-row basicrow float-left m-tb">
										<div class="file-box big">
											<div class="vcenter">
												<div class="tabcell">
													<i class="fa fa-cloud-upload" aria-hidden="true"></i> Tambi&eacute;n puedes arrastrar tu archivo ac&aacute;
												</div>

												 <div class="form-group">
												    <input type="file" id="exampleInputFile">
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
						<?php
						}
						else {
						?>
						<div class="subjects-box">
							<ul>
								<?php
								foreach ($oCurso->getEjes() as $eje) {
								?>
								<li class="subjects"> <!-- on -->
									<div class="status-icon">
										<?php 
										if ($_POST["group"]=="group80") { ?> <img src="images/icon-check-on.png" alt=""> <?php } 
										else if ($_POST["group"]=="group50") { ?> <img src="images/icon-dot.png" alt=""> <?php } 
										else if ($_POST["group"]=="group0") { ?> <img src="images/icon-x.png" alt=""> <?php } ?>
									</div>

									<div class="reinforcement-subjects-box">
										<div class="subjects-thumb">
											<img src="<?=$eje["icon"];?>" alt="">
										</div>

										<h3><?=$eje["name"];?></h3>

										<div class="profile-icon-row">
											<ul>
												<?php
													$gruposEje = $oCurso->getGrupos($eje["id"]);
													$iterar = $gruposEje[$_POST["group"]]["alumnos"];
													if (count($iterar) == 0) {
												?>
													No existen alumnos para este eje en este grupo
												<?php
													}
													else {
														$print=0;
														$nextUsers = 0;
														$names=array();
														foreach ($iterar as $alumno) {
															$print++;
															if ($print >= 5 && count($names)<4) { $names[] = $alumno->getName(1); }
															else if ($print<5) {
															?>
															<li class="thumb-pic img-circle">
																<img src="<?=$alumno->image;?>" alt="<?=$alumno->getName();?>" title="<?=$alumno->getName();?>">
															</li>
															<?php
															}
														}
														if (count($iterar)>4) {
															echo "<li class='thumb-pic img-circle' style='left:-25px;padding:5px;font-size:20px;'>+ ".(count($iterar) - 4)."</li>";
														}
													}
												?>
											</ul>
										</div>

										<div>
											<?php
												$too = (count($iterar) - count($names) - 4);
												if (count($names)>0) { echo "Tambien ".implode(", ",$names)." ".($too > 0 ? "+ ".$too : ""); }
											?>
										</div>

										<div>
											<?php
											if (count($iterar)>0) {
											?>
											<br />
											<a class="uploadCustomMaterial" href="#" data-group="<?=$_POST["group"];?>" data-eje="<?=$eje["id"];?>" data-rel="<?=$_POST["rel"];?>">Subir material</a>
											<?php
											}
											?>
										</div>
									</div>
								</li>
								<?php
								}
								?>
							</ul>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

	</div>	
</div>
