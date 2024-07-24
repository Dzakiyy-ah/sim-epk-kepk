    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
    <script src="<?php echo base_url()?>assets/js/select2.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/id.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.hotkeys.index.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap-wysiwyg.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootbox.js"></script>
    <script src="<?php echo base_url()?>assets/js/dropzone.min.js"></script>
    
    <script type="text/javascript">
    	var purge_dokumen = [], purge_filename = [];
    	jQuery(function($) {
        $(".select2").select2({
          placeholder: "Pilih...",
          language: "id",
          allowClear: true
        });

    		$('.wysiwyg-editor').ace_wysiwyg({
    			toolbar:
    			[
    				'font',
    				null,
    				'fontSize',
    				null,
    				{name:'bold', className:'btn-info'},
    				{name:'italic', className:'btn-info'},
    				{name:'strikethrough', className:'btn-info'},
    				{name:'underline', className:'btn-info'},
    				null,
    				{name:'insertunorderedlist', className:'btn-success'},
    				{name:'insertorderedlist', className:'btn-success'},
    				{name:'outdent', className:'btn-purple'},
    				{name:'indent', className:'btn-purple'},
    				null,
    				{name:'justifyleft', className:'btn-primary'},
    				{name:'justifycenter', className:'btn-primary'},
    				{name:'justifyright', className:'btn-primary'},
    				{name:'justifyfull', className:'btn-inverse'},
    				null,
    				{name:'createLink', className:'btn-pink'},
    				{name:'unlink', className:'btn-pink'},
    				null,
    				{name:'insertImage', className:'btn-success'},
    				null,
    				'foreColor',
    				null,
    				{name:'undo', className:'btn-grey'},
    				{name:'redo', className:'btn-grey'}
    			],
    			'wysiwyg': {
    				fileUploadError: showErrorAlert
    			}
    		}).prev().addClass('wysiwyg-style2');
    		
    		$('#laporan_akhir').html("<?php echo isset($data['laporan_akhir']) ? $data['laporan_akhir'] : ''?>");
    	});

    	function showErrorAlert (reason, detail) {
    		var msg='';
    		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
    		else {
    			//console.log("error uploading file", reason, detail);
    		}
    		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
    		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
    	}

    	function getNewid()
    	{
    	  return 'new_' + parseFloat((new Date().getTime() + '').slice(7))+ Math.round(Math.random() * 100);
    	}

    	var Dokumen = function(id, deskripsi, client_name, file_name, file_size, file_type, file_ext){
    		this.id = id;
    		this.deskripsi = ko.observable(deskripsi);
    		this.client_name = client_name;
    		this.file_name = file_name;
    		this.file_size = file_size;
    		this.file_type = file_type;
    		this.file_ext = file_ext;
    	}

      var LaporanAkhirModel = function(){
    		var self = this;
    		self.id = ko.observable(<?php echo isset($data['id_laporan_akhir']) ? $data['id_laporan_akhir'] : 0 ?>);
    		self.id_pep = ko.observable(<?php echo isset($data['id_pep']) ? $data['id_pep'] : 0 ?>);
    		self.dokumen = ko.observableArray([]);
    		self.removeDokumen = function(dok){
    			self.dokumen.remove(dok);
    			purge_dokumen.push(dok.id);
    			purge_filename.push(dok.file_name);
    		};
    		self.processing = ko.observable(false);
    	}

    	var App = new LaporanAkhirModel();

    	App.upload = function(){
    		$('#file').trigger('click');
    	}

    	App.do_upload = function(){
    		var data_upload = new FormData();
    	  		data_upload.append('file', $('#file').prop('files')[0]);
    	  		$('#upload').button('loading');

    		$.ajax({
    		    url: '<?php echo base_url()?>laporan_akhir/do_upload',
    		    type: 'post',
    		    processData: false, // important
    		    contentType: false, // important
    		    dataType : 'json',
    		    data: data_upload,
    		    success: function(res, xhr){
    			    if (res.isSuccess){
    	        		var id = getNewid();
    	        		App.dokumen.push(new Dokumen(id, '', res.data_fileupload.client_name, res.data_fileupload.file_name, res.data_fileupload.file_size, res.data_fileupload.file_type, res.data_fileupload.file_ext));
    	      		}
    			    else show_error(true, res.message);

    			    $('#upload').button('reset');
        		}
    		});

    	}

      App.back = function(){
    		window.location.href = '<?php echo base_url()?>laporan_akhir/';
    	}

    	App.init_fileupload = function(){
    		if (App.id() > 0)
    		{
    			var id = App.id();
    			App.dokumen.removeAll();
    			$.ajax({
    				url: '<?php echo base_url()?>laporan_akhir/get_fileupload_by_id/'+id,
    				type: 'post',
    				dataType: 'json',
    				success: function(res, xhr){
    					$.each(res, function(i, item){
    			  		App.dokumen.push(new Dokumen(res[i].id, res[i].deskripsi, res[i].client_name, res[i].file_name, res[i].file_size, res[i].file_type, res[i].file_ext));  
    					});
    				}
    			});
    		}

    	}
      
      App.save = function(createNew){
    	  var data = JSON.parse(ko.toJSON(App));
    	  		data['laporan_akhir'] = $('#laporan_akhir').html();
    	      data['dokumen'] = JSON.stringify(ko.toJS(App.dokumen()));
    	      data['purge_dokumen'] = purge_dokumen;
    	      data['purge_filename'] = purge_filename;

    	  var $btn = $('#submit');

    	  $btn.button('loading');
    	  App.processing(true);
    	  $.ajax({
    	    url: '<?php echo base_url()?>laporan_akhir/proses',
    	    type: 'post',
    	    cache: false,
    	    dataType: 'json',
    	    data: data,
    	    success: function(res, xhr){
    	      if (res.isSuccess){
    	      	App.id(res.id);
    	      	show_success(true, res.message);
    	      }
    	      else show_error(true, res.message);

    	      $btn.button('reset');
    	      App.processing(false);
    	    }
    	  });

    	}

    	ko.applyBindings(App);

      <?php if (isset($data['id_laporan_akhir']) && $data['id_laporan_akhir'] > 0) { ?>
    	App.init_fileupload();
      <?php } ?>
  
  </script>
