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
									<button class="btn btn-status btn-a btn-img <?=($_POST["group"]=="group80" ? "on":"");?>" data-group="group80" data-rel="<?=$_POST["rel"];?>">
										<img src="images/icon-check-on.png" width="100%;" alt="">
										<span><i class="fa fa-arrow-up"></i> 80%</span>
									</button>

									<button class="btn btn-status btn-b btn-img <?=($_POST["group"]=="group50" ? "on":"");?>" data-rel="<?=$_POST["rel"];?>" data-group="group50">
										<img src="images/icon-dot.png" width="100%;" alt="">
										<span><i class="fa fa-arrow-up"></i> 50%</span>
									</button>

									<button class="btn btn-status btn-c btn-img <?=($_POST["group"]=="group0" ? "on":"");?>" data-rel="<?=$_POST["rel"];?>" data-group="group0">
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
						$rows = DB::query("	SELECT 	u.id, 
													u.name, 
													IFNULL((SELECT tp.points FROM test_end_head tp WHERE tp.materia = tr.materia_id AND tp.user_id = u.id ORDER BY tp.cuando DESC LIMIT 1),0) psu,
													IFNULL((SELECT ug.points FROM user_goal ug WHERE ug.materia = tr.materia_id AND ug.id = u.id LIMIT 1),0) user_goal,
													tr.goal goal,
													u.image image
											FROM 	user_relations ur, 
													user u, 
													course c, 
													teacher_relations tr 
											WHERE 	ur.course_id = %i AND 
													ur.user_id = u.id AND 
													ur.course_id = c.id AND 
													tr.teacher_id = %i AND 
													tr.materia_id = %i AND 
													tr.course_id = c.id
										", $curso, $_SESSION["id"], $materia);
						$metaCurso = $rows[0]["goal"];
						$ptjePromedio = 0;
						$totalPtjes = 0;
						$prcntActual = 0;
						foreach ($rows as $row) {
							if ($row["psu"]>0) {
								$ptjePromedio += $row["psu"];
								$totalPtjes++;
							}
						}
						if ($ptjePromedio > 0 && $metaCurso > 0) {
							$ptjePromedio /= $totalPtjes;
							$prcntActual = round(($ptjePromedio * 100) / $metaCurso);
						}

						?>
		                <div class="c100 p<?=$prcntActual;?>">
		                    <span><?=$prcntActual;?>%</span>
		                    <div class="meta">Meta</div>
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
<?php	/*	<div id="reinforcementSection">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<div class="subjects-box">
							<ul>
								<?php
								$ejes = DB::query("SELECT * FROM eje e WHERE e.parent = %i",$materia);
								foreach ($ejes as $eje) {
								?>
								<li class="subjects"> <!-- on -->
									<div class="status-icon">
										<div class="g_<?=$_POST["group"];?>">
											<i class="fa fa-<?=($_POST["group"]=="group80" ? "check" : ($_POST["group"] == "group50" ? "circle" : "times"));?>"></i>
										</div>
									</div>

									<button class="btn btn-default btn-img">
										<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
									</button>

									<div class="reinforcement-subjects-box">
										<div class="subjects-thumb">
											<img src="<?=$eje["icon"];?>" alt="">
										</div>

										<h3><?=$eje["name"];?></h3>

										<div class="profile-icon-row">
											<ul>
												<?php

													// search alumnos 
													$correctas = DB::query("SELECT 	ts.user_id, 
																					(select u.name from user u where u.id = ts.user_id) user_name, 
																					(select u.image from user u where u.id = ts.user_id) user_pic, 
																					COUNT(*) qty 
																			FROM 	test_end_detail ts, 
																					user_relations ur 
																			WHERE 	ts.isOk = 1 AND 
																					ts.test_id = (SELECT tp.test_id FROM test_end_head tp WHERE tp.user_id = ur.user_id AND tp.materia = %i ORDER BY tp.cuando DESC LIMIT 1) AND 
																					ts.user_id = ur.user_id AND 
																					ur.course_id = %i AND 
																					ts.eje = %i 
																			GROUP BY ts.user_id ORDER BY qty DESC", $materia, $curso, $eje["id"]);


													//$for = DB::query("SELECT p.*, e.name eje_name, e.id eje_id FROM preg p, eje e WHERE p.test_id = (SELECT MAX(t.id) FROM test t WHERE t.materia = %i) AND p.eje = e.id ORDER BY p.orden ASC", $materia);
													$for = DB::query("SELECT p.*, e.name eje_name, e.id eje_id FROM preg p, eje e WHERE p.test_id = 5 AND p.eje = e.id ORDER BY p.orden ASC", $materia);

													//print_r($for); echo $materia;

													$totalPreguntasTest = count($for);
													$preguntasPorEje = array();
													foreach ($for as $preg) {
														$preguntasPorEje[$preg["eje_id"]]++;
													}

													if ($_POST["group"] == "group80") {
														$rango = round($totalPreguntasTest * 0.8);
													}
													else if ($_POST["group"] == "group50") {
														$rango = round($totalPreguntasTest * 0.5);
													}
													else if ($_POST["group"] == "group0") {
														$rango = 0;
													}
													
													$elmax = 4;
													$llevo = 0;
													foreach ($correctas as $c) {
														if ($c["qty"] >= $rango && $llevo < $elmax) {
															$llevo++;
												?>
												<li class="thumb-pic img-circle">
													<img src="<?=($c["user_pic"]!="" ? $c["user_pic"] : "images/default.jpg");?>" alt="">
												</li>
												<?php
														}
													}
												?>

											</ul>
										</div>

										<div class="option-row">
											<a href="#">Subir material</a>

											<a href="#">Comentario</a>
										</div>
									</div>
								</li>
								<?php } ?>
							</ul>
						</div>
					</div>
					
					<!--
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<div class="summary-box">
							<div class="subject-box">
								<div class="row">
									<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
										<img src="images/icon-algebra.png" width="100%" alt="">
									</div>

									<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
										<h4>
											&Aacute;lgebra
										</h4>

										<div class="progress-box">
											<div class="row">
												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
													680
												</div>

												<div class="col-xs-4 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4 text-right">
													780
												</div>
											</div>

											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="progress">
														<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
															<span class="sr-only">60% Complete</span>
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													Actual  /  Meta
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<hr/>

							<div class="subjects-inforow">
								<div class="row">
									<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
										<span>Cantidad de Alumnos</span>
									</div>

									<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
										<span>14</span>
									</div>

									<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
										<img src="images/icon-check-on.png" width="100%" alt="">
									</div>
								</div>

								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<span>Resumen de alumnos de los últimos 6 test.</span>
									</div>
								</div>
							</div>

							<div id="carousel-students-list" class="carousel slide" data-ride="carousel" data-interval="10000">
								<ol class="carousel-indicators">
									<li data-target="#carousel-students-list" data-slide-to="0" class="active"></li>
									<li data-target="#carousel-students-list" data-slide-to="1"></li>
								</ol>

								<div class="carousel-inner" role="listbox">
									<div class="item active">
										<div class="students-list">
											<ul>
												<li class="on">
													<div class="student-thumb img-circle">
														<img src="images/profile-pic.png" alt="">
													</div>
												
													<div class="student-info">
														<div class="row">
															<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																Catalina Rojas S
															</div>

															<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																680pts
															</div>
														</div>
													</div>

													<div class="white-box student-toolbar">
														<div class="data-cont text-center">
															<ul>
																<li>T1</li>

																<li>T2</li>

																<li>T3</li>

																<li>T4</li>

																<li>T5</li>

																<li>T6</li>

																<li>
																	<img src="images/icon-check-on.png" width="18" alt="">
																</li>
															</ul>

															<ul>
																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>
															</ul>
														
															<button class="btn btn-default btn-img">
																<i class="fa fa-ellipsis-v" aria-hidden="true"></i>

																<span class="document-opt">
																	<ul>
																		<li>
																			<a href=""><i class="fa fa-share-alt" aria-hidden="true"></i> Compartir</a>
																		</li>

																		<li>
																			<a href=""><i class="fa fa-cloud-download" aria-hidden="true"></i> Descargar en .zip</a>
																		</li>

																		<li>
																			<a href=""><i class="fa fa-print" aria-hidden="true"></i> Imprimir</a>
																		</li>

																		<li>
																			<a href=""> Abrir en PDF</a>
																		</li>
																	</ul>
																</span>
															</button>
														</div>
													</div>
												</li>

												<li>
													<div class="student-thumb img-circle">
														<img src="images/profile-pic.png" alt="">
													</div>
												
													<div class="student-info">
														<div class="row">
															<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																Catalina Rojas S
															</div>

															<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																680pts
															</div>
														</div>
													</div>

													<div class="white-box student-toolbar">
														<div class="data-cont text-center">
															<ul>
																<li>T1</li>

																<li>T2</li>

																<li>T3</li>

																<li>T4</li>

																<li>T5</li>

																<li>T6</li>

																<li>
																	<img src="images/icon-check-on.png" width="18" alt="">
																</li>
															</ul>

															<ul>
																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>
															</ul>
														
															<button class="btn btn-default btn-img">
																<i class="fa fa-ellipsis-v" aria-hidden="true"></i>

																<span class="document-opt">
																	<ul>
																		<li>
																			<a href=""><i class="fa fa-share-alt" aria-hidden="true"></i> Compartir</a>
																		</li>

																		<li>
																			<a href=""><i class="fa fa-cloud-download" aria-hidden="true"></i> Descargar en .zip</a>
																		</li>

																		<li>
																			<a href=""><i class="fa fa-print" aria-hidden="true"></i> Imprimir</a>
																		</li>

																		<li>
																			<a href=""> Abrir en PDF</a>
																		</li>
																	</ul>
																</span>
															</button>
														</div>
													</div>
												</li>

												<li>
													<div class="student-thumb img-circle">
														<img src="images/profile-pic.png" alt="">
													</div>
												
													<div class="student-info">
														<div class="row">
															<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																Catalina Rojas S
															</div>

															<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																680pts
															</div>
														</div>
													</div>

													<div class="white-box student-toolbar">
														<div class="data-cont text-center">
															<ul>
																<li>T1</li>

																<li>T2</li>

																<li>T3</li>

																<li>T4</li>

																<li>T5</li>

																<li>T6</li>

																<li>
																	<img src="images/icon-check-on.png" width="18" alt="">
																</li>
															</ul>

															<ul>
																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>
															</ul>
														
															<button class="btn btn-default btn-img">
																<i class="fa fa-ellipsis-v" aria-hidden="true"></i>

																<span class="document-opt">
																	<ul>
																		<li>
																			<a href=""><i class="fa fa-share-alt" aria-hidden="true"></i> Compartir</a>
																		</li>

																		<li>
																			<a href=""><i class="fa fa-cloud-download" aria-hidden="true"></i> Descargar en .zip</a>
																		</li>

																		<li>
																			<a href=""><i class="fa fa-print" aria-hidden="true"></i> Imprimir</a>
																		</li>

																		<li>
																			<a href=""> Abrir en PDF</a>
																		</li>
																	</ul>
																</span>
															</button>
														</div>
													</div>
												</li>
											</ul>
										</div>
									</div>

									<div class="item">
										<div class="students-list">
											<ul>
												<li class="">
													<div class="student-thumb img-circle">
														<img src="images/profile-pic.png" alt="">
													</div>
												
													<div class="student-info">
														<div class="row">
															<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																Catalina Rojas S
															</div>

															<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																680pts
															</div>
														</div>
													</div>

													<div class="white-box student-toolbar">
														<div class="data-cont text-center">
															<ul>
																<li>T1</li>

																<li>T2</li>

																<li>T3</li>

																<li>T4</li>

																<li>T5</li>

																<li>T6</li>

																<li>
																	<img src="images/icon-check-on.png" width="18" alt="">
																</li>
															</ul>

															<ul>
																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>
															</ul>
														
															<button class="btn btn-default btn-img">
																<i class="fa fa-ellipsis-v" aria-hidden="true"></i>

																<span class="document-opt">
																	<ul>
																		<li>
																			<a href=""><i class="fa fa-share-alt" aria-hidden="true"></i> Compartir</a>
																		</li>

																		<li>
																			<a href=""><i class="fa fa-cloud-download" aria-hidden="true"></i> Descargar en .zip</a>
																		</li>

																		<li>
																			<a href=""><i class="fa fa-print" aria-hidden="true"></i> Imprimir</a>
																		</li>

																		<li>
																			<a href=""> Abrir en PDF</a>
																		</li>
																	</ul>
																</span>
															</button>
														</div>
													</div>
												</li>

												<li>
													<div class="student-thumb img-circle">
														<img src="images/profile-pic.png" alt="">
													</div>
												
													<div class="student-info">
														<div class="row">
															<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																Catalina Rojas S
															</div>

															<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																680pts
															</div>
														</div>
													</div>
												
													<div class="white-box student-toolbar">
														<div class="data-cont text-center">
															<ul>
																<li>T1</li>

																<li>T2</li>

																<li>T3</li>

																<li>T4</li>

																<li>T5</li>

																<li>T6</li>

																<li>
																	<img src="images/icon-check-on.png" width="18" alt="">
																</li>
															</ul>

															<ul>
																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>
															</ul>
														
															<button class="btn btn-default btn-img">
																<i class="fa fa-ellipsis-v" aria-hidden="true"></i>

																<span class="document-opt">
																	<ul>
																		<li>
																			<a href=""><i class="fa fa-share-alt" aria-hidden="true"></i> Compartir</a>
																		</li>

																		<li>
																			<a href=""><i class="fa fa-cloud-download" aria-hidden="true"></i> Descargar en .zip</a>
																		</li>

																		<li>
																			<a href=""><i class="fa fa-print" aria-hidden="true"></i> Imprimir</a>
																		</li>

																		<li>
																			<a href=""> Abrir en PDF</a>
																		</li>
																	</ul>
																</span>
															</button>
														</div>
													</div>
												</li>

												<li>
													<div class="student-thumb img-circle">
														<img src="images/profile-pic.png" alt="">
													</div>
												
													<div class="student-info">
														<div class="row">
															<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																Catalina Rojas S
															</div>

															<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																680pts
															</div>
														</div>
													</div>

													<div class="white-box student-toolbar">
														<div class="data-cont text-center">
															<ul>
																<li>T1</li>

																<li>T2</li>

																<li>T3</li>

																<li>T4</li>

																<li>T5</li>

																<li>T6</li>

																<li>
																	<img src="images/icon-check-on.png" width="18" alt="">
																</li>
															</ul>

															<ul>
																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>

																<li>66%</li>
															</ul>
														
															<button class="btn btn-default btn-img">
																<i class="fa fa-ellipsis-v" aria-hidden="true"></i>

																<span class="document-opt">
																	<ul>
																		<li>
																			<a href=""><i class="fa fa-share-alt" aria-hidden="true"></i> Compartir</a>
																		</li>

																		<li>
																			<a href=""><i class="fa fa-cloud-download" aria-hidden="true"></i> Descargar en .zip</a>
																		</li>

																		<li>
																			<a href=""><i class="fa fa-print" aria-hidden="true"></i> Imprimir</a>
																		</li>

																		<li>
																			<a href=""> Abrir en PDF</a>
																		</li>
																	</ul>
																</span>
															</button>
														</div>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>

								<a class="left carousel-control" href="#carousel-students-list" role="button" data-slide="prev">
									<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
									<span class="sr-only">Previous</span>
								</a>

								<a class="right carousel-control" href="#carousel-students-list" role="button" data-slide="next">
									<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
									<span class="sr-only">Next</span>
								</a> 
							</div>
						</div>
					</div>
					-->
				</div>
			</div>
		</div>*/ ?>


		<div id="reinforcementSection">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12">
						<div class="subjects-box">
							<ul>
								<li class="subjects on">
									<div class="status-icon">
										<img src="images/icon-check-on.png" alt="">
									</div>

									<div class="reinforcement-subjects-box">
										<div class="subjects-thumb">
											<img src="images/icon-algebra.png" alt="">
										</div>

										<h3>Álgebra</h3>

										<div class="profile-icon-row">
											<ul>
												<li class="thumb-pic img-circle">
													<img src="images/profile-pic.png" alt="">
												</li>
												
												<li class="thumb-pic img-circle">
													<img src="images/profile-pic.png" alt="">
												</li>

												<li class="thumb-pic img-circle">
													<img src="images/profile-pic.png" alt="">
												</li>

												<li class="thumb-pic img-circle">
													<img src="images/profile-pic.png" alt="">
												</li>
											</ul>
										</div>
									</div>
								</li>

								<li class="subjects">
									<div class="status-icon">
										<img src="images/icon-check-on.png" alt="">
									</div>

									<div class="reinforcement-subjects-box">
										<div class="subjects-thumb">
											<img src="images/icon-datos-y-azar.png" alt="">
										</div>

										<h3>Datos y azar</h3>

										<div class="profile-icon-row">
											<ul>
												<li class="thumb-pic img-circle">
													<img src="images/profile-pic.png" alt="">
												</li>
												
												<li class="thumb-pic img-circle">
													<img src="images/profile-pic.png" alt="">
												</li>

												<li class="thumb-pic img-circle">
													<img src="images/profile-pic.png" alt="">
												</li>

												<li class="thumb-pic img-circle">
													<img src="images/profile-pic.png" alt="">
												</li>
											</ul>
										</div>
									</div>
								</li>

								<li class="subjects">
									<div class="status-icon">
										<img src="images/icon-check-on.png" alt="">
									</div>

									<div class="reinforcement-subjects-box">
										<div class="subjects-thumb">
											<img src="images/icon-geometria.png" alt="">
										</div>

										<h3>Geometría</h3>

										<div class="profile-icon-row">
											<ul>
												<li class="thumb-pic img-circle">
													<img src="images/profile-pic.png" alt="">
												</li>
												
												<li class="thumb-pic img-circle">
													<img src="images/profile-pic.png" alt="">
												</li>

												<li class="thumb-pic img-circle">
													<img src="images/profile-pic.png" alt="">
												</li>

												<li class="thumb-pic img-circle">
													<img src="images/profile-pic.png" alt="">
												</li>
											</ul>
										</div>
									</div>
								</li>

								<li class="subjects">
									<div class="status-icon">
										<img src="images/icon-check-on.png" alt="">
									</div>

									<div class="reinforcement-subjects-box">
										<div class="subjects-thumb">
											<img src="images/icon-numeros.png" alt="">
										</div>

										<h3>Números</h3>

										<div class="profile-icon-row">
											<ul>
												<li class="thumb-pic img-circle">
													<img src="images/profile-pic.png" alt="">
												</li>
												
												<li class="thumb-pic img-circle">
													<img src="images/profile-pic.png" alt="">
												</li>

												<li class="thumb-pic img-circle">
													<img src="images/profile-pic.png" alt="">
												</li>

												<li class="thumb-pic img-circle">
													<img src="images/profile-pic.png" alt="">
												</li>
											</ul>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>	
</div>
