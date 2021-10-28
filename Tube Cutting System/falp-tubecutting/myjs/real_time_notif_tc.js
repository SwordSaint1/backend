setTimeout(count_notif, 30000);
function count_notif(){
    var scooter_station = document.getElementById('station_hidden').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
            var response = this.responseText;
            count_notifi_new();
		}
	};
	xhttp.open("GET", "AJAX/notification_station.php?operation=count_notif&&scooter_station="+scooter_station, true);
	xhttp.send();
}
function count_notifi_new(){
    var scooter_station = document.getElementById('station_hidden').value;
    var hidden_count_unread = document.getElementById('hidden_count_unread').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
            var response = this.responseText;
            var response = parseInt(response);
            var hidden_count_unread = parseInt(hidden_count_unread);
            if (response != hidden_count_unread){
                document.getElementById('hidden_count_unread').value=response;
                real_time_refresh();
            }else{

            }
            setTimeout(count_notif, 30000);
		}
	};
	xhttp.open("GET", "AJAX/notification_station.php?operation=count_notif&&scooter_station="+scooter_station, true);
	xhttp.send();
}