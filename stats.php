
<div id="pageContainerInner" class="no-menu-helper">
	<div id="pageBody">
		<div class="container-fluid">
			<!--
			<div class="statistics-row">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="estadisticas-tipo">
							<ul> 
								<a href="#" class="hrefStatsType" data-type="ENSAYO"><li class="activo">PSU</li></a>
								<a href="#" class="hrefStatsType" data-type="MINIENSAYO"><li>MINI ENSAYOS</li></a>
							</ul>
						</div>
					</div>
				</div>
			</div>
			-->
			<div id="statsAlumnoDiv">
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

/* ************************ ENSAYO TYPES *************** */
var type="ENSAYO";
/*
$(document).on("click",".hrefStatsType",function(e) {
	type=$(this).attr('data-type');
	$(this).parent().find(".activo").removeClass('activo');
	$(this).find("li").addClass('activo');

	$("#statsAlumnoDiv").html('<i class="fa fa-5x fa-spin fa-refresh"></i>');
	$("#statsAlumnoDiv").show();
	$.post("ajax/alumno_general.php", { type: type }, function(data) {
		$("#statsAlumnoDiv").html(data);
	});
	
});
*/


$(document).on("click",".cargarResultados", function(data) {
	var id = $(this).attr('data-id');

	$("#statsAlumnoDiv").html('<i class="fa fa-5x fa-spin fa-refresh"></i>');
	$("#statsAlumnoDiv").show();
	$.post("ajax/alumno_estadistica.php", { id: $(this).attr('data-materia'), test: $(this).attr('data-id'), type: type }, function(data) {
		$("#statsAlumnoDiv").html(data);
	});
});

$(document).on("click",".subjects-infobox", function(data) {
	$("#statsAlumnoDiv").html('<i class="fa fa-5x fa-spin fa-refresh"></i>');
	$("#statsAlumnoDiv").show();
	$.post("ajax/alumno_estadistica.php", { id: $(this).attr('data-id'), type: type }, function(data) {
		$("#statsAlumnoDiv").html(data);
	});
});


// first click
$("#statsAlumnoDiv").html('<i class="fa fa-5x fa-spin fa-refresh"></i>');
$("#statsAlumnoDiv").show();
$.post("ajax/alumno_general.php", { type: type }, function(data) {
	$("#statsAlumnoDiv").html(data);
});
</script>