    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
    <script src="<?php echo base_url()?>assets/js/select2.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/id.js"></script>

    <script type="text/javascript">
    	jQuery(function($) {
        $(".select2").select2({
          placeholder: "Pilih...",
          language: "id",
          allowClear: true
        });
    	});

    	var TarifTelaahModel = function(){
    		var self = this;
    		self.id = ko.observable(<?php echo isset($data['id_tarif_telaah']) ? $data['id_tarif_telaah'] : 0?>);
    		self.jns_penelitian = ko.observable('<?php echo isset($data['jenis_penelitian']) ? $data['jenis_penelitian'] : ""?>');
    		self.asal_pengusul = ko.observable('<?php echo isset($data['asal_pengusul']) ? $data['asal_pengusul'] : ""?>');
    		self.jns_lembaga = ko.observable('<?php echo isset($data['jenis_lembaga']) ? $data['jenis_lembaga'] : ""?>');
    		self.status_pengusul = ko.observable('<?php echo isset($data['status_pengusul']) ? $data['status_pengusul'] : ""?>');
    		self.strata_pend = ko.observable('<?php echo isset($data['strata_pendidikan']) ? $data['strata_pendidikan'] : ""?>');
    		self.tarif = ko.observable('<?php echo isset($data['tarif_telaah']) ? $data['tarif_telaah'] : ''?>');
    		self.processing = ko.observable(false);
    	}

    	var App = new TarifTelaahModel();

    	App.save = function(createNew){
    	  var data = JSON.parse(ko.toJSON(App));
    	  var $btn = $('#submit');

    	  $btn.button('loading');
    	  App.processing(true);
    	  $.ajax({
    	    url: '<?php echo base_url()?>tarif_telaah/proses',
    	    type: 'post',
    	    cache: false,
    	    dataType: 'json',
    	    data: data,
    	    success: function(res, xhr){
    	      if (res.isSuccess){
    	      	App.id(res.id);
    	      	show_success(true, res.message);
              if (createNew){
                setTimeout(function(){
                  window.location.href = '<?php echo base_url()?>tarif_telaah/form/';
                }, 3000)
              }
    	      }
    	      else show_error(true, res.message);

    	      $btn.button('reset');
    	      App.processing(false);

    	    }
    	  });

    	}

    	App.back = function(){
    		window.location.href = '<?php echo base_url()?>tarif_telaah/';
    	}

    	ko.applyBindings(App);
    </script>