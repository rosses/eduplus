$(document).ready(function() {

	$("#rut").rut({
		formatOn: 'keyup'
	});

	$("#login").click(function(e) {
		e.preventDefault();
		$(".step1").hide();
		$(".step2").show();

		$.post("ajax/login.php", {
			rut: $("#rut").val(),
			clave: $("#clave").val()
		}, function(data) {
			if (data.res == "OK") {
				location.href='index.php';
			} else {
				location.href='login.php?error=1';
			}
		}, "json");

	});
	
	var noHideMe = 0;
	$("#menu").click(function(e) {
		if($("#mainMenu").css("left") == "-100px"){
		    $("#mainMenu").animate({"left": "20px"},"fast");
		    noHideMe = 1;
		}
		else{
		    $("#mainMenu").animate({"left": "-100px"},"fast");
		}
	});

	$("#mainMenu").mouseout(function(e) {
		noHideMe = 0;
		setTimeout(function() {
			if (noHideMe == 0) {
				$("#menu").click();
			}
		}, 1000);
	});

	$("#mainMenu").mouseover(function(e) {
		noHideMe = 1;
	});

	$("#chat").click(function(e) {
		$(".chat-contact-list").toggle();
	});


	$("#userTarget").submit(function(e) {
		e.preventDefault();
		$("#ponderacion_ale").hide();
		$("#error_ciencias").hide();

		var pn = 0;
		var error_ciencias = 0;

		$.each($(".pondNumber"), function(k,v) {
			if (!isNaN(parseFloat($(this).val()))) {
				pn = pn + parseFloat($(this).val());
			}
		});

		$.each($(".radioMateriaPerfil:checked"), function(k,v) {
			var m = $(this).attr('data-mid');
			var miPuntaje = parseInt($(".calculatePonderationPoints[data-mid='"+m+"']").val());
			if (isNaN(miPuntaje) || miPuntaje > 850 || miPuntaje < 1) {
				error_ciencias = 1;
			}
		});

		if (pn != 100 && pn > 0) {
			$("#ponderacion_ale").show();
			$("#ponderacion_num").html(pn.toFixed(2)+"%");
		}
		else if (error_ciencias == 1) {
			$("#error_ciencias").show();
		}
		else {
			$("#userTarget_load").show();
			$(".editOn").hide();
			$("#userForm").hide();

			$.post("ajax/action.save.goal.php", $("#userTarget").serialize() , function(data) {
				location.href='index.php';
			},"json");
		}
	});

	$(document).on("click","#saveTest",function(e) {
		e.preventDefault();
		$("#modalSaveTest").modal("show");
	});
	$(document).on("click","#saveTestConfirm",function(e) {
		e.preventDefault();
	    $(".all_ok").hide();
	    $(".all_load").show();
	    $("#modalSaveTest").modal('hide');
	    setTimeout(function() {
	    	$.post("ajax/action.save.test.php?save=1&mm="+mmm+"&ss="+sss, $("form").serializeArray(),function(x) {
	    		location.href = 'index.php?load=test&saving='+x;
	    	});
	    }, 2000);
	});

	$("#universidad").change(function(e) {
		if ($(this).val() != "") {
			$("#carrera").html('<option>cargando...</option>');
			$.post("ajax/alumno_carreras.php", { universidad: $(this).val() }, function(data) {
				$("#carrera").html(data);
			});
		} else {
			$("#carrera").html('<option value="">- Seleccione universidad -</option>');
		}
	});

	$(".clickMat").click(function(e) {
		e.preventDefault();
		$("#grade-itemlist").html('');
		$("#loadingpageBody").show();
		$.post("ajax/curso_profesor.php", { materia: $(this).attr('data-id') }, function(data) {
			$("#loadingpageBody").hide();
			$("#grade-itemlist").html(data);
		});
	});

	$(document).on("click","#makeTest",function(e) {
		e.preventDefault();
		$("#new_test_load").show();
		$("#new_test").hide();
		$.post("ajax/action.make.custom.php", { materia: $("#test_custom_materia").val(), qty: $("#test_custom_preguntas").val() }, function(data) {
			location.href='index.php?load=test&custom='+data;
		});
	});
	$(document).on("click","#recoverTestDelete",function(e) {
		$.post("ajax/action.removedraft.php", { test: $(this).attr('data-id') }, function(data) { });
	});
	$(document).on("click","#recoverTestSaving",function(e) {
		$.post("ajax/action.recoverdraft.php", { test: $(this).attr('data-id') }, function(data) {
			mmm = data.head.mm;
			sss = data.head.ss;
			$("#test-start").click();
			$("#modalDraftExists").modal("hide");
			for (var i = 0; i < data.detail.length;i++) {
				$("ul[data-pregid='"+data.detail[i].preg+"']").find("li > a").get(parseInt(data.detail[i].reply)).click();
			}
		},"json");
	});

	$(document).on("change","#estaDetalleCurso",function(e) {
		e.preventDefault();
		$.post("ajax/getMateriaCurso.php", { curso: $(this).val() }, function(data) {
			$("#estaDetalleMateria").html(data);
			if (isFirstLoad == 1) { 
				isFirstLoad = 0;
				$("#estaDetalleMateria").change();
			}
		});
	});

	$(document).on("change","#estaDetalleMateria",function(e) {
		e.preventDefault();
		$("#pageBody").html('');
		$("#loadingpageBody").show();
		$.post("ajax/curso_estadistica.php", { curso: $("#estaDetalleCurso").val(), materia: $(this).val() }, function(data) {
			$("#loadingpageBody").hide();
			$("#pageBody").html(data);
		});
	});
	$(document).on("click",".reloadTest", function(e) {
		e.preventDefault();
		var id = $(this).attr('data-id');
		$("#pageBody").html('');
		$("#loadingpageBody").show();
		$.post("ajax/curso_estadistica.php", { curso: $("#estaDetalleCurso").val(), materia: $("#estaDetalleMateria").val(), test: id }, function(data) {
			$("#loadingpageBody").hide();
			$("#pageBody").html(data);
		});
	});

	$(document).on("mouseover",".cursoJoin",function(e) {
		e.preventDefault();
		$(this).addClass("active");
	});
	$(document).on("mouseout",".cursoJoin",function(e) {
		e.preventDefault();
		$(this).removeClass("active");
	});

	$(document).on("click",".cursoJoin",function(e) {
		e.preventDefault();
		var course = $(this).attr('data-course');
		var materia = $(this).attr('data-materia');
		$("#loading").show();
		$("#pageContainer").html('');
		$.post("ajax/curso_detalle.php", { course: course, materia: materia }, function(data) {
			$("#loading").hide();
			$("#pageContainer").html(data);
		});
	});

	$(document).on("change","#selectDetalleCursoSorter",function(e) {
		e.preventDefault();
		var detalleCurso = $("#selectDetalleCurso").val().split('-');
		var course = detalleCurso[0];
		var materia = detalleCurso[1];
		$("#loadingpageBody").show();
		$("#pageBody").html('');
		$.post("ajax/curso_detalle.php", { course: course, materia: materia, orderby: $(this).val() }, function(data) {
			$("#loadingpageBody").hide();
			$("#pageContainer").html(data);
		});
	});
	$(document).on("change","#selectDetalleCurso",function(e) {
		e.preventDefault();
		var detalleCurso = $(this).val().split('-');
		var course = detalleCurso[0];
		var materia = detalleCurso[1];
		$("#loadingpageBody").show();
		$("#pageBody").html('');
		$.post("ajax/curso_detalle.php", { course: course, materia: materia, orderby: $("#selectDetalleCursoSorter").val() }, function(data) {
			$("#loadingpageBody").hide();
			$("#pageContainer").html(data);
		});
	});

	$(document).on('transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd', ".student-card-container", function() {
		if (!$(this).hasClass("active") && $(this).hasClass("opened")) {
         $(this).find(".student-card").addClass("open");
         $(this).addClass("active");
         var sd = $(this).find(".student-details");
         sd.html('<br><br><div class="text-center"><i class="fa fa-spin fa-2x fa-refresh"></i></div>');
         $.post("ajax/alumno_box.php", { id: $(this).attr('data-id') }, function(data) {
         	sd.html(data);
         });

         var sg = $(this).find(".student-card-graph");
         sg.html('<br><br><div class="text-center"><i class="fa fa-spin fa-2x fa-refresh"></i></div>');
         $.post("ajax/alumno_box_graph.php", { id: $(this).attr('data-id'), materia: $(this).attr('data-materia') }, function(data) {
         	sg.html(data);
         });
     	} 
    });
	$(document).on("click",".openAlumno",function(e) {
		e.preventDefault();
		$(this).parent().parent().parent().find(".student-card-graph").html('');
		if ($(this).parent().parent().parent().hasClass("opened")) {
			$(this).removeClass("iAmOpen");
			$(this).parent().parent().parent().removeClass("opened");
			$(this).parent().parent().parent().find(".student-card").removeClass("open");
			$(this).parent().parent().parent().removeClass("active");
		}
		else {
			$(this).addClass("iAmOpen");
			$(this).parent().parent().parent().addClass("opened");
		}
	});

	$("#profileTeacher").submit(function(e) {
		e.preventDefault();
		var noPost = 0;
		$.each($(".teacherGoals"), function(k,v) {
			if (isNaN(parseFloat($(this).val()))) {
				$(this).val('0');
			}
			if (parseFloat($(this).val()) > 850) {
				$("#puntajeTeacherInvalido").show();
				noPost = 1;
				return false;
			}
		});

		if (noPost == 0) {
			$("#userTarget_load").show();
			$("#teacherForm").hide();

			$.post("ajax/saveGoalTeacher.php", $("#profileTeacher").serialize(), function(data) {
				location.href='index.php';
			},"json");
		}
	});

	$(document).on("click","#buttonEdit", function(e) {
		e.preventDefault();
		$("#buttonEdit").hide();
		$("#buttonSave").show();
		$(".editOn").show();
		$(".radioMateriaPerfil").each(function() {
			var mid = $(this).attr('data-mid');
			$(this).prop('disabled',false);
			if ($(this).is(":checked")) {
				$(".calculatePonderationPoints[data-mid='"+mid+"']").prop('disabled',false);
			} else {
				$(".calculatePonderationPoints[data-mid='"+mid+"']").prop('disabled',true);
			}
		});
		$(".editOff").hide();
	});

	$(document).on("click",".radioMateriaPerfil", function(e) {
		var mid = $(this).attr('data-mid');
		if ($(this).is(":checked")) {
			$(".calculatePonderationPoints[data-mid='"+mid+"']").prop('disabled',false);
		} else {
			$(".calculatePonderationPoints[data-mid='"+mid+"']").prop('disabled',true);
			$(".calculatePonderationPoints[data-mid='"+mid+"']").val(0);
		}
	});

	$(document).on("click",".teacherGoals", function(e) {
		$("#puntajeTeacherInvalido").hide();
		$(this).select();
	});

 	$(document).on("change","#changeProfileInput", function() {
 		var form = new FormData(); 
 		var file = $(this)[0].files[0];
 		form.append("imagen", file);
 		form.append("id", $(this).attr('data-id'));
 		form.append("type", $(this).attr('data-type'));
 		form.append("source", "profile");
 		$("#changeablePicture").show();
 		$("#changeablePictureLoading").show();
		$.ajax({
	        url: "ajax/changePicture.php",
	        method: "POST",
	        dataType: 'json',
	        data: form,
	        processData: false,
	        contentType: false,
	        success: function(result){
	        	$(".profileMainPicture").attr('src',result.imagen);
	        	$("#changeablePicture").show();
	        	$("#changeablePictureLoading").hide();
	        },
	        error: function(er){

	        }
		});
 	});
 	$(document).on("change","#changePortadaInput", function() {
 		var form = new FormData(); 
 		var file = $(this)[0].files[0];
 		form.append("imagen", file);
 		form.append("id", $(this).attr('data-id'));
 		form.append("type", $(this).attr('data-type'));
 		form.append("source", "cover");
 		$("#changeablePicture").show();
 		$("#changeablePictureLoading").show();
		$.ajax({
	        url: "ajax/changePicture.php",
	        method: "POST",
	        dataType: 'json',
	        data: form,
	        processData: false,
	        contentType: false,
	        success: function(result){
	        	$(".portadaMainPicture").attr('src',result.imagen);
	        	$("#changeablePicture").show();
	        	$("#changeablePictureLoading").hide();
	        },
	        error: function(er){

	        }
		});
 	});
 	
 	$(document).on("click",".deleteRowUpload", function(e) {
 		e.preventDefault();
 		$(this).parent().parent().parent().parent().parent().remove();
 	});
 	

 	$(document).on("click","#changePortadaPicture", function(e) {
 		e.preventDefault();
 		$("#changePortadaInput").click();
 	});
 	$(document).on("click","#changeProfilePicture", function(e) {
 		e.preventDefault();
 		$("#changeProfileInput").click();
 	});

});

