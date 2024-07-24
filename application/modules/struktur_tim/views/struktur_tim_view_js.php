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
					$(grid_selector).jqGrid( 'setGridWidth', parent_column1.width() );
				}, 20);
			}
	  })
			
		jQuery(grid_selector).jqGrid({
			//direction: "rtl",
	
			subGrid : true,
      subgridtype : "json",
			subGridOptions : {
				plusicon : "ace-icon fa fa-plus center bigger-110 blue",
				minusicon  : "ace-icon fa fa-minus center bigger-110 blue",
				openicon : "ace-icon fa fa-chevron-right center orange",
			},
			//for this example we are using local data
			subGridRowExpanded: function (subgridDivId, rowId) {
				var subgridTableId = subgridDivId + "_t";
				$("#" + subgridDivId).html("<table id='" + subgridTableId + "'></table>");
				$("#" + subgridTableId).jqGrid({
					url: '<?php echo base_url()?>struktur_tim/get_daftar_struktur_by_id/'+rowId,
					datatype: 'json',
					colNames: ['No','Nomor','Nama','Jabatan'],
					colModel: [
						{ name: 'no', width: 50 },
						{ name: 'nomor', width: 150 },
						{ name: 'nama', width: 300 },
						{ name: 'jabatan', width: 150 }
					],
          rowNum: 10000
	   		});
			},
			url: '<?php echo base_url()?>struktur_tim/get_daftar/',
			mtype: 'post',
			datatype: "json",
			height: 250,
			colNames:['ID', 'Periode', 'Ketua', 'Aktif KEPK', 'Aktif Tim KEPK'],
			colModel:[
				{name:'id', index:'id', hidden: true},
				{name:'periode', index:'periode', width:50, editable:false},
				{name:'ketua', index:'ketua', width:100, editable:false},
				{name:'aktif_kepk', index:'aktif_kepk', width:20, editable:false},
				{name:'aktif_tim_kepk', index:'aktif_tim_kepk', width:20, editable:false},
			], 
	
			viewrecords : true,
			rowNum:10,
			rowList:[10,20,30],
			pager : pager_selector,
			altRows: true,
			//toppager: true,
			
			//multikey: "ctrlKey",
	    multiboxonly: true,
	    rownumbers: true,
	
			ondblClickRow: function (rowid, iRow, iCol, e) {
				window.location = '<?php echo base_url()?>struktur_tim/lihat/'+rowid;
			},
			loadComplete : function() {
				var table = this;
				setTimeout(function(){
					
					updatePagerIcons(table);
					enableTooltips(table);
				}, 0);
			},
	
			caption: "<?php echo isset($breadcrumb) ? $breadcrumb : ''?>"
		});
		$(window).triggerHandler('resize.jqGrid');//trigger window resize to make the grid get the correct size
		
		//navButtons
		jQuery(grid_selector).jqGrid('navGrid',pager_selector,
			{ 	//navbar options
				edit: true,
        editicon : 'ace-icon fa fa-folder-open blue',
        editfunc: showRow,
        edittitle: 'Lihat Detail',
				add: true,
        addicon : 'ace-icon fa fa-arrow-circle-o-down purple',
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
				url: '<?php echo base_url()?>struktur_tim/hapus/',
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
			{
				//search form
				recreateForm: true,
				afterShowSearch: function(e){
					var form = $(e[0]);
          form.closest('.ui-jqdialog').css('width', '600px');
					form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
					style_search_form(form);
				},
				afterRedraw: function(){
					style_search_filters($(this));
				}
				,
				multipleSearch: false,
			},
			{
				//view record form
				recreateForm: true,
				beforeShowForm: function(e){
					var form = $(e[0]);
					form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
				}
			}
		)

		$(window).triggerHandler('resize.jqGrid');//trigger window resize to make the grid get the correct size
		
    function showRow(rowid) {
      window.location.href = '<?php echo base_url()?>struktur_tim/lihat/'+rowid;
    }

		function addRow() {
      $('.page-content').append('<div class="message-loading-overlay"><i class="fa-spin ace-icon fa fa-spinner orange2 bigger-160"></i></div>');
      $('#add_grid-table').find('.ui-pg-div').html('<span class="ui-icon ui-state-disabled ace-icon fa fa-spinner purple"></span>')
      $.ajax({
        url: '<?php echo base_url()?>struktur_tim/import_data',
        type: 'post',
        cache: false,
        dataType : 'json',
        success: function(res, xhr){
          if (res.isSuccess){
            show_success(true, res.message);
            $('#grid-table').trigger('reloadGrid');
          }
          else show_error(true, res.message);

          $('.page-content').find('.message-loading-overlay').remove();
          $('#add_grid-table').find('.ui-pg-div').html('<span class="ui-icon ace-icon fa fa-arrow-circle-o-down purple"></span>')
        }
      });
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
							
	});
</script>
