<!-- page specific plugin scripts -->
<script src="<?php echo base_url()?>assets/js/jquery.jqGrid.min.js"></script>
<script src="<?php echo base_url()?>assets/js/grid.locale-id.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
<script src="<?php echo base_url()?>assets/js/app.js"></script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
		
	jQuery(function($) {
    $('#add').click(function(){
      addRow();
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
			url: '<?php echo base_url()?>protokol/get_daftar/',
			datatype: "json",
      mtype: "POST",
			height: 250,
			colNames:['ID', 'No Protokol', 'Judul', 'Tanggal Pengajuan', 'KEPK', 'Waktu Mulai', 'Waktu Selesai', 'Tanggal Protokol'],
			colModel:[
				{name:'id', index:'id', hidden: true},
				{name:'no_protokol', index:'no_protokol', width:80, editable:false},
				{name:'judul', index:'judul', width:100, editable:false},
				{name:'tgl_pengajuan', index:'tgl_pengajuan', width:50, editable:false},
				{name:'kepk', index:'kepk', width:80, editable:false},
				{name:'mulai', index:'mulai', width:50, editable:false},
				{name:'selesai', index:'selesai', width:50, editable:false},
				{name:'tgl_protokol', index:'tgl_protokol', width:50, editable:false},
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
				window.location = '<?php echo base_url()?>protokol/form/'+rowid;
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
	
			caption: "Protokol",
			editurl: "<?php echo base_url()?>protokol/proses"
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
				del: true,
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
				recreateForm: true,
				beforeShowForm : function(e) {
					var form = $(e[0]);
					if(form.data('styled')) return false;
					
					form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
					style_delete_form(form);
					
					form.data('styled', true);
				},
				afterComplete : function(response, postdata, formid) {
					res = JSON.parse(response.responseText);
					if (res.isSuccess)
						show_success(true, res.message);
					else
						show_error(true, res.message);
				},
				// onClick : function(e) {
				// 	alert(1);
				// }
			},
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

		function editRow(rowid) {
			window.location.href = '<?php echo base_url()?>protokol/form/'+rowid;
		}

		function addRow() {
			window.location.href = '<?php echo base_url()?>protokol/form/';
		}

		function style_delete_form(form) {
			var buttons = form.next().find('.EditButton .fm-button');
			buttons.addClass('btn btn-sm btn-white btn-round').find('[class*="-icon"]').hide();//ui-icon, s-icon
			buttons.eq(0).addClass('btn-danger').prepend('<i class="ace-icon fa fa-trash-o"></i>');
			buttons.eq(1).addClass('btn-default').prepend('<i class="ace-icon fa fa-times"></i>')
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

</script>
