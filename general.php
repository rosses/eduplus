<div id="pageContainerInner" class="blue-page-bg">
	<div id="menuHelper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
					<a href="#" class="logo-helper">
						<img src="images/logo-helper.png" alt="">
					</a>
				</div>
				
				<!--
				<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
					<div class="helper-grade" id="course_name">
						4
						<span>B</span>
					</div>
				</div>
				-->
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<div class="search-cont">
						<div class="vcenter">
							<div class="tabcell">
								<select class="form-control inp-school-b" id="estaDetalleCurso">
									<?php
									$trs = DB::query("SELECT c.id course_id, c.name course_name
													  FROM teacher_relations tr, course c
													  WHERE tr.teacher_id = %i AND tr.course_id = c.id GROUP BY c.id, c.name ORDER BY c.id ASC",$_SESSION["id"]);
									foreach ($trs as $tr) {
										echo "<option value='".$tr["course_id"]."'>".$tr["course_name"]."</option>";
									}
									?>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<div class="search-cont">
						<div class="vcenter">
							<div class="tabcell">
								<select class="form-control inp-school-b" id="estaDetalleMateria">
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<div class="form-group">
		                <label for="dtp_input2" class="col-md-2 control-label">Desde</label>
		               
		                <div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
		                    <input class="form-control inp-school" size="16" type="text"  value="<?=date("d/m/2017");?>" readonly>
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
		                </div>

						<input type="hidden" id="dtp_input2" value="" /><br/>
		            </div>
				</div>

				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<div class="form-group">
		                <label for="dtp_input2" class="col-md-2 control-label">Hasta</label>
		               
		                <div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
		                    <input class="form-control inp-school" size="16" type="text" value="<?=date("d/m/Y");?>"  readonly>
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
		                </div>

						<input type="hidden" id="dtp_input2" value="" /><br/>
		            </div>
				</div>
				<!--
				<div class="col-xs-12 col-sm-1 col-sm-offset-3 col-md-1 col-md-offset-3 col-lg-1 col-lg-offset-3">
					<img src="images/progress-circle_01.png" width="100%;" alt="">
				</div>
				-->
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
	
	<div id="pageBody" style="">

	</div>
	<div id="pageBodyXX" style="display:none">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="report-cont">
						<div class="head-report-tab">
							<div class="row">
								<div class="col-xs-12 col-sm-3 col-md-3 col-xlg-3">
									<h3>
										Test cursados
									</h3>
								</div>

								<div class="col-xs-12 col-sm-9 col-md-9 col-xlg-9">
									<!-- Nav tabs -->
									<ul class="nav nav-pills" role="tablist">
										<li role="presentation" class="active">
											<a href="#T1" aria-controls="T1" role="tab" data-toggle="tab">T1</a>
										</li>

										<li role="presentation">
											<a href="#T2" aria-controls="T2" role="tab" data-toggle="tab">T2</a>
										</li>

										<li role="presentation">
											<a href="#T3" aria-controls="T3" role="tab" data-toggle="tab">T3</a>
										</li>

										<li role="presentation">
											<a href="#T4" aria-controls="T4" role="tab" data-toggle="tab">T4</a>
										</li>

										<li role="presentation">
											<a href="#T5" aria-controls="T5" role="tab" data-toggle="tab">T5</a>
										</li>

										<li role="presentation">
											<a href="#T6" aria-controls="T6" role="tab" data-toggle="tab">T6</a>
										</li>

										<li role="presentation">
											<a href="#T7" aria-controls="T7" role="tab" data-toggle="tab">T7</a>
										</li>
									</ul>
								</div>
							</div>
						</div>

						<div class="body-report">
							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="T1">
									<div class="module-row">
										<div class="row">
											<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
												<div class="module-row">
													<div class="white-box no-pad">
														<div class="whitebox-row box-title">
															<div class="row">
																<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 title-module-b">
																	<h4>Evoluci&oacute;n del a&ntilde;o </h4>
																	<p>
																		9 Octubre 2017
																	</p>
																</div>

																<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">

																</div>
															</div>
														</div>

														<img src="images/graph_1.png" width="100%;" alt="">
													</div>
												</div>
												
												<div class="module-row">
													<div class="row">
														<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
															<div class="white-box no-pad">
																<div class="whitebox-row box-title">
																	<div class="row">
																		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 title-module-b">
																			<h4>Evoluci&oacute;n del a&ntilde;o </h4>
																			<p>
																				9 Octubre 2017
																			</p>
																		</div>

																		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
																			Test 6
																		</div>
																	</div>
																</div>

																<div class="graph-row">
																	<img src="images/graph_2.png" width="100%" alt="">
																</div>
															</div>
														</div>

														<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
															<div class="white-box no-pad">
																<div class="whitebox-row box-title">
																	<div class="row">
																		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 title-module-b">
																			<h4>Evoluci&oacute;n del a&ntilde;o </h4>
																			<p>
																				9 Octubre 2017
																			</p>
																		</div>

																		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
																			Test 6
																		</div>
																	</div>
																</div>

																<div class="graph-row text-center">
																	<img src="images/graph_3.png" width="220" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
												<div class="module-row">
													<div class="white-box">
														<div class="module-row">
															<div class="general-progress">
																<p>
																	Promedio General
																</p>

																<div class="progress-box">
																	<div class="row">
																		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																			680
																		</div>

																		<div class="col-xs-4 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4 text-right">
																			780
																		</div>
																	</div>

																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																			<div class="progress">
																				<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
																					<span class="sr-only">60% Complete</span>
																				</div>
																			</div>
																		</div>
																	</div>

																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																			Actual  /  Meta
																		</div>
																	</div>
																</div>
															</div>
														</div>

														<hr/>

														<div class="subjects-inforow no-pad">
															<div class="row">
																<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
																	<span>Cantidad de evaluaciones</span>
																</div>

																<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
																	<span>73</span>
																</div>
															</div>

															<div class="row">
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 blue-light">
																	<span>Turn on to share your file changes and updates</span>
																</div>
															</div>
														</div>
														
														<div class="resume-pts">
															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		Promedio
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		680pts
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		Casos sobre la media 
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		49
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		Casos bajo la media 
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		24
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		M&aacute;ximo
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		825pts
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		M&iacute;nimo
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		456pts
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		Desviasión est&aacute;ndar
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		70pts
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												
												<div class="module-row">
													<div class="white-box">
														<div class="module-row">
															<div class="row">
																<div class="col-xs-12 col-sm-3 col-sm-offset-9 col-md-3 col-md-offset-9 col-lg-3 col-lg-offset-9">
																	Test 6
																</div>
																<div class="basic-row">
																	<img src="images/graph_5.png" width="100%" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="module-row">
										<div id="reportTabPanel">
											<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
												<div class="panel panel-default">
													<div class="panel-heading" role="tab" id="headingOne">
														<h4 class="panel-title">
															<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
																Detalle test 6 <i class="fa fa-caret-down" aria-hidden="true"></i>
															</a>
														</h4>
													</div>

													<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
														<div class="white-box no-pad">
															<div class="panel-body table">
																<div class="table-responsive text-center">
																	<table class="table table-striped table-condensed">
																		<thead>
																			<tr>
																				<th class="text-center">Pregunta</th>

																				<th class="text-center">% Correcta</th>

																				<th class="text-center">% Incorrecta</th>

																				<th class="text-center">% En blanco</th>

																				<th class="text-center">A</th>

																				<th class="text-center">B</th>

																				<th class="text-center">C</th>

																				<th class="text-center">E</th>

																				<th class="text-center">En blanco</th>
																			</tr>
																		</thead>

																		<tr>
																			<td>1</td>

																			<td>80%</td>

																			<td>18%</td>

																			<td>2%</td>

																			<td>
																				<span>1</span>
																			</td>

																			<td>
																				<span>3</span>
																			</td>

																			<td>
																				<span>0</span>
																			</td>

																			<td>
																				<span class="active">67</span>
																			</td>

																			<td>1</td>
																		</tr>

																		<tr>
																			<td>1</td>

																			<td>80%</td>

																			<td>18%</td>

																			<td>2%</td>

																			<td>
																				<span>1</span>
																			</td>

																			<td>
																				<span>3</span>
																			</td>

																			<td>
																				<span class="active">0</span>
																			</td>

																			<td>
																				<span>67</span>
																			</td>

																			<td>1</td>
																		</tr>

																		<tr>
																			<td>1</td>

																			<td>80%</td>

																			<td>18%</td>

																			<td>2%</td>

																			<td>
																				<span>1</span>
																			</td>

																			<td>
																				<span class="active">3</span>
																			</td>

																			<td>
																				<span>0</span>
																			</td>

																			<td>
																				<span>67</span>
																			</td>

																			<td>1</td>
																		</tr>
																	</table>
																</div>

																<div class="row">
																	<div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
																		<button class="btn btn-default btn-img more">
																			<span>Ver m&aacute;s resultados</span><br/>
																			<i class="fa fa-plus-circle" aria-hidden="true"></i>
																		</button>
																	</div>
																</div>
																
															</div>
														</div>
														
													</div>
												</div>

												<div class="panel panel-default">
													<div class="panel-heading" role="tab" id="headingTwo">
														<h4 class="panel-title">
															<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
															Detalle por ejes tem&aacute;ticos <i class="fa fa-caret-down" aria-hidden="true"></i>
															</a>
														</h4>
													</div>

													<div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
														<div class="panel-body no-pad">
															<div class="row">
																<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
																	<div class="white-box">
																		<div class="module-row title-module">
																			<h4>
																				&Aacute;lgebra
																			</h4>
																		</div>

																		<div class="module-row">
																			<div class="row status-row">
																				<div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
																					<div class="icon-status">
																						<img src="images/icon-check-on.png" width="100%" alt="">
																					</div>

																					<div class="percent-box">
																						<i class="fa fa-long-arrow-up" aria-hidden="true"></i> 80%
																						<span>
																							23
																						</span>
																					</div>
																				</div>
																			</div>

																			<div class="row status-row">
																				<div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
																					<div class="icon-status">
																						<img src="images/icon-check-on.png" width="100%" alt="">
																					</div>

																					<div class="percent-box">
																						<i class="fa fa-long-arrow-up" aria-hidden="true"></i> 80%
																						<span>
																							23
																						</span>
																					</div>
																				</div>
																			</div>

																			<div class="row status-row">
																				<div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
																					<div class="icon-status">
																						<img src="images/icon-check-on.png" width="100%" alt="">
																					</div>

																					<div class="percent-box">
																						<i class="fa fa-long-arrow-down" aria-hidden="true"></i> 80%
																						<span>
																							23
																						</span>
																					</div>
																				</div>
																			</div>
																		</div>

																		<div class="module-row">
																			<div class="row text-center">
																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
																					<button class="btn btn-default btn-line">
																						Geometr&iacute;a
																					</button>
																				</div>

																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
																					<button class="btn btn-default btn-line">
																						N&uacute;meros
																					</button>
																				</div>

																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
																					<button class="btn btn-default btn-line">
																						Medici&oacute;n
																					</button>
																				</div>
																			</div>
																		</div>

																		<div class="module-row">
																			<div class="row">
																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
																					<div class="status-icontxt">
																						<img src="images/icon-check-on.png" alt="">
																						<span>Correctas</span>
																					</div>
																				</div>

																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
																					<div class="status-icontxt">
																						<img src="images/icon-x_gray.png" alt="">
																						<span>Correctas</span>
																					</div>
																				</div>

																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
																					<div class="status-icontxt">
																						<img src="images/icon-dot_red.png" alt="">
																						<span>Correctas</span>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>

																<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
																	<div class="white-box">
																		<div class="module-row">
																			<div class="row">
																				<div class="col-xs-10 col-sm-10 col-xmds-10 col-lg-10 title-module">
																					<h4>
																						Segmentaci&oacute;n por puntaje
																					</h4>
																				</div>
																			</div>
																		</div>

																		<div class="module-row">
																			<div class="row segm-title">
																				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																					<h5>Álgebra</h5>
																					<p>Sobre el 80% <i class="fa fa-long-arrow-up" aria-hidden="true"></i></p>
																				</div>

																				<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
																					<img src="images/icon-check-on.png" width="30px" alt="">
																				</div>
																			</div>
																		</div>

																		<div class="module-row">
																			<div class="row">
																				<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
																					<div id="carousel-segm-student" class="carousel slide" data-ride="carousel">
																						<!-- Indicators -->
																						<ol class="carousel-indicators">
																							<li data-target="#carousel-segm-student" data-slide-to="0" class="active"></li>

																							<li data-target="#carousel-segm-student" data-slide-to="1"></li>
																						</ol>

																						<!-- Wrapper for slides -->
																						<div class="carousel-inner" role="listbox">
																							<div class="item active">
																								<div class="student-list">
																									<ul>
																										<li>
																											<div class="row">
																												<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																													<div class="data">
																														<div class="thumb-pic img-circle">
																															<img src="images/profile-pic.png" alt="">
																														</div>

																														<span>Martin silva v</span>
																													</div>
																												</div>

																												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																													<div class="data blue-light">
																														<span>90%</span>
																													</div>
																												</div>
																											</div>
																										</li>

																										<li>
																											<div class="row">
																												<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																													<div class="data">
																														<div class="thumb-pic img-circle">
																															<img src="images/profile-pic.png" alt="">
																														</div>

																														<span>Martin silva v</span>
																													</div>
																												</div>

																												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																													<div class="data blue-light">
																														<span>90%</span>
																													</div>
																												</div>
																											</div>
																										</li>
																									</ul>
																								</div>
																							</div>

																							<div class="item">
																								<div class="student-list">
																									<ul>
																										<li>
																											<div class="row">
																												<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																													<div class="data">
																														<div class="thumb-pic img-circle">
																															<img src="images/profile-pic.png" alt="">
																														</div>

																														<span>Martin silva v</span>
																													</div>
																												</div>

																												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																													<div class="data blue-light">
																														<span>90%</span>
																													</div>
																												</div>
																											</div>
																										</li>

																										<li>
																											<div class="row">
																												<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																													<div class="data">
																														<div class="thumb-pic img-circle">
																															<img src="images/profile-pic.png" alt="">
																														</div>

																														<span>Martin silva v</span>
																													</div>
																												</div>

																												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																													<div class="data blue-light">
																														<span>90%</span>
																													</div>
																												</div>
																											</div>
																										</li>
																									</ul>
																								</div>
																							</div>
																						</div>

																						<!-- Controls -->
																						<!-- <a class="left carousel-control" href="#carousel-segm-student" role="button" data-slide="prev">
																						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
																						<span class="sr-only">Previous</span>
																						</a>
																						<a class="right carousel-control" href="#carousel-segm-student" role="button" data-slide="next">
																						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
																						<span class="sr-only">Next</span>
																						</a> -->
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>

											</div>
										</div>
										
									</div>
								</div>

								<div role="tabpanel" class="tab-pane" id="T2">
									<div class="module-row">
										<div class="row">
											<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
												<div class="module-row">
													<div class="white-box no-pad">
														<div class="whitebox-row box-title">
															<div class="row">
																<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 title-module-b">
																	<h4>Evoluci&oacute;n del a&ntilde;o </h4>
																	<p>
																		9 Octubre 2017
																	</p>
																</div>

																<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">

																</div>
															</div>
														</div>

														<img src="images/graph_1.png" width="100%;" alt="">
													</div>
												</div>
												
												<div class="module-row">
													<div class="row">
														<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
															<div class="white-box no-pad">
																<div class="whitebox-row box-title">
																	<div class="row">
																		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 title-module-b">
																			<h4>Evoluci&oacute;n del a&ntilde;o </h4>
																			<p>
																				9 Octubre 2017
																			</p>
																		</div>

																		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
																			Test 6
																		</div>
																	</div>
																</div>

																<div class="graph-row">
																	<img src="images/graph_2.png" width="100%" alt="">
																</div>
															</div>
														</div>

														<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
															<div class="white-box no-pad">
																<div class="whitebox-row box-title">
																	<div class="row">
																		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 title-module-b">
																			<h4>Evoluci&oacute;n del a&ntilde;o </h4>
																			<p>
																				9 Octubre 2017
																			</p>
																		</div>

																		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
																			Test 6
																		</div>
																	</div>
																</div>

																<div class="graph-row text-center">
																	<img src="images/graph_3.png" width="220" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
												<div class="module-row">
													<div class="white-box">
														<div class="module-row">
															<div class="general-progress">
																<p>
																	Promedio General
																</p>

																<div class="progress-box">
																	<div class="row">
																		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																			680
																		</div>

																		<div class="col-xs-4 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4 text-right">
																			780
																		</div>
																	</div>

																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																			<div class="progress">
																				<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
																					<span class="sr-only">60% Complete</span>
																				</div>
																			</div>
																		</div>
																	</div>

																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																			Actual  /  Meta
																		</div>
																	</div>
																</div>
															</div>
														</div>

														<hr/>

														<div class="subjects-inforow no-pad">
															<div class="row">
																<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
																	<span>Cantidad de evaluaciones</span>
																</div>

																<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
																	<span>73</span>
																</div>
															</div>

															<div class="row">
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 blue-light">
																	<span>Turn on to share your file changes and updates</span>
																</div>
															</div>
														</div>
														
														<div class="resume-pts">
															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		Promedio
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		680pts
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		Casos sobre la media 
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		49
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		Casos bajo la media 
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		24
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		M&aacute;ximo
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		825pts
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		M&iacute;nimo
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		456pts
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		Desviasión est&aacute;ndar
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		70pts
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												
												<div class="module-row">
													<div class="white-box">
														1
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="module-row">
										<div id="reportTabPanel">
											<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
												<div class="panel panel-default">
													<div class="panel-heading" role="tab" id="headingOne">
														<h4 class="panel-title">
															<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
																Detalle test 6 <i class="fa fa-caret-down" aria-hidden="true"></i>
															</a>
														</h4>
													</div>

													<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
														<div class="white-box no-pad">
															<div class="panel-body table">
																<div class="table-responsive text-center">
																	<table class="table table-striped table-condensed">
																		<thead>
																			<tr>
																				<th class="text-center">Pregunta</th>

																				<th class="text-center">% Correcta</th>

																				<th class="text-center">% Incorrecta</th>

																				<th class="text-center">% En blanco</th>

																				<th class="text-center">A</th>

																				<th class="text-center">B</th>

																				<th class="text-center">C</th>

																				<th class="text-center">E</th>

																				<th class="text-center">En blanco</th>
																			</tr>
																		</thead>

																		<tr>
																			<td>1</td>

																			<td>80%</td>

																			<td>18%</td>

																			<td>2%</td>

																			<td>
																				<span>1</span>
																			</td>

																			<td>
																				<span>3</span>
																			</td>

																			<td>
																				<span>0</span>
																			</td>

																			<td>
																				<span class="active">67</span>
																			</td>

																			<td>1</td>
																		</tr>

																		<tr>
																			<td>1</td>

																			<td>80%</td>

																			<td>18%</td>

																			<td>2%</td>

																			<td>
																				<span>1</span>
																			</td>

																			<td>
																				<span>3</span>
																			</td>

																			<td>
																				<span class="active">0</span>
																			</td>

																			<td>
																				<span>67</span>
																			</td>

																			<td>1</td>
																		</tr>

																		<tr>
																			<td>1</td>

																			<td>80%</td>

																			<td>18%</td>

																			<td>2%</td>

																			<td>
																				<span>1</span>
																			</td>

																			<td>
																				<span class="active">3</span>
																			</td>

																			<td>
																				<span>0</span>
																			</td>

																			<td>
																				<span>67</span>
																			</td>

																			<td>1</td>
																		</tr>
																	</table>
																</div>

																<div class="row">
																	<div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
																		<button class="btn btn-default btn-img more">
																			<span>Ver m&aacute;s resultados</span><br/>
																			<i class="fa fa-plus-circle" aria-hidden="true"></i>
																		</button>
																	</div>
																</div>
																
															</div>
														</div>
														
													</div>
												</div>

												<div class="panel panel-default">
													<div class="panel-heading" role="tab" id="headingTwo">
														<h4 class="panel-title">
															<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
															Detalle por ejes tem&aacute;ticos <i class="fa fa-caret-down" aria-hidden="true"></i>
															</a>
														</h4>
													</div>

													<div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
														<div class="panel-body no-pad">
															<div class="row">
																<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
																	<div class="white-box">
																		<div class="module-row title-module">
																			<h4>
																				&Aacute;lgebra
																			</h4>
																		</div>

																		<div class="module-row">
																			<div class="row status-row">
																				<div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
																					<div class="icon-status">
																						<img src="images/icon-check-on.png" width="100%" alt="">
																					</div>

																					<div class="percent-box">
																						<i class="fa fa-long-arrow-up" aria-hidden="true"></i> 80%
																						<span>
																							23
																						</span>
																					</div>
																				</div>
																			</div>

																			<div class="row status-row">
																				<div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
																					<div class="icon-status">
																						<img src="images/icon-check-on.png" width="100%" alt="">
																					</div>

																					<div class="percent-box">
																						<i class="fa fa-long-arrow-up" aria-hidden="true"></i> 80%
																						<span>
																							23
																						</span>
																					</div>
																				</div>
																			</div>

																			<div class="row status-row">
																				<div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
																					<div class="icon-status">
																						<img src="images/icon-check-on.png" width="100%" alt="">
																					</div>

																					<div class="percent-box">
																						<i class="fa fa-long-arrow-down" aria-hidden="true"></i> 80%
																						<span>
																							23
																						</span>
																					</div>
																				</div>
																			</div>
																		</div>

																		<div class="module-row">
																			<div class="row text-center">
																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
																					<button class="btn btn-default btn-line">
																						Geometr&iacute;a
																					</button>
																				</div>

																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
																					<button class="btn btn-default btn-line">
																						N&uacute;meros
																					</button>
																				</div>

																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
																					<button class="btn btn-default btn-line">
																						Medici&oacute;n
																					</button>
																				</div>
																			</div>
																		</div>

																		<div class="module-row">
																			<div class="row">
																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
																					<div class="status-icontxt">
																						<img src="images/icon-check-on.png" alt="">
																						<span>Correctas</span>
																					</div>
																				</div>

																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
																					<div class="status-icontxt">
																						<img src="images/icon-x_gray.png" alt="">
																						<span>Correctas</span>
																					</div>
																				</div>

																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
																					<div class="status-icontxt">
																						<img src="images/icon-dot_red.png" alt="">
																						<span>Correctas</span>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>

																<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
																	<div class="white-box">
																		<div class="module-row">
																			<div class="row">
																				<div class="col-xs-10 col-sm-10 col-xmds-10 col-lg-10 title-module">
																					<h4>
																						Segmentaci&oacute;n por puntaje
																					</h4>
																				</div>
																			</div>
																		</div>

																		<div class="module-row">
																			<div class="row segm-title">
																				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																					<h5>Álgebra</h5>
																					<p>Sobre el 80% <i class="fa fa-long-arrow-up" aria-hidden="true"></i></p>
																				</div>

																				<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
																					<img src="images/icon-check-on.png" width="30px" alt="">
																				</div>
																			</div>
																		</div>

																		<div class="module-row">
																			<div class="row">
																				<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
																					<div id="carousel-segm-student" class="carousel slide" data-ride="carousel">
																						<!-- Indicators -->
																						<ol class="carousel-indicators">
																							<li data-target="#carousel-segm-student" data-slide-to="0" class="active"></li>

																							<li data-target="#carousel-segm-student" data-slide-to="1"></li>
																						</ol>

																						<!-- Wrapper for slides -->
																						<div class="carousel-inner" role="listbox">
																							<div class="item active">
																								<div class="student-list">
																									<ul>
																										<li>
																											<div class="row">
																												<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																													<div class="data">
																														<div class="thumb-pic img-circle">
																															<img src="images/profile-pic.png" alt="">
																														</div>

																														<span>Martin silva v</span>
																													</div>
																												</div>

																												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																													<div class="data blue-light">
																														<span>90%</span>
																													</div>
																												</div>
																											</div>
																										</li>

																										<li>
																											<div class="row">
																												<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																													<div class="data">
																														<div class="thumb-pic img-circle">
																															<img src="images/profile-pic.png" alt="">
																														</div>

																														<span>Martin silva v</span>
																													</div>
																												</div>

																												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																													<div class="data blue-light">
																														<span>90%</span>
																													</div>
																												</div>
																											</div>
																										</li>
																									</ul>
																								</div>
																							</div>

																							<div class="item">
																								<div class="student-list">
																									<ul>
																										<li>
																											<div class="row">
																												<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																													<div class="data">
																														<div class="thumb-pic img-circle">
																															<img src="images/profile-pic.png" alt="">
																														</div>

																														<span>Martin silva v</span>
																													</div>
																												</div>

																												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																													<div class="data blue-light">
																														<span>90%</span>
																													</div>
																												</div>
																											</div>
																										</li>

																										<li>
																											<div class="row">
																												<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																													<div class="data">
																														<div class="thumb-pic img-circle">
																															<img src="images/profile-pic.png" alt="">
																														</div>

																														<span>Martin silva v</span>
																													</div>
																												</div>

																												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																													<div class="data blue-light">
																														<span>90%</span>
																													</div>
																												</div>
																											</div>
																										</li>
																									</ul>
																								</div>
																							</div>
																						</div>

																						<!-- Controls -->
																						<!-- <a class="left carousel-control" href="#carousel-segm-student" role="button" data-slide="prev">
																						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
																						<span class="sr-only">Previous</span>
																						</a>
																						<a class="right carousel-control" href="#carousel-segm-student" role="button" data-slide="next">
																						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
																						<span class="sr-only">Next</span>
																						</a> -->
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>

											</div>
										</div>
										
									</div>
								</div>

								<div role="tabpanel" class="tab-pane" id="T3">
									<div class="module-row">
										<div class="row">
											<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
												<div class="module-row">
													<div class="white-box no-pad">
														<div class="whitebox-row box-title">
															<div class="row">
																<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 title-module-b">
																	<h4>Evoluci&oacute;n del a&ntilde;o </h4>
																	<p>
																		9 Octubre 2017
																	</p>
																</div>

																<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">

																</div>
															</div>
														</div>

														<img src="images/graph_1.png" width="100%;" alt="">
													</div>
												</div>
												
												<div class="module-row">
													<div class="row">
														<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
															<div class="white-box no-pad">
																<div class="whitebox-row box-title">
																	<div class="row">
																		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 title-module-b">
																			<h4>Evoluci&oacute;n del a&ntilde;o </h4>
																			<p>
																				9 Octubre 2017
																			</p>
																		</div>

																		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
																			Test 6
																		</div>
																	</div>
																</div>

																<div class="graph-row">
																	<img src="images/graph_2.png" width="100%" alt="">
																</div>
															</div>
														</div>

														<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
															<div class="white-box no-pad">
																<div class="whitebox-row box-title">
																	<div class="row">
																		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 title-module-b">
																			<h4>Evoluci&oacute;n del a&ntilde;o </h4>
																			<p>
																				9 Octubre 2017
																			</p>
																		</div>

																		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
																			Test 6
																		</div>
																	</div>
																</div>

																<div class="graph-row text-center">
																	<img src="images/graph_3.png" width="220" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
												<div class="module-row">
													<div class="white-box">
														<div class="module-row">
															<div class="general-progress">
																<p>
																	Promedio General
																</p>

																<div class="progress-box">
																	<div class="row">
																		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																			680
																		</div>

																		<div class="col-xs-4 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4 text-right">
																			780
																		</div>
																	</div>

																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																			<div class="progress">
																				<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
																					<span class="sr-only">60% Complete</span>
																				</div>
																			</div>
																		</div>
																	</div>

																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																			Actual  /  Meta
																		</div>
																	</div>
																</div>
															</div>
														</div>

														<hr/>

														<div class="subjects-inforow no-pad">
															<div class="row">
																<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
																	<span>Cantidad de evaluaciones</span>
																</div>

																<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
																	<span>73</span>
																</div>
															</div>

															<div class="row">
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 blue-light">
																	<span>Turn on to share your file changes and updates</span>
																</div>
															</div>
														</div>
														
														<div class="resume-pts">
															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		Promedio
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		680pts
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		Casos sobre la media 
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		49
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		Casos bajo la media 
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		24
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		M&aacute;ximo
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		825pts
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		M&iacute;nimo
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		456pts
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		Desviasión est&aacute;ndar
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		70pts
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												
												<div class="module-row">
													<div class="white-box">
														1
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="module-row">
										<div id="reportTabPanel">
											<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
												<div class="panel panel-default">
													<div class="panel-heading" role="tab" id="headingOne">
														<h4 class="panel-title">
															<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
																Detalle test 6 <i class="fa fa-caret-down" aria-hidden="true"></i>
															</a>
														</h4>
													</div>

													<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
														<div class="white-box no-pad">
															<div class="panel-body table">
																<div class="table-responsive text-center">
																	<table class="table table-striped table-condensed">
																		<thead>
																			<tr>
																				<th class="text-center">Pregunta</th>

																				<th class="text-center">% Correcta</th>

																				<th class="text-center">% Incorrecta</th>

																				<th class="text-center">% En blanco</th>

																				<th class="text-center">A</th>

																				<th class="text-center">B</th>

																				<th class="text-center">C</th>

																				<th class="text-center">E</th>

																				<th class="text-center">En blanco</th>
																			</tr>
																		</thead>

																		<tr>
																			<td>1</td>

																			<td>80%</td>

																			<td>18%</td>

																			<td>2%</td>

																			<td>
																				<span>1</span>
																			</td>

																			<td>
																				<span>3</span>
																			</td>

																			<td>
																				<span>0</span>
																			</td>

																			<td>
																				<span class="active">67</span>
																			</td>

																			<td>1</td>
																		</tr>

																		<tr>
																			<td>1</td>

																			<td>80%</td>

																			<td>18%</td>

																			<td>2%</td>

																			<td>
																				<span>1</span>
																			</td>

																			<td>
																				<span>3</span>
																			</td>

																			<td>
																				<span class="active">0</span>
																			</td>

																			<td>
																				<span>67</span>
																			</td>

																			<td>1</td>
																		</tr>

																		<tr>
																			<td>1</td>

																			<td>80%</td>

																			<td>18%</td>

																			<td>2%</td>

																			<td>
																				<span>1</span>
																			</td>

																			<td>
																				<span class="active">3</span>
																			</td>

																			<td>
																				<span>0</span>
																			</td>

																			<td>
																				<span>67</span>
																			</td>

																			<td>1</td>
																		</tr>
																	</table>
																</div>

																<div class="row">
																	<div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
																		<button class="btn btn-default btn-img more">
																			<span>Ver m&aacute;s resultados</span><br/>
																			<i class="fa fa-plus-circle" aria-hidden="true"></i>
																		</button>
																	</div>
																</div>
																
															</div>
														</div>
														
													</div>
												</div>

												<div class="panel panel-default">
													<div class="panel-heading" role="tab" id="headingTwo">
														<h4 class="panel-title">
															<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
															Detalle por ejes tem&aacute;ticos <i class="fa fa-caret-down" aria-hidden="true"></i>
															</a>
														</h4>
													</div>

													<div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
														<div class="panel-body no-pad">
															<div class="row">
																<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
																	<div class="white-box">
																		<div class="module-row title-module">
																			<h4>
																				&Aacute;lgebra
																			</h4>
																		</div>

																		<div class="module-row">
																			<div class="row status-row">
																				<div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
																					<div class="icon-status">
																						<img src="images/icon-check-on.png" width="100%" alt="">
																					</div>

																					<div class="percent-box">
																						<i class="fa fa-long-arrow-up" aria-hidden="true"></i> 80%
																						<span>
																							23
																						</span>
																					</div>
																				</div>
																			</div>

																			<div class="row status-row">
																				<div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
																					<div class="icon-status">
																						<img src="images/icon-check-on.png" width="100%" alt="">
																					</div>

																					<div class="percent-box">
																						<i class="fa fa-long-arrow-up" aria-hidden="true"></i> 80%
																						<span>
																							23
																						</span>
																					</div>
																				</div>
																			</div>

																			<div class="row status-row">
																				<div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
																					<div class="icon-status">
																						<img src="images/icon-check-on.png" width="100%" alt="">
																					</div>

																					<div class="percent-box">
																						<i class="fa fa-long-arrow-down" aria-hidden="true"></i> 80%
																						<span>
																							23
																						</span>
																					</div>
																				</div>
																			</div>
																		</div>

																		<div class="module-row">
																			<div class="row text-center">
																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
																					<button class="btn btn-default btn-line">
																						Geometr&iacute;a
																					</button>
																				</div>

																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
																					<button class="btn btn-default btn-line">
																						N&uacute;meros
																					</button>
																				</div>

																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
																					<button class="btn btn-default btn-line">
																						Medici&oacute;n
																					</button>
																				</div>
																			</div>
																		</div>

																		<div class="module-row">
																			<div class="row">
																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
																					<div class="status-icontxt">
																						<img src="images/icon-check-on.png" alt="">
																						<span>Correctas</span>
																					</div>
																				</div>

																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
																					<div class="status-icontxt">
																						<img src="images/icon-x_gray.png" alt="">
																						<span>Correctas</span>
																					</div>
																				</div>

																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
																					<div class="status-icontxt">
																						<img src="images/icon-dot_red.png" alt="">
																						<span>Correctas</span>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>

																<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
																	<div class="white-box">
																		<div class="module-row">
																			<div class="row">
																				<div class="col-xs-10 col-sm-10 col-xmds-10 col-lg-10 title-module">
																					<h4>
																						Segmentaci&oacute;n por puntaje
																					</h4>
																				</div>
																			</div>
																		</div>

																		<div class="module-row">
																			<div class="row segm-title">
																				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																					<h5>Álgebra</h5>
																					<p>Sobre el 80% <i class="fa fa-long-arrow-up" aria-hidden="true"></i></p>
																				</div>

																				<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
																					<img src="images/icon-check-on.png" width="30px" alt="">
																				</div>
																			</div>
																		</div>

																		<div class="module-row">
																			<div class="row">
																				<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
																					<div id="carousel-segm-student" class="carousel slide" data-ride="carousel">
																						<!-- Indicators -->
																						<ol class="carousel-indicators">
																							<li data-target="#carousel-segm-student" data-slide-to="0" class="active"></li>

																							<li data-target="#carousel-segm-student" data-slide-to="1"></li>
																						</ol>

																						<!-- Wrapper for slides -->
																						<div class="carousel-inner" role="listbox">
																							<div class="item active">
																								<div class="student-list">
																									<ul>
																										<li>
																											<div class="row">
																												<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																													<div class="data">
																														<div class="thumb-pic img-circle">
																															<img src="images/profile-pic.png" alt="">
																														</div>

																														<span>Martin silva v</span>
																													</div>
																												</div>

																												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																													<div class="data blue-light">
																														<span>90%</span>
																													</div>
																												</div>
																											</div>
																										</li>

																										<li>
																											<div class="row">
																												<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																													<div class="data">
																														<div class="thumb-pic img-circle">
																															<img src="images/profile-pic.png" alt="">
																														</div>

																														<span>Martin silva v</span>
																													</div>
																												</div>

																												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																													<div class="data blue-light">
																														<span>90%</span>
																													</div>
																												</div>
																											</div>
																										</li>
																									</ul>
																								</div>
																							</div>

																							<div class="item">
																								<div class="student-list">
																									<ul>
																										<li>
																											<div class="row">
																												<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																													<div class="data">
																														<div class="thumb-pic img-circle">
																															<img src="images/profile-pic.png" alt="">
																														</div>

																														<span>Martin silva v</span>
																													</div>
																												</div>

																												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																													<div class="data blue-light">
																														<span>90%</span>
																													</div>
																												</div>
																											</div>
																										</li>

																										<li>
																											<div class="row">
																												<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																													<div class="data">
																														<div class="thumb-pic img-circle">
																															<img src="images/profile-pic.png" alt="">
																														</div>

																														<span>Martin silva v</span>
																													</div>
																												</div>

																												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																													<div class="data blue-light">
																														<span>90%</span>
																													</div>
																												</div>
																											</div>
																										</li>
																									</ul>
																								</div>
																							</div>
																						</div>

																						<!-- Controls -->
																						<!-- <a class="left carousel-control" href="#carousel-segm-student" role="button" data-slide="prev">
																						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
																						<span class="sr-only">Previous</span>
																						</a>
																						<a class="right carousel-control" href="#carousel-segm-student" role="button" data-slide="next">
																						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
																						<span class="sr-only">Next</span>
																						</a> -->
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>

											</div>
										</div>
										
									</div>
								</div>

								<div role="tabpanel" class="tab-pane" id="T4">
									<div class="module-row">
										<div class="row">
											<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
												<div class="module-row">
													<div class="white-box no-pad">
														<div class="whitebox-row box-title">
															<div class="row">
																<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 title-module-b">
																	<h4>Evoluci&oacute;n del a&ntilde;o </h4>
																	<p>
																		9 Octubre 2017
																	</p>
																</div>

																<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">

																</div>
															</div>
														</div>

														<img src="images/graph_1.png" width="100%;" alt="">
													</div>
												</div>
												
												<div class="module-row">
													<div class="row">
														<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
															<div class="white-box no-pad">
																<div class="whitebox-row box-title">
																	<div class="row">
																		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 title-module-b">
																			<h4>Evoluci&oacute;n del a&ntilde;o </h4>
																			<p>
																				9 Octubre 2017
																			</p>
																		</div>

																		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
																			Test 6
																		</div>
																	</div>
																</div>

																<div class="graph-row">
																	<img src="images/graph_2.png" width="100%" alt="">
																</div>
															</div>
														</div>

														<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
															<div class="white-box no-pad">
																<div class="whitebox-row box-title">
																	<div class="row">
																		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 title-module-b">
																			<h4>Evoluci&oacute;n del a&ntilde;o </h4>
																			<p>
																				9 Octubre 2017
																			</p>
																		</div>

																		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
																			Test 6
																		</div>
																	</div>
																</div>

																<div class="graph-row text-center">
																	<img src="images/graph_3.png" width="220" alt="">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
												<div class="module-row">
													<div class="white-box">
														<div class="module-row">
															<div class="general-progress">
																<p>
																	Promedio General
																</p>

																<div class="progress-box">
																	<div class="row">
																		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																			680
																		</div>

																		<div class="col-xs-4 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4 text-right">
																			780
																		</div>
																	</div>

																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																			<div class="progress">
																				<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
																					<span class="sr-only">60% Complete</span>
																				</div>
																			</div>
																		</div>
																	</div>

																	<div class="row">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																			Actual  /  Meta
																		</div>
																	</div>
																</div>
															</div>
														</div>

														<hr/>

														<div class="subjects-inforow no-pad">
															<div class="row">
																<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
																	<span>Cantidad de evaluaciones</span>
																</div>

																<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
																	<span>73</span>
																</div>
															</div>

															<div class="row">
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 blue-light">
																	<span>Turn on to share your file changes and updates</span>
																</div>
															</div>
														</div>
														
														<div class="resume-pts">
															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		Promedio
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		680pts
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		Casos sobre la media 
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		49
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		Casos bajo la media 
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		24
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		M&aacute;ximo
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		825pts
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		M&iacute;nimo
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		456pts
																	</div>
																</div>
															</div>

															<div class="module-row">
																<div class="row">
																	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
																		Desviasión est&aacute;ndar
																	</div>

																	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
																		70pts
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												
												<div class="module-row">
													<div class="white-box">
														1
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="module-row">
										<div id="reportTabPanel">
											<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
												<div class="panel panel-default">
													<div class="panel-heading" role="tab" id="headingOne">
														<h4 class="panel-title">
															<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
																Detalle test 6 <i class="fa fa-caret-down" aria-hidden="true"></i>
															</a>
														</h4>
													</div>

													<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
														<div class="white-box no-pad">
															<div class="panel-body table">
																<div class="table-responsive text-center">
																	<table class="table table-striped table-condensed">
																		<thead>
																			<tr>
																				<th class="text-center">Pregunta</th>

																				<th class="text-center">% Correcta</th>

																				<th class="text-center">% Incorrecta</th>

																				<th class="text-center">% En blanco</th>

																				<th class="text-center">A</th>

																				<th class="text-center">B</th>

																				<th class="text-center">C</th>

																				<th class="text-center">E</th>

																				<th class="text-center">En blanco</th>
																			</tr>
																		</thead>

																		<tr>
																			<td>1</td>

																			<td>80%</td>

																			<td>18%</td>

																			<td>2%</td>

																			<td>
																				<span>1</span>
																			</td>

																			<td>
																				<span>3</span>
																			</td>

																			<td>
																				<span>0</span>
																			</td>

																			<td>
																				<span class="active">67</span>
																			</td>

																			<td>1</td>
																		</tr>

																		<tr>
																			<td>1</td>

																			<td>80%</td>

																			<td>18%</td>

																			<td>2%</td>

																			<td>
																				<span>1</span>
																			</td>

																			<td>
																				<span>3</span>
																			</td>

																			<td>
																				<span class="active">0</span>
																			</td>

																			<td>
																				<span>67</span>
																			</td>

																			<td>1</td>
																		</tr>

																		<tr>
																			<td>1</td>

																			<td>80%</td>

																			<td>18%</td>

																			<td>2%</td>

																			<td>
																				<span>1</span>
																			</td>

																			<td>
																				<span class="active">3</span>
																			</td>

																			<td>
																				<span>0</span>
																			</td>

																			<td>
																				<span>67</span>
																			</td>

																			<td>1</td>
																		</tr>
																	</table>
																</div>

																<div class="row">
																	<div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
																		<button class="btn btn-default btn-img more">
																			<span>Ver m&aacute;s resultados</span><br/>
																			<i class="fa fa-plus-circle" aria-hidden="true"></i>
																		</button>
																	</div>
																</div>
																
															</div>
														</div>
														
													</div>
												</div>

												<div class="panel panel-default">
													<div class="panel-heading" role="tab" id="headingTwo">
														<h4 class="panel-title">
															<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
															Detalle por ejes tem&aacute;ticos <i class="fa fa-caret-down" aria-hidden="true"></i>
															</a>
														</h4>
													</div>

													<div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
														<div class="panel-body no-pad">
															<div class="row">
																<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
																	<div class="white-box">
																		<div class="module-row title-module">
																			<h4>
																				&Aacute;lgebra
																			</h4>
																		</div>

																		<div class="module-row">
																			<div class="row status-row">
																				<div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
																					<div class="icon-status">
																						<img src="images/icon-check-on.png" width="100%" alt="">
																					</div>

																					<div class="percent-box">
																						<i class="fa fa-long-arrow-up" aria-hidden="true"></i> 80%
																						<span>
																							23
																						</span>
																					</div>
																				</div>
																			</div>

																			<div class="row status-row">
																				<div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
																					<div class="icon-status">
																						<img src="images/icon-check-on.png" width="100%" alt="">
																					</div>

																					<div class="percent-box">
																						<i class="fa fa-long-arrow-up" aria-hidden="true"></i> 80%
																						<span>
																							23
																						</span>
																					</div>
																				</div>
																			</div>

																			<div class="row status-row">
																				<div class="col-xs-12 col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
																					<div class="icon-status">
																						<img src="images/icon-check-on.png" width="100%" alt="">
																					</div>

																					<div class="percent-box">
																						<i class="fa fa-long-arrow-down" aria-hidden="true"></i> 80%
																						<span>
																							23
																						</span>
																					</div>
																				</div>
																			</div>
																		</div>

																		<div class="module-row">
																			<div class="row text-center">
																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
																					<button class="btn btn-default btn-line">
																						Geometr&iacute;a
																					</button>
																				</div>

																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
																					<button class="btn btn-default btn-line">
																						N&uacute;meros
																					</button>
																				</div>

																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
																					<button class="btn btn-default btn-line">
																						Medici&oacute;n
																					</button>
																				</div>
																			</div>
																		</div>

																		<div class="module-row">
																			<div class="row">
																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
																					<div class="status-icontxt">
																						<img src="images/icon-check-on.png" alt="">
																						<span>Correctas</span>
																					</div>
																				</div>

																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
																					<div class="status-icontxt">
																						<img src="images/icon-x_gray.png" alt="">
																						<span>Correctas</span>
																					</div>
																				</div>

																				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
																					<div class="status-icontxt">
																						<img src="images/icon-dot_red.png" alt="">
																						<span>Correctas</span>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>

																<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
																	<div class="white-box">
																		
									
																		<div class="module-row">
																			<div class="row">
																				<div class="col-xs-10 col-sm-10 col-xmds-10 col-lg-10 title-module">
																					<h4>
																						Segmentaci&oacute;n por puntaje
																					</h4>
																				</div>
																			</div>
																		</div>

																		<div class="module-row">
																			<div class="row segm-title">
																				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																					<h5>Álgebra</h5>
																					<p>Sobre el 80% <i class="fa fa-long-arrow-up" aria-hidden="true"></i></p>
																				</div>

																				<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
																					<img src="images/icon-check-on.png" width="30px" alt="">
																				</div>
																			</div>
																		</div>

																		<div class="module-row">
																			<div class="row">
																				<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
																					<div id="carousel-segm-student" class="carousel slide" data-ride="carousel">
																						<!-- Indicators -->
																						<ol class="carousel-indicators">
																							<li data-target="#carousel-segm-student" data-slide-to="0" class="active"></li>

																							<li data-target="#carousel-segm-student" data-slide-to="1"></li>
																						</ol>

																						<!-- Wrapper for slides -->
																						<div class="carousel-inner" role="listbox">
																							<div class="item active">
																								<div class="student-list">
																									<ul>
																										<li>
																											<div class="row">
																												<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																													<div class="data">
																														<div class="thumb-pic img-circle">
																															<img src="images/profile-pic.png" alt="">
																														</div>

																														<span>Martin silva v</span>
																													</div>
																												</div>

																												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																													<div class="data blue-light">
																														<span>90%</span>
																													</div>
																												</div>
																											</div>
																										</li>

																										<li>
																											<div class="row">
																												<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																													<div class="data">
																														<div class="thumb-pic img-circle">
																															<img src="images/profile-pic.png" alt="">
																														</div>

																														<span>Martin silva v</span>
																													</div>
																												</div>

																												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																													<div class="data blue-light">
																														<span>90%</span>
																													</div>
																												</div>
																											</div>
																										</li>
																									</ul>
																								</div>
																							</div>

																							<div class="item">
																								<div class="student-list">
																									<ul>
																										<li>
																											<div class="row">
																												<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																													<div class="data">
																														<div class="thumb-pic img-circle">
																															<img src="images/profile-pic.png" alt="">
																														</div>

																														<span>Martin silva v</span>
																													</div>
																												</div>

																												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																													<div class="data blue-light">
																														<span>90%</span>
																													</div>
																												</div>
																											</div>
																										</li>

																										<li>
																											<div class="row">
																												<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
																													<div class="data">
																														<div class="thumb-pic img-circle">
																															<img src="images/profile-pic.png" alt="">
																														</div>

																														<span>Martin silva v</span>
																													</div>
																												</div>

																												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
																													<div class="data blue-light">
																														<span>90%</span>
																													</div>
																												</div>
																											</div>
																										</li>
																									</ul>
																								</div>
																							</div>
																						</div>

																						<!-- Controls -->
																						<!-- <a class="left carousel-control" href="#carousel-segm-student" role="button" data-slide="prev">
																						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
																						<span class="sr-only">Previous</span>
																						</a>
																						<a class="right carousel-control" href="#carousel-segm-student" role="button" data-slide="next">
																						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
																						<span class="sr-only">Next</span>
																						</a> -->
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>

											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>		
</div>

<script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
<script type="text/javascript">
	var isFirstLoad = 0;
    $('.form_datetime').datetimepicker({
        //language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('.form_time').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });
	$(document).ready(function() {
		isFirstLoad = 1;
		$("#estaDetalleCurso").change();
	});
    
</script>
