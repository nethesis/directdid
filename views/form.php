<form action="" method="post" class="fpbx-submit" id="hwform" name="hwform" data-fpbx-delete="config.php?display=directdid&action=delete&id=<?php echo $id?>">
<input type="hidden" name='action' value="<?php echo $id?'edit':'add' ?>">

<!--NAME-->
<div class="element-container">
	<div class="row">
		<div class="form-group">
			<div class="col-md-3">
				<label class="control-label" for="name"><?php echo _("LABEL") ?></label>
				<i class="fa fa-question-circle fpbx-help-icon" data-for="name"></i>
			</div>
			<div class="col-md-9">
				<input type="text" class="form-control" id="name" name="name" value="">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="name-help" class="help-block fpbx-help-block"><?php echo _("Help Text")?></span>
		</div>
	</div>
</div>
<!--END NAME-->

</form>