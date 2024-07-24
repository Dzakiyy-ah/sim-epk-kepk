    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.hotkeys.index.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap-wysiwyg.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootbox.js"></script>
    <script src="<?php echo base_url()?>assets/js/wizard.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/autosize.min.js"></script>

    <script type="text/javascript">
    	var purge_lampiran1 = [], purge_filename1 = [];
    	var purge_lampiran2 = [], purge_filename2 = [];
    	var purge_lampiran3 = [], purge_filename3 = [];
    	var purge_lampiran4 = [], purge_filename4 = [];
    	var purge_lampiran5 = [], purge_filename5 = [];
    	var purge_lampiran6 = [], purge_filename6 = [];
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
        })
        .on('finished.fu.wizard', function(e) {
        })
        .on('stepclick.fu.wizard', function(e){
          //e.preventDefault();//this will prevent clicking and selecting steps
        });
              
        $('#modal-wizard-container').ace_wizard();
        $('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');

        autosize($('textarea[class*=autosize]'));

        $('[data-rel=popover]').popover({html:true});
        
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
   		
    		$('#c1').html('<?php echo isset($data['uraianc1']) ? $data['uraianc1'] : ""?>');
    		$('#c2').html('<?php echo isset($data['uraianc2']) ? $data['uraianc2'] : ""?>');
    		$('#d1').html('<?php echo isset($data['uraiand1']) ? $data['uraiand1'] : ""?>');
    		$('#e1').html('<?php echo isset($data['uraiane1']) ? $data['uraiane1'] : ""?>');
    		$('#f1').html('<?php echo isset($data['uraianf1']) ? $data['uraianf1'] : ""?>');
    		$('#f2').html('<?php echo isset($data['uraianf2']) ? $data['uraianf2'] : ""?>');
    		$('#f3').html('<?php echo isset($data['uraianf3']) ? $data['uraianf3'] : ""?>');
    		$('#g1').html('<?php echo isset($data['uraiang1']) ? $data['uraiang1'] : ""?>');
    		$('#g2').html('<?php echo isset($data['uraiang2']) ? $data['uraiang2'] : ""?>');
    		$('#g3').html('<?php echo isset($data['uraiang3']) ? $data['uraiang3'] : ""?>');
    		$('#h1').html('<?php echo isset($data['uraianh1']) ? $data['uraianh1'] : ""?>');
    		$('#h2').html('<?php echo isset($data['uraianh2']) ? $data['uraianh2'] : ""?>');
    		$('#h3').html('<?php echo isset($data['uraianh3']) ? $data['uraianh3'] : ""?>');
    		$('#i1').html('<?php echo isset($data['uraiani1']) ? $data['uraiani1'] : ""?>');
    		$('#i2').html('<?php echo isset($data['uraiani2']) ? $data['uraiani2'] : ""?>');
    		$('#i3').html('<?php echo isset($data['uraiani3']) ? $data['uraiani3'] : ""?>');
    		$('#i4').html('<?php echo isset($data['uraiani4']) ? $data['uraiani4'] : ""?>');
    		$('#j1').html('<?php echo isset($data['uraianj1']) ? $data['uraianj1'] : ""?>');
    		$('#k1').html('<?php echo isset($data['uraiank1']) ? $data['uraiank1'] : ""?>');
    		$('#l1').html('<?php echo isset($data['uraianl1']) ? $data['uraianl1'] : ""?>');
    		$('#l2').html('<?php echo isset($data['uraianl2']) ? $data['uraianl2'] : ""?>');
    		$('#m1').html('<?php echo isset($data['uraianm1']) ? $data['uraianm1'] : ""?>');
    		$('#n1').html('<?php echo isset($data['uraiann1']) ? $data['uraiann1'] : ""?>');
    		$('#n2').html('<?php echo isset($data['uraiann2']) ? $data['uraiann2'] : ""?>');
    		$('#o1').html('<?php echo isset($data['uraiano1']) ? $data['uraiano1'] : ""?>');
    		$('#p1').html('<?php echo isset($data['uraianp1']) ? $data['uraianp1'] : ""?>');
    		$('#p2').html('<?php echo isset($data['uraianp2']) ? $data['uraianp2'] : ""?>');
    		$('#q1').html('<?php echo isset($data['uraianq1']) ? $data['uraianq1'] : ""?>');
    		$('#q2').html('<?php echo isset($data['uraianq2']) ? $data['uraianq2'] : ""?>');
    		$('#r1').html('<?php echo isset($data['uraianr1']) ? $data['uraianr1'] : ""?>');
    		$('#r2').html('<?php echo isset($data['uraianr2']) ? $data['uraianr2'] : ""?>');
    		$('#r3').html('<?php echo isset($data['uraianr3']) ? $data['uraianr3'] : ""?>');
    		$('#s1').html('<?php echo isset($data['uraians1']) ? $data['uraians1'] : ""?>');
    		$('#s2').html('<?php echo isset($data['uraians2']) ? $data['uraians2'] : ""?>');
    		$('#s3').html('<?php echo isset($data['uraians3']) ? $data['uraians3'] : ""?>');
    		$('#s4').html('<?php echo isset($data['uraians4']) ? $data['uraians4'] : ""?>');
    		$('#t1').html('<?php echo isset($data['uraiant1']) ? $data['uraiant1'] : ""?>');
    		$('#u1').html('<?php echo isset($data['uraianu1']) ? $data['uraianu1'] : ""?>');
    		$('#v1').html('<?php echo isset($data['uraianv1']) ? $data['uraianv1'] : ""?>');
    		$('#w1').html('<?php echo isset($data['uraianw1']) ? $data['uraianw1'] : ""?>');
    		$('#w2').html('<?php echo isset($data['uraianw2']) ? $data['uraianw2'] : ""?>');
    		$('#x1').html('<?php echo isset($data['uraianx1']) ? $data['uraianx1'] : ""?>');
    		$('#y1').html('<?php echo isset($data['uraiany1']) ? $data['uraiany1'] : ""?>');
    		$('#y2').html('<?php echo isset($data['uraiany2']) ? $data['uraiany2'] : ""?>');
    		$('#z1').html('<?php echo isset($data['uraianz1']) ? $data['uraianz1'] : ""?>');
    		$('#aa1').html('<?php echo isset($data['uraianaa1']) ? $data['uraianaa1'] : ""?>');
    		$('#aa2').html('<?php echo isset($data['uraianaa2']) ? $data['uraianaa2'] : ""?>');
    		$('#aa3').html('<?php echo isset($data['uraianaa3']) ? $data['uraianaa3'] : ""?>');
    		$('#bb1').html('<?php echo isset($data['uraianbb1']) ? $data['uraianbb1'] : ""?>');

        App.init_lampiran();
        App.standar_kelaikan();

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

    	function rawurlencode (str) {
        str = (str+'').toString();        
        return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').replace(/\)/g, '%29').replace(/\*/g, '%2A');
    	}

    	function getNewid(){
    	  return 'new_' + parseFloat((new Date().getTime() + '').slice(7))+ Math.round(Math.random() * 100);
    	}

    	var Lampiran = function(id, client_name, file_name, file_size, file_type, file_ext){
    		this.id = id;
    		this.client_name = client_name;
    		this.file_name = file_name;
    		this.file_size = file_size;
    		this.file_type = file_type;
    		this.file_ext = file_ext;
    	}

    	var UraianBefore = function(id, tgl, uraian){
    		this.id = id;
    		this.tgl = tgl;
        this.uraian = uraian;
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
        this.pil = ko.observable(pil);
        this.just_header = just_header;
      }

    	var ProtokolModel = function(){
    		var self = this;
    		self.mode = ko.observable('<?php echo isset($mode) ? $mode : 'entri'?>');
        self.revisi_ke = <?php echo isset($revisi_ke) ? $revisi_ke+1 : 1 ?>;
    		self.id = ko.observable(<?php echo isset($data['id_pep']) && $data['id_pep'] != $data['id_pep_old'] ? $data['id_pep'] : 0 ?>);
    		self.id_old = <?php echo isset($data['id_pep_old']) ? $data['id_pep_old'] : 0 ?>;
    		self.id_pengajuan = <?php echo isset($data['id_pengajuan']) ? $data['id_pengajuan'] : 0 ?>;
    		self.judul = <?php echo isset($data['judul']) ? json_encode($data['judul']) : ""?>;
    		self.lokasi = <?php echo isset($data['tempat_penelitian']) ? json_encode($data['tempat_penelitian']) : ""?>;
    		self.is_multi_senter = '<?php echo isset($data['is_multi_senter']) ? $data['is_multi_senter'] : ""?>';
    		self.is_setuju_senter = '<?php echo isset($data['is_setuju_senter']) && $data['is_multi_senter'] === '1' ? $data['is_setuju_senter'] : ""?>';
    		self.link_proposal = ko.observable('<?php echo isset($data['link_proposal']) ? $data['link_proposal'] : ""?>');
        self.valid_protokol = ko.observable(false);

    		self.lampiran1 = ko.observableArray([]);
    		self.removeLampiran1 = function(file){
    		    purge_lampiran1.push(file.id);
    		    purge_filename1.push(file.file_name);
    		    self.lampiran1.remove(file);
    		};
    		self.lampiran2 = ko.observableArray([]);
    		self.removeLampiran2 = function(file){
    		    purge_lampiran2.push(file.id);
    		    purge_filename2.push(file.file_name);
    		    self.lampiran2.remove(file);
    		};
    		self.lampiran3 = ko.observableArray([]);
    		self.removeLampiran3 = function(file){
    		    purge_lampiran3.push(file.id);
    		    purge_filename3.push(file.file_name);
    		    self.lampiran3.remove(file);
    		};
    		self.lampiran4 = ko.observableArray([]);
    		self.removeLampiran4 = function(file){
    		    purge_lampiran4.push(file.id);
    		    purge_filename4.push(file.file_name);
    		    self.lampiran4.remove(file);
    		};
    		self.lampiran5 = ko.observableArray([]);
    		self.removeLampiran5 = function(file){
    		    purge_lampiran5.push(file.id);
    		    purge_filename5.push(file.file_name);
    		    self.lampiran5.remove(file);
    		};
    		self.lampiran6 = ko.observableArray([]);
    		self.removeLampiran6 = function(file){
    		    purge_lampiran6.push(file.id);
    		    purge_filename6.push(file.file_name);
    		    self.lampiran6.remove(file);
    		};

    		self.is_kirim = ko.observable(<?php echo isset($is_kirim) ? $is_kirim : 0 ?>);
    		self.lbl_btn_kirim = ko.pureComputed(function(){
    			if (self.is_kirim() == 1) 
    				return 'Terkirim';

    			return 'Kirim';
    		});

    		self.title_modal = ko.observable('');
    		self.jumlah_uraian = ko.observable(0);
    		self.uraian_sebelumnya = ko.observableArray([]);
        self.load_data_sebelumnya = ko.observable(true);
        <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
        self.jumlah_telaah = ko.observable(0);
        self.telaah_sebelumnya = ko.observableArray([]);
        self.subtitle_modal = ko.observable('');
        <?php } ?>

        self.id_sac = ko.observable(<?php echo isset($data_sac['id_sac']) ? $data_sac['id_sac'] : 0 ?>);
        self.id_sac_old = <?php echo isset($data_sac['id_sac_old']) ? $data_sac['id_sac_old'] : 0 ?>;
        self.versi_jsk = <?php echo isset($data_sac['versi_jsk']) ? $data_sac['versi_jsk'] : 0 ?>;
        /** =========== (1) ============== **/
        self.self_assesment1 = ko.observableArray([]);
        self.justifikasi1 = ko.observable(<?php echo isset($data_sac['justifikasi1']) ? json_encode($data_sac['justifikasi1']) : "" ?>);
        self.pilih1Ya = function(indx, parent){
          $.each(self.self_assesment1(), function(i, item){
            if (item.no == parent){
              var pr = item.parent;
              self.self_assesment1()[i].pil('Ya');
              $.each(self.self_assesment1(), function(ix, itemx){
                if (itemx.no == pr){
                  self.self_assesment1()[ix].pil('Ya');
                }
              });
            }
          });

        }

        self.pilih1Tidak = function(){
          self.self_assesment1().reverse();
          var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0, child1 = 0, child0 = 0;
          $.each(self.self_assesment1(), function(i, item){

            if (item.level == 2) {
              pr2 = item.parent;
              if (item.pil() == 'Tidak') pil2--;
            }

            if (item.level == 1) {
              pr1 = item.parent;
              if (Math.abs(pil2) == item.child && pr2 == item.no){
                self.self_assesment1()[i].pil('Tidak');
              }
              if (item.pil() == 'Tidak'){
                pil2 = 0;
                pr2 = 0;
                pil1--;
              }
            }

            if (item.level == 0) {
              if (Math.abs(pil1) == item.child && pr1 == item.no){
                self.self_assesment1()[i].pil('Tidak');
              }
              if (item.pil() == 'Tidak'){
                pil1 = 0;
                pr1 = 0;
              }
            }

          })
          self.self_assesment1().reverse();

        }

        /** =========== (2) ============== **/
        self.self_assesment2 = ko.observableArray([]);
        self.justifikasi2 = ko.observable(<?php echo isset($data_sac['justifikasi2']) ? json_encode($data_sac['justifikasi2']) : "" ?>);
        self.pilih2Ya = function(indx, parent){
          $.each(self.self_assesment2(), function(i, item){
            if (item.no == parent){
              var pr = item.parent;
              self.self_assesment2()[i].pil('Ya');
              $.each(self.self_assesment2(), function(ix, itemx){
                if (itemx.no == pr){
                  self.self_assesment2()[ix].pil('Ya');
                }
              });
            }
          });

        }

        self.pilih2Tidak = function(){
          self.self_assesment2().reverse();
          var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0, child1 = 0, child0 = 0;
          $.each(self.self_assesment2(), function(i, item){

            if (item.level == 2 && item.just_header == 0) {
              pr2 = item.parent;
              if (item.pil() == 'Tidak') pil2--;
            }

            if (item.level == 1 && item.just_header == 0) {
              pr1 = item.parent;

              if (Math.abs(pil2) == item.child && pr2 == item.no){
                self.self_assesment2()[i].pil('Tidak');
              }
              if (item.pil() == 'Tidak'){
                pil2 = 0;
                pr2 = 0;
                pil1--;
              }
            }

            if (item.level == 0) {
              if (Math.abs(pil1) == item.child && pr1 == item.no){
                self.self_assesment2()[i].pil('Tidak');
              }
              if (item.pil() == 'Tidak'){
                pil1 = 0;
                pr1 = 0;
              }
            }

          })
          self.self_assesment2().reverse();

        }

        /** =========== (3) ============== **/
        self.self_assesment3 = ko.observableArray([]);
        self.justifikasi3 = ko.observable(<?php echo isset($data_sac['justifikasi3']) ? json_encode($data_sac['justifikasi3']) : ""?>);
        self.pilih3Ya = function(indx, parent){
          $.each(self.self_assesment3(), function(i, item){
            if (item.no == parent){
              var pr = item.parent;
              self.self_assesment3()[i].pil('Ya');
              $.each(self.self_assesment3(), function(ix, itemx){
                if (itemx.no == pr){
                  self.self_assesment3()[ix].pil('Ya');
                }
              });
            }
          });

        }

        self.pilih3Tidak = function(){
          self.self_assesment3().reverse();
          var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0, child1 = 0, child0 = 0;
          $.each(self.self_assesment3(), function(i, item){

            if (item.level == 2) {
              pr2 = item.parent;
              if (item.pil() == 'Tidak') pil2--;
            }

            if (item.level == 1) {
              pr1 = item.parent;
              if (Math.abs(pil2) == item.child && pr2 == item.no){
                self.self_assesment3()[i].pil('Tidak');
              }
              if (item.pil() == 'Tidak'){
                pil2 = 0;
                pr2 = 0;
                pil1--;
              }
            }

            if (item.level == 0) {
              if (Math.abs(pil1) == item.child && pr1 == item.no){
                self.self_assesment3()[i].pil('Tidak');
              }
              if (item.pil() == 'Tidak'){
                pil1 = 0;
                pr1 = 0;
              }
            }

          })
          self.self_assesment3().reverse();

        }

        /** =========== (4) ============== **/
        self.self_assesment4 = ko.observableArray([]);
        self.justifikasi4 = ko.observable(<?php echo isset($data_sac['justifikasi4']) ? json_encode($data_sac['justifikasi4']) : "" ?>);
        self.pilih4Ya = function(indx, parent){
          $.each(self.self_assesment4(), function(i, item){
            if (item.no == parent){
              var pr = item.parent;
              self.self_assesment4()[i].pil('Ya');
              $.each(self.self_assesment4(), function(ix, itemx){
                if (itemx.no == pr){
                  self.self_assesment4()[ix].pil('Ya');
                }
              });
            }
          });

        }

        self.pilih4Tidak = function(){
          self.self_assesment4().reverse();
          var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0, child1 = 0, child0 = 0;
          $.each(self.self_assesment4(), function(i, item){

            if (item.level == 2) {
              pr2 = item.parent;
              if (item.pil() == 'Tidak') pil2--;
            }

            if (item.level == 1) {
              pr1 = item.parent;
              if (Math.abs(pil2) == item.child && pr2 == item.no){
                self.self_assesment4()[i].pil('Tidak');
              }
              if (item.pil() == 'Tidak'){
                pil2 = 0;
                pr2 = 0;
                pil1--;
              }
            }

            if (item.level == 0) {
              if (Math.abs(pil1) == item.child && pr1 == item.no){
                self.self_assesment4()[i].pil('Tidak');
              }
              if (item.pil() == 'Tidak'){
                pil1 = 0;
                pr1 = 0;
              }
            }

          })
          self.self_assesment4().reverse();

        }

        /** =========== (5) ============== **/
        self.self_assesment5 = ko.observableArray([]);
        self.justifikasi5 = ko.observable(<?php echo isset($data_sac['justifikasi5']) ? json_encode($data_sac['justifikasi5']) : ""?>);
        self.pilih5Ya = function(indx, parent){
          $.each(self.self_assesment5(), function(i, item){
            if (item.no == parent){
              var pr = item.parent;
              self.self_assesment5()[i].pil('Ya');
              $.each(self.self_assesment5(), function(ix, itemx){
                if (itemx.no == pr){
                  self.self_assesment5()[ix].pil('Ya');
                }
              });
            }
          });

        }

        self.pilih5Tidak = function(){
          self.self_assesment5().reverse();
          var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0, child1 = 0, child0 = 0;
          $.each(self.self_assesment5(), function(i, item){

            if (item.level == 2) {
              pr2 = item.parent;
              if (item.pil() == 'Tidak') pil2--;
            }

            if (item.level == 1) {
              pr1 = item.parent;
              if (Math.abs(pil2) == item.child && pr2 == item.no){
                self.self_assesment5()[i].pil('Tidak');
              }
              if (item.pil() == 'Tidak'){
                pil2 = 0;
                pr2 = 0;
                pil1--;
              }
            }

            if (item.level == 0) {
              if (Math.abs(pil1) == item.child && pr1 == item.no){
                self.self_assesment5()[i].pil('Tidak');
              }
              if (item.pil() == 'Tidak'){
                pil1 = 0;
                pr1 = 0;
              }
            }

          })
          self.self_assesment5().reverse();
        }

        /** =========== (6) ============== **/
        self.self_assesment6 = ko.observableArray([]);
        self.justifikasi6 = ko.observable(<?php echo isset($data_sac['justifikasi6']) ? json_encode($data_sac['justifikasi6']) : ""?>);
        self.pilih6Ya = function(indx, parent){
          $.each(self.self_assesment6(), function(i, item){
            if (item.no == parent){
              var pr = item.parent;
              self.self_assesment6()[i].pil('Ya');
              $.each(self.self_assesment6(), function(ix, itemx){
                if (itemx.no == pr){
                  self.self_assesment6()[ix].pil('Ya');
                }
              });
            }
          });

        }

        self.pilih6Tidak = function(){
          self.self_assesment6().reverse();
          var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0, child1 = 0, child0 = 0;
          $.each(self.self_assesment6(), function(i, item){

            if (item.level == 2) {
              pr2 = item.parent;
              if (item.pil() == 'Tidak') pil2--;
            }

            if (item.level == 1) {
              pr1 = item.parent;
              if (Math.abs(pil2) == item.child && pr2 == item.no){
                self.self_assesment6()[i].pil('Tidak');
              }
              if (item.pil() == 'Tidak'){
                pil2 = 0;
                pr2 = 0;
                pil1--;
              }
            }

            if (item.level == 0) {
              if (Math.abs(pil1) == item.child && pr1 == item.no){
                self.self_assesment6()[i].pil('Tidak');
              }
              if (item.pil() == 'Tidak'){
                pil1 = 0;
                pr1 = 0;
              }
            }

          })
          self.self_assesment6().reverse();
        }

        /** =========== (7) ============== **/
        self.self_assesment7 = ko.observableArray([]);
        self.justifikasi7 = ko.observable(<?php echo isset($data_sac['justifikasi7']) ? json_encode($data_sac['justifikasi7']) : ""?>);
        self.pilih7Ya = function(indx, parent){
          $.each(self.self_assesment7(), function(i, item){
            if (item.no == parent){
              var pr = item.parent;
              self.self_assesment7()[i].pil('Ya');
              $.each(self.self_assesment7(), function(ix, itemx){
                if (itemx.no == pr){
                  self.self_assesment7()[ix].pil('Ya');
                }
              });
            }
          });

        }

        self.pilih7Tidak = function(){
          self.self_assesment7().reverse();
          var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0, child1 = 0, child0 = 0;
          $.each(self.self_assesment7(), function(i, item){

            if (item.level == 2) {
              pr2 = item.parent;
              if (item.pil() == 'Tidak') pil2--;
            }

            if (item.level == 1) {
              pr1 = item.parent;
              if (Math.abs(pil2) == item.child && pr2 == item.no){
                self.self_assesment7()[i].pil('Tidak');
              }
              if (item.pil() == 'Tidak'){
                pil2 = 0;
                pr2 = 0;
                pil1--;
              }
            }

            if (item.level == 0) {
              if (Math.abs(pil1) == item.child && pr1 == item.no){
                self.self_assesment7()[i].pil('Tidak');
              }
              if (item.pil() == 'Tidak'){
                pil1 = 0;
                pr1 = 0;
              }
            }

          })
          self.self_assesment7().reverse();
        }

    		self.processing = ko.observable(false);

    	}

    	var App = new ProtokolModel();

    	App.uraian_before = function(title, uraian){
    		var id_pep = App.id(),
    				id_pengajuan = App.id_pengajuan;

        App.load_data_sebelumnya(true);
        App.uraian_sebelumnya.removeAll();
    		$.ajax({
    	    url: '<?php echo base_url()?>perbaikan/get_uraian_before/'+id_pep+'/'+id_pengajuan+'/'+uraian,
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
    		$('#my-modal-uraian').modal('show');
        App.load_data_sebelumnya(false);
    	}

      App.showUraian = function(idx){
        $('.uraian_before').parent().addClass('hide');
        $('#'+idx).parent().removeClass('hide');
        return false;
      }

      <?php if (isset($revisi_ke) && $revisi_ke > 0) { ?>
      App.showTelaah = function(idx){
        $('.telaah_before').parent().addClass('hide');
        $('#'+idx+'_telaah_before').parent().removeClass('hide');
        return false;
      }

      App.telaah_before = function(title, subtitle, catatan){
        var id_pep_old = App.id_old,
            id_pengajuan = App.id_pengajuan;

        App.load_data_sebelumnya(true);
        App.telaah_sebelumnya.removeAll();
        $.ajax({
          url: '<?php echo base_url()?>perbaikan/get_telaah_before/'+id_pep_old+'/'+id_pengajuan+'/'+catatan,
          type: 'post',
          dataType : 'json',
          success: function(res, xhr){
            App.jumlah_telaah(res.jumlah);
            $.each(res.data, function(i, item){
              App.telaah_sebelumnya.push({tgl: item.tgl, penelaah: ko.observableArray(ko.utils.arrayMap(item.telaah, function(tlh) {
                  return ({id: tlh.id_atk, tgl: tlh.tgl, catatan: tlh.catatan})
                }))
              })
            })
          }
        })

        App.title_modal(title);
        App.subtitle_modal(subtitle);
        $('#my-modal-telaah').modal('show');
        App.load_data_sebelumnya(false);
      }
      <?php } ?>

    	App.upload = function(file){
    	  $('#'+file).trigger('click');
    	}

    	App.do_upload = function(file){
    	  var data_upload = new FormData();
    	  data_upload.append(file, $('#'+file).prop('files')[0]);

    	  switch(file){
    	  	case 'lampiran1' : $('#lampiran1-btn').button('loading'); break;
    	  	case 'lampiran2' : $('#lampiran2-btn').button('loading'); break;
    	  	case 'lampiran3' : $('#lampiran3-btn').button('loading'); break;
    	  	case 'lampiran4' : $('#lampiran4-btn').button('loading'); break;
    	  	case 'lampiran5' : $('#lampiran5-btn').button('loading'); break;
    	  	case 'lampiran6' : $('#lampiran6-btn').button('loading'); break;
    	  }

    	  $.ajax({
    	    url: '<?php echo base_url()?>perbaikan/do_upload/'+file,
    	    type: 'post',
    	    processData: false, // important
    	    contentType: false, // important
    	    dataType : 'json',
    	    data: data_upload,
    	    success: function(res, xhr){
    	      if (res.isSuccess){
    	      	if (file == 'lampiran1'){
    	      		var id = getNewid(),
    	      				upl = res.data_fileupload;
    	      		App.lampiran1.push(new Lampiran(id, upl.client_name, upl.file_name, upl.file_size, upl.file_type, upl.file_ext))
    	      	}
    	      	else if (file == 'lampiran2'){
    	      		var id = getNewid(),
    	      				upl = res.data_fileupload;
    	      		App.lampiran2.push(new Lampiran(id, upl.client_name, upl.file_name, upl.file_size, upl.file_type, upl.file_ext))
    	      	}
    	      	else if (file == 'lampiran3'){
    	      		var id = getNewid(),
    	      				upl = res.data_fileupload;
    	      		App.lampiran3.push(new Lampiran(id, upl.client_name, upl.file_name, upl.file_size, upl.file_type, upl.file_ext))
    	      	}
    	      	else if (file == 'lampiran4'){
    	      		var id = getNewid(),
    	      				upl = res.data_fileupload;
    	      		App.lampiran4.push(new Lampiran(id, upl.client_name, upl.file_name, upl.file_size, upl.file_type, upl.file_ext))
    	      	}
    	      	else if (file == 'lampiran5'){
    	      		var id = getNewid(),
    	      				upl = res.data_fileupload;
    	      		App.lampiran5.push(new Lampiran(id, upl.client_name, upl.file_name, upl.file_size, upl.file_type, upl.file_ext))
    	      	}
    	      	else if (file == 'lampiran6'){
    	      		var id = getNewid(),
    	      				upl = res.data_fileupload;
    	      		App.lampiran6.push(new Lampiran(id, upl.client_name, upl.file_name, upl.file_size, upl.file_type, upl.file_ext))
    	      	}

    	      }
    		    else show_error(true, res.message);

    	  		$('#lampiran1-btn').button('reset');
        		$('#lampiran2-btn').button('reset');
        		$('#lampiran3-btn').button('reset');
        		$('#lampiran4-btn').button('reset');
        		$('#lampiran5-btn').button('reset');
        		$('#lampiran6-btn').button('reset');
    	    }
    	  });
    	}

      App.standar_kelaikan = function(){
        var id_sac = App.id_sac() == 0 ? App.id_sac_old : App.id_sac();
            versi_jsk = App.versi_jsk;

        $.ajax({
          url: '<?php echo base_url()?>perbaikan/standar_kelaikan/'+id_sac+'/'+versi_jsk,
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
        })
      }

      App.reset1 = function(){
        ko.utils.arrayForEach(App.self_assesment1(), function(pilihan) {
          pilihan.pil('');
        });
      }

      App.reset2 = function(){
        ko.utils.arrayForEach(App.self_assesment2(), function(pilihan) {
          pilihan.pil('');
        });
      }

      App.reset3 = function(){
        ko.utils.arrayForEach(App.self_assesment3(), function(pilihan) {
          pilihan.pil('');
        });
      }

      App.reset4 = function(){
        ko.utils.arrayForEach(App.self_assesment4(), function(pilihan) {
          pilihan.pil('');
        });
      }

      App.reset5 = function(){
        ko.utils.arrayForEach(App.self_assesment5(), function(pilihan) {
          pilihan.pil('');
        });
      }

      App.reset6 = function(){
        ko.utils.arrayForEach(App.self_assesment6(), function(pilihan) {
          pilihan.pil('');
        });
      }

      App.reset7 = function(){
        ko.utils.arrayForEach(App.self_assesment7(), function(pilihan) {
          pilihan.pil('');
        });
      }

      <?php if (isset($data['klasifikasi']) && ($data['klasifikasi'] == 2 || $data['klasifikasi'] == 3)) { ?>
      App.print_catatan_telaah = function(){
        var id_old = App.id_old;

        <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] == 2) { ?>;
        window.open('<?php echo base_url()?>perbaikan/cetak_catatan_expedited/'+id_old, '_blank');
        <?php } else if (isset($data['klasifikasi']) && $data['klasifikasi'] == 3) { ?>
        window.open('<?php echo base_url()?>perbaikan/cetak_catatan_fullboard/'+id_old, '_blank');
        <?php } ?>
      }
      <?php } ?>

    	App.print_protokol = function(){
    		var id = App.id();
            id_old = App.id_old;

        if (id > 0)
      		window.open('<?php echo base_url()?>perbaikan/cetak_protokol/'+id+'/'+id_old, '_blank');
        else
          show_error(true, 'Data belum disimpan');
    	}

      App.print_sa = function(){
        var id = App.id();
            id_old = App.id_old;
            id_pengajuan = App.id_pengajuan;
            revisi_ke = App.revisi_ke;

        if (id > 0)
          window.open('<?php echo base_url()?>perbaikan/cetak_sa/'+id+'/'+id_old+'/'+id_pengajuan+'/'+revisi_ke, '_blank');
        else
          show_error(true, 'Data belum disimpan');
      }

    	App.init_lampiran = function(){
  			var id = App.id();
  					id_old = App.id_old;

  			App.lampiran1.removeAll();
  			App.lampiran2.removeAll();
  			App.lampiran3.removeAll();
  			App.lampiran4.removeAll();
  			App.lampiran5.removeAll();
  			App.lampiran6.removeAll();

  		  $.ajax({
  		    url: '<?php echo base_url()?>perbaikan/get_lampiran/'+id+'/'+id_old,
  		    type: 'post',
  		    cache: false,
  		    dataType: 'json',
  		    success: function(res, xhr){
  		    	$.each(res, function(i, item){	    		
  		      	if (item.lampiran == 1){
  		      		App.lampiran1.push(new Lampiran(item.id, item.client_name, item.file_name, item.file_size, item.file_type, item.file_ext));
  		      	}
  		      	else if (item.lampiran == 2){
  		      		App.lampiran2.push(new Lampiran(item.id, item.client_name, item.file_name, item.file_size, item.file_type, item.file_ext));
  		      	}
  		      	else if (item.lampiran == 3){
  		      		App.lampiran3.push(new Lampiran(item.id, item.client_name, item.file_name, item.file_size, item.file_type, item.file_ext));
  		      	}
  		      	else if (item.lampiran == 4){
  		      		App.lampiran4.push(new Lampiran(item.id, item.client_name, item.file_name, item.file_size, item.file_type, item.file_ext));
  		      	}
  		      	else if (item.lampiran == 5){
  		      		App.lampiran5.push(new Lampiran(item.id, item.client_name, item.file_name, item.file_size, item.file_type, item.file_ext));
  		      	}
  		      	else if (item.lampiran == 6){
  		      		App.lampiran6.push(new Lampiran(item.id, item.client_name, item.file_name, item.file_size, item.file_type, item.file_ext));
  		      	}
  		    	})

  		    }
  		  });
  		
    	}

    	App.back = function(){
    		window.location.href = '<?php echo base_url()?>perbaikan/';
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
    				  var id_pengajuan = App.id_pengajuan,
    				  		id_pep = App.id();
    				  var $btn = $('#kirim');

    				  $btn.button('loading');
    				  App.processing(true);
    				  $.ajax({
    				    url: '<?php echo base_url()?>perbaikan/kirim/'+id_pengajuan+'/'+id_pep,
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

    	App.save = function(createNew){
        var data = new Object();
            data['id'] = App.id();
            data['judul'] = App.judul;
            data['id_pengajuan'] = App.id_pengajuan;
            data['link_proposal'] = App.link_proposal();
            data['id_old'] = App.id_old;
            data['valid_protokol'] = App.valid_protokol();
    	  		data['uraianc1'] = $('#c1').html(),
    	  		data['uraianc2'] = $('#c2').html(),
    				data['uraiand1'] = $('#d1').html(),
    				data['uraiane1'] = $('#e1').html(),
    				data['uraianf1'] = $('#f1').html(),
    				data['uraianf2'] = $('#f2').html(),
    				data['uraianf3'] = $('#f3').html(),
    				data['uraiang1'] = $('#g1').html(),
    				data['uraiang2'] = $('#g2').html(),
    				data['uraiang3'] = $('#g3').html(),
    				data['uraianh1'] = $('#h1').html(),
    				data['uraianh2'] = $('#h2').html(),
    				data['uraianh3'] = $('#h3').html(),
    				data['uraiani1'] = $('#i1').html(),
    				data['uraiani2'] = $('#i2').html(),
    				data['uraiani3'] = $('#i3').html(),
    				data['uraiani4'] = $('#i4').html(),
    				data['uraianj1'] = $('#j1').html(),
    				data['uraiank1'] = $('#k1').html(),
    				data['uraianl1'] = $('#l1').html(),
    				data['uraianl2'] = $('#l2').html(),
    				data['uraianm1'] = $('#m1').html(),
    				data['uraiann1'] = $('#n1').html(),
    				data['uraiann2'] = $('#n2').html(),
    				data['uraiano1'] = $('#o1').html(),
    				data['uraianp1'] = $('#p1').html(),
    				data['uraianp2'] = $('#p2').html(),
    				data['uraianq1'] = $('#q1').html(),
    				data['uraianq2'] = $('#q2').html(),
    				data['uraianr1'] = $('#r1').html(),
    				data['uraianr2'] = $('#r2').html(),
    				data['uraianr3'] = $('#r3').html(),
    				data['uraians1'] = $('#s1').html(),
    				data['uraians2'] = $('#s2').html(),
    				data['uraians3'] = $('#s3').html(),
    				data['uraians4'] = $('#s4').html(),
    				data['uraiant1'] = $('#t1').html(),
    				data['uraianu1'] = $('#u1').html(),
    				data['uraianv1'] = $('#v1').html(),
    				data['uraianw1'] = $('#w1').html(),
    				data['uraianw2'] = $('#w2').html(),
    				data['uraianx1'] = $('#x1').html(),
    				data['uraiany1'] = $('#y1').html(),
    				data['uraiany2'] = $('#y2').html(),
    				data['uraianz1'] = $('#z1').html(),
    				data['uraianaa1'] = $('#aa1').html(),
    				data['uraianaa2'] = $('#aa2').html(),
    				data['uraianaa3'] = $('#aa3').html(),
    				data['uraianbb1'] = $('#bb1').html();

            data['lampiran1'] = App.lampiran1();
            data['lampiran2'] = App.lampiran2();
            data['lampiran3'] = App.lampiran3();
            data['lampiran4'] = App.lampiran4();
            data['lampiran5'] = App.lampiran5();
            data['lampiran6'] = App.lampiran6();
    				data['purge_lampiran1'] = purge_lampiran1,
    				data['purge_lampiran2'] = purge_lampiran2,
    				data['purge_lampiran3'] = purge_lampiran3,
    				data['purge_lampiran4'] = purge_lampiran4,
    				data['purge_lampiran5'] = purge_lampiran5,
    				data['purge_lampiran6'] = purge_lampiran6;

    				data['purge_filename1'] = purge_filename1,
    				data['purge_filename2'] = purge_filename2,
    				data['purge_filename3'] = purge_filename3,
    				data['purge_filename4'] = purge_filename4,
    				data['purge_filename5'] = purge_filename5,
    				data['purge_filename6'] = purge_filename6;

            data['id_sac'] = App.id_sac();
            data['id_sac_old'] = App.id_sac_old;
            data['justifikasi1'] = App.justifikasi1();
            data['justifikasi2'] = App.justifikasi2();
            data['justifikasi3'] = App.justifikasi3();
            data['justifikasi4'] = App.justifikasi4();
            data['justifikasi5'] = App.justifikasi5();
            data['justifikasi6'] = App.justifikasi6();
            data['justifikasi7'] = App.justifikasi7();
            data['versi_jsk'] = App.versi_jsk;
            data['self_assesment1'] = JSON.stringify(ko.toJS(App.self_assesment1()));
            data['self_assesment2'] = JSON.stringify(ko.toJS(App.self_assesment2()));
            data['self_assesment3'] = JSON.stringify(ko.toJS(App.self_assesment3()));
            data['self_assesment4'] = JSON.stringify(ko.toJS(App.self_assesment4()));
            data['self_assesment5'] = JSON.stringify(ko.toJS(App.self_assesment5()));
            data['self_assesment6'] = JSON.stringify(ko.toJS(App.self_assesment6()));
            data['self_assesment7'] = JSON.stringify(ko.toJS(App.self_assesment7()));

    	  var $btn = $('#submit');

    	  $btn.button('loading');
    	  App.processing(true);
    	  $.ajax({
    	    url: '<?php echo base_url()?>perbaikan/proses',
    	    type: 'post',
    	    cache: false,
    	    dataType: 'json',
    	    data: data,
    	    success: function(res, xhr){
    	      if (res.isSuccess){
    	      	App.id(res.id);
              App.id_sac(res.id_sac);
    	      	App.mode('edit');
    	      	App.init_lampiran();
    	      	show_success(true, res.message);
    	      }
    	      else show_error(true, res.message);

    	      $btn.button('reset');
    	      App.processing(false);
    	    }
    	  });

    	}

    	ko.applyBindings(App);

    </script>
