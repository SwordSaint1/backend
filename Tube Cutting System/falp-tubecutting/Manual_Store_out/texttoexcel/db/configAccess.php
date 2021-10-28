<?php
// $dbName = $_SERVER["DOCUMENT_ROOT"] . "C:納期管理2008.mdb";
// if (!file_exists($dbName)) {
//     die("Could not find database file.");
// }
// $db = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$dbName; Uid=; Pwd=;");


$accessCon=odbc_connect('modelline2','','');


if (!$accessCon)
 {
 	echo "connection lost";
 }


?>