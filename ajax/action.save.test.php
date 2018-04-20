<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");
$quiz = $_POST["quiz"];
$data = $_POST["alt"];

$test = DB::queryFirstRow("SELECT * FROM test WHERE id = %i",$quiz);
$alts = DB::query("SELECT * FROM preg WHERE test_id = %i",$quiz);

$arr = array();
$totalCorrectas = 0;

if ($_GET["save"]=="1") {
	$head = "test_save_head";
	$detail = "test_save_detail";
	// delete old saved
	$rows = DB::query("SELECT * FROM test_save_head WHERE test_id = %i AND user_id = %i",$test["id"],$_SESSION["id"]);
	foreach ($rows as $row) {
		DB::query("DELETE FROM test_save_head WHERE id = %i",$row["id"]);
		DB::query("DELETE FROM test_save_detail WHERE packet_id = %i",$row["id"]);
	}
}
else {
	$head = "test_end_head";
	$detail = "test_end_detail";
}

$timeRandom = time();

foreach ($alts as $a) {
	$correct = $a["correct_id"];

	if ($data[$a["id"]]!="N") {
		DB::insertUpdate($detail, array(
			"packet_id" => $timeRandom,
			"user_id" => $_SESSION["id"],
			"test_id" => $test["id"],
			"cuando" => date("Y-m-d H:i:s"),
			"preg" => $a["id"],
			"materia" => $a["materia"],
			"eje" => $a["eje"],
			"correct" => $correct,
			"reply" => $data[$a["id"]],
			"isOk" => ($data[$a["id"]] == $correct ? 1 : 0)
		), array(
			"cuando" => date("Y-m-d H:i:s"),
			"correct" => $correct,
			"reply" => $data[$a["id"]],
			"isOk" => ($data[$a["id"]] == $correct ? 1 : 0)
		));

	}


	if ($data[$a["id"]] == $correct) {
		$arr[$a["materia"]][$a["eje"]] += 1;
		$totalCorrectas++;
	}
	else {
		$arr[$a["materia"]][$a["eje"]] += 0;
	}
}

/* Solo calculo final */
if (!$_GET["save"]) {
	foreach ($arr as $materia=>$sub) {
		foreach ($sub as $eje => $v) {

			$now = DB::queryFirstField("SELECT total FROM points WHERE materia = %i AND eje = %i",$materia,$eje);
			if (!$now) { $now = 0; }
			$now += $v;

			DB::insertUpdate("points", array(
				"id" => $_SESSION["id"],
				"materia" => $materia,
				"eje" => $eje,
				"total" => $now
			), array(
				"total" => $now
			));


		}
	}
}

DB::query("UPDATE ".$head." SET isLast = 0 WHERE isLast = 1 AND user_id = %i AND test_id = %i", $_SESSION["id"],$test["id"]);

if ($test["tipo"] == "ENSAYO") {
	if ($totalCorrectas == 0) { $totalPSU = 150; }
	else { 
		$totalPSU = DB::queryFirstField("SELECT ptje FROM materia_psu WHERE materia_id = %i AND correct = %i", $materia, $totalCorrectas); 
	}

	if (!$totalPSU) { $totalPSU = 150; }
	// update las psu record
	if (!$_GET["save"]) {
		DB::query("UPDATE user SET tempPsu = ".$totalPSU." WHERE id = 1");
	}

	DB::insert($head, array(
		"user_id" => $_SESSION["id"],
		"test_id" => $test["id"],
		"tipo" => $test["tipo"],
		"materia" => $test["materia"],
		"points" => $totalPSU,
		"cuando" => date("Y-m-d H:i:s")
	));
	$packet_id = DB::insertId();
}

else {
	DB::insert($head, array(
		"user_id" => $_SESSION["id"],
		"test_id" => $test["id"],
		"tipo" => $test["tipo"],
		"materia" => $test["materia"],
		"points" => $totalCorrectas,
		"cuando" => date("Y-m-d H:i:s")
	));
	$packet_id = DB::insertId();
}

DB::query("UPDATE ".$detail." SET packet_id = %i WHERE packet_id = ".$timeRandom." AND user_id = %i AND test_id = %i",$packet_id, $_SESSION["id"],$test["id"]);

if ($_GET["save"]=="1") {
	DB::update($head, array(
		"mm" => $_GET["mm"],
		"ss" => $_GET["ss"]
	),"id=%i",$packet_id);

	echo $test["id"];
}
else {
	// remove drafts
	$rows = DB::query("SELECT * FROM test_save_head WHERE test_id = %i AND user_id = %i",$test["id"],$_SESSION["id"]);
	foreach ($rows as $row) {
		DB::query("DELETE FROM test_save_head WHERE id = %i",$row["id"]);
		DB::query("DELETE FROM test_save_detail WHERE packet_id = %i",$row["id"]);
	}
}

?>