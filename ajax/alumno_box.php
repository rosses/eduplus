<?php
require("../../api.eduplus.enlanube.cl/sql.php");
sleep(1);

$user = DB::queryFirstRow("SELECT * FROM user WHERE id = %i",$_POST["id"]);
?>
<div class="ratings-box">
	<div class="ratings-module">
		<div class="row title">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				Últimos puntajes
			</div>
		</div>
		

		<!--<div class="row">	-->
			<?php
			$po = 0;
			$po_actual = 0;
			$masterpo = array();
			$mats = DB::query("SELECT * FROM materia WHERE active = 1 AND (EXISTS(SELECT * FROM user_goal ug WHERE ug.materia = materia.id AND ug.pond > 0 AND ug.id = %i)) ORDER BY orden ASC",$_POST["id"]);
			foreach ($mats as $mat) {
				$points = DB::queryFirstField("SELECT points FROM user_goal WHERE id = %i AND materia = %i", $_POST["id"], $mat["id"]);
				$pond = DB::queryFirstField("SELECT pond FROM user_goal WHERE id = %i AND materia = %i",$_POST["id"], $mat["id"]);

				$masterpo[$mat["id"]] = $pond;

				if ($pond > 0) {
					$po += (($points * ($pond / 100)));
				}
			?>
			<!--<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
				<?=$mat["name"];?>
			</div>-->
			<?php
			}
			$po = round($po);
			?>
		<!--</div>

		<div class="row data">-->
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<?php
				foreach ($mats as $mat) {
				?>
				<!--<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">-->
					<?php
						$getPoints = DB::queryFirstField("SELECT IFNULL(points,0) points FROM test_end_head WHERE user_id = %i AND tipo IN ('PSU','ENSAYO') AND materia = %i ORDER BY cuando DESC",$user["id"], $mat["id"]);
						if ($getPoints) {
							if ($masterpo[$mat["id"]] > 0) {
								$po_actual += ($getPoints * ($masterpo[$mat["id"]] / 100));
							}
							echo "<h2>".$getPoints."</h2>";
						}
						else {
							//echo "0";
						}
					?>pts
				<!--</div>-->
				<?php
				}
				?>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

				</div>
			</div>
		<!--</div>-->
	</div>


	<hr>

	<div class="ratings-module">

		<div class="row">
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				Puntaje ponderado actual
			</div>

			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				Meta Global
			</div>

			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				Carrera
			</div>

			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				Universidad
			</div>
		</div>

		<div class="row data">
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				<strong style='color:black;'><?=round($po_actual);?>pts</strong>
			</div>
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				<?=$po;?>pts
			</div>

			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				<?=$user["work"];?>
			</div>

			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				<?=$user["university_name"];?>
			</div>
		</div>
	</div>
</div>
<?php

?>