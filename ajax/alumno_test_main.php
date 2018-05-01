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
							<h5>ASIGNATURA</h5>

							<?php
							$alumno = new Alumno($_SESSION["id"]);
							$alumno->getMaterias();
							$alumno->getTests();
							$alumno->getDrafts();

							foreach ($alumno->materias as $id_materia=>$materia) {
							if (!$_POST["id"]) {
								$_POST["id"] = $id_materia;
							}
							?>
							<button class="btn btn-default ajax-test-materia btn-filter <?=($_POST["id"] == $id_materia ? "on" : "");?>" style="<?=($_POST["id"] == $id_materia ? "background-color: ".$materia["color"].";" : "");?>" type="submit" data-materia="<?=$id_materia;?>">
								<span class="btn-border" style="background-color: <?=$materia["color"];?>"></span>
								<i class="fa fa-folder"></i>
								<?=$materia["name"];?>
							</button>
							<?php } ?>

						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<div class="library-module">	
						<div class="themes-box">	
							<?php
							$f = DB::query("SELECT * FROM test WHERE materia = %i", $_POST["id"]);
							if (count($f)==0) {
								echo "<strong>No existen test disponibles para ".DB::queryFirstField("select name from materia where id = %i",$_POST["id"])."</strong>";
							}
							else {

							?>
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingOne">
									<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
											<?=DB::queryFirstField("select name from materia where id = %i",$_POST["id"]);?> <i class="fa fa-caret-down" aria-hidden="true"></i>
										</a>
									</h4>
								</div>

								<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
									<div class="panel-body">
										
										<div class="row m-b">
											<div class="col-xs-12 col-md-5">
												<!-- Nav tabs -->
												<ul class="nav nav-pills edu-navpill-2" role="tablist">
													<li role="presentation" class="active">
														<a href="#home1" aria-controls="home1" role="tab" data-toggle="tab">
															Test Normal (<?=count($f);?>)
														</a>
													</li>

													<li role="presentation">
														<a href="#profile" aria-controls="profile1" role="tab" data-toggle="tab">
															Test Random (0)
														</a>
													</li>
												</ul>
											</div>

											<div class="col-xs-12 col-md-4">
												<ul class="test-status-info">
													<li>
														<i class="fa fa-circle test-finished"></i> Realizados
													</li>

													<li>
														<i class="fa fa-circle test-pending"></i> Guardado
													</li>
												</ul>
											</div>
										</div>

										<div class="row">
											<div class="col-xs-12">

												<!-- Tab panes -->
												<div class="tab-content">
													<div role="tabpanel" class="tab-pane active" id="home1">
														<h5>test normales</h5>
												
														<ul class="test-list">
															<?php
															foreach ($f as $x) {
															?>
															<li>
																<a href='index.php?load=test&id=<?=$x["id"];?>'>
																	<i class="fa fa-circle <?php echo ($alumno->tests[$x["id"]] ? "test-finished" : "test-pending");?>"></i>

																	<span class="icon-row">
																		<img src="images/icon-test.png" alt="">	
																	</span>

																	<span class="name-1">
																		<?php echo $x["name"]; ?>
																	</span>

																	<!--
																	<span class="name-2">
																		Test Nº1
																	</span>
																	-->
																</a>
															</li>
															<?php
															}
															?>
														</ul>
													</div>
													<div role="tabpanel" class="tab-pane" id="profile1">
													</div>
												</div>

											</div>
										</div>

									</div>
								</div>
							</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>		
</div>