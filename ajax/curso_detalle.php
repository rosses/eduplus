<?php
require("../../api.eduplus.enlanube.cl/sql.php");
sleep(1);


if (!$_POST["orderby"]) {
	$_POST["orderby"] = "psu DESC";
}

$materia = $_POST["materia"];
$curso = $_POST["course"];
$info = new CursoMateria($curso,$materia);
?>

<div id="pageContainerInner">
	<div id="menuHelper">
		<div class="container-fluid">
			<div class="row">

				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<a href="#" class="logo-helper">
						<img src="images/logo-helper.png" alt="">
					</a>
				</div>

				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<div class="search-cont">
						<div class="vcenter">
							<div class="tabcell">
								<select class="form-control inp-school-b" id="selectDetalleCurso">
									<option value="" disabled>Cursos</option>
									<?php
									$trs = DB::query("SELECT tr.*, c.id course_id, c.name course_name, m.id materia_id, m.name materia_name
													  FROM teacher_relations tr, course c, materia m 
													  WHERE tr.teacher_id = %i AND tr.course_id = c.id AND tr.materia_id = m.id ORDER BY c.id ASC",$_SESSION["id"]);
									foreach ($trs as $tr) {
										echo "<option value='".$tr["course_id"]."-".$tr["materia_id"]."' ".($tr["materia_id"] == $_POST["materia"] && $tr["course_id"] == $_POST["course"] ? "selected" : "").">".$tr["course_name"]." / ".$tr["materia_name"]."</option>";
									}
									?>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<div class="search-cont">
						<div class="vcenter">
							<div class="tabcell">
								<select class="form-control inp-school-b" id="selectDetalleCursoSorter">
									<option value="psu DESC" <?=($_POST["orderby"]=="psu DESC" ? "selected":"");?>>Puntaje PSU: Mayor a menor</option>
									<option value="psu ASC" <?=($_POST["orderby"]=="psu ASC" ? "selected":"");?>>Puntaje PSU: Menor a mayor</option>
									<option value="porc DESC" <?=($_POST["orderby"]=="porc DESC" ? "selected":"");?>>Meta personal: Mayor a menor</option>
									<option value="porc ASC" <?=($_POST["orderby"]=="porc ASC" ? "selected":"");?>>Meta personal: Menor a mayor</option>
									<option value="apep ASC" <?=($_POST["orderby"]=="apep ASC" ? "selected":"");?>>Apellido: A - Z</option>
									<!--
									<option value="name ASC" <?=($_POST["orderby"]=="name ASC" ? "selected":"");?>>Nombre: A - Z</option>
									<option value="name DESC" <?=($_POST["orderby"]=="name DESC" ? "selected":"");?>>Nombre: Z - A</option>
									<option value="apep DESC" <?=($_POST["orderby"]=="apep DESC" ? "selected":"");?>>Apellido: Z - A</option>
									-->
								</select>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right">
					<!--<img src="images/progress-circle_01.png" width="100%;" alt="">-->
					<?php
					/*
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

					$ptjePromedio = round($ptjePromedio,0);
					*/
					/*
					echo "Meta curso:".$metaCurso."pts<br>";
					echo "Puntaje promedio: ".$ptjePromedio."pts<br>";
					echo "% actual:".$prcntActual."%<br>";
					*/
					?>
	                <div class="c100 p<?=$info->promedioPorcentaje;?>">
	                    <span><?=$info->promedioPorcentaje;?>%</span>
	                    <div class="meta"><?=$info->promedioPuntos;?> pts</div>
	                    <div class="slice">
	                        <div class="bar"></div>
	                        <div class="fill"></div>
	                    </div>
	                </div>
				</div>
			</div>
		</div>
	</div>

	<div id="loadingpageBody" class="text-center" style="display:none;">
		<br />
		<br />
		<i class="fa fa-4x fa-spin fa-circle-o-notch"></i>
		<br />
		<br />
		<br />
	</div>
	<div id="pageBody">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?php
						if (count($info->alumnos)==0) {
							echo "<div class='alert alert-danger'>El curso y materia seleccionado no tiene alumnos asociados</div>";
						}

					?>
					<div class="students-listcont">
						<ul>
							<?php
							usort($info->alumnos, array("CursoMateria", "alumnosSort"));
							foreach ($info->alumnos as $alumno) {
							?>

							<li class="student-card-container" data-materia="<?=$_POST["materia"];?>" data-id="<?=$alumno->id;?>">
								<div class="student-card-thumb">
									<div class="thumb-cont img-circle">
										<div class="student-thumb img-circle">
											<img src="<?=$alumno->image;?>" alt="">
										</div>

										<button class="btn btn-default openAlumno">
											<i class="fa fa-plus" aria-hidden="true"></i>	
										</button>
									</div>
									
									<?php
									$miMetaLeft = round(($alumno->materias[$materia]["points"] * 100 / 850),0);
									$llevo = round(($alumno->materias[$materia]["ultima_psu"] * 100 / 850),0);
									?>					
									<div class="student-list-info">
										<div class="name">
											<?=$alumno->name;?> <?=$alumno->apep;?>
										</div>

										<div class="pts">
											<?=$alumno->materias[$materia]["ultima_psu"];?>pts
										</div>

										<div class="percent">
											<?=$alumno->materias[$materia]["porc"];?>%
										</div>
									</div>
									<div class="goal-infobox text-center">
										<div class="goal-infobox-bar-out"></div>
										<div class="goal-infobox-circle" style="left: <?=$llevo;?>%;"></div>
										<div class="goal-infobox-leyend">Lleva: <?=$alumno->materias[$materia]["ultima_psu"];?>pts (<?=$alumno->materias[$materia]["porc"];?>%)</div>

										<div class="goal-infobox-circle-off" style="left: <?=$miMetaLeft;?>%;"></div>
										<div class="goal-infobox-leyend-off">Meta: <?=$alumno->materias[$materia]["points"];?>pts</div>
										
									</div>
								</div>
								<div class="student-card-graph">

								</div>
								<div class="student-card student-details">
										
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
	</div>
</div>