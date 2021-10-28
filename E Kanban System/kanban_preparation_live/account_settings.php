<?php
	session_start();
	$username_session = $_SESSION["username_session"];
	if($username_session == ''){
		header("location:index.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Account Settings (Advance Kanban Preparation)</title>
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
<body class="bg">
<?php
	include 'Nav/header.php';
	include 'Modal/accounts_modal.php';
?>
<div class="row mx-0 my-0">
	<div class="col-sm-4 col-md-4 col-lg-4">
	</div>
	<input type="hidden" id="entries_pending">
	<input type="hidden" id="entries_pending_count">
	<div class="col-sm-4 col-md-4 col-lg-4 text-center mt-1">
		<label class="h3"><i class="fas fa-users-cog"></i> List of Accounts </label>	
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12">
		<button class="btn unique-color white-text float-right" onclick="add_account_button()"><i class="fas fa-plus-circle"></i> Add Account</button>
	</div>
	<div class="row mx-0 col-sm-12 col-md-12 col-lg-12" id="scooter_station_section">
		<table class="table table-bordered table-sm">
			<thead>
				<tr class="unique-color white-text"> 
					<td class="h6">ID</td>
					<td class="h6">Username</td>
					<td class="h6">Name</td>
					<td class="h6">Role</td>
					<td class="h6">Date Updated</td>
				</tr>
				<tbody id="scooter_station_list">
				</tbody>
			</thead>
		</table>
	</div>
</div>
<!-- JQuery -->
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="js/mdb.min.js"></script>
<!-- My JavaScript for Navigation-->
<script type="text/javascript" src="myjs/nav.js"></script>
<script>
	const select_accounts =()=>{
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("scooter_station_list").innerHTML=response;
			}
		};
		xhttp.open("GET", "AJAX/account_management.php?operation=select_account", true);
		xhttp.send();
	}
	const save_accounts =()=>{
		let name = document.getElementById("name").value;
		let username = document.getElementById("username").value;
		let password = document.getElementById("password").value;
		let role = document.getElementById("role").value;
		let	xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("out_account").innerHTML=response;
				select_accounts();
			}
		};
		xhttp.open("GET", "AJAX/account_management.php?operation=save_account&&name="+name+"&&username="+username+"&&password="+password+"&&role="+role, true);
		xhttp.send();
	}
	const get_this_account =(data_param)=>{
		$("#Accounts_Form").modal();
		let split = data_param.split('~!~');
		document.getElementById("id_hidden").value=split[0];
		document.getElementById("name").value=split[1];
		document.getElementById("username").value=split[2];
		document.getElementById("role").value=split[3];
		document.getElementById("update_accounts_button").style.display="inline-block";
		document.getElementById("delete_accounts_button").style.display="inline-block";
		document.getElementById("save_accounts_button").style.display="none";
	}
	const update_accounts =()=>{
		let id_hidden = document.getElementById("id_hidden").value;
		let name = document.getElementById("name").value;
		let password = document.getElementById("password").value;
		let username = document.getElementById("username").value;
		let role = document.getElementById("role").value;
		let	xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("out_account").innerHTML=response;
				select_accounts();
			}
		};
		xhttp.open("GET", "AJAX/account_management.php?operation=update_account&&name="+name+"&&username="+username+"&&password="+password+"&&role="+role+"&&id="+id_hidden, true);
		xhttp.send();
	}
	const delete_accounts =()=>{
		let id_hidden = document.getElementById("id_hidden").value;
		let	xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				let response = this.responseText;
				document.getElementById("out_account").innerHTML=response;
				select_accounts();
			}
		};
		xhttp.open("GET", "AJAX/account_management.php?operation=delete_account&&id="+id_hidden, true);
		xhttp.send();
	}
	const close_modal =()=>{
		$('#Accounts_Form').modal('toggle');
		document.getElementById("out_account").innerHTML="";
		document.getElementById("name").value="";
		document.getElementById("password").value="";
		document.getElementById("username").value="";
		document.getElementById("role").value="Role";
	}
	const add_account_button =()=>{
		$("#Accounts_Form").modal();
		document.getElementById("update_accounts_button").style.display="none";
		document.getElementById("delete_accounts_button").style.display="none";
		document.getElementById("save_accounts_button").style.display="inline-block";
		document.getElementById('accounts_head').innerHTML='Account Management';
		document.getElementById('name').value="";
		document.getElementById('username').value="";
		document.getElementById('password').value="";
	}
	select_accounts();
</script>
</body>
</html>
