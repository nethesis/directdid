<?php
out(_('Creating the database table'));
//Database
$table = 'directdid';
$dbh = \FreePBX::Database();
try {
    $sql = "CREATE TABLE IF NOT EXISTS $table(
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `didnumber` VARCHAR(60),
    `extension` VARCHAR(10) );";
    $sth = $dbh->prepare($sql);
    $result = $sth->execute();
} catch (PDOException $e) {
    $result = $e->getMessage();
}
if ($result === true) {
    out(_('Table Created'));
} else {
    out(_('Something went wrong'));
    out($result);
}
