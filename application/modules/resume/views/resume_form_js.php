	<script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
    <script src="<?php echo base_url()?>assets/js/select2.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/id.js"></script>
    <script src="<?php echo base_url()?>assets/js/wizard.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.hotkeys.index.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap-wysiwyg.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/autosize.min.js"></script>

    <script type="text/javascript">
    	var purge_pe = [];
    	jQuery(function($) {
    		$('[data-rel=tooltip]').tooltip();
			
			autosize($('textarea[class*=autosize]'));

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
    		})
    		.on('finished.fu.wizard', function(e) {
    		})
    		.on('stepclick.fu.wizard', function(e){
    			//e.preventDefault();//this will prevent clicking and selecting steps
    		});
    					
    		$('#modal-wizard-container').ace_wizard();
    		$('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');

    		$('.wysiwyg-editor').ace_wysiwyg({
    			toolbar:
    			[
    				'font',
    				null,
    				'fontSize',
    				null,
    				{name:'bold', className:'btn-info'},
    				{name:'italic', className:'btn-info'},
    				{name:'strikethrough', className:'btn-info'},
    				{name:'underline', className:'btn-info'},
    				null,
    				{name:'insertunorderedlist', className:'btn-success'},
    				{name:'insertorderedlist', className:'btn-success'},
    				{name:'outdent', className:'btn-purple'},
    				{name:'indent', className:'btn-purple'},
    				null,
    				{name:'justifyleft', className:'btn-primary'},
    				{name:'justifycenter', className:'btn-primary'},
    				{name:'justifyright', className:'btn-primary'},
    				{name:'justifyfull', className:'btn-inverse'},
    				null,
    				{name:'createLink', className:'btn-pink'},
    				{name:'unlink', className:'btn-pink'},
    				null,
    				{name:'insertImage', className:'btn-success'},
    				null,
    				'foreColor',
    				null,
    				{name:'undo', className:'btn-grey'},
    				{name:'redo', className:'btn-grey'}
    			],
    			'wysiwyg': {
    				fileUploadError: showErrorAlert
    			}
    		}).prev().addClass('wysiwyg-style2');

        $(".select2").select2({
          placeholder: "Pilih...",
          language: "id",
          allowClear: true,
          width: '100%'
        });

        $('#penelaah_awal').on('select2:unselect', function(e){
          var id = e.params.data.id;
          if ($.inArray(id, purge_pe) < 0)
            purge_pe.push(id);
        })
        App.get_standar_kelaikan();

    		$('#resume').html(<?php if (isset($data['id_resume']) && $data['id_resume'] > 0) echo isset($data['resume']) ? json_encode($data['resume']) : ''; else echo json_encode($resume_default);?>);
    			
    	});

    	function showErrorAlert (reason, detail) {
    		var msg='';
    		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
    		else {
    			//console.log("error uploading file", reason, detail);
    		}
    		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
    		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
    	}

    	var SKEP = function(id, no_tampilan, no, idx_std, parent, child, level, uraian, uraian_master, pil, just_header){
    		this.id = id;
    		this.no_tampilan = no_tampilan;
    		this.no = no;
    		this.idx_std = idx_std;
    		this.parent = parent;
    		this.child = child;
    		this.level = level;
    		this.uraian = uraian;
    		this.uraian_master = uraian_master;
    		this.pil = pil;
    		this.just_header = just_header;
    	}

    	var ResumeModel = function(){
    		var self = this;
    		self.id = ko.observable(<?php echo isset($data['id_resume']) ? $data['id_resume'] : 0?>);
    		self.id_pengajuan = <?php echo isset($pengajuan['id_pengajuan']) ? $pengajuan['id_pengajuan'] : 0?>;
    		self.no_protokol = '<?php echo isset($pengajuan['no_protokol']) ? $pengajuan['no_protokol'] : ''?>';
    		self.judul = <?php echo isset($pengajuan['judul']) ? json_encode($pengajuan['judul']) : ''?>;
    		self.lokasi = <?php echo isset($pengajuan['tempat_penelitian']) ? json_encode($pengajuan['tempat_penelitian']) : ''?>;
    		self.is_multi_senter = '<?php echo isset($pengajuan['is_multi_senter']) ? $pengajuan['is_multi_senter'] : ''?>';
    		self.is_setuju_senter = '<?php echo isset($pengajuan['is_setuju_senter']) && $pengajuan['is_multi_senter'] == 1 ? $pengajuan['is_setuju_senter'] : ''?>';
    		self.processing = ko.observable(false);
    		self.id_pep = '<?php echo isset($pep['id_pep']) ? $pep['id_pep'] : 0 ?>';
    		self.sp = ko.observable(<?php echo isset($data['surat_pengantar_cek']) && $data['surat_pengantar_cek'] === '1' ? 'true' : 'false' ?>);
    		self.bb = ko.observable(<?php echo isset($data['bukti_bayar_cek']) && $data['bukti_bayar_cek'] == 1 ? 'true' : 'false' ?>);
    		self.pep = ko.observable(<?php echo isset($data['pep_cek']) && $data['pep_cek'] == 1 ? 'true' : 'false' ?>);
    		self.self_assesment = ko.observable(<?php echo isset($data['self_assesment_cek']) && $data['self_assesment_cek'] == 1 ? 'true' : 'false' ?>);
    		self.self_assesment1 = ko.observableArray([]);
    		self.self_assesment2 = ko.observableArray([]);
    		self.self_assesment3 = ko.observableArray([]);
    		self.self_assesment4 = ko.observableArray([]);
    		self.self_assesment5 = ko.observableArray([]);
    		self.self_assesment6 = ko.observableArray([]);
    		self.self_assesment7 = ko.observableArray([]);
    		self.keputusan = '<?php echo isset($pep['keputusan']) ? $pep['keputusan'] : '' ?>';
    		self.lbl_keputusan = ko.pureComputed(function(){
    			switch(self.keputusan){
    				case 'LE' : var lbl = 'Layak Etik'; break;
    				case 'R' : var lbl = 'Perbaikan'; break;
    				case 'F' : var lbl = 'Full Board'; break;
    			}

    			return lbl;
    		});
    		self.lanjut_telaah = ko.observable("<?php echo isset($data['lanjut_telaah']) ? $data['lanjut_telaah'] : '' ?>");
    		self.lanjut_telaah_old = "<?php echo isset($data['lanjut_telaah']) ? $data['lanjut_telaah'] : '' ?>";
    	  self.penelaah_awal = ko.observableArray([]);
			  self.alasan_tbd = ko.observable(<?php echo isset($data['alasan_tbd']) ? json_encode($data['alasan_tbd']) : '' ?>);
			  self.alasan_ditolak = ko.observable(<?php echo isset($data['alasan_ditolak']) ? json_encode($data['alasan_ditolak']) : '' ?>);
    	}

    	var App = new ResumeModel();

      App.showFile = function(path){
        sp = path.split('/');
        file_name = sp[1];
        $.ajax({
          url: '<?php echo base_url()?>resume/cek_file_upload_exist/'+file_name,
          type: 'post',
          cache: false,
          dataType: 'json',
          success: function(res, xhr){
            if (res.isSuccess)
            {
              $('#myModal').modal('show');
              html = '<embed width="100%" height="500px" src="<?php echo base_url()?>'+path+'">';
              $('#show_data_modal').html(html);
            }
            else
            {
              $('#myModal').modal('show');
              html = '<div class="alert alert-block alert-danger"><button class="close" type="button" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>File tidak ditemukan</div>';
              $('#show_data_modal').html(html);          
            }
          }
        });
      };

      App.get_standar_kelaikan = function(){
        var id_pep = App.id_pep;

        $.ajax({
          url: '<?php echo base_url()?>resume/get_standar_kelaikan/'+id_pep,
          type: 'post',
          cache: false,
          dataType: 'json',
          success: function(res, xhr){
            var skep = res;
            $.each(skep, function(i, item){
              if (item.idx_std == 1){
                App.self_assesment1.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pilihan, item.just_header) );
              }
              else if (item.idx_std == 2){
                App.self_assesment2.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian,item.uraian_master, item.pilihan, item.just_header) );
              }
              else if (item.idx_std == 3){
                App.self_assesment3.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pilihan, item.just_header) );
              }
              else if (item.idx_std == 4){
                App.self_assesment4.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pilihan, item.just_header) );
              }
              else if (item.idx_std == 5){
                App.self_assesment5.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pilihan, item.just_header) );
              }
              else if (item.idx_std == 6){
                App.self_assesment6.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pilihan, item.just_header) );
              }
              else if (item.idx_std == 7){
                App.self_assesment7.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pilihan, item.just_header) );
              }
            });
          }
        });

      }

			App.get_penelaah_awal = function(){
				var id = App.id();

        $.ajax({
          url: '<?php echo base_url()?>resume/get_penelaah_awal_by_id/'+id,
          type: 'post',
          cache: false,
          dataType: 'json',
          success: function(res, xhr){
            $.each(res, function(i, item){
              App.penelaah_awal.push(item.id_atk);
            });
						$('#penelaah_awal').trigger("change");
          }
        });
			}

    	App.print_protokol = function(){
    		var id_pep = App.id_pep;
    		window.open('<?php echo base_url()?>resume/cetak_protokol/'+id_pep, '_blank');
    	}

    	App.print_sa = function(){
    		var id_pep = App.id_pep;
    		window.open('<?php echo base_url()?>resume/cetak_sa/'+id_pep, '_blank');
    	}

    	App.save = function(createNew){
    	  var data = new Object();
    	  		data['id'] = App.id();
    	  		data['id_pep'] = App.id_pep;
    	  		data['resume'] = $('#resume').html();
    	  		data['sp'] = App.sp();
    	  		data['bb'] = App.bb();
    	  		data['pep'] = App.pep();
    	  		data['self_assesment'] = App.self_assesment();
            data['penelaah_awal'] = JSON.stringify(ko.toJS(App.penelaah_awal()));
            data['purge_pe'] = purge_pe;
            data['lanjut_telaah'] = App.lanjut_telaah();
            data['lanjut_telaah_old'] = App.lanjut_telaah_old;
            data['alasan_tbd'] = App.alasan_tbd();
            data['alasan_ditolak'] = App.alasan_ditolak();
            var $btn = $('#submit');

    	  $btn.button('loading');
    	  App.processing(true);
    	  $.ajax({
    	    url: '<?php echo base_url()?>resume/proses',
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
    		window.location.href = '<?php echo base_url()?>resume/';
    	}

    	ko.applyBindings(App);

			<?php if (isset($data['id_resume']) && $data['id_resume'] > 0) { ?>
			App.get_penelaah_awal();
			<?php } ?>
    </script>
