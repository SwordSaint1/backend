var loc = window.location;
var loc_to_string =loc.toString()
var loc_new = loc_to_string.includes("request.php");
var loc_new1 = loc_to_string.includes("scooter_station.php");
var loc_new2 = loc_to_string.includes("history.php");
if (loc_new == true){
	document.getElementById("nav_request_section").classList.add('active');
}else if (loc_new1 == true){
	document.getElementById("nav_scooter_station").classList.add('active');
}else if (loc_new2 == true){
	document.getElementById("nav_history_section").classList.add('active');
}