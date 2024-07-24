    <!-- page specific plugin scripts -->
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap-datepicker.id.js"></script>

    <script type="text/javascript">
		
    jQuery(function($) {
  
      $("#periode").datepicker( {
          format: "M yyyy",
          viewMode: "months", 
          minViewMode: "months",
          autoclose: true,
          language: 'id',
      }).on('changeDate', function(selected){
          var d = 1,
              m = selected.date.getMonth() + 1,
              Y = selected.date.getFullYear();
              tgl = Y+'-'+m+'-'+d;
          App.periode(tgl);
          App.init_statistik();
      });
  
      $('#periode').val('<?php echo date('M Y') ?>');
  
      App.init_statistik();
          
    });
  
    var StatistikProtokolModel = function(){
      var self = this;
      self.periode = ko.observable('<?php echo date('Y-m-d') ?>');
      self.jenis_penelitian1 = ko.observable(0);
      self.jenis_penelitian2 = ko.observable(0);
      self.jenis_penelitian3 = ko.observable(0);
      self.asal_pengusul1 = ko.observable(0);
      self.asal_pengusul2 = ko.observable(0);
      self.jenis_lembaga1 = ko.observable(0);
      self.jenis_lembaga2 = ko.observable(0);
      self.jenis_lembaga3 = ko.observable(0);
      self.status_pengusul1 = ko.observable(0);
      self.status_pengusul2 = ko.observable(0);
      self.status_pengusul3 = ko.observable(0);
      self.status_pengusul4 = ko.observable(0);
      self.status_pengusul5 = ko.observable(0);
      self.strata_pendidikan1 = ko.observable(0);
      self.strata_pendidikan2 = ko.observable(0);
      self.strata_pendidikan3 = ko.observable(0);
      self.strata_pendidikan4 = ko.observable(0);
      self.strata_pendidikan5 = ko.observable(0);
      self.strata_pendidikan6 = ko.observable(0);
      self.strata_pendidikan7 = ko.observable(0);
      self.strata_pendidikan8 = ko.observable(0);
      self.load_data = ko.observable(false);
    } 
  
    var App = new StatistikProtokolModel();
  
    App.init_statistik = function(){
      var periode = App.periode();
  
      App.load_data(true);
      $.ajax({
        url: '<?php echo base_url()?>statistik_protokol/get_statistik_by_periode/'+periode,
        type: 'post',
        dataType: 'json',
        success: function(res, xhr){
          App.jenis_penelitian1(res.jenis_penelitian1);
          App.jenis_penelitian2(res.jenis_penelitian2);
          App.jenis_penelitian3(res.jenis_penelitian3);
          App.asal_pengusul1(res.asal_pengusul1);
          App.asal_pengusul2(res.asal_pengusul2);
          App.jenis_lembaga1(res.jenis_lembaga1);
          App.jenis_lembaga2(res.jenis_lembaga2);
          App.jenis_lembaga3(res.jenis_lembaga3);
          App.status_pengusul1(res.status_pengusul1);
          App.status_pengusul2(res.status_pengusul2);
          App.status_pengusul3(res.status_pengusul3);
          App.status_pengusul4(res.status_pengusul4);
          App.status_pengusul5(res.status_pengusul5);
          App.strata_pendidikan1(res.strata_pendidikan1);
          App.strata_pendidikan2(res.strata_pendidikan2);
          App.strata_pendidikan3(res.strata_pendidikan3);
          App.strata_pendidikan4(res.strata_pendidikan4);
          App.strata_pendidikan5(res.strata_pendidikan5);
          App.strata_pendidikan6(res.strata_pendidikan6);
          App.strata_pendidikan7(res.strata_pendidikan7);
          App.strata_pendidikan8(res.strata_pendidikan8);
        }
      }).done(function(){
        App.load_data(false);
      });
    }
  
    ko.applyBindings(App);
  </script>
  