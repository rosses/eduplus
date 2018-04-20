<?php
require("../../api.eduplus.enlanube.cl/sql.php");
$trs = DB::query("SELECT tr.*, c.name course_name FROM teacher_relations tr, course c, materia m WHERE tr.teacher_id = %i AND tr.course_id = c.id AND tr.materia_id = m.id AND m.id = %i",$_SESSION["id"],$_POST["materia"]);	
foreach ($trs as $tr) {
	echo '<div class="checkbox"><label><input type="checkbox" class="select_cursos" value="'.$tr["course_id"].'" /> '.$tr["course_name"].'</label></div>';
}

?>
