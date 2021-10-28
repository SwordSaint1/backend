<?php
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
if (isset($_GET['data'])) {
	include '../Connection/Connect_sql.php';
    $data = $_GET['data'];
    $datas = explode(',', $data);
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
    include "qrlib.php";   
   $count = count($datas);
   for ($i=0; $i < $count; $i++) { 
    # code...
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
		$filename = $PNG_TEMP_DIR.'test'.$i.'.png';
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    // if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
    //     $errorCorrectionLevel = $_REQUEST['level'];    
    $matrixPointSize = 16;
    // if (isset($_REQUEST['size']))
    //     $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);
    if (isset($datas[$i])) { 
        //it's very important!
        if (trim($datas[$i]) == '')
            die('data cannot be empty! <a href="?">back</a>');    
        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($datas[$i].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($datas[$i], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
    } else {    
        //default data
        echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);     
    }    
    $d = explode(',', $datas[$i]);
    //display generated file
    echo $PNG_WEB_DIR.basename($filename) ;  
    //config form
}
    }
    ?>


  