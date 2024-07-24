    <!-- page specific plugin scripts -->
    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>

    <!-- inline scripts related to this page -->
    <script type="text/javascript">
    		
    	jQuery(function($) {
    		
    	});

      var KEPKModel = function(){
        var self = this;
        self.no_kep = ko.observable('');
        self.token = ko.observable('');
        self.data = <?php echo !empty($data) ? count($data) : 0 ?>;
        self.kodefikasi = "<?php echo isset($data['kodefikasi']) ? $data['kodefikasi'] : '' ?>";
        self.aktif = <?php echo isset($data['aktif']) ? $data['aktif'] : 0 ?>;
      }

      var App = new KEPKModel();

      <?php if (empty($data)) { ?>

      App.import_data = function(){
        var no_kep = App.no_kep();
            token = App.token();

        $('#import_data').button('loading');

        $.ajax({
          url: '<?php echo base_url()?>data_kepk/proses_import/',
          type: 'post',
          dataType : 'json',
          data: {no_kep: no_kep, token: token},
          success: function(res, xhr){
            if (res.isSuccess){
              show_success(true, res.message);
              setTimeout(function(){ location.reload(true); }, 5000);
            }
            else show_error(true, res.message);

            $('#import_data').button('reset');
          }
        });
      }

      <?php } ?>

      <?php if (isset($data['aktif']) && $data['aktif'] == 0) { ?>
      App.registrasi = function(){
        var kodefikasi = App.kodefikasi;
        $('#btn-registrasi').button('loading');

        $.ajax({
          url: '<?php echo base_url()?>data_kepk/registrasi/'+kodefikasi,
          type: 'post',
          cache: false,
          dataType : 'json',
          success: function(res, xhr){
            if (res.isSuccess){
              show_success(true, res.message);
              setTimeout(function(){ location.reload(true); }, 5000);
            }
            else show_error(true, res.message);

            $('#btn-registrasi').button('reset');
          }
        });
      }
      <?php } ?>

      ko.applyBindings(App);
    </script>
