    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
    <script src="<?php echo base_url()?>assets/js/select2.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap-datepicker.id.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap-timepicker.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/moment.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/id.js"></script>
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

        $('#jam_fb').timepicker({
          minuteStep: 1,
          showSeconds: false,
          showMeridian: false,
          disableFocus: true,
          icons: {
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down'
          }
        }).on('focus', function() {
          $('#jam_fb').timepicker('showWidget');
        }).next().on(ace.click_event, function(){
          $(this).prev().focus();
        });

        <?php if (isset($_GET['id_pep'])) { ?>
          var id_pep = <?php echo $_GET['id_pep'] ?>;
          $('#id_pep').val(id_pep).trigger('change.select2');
          App.id_pep(id_pep);
          var pep = $('#id_pep').text().trim();
              res = pep.split(' - ');

          App.no_protokol(res[0]);
          App.judul(res[1]);
          App.get_pengajuan_by_id_pep();
          App.get_anggota_penelitian_by_id_pep();
          App.get_penelaah_fullboard_by_id_pep();
          App.get_lay_person_fullboard_by_id_pep();
        <?php } ?>


        $('#id_pep').on('select2:select', function(e){
          var pep = $('#id_pep').text().trim();
              res = pep.split(' - ');

          App.no_protokol(res[0]);
          App.judul(res[1]);
          App.get_pengajuan_by_id_pep();
          App.get_anggota_penelitian_by_id_pep();
          App.get_penelaah_fullboard_by_id_pep();
          App.get_lay_person_fullboard_by_id_pep();
        })

    	});

    	var PemberitahuanFullboardModel = function(){
    		var self = this;
    		self.id = ko.observable(<?php echo isset($data['id_bfbd']) ? $data['id_bfbd'] : 0?>);
    		self.id_pep = ko.observable(<?php echo isset($data['id_pep']) ? $data['id_pep'] : 0 ?>);
    		self.no_protokol = ko.observable('<?php echo isset($data['no_protokol']) ? $data['no_protokol'] : ""?>');
        self.judul = ko.observable(<?php echo isset($data['judul']) ? json_encode($data['judul']) : ""?>);
    		self.nama_ketua = ko.observable('<?php echo isset($data['nama_ketua']) ? $data['nama_ketua'] : ""?>');
    		self.telp_peneliti = ko.observable('<?php echo isset($data['telp_peneliti']) ? $data['telp_peneliti'] : ""?>');
    		self.email_peneliti = ko.observable('<?php echo isset($data['email_peneliti']) ? $data['email_peneliti'] : ""?>');
    		self.nama_institusi = ko.observable('<?php echo isset($data['nama_institusi']) ? $data['nama_institusi'] : ""?>');
    		self.alamat_institusi = ko.observable('<?php echo isset($data['alamat_institusi']) ? $data['alamat_institusi'] : ""?>');
    		self.telp_institusi = ko.observable('<?php echo isset($data['telp_institusi']) ? $data['telp_institusi'] : ""?>');
    		self.email_institusi = ko.observable('<?php echo isset($data['email_institusi']) ? $data['email_institusi'] : ""?>');

        self.tgl_fb = ko.observable('<?php echo isset($data['tgl_fullboard']) ? date('d-m-Y', strtotime($data['tgl_fullboard'])) : ""?>');
        self.jam_fb = ko.observable('<?php echo isset($data['jam_fullboard']) ? $data['jam_fullboard'] : ""?>');
        self.tempat_fb = ko.observable('<?php echo isset($data['tempat_fullboard']) ? $data['tempat_fullboard'] : ""?>');

    		self.anggota = ko.observableArray([]);
        self.penelaah = ko.observableArray([]);
        self.lay_person = ko.observableArray([]);
    		self.is_kirim = ko.observable(<?php echo isset($is_kirim) ? $is_kirim : 0 ?>);
    		self.lbl_btn_kirim = ko.pureComputed(function(){
    			if (self.is_kirim() == 1) 
    				return 'Terkirim';

    			return 'Kirim';
    		});
    		self.processing = ko.observable(false);
    	}

    	var App = new PemberitahuanFullboardModel();

    	App.get_pengajuan_by_id_pep = function(){
    		var id_pep = App.id_pep();
    		$.ajax({
    			url: '<?php echo base_url()?>pemberitahuan_fullboard/get_pengajuan_by_id_pep/'+id_pep,
    			type: 'post',
    			dataType: 'json',
    			success: function(res, xhr){
    				App.nama_ketua(res.nama_ketua);
    				App.telp_peneliti(res.telp_peneliti);
    				App.email_peneliti(res.email_peneliti);
    				App.nama_institusi(res.nama_institusi);
    				App.alamat_institusi(res.alamat_institusi);
    				App.telp_institusi(res.telp_institusi);
    				App.email_institusi(res.email_institusi);
    			}
    		});
    	}

    	App.get_anggota_penelitian_by_id_pep = function(){
    		var id_pep = App.id_pep();
    		$.ajax({
    			url: '<?php echo base_url()?>pemberitahuan_fullboard/get_anggota_penelitian_by_id_pep/'+id_pep,
    			type: 'post',
    			dataType: 'json',
    			success: function(res, xhr){
    					$.each(res, function(i, item){
    			  		App.anggota.push({nama_anggota: res[i].nama});  
    					});
    			}
    		});
    	}

      App.get_penelaah_fullboard_by_id_pep = function(){
        var id_pep = App.id_pep();
        $.ajax({
          url: '<?php echo base_url()?>pemberitahuan_fullboard/get_penelaah_fullboard_by_id_pep/'+id_pep,
          type: 'post',
          dataType: 'json',
          success: function(res, xhr){
              $.each(res, function(i, item){
                App.penelaah.push({nama_penelaah: res[i].nama});  
              });
          }
        });
      }

      App.get_lay_person_fullboard_by_id_pep = function(){
        var id_pep = App.id_pep();
        $.ajax({
          url: '<?php echo base_url()?>pemberitahuan_fullboard/get_lay_person_fullboard_by_id_pep/'+id_pep,
          type: 'post',
          dataType: 'json',
          success: function(res, xhr){
              $.each(res, function(i, item){
                App.lay_person.push({nama_lay_person: res[i].nama});  
              });
          }
        });
      }

      App.print = function(){
        var id = App.id();
            id_pep = App.id_pep();
        window.open('<?php echo base_url()?>pemberitahuan_fullboard/cetak_surat/'+id+'/'+id_pep, '_blank');
      }

    	App.save = function(createNew){
    	  var data = JSON.parse(ko.toJSON(App));
    	  var $btn = $('#submit');

    	  $btn.button('loading');
    	  App.processing(true);
    	  $.ajax({
    	    url: '<?php echo base_url()?>pemberitahuan_fullboard/proses',
    	    type: 'post',
    	    cache: false,
    	    dataType: 'json',
    	    data: data,
    	    success: function(res, xhr){
    	      if (res.isSuccess){
    	      	App.id(res.id);
    	      	show_success(true, res.message);
    	      }
    	      else show_error(true, res.message);

    	      $btn.button('reset');
    	      App.processing(false);
    	    }
    	  });

    	}

    	App.back = function(){
    		window.location.href = '<?php echo base_url()?>pemberitahuan_fullboard/';
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
    				    url: '<?php echo base_url()?>pemberitahuan_fullboard/kirim/',
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

      <?php if (isset($data['id_bfbd']) && $data['id_bfbd'] > 0) { ?>
        App.get_pengajuan_by_id_pep();
        App.get_anggota_penelitian_by_id_pep();
        App.get_penelaah_fullboard_by_id_pep();
        App.get_lay_person_fullboard_by_id_pep();
      <?php } ?>

    </script>
