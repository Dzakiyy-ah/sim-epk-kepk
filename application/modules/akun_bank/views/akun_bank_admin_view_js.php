<!-- page specific plugin scripts -->
<script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
<script src="<?php echo base_url()?>assets/js/app.js"></script>
<script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>

<script type="text/javascript">
	jQuery(function($) {

	});

	var AkunBank = function(){
		var self = this;
		self.nama_bank = ko.observable('<?php echo isset($data['nama_bank']) ? $data['nama_bank'] : ''?>');
		self.no_rekening = ko.observable('<?php echo isset($data['no_rekening']) ? $data['no_rekening'] : ''?>');
		self.pemilik_rekening = ko.observable('<?php echo isset($data['pemilik_rekening']) ? $data['pemilik_rekening'] : ''?>');
		self.swift_code = ko.observable('<?php echo isset($data['swift_code']) ? $data['swift_code'] : ''?>');
    self.tarif_d3 = ko.observable('<?php echo isset($data['tarif_d3']) ? $data['tarif_d3'] : ''?>');
    self.tarif_d4 = ko.observable('<?php echo isset($data['tarif_d4']) ? $data['tarif_d4'] : ''?>');
    self.tarif_s1 = ko.observable('<?php echo isset($data['tarif_s1']) ? $data['tarif_s1'] : ''?>');
    self.tarif_s2 = ko.observable('<?php echo isset($data['tarif_s2']) ? $data['tarif_s2'] : ''?>');
    self.tarif_s3 = ko.observable('<?php echo isset($data['tarif_s3']) ? $data['tarif_s3'] : ''?>');
    self.tarif_sp1 = ko.observable('<?php echo isset($data['tarif_sp1']) ? $data['tarif_sp1'] : ''?>');
    self.tarif_sp2 = ko.observable('<?php echo isset($data['tarif_sp2']) ? $data['tarif_sp2'] : ''?>');
    self.tarif_lainnya = ko.observable('<?php echo isset($data['tarif_lainnya']) ? $data['tarif_lainnya'] : ''?>');
		self.processing = ko.observable(false);
	}

	var App = new AkunBank();

	App.save = function(createNew){
	  var data = JSON.parse(ko.toJSON(App));
	  var $btn = $('#submit');

	  $btn.button('loading');
	  App.processing(true);
	  $.ajax({
	    url: '<?php echo base_url()?>akun_bank/proses',
	    type: 'post',
	    cache: false,
	    dataType: 'json',
	    data: data,
	    success: function(res, xhr){
	      if (res.isSuccess){
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
