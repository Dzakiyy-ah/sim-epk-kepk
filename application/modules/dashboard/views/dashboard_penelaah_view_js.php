    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootbox.js"></script>
    
    <script type="text/javascript">
    		
    	jQuery(function($) {

        $('.scrollable').each(function () {
          var $this = $(this);
          $(this).ace_scroll({
            size: $this.attr('data-size') || 100,
            //styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
          });
        });
    				
        App.init_protokol_belum_kirim();
    	});

      var ResumePenelaah = function(id, no, judul, waktu, revisi_ke, hari_ke) {
        this.id = id;
        this.no = no;
        this.judul = judul;
        this.waktu = waktu;
        this.revisi_ke = revisi_ke;
        this.hari_ke = hari_ke;
        this.url_edit = ko.pureComputed(function(){
          return '<?php echo base_url()?>resume_penelaah/form/0/'+id;
        })
      }

    	var TelaahAwal = function(id, no, judul, waktu, revisi_ke, hari_ke) {
    		this.id = id;
    		this.no = no;
    		this.judul = judul;
    		this.waktu = waktu;
    		this.revisi_ke = revisi_ke;
    		this.hari_ke = hari_ke;
    		this.url_edit = ko.pureComputed(function(){
    			return '<?php echo base_url()?>telaah_awal/form/0/'+id;
    		})
    	}

    	var TelaahPelapor = function(id, no, judul, klasifikasi, anggota) {
    		this.id = id;
    		this.no = no;
    		this.judul = judul;
    		this.klasifikasi = klasifikasi;
    		this.anggota = anggota;
    	}	

    	var TelaahExpedited = function(id, no, judul, waktu, revisi_ke, hari_ke) {
    		this.id = id;
    		this.no = no;
    		this.judul = judul;
    		this.waktu = waktu;
    		this.revisi_ke = revisi_ke;
    		this.hari_ke = hari_ke;
    		this.url_edit = ko.pureComputed(function(){
    			return '<?php echo base_url()?>telaah_expedited/form/0/'+id;
    		})
    	}

    	var TelaahFullboard = function(id, no, judul, tgl_fb, jam_fb, tempat_fb, waktu, revisi_ke, hari_ke) {
    		this.id = id;
    		this.no = no;
    		this.judul = judul;
        this.tgl_fb = tgl_fb;
        this.jam_fb = jam_fb;
        this.tempat_fb = tempat_fb;
    		this.waktu = waktu;
    		this.revisi_ke = revisi_ke;
    		this.hari_ke = hari_ke;
    		this.url_edit = ko.pureComputed(function(){
    			return '<?php echo base_url()?>telaah_fullboard/form/0/'+id;
    		})
    	}

    	var PutusanExpedited = function(id, no, judul, waktu, revisi_ke, hari_ke) {
    		this.id = id;
    		this.no = no;
    		this.judul = judul;
    		this.waktu = waktu;
    		this.revisi_ke = revisi_ke;
    		this.hari_ke = hari_ke;
    		this.url_edit = ko.pureComputed(function(){
    			return '<?php echo base_url()?>putusan_expedited/form/0/'+id;
    		})
    	}

    	var PutusanFullboard = function(id, no, judul, waktu, revisi_ke, hari_ke) {
    		this.id = id;
    		this.no = no;
    		this.judul = judul;
    		this.waktu = waktu;
    		this.revisi_ke = revisi_ke;
    		this.hari_ke = hari_ke;
    		this.url_edit = ko.pureComputed(function(){
    			return '<?php echo base_url()?>putusan_fullboard/form/0/'+id;
    		})
    	}

      var ProtokolBelumKirim = function(id_pengajuan, id_pep, no, judul, revisi, klasifikasi, keputusan) {
        this.id_pengajuan = id_pengajuan;
        this.id_pep = id_pep;
        this.no = no;
        this.judul = judul;
        this.revisi = revisi;
        this.klasifikasi = klasifikasi;
        this.keputusan = keputusan;
      }

      var DashboardModel = function(){
    		var self = this;
        self.resume_penelaah = ko.observableArray([]);
    		self.telaah_awal = ko.observableArray([]);
    		self.telaah_pelapor = ko.observableArray([]);
    		self.telaah_expedited = ko.observableArray([]);
    		self.telaah_fullboard = ko.observableArray([]);
    		self.putusan_expedited = ko.observableArray([]);
    		self.putusan_fullboard = ko.observableArray([]);
    		self.texp_new = ko.pureComputed(function(){
    			var t = 0;
    			$.each(self.telaah_expedited(), function(i, item){
    				if (item.revisi_ke == 0) t++;
    			})
    			return t;
    		})
    		self.texp_rev = ko.pureComputed(function(){
    			var t = 0;
    			$.each(self.telaah_expedited(), function(i, item){
    				if (item.revisi_ke > 0) t++;
    			})
    			return t;
    		})
    		self.tfbd_new = ko.pureComputed(function(){
    			var t = 0;
    			$.each(self.telaah_fullboard(), function(i, item){
    				if (item.revisi_ke == 0) t++;
    			})
    			return t;
    		})
    		self.tfbd_rev = ko.pureComputed(function(){
    			var t = 0;
    			$.each(self.telaah_fullboard(), function(i, item){
    				if (item.revisi_ke > 0) t++;
    			})
    			return t;
    		})
    		self.kexp_new = ko.pureComputed(function(){
    			var t = 0;
    			$.each(self.putusan_expedited(), function(i, item){
    				if (item.revisi_ke == 0) t++;
    			})
    			return t;
    		})
    		self.kexp_rev = ko.pureComputed(function(){
    			var t = 0;
    			$.each(self.putusan_expedited(), function(i, item){
    				if (item.revisi_ke > 0) t++;
    			})
    			return t;
    		})
    		self.kfbd_new = ko.pureComputed(function(){
    			var t = 0;
    			$.each(self.putusan_fullboard(), function(i, item){
    				if (item.revisi_ke == 0) t++;
    			})
    			return t;
    		})
    		self.kfbd_rev = ko.pureComputed(function(){
    			var t = 0;
    			$.each(self.putusan_fullboard(), function(i, item){
    				if (item.revisi_ke > 0) t++;
    			})
    			return t;
    		})

        self.belum_kirim = ko.observableArray([]);
      } 

    	var App = new DashboardModel();

      App.init_protokol_belum_kirim = function(){
        App.belum_kirim.removeAll();
        $.ajax({
          url: '<?php echo base_url()?>dashboard/get_protokol_belum_kirim/',
          type: 'post',
          dataType: 'json',
          success: function(res, xhr){
            $.each(res, function(i, item){
              App.belum_kirim.push(new ProtokolBelumKirim(item.id_pengajuan, item.id_pep, item.no, item.judul, item.revisi, item.klasifikasi, item.keputusan));
            });
          }
        });
      }

      App.init_resume_penelaah = function(){
        App.resume_penelaah.removeAll();
        $.ajax({
          url: '<?php echo base_url()?>resume_penelaah/get_protokol/',
          type: 'post',
          dataType: 'json',
          success: function(res, xhr){
            $.each(res, function(i, item){
              App.resume_penelaah.push(new ResumePenelaah(res[i].id_pep, res[i].no, res[i].judul, res[i].waktu, res[i].revisi_ke, res[i].hari_ke));
            });
          }
        });
      }

    	App.init_telaah_awal = function(){
        App.telaah_awal.removeAll();
        $.ajax({
          url: '<?php echo base_url()?>telaah_awal/get_protokol/',
          type: 'post',
          dataType: 'json',
          success: function(res, xhr){
            $.each(res, function(i, item){
              App.telaah_awal.push(new TelaahAwal(res[i].id_pep, res[i].no, res[i].judul, res[i].waktu, res[i].revisi_ke, res[i].hari_ke));
            });
          }
        });
    	}

    	App.init_telaah_pelapor = function(){
        App.telaah_pelapor.removeAll();
        $.ajax({
          url: '<?php echo base_url()?>dashboard/get_telaah_pelapor/',
          type: 'post',
          dataType: 'json',
          success: function(res, xhr){
            $.each(res, function(i, item){
              App.telaah_pelapor.push(new TelaahPelapor(res[i].id_pep, res[i].no, res[i].judul, res[i].klasifikasi, res[i].anggota));
            });
          }
        });
    	}

    	App.init_telaah_expedited = function(){
        App.telaah_expedited.removeAll();
        $.ajax({
          url: '<?php echo base_url()?>telaah_expedited/get_protokol/',
          type: 'post',
          dataType: 'json',
          success: function(res, xhr){
            $.each(res, function(i, item){
              App.telaah_expedited.push(new TelaahExpedited(res[i].id_pep, res[i].no, res[i].judul, res[i].waktu, res[i].revisi_ke, res[i].hari_ke));
            });
          }
        });
    	}

    	App.init_telaah_fullboard = function(){
        App.telaah_fullboard.removeAll();
        $.ajax({
          url: '<?php echo base_url()?>telaah_fullboard/get_protokol/',
          type: 'post',
          dataType: 'json',
          success: function(res, xhr){
            $.each(res, function(i, item){
              App.telaah_fullboard.push(new TelaahFullboard(res[i].id_pep, res[i].no, res[i].judul, res[i].tgl_fb, res[i].jam_fb, res[i].tempat_fb, res[i].waktu, res[i].revisi_ke, res[i].hari_ke));
            });
          }
        });
    	}

    	App.init_putusan_expedited = function(){
        App.putusan_expedited.removeAll();
        $.ajax({
          url: '<?php echo base_url()?>putusan_expedited/get_protokol/',
          type: 'post',
          dataType: 'json',
          success: function(res, xhr){
            $.each(res, function(i, item){
              App.putusan_expedited.push(new PutusanExpedited(res[i].id_pep, res[i].no, res[i].judul, res[i].waktu, res[i].revisi_ke, res[i].hari_ke));
            });
          }
        });
    	}

    	App.init_putusan_fullboard = function(){
        App.putusan_fullboard.removeAll();
        $.ajax({
          url: '<?php echo base_url()?>putusan_fullboard/get_protokol/',
          type: 'post',
          dataType: 'json',
          success: function(res, xhr){
            $.each(res, function(i, item){
              App.putusan_fullboard.push(new PutusanFullboard(res[i].id_pep, res[i].no, res[i].judul, res[i].waktu, res[i].revisi_ke, res[i].hari_ke));
            });
          }
        });
    	}

      App.kirim = function(id_pep, klasifikasi, keputusan, no_protokol){
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
    				  var $btn = $('#kirim');

    				  $btn.button('loading');
              if (klasifikasi == 2)
                $url = '<?php echo base_url()?>putusan_expedited/kirim/'+id_pep+'/'+keputusan+'/'+no_protokol;
              else if (klasifikasi == 3)
                $url = '<?php echo base_url()?>putusan_fullboard/kirim/'+id_pep+'/'+keputusan+'/'+no_protokol;

    				  $.ajax({
    				    url: $url,
    				    type: 'post',
    				    cache: false,
    				    dataType: 'json',
    				    success: function(res, xhr){
    				      if (res.isSuccess){
    				      	App.init_protokol_belum_kirim();
    				      	show_success(true, res.message);
    				      }
    				      else show_error(true, res.message);

    				      $btn.button('reset');
    				    }
    				  });
    				}
    			}
    		});
    	}

      ko.applyBindings(App);
    </script>
