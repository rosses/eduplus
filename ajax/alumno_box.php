<?php
require("../../api.eduplus.enlanube.cl/sql.php");
sleep(1);

$alumno = new Alumno($_POST["id"]);
?>
<div class="ratings-box">
	<div class="ratings-module">
		<div class="row title">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			Últimos puntajes
			</div>
		</div>

		<div class="row data">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
				<?php
				$alumno->getMaterias();
				foreach ($alumno->materias as $materia_id=>$materia) {
				?>
				<div class="alumno-box" style="border-top: 10px solid <?=$materia["color"];?>">
					<h2><?=$materia["name"];?></h2>
					<h1><?=$materia["ultima_psu"];?>pts</h1>
					<h3>Meta: <?=$materia["points"];?>pts</h3>
				</div>
				<?php
				}
				?>
			</div>
		</div>
	
	</div>

	<div class="ratings-module">

		<div class="row title">
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				Puntaje ponderado actual
			</div>

			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				Meta Global
			</div>

			<div class="col-xs-12 col-sm-3 col-md-6 col-lg-6">
				Visión
			</div>
		</div>

		<div class="row data">
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				<h1 class="alumno-box-global"><?=$alumno->ultima_ponderacion;?>pts</h1>
			</div>
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				<h1 class="alumno-box-aux"><?=$alumno->puntaje_ponderacion;?>pts</h1>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-left">
				<?=$alumno->university_name;?> / <?=$alumno->work;?>
			</div>

		</div>
	</div>
</div>
<?php

?>