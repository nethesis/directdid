<?php

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

function directdid_destinations() {
    global $amp_conf;
    $results = core_users_list();
    if (isset($results)) {
	foreach($results as $result) {
            # show only main extensions
            if (preg_match('/^9[0-9][0-9][0-9][0-9]/',$result['0'])) continue;
	    $extens[] = array('destination' => 'directdid,'.$result['0'].',1','description' => ' '.$result['0'].' '.$result['1'], 'category' => $cat, 'id' => $cat_id);
	}
        return $extens;
    }
}

function directdid_getdestinfo() {
    global $active_modules;
    if (preg_match('/^directdid/',trim($dest))) {
        return array('description' => "DirectDID", 'edit_url' => 'config.php?display=directdid');
    }
    return false;
}

function directdid_get_config($engine){
    global $ext;
    global $asterisk_conf;
    switch($engine) {
        case "asterisk":
            $contextname = 'directdid';
            $results = core_users_list();
            $config = directdid_get_details();
            /************ Example of $config *************************************
            * $config['alertinfo'] = dghj
            * $config['cidnameprefix'] = EXTERNAL
            * $config['timeout'] => 6
            * $config['timeout_destination'] => app-blackhole,hangup,1
            **********************************************************************/
    
            foreach ($results as $result) {
                # show only main extensions
                if (preg_match('/^9[0-9][0-9][0-9][0-9]/',$result['0'])) continue;
                # add ring and stuff foreach extension
		$extension = $result['0'];
		$ext->add($contextname, $extension, '', new ext_playtones('ring'));
                $ext->add($contextname, $extension, '', new ext_progress());
                $ext->add($contextname, $extension, '', new ext_macro('user-callerid'));
                $ext->add($contextname, $extension, '', new ext_macro('blkvm-setifempty'));
                $ext->add($contextname, $extension, '', new ext_macro('prepend-cid', $config['cidnameprefix']));
                $ext->add($contextname, $extension, '', new ext_setvar('__ALERT_INFO', $config['alertinfo']));
                $ext->add($contextname, $extension, '', new ext_macro('dial',$config['timeout'].',${DIAL_OPTIONS},'.$extension));
                $ext->add($contextname, $extension, '', new ext_goto($config['timeout_destination']));
            }
        break;
    }
}

function directdid_get_details() {
    $dbh = FreePBX::Database();
    $sql = 'SELECT * FROM directdid';
    $sth = $dbh->prepare($sql);
    $sth->execute(array());
    $res = $sth->fetchAll();
    foreach ($res as $row) {
        $config[$row['keyword']] = $row['value'];
    }
    /*NethDEBUG*/ file_put_contents("/tmp/php_debug.log",__FUNCTION__.'@'.print_r(      $config      ,true)."@\n",FILE_APPEND); /*NethDEBUG*/
    return $config;
}







