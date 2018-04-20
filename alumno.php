<form method="POST" action="" id="userTarget">
<!-- Profile Cover -->

<div id="profileCover">
	<!-- Cover image -->
	<div class="cover-wrap">
		<div style="position: absolute;width: 100%;height: 100%;background-color: rgba(0,0,0,0.15);"></div>
		<img src="<?=($me["cover"]=="" ? "images/cover-default.jpg" : $me["cover"]);?>" alt="">
	</div>

		<div class="profile-data-row">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<div class="profile-pic text-center">
							<div class="picture img-circle">
								<div class="pic-wrap img-circle">
									<img src="<?=($me["image"]=="" ? "images/default.jpg" : $me["image"]);?>" width="100%" alt="" class="profileMainPicture">
								</div>
								
								<div id="changeablePicture">
									<label>
										<i class="fa fa-camera" aria-hidden="true"></i>
										<span class="document-opt change-picture-opt">
											<ul>
												<li>
													<a id="changeProfilePicture"><i class="fa fa-camera" aria-hidden="true"></i> Foto de perfil</a>
												</li>
												<li>
													<a id="changePortadaPicture"><i class="fa fa-photo" aria-hidden="true"></i> Foto de portada</a>
												</li>
											</ul>
										</span>
									</label>
									<input type="file" data-id="<?=$_SESSION["id"];?>" id="changeProfileInput" data-type="<?=$_SESSION["tbl"];?>" style="display:none" accept="image/x-png,image/gif,image/jpeg" />
									<input type="file" data-id="<?=$_SESSION["id"];?>" id="changePortadaInput" data-type="<?=$_SESSION["tbl"];?>" style="display:none" accept="image/x-png,image/gif,image/jpeg" />
								</div>
								<div id="changeablePictureLoading" style="display:none;">
									<label><i class="fa fa-spin fa-refresh fa-fw"></i></label>
								</div>
							</div>
						</div>

					</div>

					<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
						<div class="profile-info">
							<h1>
								<?php echo $me["name"]." ".$me["apep"]; ?>
							</h1>

							<div class="profile-position">
								<?php echo $me["work"]; ?><br /><?php echo $me["university_name"]; ?>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-right">
						<button class="btn btn-default btn-a" id="buttonEdit" type="button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button>
						<button class="btn btn-default btn-a" id="buttonSave" type="submit" style="display:none;"><i class="fa fa-floppy-o"></i> Guardar cambios</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="profileBody">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<div class="profile-description">
					<h1>
						<span>Intereses de</span>
						<?php
							$explode = explode(" ",$me["name"]);
							echo $explode[0];

							$sqlIntereses = DB::query("SELECT i.*, IFNULL((SELECT COUNT(*) FROM user_interes a WHERE a.user_id = %i AND a.interes_id = i.id),0) x FROM intereses i ORDER BY i.name ASC",$_SESSION["id"]);
						?>
					</h1>
					<div class="editOff">
						<?php 
					
						$myIntereses = array();
						foreach ($sqlIntereses as $int) {
							if ($int["x"] > 0) {
								$myIntereses[] = $int["name"];	
							}
						}
						if (count($myIntereses)==0) { 
							echo "No tienes intereses configurados, presiona editar para establecer los tuyos";
						}
						else {
							echo implode(", ",$myIntereses);
						}
						?>
					</div>
					<div class="editOn">
						<strong>Intereses:</strong>
						<div class="row">
						<?php
							foreach ($sqlIntereses as $int) {
								echo "
								<div class='col-md-6'>
									<input type='checkbox' name='interes[".$int["id"]."]' ".($int["x"] > 0 ? "checked" : "")." value='1' /> ".$int["name"]."
								</div>
								";
							}

						?>
						</div>
					</div>
					<div class="clearfix"></div>
					<br /><br />
					<h5>
						Mi curso:<br /><br />
						<?php
							$cursos = DB::query("SELECT c.name FROM user_relations ur, course c WHERE ur.user_id = %i AND ur.course_id = c.id", $_SESSION["id"]);
							foreach ($cursos as $curso) {
								echo '<button type="button" class="btn btn-default btn-c check-on" data-id="2">'.$curso["name"].'</button>';
							}
						?>
					</h5>

				</div>
			</div>

			<div class="col-xs-12 col-sm-7 col-sm-offset-1 col-md-7 col-md-offset-1 col-lg-7 col-lg-offset-1">


				<?php
				if ($_SESSION["savedProfile"]) {
				unset($_SESSION["savedProfile"]);
				?>
				<div id="userTarget_ok">
					<div class="alert alert-success">
						Cambios guardados con éxito.
					</div>
				</div>
				<?php
				}
				?>

				<div id="error_ciencias" style="display:none;'" class="alert alert-danger">
					Cada materia especifica seleccionada debe tener un puntaje superior a 0 y menor o igual a 850.
				</div>
				<div id="ponderacion_ale" style="display:none;'" class="alert alert-danger">
					La suma de las ponderaciones por materia debe ser 100%, actualmente es <span id="ponderacion_num">0</span>
				</div>

				<div id="userTarget_load" style="display:none;">
					<i class="fa fa-spin fa-3x fa-refresh"> </i>
					<br /><br /> Guardando 
				</div>
				
				<div id="userForm">

					<div class="profile-module">					
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label>Institución</label>
									<!--<input type="text" class="form-control inp-school editOn" value="<?=$institucionName;?>">-->
									<div class="editOff2"><?=$institucionName;?></div>
								</div>
							</div>

							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label>Rut</label>
									<input type="text" readonly="readonly" class="form-control inp-school editOn" value="<?=format_rut($me["identify"]);?>">
									<div class="editOff"><?=format_rut($me["identify"]);?></div>
								</div>
							</div>
						</div>
					</div>


					<div class="profile-module">					
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label for="phone">Teléfono</label>
									<div class="editOn">
										<div class="input-group">
										  <span class="input-group-addon">+56</span>
										  <input type="text" name="phone" maxlength="9" class="form-control onlyNumber inp-school" value="<?=$me["phone"];?>" placeholder="">
										</div>
									</div>
									<div class="editOff"><?=($me["phone"] == "" ? "No indicado": "+56".$me["phone"]);?></div>
								</div>
							</div>

							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label for="email">Email</label>
									<input type="text" name="email" class="form-control inp-school editOn" value="<?=$me["email"];?>" placeholder="">
									<div class="editOff"><?=$me["email"];?></div>
								</div>
							</div>
						</div>
					</div>

					<div class="profile-module">
						<h3>
							Puntajes metas Psu <?=date("Y");?>
						</h3>

						<div class="text-help">
							Ingresa el puntaje requerido para tu universidad y carrera.
						</div>

						<div class="row">
							<div class="col-md-9">
								<div class="row">
									<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
										<h4>Asignatura</h4>
									</div>
									<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
										<h4>Ptje. Esperado</h4>
									</div>
									<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
										<h4>Ponderación</h4>
									</div>
								</div>
								<?php
								$alumno = new Alumno($_SESSION["id"]);
								$alumno->getEspecify();

								foreach ($alumno->ponderaciones as $pond_id => $pond_data) {
								?>
								<div class="row vertical-align">
								<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
								<?php
								foreach ($pond_data["materias"] as $materia_id => $materia_data) {
									echo '<div class="row"><div class="col-md-12">';
									if ($materia_data["selectable"]==1) {
										echo '<div class="checkbox"><label><input type="checkbox" '.($alumno->especify[$materia_id]==1 ? "checked":"").' class="radioMateriaPerfil" name="especifico['.$materia_id.']" disabled value="1" data-pgid="'.$pond_id.'" data-mid="'.$materia_id.'" />'.$materia_data["name"].'</label></div>';
									}
									else {
										echo $materia_data["name"];
									}
									echo '</div></div>';
								}
								?>
								</div><!--
								--><div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
								<?php
								foreach ($pond_data["materias"] as $materia_id => $materia_data) {
								?>  <div class="row"><div class="col-md-12">
									<div class="form-group">
										<input type="text" id="points_<?=$materia_id;?>" data-pgid="<?=$pond_id;?>"  data-mid="<?=$materia_id;?>" maxlength="3" name="goal[<?=$materia_id;?>]" class="form-control onlyNumber editOn calculatePonderationPoints" for="" step="1" value="<?=$materia_data["points"];?>" max="850">
										<span style="display:inline-block;" class="editOff"><?=$materia_data["points"];?></span>
										<span style="display:inline-block;">pts</span>
									</div></div></div>
								<?php
								}
								?>
								</div><!--
								--><div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 va">
									<div class="form-group">
										<input type="text" id="pond_<?=$pond_id;?>" data-pgid="<?=$pond_id;?>" maxlength="2" name="pond[<?=$pond_id;?>]" class="form-control onlyNumber pondNumber editOn calculatePonderation" for="" step="1" value="<?=$pond_data["pond"];?>" max="100">
										<span style="display:inline-block;" class="editOff"><?=$pond_data["pond"];?></span>
										<span style="display:inline-block;">%</span>
									</div>
								</div>
								</div>	
								<?php
								} // foreach pondGroups
								?>
							</div>

							<div class="col-md-3 col-lg-3 text-center">
								<h4 class="text-help">
									Puntaje objetivo
								</h4>
								<h2 id="pointsExchange"></h2>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">		
							<h3>
								Carrera de interés
							</h3>
							</div>
						</div>

						<div class="row">

							<div class="col-md-6">
								<strong>Universidad</strong>
							</div>

							<div class="col-md-6">
								<strong>Carrera</strong>
							</div>

						</div>
						
						<div class="row">

							<div class="col-md-6">
								<div class="editOff"><?=($me["university_name"]!="" ? $me["university_name"] : "No indicada");?></div>
								<select class="form-control editOn" id="universidad" name="universidad">
									<option value="">- Seleccione -</option>
									<?php
										$us = DB::query("SELECT universidad FROM umineduc GROUP BY universidad ORDER BY universidad ASC");
										foreach($us as $u) {
											echo "<option value='".$u["universidad"]."' ".($me["university_name"]==$u["universidad"] ? "selected" : "").">".$u["universidad"]."</option>";
										}
									?>
								</select>
							</div>

							<div class="col-md-6">
								<div class="editOff"><?=($me["work"]!="" ? $me["work"] : "No indicada");?></div>
								<select class="form-control editOn" id="carrera"  name="carrera">
									<option value="">- Seleccione universidad -</option>
								</select>
								<?php 
								if ($me["university_name"] != "") {
								?>
								<script type="text/javascript">
								$(document).ready(function() {
									$("#carrera").html('<option>cargando...</option>');
									$.post("ajax/alumno_carreras.php", { universidad: '<?=$me["university_name"];?>', sel: '<?=$me["work"];?>'  }, function(data) {
										$("#carrera").html(data);
									});
								});
								</script>
								<?php
								}
								?>
							</div>
						

						</div>

					</div>						


				</div>
				
				<br />
				<br />

			</div>
		</div>
	</div>
</div>

</form>

<script type="text/javascript">
	perfilAlumnoRecalcular();
</script>