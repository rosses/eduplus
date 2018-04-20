<?php
if ($_GET["id"] || $_GET["custom"]) {
?>

<div id="pageContainerInner" class="no-menu-helper not-img-bg all_ok">
	<div id="testSectionRight">
		<div class="test-over"></div>
		<div class="container-fluid">
			<form name="test">
			<div class="row">
				<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 test-side-left">
					<div class="test-cont">
						<div id="question-zone" style="width: 100%; height: calc(100vh - 110px); overflow-y: scroll;">
							<?php 
								if ($_GET["custom"]) {
									$test = array(
										"name" => "Personalizado",
										"qty" => 5,
										"minutos" => 120
									);
									$sql = DB::query("SELECT p.*, m.name materia_name, e.name eje_name FROM preg p, materia m, eje e WHERE p.id IN %ls AND p.materia = m.id AND p.eje = e.id",explode(",",$_GET["custom"]));
								} else {
									$test = DB::queryFirstRow("SELECT * FROM test WHERE id = %i",$_GET["id"]);
									$sql = DB::query("SELECT p.*, m.name materia_name, e.name eje_name FROM preg p, materia m, eje e WHERE p.test_id = %i AND p.materia = m.id AND p.eje = e.id",$_GET["id"]);
								}
								$c = 1;
								//'.$s["materia_name"].' / 
								//.$c.".- "
								foreach ($sql as $s) {
									echo '
									<div data-c="'.$c.'" class="viewport-question" id="question_'.$c.'">
									<div class="subject-cat"><span>'.$s["eje_name"].'</span></div>
									<strong style="font-size: 15px;">'.$s["pregunta"].'</strong>
									'.($s["apoyo"]!="" ? "<img style=\"max-width:100%;\" src=\"http://admin.eduplus.enlanube.cl/render.php?temp=tests/".$s["test_id"]."/".$s["apoyo"]."\">" : "").'
									<div style="font-size: 15px;">'.$s["enunciado"].'</div>
									<blockquote style="border:0; font-size: 14px;">
									
									';
									if ($s["alternativas"] != "") {
										$json = json_decode($s["alternativas"],true);
										$range = range('A','Z');
										foreach ($json as $index=>$alt) {
											echo $range[$index].') '.$alt["txt"]."<br />";
										}
									}


									echo '
									</blockquote>
									<hr/>
									</div>
									';
									$c++;
								}
							?>
						</div>
						
						<div class="test-caluga">
						  	<div class="test-show">
						  		<a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
						  	</div>
						</div>

						<div class="test-player text-center">
						  <div id="test-pre">
						  	<br />
							<div class="row">
								<div class="col-md-12"><h3>¿Estás listo?</h3></div>
							</div>
							<div class="row">
								<div class="col-md-12"><button class="btn btn-start" type="button" id="test-start"><i class="fa fa-play-circle" aria-hidden="true"></i> Iniciar</button></div>
							</div>
							<br />
						  </div>
						  <div id="test-run" style="display:none;">
						  	<div class="test-hide">
						  		<a href="#">
						  			<i class="fa fa-angle-left" aria-hidden="true"></i>
						  		</a>
						  	</div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									Haz contestado <span id="contestado">0</span> de <span id="totalquiz">0</span> preguntas							
								</div>
							</div>

							<div class="row">
								<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
									0%
								</div>

								<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
									<div class="progress">
										<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
											<span class="sr-only">0% Complete</span>
										</div>
									</div>
								</div>

								<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
									100%
								</div>
							</div>

							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="timeleft_container">
									<div class="d-block time-left"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="timer-txt">Tienes <span id="timeleft"></span></span></div> 
									minutos para realizar este Test.
								</div>
							</div>

							<div class="row">
								<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
									<button class="btn btn-default btn-save-test" id="saveTest" type="button">
										<i class="fa fa-floppy-o" aria-hidden="true"></i><br/>
										<span>Guardar</span>
									</button>
								</div>

								<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
									<div class="row">
										<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
											<button class="btn btn-default btn-player small" type="button" onclick="start();">
												<i class="fa fa-play" aria-hidden="true"></i>
											</button>
										</div>

										<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
											<button class="btn btn-default btn-player" type="button">
												Volver a preguntas en blanco
											</button>
										</div>

										<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
											<button class="btn btn-default btn-player small" onclick="pause();" type="button">
												<i class="fa fa-pause" aria-hidden="true"></i>
											</button>
										</div>
									</div>
								</div>

								<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
									<button class="btn btn-default btn-save-test" type="button" id="end">
										<i class="fa fa-check" aria-hidden="true"></i><br/>
										<span>Terminar</span>
									</button>
								</div>								
							</div>
						  </div>

						</div>
					</div>
				</div>
				
				<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 test-side-right">
					<div class="answers-block">
						<?php
						if ($_GET["custom"]) {
						?>
						<button id="logtest" class="btn btn-primary pull-right" type="button">Log</button>
						<?php
						}
						?>
						<button id="faketest" class="btn btn-primary pull-right" type="button">Test fill</button>
						<h4>Respuestas Test "<?=$test["name"];?>"</h4>
						
						<input type="hidden" name="quiz" value="<?=$test["id"];?>" />

						<p class="blue-light">Toca sobre la letra de la respuesta correcta, desliza para ver todas las casillas del test.</p>
						<div class="answers-box2">
							<ul>
								<li></li>
								<?php
								if (count($json)==0) {
									for ($i=0;$i<$test["qty"];$i++) {
										echo '<li>'.$range[$i].'</li>';
									}
								}
								?>
							</ul>
						</div>
						<div class="answers-box" style="max-height: 60vh; overflow: auto; overflow-x: hidden;">
							<?php 
								$c=1;
								foreach ($sql as $s) {
							?>
							<ul id="answer_<?=$c;?>" data-pregid="<?=$s["id"];?>"> 
							<li><?=$c;?></li>
							<?php
							if ($s["alternativas"] != "") {
								$json = json_decode($s["alternativas"],true);
								$range = range('A','Z');
								foreach ($json as $index=>$alt) {
									echo '<li><a href="#" data-change="alt_'.$c.'" data-opt="'.$index.'">'.$range[$index].'</a></li>';
								}

								if (count($json)==0) {
									for ($i=0;$i<$test["qty"];$i++) {
										//$range[$i]
										echo '<li><a href="#" data-change="alt_'.$c.'" data-opt="'.$i.'"></a></li>';
									}
								}
							}
							?>
							<input type="hidden" name="alt[<?=$s["id"];?>]" id="alt_<?=$c;?>" value="N" />
							</ul>
							<?php
							$c++;
							}
							?>


						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>
	
</div>

<div class="all_load" style="display:none;">
	<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	<div class="text-center vertical-center">
		<i class="fa fa-4x fa-spin fa-refresh"></i>
		<br /><br />
	</div>
</div>


<?php

$alumno = new Alumno($_SESSION["id"]);
$alumno->getDrafts();
if ($alumno->drafts[$_GET["id"]]) {
	$showDraftPopup = true;	
}


} else {
?>	
	<div id="test_container">

	</div>
	<script type="text/javascript">
	$(document).ready(function() {
		$.post("ajax/alumno_test_main.php?saving=<?=$_GET["saving"];?>", {}, function(data){
			$("#test_container").html(data);
		});
	});
	</script>
<?php
} 
?>
<script type="text/javascript">
$(document).on("click",".ajax-test-materia",function(e) {
	e.preventDefault();
	var materia = $(this).attr("data-materia");
	$.post("ajax/alumno_test_main.php", {id: materia}, function(data){
		$("#test_container").html(data);
	});		
});
<?php
if ($showDraftPopup) {
?>
$("#modalDraftExists").modal("show");
$("#save_date_test").html("<?=$alumno->drafts[$_GET["id"]];?>");
<?php
}
?>

