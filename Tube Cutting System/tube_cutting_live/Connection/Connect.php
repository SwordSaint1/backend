<?php 
	$username = "FSIB";
	$password = "FSIB";
	$database = "172.25.116.61:1521/FSIB";
	$conn_oracle = oci_connect($username, $password, $database);
	if (!$conn_oracle) {
	   $m = oci_error();
	   echo $m['message'], "\n";
	   exit;
	}
	else {
		$array = oci_parse($conn_oracle, "SELECT C_LOCCOD, C_SYKBSYCOD, C_BHNSZICOD, L_KNBNUM, C_BHNSZINAM, C_DSNSIZ, C_DSNJIIRO, C_DSNSTRIPE, C_TKSSENCOD, L_MINLOTSUU, C_HRIKBN, C_LINENUM, C_ERRSIG, C_PIKCHKSIG, C_SISKSNUSER, TO_CHAR(DT_KSNHIZ, 'YYYY-MM-DD HH:mi:ss') AS DT_KSNHIZ, ROWSPEAD, KANBAN_READ FROM FSIB.T_ZAIKNBHRIIPTZAN_RUISEKI WHERE DT_KSNHIZ > to_date('2019-09-01 00:00:00', 'YYYY-MM-DD HH24:mi:ss')");
		oci_execute($array);
		echo"<table cols=5 border=1>
		<tr>
		 <th>C_LOCCOD</th>
		 <th>C_SYKBSYCOD</th>
		 <th>C_BHNSZICOD</th>
		 <th>L_KNBNUM</th>
		 <th>C_BHNSZINAM</th>
		 <th>C_DSNSIZ</th>
		 <th>C_DSNJIIRO</th>
		 <th>C_DSNSTRIPE</th>
		 <th>C_TKSSENCOD</th>
		 <th>L_MINLOTSUU</th>
		 <th>C_HRIKBN</th>
		 <th>C_LINENUM</th>
		 <th>C_ERRSIG</th>
		 <th>C_PIKCHKSIG</th>
		 <th>C_SISKSNUSER</th>
		 <th>DT_KSNHIZ</th>
		 <th>ROWSPEAD</th>
		 <th>KANBAN_READ</th>
		 </tr>";
		while($row=oci_fetch_array($array)){
		$C_LOCCOD = $row['C_LOCCOD'];
		$C_SYKBSYCOD = $row['C_SYKBSYCOD'];
		$C_BHNSZICOD = $row['C_BHNSZICOD'];
		$L_KNBNUM = $row['L_KNBNUM'];
		$C_BHNSZINAM = $row['C_BHNSZINAM'];
		$C_DSNSIZ = $row['C_DSNSIZ'];
		$C_DSNJIIRO = $row['C_DSNJIIRO'];
		$C_DSNSTRIPE = $row['C_DSNSTRIPE'];
		$C_TKSSENCOD = $row['C_TKSSENCOD'];
		$L_MINLOTSUU = $row['L_MINLOTSUU'];
		$C_HRIKBN = $row['C_HRIKBN'];
		$C_LINENUM = $row['C_LINENUM'];
		$C_ERRSIG = $row['C_ERRSIG'];
		$C_PIKCHKSIG = $row['C_PIKCHKSIG'];
		$C_SISKSNUSER = $row['C_SISKSNUSER'];
		$DT_KSNHIZ = $row['DT_KSNHIZ'];
		$ROWSPEAD = $row['ROWSPEAD'];
		$KANBAN_READ = $row['KANBAN_READ'];
		echo'<tr>
			<td>'.$C_LOCCOD.'</td><td>'.$C_SYKBSYCOD.'</td><td>'.$C_BHNSZICOD.'</td><td>'.$L_KNBNUM.'</td><td>'.$C_BHNSZINAM.'</td><td>'.$C_DSNSIZ.'</td>
			<td>'.$C_DSNJIIRO.'</td><td>'.$C_DSNSTRIPE.'</td><td>'.$C_TKSSENCOD.'</td><td>'.$L_MINLOTSUU.'</td><td>'.$C_HRIKBN.'</td><td>'.$C_LINENUM.'</td>
			<td>'.$C_ERRSIG.'</td><td>'.$C_PIKCHKSIG.'</td><td>'.$C_SISKSNUSER.'</td><td>'.$DT_KSNHIZ.'</td><td>'.$ROWSPEAD.'</td><td><input type="text" value="'.$row['KANBAN_READ'].'"></td>
			</tr>';
		}
		echo'</table>';
	}
	oci_close($conn_oracle);
 ?>