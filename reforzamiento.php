<div id="reforza_ajax">

</div>
<script type="text/javascript">
$(document).ready(function() {
	$.post("ajax/profe_reforza.php", {}, function(data){
		$("#reforza_ajax").html(data);
	});
});
$(document).on("click", ".group_call",function(e) {
	e.preventDefault();
	$.post("ajax/profe_reforza.php", {
		rel: $(this).attr('data-rel'),
		group: $(this).attr('data-group')
	}, function(data){
		$("#reforza_ajax").html(data);
	});
});
$(document).on("change", "#reforzamientoChanger",function(e) {
	$.post("ajax/profe_reforza.php", {
		rel: $(this).val()
	}, function(data){
		$("#reforza_ajax").html(data);
	});
});
$(document).on("click", ".uploadCustomMaterial",function(e) {
	e.preventDefault();
	$.post("ajax/profe_reforza.php", {
		rel: $(this).attr('data-rel'),
		group: $(this).attr('data-group'),
		upload: $(this).attr('data-eje')
	}, function(data){
		$("#reforza_ajax").html(data);
	});
});

</script>
