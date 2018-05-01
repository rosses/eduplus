<div id="pageContainerInner">
	<div id="menuHelper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<div class="search-cont">
						<div class="vcenter">
							<div class="tabcell">
								<div class="title-grade">
									<h4>Mis Cursos</h4>
									<span>
										<?=$institucionName;?>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<div class="vcenter">
						<div class="tabcell">
							<div class="grade-switch">
								<!-- Nav tabs -->
								<ul class="nav nav-pills" role="tablist">
									<li role="presentation">
										<a href="#tabGrade_1" class="clickMat" aria-controls="home" role="tab" data-toggle="tab" data-id="0">Todas</a>
									</li>
									<?php
										$trs = DB::query("SELECT tr.materia_id, m.name materia_name FROM teacher_relations tr, materia m 
														WHERE tr.teacher_id = %i AND tr.materia_id = m.id 
														GROUP BY tr.materia_id, m.name",$_SESSION["id"]);	
										// class="active"
										foreach ($trs as $tr) {
											echo '
											<li role="presentation">
												<a href="#tabGrade_1" class="clickMat" aria-controls="home" role="tab" data-toggle="tab" data-id="'.$tr["materia_id"].'">'.$tr["materia_name"].'</a>
											</li>
											';
										}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="loadingpageBody" class="text-center" style="display:none;">
		<br />
		<br />
		<i class="fa fa-4x fa-spin fa-circle-o-notch"></i>
		<br />
		<br />
		<br />
	</div>
	<div id="pageBody">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="grade-list-cont">
						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="tabGrade_1">
								<div class="grade-itemlist text-center">
									<ul id="grade-itemlist">
										<script type="text/javascript">
											$(document).ready(function() {
												$(".clickMat").first().click()
											});
										</script>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>		
</div>
