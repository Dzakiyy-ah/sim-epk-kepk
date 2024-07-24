    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
    <script src="<?php echo base_url()?>assets/js/select2.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/id.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap-datepicker.id.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootbox.js"></script>

    <script type="text/javascript">
    	var protokol = <?php echo isset($protokol) ? json_encode($protokol) : "" ?>;
    	jQuery(function($) {
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

    		$('.input-daterange').datepicker({autoclose:true, language: 'id'});

        $('#id_pep').change(function(){
          var pep = $('#id_pep').text().trim();
              res = pep.split(' - ');
          App.no_protokol(res[0]);
          $.each(protokol, function(i, item){
            if ($('#id_pep').val() == item.id_pep) {
              App.klasifikasi(item.klasifikasi);
              App.keputusan(item.keputusan);
            }
          })
          App.get_catatan_telaah();
          App.get_alasan_tbd();
        })

        <?php if (isset($_GET['id_pep'])) { ?>
          var id_pep = <?php echo $_GET['id_pep'] ?>;
          $('#id_pep').val(id_pep).trigger('change.select2');
          App.id_pep(id_pep);
        <?php } ?>
    	});

    	var CetakModel = function(){
    		var self = this;
    		self.id = ko.observable(<?php echo isset($data['id_ethical_revision']) ? $data['id_ethical_revision'] : 0?>);
    		self.id_pep = ko.observable(<?php echo isset($data['id_pep']) ? $data['id_pep'] : 0 ?>);
    		self.no_protokol = ko.observable('<?php echo isset($data['no_protokol']) ? $data['no_protokol'] : ''?>');
    		self.no_surat = ko.observable('<?php echo isset($data['no_surat']) ? $data['no_surat'] : ''?>');
    		self.no_dokumen = ko.observable('<?php echo isset($data['no_dokumen']) ? $data['no_dokumen'] : ''?>');
    		self.tgl_surat = ko.observable('<?php echo isset($data['tanggal_surat']) ? date('d-m-Y', strtotime($data['tanggal_surat'])) : ''?>');
    		self.awal_berlaku = ko.observable('<?php echo isset($data['awal_berlaku']) ? date('d-m-Y', strtotime($data['awal_berlaku'])) : ''?>');
    		self.akhir_berlaku = ko.observable('<?php echo isset($data['akhir_berlaku']) ? date('d-m-Y', strtotime($data['akhir_berlaku'])) : ''?>');
    		self.klasifikasi = ko.observable('<?php echo isset($data['klasifikasi']) ? $data['klasifikasi'] : ''?>');
    		self.keputusan = ko.observable('<?php echo isset($data['keputusan']) ? $data['keputusan'] : ''?>');
    		self.ringkasan = ko.observable(<?php echo isset($data['ringkasan']) ? stripcslashes(json_encode($data['ringkasan'])) : ""?>);
        self.catatan_telaah = ko.observableArray([]);
        self.alasan_tbd = ko.observable('');
    		self.is_kirim = ko.observable(<?php echo isset($is_kirim) ? $is_kirim : 0 ?>);
    		self.lbl_btn_kirim = ko.pureComputed(function(){
    			if (self.is_kirim() == 1) 
    				return 'Terkirim';

    			return 'Kirim';
    		});
    		self.processing = ko.observable(false);
    	}

    	var App = new CetakModel();

      App.get_alasan_tbd = function(){
        var id_pep = App.id_pep();

        if (klasifikasi == 'Tidak Bisa Ditelaah'){
          $.ajax({
            url: '<?php echo base_url()?>surat_perbaikan/get_alasan_tbd_by_idpep/'+id_pep,
            type: 'post',
            cache: false,
            dataType: 'json',
            success: function(res, xhr){
              App.alasan_tbd(res.alasan_tbd);
            }
          })
        }
      }

      App.get_catatan_telaah = function(){
        var id_pep = App.id_pep();
            klasifikasi = App.klasifikasi();

        App.catatan_telaah.removeAll();
        if (klasifikasi == 'Expedited')
        {
          $.ajax({
            url: '<?php echo base_url()?>surat_perbaikan/get_telaah_expedited_by_idpep/'+id_pep,
            type: 'post',
            cache: false,
            dataType: 'json',
            success: function(res, xhr){
              $.each(res, function(i, item){
                App.catatan_telaah.push({id: item.id, catatan_protokol: item.catatan_protokol, catatan_7standar: item.catatan_7standar});
              });
            }
          });
        }
        else if (klasifikasi == 'Full Board')
        {
          $.ajax({
            url: '<?php echo base_url()?>surat_perbaikan/get_telaah_fullboard_by_idpep/'+id_pep,
            type: 'post',
            cache: false,
            dataType: 'json',
            success: function(res, xhr){
              $.each(res, function(i, item){
                App.catatan_telaah.push({id: item.id, catatan_protokol: item.catatan_protokol, catatan_7standar: item.catatan_7standar});
              });
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
    	    url: '<?php echo base_url()?>surat_perbaikan/proses',
    	    type: 'post',
    	    cache: false,
    	    dataType: 'json',
    	    data: data,
    	    success: function(res, xhr){
    	      if (res.isSuccess){
    	      	App.id(res.id);
              App.no_dokumen(res.no_dokumen);
    	      	show_success(true, res.message);
    	      }
    	      else show_error(true, res.message);

    	      $btn.button('reset');
    	      App.processing(false);
    	    }
    	  });

    	}

    	App.back = function(){
    		window.location.href = '<?php echo base_url()?>surat_perbaikan/';
    	}

    	App.print = function(){
    		var id = App.id();
    		window.open('<?php echo base_url()?>surat_perbaikan/cetak_surat/'+id, '_blank');
    	}

    	App.print_telaah_alasan = function(){
    		var id = App.id();
            id_pep = App.id_pep();
            klasifikasi = App.klasifikasi();

        if (klasifikasi == 'Expedited')
      		window.open('<?php echo base_url()?>surat_perbaikan/cetak_catatan_expedited/'+id+'/'+id_pep, '_blank');
        else if (klasifikasi == 'Full Board')
          window.open('<?php echo base_url()?>surat_perbaikan/cetak_catatan_fullboard/'+id+'/'+id_pep, '_blank');
        else if (klasifikasi == 'Tidak Bisa Ditelaah')
          window.open('<?php echo base_url()?>surat_perbaikan/cetak_alasan_tbd/'+id+'/'+id_pep, '_blank');
    	}

    	App.print_sa = function(){
    		var id = App.id(), 
    				id_pep = App.id_pep();
    		window.open('<?php echo base_url()?>surat_perbaikan/cetak_sa/'+id+'/'+id_pep, '_blank');
    	}

    	App.kirim = function(){
    		bootbox.confirm({
    			message: "Apakah data sudah lengkap dan yakin untuk mengirim?",
    			buttons: {
    			  confirm: {
    				 label: "OK",
    				 className: "btn-primary btn-sm",
    			  },
    			  cancel: {
    				 label: "Batal",
    				 className: "btn-sm",
    			  }
    			},
    			callback: function(result) {
    				if(result) {
    				  var data = JSON.parse(ko.toJSON(App));
    				  var $btn = $('#kirim');

    				  $btn.button('loading');
    				  App.processing(true);
    				  $.ajax({
    				    url: '<?php echo base_url()?>surat_perbaikan/kirim/',
    				    type: 'post',
    				    cache: false,
    				    dataType: 'json',
    				    data: data,
    				    success: function(res, xhr){
    				      if (res.isSuccess){
    				      	App.is_kirim(1);
    				      	show_success(true, res.message);
    				      }
    				      else show_error(true, res.message);

    				      $btn.button('reset');
    				      App.processing(false);
    				    }
    				  });
    				}
    			}
    		});
    	}

      ko.applyBindings(App);

    <?php if (isset($data['id_ethical_revision']) && $data['id_ethical_revision'] > 0) { ?>
      App.get_catatan_telaah();
      App.get_alasan_tbd();
    <?php } ?>
    </script>
