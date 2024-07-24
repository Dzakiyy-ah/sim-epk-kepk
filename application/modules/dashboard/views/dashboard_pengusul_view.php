<div data-bind="foreach: belum_kirim">
  <div class="alert alert-block alert-warning">
    <button type="button" class="close" data-dismiss="alert">
      <i class="ace-icon fa fa-times"></i>
    </button>
    <span data-bind="text: revisi > 0 ? 'Perbaikan Protokol' : 'Protokol'"></span>
    <strong><span data-bind="text: no+' '+judul"></span></strong> belum dikirim ke KEPK
    &nbsp;
    <button type="button" class="btn btn-minier btn-success" data-bind="click: function(data, event){ $root.kirim(id_pengajuan, id_pep, revisi, data, event) }">&nbsp;&nbsp;Kirim&nbsp;&nbsp;</button>
  </div>
  <br/>
</div>

<div data-bind="foreach: belum_monev">
  <div class="alert alert-block alert-warning">
    <button type="button" class="close" data-dismiss="alert">
      <i class="ace-icon fa fa-times"></i>
    </button>
    Anda belum mengirim Laporan Monev Penelitian Protokol <strong><span data-bind="text: no+' '+judul"></span></strong>
  </div>
  <br/>
</div>

<div data-bind="foreach: belum_laporan_akhir">
  <div class="alert alert-block alert-warning">
    <button type="button" class="close" data-dismiss="alert">
      <i class="ace-icon fa fa-times"></i>
    </button>
    Anda belum mengirim Laporan Hasil Akhir Penelitian Protokol <strong><span data-bind="text: no+' '+judul"></span></strong>
  </div>
  <br/>
</div>

<div class="row" style="height: 300px">
  <div class="col-xs-6 col-sm-6">
    <div class="widget-box transparent">
      <div class="widget-header widget-header-small">
        <h4 class="widget-title blue smaller">
          <i class="ace-icon fa fa-th blue"></i>
          Pemberitahuan Fullboard
        </h4>

        <div class="widget-toolbar action-buttons">
          <a href="#" data-action="reload" title="Perbarui" data-bind="click: init_pemberitahuan_fullboard()">
            <i class="ace-icon fa fa-refresh blue"></i>
          </a>
        </div>

        <div class="widget-toolbar">
          <small>Jumlah : <span data-bind="text: pemberitahuan_fullboard().length"></span></small>
        </div>

      </div>

      <div class="widget-body">
        <div class="widget-main padding-8 scrollable" data-size="220">
          <div id="pemberitahun_fullboard" class="profile-feed" data-bind="foreach: pemberitahuan_fullboard">
            <div class="profile-activity clearfix">
              <div>
                <div>
                  No Protokol: <a class="user" href="#"> <span data-bind="text: no"></span> </a>
                </div>
                <div>
                  Judul:
                  <a href="#"><span data-bind="text: judul"></span></a>
                </div>
                <div>
                  Tanggal, Jam:
                  <a href="#"><span data-bind="text: tgl_fb"></span> <span data-bind="text: jam_fb"></span></a>
                </div>
                <div>
                  Tempat:
                  <a href="#"><span data-bind="text: tempat_fb"></span></a>
                </div>

                <div class="time">
                  <i class="ace-icon fa fa-clock-o bigger-110"></i>
                  <span data-bind="text: waktu"></span>
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="hr hr2 hr-double"></div>

  </div>

  <div class="col-xs-6 col-sm-6">
    <div class="widget-box transparent">
      <div class="widget-header widget-header-small">
        <h4 class="widget-title blue smaller">
          <i class="ace-icon fa fa-edit blue"></i>
          Perbaikan Protokol
        </h4>

        <div class="widget-toolbar action-buttons">
          <a href="#" data-action="reload" title="Perbarui" data-bind="click: init_perbaikan_protokol()">
            <i class="ace-icon fa fa-refresh blue"></i>
          </a>
        </div>

        <div class="widget-toolbar">
          <small>Jumlah : <span data-bind="text: perbaikan_protokol().length"></span></small>
        </div>
      </div>

      <div class="widget-body">
        <div class="widget-main padding-8 scrollable" data-size="220">
          <div id="perbaikan_protokol" class="profile-feed" data-bind="foreach: perbaikan_protokol">
            <div class="profile-activity clearfix">
              <div>
                <div>
                  No Protokol: <a class="user" href="#"> <span data-bind="text: no"></span> </a>
                </div>
                <div>
                  Judul:
                  <a href="#"><span data-bind="text: judul"></span></a>
                </div>

                <div class="time">
                  <i class="ace-icon fa fa-clock-o bigger-110"></i>
                  <span data-bind="text: waktu"></span>
                </div>
              </div>

              <div class="tools action-buttons">
                <a class="blue" data-bind="attr:{href: url_edit}">
                  <i class="ace-icon fa fa-pencil bigger-125"></i>
                </a>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="hr hr2 hr-double"></div>

  </div>

</div>

<table id="grid-table"></table>

<div id="grid-pager"></div>
