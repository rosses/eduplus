<!--
<div id="lib_container">
<div id="pageContainerInner" class="no-menu-helper libreria-profesor">
		<div id="pageBody">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	
							<h3>Bienvenido a tu librería</h3>
							<p></p>
							<p></p>
							<p></p>
							<div class="row lib-selector">
								<div class="col-md-6">
									<div class="white-box text-center">
										<a href="#" class="gotoLibDocs">
											<div class="reinforcement-subjects-box">
												<div class="subjects-thumb">
													<img src="http://api.eduplus.enlanube.cl/files/resources/docs.png" alt="">
												</div>

												<h3>Documentos, Guías y Apoyos</h3>

											</div>
										</a>
									</div>
								</div>
								<div class="col-md-6">
									<div class="white-box text-center">
										<a href="#" class="gotoLibTests">
											<div class="reinforcement-subjects-box">
												<div class="subjects-thumb">
													<img src="http://api.eduplus.enlanube.cl/files/resources/mind.png" alt="">
												</div>

												<h3>Facsimiles y Tests en línea</h3>

											</div>
										</a>
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
	$(".gotoLibDocs").click(function(e) {
		e.preventDefault();
		$.post("ajax/profe_lib_docs.php", {}, function(data){
			$("#lib_container").html(data);
		});
	});
	
	/*
	$.post("ajax/profe_lib.php", {}, function(data){
		$("#lib_container").html(data);
	});*/
	
});
/*
$(document).on("change", "#libMateriaChanger",function(e) {
	$.post("ajax/profe_lib.php", {
		id: $(this).val()
	}, function(data){
		$("#lib_container").html(data);
	});
});
*/
</script>
-->
<div id="lib_container">

</div>
<script type="text/javascript">
$(document).ready(function() {
	$.post("ajax/profe_lib.php", {}, function(data){
		$("#lib_container").html(data);
	});
});
$(document).on("change", "#libMateriaChanger",function(e) {
	$.post("ajax/profe_lib.php", {
		id: $(this).val()
	}, function(data){
		$("#lib_container").html(data);
	});
});
</script>