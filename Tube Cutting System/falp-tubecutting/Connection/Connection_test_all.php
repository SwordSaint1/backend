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
	//01L1R
	else {
		$array = oci_parse($conn_oracle, "SELECT C_BHNSZICOD, C_BHNSZINAM, C_DSNSIZ, C_DSNJIIRO, C_DSNSTRIPE,C_TKSSENCOD,L_MINLOTSUU,C_KNYSAKCOD,C_KNYSAKBHNNAM,NVL(C_BANTICODE,'No Data') AS C_BANTICODE,C_KNYSAKBHNNAM 
		FROM(SELECT C_BHNSZICOD, C_BHNSZINAM, C_DSNSIZ, C_DSNJIIRO, C_DSNSTRIPE,C_TKSSENCOD,L_MINLOTSUU,C_KNYSAKCOD,C_BANTICODE,C_KNYSAKBHNNAM 
		FROM (SELECT A.C_BHNSZICOD, A.C_BHNSZINAM, A.C_DSNSIZ, A.C_DSNJIIRO, A.C_DSNSTRIPE,A.C_TKSSENCOD,A.L_MINLOTSUU,A.C_KNYSAKCOD,B.C_BANTICODE,A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD,C.C_KNYSAKBHNNAM ,
        RANK() OVER(PARTITION BY A.C_BHNSZICOD ORDER BY A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD,B.C_BANTICODE) AS RANKING 
        FROM T_ZAIZIKMSI A 
		LEFT JOIN M_BANTI B 
		ON A.C_BHNSZICOD = B.C_BANTIBIKOU 
		LEFT OUTER JOIN M_ZAIBHNSZIMST C 
		ON A.C_BHNSZICOD = C.C_BHNSZICOD 
		AND A.C_KNYSAKCOD = C.C_KNYSAKCOD 
		WHERE NVL(A.C_ZAKSTATUS,'00') = '00' 
		AND NVL(B.C_BANTIKUBUN,'1') = '1' 
		AND NVL(B.C_HIKIATEFLAG,'1') = '1' 
		AND TO_CHAR(NVL(B.DT_STARTYMD,SYSDATE),'YYYY/MM/DD') <= TO_CHAR(SYSDATE,'YYYY/MM/DD') 
		AND TO_CHAR(NVL(B.DT_ENDYMD,SYSDATE),'YYYY/MM/DD') >= TO_CHAR(SYSDATE,'YYYY/MM/DD') 
		AND A.C_CNTFLG = '0' 
		AND A.C_PLTFLG = '0' 
		AND A.C_BNTFLG = '1' 
		AND A.C_LOCCOD = '4570' 
		ORDER BY A.C_LOCCOD, A.C_BHNSZICOD, A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD) WHERE RANKING = 1
		UNION ALL SELECT C_BHNSZICOD,C_BHNSZINAM,C_DSNSIZ,C_DSNJIIRO,C_DSNSTRIPE,C_TKSSENCOD,L_MINLOTSUU,C_KNYSAKCOD,BB.C_BANTICODE,C_KNYSAKBHNNAM
		FROM(SELECT C_BHNSZICOD,C_BHNSZINAM,C_DSNSIZ,C_DSNJIIRO,C_DSNSTRIPE,C_TKSSENCOD,L_MINLOTSUU,C_KNYSAKCOD,NULL AS C_BANTICODE,C_KNYSAKBHNNAM
			FROM (
				SELECT A.C_BHNSZICOD,A.C_BHNSZINAM,A.C_DSNSIZ,A.C_DSNJIIRO,A.C_DSNSTRIPE,A.C_TKSSENCOD,A.L_MINLOTSUU,A.C_KNYSAKCOD,NULL AS C_BANTICODE,A.C_KNYSAKBHNNAM,RANK() OVER(PARTITION BY A.C_BHNSZICOD ORDER BY A.C_KNYSAKCOD) AS RANKING 
				FROM M_ZAIBHNSZIMST A WHERE NOT EXISTS(SELECT 1 FROM (SELECT C_BHNSZICOD, C_BHNSZINAM, C_DSNSIZ, C_DSNJIIRO, C_DSNSTRIPE,C_TKSSENCOD,L_MINLOTSUU,C_KNYSAKCOD,C_BANTICODE,C_KNYSAKBHNNAM 
				FROM (SELECT A.C_BHNSZICOD, A.C_BHNSZINAM, A.C_DSNSIZ, A.C_DSNJIIRO,A.C_DSNSTRIPE,A.C_TKSSENCOD,A.L_MINLOTSUU,A.C_KNYSAKCOD,B.C_BANTICODE,A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD,C.C_KNYSAKBHNNAM ,
				RANK() OVER(PARTITION BY A.C_BHNSZICOD ORDER BY A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD,B.C_BANTICODE) AS RANKING 
				FROM T_ZAIZIKMSI A 
				LEFT JOIN M_BANTI B 
				ON A.C_BHNSZICOD = B.C_BANTIBIKOU 
				LEFT OUTER JOIN M_ZAIBHNSZIMST C 
				ON A.C_BHNSZICOD = C.C_BHNSZICOD 
				AND A.C_KNYSAKCOD = C.C_KNYSAKCOD 
				WHERE NVL(A.C_ZAKSTATUS,'00') = '00' 
				AND NVL(B.C_BANTIKUBUN,'1') = '1' 
				AND NVL(B.C_HIKIATEFLAG,'1') = '1' 
				AND TO_CHAR(NVL(B.DT_STARTYMD,SYSDATE),'YYYY/MM/DD') <= TO_CHAR(SYSDATE,'YYYY/MM/DD') 
				AND TO_CHAR(NVL(B.DT_ENDYMD,SYSDATE),'YYYY/MM/DD') >= TO_CHAR(SYSDATE,'YYYY/MM/DD') 
				AND A.C_CNTFLG = '0' 
				AND A.C_PLTFLG = '0' 
				AND A.C_BNTFLG = '1' 
				AND A.C_LOCCOD = '4570' 
				ORDER BY A.C_LOCCOD, A.C_BHNSZICOD, A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD) WHERE RANKING = 1) B WHERE A.C_BHNSZICOD = B.C_BHNSZICOD)
			) WHERE RANKING = 1
		) AA LEFT OUTER JOIN M_BANTI BB ON AA.C_BHNSZICOD = BB.C_BANTIBIKOU WHERE AA.C_BHNSZICOD IS NOT NULL
	)
	");
		oci_execute($array);
		echo"<table cols=5 border=1>
		<tr>
		 <th>C_BHNSZICOD</th>
		 <th>C_BHNSZINAM</th>
		 <th>C_DSNSIZ</th>
		 <th>C_DSNJIIRO</th>
		 <th>C_DSNSTRIPE</th>
		 <th>C_TKSSENCOD</th>
		 <th>L_MINLOTSUU</th>
		 <th>C_KNYSAKCOD</th>
		 <th>C_BANTICODE</th>
		 <th>C_KNYSAKBHNNAM</th>
		 </tr>";
		while($row=oci_fetch_array($array)){
		$C_BHNSZICOD = $row['C_BHNSZICOD'];
		$C_BHNSZINAM = $row['C_BHNSZINAM'];
		$C_DSNSIZ = $row['C_DSNSIZ'];
		$C_DSNJIIRO = $row['C_DSNJIIRO'];
		$C_DSNSTRIPE = $row['C_DSNSTRIPE'];
		$C_TKSSENCOD = $row['C_TKSSENCOD'];
		$L_MINLOTSUU = $row['L_MINLOTSUU'];
		$C_KNYSAKCOD = $row['C_KNYSAKCOD'];
		$C_BANTICODE = $row['C_BANTICODE'];
		$C_KNYSAKBHNNAM = $row['C_KNYSAKBHNNAM'];
		echo'<tr>
			<td>'.$C_BHNSZICOD.'</td><td>'.$C_BHNSZINAM.'</td><td>'.$C_DSNSIZ.'</td><td>'.$C_DSNJIIRO.'</td><td>'.$C_DSNSTRIPE.'</td><td>'.$C_TKSSENCOD.'</td>
			<td>'.$L_MINLOTSUU.'</td><td>'.$C_KNYSAKCOD.'</td><td>'.$C_BANTICODE.'</td><td>'.$C_KNYSAKBHNNAM.'</td>
			</tr>';
		}
		echo'</table>';
	}
	oci_close($conn_oracle);
 ?>