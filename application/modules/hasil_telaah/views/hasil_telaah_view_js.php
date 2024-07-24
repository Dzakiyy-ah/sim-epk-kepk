<!-- page specific plugin scripts -->
<script src="<?php echo base_url()?>assets/js/jquery.jqGrid.min.js"></script>
<script src="<?php echo base_url()?>assets/js/grid.locale-id.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
<script src="<?php echo base_url()?>assets/js/app.js"></script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
		
	jQuery(function($) {

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
	
			subGrid : true,
			subGridOptions : {
						plusicon : "ace-icon fa fa-plus center bigger-110 blue",
						minusicon  : "ace-icon fa fa-minus center bigger-110 blue",
						openicon : "ace-icon fa fa-chevron-right center orange"
					},
			//for this example we are using local data
			subGridRowExpanded: function (subgridDivId, rowId) {
				var subgridTableId = subgridDivId + "_t";
				$("#" + subgridDivId).html("<table id='" + subgridTableId + "'></table>");
				$("#" + subgridTableId).jqGrid({
					url: '<?php echo base_url()?>hasil_telaah/get_file_by_id/'+rowId,
					datatype: 'json',
					colNames: ['ID', 'No', 'Nama File', 'Cetak', '', ''],
					colModel: [
						{ name: 'id', hidden: true },
						{ name: 'no', width: 50 },
						{ name: 'nama_file', width: 400 },
						{ name: 'cetak', width: 50, formatter: cetak_file },
						{ name: 'klasifikasi', hidden: true},
						{ name: 'jenis_file', hidden: true}
					]
				});
			},
			url: '<?php echo base_url()?>hasil_telaah/get_daftar/',
			datatype: "json",
      mtype: "POST",
			height: 250,
			colNames:['ID', 'No Protokol', 'Judul', 'Klasifikasi', 'Keputusan', 'Jenis Surat', 'Tanggal Upload'],
			colModel:[
				{name:'id', index:'id', hidden: true, editable:false},
				{name:'no_protokol', index:'no_protokol', editable:false},
				{name:'judul', index:'judul', editable:false},
				{name:'klasifikasi', index:'klasifikasi', editable:false},
				{name:'keputusan', index:'keputusan', editable:false},
				{name:'jenis_surat', index:'jenis_surat', editable:false},
				{name:'tgl_upload', index:'tgl_upload', editable:false, align:'center'}
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
	
			caption: "Hasil Telaah"
	
		});
		$(window).triggerHandler('resize.jqGrid');//trigger window resize to make the grid get the correct size
			
		// cetak file
		function cetak_file(cellvalue, options, rowObject) {
			var id = rowObject.id,
				klasifikasi = rowObject.klasifikasi,
				jenis_file = encodeURI(rowObject.jenis_file);
			return '<a href="<?php echo base_url()?>hasil_telaah/cetak/'+id+'/'+klasifikasi+'/'+jenis_file+'" class="label label-default label-white" target="_blank"><i class="ace-icon fa fa-print bigger-120"></i></a>';
		}

		//navButtons
		jQuery(grid_selector).jqGrid('navGrid',pager_selector,
			{ 	//navbar options
				edit: false,
				editicon: 'ace-icon fa fa-pencil blue',
				add: false,
				addicon: 'ace-icon fa fa-plus-circle purple',
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
			{},
			{},
			{
				//search form
				recreateForm: true,
				beforeShowForm: function(e){
					var form = $(e[0]);
					form.closest('.ui-jqdialog').css('width', '700px');
				},
				afterShowSearch: function(e){
					var form = $(e[0]);
					form.closest('.ui-jqdialog').css('width', '700px');
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

	});

</script>