<div class="form-horizontal">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-top"> Nomor Protokol </label>

		<div class="col-sm-9">
			<select class="select2 form-control" id="id_pep" data-bind="value: id_pep, enable: id() == 0" data-placeholder="Nomor Protokol">
				<option value=""></option>
				<?php
				if (isset($protokol))
				{
					for ($i=0; $i<count($protokol); $i++)
					{
						echo '<option value="'.$protokol[$i]['id_pep'].'">'.$protokol[$i]['no_protokol'].' - '.$protokol[$i]['judul'].'</option>';
					}

					if (isset($data['id_pep']) && $data['id_pep'] > 0)
					{
						echo '<option value="'.$data['id_pep'].'">'.$data['no_protokol'].' - '.$data['judul'].'</option>';
					}
				}
				?>
			</select>

		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right"> Klasifikasi/ Proses </label>

		<div class="col-sm-9">
			<label class="control-label" data-bind="text: klasifikasi"></label>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right"> Keputusan </label>

		<div class="col-sm-9">
			<label class="control-label" data-bind="text: keputusan"></label>
		</div>
	</div>

	<div class="hr hr-16 hr-dotted"></div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right"> Nomor Surat </label>

		<div class="col-sm-9">
			<input type="text" id="no_surat" placeholder="Nomor Surat" class="col-xs-5 col-sm-6" data-bind="value: no_surat" />
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right"> Nomor Dokumen </label>

		<div class="col-sm-9">
			<input type="text" id="no_dokumen" placeholder="Nomor Dokumen" class="col-xs-5 col-sm-6" data-bind="value: no_dokumen" disabled="disabled" />
			<span class="help-inline col-xs-12 col-sm-7" data-bind="visible: id() == 0">
				<span class="middle">Terisi jika sudah tersimpan</span>
			</span>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right"> Tanggal Surat </label>

		<div class="col-sm-3">
			<div class="input-group">
				<input class="form-control date-picker" id="tgl_surat" type="text" data-date-format="dd-mm-yyyy" data-bind="value: tgl_surat" />
				<span class="input-group-addon">
					<i class="fa fa-calendar bigger-110"></i>
				</span>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right"> Masa Berlaku </label>

		<div class="col-sm-3">
			<div class="input-daterange input-group" data-date-format="dd-mm-yyyy" >
				<input type="text" class="input-sm form-control" name="start" data-bind="value: awal_berlaku" />
				<span class="input-group-addon">
					<i class="fa fa-exchange"></i>
				</span>

				<input type="text" class="input-sm form-control" name="end" data-bind="value: akhir_berlaku" />
			</div>
		</div>
	</div>

	<div class="hr hr-16 hr-dotted"></div>

	<div class="form-group">
		<div class="col-xs-12 col-sm-12 widget-container-col">
			<div class="widget-box">
				<div class="widget-header">
					<h6 class="widget-title bigger lighter">
						<i class="ace-icon fa fa-check-square-o bigger-120"></i>
						7 Standar Kelaikan Etik Penelitian
					</h6>
					<div class="widget-toolbar">
						<a href="#" data-bind="click: print_sa">
							<i class="ace-icon fa fa-print"></i>
						</a>

						<a href="#" data-action="fullscreen" class="orange2">
							<i class="ace-icon fa fa-expand"></i>
						</a>

						<a href="#" data-action="collapse">
							<i class="ace-icon fa fa-chevron-up"></i>
						</a>

					</div>
				</div>

				<div class="widget-body">
					<div class="widget-main">
						<div id="fuelux-wizard-container">
							<div>
								<ul class="steps">
									<li data-step="1" class="active">
										<span class="step">1</span>
										<span class="title">Nilai Sosial/Klinis</span>
									</li>

									<li data-step="2">
										<span class="step">2</span>
										<span class="title">Nilai Ilmiah</span>
									</li>

									<li data-step="3">
										<span class="step">3</span>
										<span class="title">Pemerataan Beban dan Manfaat</span>
									</li>

									<li data-step="4">
										<span class="step">4</span>
										<span class="title">Potensi Manfaat dan Resiko</span>
									</li>

									<li data-step="5">
										<span class="step">5</span>
										<span class="title">Bujukan/ Eksploitasi/ Iducement</span>
									</li>

									<li data-step="6">
										<span class="step">6</span>
										<span class="title">Rahasia dan Privacy</span>
									</li>

									<li data-step="7">
										<span class="step">7</span>
										<span class="title">Informed Consent</span>
									</li>
								</ul>
							</div>

							<hr />

							<div class="step-content pos-rel">
								<div class="step-pane active" data-step="1">
									<table class="table table-bordered table-hover">
										<thead>
											<tr>
												<th width="5%">No</th>
												<th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
												<th width="10%">PENELITI</th>
												<th width="10%">SEKRETARIS</th>
											</tr>
										</thead>
										<tbody data-bind="foreach: self_assesment1">
                      <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
                        <td data-bind="no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
                        <td>
                          <div data-bind="if: level == 0">
                            <strong><span data-bind="html: uraian_master"></span></strong>
                            <br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
                          </div>
                          <div data-bind="if: level > 0">
                            <span data-bind="html: uraian"></span>
                          </div>
                        </td>
												<td>
													<div class="control-group" data-bind="visible: just_header == 0">
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
																<span class="lbl"> Ya</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
																<span class="lbl"> Tidak</span>
															</label>
														</div>
													</div>
												</td>
												<td>
													<div class="control-group" data-bind="visible: just_header == 0">
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Ya" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'Ya'" />
																<span class="lbl"> Ya</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'Tidak'" />
																<span class="lbl"> Tidak</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="NA" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'NA'" />
																<span class="lbl"> NA</span>
															</label>
														</div>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>

								<div class="step-pane" data-step="2">
									<table class="table table-bordered table-hover">
										<thead>
											<tr>
												<th width="5%">No</th>
												<th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
												<th width="10%">PENELITI</th>
												<th width="10%">SEKRETARIS</th>
											</tr>
										</thead>
										<tbody data-bind="foreach: self_assesment2">
                      <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
                        <td data-bind="html: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
                        <td>
                          <div data-bind="if: level == 0">
                            <strong><span data-bind="html: uraian_master"></span></strong>
                            <br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
                          </div>
                          <div data-bind="if: level > 0">
                            <span data-bind="html: uraian"></span>
                          </div>
                        </td>
												<td>
													<div class="control-group" data-bind="visible: just_header == 0">
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
																<span class="lbl"> Ya</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
																<span class="lbl"> Tidak</span>
															</label>
														</div>
													</div>
												</td>
												<td>
													<div class="control-group" data-bind="visible: just_header == 0">
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Ya" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'Ya'" />
																<span class="lbl"> Ya</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'Tidak'" />
																<span class="lbl"> Tidak</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="NA" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'NA'" />
																<span class="lbl"> NA</span>
															</label>
														</div>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>

								<div class="step-pane" data-step="3">
									<table class="table table-bordered table-hover">
										<thead>
											<tr>
												<th width="5%">No</th>
												<th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
												<th width="10%">PENELITI</th>
												<th width="10%">SEKRETARIS</th>
											</tr>
										</thead>
										<tbody data-bind="foreach: self_assesment3">
                      <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
                        <td data-bind="html: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
                        <td>
                          <div data-bind="if: level == 0">
                            <strong><span data-bind="html: uraian_master"></span></strong>
                            <br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
                          </div>
                          <div data-bind="if: level > 0">
                            <span data-bind="html: uraian"></span>
                          </div>
                        </td>
												<td>
													<div class="control-group" data-bind="visible: just_header == 0">
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
																<span class="lbl"> Ya</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
																<span class="lbl"> Tidak</span>
															</label>
														</div>
													</div>
												</td>
												<td>
													<div class="control-group" data-bind="visible: just_header == 0">
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Ya" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'Ya'" />
																<span class="lbl"> Ya</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'Tidak'" />
																<span class="lbl"> Tidak</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="NA" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'NA'" />
																<span class="lbl"> NA</span>
															</label>
														</div>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>

								<div class="step-pane" data-step="4">
									<table class="table table-bordered table-hover">
										<thead>
											<tr>
												<th width="5%">No</th>
												<th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
												<th width="10%">PENELITI</th>
												<th width="10%">SEKRETARIS</th>
											</tr>
										</thead>
										<tbody data-bind="foreach: self_assesment4">
                      <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
                        <td data-bind="no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
                        <td>
                          <div data-bind="if: level == 0">
                            <strong><span data-bind="html: uraian_master"></span></strong>
                            <br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
                          </div>
                          <div data-bind="if: level > 0">
                            <span data-bind="html: uraian"></span>
                          </div>
                        </td>
												<td>
													<div class="control-group" data-bind="visible: just_header == 0">
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
																<span class="lbl"> Ya</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
																<span class="lbl"> Tidak</span>
															</label>
														</div>
													</div>
												</td>
												<td>
													<div class="control-group" data-bind="visible: just_header == 0">
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Ya" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'Ya'" />
																<span class="lbl"> Ya</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'Tidak'" />
																<span class="lbl"> Tidak</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="NA" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'NA'" />
																<span class="lbl"> NA</span>
															</label>
														</div>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>

								<div class="step-pane" data-step="5">
									<table class="table table-bordered table-hover">
										<thead>
											<tr>
												<th width="5%">No</th>
												<th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
												<th width="10%">PENELITI</th>
												<th width="10%">SEKRETARIS</th>
											</tr>
										</thead>
										<tbody data-bind="foreach: self_assesment5">
                      <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
                        <td data-bind="html: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
                        <td>
                          <div data-bind="if: level == 0">
                            <strong><span data-bind="html: uraian_master"></span></strong>
                            <br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
                          </div>
                          <div data-bind="if: level > 0">
                            <span data-bind="html: uraian"></span>
                          </div>
                        </td>
												<td>
													<div class="control-group" data-bind="visible: just_header == 0">
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
																<span class="lbl"> Ya</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
																<span class="lbl"> Tidak</span>
															</label>
														</div>
													</div>
												</td>
												<td>
													<div class="control-group" data-bind="visible: just_header == 0">
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Ya" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'Ya'" />
																<span class="lbl"> Ya</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'Tidak'" />
																<span class="lbl"> Tidak</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="NA" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'NA'" />
																<span class="lbl"> NA</span>
															</label>
														</div>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>

								<div class="step-pane" data-step="6">
									<table class="table table-bordered table-hover">
										<thead>
											<tr>
												<th width="5%">No</th>
												<th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
												<th width="10%">PENELITI</th>
												<th width="10%">SEKRETARIS</th>
											</tr>
										</thead>
										<tbody data-bind="foreach: self_assesment6">
                      <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
                        <td data-bind="html: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
                        <td>
                          <div data-bind="if: level == 0">
                            <strong><span data-bind="html: uraian_master"></span></strong>
                            <br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
                          </div>
                          <div data-bind="if: level > 0">
                            <span data-bind="html: uraian"></span>
                          </div>
                        </td>
												<td>
													<div class="control-group" data-bind="visible: just_header == 0">
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
																<span class="lbl"> Ya</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
																<span class="lbl"> Tidak</span>
															</label>
														</div>
													</div>
												</td>
												<td>
													<div class="control-group" data-bind="visible: just_header == 0">
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Ya" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'Ya'" />
																<span class="lbl"> Ya</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'Tidak'" />
																<span class="lbl"> Tidak</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="NA" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'NA'" />
																<span class="lbl"> NA</span>
															</label>
														</div>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>

								<div class="step-pane" data-step="7">
									<table class="table table-bordered table-hover">
										<thead>
											<tr>
												<th width="5%">No</th>
												<th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
												<th width="10%">PENELITI</th>
												<th width="10%">SEKRETARIS</th>
											</tr>
										</thead>
										<tbody data-bind="foreach: self_assesment7">
                      <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
                        <td data-bind="html: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
                        <td>
                          <div data-bind="if: level == 0">
                            <strong><span data-bind="html: uraian_master"></span></strong>
                            <br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
                          </div>
                          <div data-bind="if: level > 0">
                            <span data-bind="html: uraian"></span>
                          </div>
                        </td>
												<td>
													<div class="control-group" data-bind="visible: just_header == 0">
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
																<span class="lbl"> Ya</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
																<span class="lbl"> Tidak</span>
															</label>
														</div>
													</div>
												</td>
												<td>
													<div class="control-group" data-bind="visible: just_header == 0">
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Ya" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'Ya'" />
																<span class="lbl"> Ya</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'Tidak'" />
																<span class="lbl"> Tidak</span>
															</label>
														</div>
														<div class="radio">
															<label>
																<input type="radio" class="ace" value="NA" data-bind="checked: pil_sekretaris, attr:{'name': $index().$data}, enable: pil_sekretaris == 'NA'" />
																<span class="lbl"> NA</span>
															</label>
														</div>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>

							</div>
						</div>

						<hr />
						<div class="wizard-actions">
							<button class="btn btn-sm btn-prev">
								<i class="ace-icon fa fa-arrow-left"></i>
								Sebelumnya
							</button>

							<button class="btn btn-sm btn-success btn-next" data-last="Selesai">
								Selanjutnya
								<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<button class="btn btn-primary" id="submit" type="button" data-loading-text="Proses..." data-bind="click: function(data, event){save(false, data, event) }, enable: id() == 0 && is_kirim() == 0">
				<i class="ace-icon fa fa-floppy-o bigger-110"></i>
				Simpan
			</button>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button class="btn btn-warning" id="back" type="button" data-bind="click: back">
				<i class="ace-icon fa fa-list bigger-110"></i>
				Lihat Daftar
			</button>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button class="btn btn-default" id="print" type="button" data-bind="click: print, enable: id() > 0">
				<i class="ace-icon fa fa-print bigger-110"></i>
				Cetak
			</button>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button class="btn btn-success" id="kirim" type="button" data-bind="click: kirim, enable: id() > 0 && is_kirim() == 0">
				<i class="ace-icon fa fa-envelope bigger-110"></i>
				<span data-bind="text: lbl_btn_kirim"></span> ke Peneliti
			</button>
		</div>
	</div>

</div>
