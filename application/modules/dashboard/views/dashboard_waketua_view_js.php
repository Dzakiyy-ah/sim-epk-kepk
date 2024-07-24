<script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
    
    <!-- inline scripts related to this page -->
    <script type="text/javascript">
    		
    	jQuery(function($) {

        $('.scrollable').each(function () {
          var $this = $(this);
          $(this).ace_scroll({
            size: $this.attr('data-size') || 100,
            //styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
          });
        });
    				
    	});

    	var PutusanAwal = function(id, no, judul, waktu, hari_ke) {
    		this.id = id;
    		this.no = no;
    		this.judul = judul;
    		this.waktu = waktu;
    		this.hari_ke = hari_ke;
    		this.url_edit = ko.pureComputed(function(){
    			return '<?php echo base_url()?>putusan_awal/form/?id_pep='+id;
    		})
    	}

    	var PutusanExpedited = function(id, id_pep, no, judul, waktu, revisi_ke, hari_ke) {
    		this.id = id;
    		this.id_pep = id_pep;
    		this.no = no;
    		this.judul = judul;
    		this.waktu = waktu;
    		this.revisi_ke = revisi_ke;
    		this.hari_ke = hari_ke;
    		this.url_edit = ko.pureComputed(function(){
    			return '<?php echo base_url()?>putusan_expedited/form/'+id+'/'+id_pep;
    		})
    	}

    	var PutusanFullboard = function(id, id_pep, no, judul, waktu, revisi_ke, hari_ke) {
    		this.id = id;
    		this.id_pep = id_pep;
    		this.no = no;
    		this.judul = judul;
    		this.waktu = waktu;
    		this.revisi_ke = revisi_ke;
    		this.hari_ke = hari_ke;
    		this.url_edit = ko.pureComputed(function(){
    			return '<?php echo base_url()?>putusan_fullboard/form/'+id+'/'+id_pep;
    		})
    	}

    	var DashboardModel = function(){
    		var self = this;
    		self.putusan_awal = ko.observableArray([]);
    		self.putusan_expedited = ko.observableArray([]);
    		self.putusan_fullboard = ko.observableArray([]);
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
    	} 

    	var App = new DashboardModel();

    	App.init_putusan_awal = function(){
        App.putusan_awal.removeAll();
        $.ajax({
          url: '<?php echo base_url()?>putusan_awal/get_protokol/',
          type: 'post',
          dataType: 'json',
          success: function(res, xhr){
            $.each(res, function(i, item){
              App.putusan_awal.push(new PutusanAwal(res[i].id_pep, res[i].no, res[i].judul, res[i].waktu, res[i].hari_ke));
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
              App.putusan_expedited.push(new PutusanExpedited(res[i].id, res[i].id_pep, res[i].no, res[i].judul, res[i].waktu, res[i].revisi_ke, res[i].hari_ke));
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
              App.putusan_fullboard.push(new PutusanFullboard(res[i].id, res[i].id_pep, res[i].no, res[i].judul, res[i].waktu, res[i].revisi_ke, res[i].hari_ke));
            });
          }
        });
    	}

    	ko.applyBindings(App);
    </script>
