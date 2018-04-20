<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");

$row = DB::queryFirstRow("SELECT * FROM test_save_head WHERE test_id = %i AND user_id = %i",$_POST["test"],$_SESSION["id"]);
$rows = DB::query("SELECT * FROM test_save_detail WHERE packet_id = %i",$row["id"]);
echo json_encode(array("head"=>$row,"detail"=>$rows));

?>