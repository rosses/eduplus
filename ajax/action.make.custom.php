<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");
sleep(3);
$rows = DB::query("SELECT * FROM preg WHERE materia = %i ORDER BY rand() LIMIT %i",$_POST["materia"],$_POST["qty"]);
$out=array();
foreach ($rows as $row) {
	$out[] = $row["id"];
}
echo implode(",",$out);
?>