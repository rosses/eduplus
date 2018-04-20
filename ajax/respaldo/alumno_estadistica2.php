<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");
$q = "SELECT * FROM test t WHERE t.materia = %i AND EXISTS(SELECT g.* FROM test_end_detail g WHERE g.test_id = t.id AND g.user_id = %i) ORDER BY t.id DESC";
$f = DB::query($q,$_POST["id"],$_SESSION["id"]);

$me = DB::queryFirstRow("SELECT * FROM user WHERE id = %s",$_SESSION["id"]);
$meGoals = DB::query("SELECT * FROM user_goal WHERE id = %i",$_SESSION["id"]);


if (!$_POST["test"]) {
	$_POST["test"] = $f[0]["id"];
}
$test = DB::queryFirstRow("SELECT * FROM test WHERE id = %i", $_POST["test"]);
$pts = DB::queryFirstRow("SELECT * FROM test_end_head WHERE test_id = %i AND user_id = %i  ORDER BY id DESC LIMIT 1", $_POST["test"], $_SESSION["id"]);

/* ponderacion  */
$po = 0;
if (count($meGoals)>0) {
	foreach ($meGoals as $mg) {
		if ($mg["materia"] == $test["materia"]) { $meta = $mg["points"]; }
		if ($mg["pond"] > 0) {
			$po += (($mg["points"] * $mg["pond"]) / 100);
		}
	}
}
$po = round($po);



?>
<div class="statistics-row">
	<div class="row">
		<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
			<div class="statistics-box-a">
				<div class="test-result-list text-center">
					<h4>
						Resultados por test
					</h4>

					<div id="carousel-test-result-list" class="carousel slide" data-ride="carousel" data-interval="10000">
						<!-- Indicators -->
						<ol class="carousel-indicators">
							<li data-target="#carousel-test-result-list" data-slide-to="0" class="active"></li>
							<li data-target="#carousel-test-result-list" data-slide-to="1"></li>
						</ol>

						<div class="carousel-inner" role="listbox">
							<div class="item active">
								<?php
								foreach ($f as $x) {
								?>
								<button class="btn btn-default btn-b cargarResultados" data-materia="<?=$_POST["id"];?>" data-id="<?=$x["id"];?>" style="width:100%;">
								<?=$x["name"];?>
								</button>
								<?php
								} 
								?>
							</div>

						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7" id="esta1">

		<div class="statistics-box-a">
			<div class="goal-status-box">
				<div class="vcenter">
					<div class="tabcell">
						<div class="brand-row text-center">
							<img src="images/brand-icon.png" alt="">
						</div>

							<?php if ($po > 0 && $pts) { 
								$full = 850;
								//$meta = $me;
								$ptje = $pts["points"];

								$miMeta = round($meta * 100 / $full);
								$miPuntaje = round($ptje * 100 / $full);
								$miPuntaje2 = round($ptje * 100 / $meta);
								
							?>
							<div class="goal-info">
								<div class="text-a">Felicidades <?=$me["name"];?> estas muy cerca de la meta!</div>
								<div class="text-b blue-light">Según puntaje obtenido en <?=$test["name"];?></div>
							</div>
							<div class="goal-slide text-center">
								<div class="goal-bar">
									<div class="goal-bar-fill"></div>
									<div class="goal-bar-out" style="width: <?=(100 - $miMeta);?>%;"></div>

									<div class="goal-mimeta_pts" style="left: calc(<?=$miPuntaje;?>% - 32px);"><?=$ptje;?> pts.</div>
									<div class="goal-mipuntaje" style="left: calc(<?=$miPuntaje;?>% - 16px);"></div>
									<div class="goal-mimeta_por" style="left: calc(<?=$miPuntaje;?>% - 32px);"><?=$miPuntaje2;?>%</div>

									<div class="goal-mimeta_pts" style="left: calc(<?=$miMeta;?>% - 32px);"><?=$meta;?> pts.</div>
									<div class="goal-mimeta" style="left: calc(<?=$miMeta;?>% - 16px);"></div>
									<div class="goal-mimeta_por" style="left: calc(<?=$miMeta;?>% - 32px);">META</div>

								</div>

								<!--<img src="images/goal-graph.png" alt="">-->
							</div>
							<?php } else if ($pts) { ?>
							<div class="goal-info">
								<div class="text-a">
									<?=$me["name"];?> obtuviste <?=$ptje;?> puntos pero no conocemos tu meta <br /><br />
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
				</div>
			</div>
		</div>
		</div>
	</div>
</div>
<div class="statistics-row" id="esta2">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="statistics-box-b">
				<div class="row">
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<!--img src="images/goal-graphic-1.png" alt="" />-->
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
					
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<h5>Test <?=$test["name"];?></h5>
						<?php
							$pregs = DB::queryFirstField("SELECT COUNT(*) FROM preg WHERE test_id = %i", $test["id"]);
							$testData = DB::query("SELECT * FROM test_end_detail ts WHERE ts.user_id = %i AND ts.test_id = %i",$_SESSION["id"],$test["id"]);
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
						<div id="container" style="width: 100%; height: 170px; margin: 0 auto"></div>
						<script type="text/javascript">

						var getColor = {
						    'OK': '#50E3C2',
						    'ERR': '#333333',
						    'WH': '#028BFF'
						};

						Highcharts.chart('container', {
						    chart: {
						        type: 'pie'
						    },
						    title: {
						        text: ''
						    },
						    subtitle: {
						        text: ''
						    },
						    plotOptions: {
						        series: {
						            dataLabels: {
						                enabled: false,
						                format: '{point.name}: {point.y:.1f}%'
						            }
						        }
						    },
						    tooltip: {
						        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
						        pointFormat: '<span>{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
						    },
						    series: [{
						        name: 'Respuestas',
						        colorByPoint: true,
						        data: [{
						            name: 'Malas',
						            y: <?=$resER;?>,
						            color: getColor["ERR"]
						        },{
						            name: 'Correctas',
						            y: <?=$resOK;?>,
						            color: getColor["OK"]
						        }, {
						            name: 'En blanco',
						            y: <?=$resWH;?>,
						            color: getColor["WH"]
						        }]
						    }]
						});
						</script>
						<img src="images/chart2_legend.png" alt="">
						<?php } ?>
					</div>

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<h5>Evolución curso en <?=$test["name"];?></h5>
						<?php 
							if (!$miPuntaje) {
								echo "<br><br>No has participado en este test";
							}
							else {
								echo '<div class="stat3">
									  <div class="stat3-g">
										<div class="stat3-g1" style="top: calc('.(100 - $miPuntaje).'% - 5px);">'.$ptje.'pts</div>
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
						<!--<img src="images/goal-graphic-3.png" alt="">-->
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>