$(document).on("keyup",".calculatePonderation,.calculatePonderationPoints",function (e) {
	perfilAlumnoRecalcular();
});

function perfilAlumnoRecalcular() {
	var p = 0;
	$.each($(".calculatePonderation"), function(i,k) {
		var pgid = $(this).attr('data-pgid');
		var suma = 0;
		var qty = 0;
		$.each($(".calculatePonderationPoints[data-pgid='"+pgid+"']"), function(i2,k2) {
			var suma_in = parseInt($(this).val());
			if (isNaN(suma_in) || suma_in == 0) {
				suma_in = 0;
			}
			else {
				qty++;
			}
			suma = suma + suma_in;
		});

		var promedio = (qty > 0 ? Math.round(suma / qty) : 0);
		var pond = parseInt($(this).val());
		if (isNaN(pond)) { pond = 0; }

		if (pond > 0) {
			p += ( (promedio*pond) / 100 );	
		}
	});
	$("#pointsExchange").html(Math.round(p)+" pts.");
}

$(document).on("click","#logtest",function (e) {
	e.preventDefault();
	
});
$(document).on("click","#faketest",function (e) {
	e.preventDefault();
	$.each($(".answers-box>ul"), function(i,v) {
		var items = $(this).find("li>a");
		var n = Math.floor(Math.random()*items.length);
		console.log($(this).find("li>a").get(n),n);
		$(this).find("li>a").get(n).click();
	});
});

