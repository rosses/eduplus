<?php
require("../../api.eduplus.enlanube.cl/sql.php");
sleep(1);
if ($_POST["materia"]!=0) {
	$trs_q = "SELECT tr.*, 
	        c.name course_name, 
	        m.name materia_name, 
	        IFNULL((SELECT  AVG(tp.points)
	        FROM 	test_end_head tp, 
	                user_relations ur, 
	                course c1, 
	                user u 
	        WHERE  tp.materia = m.id AND 
	                tp.user_id = u.id AND 
	                ur.user_id = u.id AND 
	                ur.course_id = c1.id AND 
	                c1.id = c.id AND 
	                ur.course_id = c.id AND 
	                tp.test_id = (SELECT MAX(x1.id) FROM test x1 WHERE EXISTS(SELECT * FROM test_end_head x2 WHERE x2.test_id = x1.id AND x2.user_id = u.id) ORDER BY x1.id DESC LIMIT 1) AND 
	                tp.points > 0 AND 
	                tp.isLast = 1
	        ),0) puntosPromedio  
	FROM  teacher_relations tr, 
	       course c, 
	       materia m 
	WHERE tr.teacher_id = %i AND 
	      tr.course_id = c.id AND 
	      tr.materia_id = m.id AND 
	      m.id = %i
	";

	$trs = DB::query($trs_q,$_SESSION["id"],$_POST["materia"]);	

}
else {

	$trs_q = "SELECT tr.*, 
	        c.name course_name, 
	        m.name materia_name, 
	        IFNULL((SELECT  AVG(tp.points)
	        FROM 	test_end_head tp, 
	                user_relations ur, 
	                course c1, 
	                user u 
	        WHERE  tp.materia = m.id AND 
	                tp.user_id = u.id AND 
	                ur.user_id = u.id AND 
	                ur.course_id = c1.id AND 
	                c1.id = c.id AND 
	                ur.course_id = c.id AND 
	                tp.test_id = (SELECT MAX(x1.id) FROM test x1 WHERE EXISTS(SELECT * FROM test_end_head x2 WHERE x2.test_id = x1.id AND x2.user_id = u.id) ORDER BY x1.id DESC LIMIT 1) AND 
	                tp.points > 0 AND 
	                tp.isLast = 1   
	        ),0) puntosPromedio  
	FROM  teacher_relations tr, 
	       course c, 
	       materia m 
	WHERE tr.teacher_id = %i AND 
	      tr.course_id = c.id AND 
	      tr.materia_id = m.id 
	";

	$trs = DB::query($trs_q,$_SESSION["id"]);	

}

foreach ($trs as $tr) {

	// avance
	if ($tr["goal"]==0) { $tr["goal"] = 1; }
	echo '
	<li class="cursoJoin" data-course="'.$tr["course_id"].'" data-materia="'.$tr["materia_id"].'">
		<div class="grade-item text-center">
			<div class="thumb">
				<div class="vcenter">
					<div class="tabcell">
						'.$tr["course_name"].'
					</div>
				</div>

				<!--<div class="grade-letter">
					<div class="vcenter">
						<div class="tabcell">
							??
						</div>
					</div>
				</div>
				-->
			</div>

			<div class="info">
				<h4>'.$tr["materia_name"].'</h4>

				<span>
					Promedio general
				</span>
			</div>

			<div class="data">
				<div class="row data_r1">
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-left">
						0
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
						'.round($tr["puntosPromedio"],0).'
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
						'.$tr["goal"].'
					</div>
				</div>
		
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="'.round($tr["puntosPromedio"] * 100 / $tr["goal"]).'" aria-valuemin="0" aria-valuemax="100" style="width: '.round($tr["puntosPromedio"] * 100 / $tr["goal"]).'%;">
								<span class="sr-only">'.round($tr["puntosPromedio"] * 100 / $tr["goal"]).'% Complete</span>
							</div>
						</div>
					</div>
				</div>

				<div class="row data_r2">
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-left">
						Actual
					</div>

					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
						'.round($tr["puntosPromedio"] * 100 / $tr["goal"]).'%
					</div>

					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
						Meta
					</div>
				</div>
			</div>
		</div>
	</li>
	';
}

?>
