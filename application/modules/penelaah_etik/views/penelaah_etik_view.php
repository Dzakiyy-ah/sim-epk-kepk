<div class="row">
	<div class="col-sm-3">
		<select class="select2" id="bulan" data-placeholder="Bulan">
			<option value=""></option>
			<option value="1">Januari</option>
			<option value="2">Februari</option>
			<option value="3">Maret</option>
			<option value="4">April</option>
			<option value="5">Mei</option>
			<option value="6">Juni</option>
			<option value="7">Juli</option>
			<option value="8">Agustus</option>
			<option value="9">September</option>
			<option value="10">Oktober</option>			
			<option value="11">November</option>
			<option value="12">Desember</option>
		</select>
	</div>
	<div class="col-sm-3">
		<select class="select2" id="tahun" data-placeholder="Tahun">
			<option value=""></option>
			<?php
			for ($i=2017; $i<=date('Y'); $i++)
			{
				echo '<option value="'.$i.'">'.$i.'</option>';
			}
			?>
		</select>
	</div>
	<div class="col-sm-4">
		<button class="btn btn-sm btn-primary" id="filter" type="button" data-loading-text="Menampilkan...">
			<i class="ace-icon fa fa-search bigger-110"></i>
			Filter Bulan dan Tahun Telaah
		</button>
	</div>
</div>

<div class="space-12"></div>

<table id="grid-table"></table>

<div id="grid-pager"></div>
