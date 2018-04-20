<?php
	session_start();
	if ($_GET["true"]) {
		$_SESSION["loged"] = 1;
		header("Location: index.php");
	}
	else if ($_GET["profe"]) {
		$_SESSION["loged"] = 2;
		header("Location: index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<title> EDU+ </title>
	<link rel="shortcut icon" type="image/png" href="images/favicon.ico"/>
	<link rel="shortcut icon" type="image/png" href="images/favicon.ico"/>

	<!-- FontAwesome -->
	<script src="https://use.fontawesome.com/12fbfdb954.js"></script>

	<!-- CSS & Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/generic.css">

	<!-- JQuery -->
	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<!-- Js -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-slider.js"></script>
	<script src="js/jquery.rut.min.js"></script>

	<!-- GoogleFont -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet"> 
	
	<script src="js/script.js"></script>
	
</head>
<body>

	<div id="logiPage">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4 text-center">
					<div class="vcenter">
						<div class="tabcell">
							<div class="login-box">
								<div class="brand">
									<img src="images/login-brand-icon.png" alt="">
								</div>

								<div class="user-name">
									EDU+ Login	
								</div>
		
								<form class="form-box">

									<?php if ($_GET["error"]) { ?>
									<div class="alert alert-danger">
									Acceso denegado
									</div>
									<?php } ?>
									
									<div class="form-group step1">
										<label class="sr-only" for="">RUT</label>
										<i class="fa fa-id-card-o" aria-hidden="true"></i>
										<input type="text" class="form-control" id="rut" placeholder="XX.XXX.XXX-X">
									</div>

									<div class="form-group step1">
										<label class="sr-only" for="">Clave</label>
										<i class="fa fa-lock" aria-hidden="true"></i>
										<input type="password" class="form-control" id="clave" placeholder="Clave">
									</div>

									<div id="loading" class="step2" style="display: none;">
										<i class="fa fa-refresh fa-spin fa-5x"></i>
									</div>

									<button type="submit" id="login" class="step1 btn btn-default btn-type-a">Acceder</button>

									<p>
										Si eres parte de EDU+, conoce<br/>
										nuestros <a href="#">términos de servicio</a>
									</p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</body>
</html>