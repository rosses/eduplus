<?php
session_start();
require("../../api.eduplus.enlanube.cl/sql.php");
$profesor = new Profesor($_SESSION["id"]);
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
					<br />
					<a class="link_to_docs btn btn-lg btn-primary pull-right">Sube un archivo</a>
				</div>
			</div>
		</div>
	</div>
	
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
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">

					<div class="filter-section">
						<div class="themes-box">
							<select class="form-control inp-school white" id="libMateriaChanger">
							<?php
							$arr = DB::query("SELECT m.* FROM materia m WHERE m.active = 1 AND m.superior = 0 AND EXISTS(SELECT g.* FROM teacher_relations g WHERE g.materia_id = m.id AND g.teacher_id = %i) ORDER BY m.orden ASC", $_SESSION["id"]);
							
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
							<hr />
							<h5>EJES TEMÁTICOS</h5>

							<?php
							$materia = new Materia($_POST["id"]);
							foreach ($materia->getEjes() as $eje) {
								if (!$_POST["eje"]) {
									$_POST["eje"] = $eje["id"];
								}
								?>
								<button class="btn btn-default btn-eje btn-filter <?=($_POST["eje"] == $eje["id"] ? "on" : "");?>" style="<?=($_POST["eje"] == $eje["id"] ? "background-color: ".$materia->color.";" : "");?>" type="submit" data-eje="<?=$eje["id"];?>" data-materia="<?=$materia->id;?>">
									<span class="btn-border" style="background-color: <?=$materia->color;?>"></span>
									<i class="fa fa-folder"></i>
										<?=$eje["name"];?>
								</button>
							<?php 
							if ($_POST["eje"] == $eje["id"]) { $thisEje = $eje; } 
							} ?>

						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<div class="library-module">	
						<div class="themes-box">	
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingOne">
									<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
											<?=$thisEje["name"];?> <i class="fa fa-caret-down" aria-hidden="true"></i>
										</a>
									</h4>
								</div>

								<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">

										<div class="row">
											<div class="col-xs-12">
												<?php
												$files = $profesor->getFilesEje($_POST["eje"], 1);
												?>
												<ul class="test-list">
													<?php foreach ($files as $file) { ?>
													<li>
														<a>
															<?php
															// Iconos de rendimiento
															$renders = explode(",",$file["rendimiento"]);
															if (count($renders)>0) {
																echo "<div class='file-icons'>";
																foreach ($renders as $render) {
																?>
																<i class="fa fa-circle flag-<?=$render;?>"></i>
																<?php 
																}
																echo "</div>";
															}
															// Tags de cursos
															$renders = explode(",",$file["cursos"]);
															if (count($renders)>0) {
																echo "<div class='file-courses'>";
																foreach ($renders as $render) {
																?>
																<span><?=$render;?></span>
																<?php 
																}
																echo "</div>";
															}
															?>
															<span class="icon-row"><img src="images/icon-test.png" alt=""></span>
															<span class="name-1">
																<i class="fa fa-clock-o fa-fw"></i> 
																<?php
																	if ($file["library_planificada"]=="0") {
																		echo "No programado";
																	} else {
																		if ($file["sin_termino"]=="1") {
																			echo "desde ".date("d/m H:i",strtotime($file["library_desde"]));
																		} else {
																			echo date("d/m",strtotime($file["library_desde"]))." al ".date("d/m",strtotime($file["library_hasta"]));
																		}
																	}
																?>
															</span>
															<span class="name-2"><?php echo $file["library_name"]; ?></span>
															<span><button data-open="<?=$file["library_fileend"];?>" class="openExternal">Ver</button><button data-eje="<?=$_POST["eje"];?>" data-id="<?=$file["file_id"];?>" class="editFile">Editar</button><button data-id="<?=$file["file_id"];?>" class="removeFile">Eliminar</button></span>
														</a>
													</li>
													<?php } ?>
												</ul>


											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>		

</div>

<script type="text/javascript">
$(document).ready(function() {
	$(".btn-eje").click(function(e) {
		e.preventDefault();
		$.post("ajax/profe_lib.php", { id: $(this).attr('data-materia'), eje: $(this).attr('data-eje') }, function(data){
			$("#lib_container").html(data);
		});
	});
	$(".link_to_docs").click(function(e) {
		e.preventDefault();
		$.post("ajax/profe_lib_docs.php", { materia: <?=$_POST["id"];?>}, function(data){
			$("#lib_container").html(data);
		});
	});
	$(".openExternal").click(function(e) {
		e.preventDefault();
		window.open($(this).attr('data-open'));
	});
	$(".removeFile").click(function(e) {
		if (confirm('¿Desea eliminar este archivo? Este proceso es irreversible')) {
			var t = $(this);
			$.ajax({
				url:"http://api.eduplus.enlanube.cl/ws.php", 
				type: 'POST', 
				contentType: 'application/json', 
				data: JSON.stringify({ action: 'removeLibraryFile', file_id: t.attr('data-id')}), 
				dataType: 'json', 
				success: function(data) {
							t.closest("li").remove();
				}
			});
		}
	});

	$(".editFile").click(function(e) {
		$.post("ajax/modal.editlibrary.php", {id: $(this).attr('data-id'), eje: $(this).attr('data-eje') }, function(data) {
			$("#modalEditLibraryHtml").html(data);
			$("#modalEditLibrary").modal("show");
		});
	});

});
</script>