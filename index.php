<?php
	session_start();
	require("../api.eduplus.enlanube.cl/sql.php");
	if (!$_SESSION["loged"]) {
		session_destroy();
		header("Location: login.php");
	}
	if ($_SESSION["tbl"] == "user") {
		$me = DB::queryFirstRow("SELECT * FROM user WHERE id = %s",$_SESSION["id"]);
	}
	if ($_SESSION["tbl"] == "teacher") {
		$me = DB::queryFirstRow("SELECT * FROM teacher WHERE id = %s",$_SESSION["id"]);
	}
	$institucionName = DB::queryFirstField("SELECT name FROM customer WHERE id = %i", $me["customer_id"]); 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<title> EDU+ </title>
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/png" href="images/favicon.ico"/>
	<link rel="shortcut icon" type="image/png" href="images/favicon.ico"/>

	<!-- CSS & Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/generic.css?v=<?=date("dmYHis");?>">
	<link rel="stylesheet" href="css/circle.css">
	<link rel="stylesheet" href="css/slider.css">
	<link rel="stylesheet" href="css/dropzone.css">
	<link rel="stylesheet" href="css/select2.min.css" />
	<link rel="stylesheet" href="css/font-awesome.min.css" />
	<link rel="stylesheet" href="css/sfwebfont.css" />
	<link rel="stylesheet" href="js/ui/jquery-ui.min.css" />
	<link rel="stylesheet" href="js/ui/jquery-ui.theme.min.css" />

	<!-- JQuery -->
	<script src="js/jquery-1.12.4.min.js"></script>


	<!-- Js -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-slider.js"></script>
	<script src="js/jquery.rut.min.js"></script>
	<script src="js/jquery.mask.min.js"></script>
	<script src="js/ui/jquery-ui.min.js"></script>
	<script src="js/canvasjs.min.js"></script>
	<script src="js/select2.full.min.js"></script>
	<script src="js/dropzone.js"></script>
	<script src="js/bootstrap-datetimepicker.js"></script>
	<script src="js/locales/bootstrap-datetimepicker.es.js"></script>

	<!-- GoogleFont -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet"> 

	<script src="js/script.js?v=<?=date("YmdHis");?>"></script>

