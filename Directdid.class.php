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

namespace FreePBX\modules;

class Directdid implements \BMO {
        public function __construct($freepbx = null) {
                $this->freepbx = $freepbx;
                $this->db = $freepbx->Database;
        }
	public function install()
	{
	}
	public function uninstall()
	{
	}
	public function backup()
	{
	}
	public function restore($backup)
	{
	}
	public function doConfigPageInit($page) {
		$id = $_REQUEST['id']?$_REQUEST['id']:'';
		$action = $_REQUEST['action']?$_REQUEST['action']:'';
		$exampleField = $_REQUEST['example-field']?$_REQUEST['example-field']:'';
		//Handle form submissions
		switch ($action) {
                    case 'save':
                        $dbh = \FreePBX::Database();
                        # get destinations for 'timeout_destination'
                        foreach (['timeout_destination'] as $key) {
                            if (isset($_REQUEST['goto'.$key]) && isset($_REQUEST[$_REQUEST['goto'.$key].$key])) {
                                $destination = $_REQUEST[$_REQUEST['goto'.$key].$key];
                            } else {
                                $destination = '';
                            }
                            $sql = "REPLACE INTO directdid (keyword,value) VALUES (?,?)";
                            $stmt = $dbh->prepare($sql);
                            $stmt->execute(array($key,$destination));
                        }

                        foreach (['timeout','alertinfo','cidnameprefix'] as $key) {
                            $sql = "REPLACE INTO directdid (keyword,value) VALUES (?,?)";
                            $stmt = $dbh->prepare($sql);
                            $stmt->execute(array($key,$_REQUEST[$key]));
                        }
                        needreload();
                    break;
		}
	}

	public function getActionBar($request)
	{
		$buttons = array();
		switch ($request['display']) {
		case 'directdid':
			$buttons = array(
				'submit' => array(
					'name' => 'submit',
					'id' => 'submit',
					'value' => _('Submit')
				)
			);
			if (empty($request['extdisplay'])) {
				unset($buttons['delete']);
			}
			break;
		}
		return $buttons;
	}

	public function showPage()
	{
	    $subhead = _('Direct DID Options');
	    $content = load_view(__DIR__.'/views/form.php');
	    echo load_view(__DIR__.'/views/default.php', array('subhead' => $subhead, 'content' => $content));
	}

}
