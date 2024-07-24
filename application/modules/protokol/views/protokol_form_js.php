    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
    <script src="<?php echo base_url()?>assets/js/select2.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/id.js"></script>
    <script src="<?php echo base_url()?>assets/js/wizard.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.hotkeys.index.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap-wysiwyg.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootbox.js"></script>

    <script type="text/javascript">
    	var data_pengajuan = <?php echo isset($data_pengajuan) ? json_encode($data_pengajuan) : "''" ?>;
    	var purge_lampiran1 = [], purge_filename1 = [];
    	var purge_lampiran2 = [], purge_filename2 = [];
    	var purge_lampiran3 = [], purge_filename3 = [];
    	var purge_lampiran4 = [], purge_filename4 = [];
    	var purge_lampiran5 = [], purge_filename5 = [];
    	var purge_lampiran6 = [], purge_filename6 = [];
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

    		$('#c1').html("<?php echo isset($data['uraianc1']) ? $data['uraianc1'] : ''?>");
    		$('#c2').html('<?php echo isset($data['uraianc2']) ? $data['uraianc2'] : ''?>');
    		$('#d1').html('<?php echo isset($data['uraiand1']) ? $data['uraiand1'] : ''?>');
    		$('#e1').html('<?php echo isset($data['uraiane1']) ? $data['uraiane1'] : ''?>');
    		$('#f1').html('<?php echo isset($data['uraianf1']) ? $data['uraianf1'] : ''?>');
    		$('#f2').html('<?php echo isset($data['uraianf2']) ? $data['uraianf2'] : ''?>');
    		$('#f3').html('<?php echo isset($data['uraianf3']) ? $data['uraianf3'] : ''?>');
    		$('#g1').html('<?php echo isset($data['uraiang1']) ? $data['uraiang1'] : ''?>');
    		$('#g2').html('<?php echo isset($data['uraiang2']) ? $data['uraiang2'] : ''?>');
    		$('#g3').html('<?php echo isset($data['uraiang3']) ? $data['uraiang3'] : ''?>');
    		$('#h1').html('<?php echo isset($data['uraianh1']) ? $data['uraianh1'] : ''?>');
    		$('#h2').html('<?php echo isset($data['uraianh2']) ? $data['uraianh2'] : ''?>');
    		$('#h3').html('<?php echo isset($data['uraianh3']) ? $data['uraianh3'] : ''?>');
    		$('#i1').html('<?php echo isset($data['uraiani1']) ? $data['uraiani1'] : ''?>');
    		$('#i2').html('<?php echo isset($data['uraiani2']) ? $data['uraiani2'] : ''?>');
    		$('#i3').html('<?php echo isset($data['uraiani3']) ? $data['uraiani3'] : ''?>');
    		$('#i4').html('<?php echo isset($data['uraiani4']) ? $data['uraiani4'] : ''?>');
    		$('#j1').html('<?php echo isset($data['uraianj1']) ? $data['uraianj1'] : ''?>');
    		$('#k1').html('<?php echo isset($data['uraiank1']) ? $data['uraiank1'] : ''?>');
    		$('#l1').html('<?php echo isset($data['uraianl1']) ? $data['uraianl1'] : ''?>');
    		$('#l2').html('<?php echo isset($data['uraianl2']) ? $data['uraianl2'] : ''?>');
    		$('#m1').html('<?php echo isset($data['uraianm1']) ? $data['uraianm1'] : ''?>');
    		$('#n1').html('<?php echo isset($data['uraiann1']) ? $data['uraiann1'] : ''?>');
    		$('#n2').html('<?php echo isset($data['uraiann2']) ? $data['uraiann2'] : ''?>');
    		$('#o1').html('<?php echo isset($data['uraiano1']) ? $data['uraiano1'] : ''?>');
    		$('#p1').html('<?php echo isset($data['uraianp1']) ? $data['uraianp1'] : ''?>');
    		$('#p2').html('<?php echo isset($data['uraianp2']) ? $data['uraianp2'] : ''?>');
    		$('#q1').html('<?php echo isset($data['uraianq1']) ? $data['uraianq1'] : ''?>');
    		$('#q2').html('<?php echo isset($data['uraianq2']) ? $data['uraianq2'] : ''?>');
    		$('#r1').html('<?php echo isset($data['uraianr1']) ? $data['uraianr1'] : ''?>');
    		$('#r2').html('<?php echo isset($data['uraianr2']) ? $data['uraianr2'] : ''?>');
    		$('#r3').html('<?php echo isset($data['uraianr3']) ? $data['uraianr3'] : ''?>');
    		$('#s1').html('<?php echo isset($data['uraians1']) ? $data['uraians1'] : ''?>');
    		$('#s2').html('<?php echo isset($data['uraians2']) ? $data['uraians2'] : ''?>');
    		$('#s3').html('<?php echo isset($data['uraians3']) ? $data['uraians3'] : ''?>');
    		$('#s4').html('<?php echo isset($data['uraians4']) ? $data['uraians4'] : ''?>');
    		$('#t1').html('<?php echo isset($data['uraiant1']) ? $data['uraiant1'] : ''?>');
    		$('#u1').html('<?php echo isset($data['uraianu1']) ? $data['uraianu1'] : ''?>');
    		$('#v1').html('<?php echo isset($data['uraianv1']) ? $data['uraianv1'] : ''?>');
    		$('#w1').html('<?php echo isset($data['uraianw1']) ? $data['uraianw1'] : ''?>');
    		$('#w2').html('<?php echo isset($data['uraianw2']) ? $data['uraianw2'] : ''?>');
    		$('#x1').html('<?php echo isset($data['uraianx1']) ? $data['uraianx1'] : ''?>');
    		$('#y1').html('<?php echo isset($data['uraiany1']) ? $data['uraiany1'] : ''?>');
    		$('#y2').html('<?php echo isset($data['uraiany2']) ? $data['uraiany2'] : ''?>');
    		$('#z1').html('<?php echo isset($data['uraianz1']) ? $data['uraianz1'] : ''?>');
    		$('#aa1').html('<?php echo isset($data['uraianaa1']) ? $data['uraianaa1'] : ''?>');
    		$('#aa2').html('<?php echo isset($data['uraianaa2']) ? $data['uraianaa2'] : ''?>');
    		$('#aa3').html('<?php echo isset($data['uraianaa3']) ? $data['uraianaa3'] : ''?>');
    		$('#bb1').html('<?php echo isset($data['uraianbb1']) ? $data['uraianbb1'] : ''?>');
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

    	function rawurlencode (str) {
        str = (str+'').toString();        
        return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').replace(/\)/g, '%29').replace(/\*/g, '%2A');
    	}

    	function getNewid(){
    	  return 'new_' + parseFloat((new Date().getTime() + '').slice(7))+ Math.round(Math.random() * 100);
    	}

			function isContentEmpty(text) {
				text = text.replaceAll("&nbsp;", "").
				replaceAll("<br>", "").
				replaceAll(" ", "").
				replaceAll("<p>", "").
				replaceAll("</p>", "").trim();

				return (text.length == 0) ? true : false;
			}

			var Lampiran = function(id, client_name, file_name, file_size, file_type, file_ext){
    		this.id = id;
    		this.client_name = client_name;
    		this.file_name = file_name;
    		this.file_size = file_size;
    		this.file_type = file_type;
    		this.file_ext = file_ext;
    	}

    	var ProtokolModel = function(){
    		var self = this;
    		self.id = ko.observable(<?php echo isset($data['id_pep']) ? $data['id_pep'] : 0 ?>);
    		self.id_pengajuan = ko.observable(<?php echo isset($data['id_pengajuan']) ? $data['id_pengajuan'] : 0 ?>);
    		self.judul = ko.observable(<?php echo isset($data['judul']) ? json_encode($data['judul']) : ""?>);
    		self.lokasi = ko.observable(<?php echo isset($data['tempat_penelitian']) ? json_encode($data['tempat_penelitian']) : ""?>);
    		self.is_multi_senter = ko.observable('<?php echo isset($data['is_multi_senter']) ? $data['is_multi_senter'] : ""?>');
    		self.is_setuju_senter = ko.observable('<?php echo isset($data['is_setuju_senter']) && $data['is_multi_senter'] === '1' ? $data['is_setuju_senter'] : ""?>');
    		self.link_proposal = ko.observable('<?php echo isset($data['link_proposal']) ? $data['link_proposal'] : ""?>');
        self.valid_protokol = ko.observable(false);

    		self.lampiran1 = ko.observableArray([]);
    		self.removeLampiran1 = function(file){
    		    purge_lampiran1.push(file.id);
    		    purge_filename1.push(file.file_name);
    		    self.lampiran1.remove(file);
    		};
    		self.lampiran2 = ko.observableArray([]);
    		self.removeLampiran2 = function(file){
    		    purge_lampiran2.push(file.id);
    		    purge_filename2.push(file.file_name);
    		    self.lampiran2.remove(file);
    		};
    		self.lampiran3 = ko.observableArray([]);
    		self.removeLampiran3 = function(file){
    		    purge_lampiran3.push(file.id);
    		    purge_filename3.push(file.file_name);
    		    self.lampiran3.remove(file);
    		};
    		self.lampiran4 = ko.observableArray([]);
    		self.removeLampiran4 = function(file){
    		    purge_lampiran4.push(file.id);
    		    purge_filename4.push(file.file_name);
    		    self.lampiran4.remove(file);
    		};
    		self.lampiran5 = ko.observableArray([]);
    		self.removeLampiran5 = function(file){
    		    purge_lampiran5.push(file.id);
    		    purge_filename5.push(file.file_name);
    		    self.lampiran5.remove(file);
    		};
    		self.lampiran6 = ko.observableArray([]);
    		self.removeLampiran6 = function(file){
    		    purge_lampiran6.push(file.id);
    		    purge_filename6.push(file.file_name);
    		    self.lampiran6.remove(file);
    		};

    		self.is_resume = <?php echo isset($is_resume) ? $is_resume : 0 ?>;
    		self.klasifikasi = '<?php echo isset($klas_putusan['klasifikasi']) ? $klas_putusan['klasifikasi'] : "" ?>';
    		self.keputusan = '<?php echo isset($klas_putusan['keputusan']) ? $klas_putusan['keputusan'] : "" ?>';
    		self.processing = ko.observable(false);
    	}

    	var App = new ProtokolModel();

    	App.id_pengajuan.subscribe(function(newValue){
    		$.each(data_pengajuan, function(i, item){
    			if (item.id_pengajuan == newValue)
    			{
    				App.judul(item.judul);
    				App.lokasi(item.tempat_penelitian);
    				App.is_multi_senter(item.is_multi_senter);
    				if (item.is_multi_senter == 1)
    					App.is_setuju_senter(item.is_setuju_senter);
    			}
    		})
    	})

    	App.upload = function(file){
    	  $('#'+file).trigger('click');
    	}

    	App.do_upload = function(file){
    	  var data_upload = new FormData();
    	  data_upload.append(file, $('#'+file).prop('files')[0]);

    	  switch(file){
    	  	case 'lampiran1' : $('#lampiran1-btn').button('loading'); break;
    	  	case 'lampiran2' : $('#lampiran2-btn').button('loading'); break;
    	  	case 'lampiran3' : $('#lampiran3-btn').button('loading'); break;
    	  	case 'lampiran4' : $('#lampiran4-btn').button('loading'); break;
    	  	case 'lampiran5' : $('#lampiran5-btn').button('loading'); break;
    	  	case 'lampiran6' : $('#lampiran6-btn').button('loading'); break;
    	  }

    	  $.ajax({
    	    url: '<?php echo base_url()?>protokol/do_upload/'+file,
    	    type: 'post',
    	    processData: false, // important
    	    contentType: false, // important
    	    dataType : 'json',
    	    data: data_upload,
    	    success: function(res, xhr){
    	      if (res.isSuccess){
    	      	if (file == 'lampiran1'){
    	      		var id = getNewid(),
    	      				upl = res.data_fileupload;
    	      		App.lampiran1.push(new Lampiran(id, upl.client_name, upl.file_name, upl.file_size, upl.file_type, upl.file_ext))
    	      	}
    	      	else if (file == 'lampiran2'){
    	      		var id = getNewid(),
    	      				upl = res.data_fileupload;
    	      		App.lampiran2.push(new Lampiran(id, upl.client_name, upl.file_name, upl.file_size, upl.file_type, upl.file_ext))
    	      	}
    	      	else if (file == 'lampiran3'){
    	      		var id = getNewid(),
    	      				upl = res.data_fileupload;
    	      		App.lampiran3.push(new Lampiran(id, upl.client_name, upl.file_name, upl.file_size, upl.file_type, upl.file_ext))
    	      	}
    	      	else if (file == 'lampiran4'){
    	      		var id = getNewid(),
    	      				upl = res.data_fileupload;
    	      		App.lampiran4.push(new Lampiran(id, upl.client_name, upl.file_name, upl.file_size, upl.file_type, upl.file_ext))
    	      	}
    	      	else if (file == 'lampiran5'){
    	      		var id = getNewid(),
    	      				upl = res.data_fileupload;
    	      		App.lampiran5.push(new Lampiran(id, upl.client_name, upl.file_name, upl.file_size, upl.file_type, upl.file_ext))
    	      	}
    	      	else if (file == 'lampiran6'){
    	      		var id = getNewid(),
    	      				upl = res.data_fileupload;
    	      		App.lampiran6.push(new Lampiran(id, upl.client_name, upl.file_name, upl.file_size, upl.file_type, upl.file_ext))
    	      	}

    	      }
    		    else show_error(true, res.message);

    	  		$('#lampiran1-btn').button('reset');
        		$('#lampiran2-btn').button('reset');
        		$('#lampiran3-btn').button('reset');
        		$('#lampiran4-btn').button('reset');
        		$('#lampiran5-btn').button('reset');
        		$('#lampiran6-btn').button('reset');
    	    }
    	  });
    	}

    	App.cetak = function(){
    		var id = App.id();
    		window.open('<?php echo base_url()?>protokol/cetak_protokol/'+id, '_blank');	
    	}

    	App.init_lampiran = function(){
    		if (App.id() > 0){
    			var id = App.id();

    			App.lampiran1.removeAll();
    			App.lampiran2.removeAll();
    			App.lampiran3.removeAll();
    			App.lampiran4.removeAll();
    			App.lampiran5.removeAll();
    			App.lampiran6.removeAll();

    		  $.ajax({
    		    url: '<?php echo base_url()?>protokol/get_lampiran/'+id,
    		    type: 'post',
    		    cache: false,
    		    dataType: 'json',
    		    success: function(res, xhr){
    		    	$.each(res, function(i, item){	    		
    		      	if (item.lampiran == 1){
    		      		App.lampiran1.push(new Lampiran(item.id, item.client_name, item.file_name, item.file_size, item.file_type, item.file_ext));
    		      	}
    		      	else if (item.lampiran == 2){
    		      		App.lampiran2.push(new Lampiran(item.id, item.client_name, item.file_name, item.file_size, item.file_type, item.file_ext));
    		      	}
    		      	else if (item.lampiran == 3){
    		      		App.lampiran3.push(new Lampiran(item.id, item.client_name, item.file_name, item.file_size, item.file_type, item.file_ext));
    		      	}
    		      	else if (item.lampiran == 4){
    		      		App.lampiran4.push(new Lampiran(item.id, item.client_name, item.file_name, item.file_size, item.file_type, item.file_ext));
    		      	}
    		      	else if (item.lampiran == 5){
    		      		App.lampiran5.push(new Lampiran(item.id, item.client_name, item.file_name, item.file_size, item.file_type, item.file_ext));
    		      	}
    		      	else if (item.lampiran == 6){
    		      		App.lampiran6.push(new Lampiran(item.id, item.client_name, item.file_name, item.file_size, item.file_type, item.file_ext));
    		      	}
    		    	})

    		    }
    		  });
    		}
    	}

    	App.back = function(){
    		window.location.href = '<?php echo base_url()?>protokol/';
    	}

    	App.lanjut = function(){
    		window.location.href = '<?php echo base_url()?>self_assesment/form/';
    	}

    	App.save = function(createNew){
				var data = JSON.parse(ko.toJSON(App));
						data['uraianc1'] = $('#c1').html(),
						data['uraianc2'] = $('#c2').html(),
						data['uraiand1'] = $('#d1').html(),
						data['uraiane1'] = $('#e1').html(),
						data['uraianf1'] = $('#f1').html(),
						data['uraianf2'] = $('#f2').html(),
						data['uraianf3'] = $('#f3').html(),
						data['uraiang1'] = $('#g1').html(),
						data['uraiang2'] = $('#g2').html(),
						data['uraiang3'] = $('#g3').html(),
						data['uraianh1'] = $('#h1').html(),
						data['uraianh2'] = $('#h2').html(),
						data['uraianh3'] = $('#h3').html(),
						data['uraiani1'] = $('#i1').html(),
						data['uraiani2'] = $('#i2').html(),
						data['uraiani3'] = $('#i3').html(),
						data['uraiani4'] = $('#i4').html(),
						data['uraianj1'] = $('#j1').html(),
						data['uraiank1'] = $('#k1').html(),
						data['uraianl1'] = $('#l1').html(),
						data['uraianl2'] = $('#l2').html(),
						data['uraianm1'] = $('#m1').html(),
						data['uraiann1'] = $('#n1').html(),
						data['uraiann2'] = $('#n2').html(),
						data['uraiano1'] = $('#o1').html(),
						data['uraianp1'] = $('#p1').html(),
						data['uraianp2'] = $('#p2').html(),
						data['uraianq1'] = $('#q1').html(),
						data['uraianq2'] = $('#q2').html(),
						data['uraianr1'] = $('#r1').html(),
						data['uraianr2'] = $('#r2').html(),
						data['uraianr3'] = $('#r3').html(),
						data['uraians1'] = $('#s1').html(),
						data['uraians2'] = $('#s2').html(),
						data['uraians3'] = $('#s3').html(),
						data['uraians4'] = $('#s4').html(),
						data['uraiant1'] = $('#t1').html(),
						data['uraianu1'] = $('#u1').html(),
						data['uraianv1'] = $('#v1').html(),
						data['uraianw1'] = $('#w1').html(),
						data['uraianw2'] = $('#w2').html(),
						data['uraianx1'] = $('#x1').html(),
						data['uraiany1'] = $('#y1').html(),
						data['uraiany2'] = $('#y2').html(),
						data['uraianz1'] = $('#z1').html(),
						data['uraianaa1'] = $('#aa1').html(),
						data['uraianaa2'] = $('#aa2').html(),
						data['uraianaa3'] = $('#aa3').html(),
						data['uraianbb1'] = $('#bb1').html();

						data['purge_lampiran1'] = purge_lampiran1,
						data['purge_lampiran2'] = purge_lampiran2,
						data['purge_lampiran3'] = purge_lampiran3,
						data['purge_lampiran4'] = purge_lampiran4,
						data['purge_lampiran5'] = purge_lampiran5,
						data['purge_lampiran6'] = purge_lampiran6;

						data['purge_filename1'] = purge_filename1,
						data['purge_filename2'] = purge_filename2,
						data['purge_filename3'] = purge_filename3,
						data['purge_filename4'] = purge_filename4,
						data['purge_filename5'] = purge_filename5,
						data['purge_filename6'] = purge_filename6;

				var $btn = $('#submit');

				$btn.button('loading');
				App.processing(true);
				$.ajax({
					url: '<?php echo base_url()?>protokol/proses',
					type: 'post',
					cache: false,
					dataType: 'json',
					data: data,
					success: function(res, xhr){
						if (res.isSuccess){
							App.id(res.id);
							App.init_lampiran();
							show_success(true, res.message);
						}
						else show_error(true, res.message);

						$btn.button('reset');
						App.processing(false);
					}
				});
    	}

    	ko.applyBindings(App);

    <?php if (isset($data['id_pep']) && $data['id_pep'] > 0) { ?>
    App.init_lampiran();
    <?php } ?>
    </script>
