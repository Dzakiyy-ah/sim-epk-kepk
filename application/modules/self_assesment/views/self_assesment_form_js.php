    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
    <script src="<?php echo base_url()?>assets/js/select2.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/id.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootbox.js"></script>
    <script src="<?php echo base_url()?>assets/js/wizard.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/autosize.min.js"></script>

    <script type="text/javascript">
    	jQuery(function($) {
        $(".select2").select2({
          placeholder: "Pilih...",
          language: "id",
          allowClear: true
        });
	
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
    			if (App.is_resume == 0)
    				App.save();
    		})
    		.on('stepclick.fu.wizard', function(e){
    			//e.preventDefault();//this will prevent clicking and selecting steps
    		});
    					
    		$('#modal-wizard-container').ace_wizard();
    		$('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');
    		
    		$(document).one('ajaxloadstart.page', function(e) {
    			//in ajax mode, remove remaining elements before leaving page
    			$('[class*=select2]').remove();
    		});

    		$.ajax({
    	    url: '<?php echo base_url()?>self_assesment/standar_kelaikan/'+App.id(),
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


    	})

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

    	var SAModel = function(){
    		var self = this;
    		self.id = ko.observable(<?php echo isset($data['id_sac']) ? $data['id_sac'] : 0 ?>);
    		self.id_pengajuan = ko.observable(<?php echo isset($data['id_pengajuan']) ? $data['id_pengajuan'] : 0 ?>);

    		/** =========== (1) ============== **/
    		self.self_assesment1 = ko.observableArray([]);
    		self.justifikasi1 = ko.observable(<?php echo isset($data['justifikasi1']) ? json_encode($data['justifikasi1']) : "" ?>);
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
          var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0;
          $.each(self.self_assesment1(), function(i, item){
            if (item.level == 2) {
              pr2 = item.parent;
              if (item.pil() == 'Tidak') pil2--;
              else pil2 = 0;
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
    		self.justifikasi2 = ko.observable(<?php echo isset($data['justifikasi2']) ? json_encode($data['justifikasi2']) : "" ?>);
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
    			var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0;
    			$.each(self.self_assesment2(), function(i, item){
    				if (item.level == 2) {
              pr2 = item.parent;
    					if (item.pil() == 'Tidak') pil2--;
              else pil2 = 0;
    				}

    				if (item.level == 1) {
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
    		self.justifikasi3 = ko.observable(<?php echo isset($data['justifikasi3']) ? json_encode($data['justifikasi3']) : ""?>);
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
          var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0;
          $.each(self.self_assesment3(), function(i, item){
            if (item.level == 2) {
              pr2 = item.parent;
              if (item.pil() == 'Tidak') pil2--;
              else pil2 = 0;
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
    		self.justifikasi4 = ko.observable(<?php echo isset($data['justifikasi4']) ? json_encode($data['justifikasi4']) : "" ?>);
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
          var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0;
          $.each(self.self_assesment4(), function(i, item){
            if (item.level == 2) {
              pr2 = item.parent;
              if (item.pil() == 'Tidak') pil2--;
              else pil2 = 0;
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
    		self.justifikasi5 = ko.observable(<?php echo isset($data['justifikasi5']) ? json_encode($data['justifikasi5']) : ""?>);
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
    			var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0;
    			$.each(self.self_assesment5(), function(i, item){
    				if (item.level == 2) {
    					pr2 = item.parent;
    					if (item.pil() == 'Tidak') pil2--;
              else pil2 = 0;
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
    		self.justifikasi6 = ko.observable(<?php echo isset($data['justifikasi6']) ? json_encode($data['justifikasi6']) : ""?>);
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
    			var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0;
    			$.each(self.self_assesment6(), function(i, item){
    				if (item.level == 2) {
    					pr2 = item.parent;
    					if (item.pil() == 'Tidak') pil2--;
              else pil2 = 0;
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
    		self.justifikasi7 = ko.observable(<?php echo isset($data['justifikasi7']) ? json_encode($data['justifikasi7']) : ""?>);
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
    			var pil2 = 0, pil1 = 0, pr2 = 0, pr1 = 0;
    			$.each(self.self_assesment7(), function(i, item){
    				if (item.level == 2) {
    					pr2 = item.parent;
    					if (item.pil() == 'Tidak') pil2--;
              else pil2 = 0;
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

    		self.is_resume = <?php echo isset($is_resume) ? $is_resume : 0 ?>;
    		self.is_kirim = ko.observable(<?php echo isset($is_kirim) ? $is_kirim : 0 ?>);
    		self.lbl_btn_kirim = ko.pureComputed(function(){
    			if (self.is_kirim() == 1) 
    				return 'Terkirim';

    			return 'Kirim';
    		});
    		self.klasifikasi = <?php echo isset($klasifikasi['klasifikasi']) ? $klasifikasi['klasifikasi'] : 0 ?>;
    		self.lbl_klasifikasi = ko.pureComputed(function(){
    			switch(self.klasifikasi){
    				case 1 : var lbl = 'Exempted'; break;
    				case 2 : var lbl = 'Expedited'; break;
    				case 3 : var lbl = 'Full Board'; break;
    			}

    			return lbl;
    		});
    		self.keputusan = '<?php echo isset($keputusan['keputusan']) ? $keputusan['keputusan'] : '' ?>';
    		self.lbl_keputusan = ko.pureComputed(function(){
    			switch(self.keputusan){
    				case 'LE' : var lbl = 'Layak Etik'; break;
    				case 'R' : var lbl = 'Perbaikan'; break;
    				case 'F' : var lbl = 'Full Board'; break;
    			}

    			return lbl;
    		});
    		self.processing = ko.observable(false);
    	}

    	var App = new SAModel();

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

    	App.back = function(){
    		window.location.href = '<?php echo base_url()?>self_assesment/';
    	}

      App.id_pengajuan.subscribe(function(newValue){
        if (parseInt(newValue) > 0 && App.id() == 0)
        {
    			$.each(App.self_assesment1(), function(i, item){
    				if (item.no_tampilan == '1.2') { 
              item.pil('Ya');
              App.pilih1Ya(i, item.parent);
            }
    				if (item.no_tampilan == '1.3') {
              item.pil('Ya');
              App.pilih1Ya(i, item.parent);
            }
    			})

    			$.each(App.self_assesment2(), function(i, item){
    				if (item.id == 15) {
              item.pil('Ya');
              App.pilih2Ya(i, item.parent);
            }
    				if (item.id == 16) {
              item.pil('Ya');
              App.pilih2Ya(i, item.parent);
            }
    				if (item.id == 17) {
              item.pil('Ya');
              App.pilih2Ya(i, item.parent);
            }
    				if (item.id == 18) {
              item.pil('Ya');
              App.pilih2Ya(i, item.parent);
            }
    				if (item.id == 19) {
              item.pil('Ya');
              App.pilih2Ya(i, item.parent);
            }
    				if (item.id == 23) {
              item.pil('Ya');
              App.pilih2Ya(i, item.parent);
            }
    			})

    			$.each(App.self_assesment3(), function(i, item){
    				if (item.no_tampilan == '3.2') { 
              item.pil('Ya');
              App.pilih3Ya(i, item.parent);
            }
    			})

    			$.each(App.self_assesment4(), function(i, item){
    				if (item.no_tampilan == '4.1') { 
              item.pil('Ya');
              App.pilih4Ya(i, item.parent);
            }
    			})

    			$.each(App.self_assesment5(), function(i, item){
    				if (item.no_tampilan == '5.1') { 
              item.pil('Ya');
              App.pilih5Ya(i, item.parent);
            }
    			})

    			$.each(App.self_assesment6(), function(i, item){
    				if (item.id == 100) { 
              item.pil('Ya');
              App.pilih6Ya(i, item.parent);
            }
    			})

    			$.each(App.self_assesment7(), function(i, item){
    				if (item.no_tampilan == 7) { 
              item.pil('Ya');
              App.pilih7Ya(i, item.parent);
            }
    			})

        }
      })

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
    				  var id_pengajuan = App.id_pengajuan();
    				  var $btn = $('#kirim');

    				  $btn.button('loading');
    				  App.processing(true);
    				  $.ajax({
    				    url: '<?php echo base_url()?>self_assesment/kirim/'+id_pengajuan,
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
    	  var data = JSON.parse(ko.toJSON(App));
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
    	    url: '<?php echo base_url()?>self_assesment/proses',
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

    	App.print = function(){
    		var id = App.id();
    		window.open('<?php echo base_url()?>self_assesment/cetak_sa/'+id, '_blank');
    	}

      App.print_protokol = function(){
        var id_pengajuan = App.id_pengajuan();

        if (id_pengajuan == "")
          show_error(true, 'Protokol belum dipilih')
        else
          window.open('<?php echo base_url()?>self_assesment/cetak_protokol/'+id_pengajuan, '_blank');
      }

    	ko.applyBindings(App);
    </script>
