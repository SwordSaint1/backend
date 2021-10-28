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
		$array = oci_parse($conn_oracle, "SELECT C_LOCCOD, C_BNTCOD, C_NYKLBLBARCOD, DT_ZAIKOTRKHIZ, C_BHNBRI, C_BHNSZINAM, C_DSNSIZ, 
		C_DSNJIIRO, C_DSNSTRIPE, C_TKSSENCOD, L_BHNKOPSUU, C_BHNKOPTNI, L_MINLOTSUU, C_MINLOTTNI, C_KNYSAKCOD,
		L_BHNKNYTNK, C_TRHTUKCOD, L_HYKTNK, C_HYKTUKCOD, L_HRISUU, DT_SYUKKOHIZ, C_HSUSIG, C_HRIKBN, C_TYOTATKBN, C_ZAISYKKETKBN, 
		C_MKRCOD, C_KHNHIN, C_SYNHIN, C_LOTNUM, C_LOTSEQNUM, L_KNBNUM, C_HNSSIG, C_ERRSIG, C_SYKBSYCOD, C_LINENUM, C_ASSYGR, C_AKASIG,
		C_TRKUSER, TO_CHAR(DT_DATTRKYMD, 'YYYY-MM-DD HH:mi:ss') AS DT_DATTRKYMD, C_TYSHRIBRI, C_BUMONCD, C_CNTFLG, C_BNTFLG, C_CNTNUM FROM FSIB.T_ZAISYKRSK WHERE ROWNUM <= 1000 ORDER BY DT_DATTRKYMD DESC");
		oci_execute($array);
		echo"<table cols=5 border=1>
		<tr>
		 <th>C_LOCCOD</th>
		 <th>C_BNTCOD</th>
		 <th>C_NYKLBLBARCOD</th>
		 <th>DT_ZAIKOTRKHIZ</th>
		 <th>C_BHNBRI</th>
		 <th>C_BHNSZINAM</th>
		 <th>C_DSNSIZ</th>
		 <th>C_DSNJIIRO</th>
		 <th>C_DSNSTRIPE</th>
		 <th>C_TKSSENCOD</th>
		 <th>L_BHNKOPSUU</th>
		 <th>C_BHNKOPTNI</th>
		 <th>L_MINLOTSUU</th>
		 <th>C_MINLOTTNI</th>
		 <th>C_KNYSAKCOD</th>
		 <th>L_BHNKNYTNK</th>
		 <th>C_TRHTUKCOD</th>
		 <th>L_HYKTNK</th>
		 <th>C_HYKTUKCOD</th>
		 <th>L_HRISUU</th>
		 <th>DT_SYUKKOHIZ</th>
		 <th>C_HSUSIG</th>
		 <th>C_HRIKBN</th>
		 <th>C_TYOTATKBN</th>
		 <th>C_ZAISYKKETKBN</th>
		 <th>C_MKRCOD</th>
		 <th>C_KHNHIN</th>
		 <th>C_SYNHIN</th>
		 <th>C_LOTNUM</th>
		 <th>C_LOTSEQNUM</th>
		 <th>L_KNBNUM</th>
		 <th>C_HNSSIG</th>
		 <th>C_ERRSIG</th>
		 <th>C_SYKBSYCOD</th>
		 <th>C_LINENUM</th>
		 <th>C_ASSYGR</th>
		 <th>C_AKASIG</th>
		 <th>C_TRKUSER</th>
		 <th>DT_DATTRKYMD</th>
		 <th>C_TYSHRIBRI</th>
		 <th>C_BUMONCD</th>
		 <th>C_CNTFLG</th>
		 <th>C_BNTFLG</th>
		 <th>C_CNTNUM</th>
		 </tr>";
		while($row=oci_fetch_array($array)){
		$C_LOCCOD = $row['C_LOCCOD'];
		$C_BNTCOD = $row['C_BNTCOD'];
		$C_NYKLBLBARCOD = $row['C_NYKLBLBARCOD'];
		$DT_ZAIKOTRKHIZ = $row['DT_ZAIKOTRKHIZ'];
		$C_BHNBRI = $row['C_BHNBRI'];
		$C_BHNSZINAM = $row['C_BHNSZINAM'];
		$C_DSNSIZ = $row['C_DSNSIZ'];
		$C_DSNJIIRO = $row['C_DSNJIIRO'];
		$C_DSNSTRIPE = $row['C_DSNSTRIPE'];
		$C_TKSSENCOD = $row['C_TKSSENCOD'];
		$L_BHNKOPSUU = $row['L_BHNKOPSUU'];
		$C_BHNKOPTNI = $row['C_BHNKOPTNI'];
		$L_MINLOTSUU = $row['L_MINLOTSUU'];
		$C_MINLOTTNI = $row['C_MINLOTTNI'];
		$C_KNYSAKCOD = $row['C_KNYSAKCOD'];
		$L_BHNKNYTNK = $row['L_BHNKNYTNK'];
		$C_TRHTUKCOD = $row['C_TRHTUKCOD'];
		$L_HYKTNK = $row['L_HYKTNK'];
		$C_HYKTUKCOD = $row['C_HYKTUKCOD'];
		$L_HRISUU = $row['L_HRISUU'];
		$DT_SYUKKOHIZ = $row['DT_SYUKKOHIZ'];
		$C_HSUSIG = $row['C_HSUSIG'];
		$C_HRIKBN = $row['C_HRIKBN'];
		$C_TYOTATKBN = $row['C_TYOTATKBN'];
		$C_ZAISYKKETKBN = $row['C_ZAISYKKETKBN'];
		$C_MKRCOD = $row['C_MKRCOD'];
		$C_KHNHIN = $row['C_KHNHIN'];
		$C_SYNHIN = $row['C_SYNHIN'];
		$C_LOTNUM = $row['C_LOTNUM'];
		$C_LOTSEQNUM = $row['C_LOTSEQNUM'];
		$L_KNBNUM = $row['L_KNBNUM'];
		$C_HNSSIG = $row['C_HNSSIG'];
		$C_ERRSIG = $row['C_ERRSIG'];
		$C_SYKBSYCOD = $row['C_SYKBSYCOD'];
		$C_LINENUM = $row['C_LINENUM'];
		$C_ASSYGR = $row['C_ASSYGR'];
		$C_AKASIG = $row['C_AKASIG'];
		$C_TRKUSER = $row['C_TRKUSER'];
		$DT_DATTRKYMD = $row['DT_DATTRKYMD'];
		$C_TYSHRIBRI = $row['C_TYSHRIBRI'];
		$C_BUMONCD = $row['C_BUMONCD'];
		$C_CNTFLG = $row['C_CNTFLG'];
		$C_BNTFLG = $row['C_BNTFLG'];
		$C_CNTNUM = $row['C_CNTNUM'];
		echo'<tr>
			<td>'.$C_LOCCOD.'</td><td>'.$C_BNTCOD.'</td><td>'.$C_NYKLBLBARCOD.'</td><td>'.$DT_ZAIKOTRKHIZ.'</td><td>'.$C_BHNBRI.'</td><td>'.$C_BHNSZINAM.'</td>
			<td>'.$C_DSNSIZ.'</td><td>'.$C_DSNJIIRO.'</td><td>'.$C_DSNSTRIPE.'</td><td>'.$C_TKSSENCOD.'</td><td>'.$L_BHNKOPSUU.'</td><td>'.$C_BHNKOPTNI.'</td>
			<td>'.$L_MINLOTSUU.'</td><td>'.$C_MINLOTTNI.'</td><td>'.$C_KNYSAKCOD.'</td><td>'.$L_BHNKNYTNK.'</td><td>'.$C_TRHTUKCOD.'</td><td>'.$L_HYKTNK.'</td>
			<td>'.$C_HYKTUKCOD.'</td><td>'.$L_HRISUU.'</td><td>'.$DT_SYUKKOHIZ.'</td><td>'.$C_HSUSIG.'</td><td>'.$C_HRIKBN.'</td><td>'.$C_TYOTATKBN.'</td>
			<td>'.$C_ZAISYKKETKBN.'</td><td>'.$C_MKRCOD.'</td><td>'.$C_KHNHIN.'</td><td>'.$C_SYNHIN.'</td><td>'.$C_LOTNUM.'</td><td>'.$C_LOTSEQNUM.'</td>
			<td>'.$L_KNBNUM.'</td><td>'.$C_HNSSIG.'</td><td>'.$C_ERRSIG.'</td><td>'.$C_SYKBSYCOD.'</td><td>'.$C_LINENUM.'</td><td>'.$C_ASSYGR.'</td>
			<td>'.$C_AKASIG.'</td><td>'.$C_TRKUSER.'</td><td>'.$DT_DATTRKYMD.'</td><td>'.$C_TYSHRIBRI.'</td><td>'.$C_BUMONCD.'</td><td>'.$C_CNTFLG.'</td>
			<td>'.$C_BNTFLG.'</td><td>'.$C_CNTNUM.'</td>
			</tr>';
		}
		echo'</table>';
	}
	oci_close($conn_oracle);
 ?>