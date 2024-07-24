    <!-- page specific plugin scripts -->
    <script src="<?php echo base_url()?>assets/js/jquery.jqGrid.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/grid.locale-id.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
    <script src="<?php echo base_url()?>assets/js/select2.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/id.js"></script>

    <!-- inline scripts related to this page -->
    <script type="text/javascript">
    		
    	jQuery(function($) {
        $('#add').click(function(){
          addRow();
        })

        $('.scrollable').each(function () {
          var $this = $(this);
          $(this).ace_scroll({
            size: $this.attr('data-size') || 100,
            //styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
          });
        });

        $("#protokol").select2({
          placeholder: "Pilih...",
          language: "id",
          allowClear: true,
          width: "100%"
        });

    		$('#pilih').click(function(){
    			var id_pep = $('#protokol').val();

    			window.location.href = '<?php echo base_url()?>perbaikan/form/0/'+id_pep;
    		})

    		var grid_selector = "#grid-table";
    		var pager_selector = "#grid-pager";
    		
    		var parent_column = $(grid_selector).closest('[class*="col-"]');
    		//resize to fit page size
    		$(window).on('resize.jqGrid', function () {
    			$(grid_selector).jqGrid( 'setGridWidth', parent_column.width() );
    	    })
    		
    		//resize on sidebar collapse/expand
    		$(document).on('settings.ace.jqGrid' , function(ev, event_name, collapsed) {
    			if( event_name === 'sidebar_collapsed' || event_name === 'main_container_fixed' ) {
    				//setTimeout is for webkit only to give time for DOM changes and then redraw!!!
    				setTimeout(function() {
    					$(grid_selector).jqGrid( 'setGridWidth', parent_column.width() );
    				}, 20);
    			}
    	  })
    			
    		jQuery(grid_selector).jqGrid({
    			//direction: "rtl",
    	
    			subGrid : false,
    			url: '<?php echo base_url()?>perbaikan/get_daftar/',
    			datatype: "json",
          mtype: "POST",
    			height: 250,
    			colNames:['ID', 'ID Old', 'No Protokol', 'Judul', 'Tanggal Pengajuan', 'KEPK', 'Waktu Mulai', 'Waktu Selesai', 'Tanggal Perbaikan', 'Perbaikan ke'],
    			colModel:[
    				{name:'id', index:'id', hidden: true, editable:false},
    				{name:'id_pep_old', index:'id_pep_old', hidden: true, editable:false},
    				{name:'no_protokol', index:'no_protokol', editable:false},
    				{name:'judul', index:'judul', editable:false},
    				{name:'tgl_pengajuan', index:'tgl_pengajuan', editable:false, align:'center'},
    				{name:'kepk', index:'kepk', editable:false},
    				{name:'mulai', index:'mulai', editable:false, align:'center'},
    				{name:'selesai', index:'selesai', editable:false, align:'center'},
    				{name:'tgl_perbaikan', index:'tgl_perbaikan', editable:false, align:'center'},
    				{name:'revisi_ke', index:'revisi_ke', editable:false, align:'center'}
    			], 
    	
    			viewrecords : true,
    			rowNum:10,
    			rowList:[10,20,30],
    			pager : pager_selector,
    			altRows: true,
    			//toppager: true,
    			
    			multiselect: false,
    			//multikey: "ctrlKey",
    	    multiboxonly: true,
    	    rownumbers: true,
    	
    			ondblClickRow: function (rowid, iRow, iCol, e) {
    				var id_pep_old = jQuery(grid_selector).jqGrid('getCell', rowid, 'id_pep_old');
    				window.location = '<?php echo base_url()?>perbaikan/form/'+rowid+'/'+id_pep_old;
    			},
    			loadComplete : function() {
    				var table = this;
    				setTimeout(function(){
    					
    					updatePagerIcons(table);
    					enableTooltips(table);
    				}, 0);
    			},
    			gridComplete : function() {
    				$('#grid-table_rn').text('No');
    				$('.ui-jqgrid-bdiv').css('overflow-x', 'auto');
    			},
    	
    			caption: "Perbaikan Protokol"
    	
    		});
    		$(window).triggerHandler('resize.jqGrid');//trigger window resize to make the grid get the correct size
    			
    		//navButtons
    		jQuery(grid_selector).jqGrid('navGrid',pager_selector,
    			{ 	//navbar options
    				edit: true,
    				editicon: 'ace-icon fa fa-pencil blue',
    				editfunc: editRow,
    				add: true,
    				addicon: 'ace-icon fa fa-plus-circle purple',
    				addfunc: addRow,
    				del: false,
    				delicon : 'ace-icon fa fa-trash-o red',
    				search: true,
    				searchicon : 'ace-icon fa fa-search orange',
    				refresh: true,
    				refreshicon : 'ace-icon fa fa-refresh green',
    				view: true,
    				viewicon : 'ace-icon fa fa-search-plus grey',
    			},
    			{},
    			{},
    			{
    				//delete record form
    				url: '<?php echo base_url()?>perbaikan/hapus/',
    				recreateForm: true,
    				beforeShowForm : function(e) {
    					var form = $(e[0]);
    					if(form.data('styled')) return false;
    					
    					form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
    					style_delete_form(form);
    					
    					form.data('styled', true);
    				},
    				afterComplete : function (response, postdata, formid) {
    					var res = JSON.parse(response.responseText);
    					
    					if (res.isSuccess)
    				        show_success(true, res.message);
    				    else
    				    	show_error(true, res.message);
    				}
    			},
    			{},
    			{
    				//search form
    				recreateForm: true,
    				afterShowSearch: function(e){
    					var form = $(e[0]);
    					form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
    					style_search_form(form);
    				},
    				afterRedraw: function(){
    					style_search_filters($(this));
    				}
    				,
    				multipleSearch: false,
    				/**
    				multipleGroup:true,
    				showQuery: true
    				*/
    			},
    			{
    				//view record form
    				recreateForm: true,
    				beforeShowForm: function(e){
    					var form = $(e[0]);
    					form.closest('.ui-jqdialog').css('width', '700px');
    					form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />');
    					// $('#viewmodgrid-table').css('width', '700px');
    				}
    			}
    		)

    		function editRow(rowid) {
    			var id_pep_old = jQuery(grid_selector).jqGrid('getCell', rowid, 'id_pep_old');
    			window.location.href = '<?php echo base_url()?>perbaikan/form/'+rowid+'/'+id_pep_old;
    		}

    		function addRow() {
    			$('#my-modal').modal('show');
    		}
    		
    		function style_search_filters(form) {
    			form.find('.delete-rule').val('X');
    			form.find('.add-rule').addClass('btn btn-xs btn-primary');
    			form.find('.add-group').addClass('btn btn-xs btn-success');
    			form.find('.delete-group').addClass('btn btn-xs btn-danger');
    		}

    		function style_search_form(form) {
    			var dialog = form.closest('.ui-jqdialog');
    			var buttons = dialog.find('.EditTable')
    			buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');
    			buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');
    			buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');
    		}
    				
    		//replace icons with FontAwesome icons like above
    		function updatePagerIcons(table) {
    			var replacement = 
    			{
    				'ui-icon-seek-first' : 'ace-icon fa fa-angle-double-left bigger-140',
    				'ui-icon-seek-prev' : 'ace-icon fa fa-angle-left bigger-140',
    				'ui-icon-seek-next' : 'ace-icon fa fa-angle-right bigger-140',
    				'ui-icon-seek-end' : 'ace-icon fa fa-angle-double-right bigger-140'
    			};
    			$('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function(){
    				var icon = $(this);
    				var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
    				
    				if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
    			})
    		}
    	
    		function enableTooltips(table) {
    			$('.navtable .ui-pg-button').tooltip({container:'body'});
    			$(table).find('.ui-pg-div').tooltip({container:'body'});
    		}
    	
    		//var selr = jQuery(grid_selector).jqGrid('getGridParam','selrow');
    	
    		$(document).one('ajaxloadstart.page', function(e) {
    			$.jgrid.gridDestroy(grid_selector);
    			$('.ui-jqdialog').remove();
    		});

    		$('#profile-feed-1').ace_scroll({
    			height: '250px',
    			mouseWheelLock: true,
    			alwaysVisible : true
    		});
    				
    	});

    	var Protokol = function(id, no, judul, waktu) {
    		this.id = id;
    		this.no = no;
    		this.judul = judul;
    		this.waktu = waktu;
    		this.url_edit = ko.pureComputed(function(){
    			return '<?php echo base_url()?>perbaikan/form/0/'+id;
    		})
    	}

    	var PerbaikanModel = function(){
    		var self = this;
    		this.data_protokol = ko.observableArray([]);
    	} 

    	var App = new PerbaikanModel();

    	App.init_protokol = function(){
        App.data_protokol.removeAll();
        $.ajax({
          url: '<?php echo base_url()?>perbaikan/get_protokol/',
          type: 'post',
          dataType: 'json',
          success: function(res, xhr){
            $.each(res, function(i, item){
              App.data_protokol.push(new Protokol(res[i].id_pep, res[i].no, res[i].judul, res[i].waktu));
            });
          }
        });
    	}

    	ko.applyBindings(App);
    </script>
