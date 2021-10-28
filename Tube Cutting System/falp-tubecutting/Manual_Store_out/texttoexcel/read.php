

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<table border="1">
<?php


// include 'M_HINBAN.TXT';



 $file_name = basename($_FILES['file']['name']);
 $file = $_FILES['file']['name'];
$filename = $file_name.".xls";
    // header("Content-Type: application/vnd.ms-excel");
    header('Content-Type: text/csv; charset=utf-8');  
    header("Content-Disposition: ; filename=\"$filename\"");


 $file_lines = file($file_name);
foreach ($file_lines as $line) {
	
	 $data = preg_replace('/[\t]+/', "<->", $line); 

  $out = str_replace('"', '', $data);  	
   	$try = explode("<->", $out);
  	
  	$count = count($try);
  	 $count;
  	

  	for ($i=0; $i <$count ; $i++) { 
  		


  		echo "<td>".$try[$i]."</td>";
  	}
  	echo "<tr>";

}


//header('location:index.php');
?>

</table>



</body>
</html>


