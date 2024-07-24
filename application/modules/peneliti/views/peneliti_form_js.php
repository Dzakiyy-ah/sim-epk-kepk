    <!-- page specific plugin scripts -->
		<script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>

    <script type="text/javascript">
    	jQuery(function($) {

    	});

    	var Peneliti = function(){
    		var self = this;
    		self.id_user = <?php echo isset($data['id_user']) ? $data['id_user'] : 0 ?>;
    		self.aktif_password = ko.observable(false);
    		self.password = ko.observable("");
    		self.processing = ko.observable(false);
    	}

    	var App = new Peneliti();

    	App.aktif_password.subscribe(function(newValue){
    		if (newValue == false)
    			App.password("");
    	})

    	App.save = function(createNew){
    	  var data = JSON.parse(ko.toJSON(App));
    	  var $btn = $('#submit');

    	  $btn.button('loading');
    	  App.processing(true);
    	  $.ajax({
    	    url: '<?php echo base_url()?>peneliti/proses_password',
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

    	App.back = function(){
    		window.location.href = '<?php echo base_url()?>peneliti/';
    	}

    	ko.applyBindings(App);
    </script>
