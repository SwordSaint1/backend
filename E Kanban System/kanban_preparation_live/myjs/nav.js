var loc = window.location;
var loc_to_string =loc.toString()
var loc_new = loc_to_string.includes("request.php");
var loc_new1 = loc_to_string.includes("scooter_station.php");
var loc_new2 = loc_to_string.includes("history.php");
var loc_new3 = loc_to_string.includes("requested_parts.php");
var loc_new4 = loc_to_string.includes("notification_mm.php");
var loc_new5 = loc_to_string.includes("history_admin.php");
var loc_new6 = loc_to_string.includes("live_store_out.php");
var loc_new7 = loc_to_string.includes("settings_distributor.php");
var loc_new8 = loc_to_string.includes("settings_scooter_stations.php");
var loc_new9 = loc_to_string.includes("account_settings.php");
var loc_new10 = loc_to_string.includes("notification_station.php");
var loc_new11 = loc_to_string.includes("history_station.php");
var loc_new12 = loc_to_string.includes("settings_truck_no.php");
var loc_new13 = loc_to_string.includes("settings_route_no.php");
var loc_new14 = loc_to_string.includes("history_search.php");
var loc_new15 = loc_to_string.includes("request_search.php");
if (loc_new == true){
	document.getElementById("nav_request_section").classList.add('active');
}else if (loc_new1 == true){
	document.getElementById("nav_scooter_station").classList.add('active');
}else if (loc_new2 == true){
	document.getElementById("nav_history_section").classList.add('active');
}else if (loc_new3 == true){
	document.getElementById("nav_request_section").classList.add('active');
}else if (loc_new4 == true){
	document.getElementById("nav_notification_section").classList.add('active');
}else if (loc_new5 == true){
	document.getElementById("nav_history_section").classList.add('active');
}else if (loc_new6 == true){
	document.getElementById("nav_live_history_section").classList.add('active');
}else if (loc_new7 == true){
	document.getElementById("nav_distributor_section").classList.add('active');
}else if (loc_new8 == true){
	document.getElementById("nav_scooter_station_section").classList.add('active');
}else if (loc_new9 == true){
	document.getElementById("nav_account_section").classList.add('active');
}else if (loc_new10 == true){
	document.getElementById("nav_notif_stat_section").classList.add('active');
}else if (loc_new11 == true){
	document.getElementById("nav_history_section").classList.add('active');
}else if (loc_new12 == true){
	document.getElementById("nav_truck_no_section").classList.add('active');
}else if (loc_new13 == true){
	document.getElementById("nav_route_no_section").classList.add('active');
}else if (loc_new14 == true){
	document.getElementById("nav_history_section").classList.add('active');
}else if (loc_new15 == true){
	document.getElementById("nav_search_section").classList.add('active');
}