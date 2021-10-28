const check_notification =()=>{
	let scooter_station = document.getElementById('scooter_station_real').value;
	let entries = document.getElementById('count_pending').value;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			if (response != entries){
				display_all_requested_parts();
				document.getElementById('count_pending').value=response;
			}else{
				//Check Count of Ongoing Picking
				count_op_realtime();
			}
		}
	};
	xhttp.open("GET", "AJAX/realtime_station.php?operation=count_entries&&scooter_station="+scooter_station, true);
	xhttp.send();
}
const display_all_requested_parts =()=>{
	let scooter_area = document.getElementById('scooter_station_real').value;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			let response = this.responseText;
			if(response == ""){
				document.getElementById('pending_parts_section').style.display="none";
				document.getElementById('pending_parts_label_section').style.display="none";
			}else{
				document.getElementById('pending_parts_section').style.display="inline-block";
				document.getElementById('pending_parts_label_section').style.display="inline-block";
				document.getElementById('requested_parts_this_area').innerHTML=response;
			}
			count_op_realtime();
		}
	};
	xhttp.open("GET", "AJAX/get_requested.php?operation=select_request_scooter_area&&scooter_area="+scooter_area, true);
	xhttp.send();
}
const count_op_realtime =()=>{
	let scooter_station = document.getElementById('scooter_station_real').value;
	let entries = document.getElementById('count_op').value;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			if (response != entries){
				display_all_op_parts();
				document.getElementById('count_op').value=response;
			}else{
				//For Checking Notification
				count_all_notification();
			}
		}
	};
	xhttp.open("GET", "AJAX/realtime_station.php?operation=count_op_realtime&&scooter_station="+scooter_station, true);
	xhttp.send();
}
const display_all_op_parts =()=>{
	let scooter_area = document.getElementById('scooter_station_real').value;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			let response = this.responseText;
			if(response == ""){
				document.getElementById('ongoing_parts_section').style.display="none";
				document.getElementById('ongoing_parts_label_section').style.display="none";
			}else{
				document.getElementById('ongoing_parts_section').style.display="inline-block";
				document.getElementById('ongoing_parts_label_section').style.display="inline-block";
				document.getElementById('ongoing_picking_parts_this_area').innerHTML=response;
			}
			//For Checking Notification
			count_all_notification();
		}
	};
	xhttp.open("GET", "AJAX/get_requested.php?operation=select_request_scooter_area_ongoing&&scooter_area="+scooter_area, true);
	xhttp.send();
}
const count_all_notification =()=>{
	let scooter_station_real = document.getElementById('scooter_station_real').value;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			if(response != 0){				
				document.getElementById('badge_notification').innerHTML=response;
			}else if( response == 0){
				document.getElementById('badge_notification').innerHTML='';
			}
			setTimeout(check_notification, 10000);
		}
	};
	xhttp.open("GET", "AJAX/realtime_station.php?operation=count_all_notification&&scooter_station="+scooter_station_real, true);
	xhttp.send();
}
setTimeout(check_notification, 10000);
