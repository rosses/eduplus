<?php
session_start();
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
$pts = DB::queryFirstRow("SELECT * FROM test_end_head WHERE test_id = %i AND user_id = %i  ORDER BY id DESC LIMIT 1", $_POST["id"], $_SESSION["id"]);

?>
<div class="statistics-box-a">
	<div class="goal-status-box">
		<div class="vcenter">
			<div class="tabcell">
				<div class="brand-row text-center">
					<img src="images/brand-icon.png" alt="">
				</div>

					<?php if ($po > 0 && $pts) { 
						$full = 850;
						$meta = $po;
						$ptje = $pts["points"];

						$miMeta = round($meta * 100 / $full);
						$miPuntaje = round($ptje * 100 / $full);
						
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
							<div class="goal-mimeta_por" style="left: calc(<?=$miPuntaje;?>% - 32px);"><?=$miPuntaje;?>%</div>

							<div class="goal-mimeta_pts" style="left: calc(<?=$miMeta;?>% - 32px);"><?=$po;?> pts.</div>
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