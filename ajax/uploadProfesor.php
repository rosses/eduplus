<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");
$out = array();
$out["res"] = "OK";
print_r($_FILES);
print_r($_POST);
echo json_encode($out);
?>