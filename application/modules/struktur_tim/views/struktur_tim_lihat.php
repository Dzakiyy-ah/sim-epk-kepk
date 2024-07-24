  	<div class="widget-box">
  		<div class="widget-header">
  			<h4 class="widget-title">
  				Struktur Tim KEPK
  			</h4>
  		</div>

  		<div class="widget-body">
  			<div class="widget-main">
  				<dl class="dl-horizontal">
            <dt style="width: 150px;">Periode</dt>
            <dd><span data-bind="text: periode_awal"></span> s/d <span data-bind="text: periode_akhir"></span></dd>
            <dt style="width: 150px;">Aktif Tim KEPK</dt>
            <dd><span data-bind="text: aktif_tim"></span></dd>
            <hr/>
  					<dt style="width: 150px;">Ketua</dt>
  					<dd><span data-bind="text: nama_ketua"></span></dd>
  					<dt style="width: 150px;">Wakil Ketua</dt>
  					<dd>
  						<ol data-bind="foreach: nama_wakil_ketua">
  							<li><span data-bind="text: $data"></span></li>
  						</ol>
  					</dd>
  					<dt style="width: 150px;">Sekretaris</dt>
  					<dd>
  						<ol data-bind="foreach: nama_sekretaris">
  							<li><span data-bind="text: $data"></span></li>
  						</ol>
  					</dd>
  					<dt style="width: 150px;">Kesekretariatan</dt>
  					<dd>
  						<ol data-bind="foreach: nama_sekretariat">
  							<li><span data-bind="text: $data"></span></li>
  						</ol>
  					</dd>
  					<dt style="width: 150px;">Penelaah</dt>
  					<dd>
  						<ol data-bind="foreach: nama_penelaah">
  							<li><span data-bind="text: $data"></span></li>
  						</ol>
  					</dd>
  					<dt style="width: 150px;">Lay Person</dt>
  					<dd>
  						<ol data-bind="foreach: nama_lay_person">
  							<li><span data-bind="text: $data"></span></li>
  						</ol>
  					</dd>
  					<dt style="width: 150px;">Konsultan Independen</dt>
  					<dd>
  						<ol data-bind="foreach: nama_konsultan">
  							<li><span data-bind="text: $data"></span></li>
  						</ol>
  					</dd>
  				</dl>
  			</div>
  		</div>
  	</div>

    <div class="clearfix form-actions">
      <div class="col-md-offset-3 col-md-9">
        <button class="btn btn-warning" type="button" data-bind="click: back">
          <i class="ace-icon fa fa-list bigger-110"></i>
          Lihat Daftar
        </button>
      </div>
    </div>

