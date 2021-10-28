<?php
    error_reporting(0);
    $previousURL = $_SERVER['HTTP_REFERER'];
    include 'Connection/ConnectSqlsrv.php';
    include 'Connection/ConnectOracle.php';

    if(isset($_POST['upload'])){
        $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
            if(is_uploaded_file($_FILES['file']['tmp_name'])){
                //READ FILE
                $csvFile = fopen($_FILES['file']['tmp_name'],'r');
                // SKIP FIRST LINE
                fgetcsv($csvFile);
                // PARSE
                $error = 0;
                while(($line = fgetcsv($csvFile)) !== false){
                    $qrcode = $line[0];
                    $qrcode = ltrim($qrcode);
                    $scooter_station = $line[1];
                    $line_number = substr($qrcode,37,10);
                    $partscode = substr($qrcode,13,10);
                    $partscode =  trim($partscode);
                    // $line_number = $line[2];
                    // $partscode = trim($line[3]);
                    // $partsname = $line[4];
                    // $supplier_name = $line[5];
                    // $stock_address = $line[6];
                    // $qty = $line[7];
                    $kanban_number = substr($qrcode,33,4);
                    $date_now = date('Y-m-d');
                    
                    // CHECK IF BLANK DATA
                    if($line[0] == '' || $line[1] == '' ){
                        // IF BLANK DETECTED ERROR += 1
                        $error = $error + 1;
                    }else{

                        $get_fsib = oci_parse($conn_oracle,"
                                                        
                            SELECT C_BHNSZICOD AS PARTSCODE, C_BHNSZINAM AS PARTSNAME,C_DSNSIZ AS WIRESIZE,C_DSNJIIRO AS GROUNDCOLOR,C_DSNSTRIPE AS STRIPECOLOR,C_KNYSAKBHNNAM AS SUPPLIER_NAME,NVL(C_BANTICODE,'No Data') AS C_BANTICODE,L_MINLOTSUU AS QUANTITY,C_KNYSAKBHNNAM 
                                    FROM(SELECT C_BHNSZICOD, C_BHNSZINAM, C_DSNSIZ, C_DSNJIIRO, C_DSNSTRIPE,C_TKSSENCOD,L_MINLOTSUU,C_KNYSAKCOD,C_BANTICODE,C_KNYSAKBHNNAM 
                                        FROM (SELECT A.C_BHNSZICOD, A.C_BHNSZINAM, A.C_DSNSIZ, A.C_DSNJIIRO, A.C_DSNSTRIPE,A.C_TKSSENCOD,C.L_MINLOTSUU,A.C_KNYSAKCOD,B.C_BANTICODE,A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD,C.C_KNYSAKBHNNAM ,
                                        RANK() OVER(PARTITION BY A.C_BHNSZICOD ORDER BY A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD,B.C_BANTICODE) AS RANKING 
                                        FROM T_ZAIZIKMSI A LEFT JOIN M_BANTI B ON A.C_BHNSZICOD = B.C_BANTIBIKOU LEFT OUTER JOIN M_ZAIBHNSZIMST C ON A.C_BHNSZICOD = C.C_BHNSZICOD AND A.C_KNYSAKCOD = C.C_KNYSAKCOD 
                                        WHERE NVL(A.C_ZAKSTATUS,'00') = '00' AND NVL(B.C_BANTIKUBUN,'1') = '1' AND NVL(B.C_HIKIATEFLAG,'1') = '1' AND TO_CHAR(NVL(B.DT_STARTYMD,SYSDATE),'YYYY/MM/DD') <= TO_CHAR(SYSDATE,'YYYY/MM/DD') AND TO_CHAR(NVL(B.DT_ENDYMD,SYSDATE),'YYYY/MM/DD') >= TO_CHAR(SYSDATE,'YYYY/MM/DD') 
                                        AND A.C_CNTFLG = '0' AND A.C_PLTFLG = '0' AND A.C_BNTFLG = '1' AND A.C_LOCCOD LIKE '1457' 
                                        ORDER BY A.C_LOCCOD, A.C_BHNSZICOD, A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD) WHERE RANKING = 1
                                        UNION ALL SELECT C_BHNSZICOD,C_BHNSZINAM,C_DSNSIZ,C_DSNJIIRO,C_DSNSTRIPE,C_TKSSENCOD,L_MINLOTSUU,C_KNYSAKCOD,BB.C_BANTICODE,C_KNYSAKBHNNAM
                                        FROM(SELECT C_BHNSZICOD,C_BHNSZINAM,C_DSNSIZ,C_DSNJIIRO,C_DSNSTRIPE,C_TKSSENCOD,L_MINLOTSUU,C_KNYSAKCOD,NULL AS C_BANTICODE,C_KNYSAKBHNNAM
                                            FROM (
                                                SELECT A.C_BHNSZICOD,A.C_BHNSZINAM,A.C_DSNSIZ,A.C_DSNJIIRO,A.C_DSNSTRIPE,A.C_TKSSENCOD,A.L_MINLOTSUU,A.C_KNYSAKCOD,NULL AS C_BANTICODE,A.C_KNYSAKBHNNAM,RANK() OVER(PARTITION BY A.C_BHNSZICOD ORDER BY A.C_KNYSAKCOD) AS RANKING 
                                                FROM M_ZAIBHNSZIMST A WHERE NOT EXISTS(SELECT 1 FROM (SELECT C_BHNSZICOD, C_BHNSZINAM, C_DSNSIZ, C_DSNJIIRO, C_DSNSTRIPE,C_TKSSENCOD,L_MINLOTSUU,C_KNYSAKCOD,C_BANTICODE,C_KNYSAKBHNNAM 
                                                FROM (SELECT A.C_BHNSZICOD, A.C_BHNSZINAM, A.C_DSNSIZ, A.C_DSNJIIRO,A.C_DSNSTRIPE,A.C_TKSSENCOD,A.L_MINLOTSUU,A.C_KNYSAKCOD,B.C_BANTICODE,A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD,C.C_KNYSAKBHNNAM ,
                                                RANK() OVER(PARTITION BY A.C_BHNSZICOD ORDER BY A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD,B.C_BANTICODE) AS RANKING 
                                                FROM T_ZAIZIKMSI A LEFT JOIN M_BANTI B ON A.C_BHNSZICOD = B.C_BANTIBIKOU LEFT OUTER JOIN M_ZAIBHNSZIMST C ON A.C_BHNSZICOD = C.C_BHNSZICOD AND A.C_KNYSAKCOD = C.C_KNYSAKCOD 
                                                WHERE NVL(A.C_ZAKSTATUS,'00') = '00' AND NVL(B.C_BANTIKUBUN,'1') = '1' AND NVL(B.C_HIKIATEFLAG,'1') = '1' AND TO_CHAR(NVL(B.DT_STARTYMD,SYSDATE),'YYYY/MM/DD') <= TO_CHAR(SYSDATE,'YYYY/MM/DD') AND TO_CHAR(NVL(B.DT_ENDYMD,SYSDATE),'YYYY/MM/DD') >= TO_CHAR(SYSDATE,'YYYY/MM/DD') 
                                                AND A.C_CNTFLG = '0' AND A.C_PLTFLG = '0' AND A.C_BNTFLG = '1' AND A.C_LOCCOD = '1457' ORDER BY A.C_LOCCOD, A.C_BHNSZICOD, A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD) WHERE RANKING = 1) B WHERE A.C_BHNSZICOD = B.C_BHNSZICOD)
                                            ) WHERE RANKING = 1
                                        ) AA LEFT OUTER JOIN M_BANTI BB ON AA.C_BHNSZICOD = BB.C_BANTIBIKOU WHERE AA.C_BHNSZICOD IS NOT NULL
                                    )
                                    WHERE C_BHNSZICOD = '$partscode'");
                        oci_execute($get_fsib);
                        while($r = oci_fetch_assoc($get_fsib)){
                            $partsname = $r['PARTSNAME'];
                            $supplier_name = $r['SUPPLIER_NAME'];
                            $stock_address = $r['C_BANTICODE'];
                            $qty = $r['QUANTITY'];
                            $wire_size = $r['WIRESIZE'];
                            $ground_color = $r['GROUNDCOLOR'];
                            $stripe_color = $r['STRIPECOLOR'];
                            if($stripe_color != ""){
                                $stripe_color = ' / '.$stripe_color;
                            }else{
                                $stripe_color = $stripe_color;
                            }
                            $partsname = $partsname.' '.$wire_size.' '.$ground_color.' '.$stripe_color;
                        }

                    // CHECK DATA
                    $prevQuery = "SELECT id FROM mm_masterlist WHERE partscode = '$partscode' AND kanban_number = '$kanban_number' AND kanban_qrcode LIKE '$qrcode%'";
                    $stmt = sqlsrv_query($conn_sqlsrv,$prevQuery);
                    $row = sqlsrv_has_rows($stmt);
                    if($row === true){
                        while($rowData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
                            $concern = $rowData['id'];
                        } 
                         // UPDATE THE RECORD
                            $update = "UPDATE mm_masterlist SET station = ?, line_number = ?, partsname = ?, suppliers_name = ?, stock_address = ?, date_updated = ? WHERE id = ? ";
                            $update_param = array($scooter_station, $line_number, $partsname, $supplier_name, $stock_address, $date_now, $concern);
                            $stmt1 = sqlsrv_query($conn_sqlsrv,$update,$update_param);
                            if($stmt1 == true){
                                // echo 'update';
                            }else{
                                // echo 'error';
                                $error = $error + 1;
                                die(print_r(sqlsrv_errors(),true));
                            }
                    }
                    // IF NOT EXIST INSERT NEW RECORD
                    else{
                        $insertDataQuery = "INSERT INTO mm_masterlist (kanban_qrcode, station, kanban_number, line_number, partscode, partsname, suppliers_name, stock_address, quantity, uploader, date_uploaded, date_updated) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
                        $insertParam = array(ltrim($qrcode), $scooter_station, $kanban_number,$line_number, $partscode, $partsname, $supplier_name, $stock_address, $qty, $username_session, $date_now, $date_now);
                        $stmt2 = sqlsrv_query($conn_sqlsrv,$insertDataQuery,$insertParam);
                        if($stmt2 === FALSE){
                            die(print_r(sqlsrv_errors(),true));
                            $error = $error + 1;
                        }else{
                            // SUCCESS
                        }
                        sqlsrv_free_stmt($stmt1);
                        sqlsrv_free_stmt($stmt2);
                        // sqlsrv_close($conn_sqlsrv);
                    }
                
                    }
                    sqlsrv_free_stmt($stmt);
                }
                 sqlsrv_close($conn_sqlsrv);
                fclose($csvFile);
               if($error == 0){
                    echo '<script>
                    var x = confirm("SUCCESS! # OF ERRORS '.$error.' ");
                    if(x == true){
                       location.replace("'.$previousURL.'");
                    }else{
                       location.replace("'.$previousURL.'");
                    }
                </script>'; 
               }else{
                    echo '<script>
                    var x = confirm("WITH ERROR! # OF ERRORS '.$error.' ");
                    if(x == true){
                       location.replace("'.$previousURL.'");
                    }else{
                        location.replace("'.$previousURL.'");
                    }
                </script>'; 
               }
            }else{
                echo '<script>
                        var x = confirm("CSV FILE NOT UPLOADED! # OF ERRORS '.$error.' ");
                        if(x == true){
                            location.replace("'.$previousURL.'");
                        }else{
                           location.replace("'.$previousURL.'");
                        }
                    </script>';
            }
        }else{
            echo '<script>
                        var x = confirm("INVALID FILE FORMAT! # OF ERRORS '.$error.' ");
                        if(x == true){
                            location.replace("'.$previousURL.'");
                        }else{
                           location.replace("'.$previousURL.'");

                        }
                    </script>';
        }
        
    }

    // KILL CONNECTION

?>
