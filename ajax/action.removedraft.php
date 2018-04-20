<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");

$rows = DB::query("SELECT * FROM test_save_head WHERE test_id = %i AND user_id = %i",$_POST["test"],$_SESSION["id"]);
foreach ($rows as $row) {
	DB::query("DELETE FROM test_save_head WHERE id = %i",$row["id"]);
	DB::query("DELETE FROM test_save_detail WHERE packet_id = %i",$row["id"]);
}

?>