$(document).on("click",".ver_respuesta_test",function (e) {
	e.preventDefault();
	var user = $(this).attr('data-user');
	var test = $(this).attr('data-test');
	modal("Tus resultados", "<i class='fa fa-spin fa-refresh fa-2x'></i>");
	$("#resultDownloadAction").attr('href','http://api.eduplus.enlanube.cl/pdf.cartola.php?user='+user+'&id='+test);
	$("#resultTestAction").attr('href','http://api.eduplus.enlanube.cl/pdf.facsimil.php?id='+test);
	$("#resultPrintAction").attr('href','#');
	$.post("ajax/alumno_cartola.php", { user: user, test: test }, function(data) {
		$("#modal-body").html(data);
	});
});


$(document).on("keydown",".onlyNumber",function (e) {
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             return;
    }
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});

$.fn.isInViewport = function() {
  var elementTop = $(this).offset().top;
  var elementBottom = elementTop + $(this).outerHeight();

  var viewportTop = $(window).scrollTop();
  var viewportBottom = viewportTop + $(window).height();

  return elementBottom > viewportTop && elementTop < viewportBottom;
};

function modal(title,html) {
	$("#modal-title").html(title);
	$("#modal-body").html(html);
	$(".modal-options-result").hide();
	if (title=="Tus resultados") {
		$(".modal-options-result").show();
	}
	$("#modal").modal("show");
}

function hr(bytes, si) {
    var thresh = si ? 1000 : 1024;
    if(Math.abs(bytes) < thresh) {
        return bytes + ' B';
    }
    var units = si
        ? ['kB','MB','GB','TB','PB','EB','ZB','YB']
        : ['KiB','MiB','GiB','TiB','PiB','EiB','ZiB','YiB'];
    var u = -1;
    do {
        bytes /= thresh;
        ++u;
    } while(Math.abs(bytes) >= thresh && u < units.length - 1);
    return bytes.toFixed(1)+' '+units[u];
}

function hexToR(h) {return parseInt((cutHex(h)).substring(0,2),16)}
function hexToG(h) {return parseInt((cutHex(h)).substring(2,4),16)}
function hexToB(h) {return parseInt((cutHex(h)).substring(4,6),16)}
function cutHex(h) {return (h.charAt(0)=="#") ? h.substring(1,7):h}
function hexToRGB(x) {
	return hexToR(x)+','+hexToG(x)+','+hexToB(x);
}