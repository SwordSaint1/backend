<?php    

include 'db/config.php';


/*
 * PHP QR Code encoder
 *
 * Exemplatory usage
 *
 * PHP QR Code is distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */
   
    
    // //config form
    // echo '<form action="qrcode.php" method="post">
    //     Data:&nbsp;<input name="data" value="'.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'PHP QR Code :)').'" />&nbsp;
    //     ECC:&nbsp;<select name="level">
    //         <option value="L">L - smallest</option>
    //         <option value="M">M</option>
    //         <option value="Q">Q</option>
    //         <option value="H">H - best</option>
    //     </select>&nbsp;
    //     Size:&nbsp;<select name="size" class="try">';
        
    // for($i=1;$i<=10;$i++)
    //     echo '<option value="'.$i.'"'.(($matrixPointSize==$i)?' selected':'').'>'.$i.'</option>';
        
    // echo '</select>&nbsp;
    //     <input type="submit" value="GENERATE"></form><hr/>';
        
    // benchmark
   // QRtools::timeBenchmark();    

    
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>QR CODE</title>

    </head>
    <body>
    

    <table border="1">
        <th></th>
        <th>ID Number</th>
        <th>Name</th>
    <tr>
    
    <?php
    $array = array();
    $sql = "SELECT * FROM main";
    $query = $db->query($sql);
    while ($result = $query->fetch_assoc()) 
    {
        echo "<td> </td>";
        echo "<td>".$result['itemCode']."</td>";
        echo "<td>".$result['itName']."</td>";
        $array[] = $result['itemCode'].":".$result['itName'];
        echo "<tr>";
    }

    ?>


    </table>
<br><br>
<script src="jquery/jquery-3.2.1.js"></script>
<button id="btnSubmit">Generate</button>

<script type="text/javascript">
	btnSubmit();
    function btnSubmit(){
        var array = <?php echo json_encode($array);?>;
        window.location.href = "qrcode.php?data="+array;

    };


</script>


    </body>
    </html>