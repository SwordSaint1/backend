<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Ip Checker</title>
	<!-- Title Logo -->
	<!-- Font Awesome -->
	<!--link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"-->
	<link rel="stylesheet" href="Fontawesome/fontawesome-free-5.9.0-web/css/all.css">
	<!-- Bootstrap core CSS -->
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<!-- Material Design Bootstrap -->
	<link href="../css/mdb.min.css" rel="stylesheet">
	<!-- Your custom styles (optional) -->
	<link href="../css/style.css" rel="stylesheet">
	<!-- My CSS -->
	<link href="../mycss/style1.css" rel="stylesheet">
	<link rel="shortcut icon" href="../Icon/favicon.ico" type="image/ico">
	<link href="../Icon/favicon.png" rel="icon">
</head>
<body class="bg">
	<div class="text-center w-auto h-100 mh-100 card_opa" style="margin-top:200px;">
		<label class="text-center h1 text-danger" style="text-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);"><i class="fas fa-exclamation-triangle"></i></label><br>
		<label class="text-center h1 text-danger"><?php echo $_SERVER['REMOTE_ADDR'];?></label><br>
		<label class="text-center h2 text-danger">Your Ip Address...</label>
	</div>
<!-- JQuery -->
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="../js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="../js/mdb.min.js"></script>
<!-- Realtime Access JavaScript -->
</body>
</html>
