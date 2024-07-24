    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
    <script src="<?php echo base_url()?>assets/js/wizard.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.hotkeys.index.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap-wysiwyg.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootbox.js"></script>

    <script type="text/javascript">
    	jQuery(function($) {
    					
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

        App.get_telaah_fullboard();
        App.get_standar_kelaikan();

    		$('#ringkasan').html('<?php echo isset($data['ringkasan']) ? $data['ringkasan'] : ''?>');

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

    	var SKEP = function(id, no_tampilan, no, idx_std, parent, child, level, uraian, uraian_master, pil_pengaju, pil_pelapor, just_header){
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
    		this.pil_pelapor = ko.observable(pil_pelapor);
    		this.just_header = just_header;
    	}

    	var TelaahFbd = function(id, no, nama, kelayakan, cata, catc, catd, cate, catf, catg, cath, cati, catj, catk, catl, catm, catn, cato, catp, catq, catr, cats, catt, catu, catv, catw, catx, caty, catz, cataa, catbb, catcc, catlink, catprotokol, cat1, cat2, cat3, cat4, cat5, cat6, cat7, cat7standar){
    		this.id = id;
    		this.no = no;
    		this.nama = nama;
    		this.kelayakan = kelayakan;
    		this.cata = cata;
        this.catc = catc;
        this.catd = catd;
        this.cate = cate;
        this.catf = catf;
        this.catg = catg;
        this.cath = cath;
        this.cati = cati;
        this.catj = catj;
        this.catk = catk;
        this.catl = catl;
        this.catm = catm;
        this.catn = catn;
        this.cato = cato;
        this.catp = catp;
        this.catq = catq;
        this.catr = catr;
        this.cats = cats;
        this.catt = catt;
        this.catu = catu;
        this.catv = catv;
        this.catw = catw;
        this.catx = catx;
        this.caty = caty;
        this.catz = catz;
        this.cataa = cataa;
        this.catbb = catbb;
        this.catcc = catcc;
        this.catlink = catlink;
        this.catprotokol = catprotokol;
        this.cat1 = cat1;
        this.cat2 = cat2;
        this.cat3 = cat3;
        this.cat4 = cat4;
        this.cat5 = cat5;
        this.cat6 = cat6;
        this.cat7 = cat7;
        this.cat7standar = cat7standar;
    	}

      <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
      var TelaahBefore = function(id, tgl, kelayakan, catatan, catprotokol, cat7standar){
        this.id = id;
        this.tgl = tgl;
        this.kelayakan = kelayakan;
        this.catatan = catatan;
        this.catprotokol = catprotokol;
        this.cat7standar = cat7standar;
      }
      <?php } ?>

    	var PutusanTelaahModel = function(){
    		var self = this;
    		self.id = ko.observable(<?php echo isset($data['id_pfbd']) ? $data['id_pfbd'] : 0?>);
    		self.id_pep = <?php echo isset($id_pep) ? $id_pep : 0 ?>;
        self.id_pengajuan = <?php echo isset($pengajuan['id_pengajuan']) ? $pengajuan['id_pengajuan'] : 0 ?>;
    		self.id_group = <?php echo $this->session->userdata('id_group_'.APPAUTH); ?>;
    		self.no_protokol = '<?php echo isset($pengajuan['no_protokol']) ? $pengajuan['no_protokol'] : ''?>';
    		self.telaah_fbd = ko.observableArray([]);
    		self.keputusan = ko.observable('<?php echo isset($data['keputusan']) ? $data['keputusan'] : ''?>');
        self.save_sekretaris = ko.observable(<?php echo isset($data['id_atk_sekretaris']) && $data['id_atk_sekretaris'] > 0 ? 1 : 0 ?>); 
        self.save_ketua = ko.observable(<?php echo isset($data['id_atk_ketua']) && $data['id_atk_ketua'] > 0 ? 1 : 0 ?>);
        self.save_wakil_ketua = ko.observable(<?php echo isset($data['id_atk_wakil_ketua']) && $data['id_atk_wakil_ketua'] > 0 ? 1 : 0 ?>);

    		/** =========== (1) ============== **/
    		self.self_assesment1 = ko.observableArray([]);
    		self.pilih1Ya = function(indx, parent){
    			$.each(self.self_assesment1(), function(i, item){
    				if (item.no == parent){
    					var pr = item.parent;
    					self.self_assesment1()[i].pil_pelapor('Ya');
    					$.each(self.self_assesment1(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment1()[ix].pil_pelapor('Ya');
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
    					if (item.pil_pelapor() == 'Tidak') pil2--;
              else pil2 = 0;
    				}

    				if (item.level == 1) {
    					pr1 = item.parent;
    					if (Math.abs(pil2) == item.child && pr2 == item.no){
    						self.self_assesment1()[i].pil_pelapor('Tidak');
    					}
    					if (item.pil_pelapor() == 'Tidak'){
    						pil2 = 0;
    						pr2 = 0;
    						pil1--;
    					}
    				}

    				if (item.level == 0) {
    					if (Math.abs(pil1) == item.child && pr1 == item.no){
    						self.self_assesment1()[i].pil_pelapor('Tidak');
    					}
    					if (item.pil_pelapor() == 'Tidak'){
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
    					self.self_assesment2()[i].pil_pelapor('Ya');
    					$.each(self.self_assesment2(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment2()[ix].pil_pelapor('Ya');
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
    					if (item.pil_pelapor() == 'Tidak') pil2--;
              else pil2 = 0;
    				}

    				if (item.level == 1) {
    					pr1 = item.parent;
    					if (Math.abs(pil2) == item.child && pr2 == item.no){
    						self.self_assesment2()[i].pil_pelapor('Tidak');
    					}
    					if (item.pil_pelapor() == 'Tidak'){
    						pil2 = 0;
    						pr2 = 0;
    						pil1--;
    					}
    				}

    				if (item.level == 0) {
    					if (Math.abs(pil1) == item.child && pr1 == item.no){
    						self.self_assesment2()[i].pil('Tidak');
    					}
    					if (item.pil_pelapor() == 'Tidak'){
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
    					self.self_assesment3()[i].pil_pelapor('Ya');
    					$.each(self.self_assesment3(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment3()[ix].pil_pelapor('Ya');
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
    					if (item.pil_pelapor() == 'Tidak') pil2--;
              else pil2 = 0;
    				}

    				if (item.level == 1) {
    					pr1 = item.parent;
    					if (Math.abs(pil2) == item.child && pr2 == item.no){
    						self.self_assesment3()[i].pil_pelapor('Tidak');
    					}
    					if (item.pil_pelapor() == 'Tidak'){
    						pil2 = 0;
    						pr2 = 0;
    						pil1--;
    					}
    				}

    				if (item.level == 0) {
    					if (Math.abs(pil1) == item.child && pr1 == item.no){
    						self.self_assesment3()[i].pil_pelapor('Tidak');
    					}
    					if (item.pil_pelapor() == 'Tidak'){
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
    					self.self_assesment4()[i].pil_pelapor('Ya');
    					$.each(self.self_assesment4(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment4()[ix].pil_pelapor('Ya');
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
    					if (item.pil_pelapor() == 'Tidak') pil2--;
              else pil2 = 0;
    				}

    				if (item.level == 1) {
    					pr1 = item.parent;
    					if (Math.abs(pil2) == item.child && pr2 == item.no){
    						self.self_assesment4()[i].pil_pelapor('Tidak');
    					}
    					if (item.pil_pelapor() == 'Tidak'){
    						pil2 = 0;
    						pr2 = 0;
    						pil1--;
    					}
    				}

    				if (item.level == 0) {
    					if (Math.abs(pil1) == item.child && pr1 == item.no){
    						self.self_assesment4()[i].pil_pelapor('Tidak');
    					}
    					if (item.pil_pelapor() == 'Tidak'){
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
    					self.self_assesment5()[i].pil_pelapor('Ya');
    					$.each(self.self_assesment5(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment5()[ix].pil_pelapor('Ya');
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
    					if (item.pil_pelapor() == 'Tidak') pil2--;
              else pil2 = 0;
    				}

    				if (item.level == 1) {
    					pr1 = item.parent;
    					if (Math.abs(pil2) == item.child && pr2 == item.no){
    						self.self_assesment5()[i].pil_pelapor('Tidak');
    					}
    					if (item.pil_pelapor() == 'Tidak'){
    						pil2 = 0;
    						pr2 = 0;
    						pil1--;
    					}
    				}

    				if (item.level == 0) {
    					if (Math.abs(pil1) == item.child && pr1 == item.no){
    						self.self_assesment5()[i].pil_pelapor('Tidak');
    					}
    					if (item.pil_pelapor() == 'Tidak'){
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
    					self.self_assesment6()[i].pil_pelapor('Ya');
    					$.each(self.self_assesment6(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment6()[ix].pil_pelapor('Ya');
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
    					if (item.pil_pelapor() == 'Tidak') pil2--;
              else pil2 = 0;
    				}

    				if (item.level == 1) {
    					pr1 = item.parent;
    					if (Math.abs(pil2) == item.child && pr2 == item.no){
    						self.self_assesment6()[i].pil_pelapor('Tidak');
    					}
    					if (item.pil_pelapor() == 'Tidak'){
    						pil2 = 0;
    						pr2 = 0;
    						pil1--;
    					}
    				}

    				if (item.level == 0) {
    					if (Math.abs(pil1) == item.child && pr1 == item.no){
    						self.self_assesment6()[i].pil_pelapor('Tidak');
    					}
    					if (item.pil_pelapor() == 'Tidak'){
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
    					self.self_assesment7()[i].pil_pelapor('Ya');
    					$.each(self.self_assesment7(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment7()[ix].pil_pelapor('Ya');
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
    					if (item.pil_pelapor() == 'Tidak') pil2--;
              else pil2 = 0;
    				}

    				if (item.level == 1) {
    					pr1 = item.parent;
    					if (Math.abs(pil2) == item.child && pr2 == item.no){
    						self.self_assesment7()[i].pil_pelapor('Tidak');
    					}
    					if (item.pil_pelapor() == 'Tidak'){
    						pil2 = 0;
    						pr2 = 0;
    						pil1--;
    					}
    				}

    				if (item.level == 0) {
    					if (Math.abs(pil1) == item.child && pr1 == item.no){
    						self.self_assesment7()[i].pil_pelapor('Tidak');
    					}
    					if (item.pil_pelapor() == 'Tidak'){
    						pil1 = 0;
    						pr1 = 0;
    					}
    				}

    			})
    			self.self_assesment7().reverse();
    		}

    		self.is_kirim = ko.observable(<?php echo isset($is_kirim) ? $is_kirim : 0 ?>);
    		self.lbl_btn_kirim = ko.pureComputed(function(){
    			if (self.is_kirim() == 1) 
    				return 'Terkirim';

    			return 'Kirim';
    		});
    		self.processing = ko.observable(false);

      <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
        self.title_modal = ko.observable('');
        self.subtitle_modal = ko.observable('');
        self.jumlah_telaah = ko.observable(0);
        self.telaah_sebelumnya = ko.observableArray([]);
        self.no_penelaah = ko.observable('');
        self.nama_penelaah = ko.observable('');
        self.load_data_sebelumnya = ko.observable(true);
      <?php } ?>

    	}

    	var App = new PutusanTelaahModel();

      <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
      App.showTelaah = function(idx){
        $('.telaah_before').parent().addClass('hide');
        $('#'+idx+'_telaah_before').parent().removeClass('hide');
        return false;
      }
      
      App.showKelayakan = function(idx){
        $('.kelayakan_before').parent().addClass('hide');
        $('#'+idx+'_kelayakan_before').parent().removeClass('hide');
        return false;
      }

      App.telaah_before = function(title, subtitle, catatan, id, no, nama){
        var id_pep = App.id_pep,
            id_pengajuan = App.id_pengajuan;

        App.load_data_sebelumnya(true);
        App.telaah_sebelumnya.removeAll();
        $.ajax({
          url: '<?php echo base_url()?>putusan_fullboard/get_telaah_before/'+id_pep+'/'+id_pengajuan+'/'+catatan+'/'+id,
          type: 'post',
          dataType : 'json',
          success: function(res, xhr){
            App.jumlah_telaah(res.jumlah);
            $.each(res.data, function(i, item){
              App.telaah_sebelumnya.push(new TelaahBefore(item.id, item.tgl, item.kelayakan, item.catatan, item.catprotokol, item.cat7standar));
            })
          }
        })

        App.title_modal(title);
        App.subtitle_modal(subtitle);
        App.no_penelaah(no);
        App.nama_penelaah(nama);
        $('#my-modal-telaah').modal('show');
        App.load_data_sebelumnya(false);
      }

      App.kelayakan_before = function(title, subtitle, catatan, id, no, nama){
        var id_pep = App.id_pep,
            id_pengajuan = App.id_pengajuan;

        App.load_data_sebelumnya(true);
        App.telaah_sebelumnya.removeAll();
        $.ajax({
          url: '<?php echo base_url()?>putusan_fullboard/get_telaah_before/'+id_pep+'/'+id_pengajuan+'/'+catatan+'/'+id,
          type: 'post',
          dataType : 'json',
          success: function(res, xhr){
            App.jumlah_telaah(res.jumlah);
            $.each(res.data, function(i, item){
              App.telaah_sebelumnya.push(new TelaahBefore(item.id, item.tgl, item.kelayakan, item.catatan, item.catprotokol, item.cat7standar));
            })
          }
        })

        App.title_modal(title);
        App.subtitle_modal(subtitle);
        App.no_penelaah(no);
        App.nama_penelaah(nama);
        $('#my-modal-kelayakan').modal('show');
        App.load_data_sebelumnya(false);
      }
      <?php } ?>

      App.get_telaah_fullboard = function(){
        var id_pep = App.id_pep;

        $.ajax({
          url: '<?php echo base_url()?>putusan_fullboard/get_telaah_fullboard_by_idpep/'+id_pep,
          type: 'post',
          cache: false,
          dataType: 'json',
          success: function(res, xhr){
            $.each(res, function(i, item){
              App.telaah_fbd.push(new TelaahFbd(item.id, item.no, item.nama, item.kelayakan, item.cata, item.catc, item.catd, item.cate, item.catf, item.catg, item.cath, item.cati, item.catj, item.catk, item.catl, item.catm, item.catn, item.cato, item.catp, item.catq, item.catr, item.cats, item.catt, item.catu, item.catv, item.catw, item.catx, item.caty, item.catz, item.cataa, item.catbb, item.catcc, item.catlink, item.catprotokol, item.cat1, item.cat2, item.cat3, item.cat4, item.cat5, item.cat6, item.cat7, item.cat7standar));
            });
          }
        });

      }

      App.get_standar_kelaikan = function(){
        var id = App.id(), 
            id_pep = App.id_pep;

        $.ajax({
          url: '<?php echo base_url()?>putusan_fullboard/get_standar_kelaikan/'+id+'/'+id_pep,
          type: 'post',
          cache: false,
          dataType: 'json',
          success: function(res, xhr){
            var skep = res;
            $.each(skep, function(i, item){
              if (item.idx_std == 1){
                App.self_assesment1.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_pelapor, item.just_header) );
              }
              else if (item.idx_std == 2){
                App.self_assesment2.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian,item.uraian_master, item.pil_pengaju, item.pil_pelapor, item.just_header) );
              }
              else if (item.idx_std == 3){
                App.self_assesment3.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_pelapor, item.just_header) );
              }
              else if (item.idx_std == 4){
                App.self_assesment4.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_pelapor, item.just_header) );
              }
              else if (item.idx_std == 5){
                App.self_assesment5.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_pelapor, item.just_header) );
              }
              else if (item.idx_std == 6){
                App.self_assesment6.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_pelapor, item.just_header) );
              }
              else if (item.idx_std == 7){
                App.self_assesment7.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_pelapor, item.just_header) );
              }
            });

            App.default_pilihan_pelapor();
          }
        });

      }

      App.default_pilihan_pelapor = function(){
        if (App.id() == 0)
        {
          $.each(App.self_assesment1(), function(i, item){
    				if (item.no_tampilan == '1.2') { 
              item.pil_pelapor('Ya');
              App.pilih1Ya(i, item.parent);
            }
    				if (item.no_tampilan == '1.3') {
              item.pil_pelapor('Ya');
              App.pilih1Ya(i, item.parent);
            }
    			})

    			$.each(App.self_assesment2(), function(i, item){
    				if (item.id == 15) {
              item.pil_pelapor('Ya');
              App.pilih2Ya(i, item.parent);
            }
    				if (item.id == 16) {
              item.pil_pelapor('Ya');
              App.pilih2Ya(i, item.parent);
            }
    				if (item.id == 17) {
              item.pil_pelapor('Ya');
              App.pilih2Ya(i, item.parent);
            }
    				if (item.id == 18) {
              item.pil_pelapor('Ya');
              App.pilih2Ya(i, item.parent);
            }
    				if (item.id == 19) {
              item.pil_pelapor('Ya');
              App.pilih2Ya(i, item.parent);
            }
    				if (item.id == 23) {
              item.pil_pelapor('Ya');
              App.pilih2Ya(i, item.parent);
            }
    			})

    			$.each(App.self_assesment3(), function(i, item){
    				if (item.no_tampilan == '3.2') { 
              item.pil_pelapor('Ya');
              App.pilih3Ya(i, item.parent);
            }
    			})

    			$.each(App.self_assesment4(), function(i, item){
    				if (item.no_tampilan == '4.1') { 
              item.pil_pelapor('Ya');
              App.pilih4Ya(i, item.parent);
            }
    			})

    			$.each(App.self_assesment5(), function(i, item){
    				if (item.no_tampilan == '5.1') { 
              item.pil_pelapor('Ya');
              App.pilih5Ya(i, item.parent);
            }
    			})

    			$.each(App.self_assesment6(), function(i, item){
    				if (item.id == 100) { 
              item.pil_pelapor('Ya');
              App.pilih6Ya(i, item.parent);
            }
    			})

    			$.each(App.self_assesment7(), function(i, item){
    				if (item.no_tampilan == 7) { 
              item.pil_pelapor('Ya');
              App.pilih7Ya(i, item.parent);
            }
    			})
        }
      }

      App.reset1 = function(){
    	  ko.utils.arrayForEach(App.self_assesment1(), function(pilihan) {
    	  	pilihan.pil_pelapor('');
    	  });
    	}

    	App.reset2 = function(){
    	  ko.utils.arrayForEach(App.self_assesment2(), function(pilihan) {
    	  	pilihan.pil_pelapor('');
    	  });
    	}

    	App.reset3 = function(){
    	  ko.utils.arrayForEach(App.self_assesment3(), function(pilihan) {
    	  	pilihan.pil_pelapor('');
    	  });
    	}

    	App.reset4 = function(){
    	  ko.utils.arrayForEach(App.self_assesment4(), function(pilihan) {
    	  	pilihan.pil_pelapor('');
    	  });
    	}

    	App.reset5 = function(){
    	  ko.utils.arrayForEach(App.self_assesment5(), function(pilihan) {
    	  	pilihan.pil_pelapor('');
    	  });
    	}

    	App.reset6 = function(){
    	  ko.utils.arrayForEach(App.self_assesment6(), function(pilihan) {
    	  	pilihan.pil_pelapor('');
    	  });
    	}

    	App.reset7 = function(){
    	  ko.utils.arrayForEach(App.self_assesment7(), function(pilihan) {
    	  	pilihan.pil_pelapor('');
    	  });
    	}

      App.show7standar = function(){
        $('.nav-tabs a[href="#self_assesment-tab"]').tab('show');
        $("html, body").animate({ scrollTop: $("#fuelux-wizard-container").offset().top }, "slow");
      }

    	App.save = function(createNew){
        if (parseInt(App.is_kirim()) == 1)
          show_error(true, 'Data tidak bisa disimpan karena sudah terkirim');
        else
        {
      	  var data = JSON.parse(ko.toJSON(App));
      	      data['self_assesment1'] = JSON.stringify(ko.toJS(App.self_assesment1()));
      	      data['self_assesment2'] = JSON.stringify(ko.toJS(App.self_assesment2()));
      	      data['self_assesment3'] = JSON.stringify(ko.toJS(App.self_assesment3()));
      	      data['self_assesment4'] = JSON.stringify(ko.toJS(App.self_assesment4()));
      	      data['self_assesment5'] = JSON.stringify(ko.toJS(App.self_assesment5()));
      	      data['self_assesment6'] = JSON.stringify(ko.toJS(App.self_assesment6()));
      	      data['self_assesment7'] = JSON.stringify(ko.toJS(App.self_assesment7()));
      	  		data['ringkasan'] = $('#ringkasan').html();
      	  var $btn = $('#submit');

      	  $btn.button('loading');
      	  App.processing(true);
      	  $.ajax({
      	    url: '<?php echo base_url()?>putusan_fullboard/proses',
      	    type: 'post',
      	    cache: false,
      	    dataType: 'json',
      	    data: data,
      	    success: function(res, xhr){
      	      if (res.isSuccess){
      	      	App.id(res.id);
                <?php if ($this->session->userdata('id_group_'.APPAUTH) == 4) { ?>
                App.save_sekretaris(1);
                <?php } else if ($this->session->userdata('id_group_'.APPAUTH) == 7) { ?>
								App.save_ketua(1);
								<?php } else if ($this->session->userdata('id_group_'.APPAUTH) == 8) { ?>
								App.save_wakil_ketua(1);
								<?php } ?>
      	      	show_success(true, res.message);
      	      }
      	      else show_error(true, res.message);

      	      $btn.button('reset');
      	      App.processing(false);
      	    }
      	  });
        }

    	}

    	App.back = function(){
    		window.location.href = '<?php echo base_url()?>putusan_fullboard/';
    	}

    <?php if ($this->session->userdata('id_group_'.APPAUTH) == 6){ ?>
    	App.kirim1 = function(){
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
    				  var id_pep = App.id_pep,
    				  		no_protokol = App.no_protokol,
    				  		keputusan = App.keputusan();
    				  var $btn = $('#kirim1');

    				  $btn.button('loading');
    				  App.processing(true);
    				  $.ajax({
    				    url: '<?php echo base_url()?>putusan_fullboard/kirim/'+id_pep+'/'+keputusan+'/'+no_protokol,
    				    type: 'post',
    				    cache: false,
    				    dataType: 'json',
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
    <?php } ?>

    <?php if ($this->session->userdata('id_group_'.APPAUTH) == 4){ ?>
    	App.kirim2 = function(){
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
    				  var id_pep = App.id_pep,
    				  		no_protokol = App.no_protokol,
    				  		keputusan = App.keputusan();
    				  var $btn = $('#kirim2');

    				  $btn.button('loading');
    				  App.processing(true);
    				  $.ajax({
    				    url: '<?php echo base_url()?>putusan_fullboard/kirim/'+id_pep+'/'+keputusan+'/'+no_protokol,
    				    type: 'post',
    				    cache: false,
    				    dataType: 'json',
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
    <?php } ?>

    <?php if ($this->session->userdata('id_group_'.APPAUTH) == 7 || $this->session->userdata('id_group_'.APPAUTH) == 8){ ?>
    	App.kirim3 = function(){
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
    				  var id_pep = App.id_pep,
    				  		no_protokol = App.no_protokol,
    				  		keputusan = App.keputusan();
    				  var $btn = $('#kirim3');

    				  $btn.button('loading');
    				  App.processing(true);
    				  $.ajax({
    				    url: '<?php echo base_url()?>putusan_fullboard/kirim/'+id_pep+'/'+keputusan+'/'+no_protokol,
    				    type: 'post',
    				    cache: false,
    				    dataType: 'json',
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
    <?php } ?>

    	App.print_sa = function(){
    		var id = App.id(), 
    				id_pep = App.id_pep;
    		window.open('<?php echo base_url()?>putusan_fullboard/cetak_sa/'+id+'/'+id_pep, '_blank');
    	}

    	App.print_telaah_fullboard = function(id_texp){
    		var id_pep = App.id_pep;
    		window.open('<?php echo base_url()?>putusan_fullboard/cetak_telaah_fullboard/'+id_texp+'/'+id_pep, '_blank');
    	}

      ko.applyBindings(App);
    </script>
