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

            <?php if (empty($data)) { ?>
            <div class="alert alert-block alert-warning">
              <button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
              <i class="ace-icon fa fa-exclamation-triangle yellow"></i>
              Data masih kosong. Silakan masukkan nomor KEPK dan token untuk mendapatkan data KEPK.
              <strong>Pastikan bahwa Nomor KEPK dan token yang dimasukkan tidak salah.</strong>
            </div>

            <input type="text" name="no_kep" id="no_kep" placeholder="Nomor KEPK" data-bind="value: no_kep">
            <input type="text" name="token" id="token" placeholder="Token" data-bind="value: token">
            <button type="button" id="import_data" class="btn btn-sm btn-purple" data-bind="click: import_data"><i class="ace-icon fa fa-file-text bigger-110"></i> Ambil & Impor Data KEPK</button>

            <?php } ?>

            <?php if (!empty($data) && isset($data['aktif']) && $data['aktif'] == 0) { ?>
            <div class="alert alert-block alert-success">
              <button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
              <i class="ace-icon fa fa-check yellow"></i>
              Registrasi untuk mengaktifkan KEPK
            </div>
            <button type="button" class="btn btn-primary" id="btn-registrasi" data-bind="click: registrasi,visible: data > 0 && aktif == 0">
              <i class="ace-icon fa fa-circle-o-notch bigger-110"></i> Registrasi
            </button>
            <?php } ?>

            <h4 class="header blue bolder smaller">Data KEPK</h4>
            <div class="profile-user-info">
              <div class="profile-info-row">
                <div class="profile-info-name">Nama KEPK</div>
                <div class="profile-info-value"><?php echo isset($data['nama_kepk']) ? $data['nama_kepk'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">No. Surat Penetapan KEPK dan atau Surat Penetapan Tim KEPK</div>
                <div class="profile-info-value"><?php echo isset($data['no_surat_penetapan']) ? $data['no_surat_penetapan'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">Alamat</div>
                <div class="profile-info-value"><?php echo isset($data['alamat_kepk']) ? $data['alamat_kepk'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">Jalan</div>
                <div class="profile-info-value"><?php echo isset($data['jalan_kepk']) ? $data['jalan_kepk'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">Nomor</div>
                <div class="profile-info-value"><?php echo isset($data['no_rumah_kepk']) ? $data['no_rumah_kepk'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">RT / RW</div>
                <div class="profile-info-value"><?php echo isset($data['rt_kepk']) ? $data['rt_kepk'] : '-' ?> / <?php echo isset($data['rw_kepk']) ? $data['rw_kepk'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">Kecamatan</div>
                <div class="profile-info-value"><?php echo isset($data['kecamatan_kepk']) ? $data['kecamatan_kepk'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">Kabupaten / Kotamadya</div>
                <div class="profile-info-value"><?php echo isset($data['kabupaten_kepk']) ? $data['kabupaten_kepk'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">Propinsi</div>
                <div class="profile-info-value"><?php echo isset($data['propinsi_kepk']) ? $data['propinsi_kepk'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">Kode Pos</div>
                <div class="profile-info-value"><?php echo isset($data['kode_pos_kepk']) ? $data['kode_pos_kepk'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">Email</div>
                <div class="profile-info-value"><?php echo isset($data['email_kepk']) ? $data['email_kepk'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">No. Telepon</div>
                <div class="profile-info-value"><?php echo isset($data['no_telp_kepk']) ? $data['no_telp_kepk'] : '-' ?></div>
              </div>
            </div>

            <h4 class="header blue bolder smaller">Data Lembaga</h4>
            <div class="profile-user-info">
              <div class="profile-info-row">
                <div class="profile-info-name">Nama Lembaga</div>
                <div class="profile-info-value"><?php echo isset($data['nama_lembaga']) ? $data['nama_lembaga'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">Alamat</div>
                <div class="profile-info-value"><?php echo isset($data['alamat_lembaga']) ? $data['alamat_lembaga'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">Jalan</div>
                <div class="profile-info-value"><?php echo isset($data['jalan_lembaga']) ? $data['jalan_lembaga'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">Nomor</div>
                <div class="profile-info-value"><?php echo isset($data['no_rumah_lembaga']) ? $data['no_rumah_lembaga'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">RT / RW</div>
                <div class="profile-info-value"><?php echo isset($data['rt_lembaga']) ? $data['rt_lembaga'] : '-' ?> / <?php echo isset($data['rw_lembaga']) ? $data['rw_lembaga'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">Kecamatan</div>
                <div class="profile-info-value"><?php echo isset($data['kecamatan_lembaga']) ? $data['kecamatan_lembaga'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">Kabupaten / Kotamadya</div>
                <div class="profile-info-value"><?php echo isset($data['kabupaten_lembaga']) ? $data['kabupaten_lembaga'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">Propinsi</div>
                <div class="profile-info-value"><?php echo isset($data['propinsi_lembaga']) ? $data['propinsi_lembaga'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">Kode Pos</div>
                <div class="profile-info-value"><?php echo isset($data['kode_pos_lembaga']) ? $data['kode_pos_lembaga'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">Email</div>
                <div class="profile-info-value"><?php echo isset($data['email_lembaga']) ? $data['email_lembaga'] : '-' ?></div>
              </div>
              <div class="profile-info-row">
                <div class="profile-info-name">No. Telepon</div>
                <div class="profile-info-value"><?php echo isset($data['no_telp_lembaga']) ? $data['no_telp_lembaga'] : '-' ?></div>
              </div>
            </div>
