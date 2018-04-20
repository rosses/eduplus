<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");
$alumno = new Alumno($_SESSION["id"]);
$alumno->getMaterias();
?>
<div class="statistics-row">
	<div class="row">
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
			<div class="subjects-row2">
				<ul>
					<?php
					foreach ($alumno->materias as $id_materia=>$materia) {
					?>		
					<li>
						<div class="subjects-infobox subj-x" style="border-color: <?=$materia["color"];?>;" data-id="<?=$id_materia;?>">
							<div class="vcenter">
								<div class="tabcell">
									<div class="subj-title"><?=$materia["name"];?></div>
									<div class="subj-subtitle">meta</div>
									<div class="subj-pts"><?php echo $materia["ultima_psu"]."pts"; ?></div>
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
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

			<div class="subjects-dashboard">
				<div class="statistics-row">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="statistics-box-b subj-math">
								<div class="row">
									<div class="col-xs-12">
										<div class="tab-title text-center">
											<b>Visión general</b><br />
											<?=$alumno->name;?>, así has progresado
										</div>

										<!-- Tab panes -->
										<div class="tab-content">
											<div role="tabpanel" class="tab-pane active" id="tab_1">
												<div class="row">
													<div class="col-md-12 text-left">

														<?php 
														$alumno->getTests();
														?>
														<div id="activeGraph_general" style="height: 350px; width: 100%;"></div>	
														<script type="text/javascript">
														<?php
															$puntajesGrafico = array();
															$dataPoints = "["; 
															foreach ($alumno->tests as $test) {
																$itemsStr = "";
																foreach ($test["items"] as $itm) {
																	$itemsStr .= $itm["name"].": ".$itm["puntaje"]." pts.<br />";
																}
																$dataPoints .= "{ label: \"".$test["fecha"]."\", toolTipContent: \"{y} puntos <br />Realizado el ".$test["fecha"]."<br /><b>basado en:</b><br />".$itemsStr."\", y: ".$test["ponderado"]." },";
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
														chart.render();
														$(".canvasjs-chart-credit").hide();
														</script>
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

		</div>
	</div>
</div>
