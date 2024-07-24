<!-- page specific plugin scripts -->
<script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
<script src="<?php echo base_url()?>assets/js/app.js"></script>
<script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>

<script type="text/javascript">
	jQuery(function($) {

	});

	var TandaTanganKetua = function(){
		var self = this;
		self.client_name = ko.observable('<?php echo isset($data['client_name']) ? $data['client_name'] : ''?>');
		self.file_name = ko.observable('<?php echo isset($data['file_name']) ? $data['file_name'] : ''?>');
		self.file_size = ko.observable('<?php echo isset($data['file_size']) ? $data['file_size'] : ''?>');
		self.file_type = ko.observable('<?php echo isset($data['file_type']) ? $data['file_type'] : ''?>');
		self.file_ext = ko.observable('<?php echo isset($data['file_ext']) ? $data['file_ext'] : ''?>');
		self.processing = ko.observable(false);
	}

	var App = new TandaTanganKetua();

	App.upload = function(){
	  $('#kop').trigger('click');
	}

	App.do_upload = function(){
	  var data_upload = new FormData();
	  data_upload.append('file', $('#kop').prop('files')[0]);

  	$('#btn_kop').button('loading');
	  $.ajax({
	    url: '<?php echo base_url()?>tandatangan_ketua/do_upload/',
	    type: 'post',
	    processData: false, // important
	    contentType: false, // important
	    dataType : 'json',
	    data: data_upload,
	    success: function(res, xhr){
	      if (res.isSuccess){
        	App.client_name(res.data_fileupload.client_name);
        	App.file_name(res.data_fileupload.file_name);
        	App.file_size(res.data_fileupload.file_size);
        	App.file_type(res.data_fileupload.file_type);
        	App.file_ext(res.data_fileupload.file_ext);
	      }
	     	else show_error(true, res.message);

		  	$('#btn_kop').button('reset');
	    },
			error: function(xmlhttprequest, textstatus, message) {
        if(textstatus==="timeout") {
            alert("got timeout");
        } else {
            alert(textstatus);
        }
    	}
 	  });
	}

  App.pratinjau = function(){
    var file_name = App.file_name();
    window.open('<?php echo base_url()?>tandatangan_ketua/pratinjau_cetak/'+file_name, '_blank');
  }

	App.save = function(createNew){
	  var data = JSON.parse(ko.toJSON(App));
	  var $btn = $('#submit');

	  $btn.button('loading');
	  App.processing(true);
	  $.ajax({
	    url: '<?php echo base_url()?>tandatangan_ketua/proses',
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
