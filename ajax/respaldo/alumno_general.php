<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");
?>
<div class="statistics-row">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="subjects-row">
				<ul>
					<?php
					$alumno = new Alumno($_SESSION["id"]);
					$alumno->getMaterias();

					//$arr = DB::query("SELECT m.* FROM materia m WHERE m.active = 1 AND m.superior = 0 AND EXISTS(SELECT g.* FROM user_goal g WHERE g.materia = m.id AND g.id = %i AND g.points > 0) ORDER BY m.orden ASC", $_SESSION["id"]);
					foreach ($alumno->materias as $id_materia=>$materia) {
					?>		
					<li>
						<div class="subjects-infobox subj-x" style="border-color: <?=$materia["color"];?>;" data-id="<?=$id_materia;?>">
							<div class="vcenter">
								<div class="tabcell">
									<div class="subj-title">
										<?=$materia["name"];?>
									</div>

									<div class="subj-subtitle">
										meta
									</div>

									<div class="subj-pts">
										<?php
										echo $materia["ultima_psu"]."pts";
										/*
										if ($_POST["type"]=="ENSAYO") {
											$now = DB::queryFirstField("SELECT points 
																		FROM test_packet tp, test t
																		WHERE tp.materia = %i and tp.user_id = %i AND tp.test_id = t.id AND t.tipo = %s
																		ORDER BY tp.cuando DESC LIMIT 1", $a["id"], $_SESSION["id"], $_POST["type"]);
										}
										if (!$now) { $now = 0; }
										echo intval($now)."pts";
										*/
										?>
									</div>
								</div>
							</div>
						</div>
					</li>
					<?php
					}
					?>							
				</ul>
			</div>	
		</div>
	</div>
</div>
<?php
/*
$me = DB::queryFirstRow("SELECT * FROM user WHERE id = %s",$_SESSION["id"]);
$meGoals = DB::query("SELECT * FROM user_goal WHERE id = %i",$_SESSION["id"]);
$pts = DB::query("SELECT b.* FROM test_packet b, test t 
				  WHERE b.user_id = %i AND b.isLast = 1 
				  AND b.test_id = (SELECT a.test_id FROM test_packet a WHERE a.user_id=b.user_id AND a.materia = b.materia AND a.isLast = 1 ORDER BY a.cuando DESC LIMIT 1) 
				  AND b.test_id = t.id 
				  AND t.tipo = %s
				  ORDER BY b.id DESC", $_SESSION["id"], $_POST["type"]);


$ptje = 0;
$po = 0;
if (count($meGoals)>0) {
	foreach ($meGoals as $mg) {
		if ($mg["pond"] > 0) {
			$po += (($mg["points"] * $mg["pond"]) / 100);
			$meta += $mg["points"] * ($mg["pond"] / 100);
			foreach ($pts as $p) {
				if ($p["materia"] == $mg["materia"]) {
					$ptje += $p["points"] * ($mg["pond"] / 100);
					//echo "$p[points] * ($mg[pond] / 100)  = ".($p["points"] * ($mg["pond"] / 100))."<br>";
				}
			}
		}
	}
}
$po = round($po);
$ptje = round($ptje);
*/
?>
<div class="subjects-dashboard">
	<div class="statistics-row">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="statistics-box-b subj-math">
					<div class="row">
						<div class="col-xs-12">
							<div class="tab-title text-center">
								<?=$alumno->name;?>, así has progresado
							</div>

							<!-- Tab panes -->
							<div class="tab-content">

								<div role="tabpanel" class="tab-pane active" id="tab_1">
									<div class="row">
										<div class="col-md-12 text-left">

											<?php 
											$alumno->getTests();
											//echo "<pre>".print_r($alumno->tests,1)."</pre>";
											?>
											<div id="activeGraph_general" style="height: 350px; width: 100%;"></div>	
											<script type="text/javascript">
											<?php
												$puntajesGrafico = array();
												$dataPoints = "["; 
												foreach ($alumno->tests as $test) {
													$dataPoints .= "{ label: \"".$test["fecha"]."\", toolTipContent: \"{y} puntos <br />Realizado el ".$test["fecha"]."\", y: ".$test["ponderado"]." },";
													$puntajesGrafico[] = $test["ponderado"];
												}
												if (!$puntajesGrafico) { $puntajesGrafico = array(0); }
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
												},/*
												axisX: {
													minimum: <?=min($puntajesGrafico);?>,
												},*/
												data: [{
													type: "splineArea",
													toolTipContent: "{y} puntos",
													color: "rgba(219,236,255,.7)",
													markerSize: 20,
													markerBorderThickness: 2,
													markerColor: "rgba(76,160,255,1)",
													dataPoints: <?=($dataPoints);?>
												}]});
											chart.render();
											$(".canvasjs-chart-credit").hide();
											</script>
											<?php
											
											/*
											if ($po > 0 && $pts) { 
												$full = 850;
												$miMeta = round($meta * 100 / $full);
												$miPuntaje = round($ptje * 100 / $full);
												$miPuntaje2 = round($ptje * 100 / $meta);
												
											?>
											<div class="goal-slide text-center">
												<br /><br />
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
											</div>
											<?php } else if ($pts) { ?>
											<div class="goal-info">
												<div class="text-a">
													<?=$me["name"];?> obtuviste <?=$ptje;?> puntos pero no conocemos tu meta <br /><br />
													<a href="index.php" class="btn btn-primary">Configurala aquí</a></div>
											</div>
											<br /><br /><br /><br />
											<div class="text-center"><img class="" src="images/logo-helper.png" alt="" /></div>
											<br />
											<?php } else {
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
											*/
											?>

											<div class="clearfix"></div>
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