    <!-- page specific plugin scripts -->
    <script src="<?php echo base_url()?>assets/js/spinbox.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap-datepicker.id.js"></script>
    <script src="<?php echo base_url()?>assets/js/select2.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/id.js"></script>
    <script src="<?php echo base_url()?>assets/js/autosize.min.js"></script>

    <script type="text/javascript">
    	var purge_anggota_peneliti = [], purge_peneliti_asing = [];

    	jQuery(function($) {
    		$('#jml_negara').ace_spinner({value:0,min:0,max:10000,step:1, touch_spinner: true, icon_up:'ace-icon fa fa-caret-up bigger-110', icon_down:'ace-icon fa fa-caret-down bigger-110'});

    		$('.spinbox-up, .spinbox-down').click(function(){
    			var jml = parseInt($('#jml_negara').val());
    			App.jml_negara(jml);
    		})

	      autosize($('textarea[class*=autosize]'));

    	  $(".select2").select2({
        	placeholder: "Pilih...",
          language: "id",
          allowClear: true
        });

        $('.date-picker').datepicker({
          autoclose: true,
          todayHighlight: true,
          language: 'id'
        })
        //show datepicker when clicking on the icon
        .next().on(ace.click_event, function(){
          $(this).prev().focus();
        });

				//or change it into a date range picker
				$('.input-daterange').datepicker({
          autoclose:true,
          todayHighlight: true,
          language: 'id'
        });
    				
    	});

    	function getNewid()
    	{
    	  return 'new_' + parseFloat((new Date().getTime() + '').slice(7))+ Math.round(Math.random() * 100);
    	}

    	var AnggotaPenelitan = function(id, nama, nomor){
    		this.id = id;
    		this.nama = nama;
    		this.nomor = nomor;
    	}

    	var PenelitiAsing = function(id, nama, institusi, tugas, telp){
    		this.id = id;
    		this.nama = nama;
    		this.institusi = institusi;
    		this.tugas = tugas;
    		this.telp = telp;
    	}

    	var PengajuanModel = function(){
    		var self = this;
    		self.id = ko.observable(<?php echo isset($data['id_pengajuan']) ? $data['id_pengajuan'] : 0 ?>);
    		self.id_kepk = <?php echo isset($kepk['id_kepk']) ? $kepk['id_kepk'] : 0 ?>;
        self.nama_kepk = '<?php echo isset($kepk['nama_kepk']) ? $kepk['nama_kepk'] : "" ?>';
    		self.nama_bank = '<?php echo isset($kepk['nama_bank']) ? $kepk['nama_bank'] : "" ?>';
    		self.no_rekening = '<?php echo isset($kepk['no_rekening']) ? $kepk['no_rekening'] : "" ?>';
    		self.pemilik_rekening = '<?php echo isset($kepk['pemilik_rekening']) ? $kepk['pemilik_rekening'] : "" ?>';
    		self.swift_code = '<?php echo isset($kepk['swift_code']) ? $kepk['swift_code'] : "" ?>';
        self.tarif_telaah = ko.observable('<?php echo isset($data['tarif_telaah']) ? number_format($data['tarif_telaah'],2,",",".") : "" ?>');
    		self.jns_penelitian = ko.observable('<?php echo isset($data['jenis_penelitian']) ? $data['jenis_penelitian'] : "" ?>');
    		self.asal_pengusul = ko.observable('<?php echo isset($data['asal_pengusul']) ? $data['asal_pengusul'] : "" ?>');
    		self.jns_lembaga = ko.observable('<?php echo isset($data['jenis_lembaga']) ? $data['jenis_lembaga'] : "" ?>');
    		self.status_pengusul = ko.observable('<?php echo isset($data['status_pengusul']) ? $data['status_pengusul'] : "" ?>');
    		self.strata_pend = ko.observable('<?php echo isset($data['strata_pendidikan']) ? $data['strata_pendidikan'] : "" ?>');
    		self.judul = ko.observable(<?php echo isset($data['judul']) ? json_encode($data['judul']) : "" ?>);
    		self.title = ko.observable(<?php echo isset($data['title']) ? json_encode($data['title']) : "" ?>);
    		self.nm_ketua = ko.observable(<?php echo isset($data['nama_ketua']) ? json_encode($data['nama_ketua']) : "" ?>);
    		self.telp_peneliti = ko.observable('<?php echo isset($data['telp_peneliti']) ? $data['telp_peneliti'] : "" ?>');
    		self.email_peneliti = ko.observable('<?php echo isset($data['email_peneliti']) ? $data['email_peneliti'] : "" ?>');
    		self.anggota_peneliti = ko.observableArray([new AnggotaPenelitan(0, '', '')]);
    		self.addAnggotaPeneliti = function(){
    			var id = getNewid();
    			self.anggota_peneliti.push(new AnggotaPenelitan(id, '', ''));
    		};
    		self.removeAnggotaPeneliti = function(anggota){
    			self.anggota_peneliti.remove(anggota);
    			purge_anggota_peneliti.push(anggota.id);
    		}
    		self.komunikasi = ko.observableArray([]);
    		self.nm_institusi = ko.observable(<?php echo isset($data['nama_institusi']) ? json_encode($data['nama_institusi']) : "" ?>);
    		self.alm_inst = ko.observable(<?php echo isset($data['alamat_institusi']) ? json_encode($data['alamat_institusi']) : "" ?>);
    		self.telp_inst = ko.observable('<?php echo isset($data['telp_institusi']) ? $data['telp_institusi'] : "" ?>');
    		self.email_inst = ko.observable('<?php echo isset($data['email_institusi']) ? $data['email_institusi'] : "" ?>');
    		self.sumber_dana = ko.observable('<?php echo isset($data['sumber_dana']) ? $data['sumber_dana'] : "" ?>');
    		self.total_dana = ko.observable('<?php echo isset($data['total_dana']) ? $data['total_dana'] : "" ?>');
    		self.penelitian = ko.observable('<?php echo isset($data['penelitian']) ? $data['penelitian'] : "" ?>');
    		self.jml_negara = ko.observable(<?php echo isset($data['jml_negara']) ? $data['jml_negara'] : "" ?>);
    		self.peneliti_asing = ko.observableArray([new PenelitiAsing(0, '', '', '', '')]);
    		self.addPenelitiAsing = function(){
    			var id = getNewid();
    			self.peneliti_asing.push(new PenelitiAsing(id, '', '', '', ''));
    		};
    		self.removePenelitiAsing = function(peneliti){
    			self.peneliti_asing.remove(peneliti);
    			purge_peneliti_asing.push(peneliti.id);
    		}
    		self.tempat_penelitian = ko.observable(<?php echo isset($data['tempat_penelitian']) ? json_encode($data['tempat_penelitian']) : "" ?>);
    		self.waktu_mulai = ko.observable('<?php echo isset($data['waktu_mulai']) ? date('d/m/Y', strtotime($data['waktu_mulai'])) : "" ?>');
    		self.waktu_selesai = ko.observable('<?php echo isset($data['waktu_selesai']) ? date('d/m/Y', strtotime($data['waktu_selesai'])) : "" ?>');
    		self.is_multi_senter = ko.observable(<?php echo isset($data['is_multi_senter']) ? $data['is_multi_senter'] : "" ?>);
    		self.is_setuju_senter = ko.observable(<?php echo isset($data['is_setuju_senter']) ? $data['is_setuju_senter'] : "" ?>);
    		self.tempat_multi_senter = ko.observable(<?php echo isset($data['tempat_multi_senter']) ? json_encode($data['tempat_multi_senter']) : "" ?>);

    		self.id_sp = ko.observable(<?php echo isset($sp['id_sp']) ? $sp['id_sp'] : 0?>);
    		self.no_sp = ko.observable('<?php echo isset($sp['nomor']) ? $sp['nomor'] : ''?>');
    		self.tgl_sp = ko.observable('<?php echo isset($sp['tanggal']) ? date('d/m/Y', strtotime($sp['tanggal'])) : ''?>');
    		self.client_name_sp = ko.observable('<?php echo isset($sp['client_name']) ? $sp['client_name'] : ''?>');
    		self.file_name_sp = ko.observable('<?php echo isset($sp['file_name']) ? $sp['file_name'] : ''?>');
    		self.file_size_sp = ko.observable('<?php echo isset($sp['file_size']) ? $sp['file_size'] : ''?>');
    		self.file_type_sp = ko.observable('<?php echo isset($sp['file_type']) ? $sp['file_type'] : ''?>');
    		self.file_ext_sp = ko.observable('<?php echo isset($sp['file_ext']) ? $sp['file_ext'] : ''?>');

    		self.id_bb = ko.observable(<?php echo isset($bb['id_bb']) ? $bb['id_bb'] : 0?>);
    		self.no_bb = ko.observable('<?php echo isset($bb['nomor']) ? $bb['nomor'] : ''?>');
    		self.tgl_bb = ko.observable('<?php echo isset($bb['tanggal']) ? date('d/m/Y', strtotime($bb['tanggal'])) : ''?>');
    		self.client_name_bb = ko.observable('<?php echo isset($bb['client_name']) ? $bb['client_name'] : ''?>');
    		self.file_name_bb = ko.observable('<?php echo isset($bb['file_name']) ? $bb['file_name'] : ''?>');
    		self.file_size_bb = ko.observable('<?php echo isset($bb['file_size']) ? $bb['file_size'] : ''?>');
    		self.file_type_bb = ko.observable('<?php echo isset($bb['file_type']) ? $bb['file_type'] : ''?>');
    		self.file_ext_bb = ko.observable('<?php echo isset($bb['file_ext']) ? $bb['file_ext'] : ''?>');
    		self.inserted = '<?php echo isset($data['inserted']) ? date('Y-m-d', strtotime($data['inserted'])) : date('Y-m-d') ?>'

    		self.processing = ko.observable(false);
    	}

    	var App = new PengajuanModel();

      App.jns_penelitian.subscribe(function(newValue){
        App.get_tarif_telaah();
      })

      App.asal_pengusul.subscribe(function(newValue){
        App.get_tarif_telaah();
      })

      App.jns_lembaga.subscribe(function(newValue){
        App.get_tarif_telaah();
      })

      App.status_pengusul.subscribe(function(newValue){
        App.get_tarif_telaah();
      })

      App.strata_pend.subscribe(function(newValue){
        App.get_tarif_telaah();
      })

      App.get_tarif_telaah = function(){
        if (App.id() == 0)
        {
          var id_kepk = App.id_kepk,
              jns_penelitian = App.jns_penelitian() !== '' ? App.jns_penelitian() : 0,
              asal_pengusul = App.asal_pengusul() !== '' ? App.asal_pengusul() : 0,
              jns_lembaga = App.jns_lembaga() !== '' ? App.jns_lembaga() : 0,
              status_pengusul = App.status_pengusul() !== '' ? App.status_pengusul() : 0,
              strata_pend = App.strata_pend() !== '' ? App.strata_pend() : 0;
          $.ajax({
            url: '<?php echo base_url()?>pengajuan/get_tarif_telaah_by_param/'+id_kepk+'/'+jns_penelitian+'/'+asal_pengusul+'/'+jns_lembaga+'/'+status_pengusul+'/'+strata_pend,
            type: 'post',
            cache: false,
            dataType: 'json',
            success: function(res, xhr){
              App.tarif_telaah(res.tarif_telaah);
            }
          });
        }
      }

    	App.init_anggota = function(){
    		if (App.id() > 0)
    		{
    	    var id = App.id();
    	    App.anggota_peneliti.removeAll();
    			$.ajax({
    		    url: '<?php echo base_url()?>pengajuan/get_anggota_by_id/'+id,
    		    type: 'post',
    		    cache: false,
    		    dataType: 'json',
    		    success: function(res, xhr){
    	        $.each(res, function(i, item){
    	          App.anggota_peneliti.push(new AnggotaPenelitan(res[i].id, res[i].nama, res[i].nomor));
    	        });
    		    }
    			})
    		}
    	}

    	App.init_pa = function(){
    		if (App.id() > 0)
    		{
    	    var id = App.id();
    	    App.peneliti_asing.removeAll();
    			$.ajax({
    		    url: '<?php echo base_url()?>pengajuan/get_pa_by_id/'+id,
    		    type: 'post',
    		    cache: false,
    		    dataType: 'json',
    		    success: function(res, xhr){
    	        $.each(res, function(i, item){
    	          App.peneliti_asing.push(new PenelitiAsing(res[i].id, res[i].nama, res[i].institusi, res[i].tugas, res[i].telp));
    	        });
    		    }
    			})
    		}
    	}

    	App.upload = function(file){
    	  $('#'+file).trigger('click');
    	}

    	App.do_upload = function(file){
    	  var data_upload = new FormData();
    	  data_upload.append(file, $('#'+file).prop('files')[0]);

    	  if (file == 'sp'){
    	  	$('#btn_sp').button('loading');
    	  }
    	  else if (file == 'bb'){
    	  	$('#btn_bb').button('loading');
    	  }

    	  $.ajax({
    	    url: '<?php echo base_url()?>pengajuan/do_upload/'+file,
    	    type: 'post',
    	    processData: false, // important
    	    contentType: false, // important
    	    dataType : 'json',
    	    data: data_upload,
    	    success: function(res, xhr){
    	      if (res.isSuccess){
    	      	if (res.file == 'sp'){
    	        	App.client_name_sp(res.data_fileupload.client_name);
    	        	App.file_name_sp(res.data_fileupload.file_name);
    	        	App.file_size_sp(res.data_fileupload.file_size);
    	        	App.file_type_sp(res.data_fileupload.file_type);
    	        	App.file_ext_sp(res.data_fileupload.file_ext);
    	      	}
    	      	else if (res.file = 'bb'){
    	        	App.client_name_bb(res.data_fileupload.client_name);
    	        	App.file_name_bb(res.data_fileupload.file_name);
    	        	App.file_size_bb(res.data_fileupload.file_size);
    	        	App.file_type_bb(res.data_fileupload.file_type);
    	        	App.file_ext_bb(res.data_fileupload.file_ext);
    	      	}
    	      }
    	    	else show_error(true, res.message);

    			  if (file == 'sp'){
    			  	$('#btn_sp').button('reset');
    			  }
    			  else if (file == 'bb'){
    			  	$('#btn_bb').button('reset');
    			  }
    	    }
    	  });
    	}

    	App.back = function(){
    		window.location.href = '<?php echo base_url()?>pengajuan/';
    	}

    	App.lanjut = function(){
    		window.location.href = '<?php echo base_url()?>protokol/form/';
    	}

    	App.save = function(createNew){
    	  var data = JSON.parse(ko.toJSON(App));
    	      data['anggota_peneliti'] = JSON.stringify(ko.toJS(App.anggota_peneliti()));
    	      data['peneliti_asing'] = JSON.stringify(ko.toJS(App.peneliti_asing()));
    	      data['purge_anggota_peneliti'] = purge_anggota_peneliti;
    	      data['purge_peneliti_asing'] = purge_peneliti_asing;
    	  var $btn = $('#submit');

    	  $btn.button('loading');
    	  App.processing(true);
    	  $.ajax({
    	    url: '<?php echo base_url()?>pengajuan/proses',
    	    type: 'post',
    	    cache: false,
    	    dataType: 'json',
    	    data: data,
    	    success: function(res, xhr){
    	      if (res.isSuccess){
    	      	show_success(true, res.message);
    	      	App.id(res.id);
    	      	App.init_anggota();
    	      	App.init_pa();
    	      }
    	      else show_error(true, res.message);

    	      $btn.button('reset');
    	      App.processing(false);
    	    }
    	  });

    	}

    	ko.applyBindings(App);

    <?php if (isset($data['id_pengajuan']) && $data['id_pengajuan'] > 0) { ?>
    	App.init_anggota();
    	App.init_pa();
    <?php 
    	$komunikasi = explode(",", $data['komunikasi']);
    	for ($i=0; $i<count($komunikasi); $i++) {
    ?>
    		App.komunikasi.push('<?php echo $komunikasi[$i]?>');
    <?php
    	}
    } 
    ?>

    </script>