</head>
<body>


	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myTestDraft" aria-hidden="true" id="modalDraftExists">
	  <div class="modal-dialog modal-md">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="saveTestConfirmTitle">Este test tiene una copia guardada del <span id="save_date_test"></span> <b>¿Deseas continuarla?</b></h4>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-success" id="recoverTestSaving" data-id="<?=$_GET["id"];?>">Si, continuar</button>
	        <button type="button" class="btn btn-primary" id="recoverTestDelete" data-id="<?=$_GET["id"];?>" data-dismiss="modal">No, empezar de cero</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div id="modal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title" id="modal-title"></h4>
	      </div>
	      <div class="modal-body" id="modal-body">
	        
	      </div>
	      <div class="modal-footer">
	        <a href="#" target="_blank" class="btn btn-info modal-options-result" id="resultPrintAction" style="display:none;">Imprimir</a>
	        <a href="#" target="_blank" class="btn btn-info modal-options-result" id="resultDownloadAction" style="display:none;">Descargar</a>
	        <a href="#" target="_blank" class="btn btn-info modal-options-result" id="resultTestAction" style="display:none;">Descargar Facsímil</a>
	        <button type="button" class="btn btn-default modal-options-result" data-dismiss="modal">Cerrar</button>
	      </div>
	    </div>

	  </div>
	</div>

	<div id="mainMenu">
		<ul>
			<li>
				<a href="index.php" class="<?php echo (!$_GET["load"] ? "current" : ""); ?>">
					<img src="images/icon-menu-profile.png" alt="">
					<span>Perf&iacute;l</span>
				</a>
			</li>

			<?php if ($_SESSION["loged"] == 1) { ?>
			<li>
				<a href="index.php?load=lib" class="<?php echo ($_GET["load"]=="lib" ? "current" : ""); ?>">
					<img src="images/icon-menu-library.png" alt="">
					<span>Librer&iacute;a</span>
				</a>
			</li>
			<li>
				<a href="index.php?load=test" class="<?php echo ($_GET["load"]=="test" ? "current" : ""); ?>">
					<img src="images/icon-menu-test.png" alt="">
					<span>Test</span>
				</a>
			</li>
			<li>
				<a href="index.php?load=stats" class="<?php echo ($_GET["load"]=="stats" ? "current" : ""); ?>">
					<img src="images/icon-menu-statistics.png" alt="">
					<span>Estad&iacute;sticas</span>
				</a>
			</li>

			<?php } if ($_SESSION["loged"] == 2) { ?>
			<li>
				<a href="index.php?load=libprofe" class="<?php echo ($_GET["load"]=="libprofe" ? "current" : ""); ?>">
					<img src="images/icon-menu-library.png" alt="">
					<span>Librer&iacute;a</span>
				</a>
			</li>
			<li>
				<a href="index.php?load=reforzamiento" class="<?php echo ($_GET["load"]=="reforzamiento" ? "current" : ""); ?>">
					<img src="images/icon-menu-reinforcement.png" alt="">
					<span>Reforzamiento</span>
				</a>
			</li>
			<li>
				<a href="index.php?load=curso" class="<?php echo ($_GET["load"]=="curso" ? "current" : ""); ?>">
					<img src="images/icon-menu-grade.png" alt="">
					<span>Curso</span>
				</a>
			</li>
			<li>
				<a href="index.php?load=general" class="<?php echo ($_GET["load"]=="general" ? "current" : ""); ?>">
					<img src="images/icon-menu-statistics.png" alt="">
					<span>Estad&iacute;sticas</span>
				</a>
			</li>

			<?php } ?>

		</ul>
	</div>
	<div id="headerTopBar">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<a href="#" id="menu">
						<i class="fa fa-bars" aria-hidden="true"></i>
					</a>
				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<div class="page-title">
						<h4>
						<?php
						if (!$_GET["load"]) { echo "Mi perfil"; }
						else if ($_GET["load"] == "lib") { echo "Librería"; }
						else if ($_GET["load"] == "cursos") { echo "Cursos"; }
						else if ($_GET["load"] == "reforzamiento") { echo "Reforzamiento"; }
						else if ($_GET["load"] == "test") { echo "Tests"; }
						else if ($_GET["load"] == "test_custom") { echo "Tests personalizado"; }
						else if ($_GET["load"] == "stats") { echo "Estadísticas"; }
						else if ($_GET["load"] == "general") { echo "Estadísticas"; }
						?>
						</h4>
					</div>
				</div>

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="menu-control">
						<div class="row">
							<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center">
								<a href="#" id="chat" class="menu-btn-icon">
									<i class="fa fa-envelope-o" aria-hidden="true"></i>
									<!-- Notification -->
									<!--<span class="type-a">1</span>-->
								</a>
							</div>

							<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 text-center">
								<a href="#" class="menu-btn-icon">
									<i class="fa fa-bell-o" aria-hidden="true"></i>
									<!-- Notification -->
									<!--<span class="type-b">0</span>-->
								</a>
							</div>
							
							<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
								<div class="profile-thumb">
									<div class="thumb-pic img-circle">
										<img src="<?=($me["image"]=="" ? "images/default.jpg" : $me["image"]);?>" alt="" class="profileMainPicture" />
									</div>

									<div class="user-type">
										<?php if ($_SESSION["loged"] == 1) { ?>
										Alumno
										<?php } if ($_SESSION["loged"] == 2) { ?>
										Profesor
										<?php } ?>
									</div>

									<div class="user-name">
										<?=$me["name"];?>
									</div>
								</div>
							</div>
							
							
							<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-center">
								<a href="login.php" class="menu-btn-icon">
									<i class="fa fa-sign-out" aria-hidden="true"></i> <span style="font-size: 13px;">cerrar sesión</span>
								</a>
							</div>
						</div>

						<!-- CHAT Notification -->
						<div class="chat-contact-list" style="display:none;">
							<div class="arrow-top"></div>

							<ul>

							</ul>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="loading" class="text-center" style="display:none;">
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<i class="fa fa-4x fa-spin fa-circle-o-notch"></i>
		<br />
		<br />
		<br />
	</div>
	<div id="pageContainer">
		<?php
		if ($_GET["load"] && file_exists($_GET["load"].".php")) {
			include($_GET["load"].".php");
		}
		else if ($_SESSION["loged"]==2) {
			include("profe.php");	
		} 
		else { 
			include("alumno.php");
		} ?>
			
	</div>
	


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-end-test">
  <div class="modal-dialog modal-sm" style="width: 600px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">¿Deseas terminar y evaluar este test ahora?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="endTestConfirm">Si</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myConfirmSaving" aria-hidden="true" id="modalSaveTest">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="saveTestConfirmTitle">Vas a guardar tu test para continuarlo en el futuro. <b>¿Deseas continuar?</b></h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="saveTestConfirm">Si</button>
        <button type="button" class="btn btn-primary" id="saveTestClose" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myEditLibrary" aria-hidden="true" id="modalEditLibrary">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Editar archivo de la libreria</h4>
      </div>
      <div class="modal-body" id="modalEditLibraryHtml">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="confirmSaveLibrary">Editar archivo</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>


</body>
</html>