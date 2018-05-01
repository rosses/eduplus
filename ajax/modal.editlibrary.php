<?php
require("../../api.eduplus.enlanube.cl/sql.php");

$lib = DB::queryFirstRow("SELECT * FROM library_files WHERE file_id = %i",$_POST["id"]);
$targets = DB::query("SELECT * FROM library_target WHERE library_file_id = %i",$_POST["id"]);

if (count($targets) > 0) {

	$rendimiento_low = 0;
	$rendimiento_medium = 0;
	$rendimiento_high = 0;
	$cursos=array();
	foreach ($targets as $target) {
		
		if ($target["rendimiento"]=="1") { $rendimiento_high = 1; }
		else if ($target["rendimiento"]=="2") { $rendimiento_medium = 1; }
		else if ($target["rendimiento"]=="3") { $rendimiento_low = 1; }

		$cursos[$target["course_id"]] = 1;
		$ejes[$target["eje_id"]] = 1;

	}
	
	$profesor = new Profesor($lib["teacher_id"]);
	$materia = new Materia($targets[0]["materia_id"]);


	?>
	<div class="form-group">
	  <label for="materia">Materia</label>
	  <input type="text" class="form-control" id="materia" value="<?=$materia->name;?>" disabled>
	</div>
	<div class="form-group">
	  <label for="library_name">Nombre documento</label>
	  <input type="text" class="form-control" id="library_name" value="<?=$lib["library_name"];?>" placeholder="Nombre documento">
	</div>
	<div class="form-group">
	  <label>Ejes temáticos:</label>
	  <?php
	  foreach ($materia->getEjes() as $eje) {
	  	echo '<div class="checkbox"><label><input type="checkbox" '.($ejes[$eje["id"]] ? "checked":"").' class="eje_relations" value="'.$eje["id"].'" /> '.$eje["name"].'</label></div>';
	  }
	  ?>
	</div>
	<div class="form-group">
	  <label>Cursos:</label>
	  <?php
	  foreach ($profesor->getMateriaCurso($materia->id) as $rel) {
	  	echo '<div class="checkbox"><label><input type="checkbox" '.($cursos[$rel["course_id"]] ? "checked":"").' class="course_relations" value="'.$rel["course_id"].'" /> '.$rel["course_name"].'</label></div>';
	  }
	  ?>
	</div>
	<div class="form-group">
		<label>Disponibilidad:</label>
		<div><input type="radio" name="disponible" value="1" onclick="jQuery('#customDate').hide();" <?=($lib["library_planificada"]=="0"?"checked":"");?> id="disponible_siempre" /> <label for="disponible_siempre">Siempre</label></div>
		<div><input type="radio" name="disponible" value="2" onclick="jQuery('#customDate').show();" <?=($lib["library_planificada"]=="1"?"checked":"");?> id="disponible_custom" /> <label for="disponible_custom">Personalizar disponibilidad</label></div>
		<div id="customDate" class="panel" style="display:<?=($lib["library_planificada"]=="0"?"none":"");?>;">
			<div class="row panel-body">
				<div class="col-md-6">
					<label for="fecha_inicio" class="control-label">Desde</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<input class="form-control" size="16" type="text" id="fecha_inicio" value="<?=($lib["library_desde"]!="" ? date("d/m/Y",strtotime($lib["library_desde"])) : "");?>" readonly>
						<span class="input-group-addon"><select id="hora_inicio"><?php for($i=0;$i<24;$i++) { echo "<option value='".($i<10?"0".$i:$i).":00' ".(date("G",strtotime($lib["library_desde"])) == $i ? "selected":"").">".($i<10?"0".$i:$i).":00</option>"; } ?></select></span>
					</div>
				</div>
				<div class="col-md-6">
					<label for="fecha_inicio" class="control-label">Hasta</label> <input type="checkbox" id="no_end" <?=($lib["sin_termino"]=="1"?"checked":"");?>;"> <label for="no_end">Sin fecha de término</label>
					<div class="input-group fecha_termino_div" style="display:<?=($lib["sin_termino"]=="1"?"none":"");?>;">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<input class="form-control" size="16" type="text" id="fecha_termino" value="<?=($lib["library_hasta"]!="" ? date("d/m/Y",strtotime($lib["library_hasta"])) : "");?>" readonly>
						<span class="input-group-addon"><select id="hora_termino"><?php for($i=0;$i<24;$i++) { echo "<option value='".($i<10?"0".$i:$i).":00' ".(date("G",strtotime($lib["library_hasta"])) == $i ? "selected":"").">".($i<10?"0".$i:$i).":00</option>"; } ?></select></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
	  <label>Grupos de rendimiento:</label>
	  <ul>
			<label class="checkbox"><input type="checkbox" id="visibilidad_all" <?=($rendimiento_high == 1 && $rendimiento_low == 1 && $rendimiento_medium == 1 ? "checked":"");?> /> Todos</label>
			<ul>
				<div class="checkbox"><label><input type="checkbox" class="visibilidad_check" <?=($rendimiento_high == 1 ? "checked":"");?> value="1" /> Alumnos sobre 80% de rendimiento</label></div>
				<div class="checkbox"><label><input type="checkbox" class="visibilidad_check" <?=($rendimiento_medium == 1 ? "checked":"");?> value="2" /> Alumnos entre 50% y 80% rendimiento</label></div>
				<div class="checkbox"><label><input type="checkbox" class="visibilidad_check" <?=($rendimiento_low == 1 ? "checked":"");?> value="3" /> Alumnos bajo 50% de rendimiento</label></div>
			</ul>
	  </ul>
	</div>
	
	<script type="text/javascript">
	$(".visibilidad_check").click(function(e) {
		if ($(".visibilidad_check:checkbox:checked").length < 3) {
			$("#visibilidad_all").prop("checked",false);
		}
		else {
			$("#visibilidad_all").prop("checked",true);	
		}
	});
	$("#visibilidad_all").click(function(e) {
		if ($(this).is(":checked")) {
			$(".visibilidad_check").prop('checked',true);
		} else {
			$(".visibilidad_check").prop('checked',false);
		}
	});
	$("#no_end").change(function(e) {
		if ($(this).is(":checked")) {
			$(".fecha_termino_div").hide();
			$("#fecha_termino").prop('disabled',true);
			$("#hora_termino").prop('disabled',true);
		}
		else {
			$(".fecha_termino_div").show();
			$("#fecha_termino").prop('disabled',false);
			$("#hora_termino").prop('disabled',false);
		}
	});
	$("#confirmSaveLibrary").click(function(e) {
		var planificada = ($("#disponible_siempre").is(":checked") ? 0 : 1);
		var sin_termino = ($("#no_end").is(":checked") ? 1 : 0);
		var fecha_inicio = $("#fecha_inicio").val();
		var fecha_termino = $("#fecha_termino").val();
		var hora_inicio = $("#hora_inicio").val();
		var hora_termino = $("#hora_termino").val();

		if ($(".visibilidad_check:checked").length == 0) {
			alert('Debe seleccionar a lo menos un grupo de rendimiento');
		}
		else if ($.trim($("#library_name").val())=="") {
			alert('Titulo del documento no puede ser vacio');	
		} 
		else if ($(".course_relations:checked").length == 0) {
			alert('Debe seleccionar a lo menos un curso');
		}
		else if ($(".eje_relations:checked").length == 0) {
			alert('Debe seleccionar a lo menos un eje');
		}
		else if (planificada == 1 && (fecha_inicio=="" || hora_inicio=="") ) {
			alert("Si vas a planificar la publicación debes parametrizar el inicio correctamente");
		}
		else if (planificada == 1 && sin_termino == 0 && (fecha_termino=="" || hora_termino == "")) {
			alert("Si vas a planificar la publicación debes parametrizar el término correctamente");	
		}
		else {
			$("#modalEditLibrary").modal("hide");
			$.ajax({
				url:"http://api.eduplus.enlanube.cl/ws.php", 
				type: 'POST', 
				contentType: 'application/json', 
				data: JSON.stringify({ 
					action: 'updateLibrary', 
					file_id: '<?=$lib["file_id"];?>',
					materia_id: '<?=$materia->id;?>',
					library_name: $.trim($("#library_name").val()),
					courses: $('.course_relations:checked').map(function() { return this.value; }).get().join(','),
					ejes: $('.eje_relations:checked').map(function() { return this.value; }).get().join(','),
					visibilidad: $('.visibilidad_check:checked').map(function() { return this.value; }).get().join(','),
					sin_termino: sin_termino,
					planificada: planificada,
					fecha_inicio: fecha_inicio,
					fecha_termino: fecha_termino,
					hora_inicio: hora_inicio,
					hora_termino: hora_termino,
				}), 
				dataType: 'json', 
				success: function(x) {
					$.post("ajax/profe_lib.php", { id: "<?=$materia->id;?>", eje: "<?=$_POST["eje"];?>" }, function(data){
						$("#lib_container").html(data);
					});
				}
			});
		}
	});

	$("#fecha_termino").datepicker({ dateFormat: 'dd/mm/yy' });
	$("#fecha_inicio").datepicker({ dateFormat: 'dd/mm/yy' });

	</script>
<?php 
}
else { echo "Archivo invalido. Contacte a soporte"; }
?>