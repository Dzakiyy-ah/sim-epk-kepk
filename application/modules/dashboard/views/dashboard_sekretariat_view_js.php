<script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
		
	jQuery(function($) {

		$('#putusan_awal_fullboard, #pembebasan, #persetujuan, #perbaikan').ace_scroll({
			height: '250px',
			mouseWheelLock: true,
			alwaysVisible : true
		});
				
	});

	var PutusanAwalFullboard = function(id, no, judul, waktu, hari_ke) {
		this.id = id;
		this.no = no;
		this.judul = judul;
		this.waktu = waktu;
		this.hari_ke = hari_ke;
		this.url_edit = ko.pureComputed(function(){
			return '<?php echo base_url()?>pemberitahuan_fullboard/form/?id_pep='+id;
		})
	}

	var Pembebasan = function(id, no, judul, waktu, hari_ke) {
		this.id = id;
		this.no = no;
		this.judul = judul;
		this.waktu = waktu;
		this.hari_ke = hari_ke;
		this.url_edit = ko.pureComputed(function(){
			return '<?php echo base_url()?>surat_pembebasan/form/?id_pep='+id;
		})
	}

	var Persetujuan = function(id, no, judul, waktu, hari_ke) {
		this.id = id;
		this.no = no;
		this.judul = judul;
		this.waktu = waktu;
		this.hari_ke = hari_ke;
		this.url_edit = ko.pureComputed(function(){
			return '<?php echo base_url()?>surat_persetujuan/form/?id_pep='+id;
		})
	}

	var Perbaikan = function(id, no, judul, waktu, hari_ke) {
		this.id = id;
		this.no = no;
		this.judul = judul;
		this.waktu = waktu;
		this.hari_ke = hari_ke;
		this.url_edit = ko.pureComputed(function(){
			return '<?php echo base_url()?>surat_perbaikan/form/?id_pep='+id;
		})
	}

	var DashboardModel = function(){
		var self = this;
		self.putusan_awal_fullboard = ko.observableArray([]);
		self.pembebasan = ko.observableArray([]);
		self.persetujuan = ko.observableArray([]);
		self.perbaikan = ko.observableArray([]);
	} 

	var App = new DashboardModel();

	App.init_putusan_awal_fullboard = function(){
    App.putusan_awal_fullboard.removeAll();
    $.ajax({
      url: '<?php echo base_url()?>dashboard/get_putusan_fullboard/',
      type: 'post',
      dataType: 'json',
      success: function(res, xhr){
		    App.putusan_awal_fullboard.removeAll();
        $.each(res, function(i, item){
          App.putusan_awal_fullboard.push(new PutusanAwalFullboard(res[i].id, res[i].no, res[i].judul, res[i].waktu, res[i].hari_ke));
        });
      }
    });
	}

	App.init_pembebasan = function(){
    App.pembebasan.removeAll();
    $.ajax({
      url: '<?php echo base_url()?>dashboard/get_pembebasan_etik/',
      type: 'post',
      dataType: 'json',
      success: function(res, xhr){
		    App.pembebasan.removeAll();
        $.each(res, function(i, item){
          App.pembebasan.push(new Pembebasan(res[i].id, res[i].no, res[i].judul, res[i].waktu, res[i].hari_ke));
        });
      }
    });
	}

	App.init_persetujuan = function(){
    App.persetujuan.removeAll();
    $.ajax({
      url: '<?php echo base_url()?>dashboard/get_persetujuan_etik/',
      type: 'post',
      dataType: 'json',
      success: function(res, xhr){
		    App.persetujuan.removeAll();
        $.each(res, function(i, item){
          App.persetujuan.push(new Persetujuan(res[i].id, res[i].no, res[i].judul, res[i].waktu, res[i].hari_ke));
        });
      }
    });
	}

	App.init_perbaikan = function(){
    App.perbaikan.removeAll();
    $.ajax({
      url: '<?php echo base_url()?>dashboard/get_perbaikan_etik/',
      type: 'post',
      dataType: 'json',
      success: function(res, xhr){
		    App.perbaikan.removeAll();
        $.each(res, function(i, item){
          App.perbaikan.push(new Perbaikan(res[i].id, res[i].no, res[i].judul, res[i].waktu, res[i].hari_ke));
        });
      }
    });
	}

	ko.applyBindings(App);
</script>
