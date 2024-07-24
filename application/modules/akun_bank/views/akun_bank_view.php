            <div class="page-header">
              <h1>
                <?php echo isset($page_header) ? $page_header : '' ?>
                <?php if (isset($subheader)) { ?>
                <small>
                  <i class="ace-icon fa fa-angle-double-right"></i>
                  <?php echo $subheader ?>
                </small>
                <?php } ?>
              </h1>
            </div><!-- /.page-header -->

            <div class="profile-contact-info">
              <div class="profile-contact-links align-left">
                <div class="profile-info-row">
                  <div class="profile-info-name">Nama Bank</div>
                  <div class="profile-info-value"><?php echo isset($data['nama_bank']) ? $data['nama_bank'] : '-' ?></div>
                </div>
                <div class="profile-info-row">
                  <div class="profile-info-name">No. Rekening</div>
                  <div class="profile-info-value"><?php echo isset($data['no_rekening']) ? $data['no_rekening'] : '-' ?></div>
                </div>
                <div class="profile-info-row">
                  <div class="profile-info-name">Pemilik Rekening</div>
                  <div class="profile-info-value"><?php echo isset($data['pemilik_rekening']) ? $data['pemilik_rekening'] : '-' ?></div>
                </div>
                <div class="profile-info-row">
                  <div class="profile-info-name">Swift Code</div>
                  <div class="profile-info-value"><?php echo isset($data['swift_code']) ? $data['swift_code'] : '-' ?></div>
                </div>
              </div>
            </div>

            <h4 class="header blue bolder smaller">Tarif/Biaya Telaah</h4>
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Jenis Penelitian</th>
                  <th>Asal Pengusul</th>
                  <th>Jenis Lembaga Asal Pengusul</th>
                  <th>Status Pengusul</th>
                  <th>Strata Pendidikan Pengusul</th>
                  <th>Tarif/Biaya</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (!empty($data_tarif)) 
                {
                  for ($i=0; $i<count($data_tarif); $i++)
                  {
                    switch ($data_tarif[$i]['jenis_penelitian']) {
                      case 1: $jns_penelitian = 'Observasional'; break;
                      case 2: $jns_penelitian = 'Intervensi'; break;
                      case 3: $jns_penelitian = 'Uji Klinik'; break;
                      default: $jns_penelitian = ''; break;
                    }

                    switch ($data_tarif[$i]['asal_pengusul']) {
                      case 1: $asal_pengusul = 'Internal'; break;
                      case 2: $asal_pengusul = 'Eksternal'; break;
                      default: $asal_pengusul = ''; break;
                    }

                    switch ($data_tarif[$i]['jenis_lembaga']) {
                      case 1: $jns_lembaga = 'Pendidikan'; break;
                      case 2: $jns_lembaga = 'Rumah Sakit'; break;
                      case 3: $jns_lembaga = 'Litbang'; break;
                      default: $jns_lembaga = ''; break;
                    }

                    switch ($data_tarif[$i]['status_pengusul']) {
                      case 1: $status_pengusul = 'Mahasiswa'; break;
                      case 2: $status_pengusul = 'Dosen'; break;
                      case 3: $status_pengusul = 'Pelaksana Pelayanan'; break;
                      case 4: $status_pengusul = 'Peneliti'; break;
                      case 5: $status_pengusul = 'Lainnya'; break;
                      default: $status_pengusul = ''; break;
                    }

                    switch ($data_tarif[$i]['strata_pendidikan']) {
                      case 1: $strata_pend = 'Diploma III'; break;
                      case 2: $strata_pend = 'Diploma IV'; break;
                      case 3: $strata_pend = 'S-1'; break;
                      case 4: $strata_pend = 'S-2'; break;
                      case 5: $strata_pend = 'S-3'; break;
                      case 6: $strata_pend = 'Sp-1'; break;
                      case 7: $strata_pend = 'Sp-2'; break;
                      case 8: $strata_pend = 'Lainnya'; break;
                      default: $strata_pend = ''; break;
                    }
                ?>
                <tr>
                  <td><?php echo $jns_penelitian ?></td>
                  <td><?php echo $asal_pengusul ?></td>
                  <td><?php echo $jns_lembaga ?></td>
                  <td><?php echo $status_pengusul ?></td>
                  <td><?php echo $strata_pend ?></td>
                  <td align="right"><?php echo isset($data_tarif[$i]['tarif_telaah']) ? number_format($data_tarif[$i]['tarif_telaah'],2,",",".") : '' ?></td>
                </tr>
                <?php } } ?>
              </tbody>
            </table>
