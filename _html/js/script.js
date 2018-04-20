$(document).ready(function() {
	$("#login").click(function(e) {
		e.preventDefault();
		$(".step1").hide();
		$(".step2").show();
		setTimeout(function() {
			if ($.trim($("#rut").val()) == "1-9" && $.trim($("#clave").val()) == "12345") {
				location.href='login.php?true=1';	
			}
			else if ($.trim($("#rut").val()) == "2-7" && $.trim($("#clave").val()) == "12345") {
				location.href='login.php?profe=1';	
			}
			else {
				location.href='login.php?error=1';		
			}
		},2000);
	});

	$("#menu").click(function(e) {
		$("#mainMenu").toggle();
	});

	$("#chat").click(function(e) {
		$(".chat-contact-list").toggle();
	});

});