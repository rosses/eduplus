<?php
require("../../api.eduplus.enlanube.cl/sql.php");
sleep(1);

$user = DB::queryFirstRow("SELECT * FROM user WHERE id = %i",$_POST["id"]);
$packet = DB::query("SELECT tp.points, t.name FROM test_end_head tp, test t WHERE tp.isLast = 1 AND tp.test_id = t.id AND tp.materia = %i AND tp.user_id = %i ORDER BY tp.cuando ASC",$_POST["materia"],$_POST["id"]);
$dataPoints = "[";
foreach($packet as $p) {
	$dataPoints .= '{label: "'.$p["name"].'", y: '.$p["points"].'},';
}
$dataPoints = substr($dataPoints, 0, strlen($dataPoints)-1);
$dataPoints .= "]";
?>
<br />
<div id="activeGraph_<?=$_POST["id"];?>" style="height: 200px; width: 100%;"></div>
<script>

var chart = new CanvasJS.Chart("activeGraph_<?=$_POST["id"];?>", {
	animationEnabled: true,
	theme: "dark2",
	backgroundColor: "#4DA1FF",
	title:{
		text: "Evolución"
	},
	axisY:{
		includeZero: false
	},
	data: [{        
		type: "line",  
		lineColor: "#FFF",     
		dataPoints: <?=($dataPoints);?>
	}]
});
chart.render();
$(".canvasjs-chart-credit").hide();

</script>
