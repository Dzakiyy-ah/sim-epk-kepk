    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
    <script src="<?php echo base_url()?>assets/js/select2.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/id.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap-datepicker.id.js"></script>
    <script src="<?php echo base_url()?>assets/js/wizard.min.js"></script>
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
    	
    		var $validation = false;
    		$('#fuelux-wizard-container')
    		.ace_wizard({
    			//step: 2 //optional argument. wizard will jump to step "2" at first
    			//buttons: '.wizard-actions:eq(0)'
    		})
    		.on('actionclicked.fu.wizard' , function(e, info){
    			if(info.step == 1 && $validation) {
    				if(!$('#validation-form').valid()) e.preventDefault();
    			}
          $("html, body").animate({ scrollTop: $("#fuelux-wizard-container").offset().top }, "slow");

    			if (info.step == 6){
    				$('.btn-next').attr('disabled', true);
    			}

    			if (info.step == 7 && info.direction == 'previous'){
    				$('.btn-next').removeAttr('disabled');				
    			}
    		})
    		.on('finished.fu.wizard', function(e) {
    		})
    		.on('stepclick.fu.wizard', function(e){
    			//e.preventDefault();//this will prevent clicking and selecting steps
    		});
    					
    		$('#modal-wizard-container').ace_wizard();
    		$('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');

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

    			App.get_standar_kelaikan();
    		})

    		<?php if (isset($_GET['id_pep'])) { ?>
    			var id_pep = <?php echo $_GET['id_pep'] ?>;
    			$('#id_pep').val(id_pep).trigger('change.select2');
    			App.id_pep(id_pep);
    		<?php } ?>

    	});

    	var SKEP = function(id, no_tampilan, no, idx_std, parent, child, level, uraian, uraian_master, pil_pengaju, pil_penelaah, just_header){
    		this.id = id;
    		this.no_tampilan = no_tampilan;
    		this.no = no;
    		this.idx_std = idx_std;
    		this.parent = parent;
    		this.child = child;
    		this.level = level;
    		this.uraian = uraian;
    		this.uraian_master = uraian_master;
    		this.pil_pengaju = pil_pengaju;
    		this.pil_penelaah = pil_penelaah;
    		this.just_header = just_header;
    	}

    	var CetakModel = function(){
    		var self = this;
    		self.id = ko.observable(<?php echo isset($data['id_ethical_approval']) ? $data['id_ethical_approval'] : 0?>);
    		self.id_pep = ko.observable(<?php echo isset($data['id_pep']) ? $data['id_pep'] : 0 ?>);
    		self.no_protokol = ko.observable('<?php echo isset($data['no_protokol']) ? $data['no_protokol'] : ''?>');
    		self.no_surat = ko.observable('<?php echo isset($data['no_surat']) ? $data['no_surat'] : ''?>');
    		self.no_dokumen = ko.observable('<?php echo isset($data['no_dokumen']) ? $data['no_dokumen'] : ''?>');
    		self.tgl_surat = ko.observable('<?php echo isset($data['tanggal_surat']) ? date('d-m-Y', strtotime($data['tanggal_surat'])) : ''?>');
    		self.awal_berlaku = ko.observable('<?php echo isset($data['awal_berlaku']) ? date('d-m-Y', strtotime($data['awal_berlaku'])) : ''?>');
    		self.akhir_berlaku = ko.observable('<?php echo isset($data['akhir_berlaku']) ? date('d-m-Y', strtotime($data['akhir_berlaku'])) : ''?>');
    		self.klasifikasi = ko.observable('<?php echo isset($data['klasifikasi']) ? $data['klasifikasi'] : ''?>');
    		self.keputusan = ko.observable('<?php echo isset($data['keputusan']) ? $data['keputusan'] : ''?>');
    		self.self_assesment1 = ko.observableArray([]);
    		self.self_assesment2 = ko.observableArray([]);
    		self.self_assesment3 = ko.observableArray([]);
    		self.self_assesment4 = ko.observableArray([]);
    		self.self_assesment5 = ko.observableArray([]);
    		self.self_assesment6 = ko.observableArray([]);
    		self.self_assesment7 = ko.observableArray([]);
    		self.is_kirim = ko.observable(<?php echo isset($is_kirim) ? $is_kirim : 0 ?>);
    		self.lbl_btn_kirim = ko.pureComputed(function(){
    			if (self.is_kirim() == 1) 
    				return 'Terkirim';

    			return 'Kirim';
    		});
    		self.processing = ko.observable(false);
    	}

    	var App = new CetakModel();

    	App.get_standar_kelaikan = function(){
    		var id_pep = App.id_pep();
    		$.ajax({
    			url: '<?php echo base_url()?>surat_persetujuan/get_standar_kelaikan/'+id_pep,
    			type: 'post',
    			cache: false,
    			dataType: 'json',
    			success: function(res, xhr){
    				if (res.length > 0)
    				{
    					App.self_assesment1.removeAll();
    					App.self_assesment2.removeAll();
    					App.self_assesment3.removeAll();
    					App.self_assesment4.removeAll();
    					App.self_assesment5.removeAll();
    					App.self_assesment6.removeAll();
    					App.self_assesment7.removeAll();

    					$.each(res, function(i, item){
    						if (item.idx_std == 1){
    			     		App.self_assesment1.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_penelaah, item.just_header) );
    						}
    						else if (item.idx_std == 2){
    			     		App.self_assesment2.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian,item.uraian_master, item.pil_pengaju, item.pil_penelaah, item.just_header) );
    						}
    						else if (item.idx_std == 3){
    			     		App.self_assesment3.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_penelaah, item.just_header) );
    						}
    						else if (item.idx_std == 4){
    			     		App.self_assesment4.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_penelaah, item.just_header) );
    						}
    						else if (item.idx_std == 5){
    			     		App.self_assesment5.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_penelaah, item.just_header) );
    						}
    						else if (item.idx_std == 6){
    			     		App.self_assesment6.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_penelaah, item.just_header) );
    						}
    						else if (item.idx_std == 7){
    			     		App.self_assesment7.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_penelaah, item.just_header) );
    						}
    			    });			
    				}
    			}
    		})
    	}

    	App.save = function(createNew){
    	  var data = new Object();
						data['id'] = App.id();
						data['id_pep'] = App.id_pep();
						data['no_protokol'] = App.no_protokol();
						data['no_surat'] = App.no_surat();
						data['tgl_surat'] = App.tgl_surat();
						data['awal_berlaku'] = App.awal_berlaku();
						data['akhir_berlaku'] = App.akhir_berlaku();
    	  var $btn = $('#submit');

    	  $btn.button('loading');
    	  App.processing(true);
    	  $.ajax({
    	    url: '<?php echo base_url()?>surat_persetujuan/proses',
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
    		window.location.href = '<?php echo base_url()?>surat_persetujuan/';
    	}

    	App.print = function(){
    		var id = App.id();
    		window.open('<?php echo base_url()?>surat_persetujuan/cetak_surat/'+id, '_blank');
    	}

    	App.print_sa = function(){
    		var id = App.id(), 
    				id_pep = App.id_pep();

				if (id > 0)
	    		window.open('<?php echo base_url()?>surat_persetujuan/cetak_sa/'+id+'/'+id_pep, '_blank');
				else
					show_error(true, 'Data belum disimpan');
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
    				    url: '<?php echo base_url()?>surat_persetujuan/kirim/',
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

    <?php if (isset($data['id_ethical_approval']) && $data['id_ethical_approval'] > 0) { ?>
    	App.get_standar_kelaikan();
    <?php } ?>
    </script>
