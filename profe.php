<form id="profileTeacher" action="" method="POST">
<div id="pageContainer">
	<!-- Profile Cover -->
	<div id="profileCover">
		<!-- Cover image -->
		<div class="cover-wrap">
			<div style="position: absolute;width: 100%;height: 100%;background-color: rgba(0,0,0,0.15);"></div>
			<img src="<?=($me["cover"]=="" ? "images/cover-default.jpg" : $me["cover"]);?>" alt="" class="portadaMainPicture">
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
								<?=$me["name"];?>
							</h1>

							<div class="profile-position">
								<?php echo $institucionName; ?>
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
	

	<div id="profileBody">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<div class="profile-description">
						<h1>
							Acerca de <?php $me0 = explode(" ",$me["name"]); echo $me0[0]; ?>
						</h1>

						<p>
							<div class="desc-box"><?=($me["about"]!="" ? $me["about"] : "<div class='editOff'><i>Aún no escribes una pequeña biografía, presiona editar para crear la tuya</i></div>");?></div>
							<textarea name="about" class="form-control editOn" style="resize: none; height: 200px;"><?=$me["about"];?></textarea>
						</p>
					</div>
				</div>
				<?php
				if ($_SESSION["savedProfile"]) {
				unset($_SESSION["savedProfile"]);
				?>
				<div id="userTarget_ok" class="col-xs-12 col-sm-7 col-sm-offset-1 col-md-7 col-md-offset-1 col-lg-7 col-lg-offset-1">
					<div class="alert alert-success">
						Cambios guardados con éxito.
					</div>
				</div>
				<?php
				}
				?>
				<div id="puntajeTeacherInvalido" style="display:none;'" class="alert alert-danger">
					A lo menos uno de los puntajes es inválido o es mayor a 850 puntos.
				</div>								

				<div id="userTarget_load" style="display:none;" class="col-xs-12 col-sm-7 col-sm-offset-1 col-md-7 col-md-offset-1 col-lg-7 col-lg-offset-1">
					<i class="fa fa-spin fa-3x fa-refresh"> </i>
					<br /><br /> Guardando 
				</div>

			
				<div class="col-xs-12 col-sm-7 col-sm-offset-1 col-md-7 col-md-offset-1 col-lg-7 col-lg-offset-1" id="teacherForm">
					<div class="profile-module">

						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label for="">Institución</label>
									<div><?=$institucionName;?></div>
								</div>
							</div>

							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label for="">Rut</label>
									<input type="text" class="form-control inp-school editOn" readonly value="<?=format_rut($me["identify"]);?>" placeholder="">
									<div class="editOff"><?=format_rut($me["identify"]);?></div>
								</div>
							</div>
						</div>
					</div>

					<div class="profile-module">
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label for="">Email</label>
									<input type="text" name="email" class="form-control inp-school editOn" value="<?=($me["email"]);?>" placeholder="">
									<div class="editOff"><?=($me["email"]);?></div>
								</div>
							</div>
						</div>
					</div>

					<div class="profile-module">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group">
									<h3>
										Mis cursos y materias
									</h3>
									
									<div class="profile-module">
										<div class="row">
										<?php
											$vigenteMateria = null;
											$trs = DB::query("SELECT tr.*, m.name materia_name, c.name course_name FROM teacher_relations tr, materia m, course c WHERE tr.teacher_id = %i AND tr.materia_id = m.id AND tr.course_id = c.id ORDER BY m.id ASC", $me["id"]);
											foreach ($trs as $tr) {
												if ($vigenteMateria != $tr["materia_id"]) {

													if ($vigenteMateria!=null) { echo "</div></div><!-- /row --><div class='row'>"; }
													echo "
														<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6'>
															<button type='button' class='btn btn-default btn-c check-on' data-id='".$tr["materia_id"]."'>".$tr["materia_name"]."</button>
														</div>
														<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 grade-list-col'>
													";
												}

												echo '<button type="button" class="btn btn-default btn-square">'.$tr["course_name"].'</button>';

												$vigenteMateria = $tr["materia_id"];
											}
											
										?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="profile-module">
						<h3>
							Metas de cursos
						</h3>

						<div class="goal-course text-center">
							<div class="row">
								<?php
								reset($trs);
								foreach ($trs as $tr) {
									echo '
									<div class="col-md-3 col-xs-12">
										<div class="goal-course-bar-out"></div>
										<div class="goal-course-circle"></div>
										<div class="goal-course-title">
											'.$tr["materia_name"].' en '.$tr["course_name"].'
										</div>
										<div class="goal-course-input">
											<input maxlength="3" class="form-control teacherGoals editOn" name="goal['.$tr["course_id"].']['.$tr["materia_id"].']" type="text" value="'.$tr["goal"].'" /> 
											<span class="editOff">'.$tr["goal"].'</span>pts
										</div>
									</div>
									';
								}
								?>
							</div>
						</div>

						<br /><br />

					</div>
				</div>
			</div>
		</div>
	</div>
		
</div>
</form>
