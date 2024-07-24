    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>

    <script type="text/javascript">
    	var PasswModel = function(){
    		var self = this;
    		self.passw_lama = ko.observable('');
    		self.passw_baru1 = ko.observable('');
    		self.passw_baru2 = ko.observable('');
    		self.processing = ko.observable(false);
    	}

    	var App = new PasswModel();

    	App.save = function(createNew){
    	  var data = JSON.parse(ko.toJSON(App));
    	  var $btn = $('#submit');

    	  $btn.button('loading');
    	  App.processing(true);
    	  $.ajax({
    	    url: '<?php echo base_url()?>user_profil/proses_password',
    	    type: 'post',
    	    cache: false,
    	    dataType: 'json',
    	    data: data,
    	    success: function(res, xhr){
    	      if (res.isSuccess){
    	      	show_success(true, res.message);
    	      	setTimeout(function(){
    		      	window.location = '<?php echo base_url()?>user_profil/';
    	      	}, 500);
    	      }
    	      else show_error(true, res.message);

    	      $btn.button('reset');
    	      App.processing(false);
    	    }
    	  });

    	}

    	ko.applyBindings(App);
    </script>