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