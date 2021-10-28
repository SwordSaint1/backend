<!DOCTYPE html>
<html>
<head>
	<title>Convert text to excel</title>
</head>
<?php include 'src/link.php';?>
<body>



<div class="card" style="width: 450px;margin-top: 2%;margin-left: 35%;">
	<div class="container">
	 <form method="POST" action="read.php" enctype="multipart/form-data">
	      <div class="form-group" style="width: 350px;">
		      <br><legend>Text file to Excel file Converter</legend>
		      	<br>
		      <input type="file" id="file" name="file" class="form-control">
		      </div>
		      <div class="form-group">
		      <button type="submit" id="upload" name="Submit" class="btn btn-btn btn-primary"><i class="fas fa-file-csv"></i> Convert</button>
	      </div>
      </form>
      </div>
</div>
<br><br><br>
 <?php include 'src/footer.php';?>

</body>
</html>