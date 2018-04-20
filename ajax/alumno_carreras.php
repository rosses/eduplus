<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");

$q = DB::query("SELECT carrera FROM umineduc WHERE universidad = %s GROUP BY carrera ORDER BY carrera ASC", $_POST["universidad"]);
foreach ($q as $x) {
	echo "<option ".($_POST["sel"] == $x["carrera"] ? "selected" : "")." value='".$x["carrera"]."'>".$x["carrera"]."</option>";
}

?>