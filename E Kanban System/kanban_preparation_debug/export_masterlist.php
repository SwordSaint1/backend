<?php
require_once 'Connection/ConnectSqlsrv.php';

$scooter = $_GET['scooter_station'];
$line = $_GET['line'];
$partscode = $_GET['partscode'];
$datenow = date('Y-m-d');
$filename = "E-Kanban Masterlist-".$datenow.".xls";
header("Content-Type: application/vnd.ms-excel");
header('Content-Type: text/csv; charset=utf-8');  
header("Content-Disposition: ; filename=\"$filename\"");
echo'
<html lang="en">
<body>
<table border="1">
<thead>
	<tr>
		<td class="h6">QR CODE</td>
		<td class="h6">STATION</td> 
		<td class="h6">LINE#</td>
		<td class="h6">PARTSCODE</td>
		<td class="h6">PARTSNAME</td>
		<td class="h6">QUANTITY</td>
		<td class="h6">SUPPLIER NAME</td>
		<td class="h6">STOCK ADDRESS</td>
	</tr>
</thead>
';


 $sql = "SELECT *FROM mm_masterlist WHERE  station LIKE '$scooter%' AND line_number LIKE '$line%' AND partscode LIKE '$partscode%'";
 $stmt = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_has_rows($stmt);
    if ($row === true){
            while($rows = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
            	echo'
 				<tr>
                    <td>'.$rows['kanban_qrcode'].'</td>
                    <td>'.$rows['station'].'</td>
                    <td>'.$rows['line_number'].'</td>
                    <td>'.$rows['partscode'].'</td>
                    <td>'.$rows['partsname'].'</td>
                    <td>'.$rows['quantity'].'</td>
                    <td>'.$rows['suppliers_name'].'</td>
                    <td>'.$rows['stock_address'].'</td>
 				</tr>
 			';
            }
        }
    
echo'
</table>
</body>
</html>
';

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn_sqlsrv);
?>