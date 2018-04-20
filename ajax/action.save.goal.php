<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");
$out = array();
$out["res"] = "ERR";

/* Actualizar Ponderacion */
foreach ($_POST["pond"] as $pg=>$p) {
	DB::insertUpdate("pond_group_user", array(
		"pond_id"=>$pg,
		"pond_user"=>$_SESSION["id"],
		"pond_valor"=>$p
	));
}


/* Actualizar Puntaje x Materias */
$ul = "<ul>";
foreach ($_POST["goal"] as $mat=>$goal) {
	DB::insertUpdate("user_goal", array(
		"id"=>$_SESSION["id"],
		"materia"=>$mat,
		"points"=>$goal
	));	
	$ul.= "<li><strong>".DB::queryFirstField("select name from materia where id = %i", $mat).":</strong> ".$goal." puntos</li>";
}
$ul .= "</ul>";

/* Actualizar datos del perfil */
DB::update("user", array(
	"university_name" => $_POST["universidad"],
	"work" => $_POST["carrera"],
	"phone" => $_POST["phone"],
	"email" => $_POST["email"]
),"id=%i",$_SESSION["id"]);

/* Borrar intereses */
DB::query("DELETE FROM user_interes WHERE user_id = %i", $_SESSION["id"]);

/* Nuevos intereses */
if (count($_POST["interes"]) > 0) {
	foreach ($_POST["interes"] as $id=>$nul) {
		DB::insert("user_interes", array(
			"user_id" => $_SESSION["id"],
			"interes_id" => $id
		));
	}
}

/* Borrar especifica */
DB::query("DELETE FROM user_especify WHERE user_id = %i", $_SESSION["id"]);

/* Nuevas especificas */
if (count($_POST["especifico"]) > 0) {
	foreach ($_POST["especifico"] as $id=>$nul) {
		DB::insert("user_especify", array(
			"user_id" => $_SESSION["id"],
			"especify" => $id
		));
	}
}

/* Enviar Correo todo OK */
$me = DB::queryFirstRow("SELECT name, email FROM user WHERE id = %i", $_SESSION["id"]);
$html = "Hemos actualizado tus metas PSU:".$ul;
sendEmail($me["email"], "Actualización de puntajes", $html, $me["name"]);
$_SESSION["savedProfile"] = 1;
echo json_encode($out);
?>