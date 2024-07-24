    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
    <script src="<?php echo base_url()?>assets/js/wizard.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.hotkeys.index.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap-wysiwyg.min.js"></script>

    <script type="text/javascript">
    	jQuery(function($) {

    		$('[data-rel=tooltip]').tooltip();

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
          $('.nav-tabs a[href="#kelayakan-tab"]').tab('show');
    		})
    		.on('stepclick.fu.wizard', function(e){
    			//e.preventDefault();//this will prevent clicking and selecting steps
    		});
    					
    		$('#modal-wizard-container').ace_wizard();
    		$('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');

        $('#catatanA').html(<?php echo isset($data['catatana']) ? json_encode(stripslashes($data['catatana'])) : "" ?>);
        $('#catatanC').html(<?php echo isset($data['catatanc']) ? json_encode(stripslashes($data['catatanc'])) : "" ?>);
        $('#catatanD').html(<?php echo isset($data['catatand']) ? json_encode(stripslashes($data['catatand'])) : "" ?>);
        $('#catatanE').html(<?php echo isset($data['catatane']) ? json_encode(stripslashes($data['catatane'])) : "" ?>);
        $('#catatanF').html(<?php echo isset($data['catatanf']) ? json_encode(stripslashes($data['catatanf'])) : "" ?>);
        $('#catatanG').html(<?php echo isset($data['catatang']) ? json_encode(stripslashes($data['catatang'])) : "" ?>);
        $('#catatanH').html(<?php echo isset($data['catatanh']) ? json_encode(stripslashes($data['catatanh'])) : "" ?>);
        $('#catatanI').html(<?php echo isset($data['catatani']) ? json_encode(stripslashes($data['catatani'])) : "" ?>);
        $('#catatanJ').html(<?php echo isset($data['catatanj']) ? json_encode(stripslashes($data['catatanj'])) : "" ?>);
        $('#catatanK').html(<?php echo isset($data['catatank']) ? json_encode(stripslashes($data['catatank'])) : "" ?>);
        $('#catatanL').html(<?php echo isset($data['catatanl']) ? json_encode(stripslashes($data['catatanl'])) : "" ?>);
        $('#catatanM').html(<?php echo isset($data['catatanm']) ? json_encode(stripslashes($data['catatanm'])) : "" ?>);
        $('#catatanN').html(<?php echo isset($data['catatann']) ? json_encode(stripslashes($data['catatann'])) : "" ?>);
        $('#catatanO').html(<?php echo isset($data['catatano']) ? json_encode(stripslashes($data['catatano'])) : "" ?>);
        $('#catatanP').html(<?php echo isset($data['catatanp']) ? json_encode(stripslashes($data['catatanp'])) : "" ?>);
        $('#catatanQ').html(<?php echo isset($data['catatanq']) ? json_encode(stripslashes($data['catatanq'])) : "" ?>);
        $('#catatanR').html(<?php echo isset($data['catatanr']) ? json_encode(stripslashes($data['catatanr'])) : "" ?>);
        $('#catatanS').html(<?php echo isset($data['catatans']) ? json_encode(stripslashes($data['catatans'])) : "" ?>);
        $('#catatanT').html(<?php echo isset($data['catatant']) ? json_encode(stripslashes($data['catatant'])) : "" ?>);
        $('#catatanU').html(<?php echo isset($data['catatanu']) ? json_encode(stripslashes($data['catatanu'])) : "" ?>);
        $('#catatanV').html(<?php echo isset($data['catatanv']) ? json_encode(stripslashes($data['catatanv'])) : "" ?>);
        $('#catatanW').html(<?php echo isset($data['catatanw']) ? json_encode(stripslashes($data['catatanw'])) : "" ?>);
        $('#catatanX').html(<?php echo isset($data['catatanx']) ? json_encode(stripslashes($data['catatanx'])) : "" ?>);
        $('#catatanY').html(<?php echo isset($data['catatany']) ? json_encode(stripslashes($data['catatany'])) : "" ?>);
        $('#catatanZ').html(<?php echo isset($data['catatanz']) ? json_encode(stripslashes($data['catatanz'])) : "" ?>);
        $('#catatanAA').html(<?php echo isset($data['catatanaa']) ? json_encode(stripslashes($data['catatanaa'])) : "" ?>);
        $('#catatanBB').html(<?php echo isset($data['catatanbb']) ? json_encode(stripslashes($data['catatanbb'])) : "" ?>);
        $('#catatanCC').html(<?php echo isset($data['catatancc']) ? json_encode(stripslashes($data['catatancc'])) : "" ?>);
        $('#catatan_link_proposal').html(<?php echo isset($data['catatan_link_proposal']) ? json_encode(stripslashes($data['catatan_link_proposal'])) : "" ?>);              
        $('#catatan_protokol').html(<?php echo isset($data['catatan_protokol']) ? json_encode(stripslashes($data['catatan_protokol'])) : "" ?>);

    		$('#catatan1').html('<?php echo isset($data['catatan_sa1']) ? $data['catatan_sa1'] : ''?>');
    		$('#catatan2').html('<?php echo isset($data['catatan_sa2']) ? $data['catatan_sa2'] : ''?>');
    		$('#catatan3').html('<?php echo isset($data['catatan_sa3']) ? $data['catatan_sa3'] : ''?>');
    		$('#catatan4').html('<?php echo isset($data['catatan_sa4']) ? $data['catatan_sa4'] : ''?>');
    		$('#catatan5').html('<?php echo isset($data['catatan_sa5']) ? $data['catatan_sa5'] : ''?>');
    		$('#catatan6').html('<?php echo isset($data['catatan_sa6']) ? $data['catatan_sa6'] : ''?>');
    		$('#catatan7').html('<?php echo isset($data['catatan_sa7']) ? $data['catatan_sa7'] : ''?>');
        $('#catatan_7standar').html(<?php echo isset($data['catatan_7standar']) ? json_encode(stripslashes($data['catatan_7standar'])) : ""?>);

        App.get_standar_kelaikan();

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

      var SKEP = function(id, no_tampilan, no, idx_std, parent, child, level, uraian, uraian_master, pil_pengaju, pil_penelaah, cat_penelaah, just_header){
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
    		this.pil_penelaah = ko.observable(pil_penelaah);
        this.cat_penelaah = ko.observable(cat_penelaah);
    		this.just_header = just_header;
    	}

      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
      var UraianBefore = function(id, tgl, uraian){
        this.id = id;
        this.tgl = tgl;
        this.uraian = uraian;
      }

      var TelaahBefore = function(id, tgl, catatan){
        this.id = id;
        this.tgl = tgl;
        this.catatan = catatan;
      }
      <?php } ?>

    	var TelaahModel = function(){
    		var self = this;
    		self.id = ko.observable(<?php echo isset($data['id_texp']) ? $data['id_texp'] : 0?>);
    		self.id_pengajuan = <?php echo isset($pengajuan['id_pengajuan']) ? $pengajuan['id_pengajuan'] : 0?>;
    		self.no_protokol = '<?php echo isset($pengajuan['no_protokol']) ? $pengajuan['no_protokol'] : ''?>';
    		self.judul = <?php echo isset($pengajuan['judul']) ? json_encode($pengajuan['judul']) : ''?>;
    		self.lokasi = <?php echo isset($pengajuan['tempat_penelitian']) ? json_encode($pengajuan['tempat_penelitian']) : ''?>;
    		self.is_multi_senter = '<?php echo isset($pengajuan['is_multi_senter']) ? $pengajuan['is_multi_senter'] : ''?>';
    		self.is_setuju_senter = '<?php echo isset($pengajuan['is_setuju_senter']) && $pengajuan['is_multi_senter'] == 1 ? $pengajuan['is_setuju_senter'] : ''?>';
    		self.processing = ko.observable(false);
    		self.id_pep = '<?php echo isset($pep['id_pep']) ? $pep['id_pep'] : 0 ?>';
    		self.kelayakan = ko.observable('<?php echo isset($data['kelayakan']) ? $data['kelayakan'] : ''?>');
    		self.is_putusan = <?php echo isset($is_putusan) ? $is_putusan : 0 ?>;

    		/** =========== (1) ============== **/
    		self.self_assesment1 = ko.observableArray([]);
    		self.pilih1Ya = function(indx, parent){
    			$.each(self.self_assesment1(), function(i, item){
    				if (item.no == parent){
    					var pr = item.parent;
    					self.self_assesment1()[i].pil_penelaah('Ya');
    					$.each(self.self_assesment1(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment1()[ix].pil_penelaah('Ya');
    						}
    					});
    				}
    			});

    		}

    		self.pilih1Tidak = function(){
    			self.self_assesment1().reverse();
    			var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0;
    			$.each(self.self_assesment1(), function(i, item){
    				if (item.level == 2) {
    					pr2 = item.parent;
    					if (item.pil_penelaah() == 'Tidak') pil2--;
              else pil2 = 0;
    				}

    				if (item.level == 1) {
    					pr1 = item.parent;
    					if (Math.abs(pil2) == item.child && pr2 == item.no){
    						self.self_assesment1()[i].pil_penelaah('Tidak');
    					}
    					if (item.pil_penelaah() == 'Tidak'){
    						pil2 = 0;
    						pr2 = 0;
    						pil1--;
    					}
    				}

    				if (item.level == 0) {
    					if (Math.abs(pil1) == item.child && pr1 == item.no){
    						self.self_assesment1()[i].pil_penelaah('Tidak');
    					}
    					if (item.pil_penelaah() == 'Tidak'){
    						pil1 = 0;
    						pr1 = 0;
    					}
    				}

    			})
    			self.self_assesment1().reverse();
    		}
    		/** =========== (2) ============== **/
    		self.self_assesment2 = ko.observableArray([]);
    		self.pilih2Ya = function(indx, parent){
    			$.each(self.self_assesment2(), function(i, item){
    				if (item.no == parent){
    					var pr = item.parent;
    					self.self_assesment2()[i].pil_penelaah('Ya');
    					$.each(self.self_assesment2(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment2()[ix].pil_penelaah('Ya');
    						}
    					});
    				}
    			});

    		}

    		self.pilih2Tidak = function(){
    			self.self_assesment2().reverse();
    			var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0;
    			$.each(self.self_assesment2(), function(i, item){
    				if (item.level == 2) {
    					pr2 = item.parent;
    					if (item.pil_penelaah() == 'Tidak') pil2--;
              else pil2 = 0;
    				}

    				if (item.level == 1) {
    					pr1 = item.parent;
    					if (Math.abs(pil2) == item.child && pr2 == item.no){
    						self.self_assesment2()[i].pil_penelaah('Tidak');
    					}
    					if (item.pil_penelaah() == 'Tidak'){
    						pil2 = 0;
    						pr2 = 0;
    						pil1--;
    					}
    				}

    				if (item.level == 0) {
    					if (Math.abs(pil1) == item.child && pr1 == item.no){
    						self.self_assesment2()[i].pil('Tidak');
    					}
    					if (item.pil_penelaah() == 'Tidak'){
    						pil1 = 0;
    						pr1 = 0;
    					}
    				}

    			})
    			self.self_assesment2().reverse();
    		}

    		/** =========== (3) ============== **/
    		self.self_assesment3 = ko.observableArray([]);
    		self.pilih3Ya = function(indx, parent){
    			$.each(self.self_assesment3(), function(i, item){
    				if (item.no == parent){
    					var pr = item.parent;
    					self.self_assesment3()[i].pil_penelaah('Ya');
    					$.each(self.self_assesment3(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment3()[ix].pil_penelaah('Ya');
    						}
    					});
    				}
    			});

    		}

    		self.pilih3Tidak = function(){
    			self.self_assesment3().reverse();
    			var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0;
    			$.each(self.self_assesment3(), function(i, item){
    				if (item.level == 2) {
    					pr2 = item.parent;
    					if (item.pil_penelaah() == 'Tidak') pil2--;
              else pil2 = 0;
    				}

    				if (item.level == 1) {
    					pr1 = item.parent;
    					if (Math.abs(pil2) == item.child && pr2 == item.no){
    						self.self_assesment3()[i].pil_penelaah('Tidak');
    					}
    					if (item.pil_penelaah() == 'Tidak'){
    						pil2 = 0;
    						pr2 = 0;
    						pil1--;
    					}
    				}

    				if (item.level == 0) {
    					if (Math.abs(pil1) == item.child && pr1 == item.no){
    						self.self_assesment3()[i].pil_penelaah('Tidak');
    					}
    					if (item.pil_penelaah() == 'Tidak'){
    						pil1 = 0;
    						pr1 = 0;
    					}
    				}

    			})
    			self.self_assesment3().reverse();
    		}

    		/** =========== (4) ============== **/
    		self.self_assesment4 = ko.observableArray([]);
    		self.pilih4Ya = function(indx, parent){
    			$.each(self.self_assesment4(), function(i, item){
    				if (item.no == parent){
    					var pr = item.parent;
    					self.self_assesment4()[i].pil_penelaah('Ya');
    					$.each(self.self_assesment4(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment4()[ix].pil_penelaah('Ya');
    						}
    					});
    				}
    			});

    		}

    		self.pilih4Tidak = function(){
    			self.self_assesment4().reverse();
    			var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0;
    			$.each(self.self_assesment4(), function(i, item){
    				if (item.level == 2) {
    					pr2 = item.parent;
    					if (item.pil_penelaah() == 'Tidak') pil2--;
              else pil2 = 0;
    				}

    				if (item.level == 1) {
    					pr1 = item.parent;
    					if (Math.abs(pil2) == item.child && pr2 == item.no){
    						self.self_assesment4()[i].pil_penelaah('Tidak');
    					}
    					if (item.pil_penelaah() == 'Tidak'){
    						pil2 = 0;
    						pr2 = 0;
    						pil1--;
    					}
    				}

    				if (item.level == 0) {
    					if (Math.abs(pil1) == item.child && pr1 == item.no){
    						self.self_assesment4()[i].pil_penelaah('Tidak');
    					}
    					if (item.pil_penelaah() == 'Tidak'){
    						pil1 = 0;
    						pr1 = 0;
    					}
    				}

    			})
    			self.self_assesment4().reverse();
    		}

    		/** =========== (5) ============== **/
    		self.self_assesment5 = ko.observableArray([]);
    		self.pilih5Ya = function(indx, parent){
    			$.each(self.self_assesment5(), function(i, item){
    				if (item.no == parent){
    					var pr = item.parent;
    					self.self_assesment5()[i].pil_penelaah('Ya');
    					$.each(self.self_assesment5(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment5()[ix].pil_penelaah('Ya');
    						}
    					});
    				}
    			});

    		}

    		self.pilih5Tidak = function(){
    			self.self_assesment5().reverse();
    			var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0;
    			$.each(self.self_assesment5(), function(i, item){
    				if (item.level == 2) {
    					pr2 = item.parent;
    					if (item.pil_penelaah() == 'Tidak') pil2--;
              else pil2 = 0;
    				}

    				if (item.level == 1) {
    					pr1 = item.parent;
    					if (Math.abs(pil2) == item.child && pr2 == item.no){
    						self.self_assesment5()[i].pil_penelaah('Tidak');
    					}
    					if (item.pil_penelaah() == 'Tidak'){
    						pil2 = 0;
    						pr2 = 0;
    						pil1--;
    					}
    				}

    				if (item.level == 0) {
    					if (Math.abs(pil1) == item.child && pr1 == item.no){
    						self.self_assesment5()[i].pil_penelaah('Tidak');
    					}
    					if (item.pil_penelaah() == 'Tidak'){
    						pil1 = 0;
    						pr1 = 0;
    					}
    				}

    			})
    			self.self_assesment5().reverse();
    		}

    		/** =========== (6) ============== **/
    		self.self_assesment6 = ko.observableArray([]);
    		self.pilih6Ya = function(indx, parent){
    			$.each(self.self_assesment6(), function(i, item){
    				if (item.no == parent){
    					var pr = item.parent;
    					self.self_assesment6()[i].pil_penelaah('Ya');
    					$.each(self.self_assesment6(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment6()[ix].pil_penelaah('Ya');
    						}
    					});
    				}
    			});

    		}

    		self.pilih6Tidak = function(){
    			self.self_assesment6().reverse();
    			var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0;
    			$.each(self.self_assesment6(), function(i, item){
    				if (item.level == 2) {
    					pr2 = item.parent;
    					if (item.pil_penelaah() == 'Tidak') pil2--;
              else pil2 = 0;
    				}

    				if (item.level == 1) {
    					pr1 = item.parent;
    					if (Math.abs(pil2) == item.child && pr2 == item.no){
    						self.self_assesment6()[i].pil_penelaah('Tidak');
    					}
    					if (item.pil_penelaah() == 'Tidak'){
    						pil2 = 0;
    						pr2 = 0;
    						pil1--;
    					}
    				}

    				if (item.level == 0) {
    					if (Math.abs(pil1) == item.child && pr1 == item.no){
    						self.self_assesment6()[i].pil_penelaah('Tidak');
    					}
    					if (item.pil_penelaah() == 'Tidak'){
    						pil1 = 0;
    						pr1 = 0;
    					}
    				}

    			})
    			self.self_assesment6().reverse();
    		}

    		/** =========== (7) ============== **/
    		self.self_assesment7 = ko.observableArray([]);
    		self.pilih7Ya = function(indx, parent){
    			$.each(self.self_assesment7(), function(i, item){
    				if (item.no == parent){
    					var pr = item.parent;
    					self.self_assesment7()[i].pil_penelaah('Ya');
    					$.each(self.self_assesment7(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment7()[ix].pil_penelaah('Ya');
    						}
    					});
    				}
    			});

    		}

    		self.pilih7Tidak = function(){
    			self.self_assesment7().reverse();
    			var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0;
    			$.each(self.self_assesment7(), function(i, item){
    				if (item.level == 2) {
    					pr2 = item.parent;
    					if (item.pil_penelaah() == 'Tidak') pil2--;
              else pil2 = 0;
    				}

    				if (item.level == 1) {
    					pr1 = item.parent;
    					if (Math.abs(pil2) == item.child && pr2 == item.no){
    						self.self_assesment7()[i].pil_penelaah('Tidak');
    					}
    					if (item.pil_penelaah() == 'Tidak'){
    						pil2 = 0;
    						pr2 = 0;
    						pil1--;
    					}
    				}

    				if (item.level == 0) {
    					if (Math.abs(pil1) == item.child && pr1 == item.no){
    						self.self_assesment7()[i].pil_penelaah('Tidak');
    					}
    					if (item.pil_penelaah() == 'Tidak'){
    						pil1 = 0;
    						pr1 = 0;
    					}
    				}

    			})
    			self.self_assesment7().reverse();
    		}

      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
        self.title_modal = ko.observable('');
        self.subtitle_modal = ko.observable('');
        self.jumlah_uraian = ko.observable(0);
        self.uraian_sebelumnya = ko.observableArray([]);
        self.jumlah_telaah = ko.observable(0);
        self.telaah_sebelumnya = ko.observableArray([]);
        self.load_data_sebelumnya = ko.observable(true);
      <?php } ?>

    	}

    	var App = new TelaahModel();

      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
      App.showUraian = function(idx){
        $('.uraian_before').parent().addClass('hide');
        $('#'+idx+'_uraian_before').parent().removeClass('hide');
        return false;
      }

      App.showTelaah = function(idx){
        $('.telaah_before').parent().addClass('hide');
        $('#'+idx+'_telaah_before').parent().removeClass('hide');
        return false;
      }

      App.uraian_before = function(title, uraian){
        var id_pep = App.id_pep,
            id_pengajuan = App.id_pengajuan;

        App.load_data_sebelumnya(true);
        App.uraian_sebelumnya.removeAll();
        $.ajax({
          url: '<?php echo base_url()?>telaah_expedited/get_uraian_before/'+id_pep+'/'+id_pengajuan+'/'+uraian,
          type: 'post',
          dataType : 'json',
          success: function(res, xhr){
            App.jumlah_uraian(res.jumlah);
            $.each(res.data, function(i, item){
              App.uraian_sebelumnya.push(new UraianBefore(item.id, item.tgl, item.uraian));
            })
          }
        })

        App.title_modal(title);
        $('#my-modal').modal('show');
        App.load_data_sebelumnya(false);
      }

      App.telaah_before = function(title, subtitle, catatan){
        var id_pep = App.id_pep,
            id_pengajuan = App.id_pengajuan;

        App.load_data_sebelumnya(true);
        App.telaah_sebelumnya.removeAll();
        $.ajax({
          url: '<?php echo base_url()?>telaah_expedited/get_catatan_before/'+id_pep+'/'+id_pengajuan+'/'+catatan,
          type: 'post',
          dataType : 'json',
          success: function(res, xhr){
            App.jumlah_telaah(res.jumlah);
            $.each(res.data, function(i, item){
              App.telaah_sebelumnya.push(new TelaahBefore(item.id, item.tgl, item.catatan));
            })
          }
        })

        App.title_modal(title);
        App.subtitle_modal(subtitle);
        $('#my-modal-telaah').modal('show');
        App.load_data_sebelumnya(false);
      }
      <?php } ?>

      App.showFile = function(path){
        sp = path.split('/');
        file_name = sp[1];
        $.ajax({
          url: '<?php echo base_url()?>telaah_expedited/cek_file_upload_exist/'+file_name,
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

      App.catatan_protokol = function(){
        var cat = '';

        if ( $('#catatanA').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>A. Judul Penelitian (p-protokol no 1):</b><br/><u>Catatan</u>: <br/>'+$('#catatanA').html()+'<br/><br/>';

        if ( $('#catatanC').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>C. Ringkasan Protokol Penelitian:</b><br/><u>Catatan</u>: <br/>'+$('#catatanC').html()+'<br/><br/>';

        if ( $('#catatanD').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>D. Isu Etik yang mungkin dihadapi:</b><br/><u>Catatan</u>: <br/>'+$('#catatanD').html()+'<br/><br/>';

        if ( $('#catatanE').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>E. Ringkasan Kajian Pustaka:</b><br/><u>Catatan</u>: <br/>'+$('#catatanE').html()+'<br/><br/>';

        if ( $('#catatanF').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>F. Kondisi Lapangan:</b><br/><u>Catatan</u>: <br/>'+$('#catatanF').html()+'<br/><br/>';

        if ( $('#catatanG').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>G. Disain Penelitian:</b><br/><u>Catatan</u>: <br/>'+$('#catatanG').html()+'<br/><br/>';

        if ( $('#catatanH').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>H. Sampling:</b><br/><u>Catatan</u>: <br/>'+$('#catatanH').html()+'<br/><br/>';

        if ( $('#catatanI').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>I. Intervensi:</b><br/><u>Catatan</u>: <br/>'+$('#catatanI').html()+'<br/><br/>';

        if ( $('#catatanJ').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>J. Monitoring Penelitian:</b><br/><u>Catatan</u>: <br/>'+$('#catatanJ').html()+'<br/><br/>';
        
        if ( $('#catatanK').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>K. Penghentian  Penelitian dan Alasannya:</b><br/><u>Catatan</u>: <br/>'+$('#catatanK').html()+'<br/><br/>';
        
        if ( $('#catatanL').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>L. Adverse Event dan Komplikasi (Kejadian Yang Tidak Diharapkan):</b><br/><u>Catatan</u>: <br/>'+$('#catatanL').html()+'<br/><br/>';
        
        if ( $('#catatanM').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>M. Penanganan Komplikasi <small>(p27)</small>:</b><br/><u>Catatan</u>: <br/>'+$('#catatanM').html()+'<br/><br/>';
        
        if ( $('#catatanN').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>N. Manfaat:</b><br/><u>Catatan</u>: <br/>'+$('#catatanN').html()+'<br/><br/>';
        
        if ( $('#catatanO').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>O. Jaminan Keberlanjutan Manfaat <small><i>(p28)</i></small>:</b><br/><u>Catatan</u>: <br/>'+$('#catatanO').html()+'<br/><br/>';
        
        if ( $('#catatanP').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>P. Informed Consent <small><i>(Upload IC 35 butir di Tab CC)</i></small>:</b><br/><u>Catatan</u>: <br/>'+$('#catatanP').html()+'<br/><br/>';
        
        if ( $('#catatanQ').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>Q. Wali <small><i>(p31)</i></small>:</b><br/><u>Catatan</u>: <br/>'+$('#catatanQ').html()+'<br/><br/>';
        
        if ( $('#catatanR').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>R. Bujukan:</b><br/><u>Catatan</u>: <br/>'+$('#catatanR').html()+'<br/><br/>';
        
        if ( $('#catatanS').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>S. Penjagaan Kerahasiaan:</b><br/><u>Catatan</u>: <br/>'+$('#catatanS').html()+'<br/><br/>';
        
        if ( $('#catatanT').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>T. Rencana Analisis:</b><br/><u>Catatan</u>: <br/>'+$('#catatanT').html()+'<br/><br/>';
        
        if ( $('#catatanU').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>U. Monitor Keamanan:</b><br/><u>Catatan</u>: <br/>'+$('#catatanU').html()+'<br/><br/>';
        
        if ( $('#catatanV').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>V. Konflik Kepentingan:</b><br/><u>Catatan</u>: <br/>'+$('#catatanV').html()+'<br/><br/>';
        
        if ( $('#catatanW').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>W. Manfaat Sosial:</b><br/><u>Catatan</u>: <br/>'+$('#catatanW').html()+'<br/><br/>';
        
        if ( $('#catatanX').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>X. Hak atas Data:</b><br/><u>Catatan</u>: <br/>'+$('#catatanX').html()+'<br/><br/>';
        
        if ( $('#catatanY').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>Y. Publikasi:</b><br/><u>Catatan</u>: <br/>'+$('#catatanY').html()+'<br/><br/>';
        
        if ( $('#catatanZ').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>Z. Pendanaan:</b><br/><u>Catatan</u>: <br/>'+$('#catatanZ').html()+'<br/><br/>';
        
        if ( $('#catatanAA').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>AA. Komitmen Etik:</b><br/><u>Catatan</u>: <br/>'+$('#catatanAA').html()+'<br/><br/>';
        
        if ( $('#catatanBB').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>BB. Daftar Pustaka:</b><br/><u>Catatan</u>: <br/>'+$('#catatanBB').html()+'<br/><br/>';
        
        if ( $('#catatanCC').text().trim().length > 0)
          cat += '<u>Protokol:</u><br/><b>CC. Lampiran:</b><br/><u>Catatan</u>: <br/>'+$('#catatanCC').html()+'<br/><br/>';

        $('#catatan_protokol').html(cat);
      }

      App.catatan_sa = function(no){
        switch(no){
          case 1: arr = App.self_assesment1(); break;
          case 2: arr = App.self_assesment2(); break;
          case 3: arr = App.self_assesment3(); break;
          case 4: arr = App.self_assesment4(); break;
          case 5: arr = App.self_assesment5(); break;
          case 6: arr = App.self_assesment6(); break;
          case 7: arr = App.self_assesment7(); break;
        }

        var cat = '';
            cat_kelayakan = '';
        $.each(arr, function(i, item){
          if ($.trim(item.cat_penelaah()) !== ""){
            if (item.no_tampilan == '')
              cat += '<p><u>7-Standar:</u> <br/><i>'+item.parent+'.'+item.uraian+'</i><br/><u>Catatan</u>: <br/>'+item.cat_penelaah()+'</p>';
            else
              cat += '<p><u>7-Standar:</u> <br/><i>'+item.no_tampilan+'.'+item.uraian+'</i><br/><u>Catatan</u>: <br/>'+item.cat_penelaah()+'</p>';
          }
        })

        switch(no){
          case 1: $('#catatan1').html(cat); break;
          case 2: $('#catatan2').html(cat); break;
          case 3: $('#catatan3').html(cat); break;
          case 4: $('#catatan4').html(cat); break;
          case 5: $('#catatan5').html(cat); break;
          case 6: $('#catatan6').html(cat); break;
          case 7: $('#catatan7').html(cat); break;
        }

        cat_kelayakan = $('#catatan1').html()+$('#catatan2').html()+$('#catatan3').html()+$('#catatan4').html()+$('#catatan5').html()+$('#catatan6').html()+$('#catatan7').html();

        $('#catatan_7standar').html(cat_kelayakan);
      }

      App.get_standar_kelaikan = function(){
        var id = App.id(), 
            id_pep = App.id_pep;

        $.ajax({
          url: '<?php echo base_url()?>telaah_expedited/get_standar_kelaikan/'+id+'/'+id_pep,
          type: 'post',
          cache: false,
          dataType: 'json',
          success: function(res, xhr){
            var skep = res;
            $.each(skep, function(i, item){
              if (item.idx_std == 1){
                App.self_assesment1.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_penelaah, item.cat_penelaah, item.just_header) );
              }
              else if (item.idx_std == 2){
                App.self_assesment2.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian,item.uraian_master, item.pil_pengaju, item.pil_penelaah, item.cat_penelaah, item.just_header) );
              }
              else if (item.idx_std == 3){
                App.self_assesment3.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_penelaah, item.cat_penelaah, item.just_header) );
              }
              else if (item.idx_std == 4){
                App.self_assesment4.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_penelaah, item.cat_penelaah, item.just_header) );
              }
              else if (item.idx_std == 5){
                App.self_assesment5.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_penelaah, item.cat_penelaah, item.just_header) );
              }
              else if (item.idx_std == 6){
                App.self_assesment6.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_penelaah, item.cat_penelaah, item.just_header) );
              }
              else if (item.idx_std == 7){
                App.self_assesment7.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_penelaah, item.cat_penelaah, item.just_header) );
              }
            });

            App.default_pilihan_penelaah();
          }
        });

      }

      App.default_pilihan_penelaah = function(){
        if (App.id() == 0)
        {
          $.each(App.self_assesment1(), function(i, item){
    				if (item.no_tampilan == '1.2') { 
              item.pil_penelaah('Ya');
              App.pilih1Ya(i, item.parent);
            }
    				if (item.no_tampilan == '1.3') {
              item.pil_penelaah('Ya');
              App.pilih1Ya(i, item.parent);
            }
    			})

    			$.each(App.self_assesment2(), function(i, item){
    				if (item.id == 15) {
              item.pil_penelaah('Ya');
              App.pilih2Ya(i, item.parent);
            }
    				if (item.id == 16) {
              item.pil_penelaah('Ya');
              App.pilih2Ya(i, item.parent);
            }
    				if (item.id == 17) {
              item.pil_penelaah('Ya');
              App.pilih2Ya(i, item.parent);
            }
    				if (item.id == 18) {
              item.pil_penelaah('Ya');
              App.pilih2Ya(i, item.parent);
            }
    				if (item.id == 19) {
              item.pil_penelaah('Ya');
              App.pilih2Ya(i, item.parent);
            }
    				if (item.id == 23) {
              item.pil_penelaah('Ya');
              App.pilih2Ya(i, item.parent);
            }
    			})

    			$.each(App.self_assesment3(), function(i, item){
    				if (item.no_tampilan == '3.2') { 
              item.pil_penelaah('Ya');
              App.pilih3Ya(i, item.parent);
            }
    			})

    			$.each(App.self_assesment4(), function(i, item){
    				if (item.no_tampilan == '4.1') { 
              item.pil_penelaah('Ya');
              App.pilih4Ya(i, item.parent);
            }
    			})

    			$.each(App.self_assesment5(), function(i, item){
    				if (item.no_tampilan == '5.1') { 
              item.pil_penelaah('Ya');
              App.pilih5Ya(i, item.parent);
            }
    			})

    			$.each(App.self_assesment6(), function(i, item){
    				if (item.id == 100) { 
              item.pil_penelaah('Ya');
              App.pilih6Ya(i, item.parent);
            }
    			})

    			$.each(App.self_assesment7(), function(i, item){
    				if (item.no_tampilan == 7) { 
              item.pil_penelaah('Ya');
              App.pilih7Ya(i, item.parent);
            }
    			})
        }
      }

      App.reset1 = function(){
    	  ko.utils.arrayForEach(App.self_assesment1(), function(pilihan) {
    	  	pilihan.pil_penelaah('');
    	  });
    	}

    	App.reset2 = function(){
    	  ko.utils.arrayForEach(App.self_assesment2(), function(pilihan) {
    	  	pilihan.pil_penelaah('');
    	  });
    	}

    	App.reset3 = function(){
    	  ko.utils.arrayForEach(App.self_assesment3(), function(pilihan) {
    	  	pilihan.pil_penelaah('');
    	  });
    	}

    	App.reset4 = function(){
    	  ko.utils.arrayForEach(App.self_assesment4(), function(pilihan) {
    	  	pilihan.pil_penelaah('');
    	  });
    	}

    	App.reset5 = function(){
    	  ko.utils.arrayForEach(App.self_assesment5(), function(pilihan) {
    	  	pilihan.pil_penelaah('');
    	  });
    	}

    	App.reset6 = function(){
    	  ko.utils.arrayForEach(App.self_assesment6(), function(pilihan) {
    	  	pilihan.pil_penelaah('');
    	  });
    	}

    	App.reset7 = function(){
    	  ko.utils.arrayForEach(App.self_assesment7(), function(pilihan) {
    	  	pilihan.pil_penelaah('');
    	  });
    	}

    	App.save = function(createNew){
    	  var data = new Object();
            data['id'] = App.id();
            data['id_pep'] = App.id_pep;
            data['kelayakan'] = App.kelayakan();
    	      data['self_assesment1'] = JSON.stringify(ko.toJS(App.self_assesment1()));
    	      data['self_assesment2'] = JSON.stringify(ko.toJS(App.self_assesment2()));
    	      data['self_assesment3'] = JSON.stringify(ko.toJS(App.self_assesment3()));
    	      data['self_assesment4'] = JSON.stringify(ko.toJS(App.self_assesment4()));
    	      data['self_assesment5'] = JSON.stringify(ko.toJS(App.self_assesment5()));
    	      data['self_assesment6'] = JSON.stringify(ko.toJS(App.self_assesment6()));
    	      data['self_assesment7'] = JSON.stringify(ko.toJS(App.self_assesment7()));
            data['catatanA'] = $('#catatanA').html();
            data['catatanC'] = $('#catatanC').html();
            data['catatanD'] = $('#catatanD').html();
            data['catatanE'] = $('#catatanE').html();
            data['catatanF'] = $('#catatanF').html();
            data['catatanG'] = $('#catatanG').html();
            data['catatanH'] = $('#catatanH').html();
            data['catatanI'] = $('#catatanI').html();
            data['catatanJ'] = $('#catatanJ').html();
            data['catatanK'] = $('#catatanK').html();
            data['catatanL'] = $('#catatanL').html();
            data['catatanM'] = $('#catatanM').html();
            data['catatanN'] = $('#catatanN').html();
            data['catatanO'] = $('#catatanO').html();
            data['catatanP'] = $('#catatanP').html();
            data['catatanQ'] = $('#catatanQ').html();
            data['catatanR'] = $('#catatanR').html();
            data['catatanS'] = $('#catatanS').html();
            data['catatanT'] = $('#catatanT').html();
            data['catatanU'] = $('#catatanU').html();
            data['catatanV'] = $('#catatanV').html();
            data['catatanW'] = $('#catatanW').html();
            data['catatanX'] = $('#catatanX').html();
            data['catatanY'] = $('#catatanY').html();
            data['catatanZ'] = $('#catatanZ').html();
            data['catatanAA'] = $('#catatanAA').html();
            data['catatanBB'] = $('#catatanBB').html();
            data['catatanCC'] = $('#catatanCC').html();
            data['catatan_link_proposal'] = $('#catatan_link_proposal').html();
            data['catatan_protokol'] = $('#catatan_protokol').html();
    	  		data['catatan1'] = $('#catatan1').html();
    	  		data['catatan2'] = $('#catatan2').html();
    	  		data['catatan3'] = $('#catatan3').html();
    	  		data['catatan4'] = $('#catatan4').html();
    	  		data['catatan5'] = $('#catatan5').html();
    	  		data['catatan6'] = $('#catatan6').html();
    	  		data['catatan7'] = $('#catatan7').html();
            data['catatan_7standar'] = $('#catatan_7standar').html();
    	  var $btn = $('#submit');

    	  $btn.button('loading');
    	  App.processing(true);
    	  $.ajax({
    	    url: '<?php echo base_url()?>telaah_expedited/proses',
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
    		window.location.href = '<?php echo base_url()?>telaah_expedited/';
    	}

    	App.print_protokol = function(){
    		var id_pep = App.id_pep;
    		window.open('<?php echo base_url()?>telaah_expedited/cetak_protokol/'+id_pep, '_blank');
    	}

    	App.print_sa = function(){
    		var id = App.id(), 
    				id_pep = App.id_pep;
    		window.open('<?php echo base_url()?>telaah_expedited/cetak_sa/'+id+'/'+id_pep, '_blank');
    	}

    	App.print_telaah_expedited = function(){
    		var id = App.id(), 
    				id_pep = App.id_pep;
    		window.open('<?php echo base_url()?>telaah_expedited/cetak_telaah_expedited/'+id+'/'+id_pep, '_blank');
    	}

      ko.applyBindings(App);
    </script>
