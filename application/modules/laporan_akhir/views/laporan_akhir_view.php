<?php if ($this->session->userdata('id_group_'.APPAUTH) == 3) { ?>
<p>
  <div class="clearfix">
    <span class="inline pull-right">
      <button class="btn btn-purple" id="add" type="button">
        <i class="ace-icon fa fa-plus-circle bigger-110"></i>
        Tambah Data
	    </button>
    </span>
  </div>
</p>
<?php } ?>

<table id="grid-table"></table>

<div id="grid-pager"></div>