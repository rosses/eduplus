<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");

$test = DB::queryFirstRow("SELECT * FROM test WHERE id = %i",$_POST["test"]);
?>
<div id="reportTabPanel">

	<div class="table-responsive text-center">
		<table class="table table-striped table-hover table-condensed header-fixed">
			<thead>
				<tr>
					<th class="text-center">Pregunta</th>
					<th class="text-center">Eje temático</th>
					<th class="text-center">Tu respuesta</th>
					<th class="text-center">Respuesta correcta</th>
					<th class="text-center">Resultado</th>
				</tr>
			</thead>
			<tbody>
			<?php

			$for = DB::query("SELECT
							    p.orden,
							    e.name eje_name,
							    e.id eje_id,
							    (SELECT IFNULL(ts.isOk, -1) FROM test_end_detail ts WHERE ts.test_id = p.test_id AND ts.preg = p.id AND ts.user_id = %i) isOk,
							    (SELECT IFNULL(ts.correct, -1) FROM test_end_detail ts WHERE ts.test_id = p.test_id AND ts.preg = p.id AND ts.user_id = %i) correct,
							    (SELECT IFNULL(ts.reply, -1) FROM test_end_detail ts WHERE ts.test_id = p.test_id AND ts.preg = p.id AND ts.user_id = %i) reply
							FROM
							    preg p,
							    eje e    
							WHERE
							    p.test_id = %i AND p.eje = e.id
							ORDER BY
							    p.orden ASC",$_POST["user"],$_POST["user"],$_POST["user"],$_POST["test"]);
			$i = 0;
			
			$totalPreguntasTest = count($for);
			$preguntasPorEje = array();
			foreach ($for as $preg) {
				$i++;
			?>
			<tr>
				<td><?=$i;?></td>
				<td><?=$preg["eje_name"];?></td>
				<td>
					<?php
						if ($preg["reply"]==-1) { echo ""; }
						if ($preg["reply"]==0) { echo "A"; }
						if ($preg["reply"]==1) { echo "B"; }
						if ($preg["reply"]==2) { echo "C"; }
						if ($preg["reply"]==3) { echo "D"; }
						if ($preg["reply"]==4) { echo "E"; }
						if ($preg["reply"]==5) { echo "F"; }
						if ($preg["reply"]==6) { echo "G"; }
						if ($preg["reply"]==7) { echo "H"; }
						if ($preg["reply"]==8) { echo "I"; }
						if ($preg["reply"]==9) { echo "J"; }
					?>
				</td>
				<td>
					<?php
						if ($preg["correct"]==-1) { echo ""; }
						if ($preg["correct"]==0) { echo "A"; }
						if ($preg["correct"]==1) { echo "B"; }
						if ($preg["correct"]==2) { echo "C"; }
						if ($preg["correct"]==3) { echo "D"; }
						if ($preg["correct"]==4) { echo "E"; }
						if ($preg["correct"]==5) { echo "F"; }
						if ($preg["correct"]==6) { echo "G"; }
						if ($preg["correct"]==7) { echo "H"; }
						if ($preg["correct"]==8) { echo "I"; }
						if ($preg["correct"]==9) { echo "J"; }
					?>
				</td>
				<td>
				<?php
				if ($preg["isOk"]==-1) {

				}
				else if ($preg["isOk"]==0) {
					echo "<i class='fa fa-times fa-fw' style='color:red;'></i>";
				}
				else if ($preg["isOk"]==1) {
					echo "<i class='fa fa-check fa-fw' style='color:green;'></i>";
				}
				else {
					echo "***";
				}
				?>
				</td>
			</tr>
			<?php
			}
			?>
			</tbody>
		</table>
	</div>


</div>
