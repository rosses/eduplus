<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");

$alumno = new Alumno($_SESSION["id"]);
$alumno->getMaterias();
$alumno->getTests($_POST["id"]);
?>
<div class="statistics-row">
	<div class="row">
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
			<div class="subjects-row2">
				<h5>ASIGNATURA</h5>
				<ul>
					<?php
					foreach ($alumno->materias as $id_materia=>$materia) {
					?>		
					<li class="<?=($id_materia == $_POST["id"] ? "subjects-stats-active" : "");?>" style="<?=($id_materia == $_POST["id"] ? "background-color: ".$materia["color"] : "");?>">
						<div class="subjects-infobox subj-x" style="border-left: 10px solid <?=$materia["color"];?>;" data-id="<?=$id_materia;?>">
							<div class="subjects-stats icon">
								<img src="images/subj/<?=$id_materia;?>_off.png" class="off" />
								<img src="images/subj/<?=$id_materia;?>_on.png" class="on" />
							</div>
							<div class="subjects-stats name"><?=$materia["name"];?></div>
							<div class="subjects-stats goal"><?php echo "<span class=\"b\">Meta</span><span>".$materia["ultima_psu"]."</span><span class=\"b\">Puntos</span>"; ?></div>
						</div>
					</li>
					<?php
					}
					?>							
				</ul>
			</div>	
		</div>
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

			<?php
			//echo "<pre>".print_r($alumno,1)."</pre>";
			if (!$_POST["test"]) { $_POST["test"] = key($alumno->tests); }

			$me = DB::queryFirstRow("SELECT * FROM user WHERE id = %s",$_SESSION["id"]);
			$test = DB::queryFirstRow("SELECT * FROM test WHERE id = %i", $_POST["test"]);
			$materia = DB::queryFirstRow("SELECT * FROM materia WHERE id = %i",$test["materia"]);
			if (count($alumno->tests)>0) {
			?>
			<div class="subjects-dashboard">
				<div class="statistics-row">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="statistics-box-b" style="border-top: 10px solid <?=$materia["color"];?>;">
								<div class="row">
									<div class="col-xs-12">
										<div class="tab-title text-center">
											Tu evolución en <?=$materia["name"];?>
										</div>
										<div class="tab-content text-center">
											<div id="activeGraph_general" style="height: 200px; width: 100%;"></div>	
											<script type="text/javascript">
											<?php

												$dataPoints = "["; 
												foreach ($alumno->tests as $test_alumno) {
													if ($test_alumno["materia"] == $test["materia"])
													$dataPoints .= "{ label: \"".$test_alumno["name"]."\", toolTipContent: \"{y} puntos <br />Realizado el ".$test_alumno["fecha"]."\", y: ".$test_alumno["puntaje_psu"]." },";
												}
												$dataPoints = substr($dataPoints,0,strlen($dataPoints)-1);
												$dataPoints .= "]";
											?>
											var chart = new CanvasJS.Chart("activeGraph_general", {
												animationEnabled: true,  
												axisY: {
													title: "Puntaje",
													suffix: "pts",
													prefix: "",
													gridThickness: 0
												},
												data: [{
													type: "splineArea",
													toolTipContent: "{y} puntos",
													//color: "rgba("+hexToRGB("<?=$materia["color"];?>")+",.7)",
													markerSize: 20,
													markerBorderThickness: 2,
													//markerColor: "rgba("+hexToRGB("<?=$materia["color"];?>")+",1)",
													dataPoints: <?=($dataPoints);?>
												}]});
											chart.render();
											$(".canvasjs-chart-credit").hide();
											</script>
											<br /><br />
										</div>
									</div>
									<div class="col-xs-4">
										<div class="tab-title text-center">
											<?=$materia["name"];?>
										</div>
										
										<div id="carouselTabs" class="carousel slide" data-ride="carousel" data-interval="false">
											<!-- Indicators -->
											<ol class="carousel-indicators">
												<li data-target="#carouselTabs" data-slide-to="0" class="active"></li>
												<li data-target="#carouselTabs" data-slide-to="1"></li>
											</ol>

											<!-- Wrapper for slides -->
											<div class="carousel-inner" role="listbox">
											  <div class="carousel-caption">
												<div class="item active">
													<ul class="nav nav-pills nav-stacked v-tabs" role="tablist">
													<?php
													foreach ($alumno->tests as $test_id=>$x) {
													?>
													<li role="presentation" class="active">
													<button class="btn btn-default btn-b <?=($_POST["test"] == $test_id ? "selected" : "");?> cargarResultados" data-materia="<?=$_POST["id"];?>" data-id="<?=$test_id;?>" style="width:100%; <?=($_POST["test"] == $test_id ? "background-color: ".$materia["color"].";" : "");?>">
													<?=$x["name"];?>
													</button>
													</li>
													<?php
													} 
													?>
													</ul>
												</div>
											  </div>
											</div>
										</div>
									</div>

									<div class="col-xs-8">
										<div class="tab-title text-center">
											Felicidades  <?=$me["name"];?> estas muy cerca de la meta!
										</div>

										<!-- Tab panes -->
										<div class="tab-content">
											<div class="tab-arrow">
												<img src="images/tab-arrow.png" width="100%" alt="">	
											</div>

											<div role="tabpanel" class="tab-pane active" id="tab_1">
												<div class="row stats-als-row">
													<div class="col-md-6 text-left">
														 <div class="text-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img class="" src="images/logo-helper.png" alt="" /></div>

														<?php if ($alumno->getPonderacionByMateria($_POST["id"]) > 0 && $alumno->materias[$_POST["id"]]["ultima_psu"] > 0) { 
															$full = 850;

															$miMeta = round($alumno->materias[$_POST["id"]]["points"] * 100 / $full);
															$miPuntaje = round($alumno->materias[$_POST["id"]]["ultima_psu"] * 100 / $full);
															$miPuntaje2 = round($alumno->materias[$_POST["id"]]["ultima_psu"] * 100 / $alumno->materias[$_POST["id"]]["points"]);
															
														?>
														<div class="goal-info">
															<!--<div class="text-a">Felicidades <?=$me["name"];?> estas muy cerca de la meta!</div>-->
															<!--<div class="text-b blue-light">Según puntaje obtenido en <?=$test["name"];?></div>-->
														</div>
														<div class="goal-slide text-center">
															<br /><br />
															<div class="goal-bar">
																<div class="goal-bar-fill"></div>
																<div class="goal-bar-out" style="width: <?=(100 - $miMeta);?>%;"></div>

																<div class="goal-mimeta_pts" style="left: calc(<?=$miPuntaje;?>% - 32px);"><?=$alumno->tests[$_POST["test"]]["puntaje_psu"];?> pts.</div>
																<div class="goal-mipuntaje" style="left: calc(<?=$miPuntaje;?>% - 16px);"></div>
																<div class="goal-mimeta_por" style="left: calc(<?=$miPuntaje;?>% - 32px);"><?=$miPuntaje2;?>%</div>

																<div class="goal-mimeta_pts" style="left: calc(<?=$miMeta;?>% - 32px);"><?=$alumno->materias[$_POST["id"]]["points"];?> pts.</div>
																<div class="goal-mimeta" style="left: calc(<?=$miMeta;?>% - 16px);"></div>
																<div class="goal-mimeta_por" style="left: calc(<?=$miMeta;?>% - 32px);">META</div>

															</div>

															<!--<img src="images/goal-graph.png" alt="">-->
														</div>
														<?php } else if ($alumno->materias[$_POST["id"]]["ultima_psu"] > 0) { ?>
														<div class="goal-info">
															<div class="text-a">
																<?=$me["name"];?> obtuviste <?=$alumno->materias[$_POST["id"]]["ultima_psu"];?> puntos pero no conocemos tu meta <br /><br />
																<a href="index.php" class="btn btn-primary">Configurala aquí</a></div>
														</div>
														<?php } else {
														?>
														<div class="goal-info">
															<div class="text-a">
																<?=$me["name"];?> no has participado en este test <br /><br />
																<a href="index.php?load=test&id=<?=$test["id"];?>" class="btn btn-primary">Participar ahora</a></div>
														</div>
														<?php
														} 
														?>
													</div>

													<div class="col-md-6 text-center">
														<h5>Respuestas</h5>
														<?php
															$pregs = DB::queryFirstField("SELECT COUNT(*) FROM preg WHERE test_id = %i", $test["id"]);
															$testData = DB::query("SELECT ts.* FROM test_end_detail ts, test_end_head th WHERE ts.user_id = %i AND ts.test_id = %i AND ts.packet_id = th.id AND th.isLast = 1",$_SESSION["id"],$test["id"]);
															$resOK = 0;
															$resER = 0;
															
															foreach ($testData as $ts) {
																if ($ts["isOk"] == 1) { $resOK++; }
																if ($ts["isOk"] == 0) { $resER++; }
															}
															$resWH = ($pregs - $resOK - $resER);

															$resOK = round($resOK * 100 / $pregs);
															$resER = round($resER * 100 / $pregs);
															$resWH = round($resWH * 100 / $pregs);

															if (count($testData) == 0) {
																echo "<br><br>No has participado en este test";
															}
															else {
														?>
														<div id="donuts" style="width: 100%; height: 170px; margin: 0 auto"></div>
														<script type="text/javascript">
														var chart = new CanvasJS.Chart("donuts", {
															animationEnabled: true,
															title:{
																text: ""
															},
															data: [{
																type: "doughnut",
																//startAngle: 60,
																innerRadius: 50,
																showInLegend: false,
																indexLabelFontSize: 11,
																indexLabel: "{label} - #percent%",
																toolTipContent: "<b>{label}:</b> {y} (#percent%)",
																dataPoints: [
																	{ y: <?=$resER;?>, label: "Malas", color: "#A0E061" },
																	{ y: <?=$resOK;?>, label: "Correctas", color: "#50E3C2" },
																	{ y: <?=$resWH;?>, label: "En blanco", color: "#41A7FF" }
																]
															}]
														});
														chart.render();
														</script>
														<a href="#" class="ver_respuesta_test btn btn-default btn-a pull-right" data-user="<?php echo $_SESSION["id"]; ?>" data-test="<?php echo $test["id"]; ?>">Ver respuestas</a>
														<!---<img src="images/chart2_legend.png" alt="">-->
														<?php } ?>
													</div>
												</div>
												
												<div class="clearfix"></div>
												
												<div class="row stats-als-row">
													<div class="col-md-6">

														<h5>Porcentaje de aprobación por eje temático</h5>
														<?php
															$p = DB::query("SELECT e.*, m.name mname,
																				  (SELECT COUNT(*) FROM test_end_detail ts WHERE ts.user_id = %i AND ts.test_id = %i AND ts.materia = m.id AND ts.eje = e.id) all_preg,
																				  (SELECT COUNT(*) FROM test_end_detail ts WHERE ts.user_id = %i AND ts.test_id = %i AND ts.materia = m.id AND ts.eje = e.id AND ts.isOk = 1) all_ok_preg 
																			FROM eje e, materia m 
																			WHERE e.active = 1 AND e.parent = m.id AND m.id = %i",
																		   $_SESSION["id"],$test["id"],$_SESSION["id"],$test["id"],$test["materia"]);
															$impresos = 0;
															foreach ($p as $e) {
																if ($e["all_preg"] > 0) {
																	if ($impresos == 0) {
																		echo '<div class="stat2">';
																	}
																	$ppp = round($e["all_ok_preg"] * 100 / $e["all_preg"]);
																	echo '<div class="stat2-g">
																			<div class="stat2-g1" style="top: calc('.(100 - $ppp).'% - 20px);">'.$ppp.'%</div>
																			<div class="stat2-g2" style="height: '.$ppp.'%;"></div>
																			<div class="stat2-g3"><strong>'.$e["name"].'</strong><br />'.$e["all_ok_preg"].' / '.$e["all_preg"].'</div>
																		  </div>';
																	$impresos++;
																}				
															}

															if ($impresos == 0) {
																echo "<br><br>No has participado en este test";
															}
															else {
																echo "</div>";		
															}
														?>


													</div>
													<div class="col-md-6 text-center">
														<h5>Tu curso en <?=$test["name"];?></h5>
														<?php 
															if (!$miPuntaje) {
																echo "<br><br>No has participado en este test";
															}
															else {
																echo '<div class="stat3">
																	  <div class="stat3-g">
																		<div class="stat3-g1" style="top: calc('.(100 - $miPuntaje).'% - 5px);">'.$alumno->tests[$_POST["test"]]["puntaje_psu"].'pts</div>
																		<div class="stat3-g2 stat3-g2-1" style="height: '.$miPuntaje.'%;"></div>
																		<div class="stat3-g3">Mi puntaje</div>
																	  </div>';

																/* get cursos alumno */
																$urelations = DB::query("SELECT ur.*, c.name, (
																	SELECT  AVG(tp.points)
															        FROM 	test_end_head tp, 
															                user_relations ur1, 
															                course c1, 
															                user u 
															        WHERE  	tp.materia = %i AND 
															                tp.user_id = u.id AND 
															                ur1.user_id = u.id AND 
															                ur1.course_id = c1.id AND 
															                c1.id = c.id AND 
															                ur1.course_id = c.id AND 
															                tp.test_id = %i AND 
															                tp.points > 0 AND 
															                tp.isLast = 1
																) promedio FROM user_relations ur, course c WHERE ur.user_id = %i AND ur.course_id = c.id",$_POST["id"],$test["id"],$me["id"]);
																foreach ($urelations as $ur) {
																	$cursoPuntaje = round($ur["promedio"] * 100 / $full);
																	echo '<div class="stat3-g">
																			<div class="stat3-g1" style="top: calc('.(100 - $cursoPuntaje).'% - 5px);">'.round($ur["promedio"]).'pts</div>
																			<div class="stat3-g2 stat3-g2-2" style="height: '.$cursoPuntaje.'%;"></div>
																			<div class="stat3-g3">Promedio '.$ur["name"].'</div>
																		  </div>';
																}
																echo '</div>';
															}
														?>
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
			<?php
			} else {
				echo "<br /><br />
				<div class='row'>
					<div class='col-md-12 text-center'>
					<h3>
					<i class='fa fa-exclamation-triangle fa-3x'></i>
					<br />
					<br />
					No hay datos que mostrar
					</h3>
					</div>
				</div>";
			}
			?>

		</div>
	</div>
</div>
