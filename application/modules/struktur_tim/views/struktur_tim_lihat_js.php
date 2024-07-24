    <!-- page specific plugin scripts -->
    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>

    <script type="text/javascript">

    	jQuery(function($) {
        App.get_struktur_tim();
    	});

    	var StrukturTimKEPKModel = function(){
    		var self = this;
    		self.id = <?php echo isset($data['id_tim_kepk']) ? $data['id_tim_kepk'] : 0?>;
        self.periode_awal = "<?php echo isset($data['periode_awal']) ? date('d/m/Y', strtotime($data['periode_awal'])) : ''?>";
        self.periode_akhir = "<?php echo isset($data['periode_akhir']) ? date('d/m/Y', strtotime($data['periode_akhir'])) : ''?>";
        self.aktif_tim = "<?php echo isset($data['aktif']) && $data['aktif'] == 1 ? 'Ya' : 'Tidak' ?>";
    		self.nama_ketua = ko.observable();
    		self.nama_wakil_ketua = ko.observableArray([]);
    		self.nama_sekretaris = ko.observableArray([]);
    		self.nama_sekretariat = ko.observableArray([]);
    		self.nama_penelaah = ko.observableArray([]);
    		self.nama_lay_person = ko.observableArray([]);
    		self.nama_konsultan = ko.observableArray([]);
    	}

    	var App = new StrukturTimKEPKModel();

      App.get_struktur_tim = function(){
        var id = App.id;
        $.ajax({
          url: '<?php echo base_url()?>struktur_tim/get_daftar_struktur_by_id/'+id,
          type: 'post',
          cache: false,
          dataType : 'json',
          success: function(res){
            if (res.length > 0)
            {
              $.each(res, function(i, item){
                if (item.jabatan == 'Ketua') 
                  App.nama_ketua(item.nama);
                else if (item.jabatan == 'Wakil Ketua')
                  App.nama_wakil_ketua.push(item.nama);
                else if (item.jabatan == 'Sekretaris') 
                  App.nama_sekretaris.push(item.nama);
                else if (item.jabatan == 'Kesekretariatan')
                  App.nama_sekretariat.push(item.nama);
                else if (item.jabatan == 'Penelaah')
                  App.nama_penelaah.push(item.nama);
                else if (item.jabatan == 'Lay Person')
                  App.nama_lay_person.push(item.nama);
                else if (item.jabatan == 'Konsultan Independen')
                  App.nama_konsultan.push(item.nama);
              })
            }
          }
        });
      }

    	App.back = function(){
    		window.location.href = '<?php echo base_url()?>struktur_tim/';
    	}

    	ko.applyBindings(App);
    </script>
