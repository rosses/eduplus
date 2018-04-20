<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");
$out = array();
$out["res"] = "OK";


if ($_FILES["imagen"]["tmp_name"]) {

    $maxDim = 500;
    $file_name = $_FILES['imagen']['tmp_name'];
    $target_filename = date("Ymd_his").".jpg";
    list($width, $height, $type, $attr) = getimagesize( $file_name );
    if ( $width > $maxDim || $height > $maxDim ) {
        $ratio = $width/$height;
        if( $ratio > 1) {
            $new_width = $maxDim;
            $new_height = $maxDim/$ratio;
        } else {
            $new_width = $maxDim*$ratio;
            $new_height = $maxDim;
        }
        $src = imagecreatefromstring( file_get_contents( $file_name ) );
        $dst = imagecreatetruecolor( $new_width, $new_height );
        imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
        imagedestroy( $src );
        imagejpeg( $dst, "../../api.eduplus.enlanube.cl/files/".$_POST["source"]."/".$target_filename , 100); 
        imagedestroy( $dst );
        $out["alg"] = "resized";
    }
    else {
    	$out["alg"] = "copy";
    	copy($file_name,"../../api.eduplus.enlanube.cl/files/".$_POST["source"]."/".$target_filename);
    }

	$finalImage = "http://api.eduplus.enlanube.cl/files/".$_POST["source"]."/".$target_filename;
	DB::update($_POST["type"], array(
		($_POST["source"] == "cover" ? "cover" : "image") => $finalImage
	),"id=%i",$_POST["id"]);
}
$out["imagen"] = $finalImage;

echo json_encode($out);
?>