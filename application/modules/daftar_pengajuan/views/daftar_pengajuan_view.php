<div class="page-header">
	<h1>
		<?php echo isset($page_header) ? $page_header : '' ?>
		<?php if (isset($subheader)) { ?>
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			<?php echo $subheader ?>
		</small>
		<?php } ?>
	</h1>
</div><!-- /.page-header -->

<div class="col-sm-12">
	<table id="grid-table"></table>

	<div id="grid-pager"></div>
</div>