    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
    <script src="<?php echo base_url()?>assets/js/select2.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/id.js"></script>
    <script src="<?php echo base_url()?>assets/js/wizard.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.hotkeys.index.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap-wysiwyg.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.easypiechart.min.js"></script>

    <script type="text/javascript">
    	var purge_pe = [], purge_lp = [], purge_konsultan = [];
    	var pe = <?php echo isset($penelaah_etik) ? json_encode($penelaah_etik) : "''" ?>;
    			lp = <?php echo isset($lay_person) ? json_encode($lay_person) : "''" ?>;
    			ki = <?php echo isset($konsultan) ? json_encode($konsultan) : "''" ?>;

    	jQuery(function($) {
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

    		$('#catatan').html('<?php echo isset($data['catatan']) ? $data['catatan'] : ''?>');

    		$('.easy-pie-chart.percentage').each(function(){
    			var barColor = $(this).data('color') || '#555';
    			var trackColor = '#E2E2E2';
    			var size = parseInt($(this).data('size')) || 72;
    			$(this).easyPieChart({
    				barColor: barColor,
    				trackColor: trackColor,
    				scaleColor: false,
    				lineCap: 'butt',
    				lineWidth: parseInt(size/10),
    				animate:false,
    				size: size
    			}).css('color', barColor);
    		});

        $(".select2").select2({
          placeholder: "Pilih...",
          language: "id",
          allowClear: true,
          width: '100%'
        });

        $('#id_pep').on('select2:select', function(e){
          var pep = $('#id_pep').text().trim();
              res = pep.split(' - ');
          App.no_protokol(res[0]);
          App.get_persen_klasifikasi();
					App.get_resume();
          App.get_telaah_awal();
          App.get_standar_kelaikan();
        });

        $('#penelaah_etik').on('select2:select', function(e){
          var pelapor = $("#pelapor option").map(function() {return $(this).val();}).get();
              id = '', teks = '';
          $("#penelaah_etik option:selected").each(function() {
            var id = $(this).val();
                teks = $(this).text();

            if ($.inArray(id, pelapor) < 0){
              var newOption = new Option(teks, id, false, false);
              $('#pelapor').append(newOption).trigger('change');
            }
          });

        })

        $('#penelaah_etik').on('select2:unselect', function(e){
          var id = e.params.data.id;

          $('#pelapor option[value="'+id+'"]').remove().trigger('change');
          $('#pelapor').val('').trigger('change');
          if ($.inArray(id, purge_pe) < 0)
            purge_pe.push(id);
        })

        $('#lay_person').on('select2:select', function(e){
          var id = e.params.data.id;
          if ($.inArray(id, purge_lp) < 0)
            purge_lp.push(id);
        })

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

        <?php if (isset($_GET['id_pep'])) { ?>
          var id_pep = <?php echo $_GET['id_pep'] ?>;
          $('#id_pep').val(id_pep).trigger("change");
          App.id_pep(id_pep);

          var pep = $('#id_pep').text().trim();
              res = pep.split(' - ');
          App.no_protokol(res[0]);
          App.get_persen_klasifikasi();
					App.get_resume();
          App.get_telaah_awal();
          App.get_standar_kelaikan();
        <?php } ?>

    	});

    	function formatTwoDec(value) {
    		return value.toFixed(2);
    	}

    	function showErrorAlert (reason, detail) {
    		var msg='';
    		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
    		else {
    			//console.log("error uploading file", reason, detail);
    		}
    		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
    		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
    	}

    	var PeExempted = function(nomor, nama){
    		this.nomor = nomor;
    		this.nama = nama;
    	}

    	var PeExpedited = function(nomor, nama){
    		this.nomor = nomor;
    		this.nama = nama;
    	}

    	var PeFullBoard = function(nomor, nama){
    		this.nomor = nomor;
    		this.nama = nama;
    	}

			var Resume = function(id_atk, no_atk, nama_sekretaris, resume_sekretaris){
				this.id_atk = id_atk;
				this.no_atk = no_atk;
				this.nama_sekretaris = nama_sekretaris;
				this.resume_sekretaris = resume_sekretaris;
			}

			var TelaahAwal = function(id_ta, id_atk, no_atk, nama_penelaah, klasifikasi_usulan, catatan_protokol, catatan_7standar){
				this.id_ta = id_ta;
				this.id_atk = id_atk;
				this.no_atk = no_atk;
				this.nama_penelaah = nama_penelaah;
				this.klasifikasi_usulan = klasifikasi_usulan;
				this.catatan_protokol = catatan_protokol;
				this.catatan_7standar = catatan_7standar;
			}

    	var SKEP = function(id, no_tampilan, no, idx_std, parent, child, level, uraian, uraian_master, pil_pengaju, pil_ketua, just_header){
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
    		this.pil_ketua = ko.observable(pil_ketua);
        this.just_header = just_header;
    	}

    	var PutusanTAModel = function(){
    		var self = this;
    		self.id = ko.observable(<?php echo isset($data['id_pa']) ? $data['id_pa'] : 0?>);
    		self.id_pep = ko.observable(<?php echo isset($data['id_pep']) ? $data['id_pep'] : 0 ?>);
    		self.no_protokol = ko.observable('<?php echo isset($data['no_protokol']) ? $data['no_protokol'] : ''?>');
    		self.persen1 = ko.observable(0);
    		self.persen2 = ko.observable(0);
    		self.persen3 = ko.observable(0);
    		self.jml_penelaah = ko.observable(0);
    		self.resume = ko.observableArray([]);
    		self.telaah_awal = ko.observableArray([]);
    		self.klasifikasi = ko.observable('<?php echo isset($data['klasifikasi']) ? $data['klasifikasi'] : ''?>');
    	  self.penelaah_etik = ko.observableArray([]);
    	  self.lay_person = ko.observableArray([]);
    	  self.konsultan = ko.observableArray([]);
    	  self.pe_exempted = ko.observableArray([]);
    	  self.pe_expedited = ko.observableArray([]);
    	  self.pe_fullboard = ko.observableArray([]);
    	  self.pelapor = ko.observable('<?php echo isset($data['id_atk_pelapor']) ? $data['id_atk_pelapor'] : ''?>');
    	  self.checkKlasifikasi = ko.pureComputed(function(){
    	  	if (self.klasifikasi() == 2) return 'Expedited';
    	  	else if (self.klasifikasi() == 3) return 'Full Board';
    	  	else return 'Expedited atau Full Board'
    	  });
    		self.keputusan = '<?php echo isset($data['keputusan']) ? $data['keputusan'] : '' ?>';
    		self.lbl_keputusan = ko.pureComputed(function(){
    			switch(self.keputusan){
    				case 'LE' : var lbl = 'Layak Etik'; break;
    				case 'R' : var lbl = 'Perbaikan'; break;
    				case 'F' : var lbl = 'Full Board'; break;
    			}

    			return lbl;
    		});

    		/** =========== (1) ============== **/
    		self.self_assesment1 = ko.observableArray([]);
    		self.pilih1Ya = function(indx, parent){
    			$.each(self.self_assesment1(), function(i, item){
    				if (item.no == parent){
    					var pr = item.parent;
    					self.self_assesment1()[i].pil_ketua('Ya');
    					$.each(self.self_assesment1(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment1()[ix].pil_ketua('Ya');
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
              if (item.pil_ketua() == 'Tidak') pil2--;
              else pil2 = 0;
            }

            if (item.level == 1) {
              pr1 = item.parent;
              if (Math.abs(pil2) == item.child && pr2 == item.no){
                self.self_assesment1()[i].pil_ketua('Tidak');
              }
              if (item.pil_ketua() == 'Tidak'){
                pil2 = 0;
                pr2 = 0;
                pil1--;
              }
            }

            if (item.level == 0) {
              if (Math.abs(pil1) == item.child && pr1 == item.no){
                self.self_assesment1()[i].pil_ketua('Tidak');
              }
              if (item.pil_ketua() == 'Tidak'){
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
    					self.self_assesment2()[i].pil_ketua('Ya');
    					$.each(self.self_assesment2(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment2()[ix].pil_ketua('Ya');
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
              if (item.pil_ketua() == 'Tidak') pil2--;
              else pil2 = 0;
            }

            if (item.level == 1) {
              pr1 = item.parent;
              if (Math.abs(pil2) == item.child && pr2 == item.no){
                self.self_assesment2()[i].pil_ketua('Tidak');
              }
              if (item.pil_ketua() == 'Tidak'){
                pil2 = 0;
                pr2 = 0;
                pil1--;
              }
            }

            if (item.level == 0) {
              if (Math.abs(pil1) == item.child && pr1 == item.no){
                self.self_assesment2()[i].pil('Tidak');
              }
              if (item.pil_ketua() == 'Tidak'){
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
    					self.self_assesment3()[i].pil_ketua('Ya');
    					$.each(self.self_assesment3(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment3()[ix].pil_ketua('Ya');
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
              if (item.pil_ketua() == 'Tidak') pil2--;
              else pil2 = 0;
            }

            if (item.level == 1) {
              pr1 = item.parent;
              if (Math.abs(pil2) == item.child && pr2 == item.no){
                self.self_assesment3()[i].pil_ketua('Tidak');
              }
              if (item.pil_ketua() == 'Tidak'){
                pil2 = 0;
                pr2 = 0;
                pil1--;
              }
            }

            if (item.level == 0) {
              if (Math.abs(pil1) == item.child && pr1 == item.no){
                self.self_assesment3()[i].pil_ketua('Tidak');
              }
              if (item.pil_ketua() == 'Tidak'){
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
    					self.self_assesment4()[i].pil_ketua('Ya');
    					$.each(self.self_assesment4(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment4()[ix].pil_ketua('Ya');
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
              if (item.pil_ketua() == 'Tidak') pil2--;
              else pil2 = 0;
            }

            if (item.level == 1) {
              pr1 = item.parent;
              if (Math.abs(pil2) == item.child && pr2 == item.no){
                self.self_assesment4()[i].pil_ketua('Tidak');
              }
              if (item.pil_ketua() == 'Tidak'){
                pil2 = 0;
                pr2 = 0;
                pil1--;
              }
            }

            if (item.level == 0) {
              if (Math.abs(pil1) == item.child && pr1 == item.no){
                self.self_assesment4()[i].pil_ketua('Tidak');
              }
              if (item.pil_ketua() == 'Tidak'){
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
    					self.self_assesment5()[i].pil_ketua('Ya');
    					$.each(self.self_assesment5(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment5()[ix].pil_ketua('Ya');
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
              if (item.pil_ketua() == 'Tidak') pil2--;
              else pil2 = 0;
            }

            if (item.level == 1) {
              pr1 = item.parent;
              if (Math.abs(pil2) == item.child && pr2 == item.no){
                self.self_assesment5()[i].pil_ketua('Tidak');
              }
              if (item.pil_ketua() == 'Tidak'){
                pil2 = 0;
                pr2 = 0;
                pil1--;
              }
            }

            if (item.level == 0) {
              if (Math.abs(pil1) == item.child && pr1 == item.no){
                self.self_assesment5()[i].pil_ketua('Tidak');
              }
              if (item.pil_ketua() == 'Tidak'){
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
    					self.self_assesment6()[i].pil_ketua('Ya');
    					$.each(self.self_assesment6(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment6()[ix].pil_ketua('Ya');
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
              if (item.pil_ketua() == 'Tidak') pil2--;
              else pil2 = 0;
            }

            if (item.level == 1) {
              pr1 = item.parent;
              if (Math.abs(pil2) == item.child && pr2 == item.no){
                self.self_assesment6()[i].pil_ketua('Tidak');
              }
              if (item.pil_ketua() == 'Tidak'){
                pil2 = 0;
                pr2 = 0;
                pil1--;
              }
            }

            if (item.level == 0) {
              if (Math.abs(pil1) == item.child && pr1 == item.no){
                self.self_assesment6()[i].pil_ketua('Tidak');
              }
              if (item.pil_ketua() == 'Tidak'){
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
    					self.self_assesment7()[i].pil_ketua('Ya');
    					$.each(self.self_assesment7(), function(ix, itemx){
    						if (itemx.no == pr){
    							self.self_assesment7()[ix].pil_ketua('Ya');
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
              if (item.pil_ketua() == 'Tidak') pil2--;
              else pil2 = 0;
            }

            if (item.level == 1) {
              pr1 = item.parent;
              if (Math.abs(pil2) == item.child && pr2 == item.no){
                self.self_assesment7()[i].pil_ketua('Tidak');
              }
              if (item.pil_ketua() == 'Tidak'){
                pil2 = 0;
                pr2 = 0;
                pil1--;
              }
            }

            if (item.level == 0) {
              if (Math.abs(pil1) == item.child && pr1 == item.no){
                self.self_assesment7()[i].pil_ketua('Tidak');
              }
              if (item.pil_ketua() == 'Tidak'){
                pil1 = 0;
                pr1 = 0;
              }
            }

          })
          self.self_assesment7().reverse();
    		}

    		self.processing = ko.observable(false);
    	}

    	var App = new PutusanTAModel();

    	App.reset1 = function(){
    	  ko.utils.arrayForEach(App.self_assesment1(), function(pilihan) {
    	  	pilihan.pil_ketua('');
    	  });
    	}

    	App.reset2 = function(){
    	  ko.utils.arrayForEach(App.self_assesment2(), function(pilihan) {
    	  	pilihan.pil_ketua('');
    	  });
    	}

    	App.reset3 = function(){
    	  ko.utils.arrayForEach(App.self_assesment3(), function(pilihan) {
    	  	pilihan.pil_ketua('');
    	  });
    	}

    	App.reset4 = function(){
    	  ko.utils.arrayForEach(App.self_assesment4(), function(pilihan) {
    	  	pilihan.pil_ketua('');
    	  });
    	}

    	App.reset5 = function(){
    	  ko.utils.arrayForEach(App.self_assesment5(), function(pilihan) {
    	  	pilihan.pil_ketua('');
    	  });
    	}

    	App.reset6 = function(){
    	  ko.utils.arrayForEach(App.self_assesment6(), function(pilihan) {
    	  	pilihan.pil_ketua('');
    	  });
    	}

    	App.reset7 = function(){
    	  ko.utils.arrayForEach(App.self_assesment7(), function(pilihan) {
    	  	pilihan.pil_ketua('');
    	  });
    	}

    	App.get_persen_klasifikasi = function(){
    		var id_pep = App.id_pep();

    		$.ajax({
    			url: '<?php echo base_url()?>putusan_awal/get_persen_klasifikasi/'+id_pep,
    			type: 'post',
    			cache: false,
    			dataType: 'json',
    			success: function(res, xhr){
    				if (res.isSuccess){
    					App.persen1( formatTwoDec(res.persen1) );
    					$('#persen1').data('easyPieChart').update(res.persen1);
    					App.persen2( formatTwoDec(res.persen2) );
    					$('#persen2').data('easyPieChart').update(res.persen2);
    					App.persen3( formatTwoDec(res.persen3) );
    					$('#persen3').data('easyPieChart').update(res.persen3);
    					App.jml_penelaah(res.total);
    				}
    				else{
    					$('#persen1').data('easyPieChart').update(0);
    					App.persen2(0);
    					$('#persen2').data('easyPieChart').update(0);
    					App.persen3(0);
    					$('#persen3').data('easyPieChart').update(0);
    					App.jml_penelaah(0);
    				}
    			}
    		})
    	}

			App.get_resume = function(){
    		var id_pep = App.id_pep();
				App.resume.removeAll();
    		$.ajax({
    			url: '<?php echo base_url()?>putusan_awal/get_resume/'+id_pep,
    			type: 'post',
    			cache: false,
    			dataType: 'json',
    			success: function(res, xhr){
    				if (res.length > 0){
    					$.each(res, function(i, item){
								App.resume.push(new Resume(item.id_atk, item.nomor, item.nama, item.resume));
    					})
    				}
    			}
    		})
			}

    	App.get_telaah_awal = function(){
    		var id_pep = App.id_pep();
    		App.pe_exempted.removeAll();
    		App.pe_expedited.removeAll();
    		App.pe_fullboard.removeAll();
				App.telaah_awal.removeAll();
    		$.ajax({
    			url: '<?php echo base_url()?>putusan_awal/get_telaah_awal/'+id_pep,
    			type: 'post',
    			cache: false,
    			dataType: 'json',
    			success: function(res, xhr){
    				if (res.length > 0){
    					$.each(res, function(i, item){
								App.telaah_awal.push(new TelaahAwal(item.id_ta, item.id_atk, item.nomor, item.nama, item.klasifikasi, item.catatan_protokol, item.catatan_7standar));
    						if (item.klasifikasi == 1) 
    							App.pe_exempted.push(new PeExempted(item.nomor, item.nama));
    						else if (item.klasifikasi == 2)
    							App.pe_expedited.push(new PeExpedited(item.nomor, item.nama));
    						else if (item.klasifikasi == 3)
    							App.pe_fullboard.push(new PeFullBoard(item.nomor, item.nama));

								if (App.id() == 0) {
									App.penelaah_etik.push(item.id_atk);
									var newOption = new Option(item.nomor+' - '+item.nama, item.id_atk, true, true);
			            $('#pelapor').append(newOption);
								}
    					})

							if (App.id() == 0) {
								$('#pelapor').val('');
								$('#penelaah_etik').trigger("change");
								$('#pelapor').trigger("change");
							}
    				}
    			}
    		})
    	}

    	App.get_standar_kelaikan = function(){
    		var id = App.id(),
    				id_pep = App.id_pep();

    		if (id_pep > 0)
    		{
    			$.ajax({
    				url: '<?php echo base_url()?>putusan_awal/get_standar_kelaikan/'+id+'/'+id_pep,
    				type: 'post',
    				cache: false,
    				dataType: 'json',
    				success: function(res, xhr){
    					$.each(res, function(i, item){
    						if (item.idx_std == 1){
    			     		App.self_assesment1.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_ketua, item.just_header) );
    						}
    						else if (item.idx_std == 2){
    			     		App.self_assesment2.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian,item.uraian_master, item.pil_pengaju, item.pil_ketua, item.just_header) );
    						}
    						else if (item.idx_std == 3){
    			     		App.self_assesment3.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_ketua, item.just_header) );
    						}
    						else if (item.idx_std == 4){
    			     		App.self_assesment4.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_ketua, item.just_header) );
    						}
    						else if (item.idx_std == 5){
    			     		App.self_assesment5.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_ketua, item.just_header) );
    						}
    						else if (item.idx_std == 6){
    			     		App.self_assesment6.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_ketua, item.just_header) );
    						}
    						else if (item.idx_std == 7){
    			     		App.self_assesment7.push( new SKEP(item.id, item.no_tampilan, item.no, item.idx_std, item.parent, item.child, item.level, item.uraian, item.uraian_master, item.pil_pengaju, item.pil_ketua, item.just_header) );
    						}
    			    });

              App.default_pilihan();
    				}
    			})
    		}
    	}

      App.default_pilihan = function(){
        $.each(App.self_assesment1(), function(i, item){
          if (item.no_tampilan == '1.2') { 
            item.pil_ketua('Ya');
            App.pilih1Ya(i, item.parent);
          }
          if (item.no_tampilan == '1.3') {
            item.pil_ketua('Ya');
            App.pilih1Ya(i, item.parent);
          }
        })

        $.each(App.self_assesment2(), function(i, item){
          if (item.id == 15) {
            item.pil_ketua('Ya');
            App.pilih2Ya(i, item.parent);
          }
          if (item.id == 16) {
            item.pil_ketua('Ya');
            App.pilih2Ya(i, item.parent);
          }
          if (item.id == 17) {
            item.pil_ketua('Ya');
            App.pilih2Ya(i, item.parent);
          }
          if (item.id == 18) {
            item.pil_ketua('Ya');
            App.pilih2Ya(i, item.parent);
          }
          if (item.id == 19) {
            item.pil_ketua('Ya');
            App.pilih2Ya(i, item.parent);
          }
          if (item.id == 23) {
            item.pil_ketua('Ya');
            App.pilih2Ya(i, item.parent);
          }
        })

        $.each(App.self_assesment3(), function(i, item){
          if (item.no_tampilan == '3.2') { 
            item.pil_ketua('Ya');
            App.pilih3Ya(i, item.parent);
          }
        })

        $.each(App.self_assesment4(), function(i, item){
          if (item.no_tampilan == '4.1') { 
            item.pil_ketua('Ya');
            App.pilih4Ya(i, item.parent);
          }
        })

        $.each(App.self_assesment5(), function(i, item){
          if (item.no_tampilan == '5.1') { 
            item.pil_ketua('Ya');
            App.pilih5Ya(i, item.parent);
          }
        })

        $.each(App.self_assesment6(), function(i, item){
          if (item.id == 100) { 
            item.pil_ketua('Ya');
            App.pilih6Ya(i, item.parent);
          }
        })

        $.each(App.self_assesment7(), function(i, item){
          if (item.no_tampilan == 7) { 
            item.pil_ketua('Ya');
            App.pilih7Ya(i, item.parent);
          }
        })
      }

    	App.save = function(createNew){
    	  var data = JSON.parse(ko.toJSON(App));
    			  data['purge_pe'] = purge_pe;
    			  data['purge_lp'] = purge_lp;
    	      data['self_assesment1'] = JSON.stringify(ko.toJS(App.self_assesment1()));
    	      data['self_assesment2'] = JSON.stringify(ko.toJS(App.self_assesment2()));
    	      data['self_assesment3'] = JSON.stringify(ko.toJS(App.self_assesment3()));
    	      data['self_assesment4'] = JSON.stringify(ko.toJS(App.self_assesment4()));
    	      data['self_assesment5'] = JSON.stringify(ko.toJS(App.self_assesment5()));
    	      data['self_assesment6'] = JSON.stringify(ko.toJS(App.self_assesment6()));
    	      data['self_assesment7'] = JSON.stringify(ko.toJS(App.self_assesment7()));
    			  data['catatan'] = $('#catatan').html();
    	  var $btn = $('#submit');

    	  $btn.button('loading');
    	  App.processing(true);
    	  $.ajax({
    	    url: '<?php echo base_url()?>putusan_awal/proses',
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
    		window.location.href = '<?php echo base_url()?>putusan_awal/';
    	}

    	App.print_telaah_awal = function(id_ta){
    		window.open('<?php echo base_url()?>putusan_awal/cetak_telaah_awal/'+id_ta, '_blank');
    	}

      ko.applyBindings(App);

      <?php if (isset($data['id_pa']) && $data['id_pa'] > 0) { ?>
        App.get_persen_klasifikasi();
        App.get_telaah_awal();
        App.get_standar_kelaikan();

        if (pe.length > 0)
        {
          $.each(pe, function(i, item){
            App.penelaah_etik.push(item.id_atk_penelaah);
            var newOption = new Option(item.nomor+' - '+item.nama, item.id_atk_penelaah, true, true);
            $('#pelapor').append(newOption);
          })
          $('#penelaah_etik').trigger("change");
          $('#pelapor').trigger("change");
        }
        if (lp.length > 0)
        {
          $.each(lp, function(i, item){
            App.lay_person.push(item.id_atk_lay_person);
          })
          $('#lay_person').trigger("change");
        }
        if (ki.length > 0)
        {
          $.each(ki, function(i, item){
            App.konsultan.push(item.id_atk_konsultan);
          })
          $('#konsultan').trigger("change");
        }

        $('#pelapor').val('<?php echo isset($data['id_atk_pelapor']) ? $data['id_atk_pelapor'] : ''?>');
        $('#pelapor').trigger("change");
        App.pelapor('<?php echo isset($data['id_atk_pelapor']) ? $data['id_atk_pelapor'] : ''?>');
      <?php } ?>
    </script>
