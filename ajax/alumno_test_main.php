<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");

?>
<div id="pageContainerInner">
	<div id="menuHelper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
					<a href="#" class="logo-helper">
						<img src="images/logo-helper.png" alt="">
					</a>
				</div>

				<div class="col-xs-12 col-sm-4 col-sm-offset-3 col-md-4 col-md-offset-3 col-lg-4 col-lg-offset-3">
					<div class="search-cont">
						<div class="vcenter">
							<div class="tabcell">
								Selecciona asignatura y test a realizar
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					
				</div>
			</div>
		</div>
	</div>

	<?php
	if ($_GET["saving"]) {
	?>
	<div class="alert alert-success">
		<b>Guardado con éxito</b>, puedes continuar el test &quot;<?=DB::queryFirstField("SELECT name FROM test WHERE id = %i",$_GET["saving"]);?>&quot; cuando lo desees.
	</div>
	<?php
	}
	?>

	<div id="pageBody">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<div class="filter-section">
						<div class="themes-box">
							<?php
							$alumno = new Alumno($_SESSION["id"]);
							$alumno->getMaterias();
							$alumno->getTests();
							$alumno->getDrafts();
							//echo "<pre>".print_r($alumno->materias,1)."</pre>";

							foreach ($alumno->materias as $id_materia=>$materia) {
							//$arr = DB::query("SELECT m.* FROM materia m WHERE m.active = 1 ORDER BY m.orden ASC", $_SESSION["id"]);
							//foreach ($arr as $indice=>$a) {
							if (!$_POST["id"]) {
								$_POST["id"] = $id_materia;
							}
							?>
							<a class="btn btn-default ajax-test-materia btn-filter <?=($_POST["id"] == $id_materia ? "active" : "");?>" style="white-space: normal;" type="submit" data-materia="<?=$id_materia;?>">
								<img src="images/folder-icon.png" alt="">
								<?=$materia["name"];?>
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</a>
							<?php } ?>

						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<div class="library-module">				
						<?php
							$f = DB::query("SELECT * FROM test WHERE materia = %i", $_POST["id"]);
							if (count($f)==0) {
								echo "<strong>No existen test disponibles para ".$a["name"]."</strong>";
							} else {
								echo '<ul class="item-row">';
								foreach ($f as $x) {
								?>									
									<li>
										<?php
										if ($alumno->tests[$x["id"]]) {
										?>
										<div class="test-icon-float test-contestado">
											<i class="fa fa-check"></i>
										</div>
										<?php
										}
										else if ($alumno->drafts[$x["id"]]) {
										?>
										<div class="test-icon-float test-pausado">
											<i class="fa fa-minus"></i>
										</div>
										<?php
										}
										?>
										<a href='index.php?load=test&id=<?=$x["id"];?>'>
											<span class="thumb">
												<img src="images/icon-print.png" alt="">
											</span>
											<span class="item-info text-center">
												<h5><?php echo $x["name"]; ?></h5>
												<span><?php echo $x["about"]; ?></span>
												<button class="btn btn-default" type="">
													<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
												</button>
											</span>
										</a>
									</li>
								<?php
								}
								echo '</ul>';
							}

						?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>		
</div>