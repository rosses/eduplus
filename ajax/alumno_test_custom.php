<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");
$alumno = new Alumno($_SESSION["id"]);
$alumno->getMaterias();

?>
<div id="pageContainerInner" class="no-menu-helper">
	<div id="pageBody">
		<div class="container-fluid">
			<?php 
			if ($_POST["success"]) {
			?>
			<div id="successCLoad" class="alert alert-success"><strong>Tu última publicación fue exitosa.</strong></div>
			<script type="text/javascript">
				setTimeout(function() {
					$("#successCLoad").fadeOut();
				},3000);
			</script>
			<?php
			}
			?>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<form id="new_test" method="POST" action="">
					<div class="white-box">
						<div class="module-row">
							<div class="folder-carousel">
								<h4>
									Crea tu test personalizado de acuerdo a tu desempeño
								</h4>
							</div>
						</div>
						<div class="module-row">
							<div class="form-group">
								
								<div class="row"> 
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<div class="panel panel-info">
										  <div class="panel-heading">
											Seleccione materia
										  </div>
										  <div class="panel-body">
											<select class="form-control inp-school-b" id="test_custom_materia">
											<?php
											foreach ($alumno->materias as $id_materia=>$materia) {
												echo "<option value='".$id_materia."' ".($_POST["materia"] == $id_materia ? "selected" : "").">".$materia["name"]."</option>";
											}
											?>
											</select>
										  </div>
										 </div>
									</div>

									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<div class="panel panel-info">
										  <div class="panel-heading">
											Cantidad de preguntas
										  </div>
										  <div class="panel-body">
										  	<select class="form-control" id="test_custom_preguntas">
										  		<option value="20">20 preguntas</option>
										  		<option value="40">40 preguntas</option>
										  		<option value="60">60 preguntas</option>
										  		<option value="80">80 preguntas</option>
										  	</select>
										  </div>
										 </div>
									</div>
								</div>
							</div>
						</div>

						<div class="module-row">
							<button class="btn-full-width" id="makeTest">Generar test</button>
						</div>
					</div>
					</form>
					<div id="new_test_load" class="text-center" style="display:none;">
						<i class="fa fa-spin fa-2x fa-refresh"></i>
						<br /><br />
						<h4>Procesando...</h4>
					</div>
				</div>
			</div>	
		</div>
		<br />
		<br />
		<br />
	</div>
</div>


</script>


