<?php
require 'class/DB.class.php';

$db = new DB();

$sql = 'SELECT * FROM schedules WHERE sc_date>=NOW() ORDER BY sc_date ASC LIMIT 10';
$recode = $db->queryPost($sql, array());
$row = $db->dbFetch($recode);
print_r($row)
 ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>

    </body>
</html>
