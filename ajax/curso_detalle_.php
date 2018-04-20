<?php
require("../../api.eduplus.enlanube.cl/sql.php");
sleep(1);
$orderby = "psu DESC";
if ($_POST["orderby"]) {
	$orderby = $_POST["orderby"];
}
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
					ORDER BY ".$orderby, $_POST["course"], $_SESSION["id"], $_POST["materia"]);

$metaCurso = $rows[0]["goal"];
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
								<option value="psu DESC">Puntaje PSU: Mayor a menor</option>
								<option value="psu ASC">Puntaje PSU: Menor a mayor</option>
								<option value="name ASC">Nombre: A - Z</option>
								<option value="name DESC">Nombre: Z - A</option>
								<option value="apep ASC">Apellido: A - Z</option>
								<option value="apep DESC">Apellido: Z - A</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right">
				<!--<img src="images/progress-circle_01.png" width="100%;" alt="">-->
				<?php
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
				/*
				echo "Meta curso:".$metaCurso."pts<br>";
				echo "Puntaje promedio: ".$ptjePromedio."pts<br>";
				echo "% actual:".$prcntActual."%<br>";
				*/
				?>
                <div class="c100 p<?=$prcntActual;?>">
                    <span><?=$prcntActual;?>%</span>
                    <div class="meta"><?=$ptjePromedio;?> pts</div>
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
					if (count($rows)==0) {
						echo "<div class='alert alert-danger'>El curso y materia seleccionado no tiene alumnos asociados</div>";
					}
				?>
				<div class="students-listcont">
					<ul>
						<?php
						foreach ($rows as $row) {
						?>

						<li class="student-card-container" data-materia="<?=$_POST["materia"];?>" data-id="<?=$row["id"];?>">
							<div class="student-card-thumb">
								<div class="thumb-cont img-circle">
									<div class="student-thumb img-circle">
										<img src="<?=($row["image"]=="" ? "images/default.jpg" : $row["image"]);?>" alt="">
									</div>

									<button class="btn btn-default openAlumno">
										<i class="fa fa-plus" aria-hidden="true"></i>	
									</button>
								</div>
								
								<?php
								$total = 850;
								$miMetaLeft = round(($row["user_goal"] * 100 / $total),0);
								$llevo = round(($row["psu"] * 100 / $total),0);
								?>					
								<div class="student-list-info">
									<div class="name">
										<?=$row["name"];?>
									</div>

									<div class="pts">
										<?=$row["psu"];?>pts
									</div>

									<div class="percent">
										<?php echo ($row["user_goal"] > 0 ? round($row["psu"] * 100 / $row["user_goal"]) : 0); ?>%
									</div>
								</div>
								<div class="goal-infobox text-center">
									<div class="goal-infobox-bar-out"></div>
									<div class="goal-infobox-circle" style="left: <?=$llevo;?>%;"></div>
									<div class="goal-infobox-leyend">Lleva: <?=$row["psu"];?>pts (<?=($row["user_goal"] > 0 ? round(($row["psu"] * 100 / $row["user_goal"])) : 0);?>%)</div>

									<div class="goal-infobox-circle-off" style="left: <?=$miMetaLeft;?>%;"></div>
									<div class="goal-infobox-leyend-off">Meta: <?=$row["user_goal"];?>pts</div>
									
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