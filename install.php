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

out(_('Creating the database table'));
//Database
$dbh = \FreePBX::Database();
try {
    $sql = "CREATE TABLE IF NOT EXISTS directdid(
    `keyword` VARCHAR(80) NOT NULL UNIQUE,
    `value` VARCHAR(200));";
    $sth = $dbh->prepare($sql);
    $result = $sth->execute();

    # Default values
    $sqls = array();
    $sqls[] = "INSERT IGNORE INTO directdid (`keyword`,`value`) VALUES ('timeout','10')";
    $sqls[] = "INSERT IGNORE INTO directdid (`keyword`,`value`) VALUES ('timeout_destination','app-blackhole,hangup,1')";
    $sqls[] = "INSERT IGNORE INTO directdid (`keyword`,`value`) VALUES ('busy_destination','app-blackhole,hangup,1')";
    $sqls[] = "INSERT IGNORE INTO directdid (`keyword`,`value`) VALUES ('unavailable_destination','app-blackhole,hangup,1')";
    $sqls[] = "INSERT IGNORE INTO directdid (`keyword`,`value`) VALUES ('cidnameprefix','EXTERNAL')";
    foreach ($sqls as $sql) {
        $sth = $dbh->prepare($sql);
        $result = $sth->execute();
    }
} catch (PDOException $e) {
    $result = $e->getMessage();
}
if ($result === true) {
    out(_('Table Created'));
} else {
    out(_('Something went wrong'));
    out($result);
}
