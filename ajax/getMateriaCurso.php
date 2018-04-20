<?php
require("../../api.eduplus.enlanube.cl/sql.php");
$trs = DB::query("SELECT m.*
				  FROM teacher_relations tr, course c, materia m 
				  WHERE tr.teacher_id = %i AND tr.course_id = c.id AND tr.materia_id = m.id AND c.id = %i",$_SESSION["id"],$_POST["curso"]);	
foreach ($trs as $tr) {
	echo '<option value="'.$tr["id"].'">'.$tr["name"].'</option>';
}

?>
