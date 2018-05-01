<?php
require("../../api.eduplus.enlanube.cl/sql.php");
sleep(1);
$oCurso = new CursoMateria($_POST["curso"],$_POST["materia"]);
// get alumnos

$tests = DB::query("SELECT 	t.*, 
					        IFNULL((SELECT  AVG(tp.points)
							        FROM 	test_end_head tp, 
							                user_relations ur, 
							                course c1, 
							                user u 
							        WHERE  tp.materia = %i AND 
							                tp.user_id = u.id AND 
							                ur.user_id = u.id AND 
							                ur.course_id = c1.id AND 
							                c1.id = %i AND 
							                ur.course_id = %i AND 
							                tp.test_id = t.id AND 
							                tp.points > 0 AND 
							                tp.isLast = 1
							        ),0) puntosPromedio  
					FROM 	test t
					WHERE 	t.isAll = 1 AND 
							t.materia = %i
					",$_POST["materia"],$_POST["curso"], $_POST["curso"], $_POST["materia"]);

if (!$_POST["test"]) {
	$_POST["test"] = $tests[0]["id"];
}
$test = DB::queryFirstRow("SELECT * FROM test where id = %i",$_POST["test"]);

$goal = DB::queryFirstField("SELECT goal FROM teacher_relations where course_id = %i AND materia_id = %i AND teacher_id = %i",$_POST["curso"],$_POST["materia"], $_SESSION["id"]);
$packet = DB::query("SELECT * FROM test_end_head tp, user_relations ur where tp.test_id = %i AND ur.course_id = %i AND ur.user_id = tp.user_id AND tp.isLast = 1",$_POST["test"],$_POST["curso"]);


$prom = 0;
$sum = 0;
$total_de_packets = 0;
foreach ($packet as $p) {
	$sum += $p["points"];
	$total_de_packets++;
}
if ($sum > 0 && $total_de_packets > 0) {
	$prom = round($sum / $total_de_packets);
}

$up = 0; 
$down = 0;
$max = 0;
$min = 850; 
$por = 0;

if ($goal > 0) {
	$por = round($prom * 100 / $goal);
}

$x = array();
foreach ($packet as $p) {
	if ($p["points"] < $min) {
		$min = $p["points"];
	}
	if ($p["points"] > $max) {
		$max = $p["points"];
	}

	if ($p["points"] >= $prom) {
		$up++;
	}
	else if ($p["points"] < $prom) {
		$down++;
	}
	$x[] = $p["points"];
}

if (count($x) > 0) {
	$desv = round(stats_standard_deviation($x));	
}
else {
	$desv = 0;
}

/* Gauss */

$pointsRs = DB::query("SELECT tp.points
				FROM 	test_end_head tp, 
				        user_relations ur, 
				        course c1, 
				        user u 
				WHERE  tp.materia = %i AND 
				        tp.user_id = u.id AND 
				        ur.user_id = u.id AND 
				        ur.course_id = c1.id AND 
				        c1.id = %i AND 
				        ur.course_id = %i AND 
				        tp.test_id = %i AND 
				        tp.points > 0 AND 
				        tp.isLast = 1
				",$_POST["materia"],$_POST["curso"], $_POST["curso"],$_POST["test"]);

$all = array();
foreach ($pointsRs as $prs) {
	$all[] = $prs["points"];
}

$nd = array();

for ($i = 150; $i < 851 ; $i += 25) {
	$t = 0;
	foreach ($all as $val) {
		if ($val >= ($i - 25) && $val < ($i)) {
			$t++;
		}
	}
	$nd[$i] = array("freq"=>$t, "normal_dist"=> 0, "probabilidad_porc"=>0);
}

foreach ($nd as $ndf_pje=>$ndf_array) {
	$nd[$ndf_pje]["normal_dist"] = round(@stats_dens_normal($ndf_pje, $prom, $desv),4);
}

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="report-cont">
				<div class="head-report-tab">
					<div class="row">
						<div class="col-xs-12 col-sm-3 col-md-3 col-xlg-3">
							<h3>
								Tests
							</h3>
						</div>

						<div class="col-xs-12 col-sm-9 col-md-9 col-xlg-9">
							<!-- Nav tabs -->
							<ul class="nav nav-pills" role="tablist">
							<?php

							foreach ($tests as $testx) {
							?>
								<li role="presentation" class="<?=($_POST["test"]==$testx["id"] ? "active":"");?>"> 
									<a href="#T<?=$testx["id"];?>" class="reloadTest" data-id="<?=$testx["id"];?>" aria-controls="T<?=$testx["id"];?>" role="tab" data-toggle="tab"><?=$testx["name"];?></a>
								</li>
							<?php
							
							}
							?>

							</ul>
							
						</div>
					</div>
				</div>

				<?php
				if (count($packet) == 0) {
				echo "<br /><br /><div class='row'>
					<div class='col-md-12 text-center'>
						<h3>
						<i class='fa fa-exclamation-triangle fa-3x'></i>
						<br />
						<br />
						No hay datos que mostrar
						</h3>
					</div>
				</div>";
				die();
				}
				//echo "<pre>".print_r(array_count_values($all),1)."</pre>";
				//echo "<pre>".print_r($nd,1)."</pre>";
				?>
				<div class="body-report">
					<div class="module-row">
						<div class="row">
							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
								<div class="module-row">
									<div class="white-box no-pad">
										<div class="whitebox-row box-title">
											<h4>Evoluci&oacute;n del periodo</h4>
											<p>
												<div id="activeGraph_<?=$_POST["curso"];?>_<?=$_POST["materia"];?>" style="height: 200px; width: 100%;"></div>	
											</p>
										</div>
									</div>
								</div>
								
								<div class="module-row">
									<div class="row">
										<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
											<div class="white-box no-pad">
												<div class="whitebox-row box-title">
													<div class="row">
														<div class="col-xs-12 title-module-b">
															<h4>Función Gaussiana</h4>
															<?=$test["name"];?>
														</div>

													</div>
												</div>

												<div class="graph-row">
													<!-- gauss -->
													<div id="chartContainerGauss" style="width: 100%; height: 205px;"></div>
													<script type="text/javascript">
													var chart = new CanvasJS.Chart("chartContainerGauss", {
														animationEnabled: true,
														axisY: {
															gridThickness: 0,
															lineThickness: 0,
															tickLength: 0,
															//title: "Frecuencia",
														    labelFormatter: function(){
														      return " ";
														    }
														},
														axisX: {
															lineThickness: 0,
															gridThickness: 0,
															tickLength: 0,
														    /*labelFormatter: function(){
														      return " ";
														    },*/
															//title: "Puntaje"
														},
														data: [
															{        
																type: "column",
														        indexLabel: "{y}",
														        indexLabelPlacement: "outside",  
														        indexLabelOrientation: "horizontal",
																toolTipContent: "frec. ({y})",
																indexLabelFormatter: function(e) {
																  if (e.dataPoint.y === 0)
																    return "";
																  else
																    return e.dataPoint.y;
																},
																color: "rgba(77,161,255,0.4)",
																dataPoints: [
																	<?php
																	$gauss = "";
																	$maxFreq = 0;
																	$maxNd = 0;
																	foreach ($nd as $points=>$p) {
																		$gauss .= "{x:".$points.", y:".$p["freq"]."},";
																		if ($p["freq"] > $maxFreq) {
																			$maxFreq = $p["freq"];
																		}
																		if ($p["normal_dist"] > $maxNd) {
																			$maxNd = $p["normal_dist"];
																		}
																	}
																	echo substr($gauss,0,strlen($gauss)-1);

																	// tabla de relacion
																	foreach ($nd as $points=>$p) {
																		if ($maxNd > 0) {
																			$porcentaje = ($p["normal_dist"] * 100 / $maxNd);
																		} else {
																			$porcentaje = 0;
																		}
																		$punto = ($maxFreq * $porcentaje / 100);
																		$nd[$points]["p"] = round($punto,8);
																	}
																	//print_r($nd);

																	?>
																]
															}/*,
															{
																type: "spline",
																toolTipContent: "{y} dist.normal",
																color: "rgba(77,161,255,1)",
																dataPoints: [
																	<?php
																	$gauss = "";
																	foreach ($nd as $points=>$p) {
																		$gauss .= "{x:".$points.", y:".$p["p"].", markerType: 'none', toolTipContent: '".$p["normal_dist"]."'},";
																	}
																	echo substr($gauss,0,strlen($gauss)-1);
																	?>
																]
															}	*/				
														]
													});

													chart.render();
													</script>
												</div>
											</div>
										</div>

										<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
											<div class="white-box no-pad">
												<div class="whitebox-row box-title">
													<div class="row">
														<div class="col-xs-12 title-module-b">
															<h4>Acertación por Eje temático</h4>
															<?=$test["name"];?>
														</div>
													</div>
												</div>

												<div class="graph-row text-center">
												<?php
												//print_r($test); echo "<hr>";
												//print_r($_POST); echo "<hr>";
												$p = DB::query("SELECT e.*, 
													 m.name mname,
													 (SELECT COUNT(*) FROM test_end_detail ts WHERE ts.test_id = %i AND ts.materia = m.id AND ts.eje = e.id AND EXISTS(SELECT * FROM user_relations ur WHERE ur.user_id = ts.user_id AND ur.course_id = %i)) all_preg,
													 (SELECT COUNT(*) FROM test_end_detail ts WHERE ts.test_id = %i AND ts.materia = m.id AND ts.eje = e.id AND ts.isOk = 1 AND EXISTS(SELECT * FROM user_relations ur WHERE ur.user_id = ts.user_id AND ur.course_id = %i)) all_ok_preg 
													 FROM eje e, materia m 
													 WHERE e.active = 1 AND e.parent = m.id AND m.id = %i",
													 $test["id"],$_POST["curso"],
													 $test["id"],$_POST["curso"],
													 $test["materia"]);

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
																<div class="stat2-g3"><strong>'.$e["name"].'</strong></div>
															  </div>';
														// <div class="stat2-g3"><strong>'.$e["name"].'</strong><br />'.$e["all_ok_preg"].' / '.$e["all_preg"].'</div>
														// no puedo poner totales, porque no es constante, es un curso podria poner promedios
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
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
								<div class="module-row">
									<div class="white-box" style="height: 648px;">
										<div class="module-row">
											<div class="general-progress">
												<p>
													Promedio General
												</p>

												<div class="progress-box">
													<div class="row">
														<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
															<?=$prom;?>
														</div>

														<div class="col-xs-4 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4 text-right">
															<?=$goal;?>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
															<div class="progress">
																<div class="progress-bar" role="progressbar" aria-valuenow="<?=$por;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$por;?>%;">
																	<span class="sr-only"><?=$por;?>% Complete</span>
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

										<hr/>


										
										<div class="resume-pts">
											<div class="module-row">
												<div class="row">
													<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
														Promedio
													</div>

													<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
														<?=$prom;?>pts
													</div>
												</div>
											</div>

											<div class="module-row">
												<div class="row">
													<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
														Casos sobre la media 
													</div>

													<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
														<?=$up;?>
													</div>
												</div>
											</div>

											<div class="module-row">
												<div class="row">
													<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
														Casos bajo la media 
													</div>

													<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
														<?=$down;?>
													</div>
												</div>
											</div>


											<div class="module-row">
												<div class="row">
													<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
														Cantidad de evaluaciones
													</div>

													<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
														<?=($up+$down);?>
													</div>
												</div>
											</div>

											<div class="module-row">
												<div class="row">
													<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
														M&aacute;ximo
													</div>

													<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
														<?=$max;?>pts
													</div>
												</div>
											</div>

											<div class="module-row">
												<div class="row">
													<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
														M&iacute;nimo
													</div>

													<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
														<?=$min;?>pts
													</div>
												</div>
											</div>

											<div class="module-row">
												<div class="row">
													<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
														Desviasión est&aacute;ndar
													</div>

													<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
														<?=$desv;?>pts
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="module-row">
						<div id="reportTabPanel">
							<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<h4 class="panel-title">
											<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
												Detalle <?=$test["name"];?> <i class="fa fa-caret-down" aria-hidden="true"></i>
											</a>
										</h4>
									</div>

									<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
										<div class="white-box no-pad">
											<div class="panel-body table">
												<div class="table-responsive text-center">
													<table class="table table-striped table-hover table-condensed">
														<thead>
															<tr>
																<th class="text-center">Pregunta</th>
																<th class="text-center">Eje</th>
																<th class="text-center">% Correcta</th>
																<th class="text-center">% Incorrecta</th>
																<th class="text-center">% En blanco</th>
																<th class="text-center">A</th>
																<th class="text-center">B</th>
																<?php if ($test["qty"] > 2) { ?> <th class="text-center">C</th><?php } ?>
																<?php if ($test["qty"] > 3) { ?> <th class="text-center">D</th><?php } ?>
																<?php if ($test["qty"] > 4) { ?> <th class="text-center">E</th><?php } ?>
																<?php if ($test["qty"] > 5) { ?> <th class="text-center">F</th><?php } ?>
																<?php if ($test["qty"] > 6) { ?> <th class="text-center">G</th><?php } ?>
																<?php if ($test["qty"] > 7) { ?> <th class="text-center">H</th><?php } ?>
																<th class="text-center">En blanco</th>
															</tr>
														</thead>
														
														<?php

														$for = DB::query("SELECT p.*, e.name eje_name, e.id eje_id, 
																		  (SELECT COUNT(*) FROM test_end_detail ts WHERE ts.test_id = p.test_id AND ts.preg = p.id AND ts.isOk = 1) win,
																		  (SELECT COUNT(*) FROM test_end_detail ts WHERE ts.test_id = p.test_id AND ts.preg = p.id AND ts.isOk = 0) lose, 
																		  (SELECT COUNT(*) FROM test_end_detail ts WHERE ts.test_id = p.test_id AND ts.preg = p.id AND ts.reply = 0) A, 
																		  (SELECT COUNT(*) FROM test_end_detail ts WHERE ts.test_id = p.test_id AND ts.preg = p.id AND ts.reply = 1) B, 
																		  (SELECT COUNT(*) FROM test_end_detail ts WHERE ts.test_id = p.test_id AND ts.preg = p.id AND ts.reply = 2) C, 
																		  (SELECT COUNT(*) FROM test_end_detail ts WHERE ts.test_id = p.test_id AND ts.preg = p.id AND ts.reply = 3) D, 
																		  (SELECT COUNT(*) FROM test_end_detail ts WHERE ts.test_id = p.test_id AND ts.preg = p.id AND ts.reply = 4) E, 
																		  (SELECT COUNT(*) FROM test_end_detail ts WHERE ts.test_id = p.test_id AND ts.preg = p.id AND ts.reply = 5) F, 
																		  (SELECT COUNT(*) FROM test_end_detail ts WHERE ts.test_id = p.test_id AND ts.preg = p.id AND ts.reply = 6) G, 
																		  (SELECT COUNT(*) FROM test_end_detail ts WHERE ts.test_id = p.test_id AND ts.preg = p.id AND ts.reply = 7) H
																		  FROM preg p, eje e WHERE p.test_id = %i AND p.eje = e.id ORDER BY p.orden ASC",$test["id"]);
														$i = 0;
														
														$totalPreguntasTest = count($for);
														$preguntasPorEje = array();
														foreach ($for as $preg) {
															$i++;
															$universoRespuestas = $preg["win"] + $preg["lose"];
															$porcentajeWin = round($preg["win"] * 100 / $universoRespuestas);
															$porcentajeLose = round($preg["lose"] * 100 / $universoRespuestas);
															$porcentajeWhite = 100 - ($porcentajeWin + $porcentajeLose);
															$preguntaWhite = 0;
															$preguntasPorEje[$preg["eje_id"]]++;
														?>
														<tr>
															<td><?=$i;?></td>
															<td><?=$preg["eje_name"];?></td>
															<td><?=($porcentajeWin);?>%</td> 
															<td><?=($porcentajeLose);?>%</td>
															<td><?=($porcentajeWhite);?>%</td>
															<td><span class="<?=($preg["correct_id"]==0 ? "active":"");?>"><?=$preg["A"];?></span></td>
															<td><span class="<?=($preg["correct_id"]==1 ? "active":"");?>"><?=$preg["B"];?></span></td>
															<?php if ($test["qty"] > 2) { ?> <td><span class="<?=($preg["correct_id"]==2 ? "active":"");?>"><?=$preg["C"];?></span></td><?php } ?>
															<?php if ($test["qty"] > 3) { ?> <td><span class="<?=($preg["correct_id"]==3 ? "active":"");?>"><?=$preg["D"];?></span></td><?php } ?>
															<?php if ($test["qty"] > 4) { ?> <td><span class="<?=($preg["correct_id"]==4 ? "active":"");?>"><?=$preg["E"];?></span></td><?php } ?>
															<?php if ($test["qty"] > 5) { ?> <td><span class="<?=($preg["correct_id"]==5 ? "active":"");?>"><?=$preg["F"];?></span></td><?php } ?>
															<?php if ($test["qty"] > 6) { ?> <td><span class="<?=($preg["correct_id"]==6 ? "active":"");?>"><?=$preg["G"];?></span></td><?php } ?>
															<?php if ($test["qty"] > 7) { ?> <td><span class="<?=($preg["correct_id"]==7 ? "active":"");?>"><?=$preg["H"];?></span></td><?php } ?>
															<td><?=$preguntaWhite;?></td>
														</tr>
														<?php
														}
														?>
													</table>
												</div>

											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>



					<div class="module-row">
						<div id="reportTabPanel">
							<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne2">
										<h4 class="panel-title">
											<a role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2" aria-expanded="true" aria-controls="collapseOne2">
												Vista detallada por eje temático <?=$test["name"];?> <i class="fa fa-caret-down" aria-hidden="true"></i>
											</a>
										</h4>
									</div>

									<div id="collapseOne2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne2">
										<div class="mainbox">
											<div class="panel-body table">
												<ul class="nav nav-pills edu-navpill-5 m-b">
												<?php
												$ejes = DB::query("SELECT * FROM eje e WHERE e.parent = %i AND e.active = 1", $_POST["materia"]);
												?>
												<li role="presentation" class="active"> 
													<a href="#E0" aria-controls="E0" role="tab" data-toggle="tab">Todos los ejes</a>
												</li>
												<?php
												foreach ($ejes as $eje) {
												?>
												<li role="presentation"> 
													<a href="#E<?=$eje["id"];?>" aria-controls="E<?=$eje["id"];?>" role="tab" data-toggle="tab"><?=$eje["name"];?></a>
												</li>
												<?php
												}

												$rango80 = round($totalPreguntasTest * 0.8);
												$rango50 = round($totalPreguntasTest * 0.5);

												$correctas = DB::query("SELECT ts.user_id, (select u.name from user u where u.id = ts.user_id) user_name, COUNT(*) qty FROM test_end_detail ts, user_relations ur WHERE ts.isOk = 1 AND ts.test_id = %i AND ts.user_id = ur.user_id AND ur.course_id = %i GROUP BY ts.user_id ORDER BY qty DESC",$test["id"], $_POST["curso"]);

												$alumnosRango80 = 0;
												$alumnosRango50 = 0;
												$alumnosRango0 = 0;
												$alumnosTotal = count($correctas);
												foreach ($correctas as $c) {
													if ($c["qty"] >= $rango80) { $alumnosRango80 += 1; }
													else if ($c["qty"] >= $rango50) { $alumnosRango50 += 1; }
													else { $alumnosRango0 += 1; }
												}
												?>
												</ul>


												<div class="tab-content">
												  <div id="E0" class="tab-pane stats-general-eje active">
												  	<div class="row">
														<div class="col-md-6">


															<table class="table table-striped text-center table-head edu-table">
																<thead>
																	<tr>
																		<th class="text-center" style="vertical-align: middle;" width="50%">
																			Rangos
																		</th>

																		<th class="text-center" width="50%">
																			<table width="100%" class="table-bordered text-center" style="border-top: 0; border-bottom: 0;">
																				<tbody>
																					<tr>
																						<td colspan="2" style="border-top: 0;">Alumnos</td>
																					</tr>

																					<tr>
																						<td width="50%" style="border-bottom: 0;">Números</td>
																						<td width="50%" style="border-bottom: 0;">%</td>
																					</tr>
																				</tbody>
																			</table>
																		</th>
																	</tr>
																</thead>

																<tbody>
																	<tr>
																		<td>
																			<table width="100%" class="text-center">
																				<tbody>
																					<tr>
																						<td width="50%">
																							<span class="icon-table"><img src="images/icon-check-on.png" alt=""></span>	
																						</td>

																						<td width="50%" class="text-left blue-light"><i class="fa fa-arrow-up"></i> 80%</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>

																		<td colspan="2">
																			<table width="100%" class="text-center">
																				<tbody>
																					<tr>
																						<td width="50%"><?=$alumnosRango80;?></td>
																						<td width="50%"><?=round($alumnosRango80 * 100 / $alumnosTotal);?>%</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>

																	<tr>
																		<td>
																			<table width="100%" class="text-center">
																				<tbody>
																					<tr>
																						<td width="50%">
																							<span class="icon-table"><img src="images/icon-dot.png" alt=""></span>	
																						</td>

																						<td width="50%" class="text-left blue-light">
																							<i class="fa fa-arrow-down"></i> 80% <i class="fa fa-arrow-up"></i> 50%
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>

																		<td colspan="2">
																			<table width="100%" class="text-center">
																				<tbody>
																					<tr>
																						<td width="50%"><?=$alumnosRango50;?></td>
																						<td width="50%"><?=round($alumnosRango50 * 100 / $alumnosTotal);?>%</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>

																	<tr>
																		<td>
																			<table width="100%" class="text-center">
																				<tbody>
																					<tr>
																						<td width="50%">
																							<span class="icon-table"><img src="images/icon-x.png" alt=""></span>	
																						</td>

																						<td width="50%" class="text-left blue-light">
																							<i class="fa fa-arrow-down"></i> 50%
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>

																		<td colspan="2">
																			<table width="100%" class="text-center">
																				<tbody>
																					<tr>
																						<td width="50%"><?=$alumnosRango0;?></td>
																						<td width="50%"><?=round($alumnosRango0 * 100 / $alumnosTotal);?>%</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>
																</tbody>
															</table>


														</div>
														<div class="col-md-6">

															<div class="stat-status-tab">
																<!-- Nav tabs -->
																<ul class="nav nav-tabs m-b" role="tablist">
																	<li role="presentation" class="active">
																		<button href="#W1" aria-controls="W1" role="tab" data-toggle="tab" class="btn btn-status btn-a btn-img on">
																			<img src="images/icon-check-on.png" width="100%;" alt="">
																		</button>
																	</li>

																	<li role="presentation">
																		<button href="#W2" aria-controls="W2" role="tab" data-toggle="tab" class="btn btn-status btn-b btn-img">
																			<img src="images/icon-dot.png" width="100%;" alt="">
																		</button>
																	</li>

																	<li role="presentation">
																		<button href="#W3" aria-controls="W3" role="tab" data-toggle="tab" class="btn btn-status btn-c btn-img">
																			<img src="images/icon-x.png" width="100%;" alt="">
																		</button>
																	</li>
																</ul>

																<!-- Tab panes -->
																<div class="tab-content">
																	<div role="tabpanel" class="tab-pane active" id="W1">
																		<div class="resume-tab-1">
																			<img src="images/icon-check-on.png" alt=""> 
																			<span><?=($rango80 > 0 ? $rango80 : 0)." aciertos de ".$totalPreguntasTest;?> preguntas del test</span>
																		</div>

																		<div class="border-table-wrap">
																			<table class="table text-center edu-table-2">
																				<thead>
																					<tr>
																						<th width="50%">Alumnos</th>

																						<th width="50%">Aciertos</th>
																					</tr>
																				</thead>

																				<tbody>
																					<?php
																					$totalImpresoTabla = 0;
																					foreach ($correctas as $c) {
																						if ($c["qty"] >= $rango80) {
																							$totalImpresoTabla++;
																							echo "<tr><td>".$c["user_name"]."</td><td>".round($c["qty"] * 100 / $totalPreguntasTest)."% (".$c["qty"]." aciertos)</td></tr>";
																						}
																					}

																					if ($totalImpresoTabla==0) {
																					?>
																					<tr>
																						<td colspan="2">
																							<div class="table-empty">No hay aciertos para esta tabla</div>
																						</td>
																					</tr>
																					<?php } ?>
																				</tbody>
																			</table>
																		</div>
																	</div>

																	<div role="tabpanel" class="tab-pane" id="W2">
																		<div class="resume-tab-1">
																			<img src="images/icon-dot.png" alt=""> <span><?=($rango50 > 0 ? $rango50 : 0)." aciertos de ".$totalPreguntasTest;?> preguntas del test</span>
																		</div>

																		<div class="border-table-wrap">
																			<table class="table text-center edu-table-2">
																				<thead>
																					<tr>
																						<th width="50%">Alumnos</th>

																						<th width="50%">Aciertos</th>
																					</tr>
																				</thead>

																				<tbody>
																					<?php
																					$totalImpresoTabla = 0;
																					foreach ($correctas as $c) {
																						if ($c["qty"] >= $rango50 && $c["qty"] < $rango80) {
																							$totalImpresoTabla++;
																							echo "<tr><td>".$c["user_name"]."</td><td>".round($c["qty"] * 100 / $totalPreguntasTest)."% (".$c["qty"]." aciertos)</td></tr>";
																						}
																					}

																					if ($totalImpresoTabla==0) {
																					?>
																					<tr>
																						<td colspan="2">
																							<div class="table-empty">No hay aciertos para esta tabla</div>
																						</td>
																					</tr>
																					<?php } ?>
																				</tbody>
																			</table>
																		</div>
																	</div>

																	<div role="tabpanel" class="tab-pane" id="W3">
																		<div class="resume-tab-1">
																			<img src="images/icon-x.png" alt=""> <span><?=($rango0 > 0 ? $rango0 : 0)." aciertos de ".$totalPreguntasTest;?> preguntas del test</span>
																		</div>

																		<div class="border-table-wrap">
																			<table class="table text-center edu-table-2">
																				<thead>
																					<tr>
																						<th width="50%">Alumnos</th>

																						<th width="50%">Aciertos</th>
																					</tr>
																				</thead>

																				<tbody>
																					<?php
																					$totalImpresoTabla = 0;
																					foreach ($correctas as $c) {
																						if ($c["qty"] < $rango50) {
																							$totalImpresoTabla++;
																							echo "<tr><td>".$c["user_name"]."</td><td>".round($c["qty"] * 100 / $totalPreguntasTest)."% (".$c["qty"]." aciertos)</td></tr>";
																						}
																					}

																					if ($totalImpresoTabla==0) {
																					?>
																					<tr>
																						<td colspan="2">
																							<div class="table-empty">No hay aciertos para esta tabla</div>
																						</td>
																					</tr>
																					<?php } ?>
																				</tbody>
																			</table>
																		</div>
																	</div>
																</div>
															</div>

														</div>
												  	</div>

												  </div>
												  <?php 
												  foreach ($ejes as $eje) {


													$rango80 = round( ($preguntasPorEje[$eje["id"]] ? $preguntasPorEje[$eje["id"]] * 0.8 : 0));
													$rango50 = round( ($preguntasPorEje[$eje["id"]] ? $preguntasPorEje[$eje["id"]] * 0.5 : 0));

													$correctas = DB::query("SELECT ts.user_id, (select u.name from user u where u.id = ts.user_id) user_name, COUNT(*) qty FROM test_end_detail ts, user_relations ur WHERE ts.isOk = 1 AND ts.test_id = %i AND ts.user_id = ur.user_id AND ur.course_id = %i AND ts.eje = %i GROUP BY ts.user_id ORDER BY qty DESC",$test["id"], $_POST["curso"],$eje["id"]);

													$alumnosRango80 = 0;
													$alumnosRango50 = 0;
													$alumnosRango0 = 0;
													$alumnosTotal = count($correctas);

													foreach ($correctas as $c) {
														if ($c["qty"] >= $rango80) { $alumnosRango80 += 1; }
														else if ($c["qty"] >= $rango50) { $alumnosRango50 += 1; }
														else { $alumnosRango0 += 1; }
													}
												  ?>
												  <div id="E<?=$eje["id"];?>" class="stats-general-eje tab-pane">

												  	<div class="row">
														<div class="col-md-6">
														
															<table class="table table-striped text-center table-head edu-table">
																<thead>
																	<tr>
																		<th class="text-center" style="vertical-align: middle;" width="50%">
																			Rangos
																		</th>

																		<th class="text-center" width="50%">
																			<table width="100%" class="table-bordered text-center" style="border-top: 0; border-bottom: 0;">
																				<tbody>
																					<tr>
																						<td colspan="2" style="border-top: 0;">Alumnos</td>
																					</tr>

																					<tr>
																						<td width="50%" style="border-bottom: 0;">Números</td>
																						<td width="50%" style="border-bottom: 0;">%</td>
																					</tr>
																				</tbody>
																			</table>
																		</th>
																	</tr>
																</thead>

																<tbody>
																	<tr>
																		<td>
																			<table width="100%" class="text-center">
																				<tbody>
																					<tr>
																						<td width="50%">
																							<span class="icon-table"><img src="images/icon-check-on.png" alt=""></span>	
																						</td>

																						<td width="50%" class="text-left blue-light"><i class="fa fa-arrow-up"></i> 80%</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>

																		<td colspan="2">
																			<table width="100%" class="text-center">
																				<tbody>
																					<tr>
																						<td width="50%"><?=$alumnosRango80;?></td>
																						<td width="50%"><?=round($alumnosRango80 * 100 / $alumnosTotal);?>%</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>

																	<tr>
																		<td>
																			<table width="100%" class="text-center">
																				<tbody>
																					<tr>
																						<td width="50%">
																							<span class="icon-table"><img src="images/icon-dot.png" alt=""></span>	
																						</td>

																						<td width="50%" class="text-left blue-light">
																							<i class="fa fa-arrow-down"></i> 80% <i class="fa fa-arrow-up"></i> 50%
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>

																		<td colspan="2">
																			<table width="100%" class="text-center">
																				<tbody>
																					<tr>
																						<td width="50%"><?=$alumnosRango50;?></td>
																						<td width="50%"><?=round($alumnosRango50 * 100 / $alumnosTotal);?>%</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>

																	<tr>
																		<td>
																			<table width="100%" class="text-center">
																				<tbody>
																					<tr>
																						<td width="50%">
																							<span class="icon-table"><img src="images/icon-x.png" alt=""></span>	
																						</td>

																						<td width="50%" class="text-left blue-light">
																							<i class="fa fa-arrow-down"></i> 50%
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>

																		<td colspan="2">
																			<table width="100%" class="text-center">
																				<tbody>
																					<tr>
																						<td width="50%"><?=$alumnosRango0;?></td>
																						<td width="50%"><?=round($alumnosRango0 * 100 / $alumnosTotal);?>%</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>
																</tbody>
															</table>

															</table>															
														</div>
														<div class="col-md-6">

															<div class="stat-status-tab">
																<!-- Nav tabs -->
																<ul class="nav nav-tabs m-b" role="tablist">
																	<li role="presentation" class="active">
																		<button href="#W_<?=$eje["id"];?>_1" aria-controls="W1" role="tab" data-toggle="tab" class="btn btn-status btn-a btn-img on">
																			<img src="images/icon-check-on.png" width="100%;" alt="">
																		</button>
																	</li>

																	<li role="presentation">
																		<button href="#W_<?=$eje["id"];?>_2" aria-controls="W2" role="tab" data-toggle="tab" class="btn btn-status btn-b btn-img">
																			<img src="images/icon-dot.png" width="100%;" alt="">
																		</button>
																	</li>

																	<li role="presentation">
																		<button href="#W_<?=$eje["id"];?>_3" aria-controls="W3" role="tab" data-toggle="tab" class="btn btn-status btn-c btn-img">
																			<img src="images/icon-x.png" width="100%;" alt="">
																		</button>
																	</li>
																</ul>

																<!-- Tab panes -->
																<div class="tab-content">
																	<div role="tabpanel" class="tab-pane active" id="W_<?=$eje["id"];?>_1">
																		<div class="resume-tab-1">
																			<img src="images/icon-check-on.png" alt=""> 
																			<span><?=($rango80 > 0 ? $rango80 : 0)." aciertos de ".$preguntasPorEje[$eje["id"]];?> preguntas del eje</span>
																		</div>

																		<div class="border-table-wrap">
																			<table class="table text-center edu-table-2">
																				<thead>
																					<tr>
																						<th width="50%">Alumnos</th>

																						<th width="50%">Aciertos</th>
																					</tr>
																				</thead>

																				<tbody>
																					<?php
																					$totalImpresoTabla = 0;
																					foreach ($correctas as $c) {
																						if ($c["qty"] >= $rango80) {
																							$totalImpresoTabla++;
																							echo "<tr><td>".$c["user_name"]."</td><td>".round($c["qty"] * 100 / $preguntasPorEje[$eje["id"]])."% (".$c["qty"]." aciertos)</td></tr>";
																						}
																					}

																					if ($totalImpresoTabla==0) {
																					?>
																					<tr>
																						<td colspan="2">
																							<div class="table-empty">No hay aciertos para esta tabla</div>
																						</td>
																					</tr>
																					<?php } ?>
																				</tbody>
																			</table>
																		</div>
																	</div>

																	<div role="tabpanel" class="tab-pane" id="W_<?=$eje["id"];?>_2">
																		<div class="resume-tab-1">
																			<img src="images/icon-dot.png" alt=""> <span><?=($rango50 > 0 ? $rango50 : 0)." aciertos de ".$preguntasPorEje[$eje["id"]];?> preguntas del eje</span>
																		</div>

																		<div class="border-table-wrap">
																			<table class="table text-center edu-table-2">
																				<thead>
																					<tr>
																						<th width="50%">Alumnos</th>

																						<th width="50%">Aciertos</th>
																					</tr>
																				</thead>

																				<tbody>
																					<?php
																					$totalImpresoTabla = 0;
																					foreach ($correctas as $c) {
																						if ($c["qty"] >= $rango50 && $c["qty"] < $rango80) {
																							$totalImpresoTabla++;
																							echo "<tr><td>".$c["user_name"]."</td><td>".round($c["qty"] * 100 / $preguntasPorEje[$eje["id"]])."% (".$c["qty"]." aciertos)</td></tr>";
																						}
																					}

																					if ($totalImpresoTabla==0) {
																					?>
																					<tr>
																						<td colspan="2">
																							<div class="table-empty">No hay aciertos para esta tabla</div>
																						</td>
																					</tr>
																					<?php } ?>
																				</tbody>
																			</table>
																		</div>
																	</div>

																	<div role="tabpanel" class="tab-pane" id="W_<?=$eje["id"];?>_3">
																		<div class="resume-tab-1">
																			<img src="images/icon-x.png" alt=""> <span><?=($rango0 > 0 ? $rango0 : 0)." aciertos de ".$preguntasPorEje[$eje["id"]];?> preguntas del eje</span>
																		</div>

																		<div class="border-table-wrap">
																			<table class="table text-center edu-table-2">
																				<thead>
																					<tr>
																						<th width="50%">Alumnos</th>

																						<th width="50%">Aciertos</th>
																					</tr>
																				</thead>

																				<tbody>
																					<?php
																					$totalImpresoTabla = 0;
																					foreach ($correctas as $c) {
																						if ($c["qty"] < $rango50) {
																							$totalImpresoTabla++;
																							echo "<tr><td>".$c["user_name"]."</td><td>".round($c["qty"] * 100 / $preguntasPorEje[$eje["id"]])."% (".$c["qty"]." aciertos)</td></tr>";
																						}
																					}

																					if ($totalImpresoTabla==0) {
																					?>
																					<tr>
																						<td colspan="2">
																							<div class="table-empty">No hay aciertos para esta tabla</div>
																						</td>
																					</tr>
																					<?php } ?>
																				</tbody>
																			</table>
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
						</div>
					</div>


					
					<script type="text/javascript">

					<?php
						/*
						$dataPoints ="[
								{ x: new Date(2018, 1,13), y: 20 },
								{ x: new Date(2018, 1,14), y: 34 },
								{ x: new Date(2018, 1,15), y: 45 },
								{ x: new Date(2018, 1,16), y: 13 },
								{ x: new Date(2018, 1,17), y: 11 },
								{ x: new Date(2018, 1,18), y: 42 },
								{ x: new Date(2018, 1,19), y: 25 }
							]";
						*/
						$dataPoints = "["; //array();
						foreach ($tests as $testx) {
							$dataPoints .= "{ label: \"".$testx["name"]."\", y: ".round($testx["puntosPromedio"])."".($testx["id"]==$_POST["test"] ? ", markerColor: \"white\", markerBorderColor: \"rgba(76,160,255,1)\"" : "")." },";
							$puntajes[] = round($testx["puntosPromedio"]);
						}
						if (!$puntajes) { $puntajes = array(0); }
						$dataPoints = substr($dataPoints,0,strlen($dataPoints)-1);
						$dataPoints .= "]";
					?>
					var chart2 = new CanvasJS.Chart("activeGraph_<?=$_POST["curso"];?>_<?=$_POST["materia"];?>", {
						animationEnabled: true,  
						axisY: {
							title: "Puntaje",
							suffix: "pts",
							prefix: "",
							gridThickness: 0
						},
						axisX: {
							minimum: 0,//<?=min($puntajes);?>,
						},
						data: [{
							type: "splineArea",
							toolTipContent: "{y} puntos",
							color: "rgba(219,236,255,.7)",
							markerSize: 20,
							markerBorderThickness: 2,
							markerColor: "rgba(76,160,255,1)",
							dataPoints: <?=($dataPoints);?>
						}]});
					chart2.render();

					$(".canvasjs-chart-credit").hide();
					</script>

				</div>
			</div>
		</div>
	</div>
</div>