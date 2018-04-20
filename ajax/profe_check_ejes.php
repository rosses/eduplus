<?php
require("../../api.eduplus.enlanube.cl/sql.php");
$trs = DB::query("SELECT * FROM eje WHERE eje.parent = %i and eje.active = 1 AND eje.library = 1 ORDER BY name ASC",$_POST["materia"]);	
foreach ($trs as $tr) {
	echo '<div class="checkbox"><label><input type="checkbox" class="select_ejes" value="'.$tr["id"].'" /> '.$tr["name"].'</label></div>';
}
echo "<small>Si seleccionar más de un eje temático el contenido aparecerá en &quot;Contenidos generales&quot;</small>";

?>
