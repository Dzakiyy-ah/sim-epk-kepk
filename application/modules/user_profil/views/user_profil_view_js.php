    <script type="text/javascript">
    	jQuery(function($) {
    	  $('#edit_passw').click(function(e){
    	    var id = "<?php echo $this->session->userdata('id_user_'.APPAUTH);?>"
    	    window.location = '<?php echo base_url()?>user_profil/form_password/'+id;
    	  })
    	});
    </script>