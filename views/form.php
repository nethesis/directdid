<!--
#
#    Copyright (C) 2018 Nethesis S.r.l.
#    http://www.nethesis.it - support@nethesis.it
#
#    This file is part of DirectDID FreePBX module.
#
#    DirectDID module is free software: you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation, either version 3 of the License, or any 
#    later version.
#
#    DirectDID module is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with DirectDID module.  If not, see <http://www.gnu.org/licenses/>.
#
-->

<form action="" method="post" class="fpbx-submit" id="hwform" name="hwform" data-fpbx-delete="config.php?display=directdid&action=delete&id=<?php echo $id?>">
<input type="hidden" name='action' value="<?php echo $id?'edit':'save' ?>">

<?php $config = directdid_get_details(); ?>

<!--NAME-->
<div class="element-container">
    <!--TIMEOUT-->
    <div class="row">
        <div class="form-group">
            <div class="col-md-4">
                <label class="control-label" for="timeout"><?php echo _("Timeout") ?></label>
                <i class="fa fa-question-circle fpbx-help-icon" data-for="timeout"></i>
            </div>
            <div class="col-md-7">
                <input type="number" min="5" max="30" class="form-control" id="timeout" name="timeout" value="<?php echo isset($config['timeout'])?$config['timeout']:10 ?>">
            </div>
        </div>    
    </div>
    <div class="row">
        <div class="col-md-12">
            <span id="timeout-help" class="help-block fpbx-help-block"><?php echo _("Ringing timeout before going to timeout destination. Minimum value: 5 Maximum value: 30")?></span>
        </div>
    </div>
    <!--TIMEOUT END-->
<?php
// implementation of module hook
$module_hook = \moduleHook::create();
echo $module_hook->hookHtml;
?>

    <!--TIMEOUT DESTINATION-->
    <div class="row">
        <div class="form-group">
            <div class="col-md-4">
                <label class="control-label" for="timeout_destination"><?php echo _("Timeout Destination") ?></label>
                <i class="fa fa-question-circle fpbx-help-icon" data-for="timeout_destination"></i>
            </div>
            <div class="col-md-7">
                <?php echo drawselects($config['timeout_destination'],'timeout_destination',false,false)?>
            </div>
        </div>    
    </div>
    <div class="row">
        <div class="col-md-12">
            <span id="timeout_destination-help" class="help-block fpbx-help-block"><?php echo _("Destination when timeout is reached")?></span>
        </div>
    </div>
    <!--END TIMEOUT DESTINATION-->
    <!--BUSY DESTINATION-->
    <div class="row">
        <div class="form-group">
            <div class="col-md-4">
                <label class="control-label" for="busy_destination"><?php echo _("Busy Destination") ?></label>
                <i class="fa fa-question-circle fpbx-help-icon" data-for="busy_destination"></i>
            </div>
            <div class="col-md-7">
                <?php echo drawselects($config['busy_destination'],'busy_destination',false,false)?>
            </div>
        </div>    
    </div>
    <div class="row">
        <div class="col-md-12">
            <span id="busy_destination-help" class="help-block fpbx-help-block"><?php echo _("Destination if user is busy")?></span>
        </div>
    </div>
    <!--END BUSY DESTINATION-->
    <!--UNAVAILABLE DESTINATION-->
    <div class="row">
        <div class="form-group">
            <div class="col-md-4">
                <label class="control-label" for="unavailable_destination"><?php echo _("Unavailable Destination") ?></label>
                <i class="fa fa-question-circle fpbx-help-icon" data-for="unavailable_destination"></i>
            </div>
            <div class="col-md-7">
                <?php echo drawselects($config['unavailable_destination'],'unavailable_destination',false,false)?>
            </div>
        </div>    
    </div>
    <div class="row">
        <div class="col-md-12">
            <span id="unavailable_destination-help" class="help-block fpbx-help-block"><?php echo _("Destination if user is not reachable")?></span>
        </div>
    </div>
    <!--END UNAVAILABLE DESTINATION-->
    <!--Alert Info-->
    <div class="row">
        <div class="form-group">
            <div class="col-md-4">
                <label class="control-label" for="alertinfo"><?php echo _("Alert Info") ?></label>
                <i class="fa fa-question-circle fpbx-help-icon" data-for="alertinfo"></i>
            </div>
            <div class="col-md-7">
                <?php echo FreePBX::View()->alertInfoDrawSelect("alertinfo",(!empty($config['alertinfo'])?$config['alertinfo']:''));?>
            </div>
        </div>
        <div class="col-md-12">
            <span id="alertinfo-help" class="help-block fpbx-help-block"><?php echo _("ALERT_INFO can be used for distinctive ring with SIP devices.")?></span>
        </div>
    </div>
    <!--END Alert Info-->
    <!--CID Name Prefix-->
    <div class="row">
        <div class="form-group">
            <div class="col-md-4">
                <label class="control-label" for="cidnameprefix"><?php echo _("CID Name Prefix") ?></label>
                <i class="fa fa-question-circle fpbx-help-icon" data-for="cidnameprefix"></i>
            </div>
            <div class="col-md-7">
                <input type="text" class="form-control" id="cidnameprefix" name="cidnameprefix" value="<?php  echo $config['cidnameprefix'] ?>">
            </div>
        </div>
        <div class="col-md-12">
            <span id="cidnameprefix-help" class="help-block fpbx-help-block"><?php echo _('You can optionally prefix the CallerID name when ringing extensions in this group. ie: If you prefix with "Sales:", a call from John Doe would display as "Sales:John Doe" on the extensions that ring.')?></span>
        </div>
    </div>
    <!--END CID Name Prefix-->
</form>
