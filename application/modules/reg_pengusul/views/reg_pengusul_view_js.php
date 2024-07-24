<!-- page specific plugin scripts -->
<script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
<script src="<?php echo base_url()?>assets/js/app.js"></script>
<script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
<script type="text/javascript">
	jQuery(function($) {

	});

<?php if (isset($isset_kepk) && $isset_kepk == 1) { ?>
  function rawurlencode (str) {
    str = (str+'').toString();        
    return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').replace(/\)/g, '%29').replace(/\*/g, '%2A');
  }

  function getNewid(){
    return 'new_' + parseFloat((new Date().getTime() + '').slice(7))+ Math.round(Math.random() * 100);
  }

  var Dokumen = function(id, deskripsi, client_name, file_name, file_size, file_type, file_ext){
    this.id = id;
    this.deskripsi = deskripsi;
    this.client_name = client_name;
    this.file_name = file_name;
    this.file_size = file_size;
    this.file_type = file_type;
    this.file_ext = file_ext;
  }

	var RegPengusulModel = function(){
		var self = this;
		self.id = ko.observable(0);
    self.no_anggota = ko.observable('');
    self.nama = ko.observable("");
    self.nik = ko.observable("");
    self.tempat_lahir = ko.observable("");
    self.tgl_lahir = ko.observable("");
    self.kewarganegaraan = ko.observable("");
    self.negara = ko.observable("");
    self.alamat = ko.observable("");
    self.jalan = ko.observable("");
    self.no_rumah = ko.observable("");
    self.rt = ko.observable("");
    self.rw = ko.observable("");
    self.propinsi = ko.observable("");
    self.kabupaten = ko.observable("");
    self.kecamatan = ko.observable("");
    self.kode_pos = ko.observable("");
    self.email = ko.observable("");
    self.no_telp = ko.observable("");
    self.no_hp = ko.observable("");
    self.dokumen = ko.observableArray([]);
    self.processing = ko.observable(false);
		self.registered = ko.observable(false);
		self.username = ko.observable('');
		self.password = ko.observable('');
		self.url = ko.observable('');
	}

	var App = new RegPengusulModel();

  App.showFile = function(path){
    if (path.substring(path.lastIndexOf('/') + 1) == "")
      show_error(true, 'File belum diunggah');
    else
    {
      $.ajax({
        url:'<?php echo base_url()?>'+path,
        type:'GET',
        error: function() {
          show_error(true, 'File tidak ditemukan');
        },
        success: function(data) {
          $('#myModal').modal('show');
          html = '<embed width="100%" height="500px" src="<?php echo base_url() ?>'+path+'">';
          $('#show_data_modal').html(html);
        }
      });
    }
  };

  App.tampilkan_data_peneliti = function(){
    App.get_peneliti();
    App.get_dokumen_peneliti();
  }

  App.get_peneliti = function(){
    var no = App.no_anggota();

    if (no.trim() == "")
      show_error(true, 'Nomor Anggota harus diisi');
    else
    {
      $('#frm').append('<div class="message-loading-overlay"><i class="fa-spin ace-icon fa fa-spinner orange2 bigger-160"></i></div>');
      $('#search_peneliti').button('loading');
      $.ajax({
        url: '<?php echo base_url()?>reg_pengusul/get_peneliti_by_no/'+no,
        type: 'post',
        cache: false,
        dataType: 'json',
        success: function(res, xhr){
          if (res.isSuccess){
            var data = res.data;
            App.nama(data.nama_anggota);
            App.nik(data.nik);
            App.tempat_lahir(data.tempat_lahir);
            App.tgl_lahir(data.tgl_lahir);
            App.kewarganegaraan(data.kewarganegaraan);
            App.negara(data.id_country);
            App.alamat(data.alamat);
            App.jalan(data.jalan);
            App.no_rumah(data.no_rumah);
            App.rt(data.rt);
            App.rw(data.rw);
            App.propinsi(data.kode_propinsi);
            App.kabupaten(data.kode_kabupaten);
            App.kecamatan(data.kode_kecamatan);
            App.kode_pos(data.kode_pos);
            App.email(data.email);
            App.no_telp(data.no_telepon);
            App.no_hp(data.no_hp);
            App.username(data.username);
            App.password(data.password);
          }
          else show_error(true, res.message);

        }
      });
    }
  }

  App.get_dokumen_peneliti = function(){
    var no = App.no_anggota();

    if (no.trim() == "")
      show_error(true, 'Nomor Anggota harus diisi');
    else
    {
      App.dokumen.removeAll();
      $.ajax({
        url: '<?php echo base_url()?>reg_pengusul/get_dokumen_peneliti_by_no/'+no,
        type: 'post',
        cache: false,
        dataType: 'json',
        success: function(res, xhr){
          if (res.isSuccess){
            var data = res.data;
            if (typeof data !== 'undefined')
            {
              $.each(data, function(i, item){
                var id = getNewid();
                App.dokumen.push(new Dokumen(id, item.deskripsi_file, item.client_name, item.file_name, item.file_size, item.file_type, item.file_ext));
              })
            }
          }

          $('#search_peneliti').button('reset');
          $('#frm').find('.message-loading-overlay').remove();
        }
      });
    }
  }

	App.save = function(createNew){
	  var data = JSON.parse(ko.toJSON(App));
	  var $btn = $('#submit');

	  $btn.button('loading');
	  App.processing(true);
	  $.ajax({
	    url: '<?php echo base_url()?>reg_pengusul/proses',
	    type: 'post',
	    cache: false,
	    dataType: 'json',
	    data: data,
	    success: function(res, xhr){
	      if (res.isSuccess){
          App.url(res.url_cetak);
	        App.registered(true);
        }
	      else show_error(true, res.message);

	      $btn.button('reset');
	      App.processing(false);
	    }
	  });

	}

	ko.applyBindings(App);
<?php } ?>
</script>
