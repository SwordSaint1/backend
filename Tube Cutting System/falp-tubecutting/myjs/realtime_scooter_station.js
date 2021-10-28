setTimeout(count_pending, 30000);
function count_pending(){
	var entries_pending_count = document.getElementById('entries_pending_count').value;
	var scooter_area = "<?php echo $_SESSION['scooter_area'];?>";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('entries_pending_count').value=response;
			if (response != entries_pending){
				display_all_requested_parts_by_not_pending(response);
			}else{
			}
			count_ongoing_picking();
		}
	};
	xhttp.open("GET", "AJAX/realtime_scooter_station.php?operation=count_pending&&scooter_area="+scooter_area, true);
	xhttp.send();
}
function count_ongoing_picking(){
	var entries_pending = document.getElementById('entries_pending').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			if (response != entries_pending){
				display_all_requested_parts(response);
				//count_pending();
				//document.getElementById('count_kanban_entries').value=response;
			}else{
				//count_pending();
			}
			realtime_remarks();
		}
	};
	xhttp.open("GET", "AJAX/realtime_scooter_station.php?operation=count_entries_pending", true);
	xhttp.send();
}
function realtime_remarks(){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			if(response != 0){				
				document.getElementById('badge_notification').innerHTML=response;
				//open_notification_pannel();
			}else if( response == 0){
				document.getElementById('badge_notification').innerHTML='';
				document.getElementById('content_page_notification').innerHTML="";
			}
			setTimeout(count_pending, 30000);
		}
	};
	xhttp.open("GET", "AJAX/realtime_remarks.php?operation=remarks_scooter_station", true);
	xhttp.send();
}
// function open_notification_pannel(){
// 	var xhttp = new XMLHttpRequest();
// 	xhttp.onreadystatechange = function(){
// 		if (this.readyState == 4 && this.status == 200){
// 			var response = this.responseText;
// 			if(response != ''){
// 				document.getElementById('content_page_notification').innerHTML=response;
// 			}else{
// 				document.getElementById('content_page_notification').innerHTML="";
// 			}
// 		}
// 	};
// 	xhttp.open("GET", "AJAX/realtime_remarks.php?operation=scooter_station_remarks_pannel", true);
// 	xhttp.send();
// }

