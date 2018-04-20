<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");
$out = array();
$out["res"] = "ERR";
unset($_SESSION["loged"]);
$_POST["rut"] = str_replace(".","",$_POST["rut"]);
$_POST["rut"] = str_replace("-","",$_POST["rut"]);
$l = DB::queryFirstRow("SELECT * FROM user WHERE identify = %s AND pwd = %s AND active = 1",$_POST["rut"],$_POST["clave"]);
if ($l) {
	$out["res"] = "OK";
	$_SESSION["id"] = $l["id"];
	$_SESSION["tbl"] = "user";
	$_SESSION["loged"] = 1;
}
else {
	// check teacher
	$l = DB::queryFirstRow("SELECT * FROM teacher WHERE identify = %s AND pwd = %s",$_POST["rut"],$_POST["clave"]); // AND active = 1
	if ($l) {
		$out["res"] = "OK";
		$_SESSION["id"] = $l["id"];
		$_SESSION["tbl"] = "teacher";
		$_SESSION["loged"] = 2;
	}
	else {
		$out["res"] = "ERR";
	}
}
echo json_encode($out);
?>