$(".answers-box>ul>li>a").click(function(e) {
	e.preventDefault();
	$(this).parent().parent().find(".answer-checked").removeClass("answer-checked");
	$(this).addClass("answer-checked");
	$(this).parent().parent().addClass("answer-checked");
	$("#contestado").html($(".answers-box>ul.answer-checked").length);

	var ok = $(".answers-box>ul.answer-checked").length;
	var largo = $(".answers-box>ul").length;
	$(".progress-bar").css("width", Math.round((ok * 100) / largo) + "%");

	var change = $(this).attr('data-change');
	var opt = $(this).attr('data-opt');

	console.log("#"+change);
	console.log(opt);
	$("#"+change).val(opt);
});

$(document).ready(function() {
	$("#totalquiz").html($(".answers-box>ul").length);

	$("#end").click(function(e) {
		e.preventDefault();
		$("#modal-end-test").modal('show');
	});

  $("#endTestConfirm").on("click", function(){
    $(".all_ok").hide();
    $(".all_load").show();
    $("#modal-end-test").modal('hide');
    setTimeout(function() {
    	$.post("ajax/action.save.test.php", $("form").serializeArray(),function(x) {
    		location.href = 'index.php?load=stats';
    		//$(".all_ok").show();
    		//$(".all_load").hide();    		
    	});
    }, 2000);
  });
  
 
  $("#test-start").click(function(e) {
  	$("#test-pre").hide();
  	$(".test-over").fadeOut();
  	start();
  	$("#test-run").show();
  });
  $(".test-hide>a").click(function(e) {
  	e.preventDefault();
  	$(".test-player").css('left', ($(".test-player").width() * -1) - 80);
  	$(".test-caluga").css('left', '-20px');
  });
  $(".test-show>a").click(function(e) {
  	e.preventDefault();
  	$(".test-player").css('left', '0px');
  	$(".test-caluga").css('left', '-80px');
  });
});


<?php if ($test["minutos"] > 0) { ?>
$("#timeleft").html("<?=$test["minutos"];?>:00");
mmm = <?=$test["minutos"];?>;
sss = 0;


function start() { 
	$("#timeleft_container").css("color","");
	countdown = setInterval(function() {

		if (parseInt(mmm) == 0 && parseInt(sss) == 0) {
			clearInterval(countdown);
		}
		else {
			if (parseInt(sss) == 0) { sss = 59; mmm = parseInt(mmm) - 1; }
			else {
				sss = parseInt(sss) - 1;
			}

			if (parseInt(sss) < 10) { sss = "0"+sss; }
			if (parseInt(mmm) < 10) { mmm = "0"+mmm; }

			$("#timeleft").html(mmm+":"+sss);
		}

	},1000);
}

function pause() {
	$("#timeleft_container").css("color","red");
	clearInterval(countdown);
}

$("#question-zone").on("scroll", function(e) {
	$(".viewport-question").each(function() {
		if ($(this).isInViewport()) {
			$(".pregunta_activa").removeClass('pregunta_activa');
			var c = $(this).attr('data-c');
			var c = parseInt(c) + 1;
			if (c <= $(".viewport-question").length) {
				var t = ($(".answers-box").scrollTop() + ($("#answer_"+c).offset().top - $(".answers-box").offset().top));
				$(".answers-box").scrollTop(t);
				$("#question_"+c).addClass("pregunta_activa");
				$("#answer_"+c).addClass("pregunta_activa");
			}
			return false;
		}
	});
});

<?php } ?>

</script>


