<?php
require("../../api.eduplus.enlanube.cl/sql.php");
if ($_SESSION["tbl"] == "user") {
	$me = DB::queryFirstRow("SELECT * FROM user WHERE id = %s",$_SESSION["id"]);	
	$meGoals = DB::query("SELECT * FROM user_goal WHERE id = %i",$_SESSION["id"]);
	$po = 0;
	if (count($meGoals)>0) {
		foreach ($meGoals as $mg) {
			if ($mg["pond"] > 0) {
				$po += (($mg["points"] * $mg["pond"]) / 100);
			}
		}
	}
	$po = round($po);
}
$test = DB::queryFirstRow("SELECT * FROM test WHERE id = %i", $_POST["id"]);
$pts = DB::queryFirstRow("SELECT * FROM test_end_head WHERE test_id = %i  ORDER BY id DESC LIMIT 1", $_POST["id"]);

$full = 850;
$ptje = $pts["points"];
$miPuntaje = round($ptje * 100 / $full);
?>

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
					<h5>Evolución curso</h5>
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

							echo '<div class="stat3-g">
									<div class="stat3-g1" style="top: calc('.(100 - $miPuntaje).'% - 5px);">'.$ptje.'pts</div>
									<div class="stat3-g2 stat3-g2-2" style="height: '.$miPuntaje.'%;"></div>
									<div class="stat3-g3">Puntaje curso</div>
								  </div>';
							echo '</div>';
						}
					?>
					<!--<img src="images/goal-graphic-3.png" alt="">-->
				</div>
			</div>
		</div>
	</div>
</div>	