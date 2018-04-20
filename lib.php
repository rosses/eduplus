<div id="lib_container">

</div>
<script type="text/javascript">
$(document).ready(function() {
	$.post("ajax/alumno_lib.php", {}, function(data){
		$("#lib_container").html(data);
	});
});
$(document).on("change", "#libMateriaChanger",function(e) {
	$.post("ajax/alumno_lib.php", {
		id: $(this).val()
	}, function(data){
		$("#lib_container").html(data);
	});
});
</script>