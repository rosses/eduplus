<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");
$out = array();
$out["res"] = "ERR";
$ul = "<ul>";
foreach ($_POST["goal"] as $curso=>$materias) {
	foreach ($materias as $materia=>$goal) {
		DB::insertUpdate("teacher_relations", array(
			"teacher_id"=>$_SESSION["id"],
			"materia_id"=>$materia,
			"course_id"=>$curso,
			"goal"=>$goal
		));	

		$ul.= "
			<li><strong>".DB::queryFirstField("select name from course where id = %i", $curso)." / ".DB::queryFirstField("select name from materia where id = %i", $materia).":</strong> ".$goal." pts</li>
		";		
	}
}
$ul .= "</ul>";

DB::update("teacher", array(
	"email" => $_POST["email"],
	"about" => $_POST["about"]
),"id=%i",$_SESSION["id"]);

$me = DB::queryFirstRow("SELECT name, email FROM teacher WHERE id = %i", $_SESSION["id"]);
$html = "Hemos actualizado metas para tus cursos:".$ul;
sendEmail($me["email"], "Actualización de datos", $html, $me["name"]);
$_SESSION["savedProfile"] = 1;
echo json_encode($out);
?>