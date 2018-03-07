<?php
//Via action call
//$dataurl = "?display=directdid&action=getJSON&jdata=grid&quietmode=1";
//Via BMO AJAX call
$dataurl = "ajax.php?module=directdid&command=getJSON&jdata=grid";
?>
<div id="toolbar-all">
	<button id="remove-all" class="btn btn-danger btn-remove" data-type="extensions" disabled data-section="all">
		<i class="glyphicon glyphicon-remove"></i> <span><?php echo _('Delete')?></span>
	</button>
</div>
<table id="mygrid" data-url="<?php echo $dataurl?>" data-cache="false" data-toolbar="#toolbar-all" data-maintain-selected="true" data-show-columns="true" data-show-toggle="true" data-toggle="table" data-pagination="true" data-search="true" class="table table-striped">
	<thead>
		<tr>
			<th data-field="name"><?php echo _("Items")?></th>
			<th data-field="link" data-formatter="linkFormatter"><?php echo _("Actions")?></th>
		</tr>
	</thead>
</table>