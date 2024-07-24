<script src="<?php echo base_url()?>assets/js/autosize.min.js"></script>

<script type="text/javascript">
	jQuery(function($) {
    autosize($('textarea[class*=autosize]'));

    $('#back').click(function(){
			window.location = '<?php echo base_url()?>progress_protokol/';
		});

    $("#printpdf").on("click", function () {
      var divContents = $("#konten").html();
      var printWindow = window.open('', '', 'height=400,width=800');
      printWindow.document.write('<html><head><link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.min.css" /><link rel="stylesheet" href="<?php echo base_url()?>assets/font-awesome/4.5.0/css/font-awesome.min.css" /><link rel="stylesheet" href="<?php echo base_url()?>assets/css/fonts.googleapis.com.css" /><link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" /><link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-part2.min.css" class="ace-main-stylesheet" /><link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-skins.min.css" /><link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-rtl.min.css" />');
      printWindow.document.write('</head><body >');
      printWindow.document.write(divContents);
      printWindow.document.write('</body></html>');
      printWindow.document.close();
      printWindow.print();
    });
	});
</script>