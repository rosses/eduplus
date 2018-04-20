<?php
require("../../api.eduplus.enlanube.cl/sql.php");
$trs = DB::query("SELECT tr.*, c.name course_name FROM teacher_relations tr, course c, materia m WHERE tr.teacher_id = %i AND tr.course_id = c.id AND tr.materia_id = m.id AND m.id = %i",$_SESSION["id"],$_POST["materia"]);	
foreach ($trs as $tr) {
	echo '<li>
	<button class="btn btn-default btn-square">'.$tr["course_name"].'</button>
	</li>';
}
echo '
	<li>
	<button class="btn btn-default btn-square add-btn">
	<i class="fa fa-plus-circle" aria-hidden="true"></i>
	</button>
	</li>
	';
?>
