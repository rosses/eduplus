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
								<div class="search-box">
									<input type="text" class="form-control" placeholder="Buscar...">
									<button type="submit" class="btn btn-default">
										<i class="fa fa-folder-open-o" aria-hidden="true"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					
				</div>
			</div>
		</div>
	</div>

	<div id="pageBody">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<div class="filter-section">
						<select class="form-control inp-school white" id="libMateriaChanger">
						<?php
						$arr = DB::query("SELECT m.* FROM materia m WHERE m.active = 1 AND m.superior = 0 AND EXISTS(SELECT g.* FROM user_goal g WHERE g.materia = m.id AND g.id = %i AND g.pond > 0) ORDER BY m.orden ASC", $_SESSION["id"]);
						
						foreach ($arr as $indice=>$a) {
						if (!$_POST["id"]) {
							$_POST["id"] = $a["id"];
						}
						?>
						<option value="<?=$a["id"];?>" <?=($_POST["id"] == $a["id"] ? "selected":"");?>><?=$a["name"];?></option>
						<?php
						}
						?>		
						</select>

						<div class="themes-box">
							<h5>Ejes tem&aacute;ticos</h5>
							<?php
							$ejes = DB::query("SELECT * FROM eje e WHERE e.parent = %i",$_POST["id"]);
							foreach ($ejes as $eje) {
							?>
							<a class="btn btn-default btn-filter" style="white-space: normal;" type="submit">
								<img src="images/folder-icon.png" alt="">
								<?=$eje["name"];?>
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</a>
							<?php } ?>
							<!--
							<button class="btn btn-default btn-filter" type="submit">
								<img src="images/folder-icon.png" alt="">
								Geometr&iacute;a
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</button>

							<button class="btn btn-default btn-filter" type="submit">
								<img src="images/folder-icon.png" alt="">
								Datos y azar
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</button>

							<button class="btn btn-default btn-filter" type="submit">
								<img src="images/folder-icon.png" alt="">
								N&uacute;meros
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</button>

							<button class="btn btn-default btn-filter" type="submit">
								<img src="images/folder-icon.png" alt="">
								Todos
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</button>
							-->
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<div class="library-module">
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="heading<?=$eje["id"];?>">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse0" aria-expanded="true" aria-controls="collapse0">
										Contenidos generales <i class="fa fa-caret-down" aria-hidden="true"></i>
									</a>
								</h4>
							</div>

							<div id="collapse0" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading0">
								<div class="panel-body">
									<ul class="item-row">
										<?php

										$libs = DB::query("SELECT * 
														   FROM library_target lt, library l 
														   WHERE lt.materia_id = %i AND lt.library_id = l.id AND 
														   EXISTS(SELECT * FROM user_relations ur WHERE ur.user_id = %i AND ur.course_id = lt.course_id) 
														   AND lt.eje_id = %i 
														   AND (SELECT COUNT(*) FROM library_target l2 WHERE l2.library_id = l.id AND l2.materia_id = lt.materia_id GROUP BY l2.eje_id) > 1
														   ORDER BY id DESC", $_POST["id"],$_SESSION["id"],$eje["id"]);
										if (count($libs)==0) {
											echo "<li style='width: 100%;'>No hay contenido activo</li>";
										}
										foreach ($libs as $lib) {
										?>
										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														<?=$lib["titulo"];?>
													</h5>

													<span>
														<?php 
														if ($lib["desde"]) {
															echo date("d/m/Y", strtotime($lib["desde"]));
														} else {
															echo "Siempre disponible";
														}
														?>
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>
										<?php											
										}
										?>
									</ul>
								</div>
							</div>

						<?php
						$uno = false;
						foreach ($ejes as $eje) {
						?>
						
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="heading<?=$eje["id"];?>">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$eje["id"];?>" aria-expanded="true" aria-controls="collapse<?=$eje["id"];?>">
										<?=$eje["name"];?> <i class="fa fa-caret-down" aria-hidden="true"></i>
									</a>
								</h4>
							</div>

							<div id="collapse<?=$eje["id"];?>" class="panel-collapse collapse <?=($uno ? "in" : "");?>" role="tabpanel" aria-labelledby="heading<?=$eje["id"];?>">
								<div class="panel-body">
									<ul class="item-row">
										<?php

										$libs = DB::query("SELECT * 
														   FROM library_target lt, library l 
														   WHERE lt.materia_id = %i AND lt.library_id = l.id AND 
														   EXISTS(SELECT * FROM user_relations ur WHERE ur.user_id = %i AND ur.course_id = lt.course_id) 
														   AND lt.eje_id = %i 
														   AND (SELECT COUNT(*) FROM library_target l2 WHERE l2.library_id = l.id AND l2.materia_id = lt.materia_id GROUP BY l2.eje_id) = 1
														   ORDER BY id DESC", $_POST["id"],$_SESSION["id"],$eje["id"]);

										if (count($libs)==0) {
											echo "<li style='width: 100%;'>No hay contenido activo</li>";
										}
										foreach ($libs as $lib) {
										?>
										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														<?=$lib["titulo"];?>
													</h5>

													<span>
														<?php 
														if ($lib["desde"]) {
															echo date("d/m/Y", strtotime($lib["desde"]));
														} else {
															echo "Siempre disponible";
														}
														?>
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>
										<?php											
										}
										?>
										<!--


										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>

											<span class="document-opt">
												<ul>
													<li>
														<a href=""><i class="fa fa-share-alt" aria-hidden="true"></i> Compartir</a>
													</li>

													<li>
														<a href=""><i class="fa fa-cloud-download" aria-hidden="true"></i> Descargar en .zip</a>
													</li>

													<li>
														<a href=""><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar</a>
													</li>
												</ul>
											</span>
										</li>

										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>

										<li class="item-locked">
											<div class="locked-box">
												<img src="images/icon-folder-locked.png" alt="">

												<div class="locked-date">
													<div class="vcenter">
														<div class="tabcell">
															<span>Fecha</span>
															<span class="date">07/09/17</span>
															<span>Disponible</span>
														</div>
													</div>
												</div>
											</div>

											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>
										-->

									</ul>
								</div>
							</div>
						</div>
						<?php unset($uno); } ?>

						<!--

						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingTwo">
								<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										Geometr&iacute;a <i class="fa fa-caret-down" aria-hidden="true"></i>
									</a>
								</h4>
							</div>

							<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
								<div class="panel-body">
									<ul class="item-row">
										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>

						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingThree">
								<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
										Medici&oacute;n <i class="fa fa-caret-down" aria-hidden="true"></i>
									</a>
								</h4>
							</div>

							<div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
								<div class="panel-body">
									<ul class="item-row">
										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<span class="thumb">
													<img src="images/icon-print.png" alt="">
												</span>

												<span class="item-info">
													<h5>
														Imprimir Guía 4 
													</h5>

													<span>
														02/08/17
													</span>

													<button class="btn btn-default" type="">
														<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
													</button>
												</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						-->
					</div>
				</div>
			</div>
		</div>
	</div>		
</div>