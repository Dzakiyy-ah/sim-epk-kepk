    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
    <script src="<?php echo base_url()?>assets/js/select2.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/id.js"></script>

    <script type="text/javascript">
    	var protokol = <?php echo isset($protokol) ? json_encode($protokol) : "" ?>; 
    	var purge_dokumen = [], purge_filename = [];
    	jQuery(function($) {
        $(".select2").select2({
          placeholder: "Pilih...",
          language: "id",
          allowClear: true
        });

        $("#print_progress_protokol").on("click", function () {
          var divContents = $('#ifr_progress_protokol').contents().find("html").html();
          var printWindow = window.open('', '', 'height=400,width=800');
          printWindow.document.write('<html><head><link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.min.css" /><link rel="stylesheet" href="<?php echo base_url()?>assets/font-awesome/4.5.0/css/font-awesome.min.css" /><link rel="stylesheet" href="<?php echo base_url()?>assets/css/fonts.googleapis.com.css" /><link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" /><link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-part2.min.css" class="ace-main-stylesheet" /><link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-skins.min.css" /><link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-rtl.min.css" />');
          printWindow.document.write('</head><body >');
          printWindow.document.write(divContents);
          printWindow.document.write('</body></html>');
          printWindow.document.close();
          printWindow.print();
        });

    	});

    	function getNewid()
    	{
    	  return 'new_' + parseFloat((new Date().getTime() + '').slice(7))+ Math.round(Math.random() * 100);
    	}

      function rawurlencode (str) {
        str = (str+'').toString();        
        return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').replace(/\)/g, '%29').replace(/\*/g, '%2A');
      }

    	var Dokumen = function(id, deskripsi, client_name, file_name, file_size, file_type, file_ext){
    		this.id = id;
    		this.deskripsi = ko.observable(deskripsi);
    		this.client_name = client_name;
    		this.file_name = file_name;
    		this.file_size = file_size;
    		this.file_type = file_type;
    		this.file_ext = file_ext;
    	}

    	var DokumenPengarsipanModel = function(){
    		var self = this;
    		self.id = ko.observable(<?php echo isset($data['id_dok_arsip']) ? $data['id_dok_arsip'] : 0?>);
    		self.id_pengajuan = ko.observable(<?php echo isset($data['id_pengajuan']) ? $data['id_pengajuan'] : 0 ?>);
    		self.no_protokol = ko.observable('<?php echo isset($data['no_protokol']) ? $data['no_protokol'] : ''?>');
    		self.judul = ko.observable(<?php echo isset($data['judul']) ? json_encode($data['judul']) : ''?>);
    		self.nama_ketua = ko.observable(<?php echo isset($data['nama_ketua']) ? json_encode($data['nama_ketua']) : ''?>);
    		self.lokasi = ko.observable(<?php echo isset($data['tempat_penelitian']) ? json_encode($data['tempat_penelitian']) : ''?>);
        self.is_multi_senter = ko.observable('<?php echo isset($data['is_multi_senter']) ? ($data['is_multi_senter'] == 1 ? 'Ya' : 'Tidak') : '-' ?>');
        self.is_setuju_senter = ko.observable('<?php echo isset($data['is_multi_senter']) && $data['is_multi_senter'] == 1 ? (isset($data['is_setuju_senter']) && $data['is_setuju_senter'] == 1 ? 'Ya' : 'Tidak') : '-' ?>')
    		self.dokumen = ko.observableArray([]);
    		self.removeDokumen = function(dok){
    			self.dokumen.remove(dok);
    			purge_dokumen.push(dok.id);
    			purge_filename.push(dok.file_name);
    		};
        self.protokol = ko.observableArray([]);
        self.surat_surat = ko.observableArray([]);
        self.ifr_progress_protokol = ko.observable('');
    		self.processing = ko.observable(false);
    	}

    	var App = new DokumenPengarsipanModel();

    	App.id_pengajuan.subscribe(function(newValue){
        $.ajax({
          url: '<?php echo base_url()?>dokumen_pengarsipan/get_pengajuan_by_idpengajuan/'+newValue,
          type: 'post',
          cache: false,
          dataType: 'json',
          success: function(res, xhr){
            App.judul(res.judul);
            App.nama_ketua(res.nama_ketua);
            App.lokasi(res.lokasi);
            App.is_multi_senter(res.is_multi_senter);
            App.is_setuju_senter(res.is_setuju_senter);
            App.get_protokol(newValue);
            App.get_surat_surat(newValue);
            App.ifr_progress_protokol('<?php echo base_url()?>dokumen_pengarsipan/detail_progress/'+newValue);
          }
        });
    	})

      App.get_protokol = function(id_pengajuan){
        if (id_pengajuan != '')
        {
          App.protokol.removeAll();
          $.ajax({
            url: '<?php echo base_url()?>dokumen_pengarsipan/get_pep_by_id_pengajuan/'+id_pengajuan,
            type: 'post',
            cache: false,
            dataType: 'json',
            success: function(res, xhr){
              $.each(res, function(i, item){
                App.protokol.push({id: item.id, link_proposal: item.link_proposal, revisi: item.revisi,
                  lampiran_ic: ko.observableArray(ko.utils.arrayMap(item.lampiran_ic, function(ic) {
                    return ({lampiran: ic.lampiran, file_name: ic.file_name, client_name: ic.client_name})
                  }))
                });
              });
            }
          });
        }
      }

      App.get_surat_surat = function(id_pengajuan){
        if (id_pengajuan != '')
        {
          App.surat_surat.removeAll();
          $.ajax({
            url: '<?php echo base_url()?>dokumen_pengarsipan/get_surat_surat_by_id_pengajuan/'+id_pengajuan,
            type: 'post',
            cache: false,
            dataType: 'json',
            success: function(res, xhr){
              $.each(res, function(i, item){
                App.surat_surat.push({id: item.id, jenis_surat: item.jenis_surat, nama_surat: item.nama_surat, klasifikasi: item.klasifikasi, lampiran: item.lampiran});
              });
            }
          });
        }
      }

      App.print_protokol = function(id)
      {
        window.open('<?php echo base_url()?>dokumen_pengarsipan/cetak_protokol/'+id, '_blank');
      }

      App.print_surat = function(id, jns_surat, klasifikasi)
      {
        window.open('<?php echo base_url()?>dokumen_pengarsipan/cetak_surat/'+id+'/'+jns_surat+'/'+klasifikasi, '_blank');
      }

      App.progress_protokol = function()
      {
        var id_pengajuan = App.id_pengajuan();

        if (id_pengajuan == "")
          show_error(true, 'Protokol belum dipilih')
        else
          window.open('<?php echo base_url()?>dokumen_pengarsipan/detail_progress/'+id_pengajuan, '_blank');
      }

    	App.upload = function(){
    		$('#file').trigger('click');
    	}

    	App.do_upload = function(){
    		var data_upload = new FormData();
    	  		data_upload.append('file', $('#file').prop('files')[0]);
    	  		$('#upload').button('loading');

    		$.ajax({
    		    url: '<?php echo base_url()?>dokumen_pengarsipan/do_upload',
    		    type: 'post',
    		    processData: false, // important
    		    contentType: false, // important
    		    dataType : 'json',
    		    data: data_upload,
    		    success: function(res, xhr){
    			    if (res.isSuccess){
    	        		var id = getNewid();
    	        		App.dokumen.push(new Dokumen(id, '', res.data_fileupload.client_name, res.data_fileupload.file_name, res.data_fileupload.file_size, res.data_fileupload.file_type, res.data_fileupload.file_ext));
    	      		}
    			    else show_error(true, res.message);

    			    $('#upload').button('reset');
        		}
    		});

    	}

    	App.init_fileupload = function(){
    		if (App.id() > 0)
    		{
    			var id = App.id();
    			App.dokumen.removeAll();
    			$.ajax({
    				url: '<?php echo base_url()?>dokumen_pengarsipan/get_fileupload_by_id/'+id,
    				type: 'post',
    				dataType: 'json',
    				success: function(res, xhr){
    					$.each(res, function(i, item){
    			  		App.dokumen.push(new Dokumen(res[i].id, res[i].deskripsi, res[i].client_name, res[i].file_name, res[i].file_size, res[i].file_type, res[i].file_ext));  
    					});
    				}
    			});
    		}

    	}

      App.showFile = function(file_name){
        $.ajax({
          url: '<?php echo base_url()?>dokumen_pengarsipan/cek_file_exist/'+file_name,
          type: 'post',
          cache: false,
          dataType: 'json',
          success: function(res, xhr){
            if (res.isSuccess)
            {
              $('#myModal').modal('show');
              html = '<embed width="100%" height="500px" src="<?php echo base_url()?>dokumen_arsip/'+file_name+'">';
              $('#show_data_modal').html(html);
            }
            else
              show_error(true, 'File tidak ditemukan');
          }
        });
      };

      App.downloadFile = function(file_name, client_name){
        $.ajax({
          url: '<?php echo base_url()?>dokumen_pengarsipan/cek_file_exist/'+file_name,
          type: 'post',
          cache: false,
          dataType: 'json',
          success: function(res, xhr){
            if (res.isSuccess)
            {
              window.location.href = '<?php echo base_url()?>dokumen_pengarsipan/download/'+rawurlencode(file_name)+'/'+rawurlencode(client_name);
            }
            else
              show_error(true, 'File tidak ditemukan');
          }
        });
      }

    	App.save = function(createNew){
    	  var data = JSON.parse(ko.toJSON(App));
    	      data['dokumen'] = JSON.stringify(ko.toJS(App.dokumen()));
    	      data['purge_dokumen'] = purge_dokumen;
    	      data['purge_filename'] = purge_filename;
    	  var $btn = $('#submit');

    	  $btn.button('loading');
    	  App.processing(true);
    	  $.ajax({
    	    url: '<?php echo base_url()?>dokumen_pengarsipan/proses',
    	    type: 'post',
    	    cache: false,
    	    dataType: 'json',
    	    data: data,
    	    success: function(res, xhr){
    	      if (res.isSuccess){
    	      	App.id(res.id);
    	      	App.init_fileupload();
    	      	show_success(true, res.message);
    	      }
    	      else show_error(true, res.message);

    	      $btn.button('reset');
    	      App.processing(false);
    	    }
    	  });

    	}

    	App.back = function(){
    		window.location.href = '<?php echo base_url()?>dokumen_pengarsipan/';
    	}

    	ko.applyBindings(App);

    <?php if (isset($data['id_dok_arsip']) && $data['id_dok_arsip'] > 0) { ?>
    	App.init_fileupload();
    <?php } ?>

    </script>
