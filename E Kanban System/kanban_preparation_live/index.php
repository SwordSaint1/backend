<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>EKanban MM</title>
	<!-- Title Logo -->
	<!-- Font Awesome -->
	<!--link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"-->
	<link rel="stylesheet" href="Fontawesome/fontawesome-free-5.9.0-web/css/all.css">
	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<!-- Material Design Bootstrap -->
	<link href="css/mdb.min.css" rel="stylesheet">
	<!-- Your custom styles (optional) -->
	<link href="css/style.css" rel="stylesheet">
	<!-- My CSS -->
	<link href="mycss/style1.css" rel="stylesheet">
	<link rel="shortcut icon" href="favicon.ico" type="image/ico">
	<link href="favicon.png" rel="icon">
</head>
<body class="bg1">
	<!-- Start of Login -->
	<div align="center" style="margin-top:15%;">
		<div class="row col-sm-6 col-md-6 col-lg-6 card_opa ml-0 mr-0" align="center">
			<div class="col-sm-5 col-md-5 col-lg-5 mx-0 my-0 px-0 py-0 d-flex justify-content-center  waves-effect waves-light">
				<!-- <div class="mx-md-n4 mt-2"> -->
					<img src="Images/ikea-2714998_960_720.jpg" class="img-fluid pt-2 pb-2" alt="placeholder">
				<!-- </div> -->
			</div>
			<div class="col-sm-7 col-md-7 col-lg-7 mx-0 my-0 px-0 py-0">
				<div class="md-form form-md mr-3 ml-3 mb-0">
					<input type="text" id="Username" class="form-control form-control-lg text-center" oninput="id_input()">
					<label for="Username" id="Username_Label">Username:</label>
				</div>
				<div class="md-form  form-md mr-3 ml-3 mb-0">
					<input type="password" id="Password" class="form-control form-control-lg text-center" oninput="pass_input()">
					<label for="Password" id="Password_Label">Password:</label>
				</div>
				<label id="output" class="h6 text-center" style='display:none;'></label>
				<div class="md-form text-center">
					<button type="button" class="btn unique-color white-text waves-effect" onclick="login();">Login</button>
				</div>
			</div>
			<div class="col-sm-12 mx-0 my-0 px-0 py-0 text-right">
				<label class="col-sm-12 my-0 px-0 py-0 text-right">© 2020 Copyright: Furukawa Automotive Systems Lima Philippines, Inc.</a></label>
			</div>
		</div>
	</div>
	<!-- End of Login -->
<!-- SCRIPTS AJAX -->
<script>
	const login =()=>{
		let username = document.getElementById('Username').value;
		let password = document.getElementById('Password').value;
		if(username == ''){
			document.getElementById('Username_Label').innerHTML="Username is Required:";
		}else if(password == ''){
			document.getElementById('Password_Label').innerHTML="Password is Required:";
		}else{
			go(username,password);
		}
	}
	const go =(username,password)=>{
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				let split = response.split("~!~");
				let status = split[0];
				let role = split[1];
				if(status == "locked" ){
					document.getElementById('output').style.display="inline-block"
					document.getElementById('output').innerHTML="Access Denied!";
				}else{
					if(role == 'MM'){
						location.replace("requested_parts.php");
					}else if(role == 'Admin'){
						location.replace("account_settings.php");
					}else if(role == 'Store Out'){
						location.replace("out_parts.php");
					}
				}
			}
		};
		xhttp.open("POST", "AJAX/login.php?username="+username+"&&password="+password, true);
		xhttp.send();
	}
	const id_input =()=>{
		document.getElementById('output').style.display="none"
		document.getElementById('Username_Label').innerHTML="Username:";
		document.getElementById('output').innerHTML="";
	}
	const pass_input =()=>{
		document.getElementById('output').style.display="none"
		document.getElementById('Password_Label').innerHTML="Password:";
		document.getElementById('output').innerHTML="";
	}
</script>
<!-- For Enter Key -->
<script>
	var input = document.getElementById("Password");
	input.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			login();
		}
	});
	var input1 = document.getElementById("Username");
	input1.addEventListener("keyup", function(event) {
		if (event.keyCode === 13){
			event.preventDefault();
			login();
		}
	});
</script>
<!-- JQuery -->
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="js/mdb.min.js"></script>
</body>
</html>
