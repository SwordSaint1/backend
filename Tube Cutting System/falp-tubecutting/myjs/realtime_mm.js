setInterval(check_notification, 5000);
function check_notification(){
	var entries = document.getElementById('count_kanban_entries').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			realtime_remarks();
			check_to_ten_min();
			//alert(response);
			if (response != entries){
				display_all_requested_parts(response);
				//document.getElementById('count_kanban_entries').value=response;
			}else{
			}
		}
	};
	xhttp.open("GET", "AJAX/realtime_mm.php?operation=count_entries", true);
	xhttp.send();
}
function display_all_requested_parts(x){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			document.getElementById('count_kanban_entries').value=x;
			document.getElementById('requested_parts').innerHTML=response;
			display_all_requested();
		}
	};
	xhttp.open("GET", "AJAX/get_requested.php?operation=display_all", true);
	xhttp.send();
}
function get_voice(){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			var voice = 'New Parts Requested From Scooter Area '+response;
			var msg = new SpeechSynthesisUtterance(voice);
			window.speechSynthesis.speak(msg);
		}
	};
	xhttp.open("GET", "AJAX/get_requested.php?operation=get_voice", true);
	xhttp.send();
}
function check_to_ten_min(){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			//alert(response);
			var x = response.split('~!~');
			var x = x.slice(0, -1);
			for(i=0;i<x.length;i++){
				var row_of_pending = 'row_of_pending'+x[i];
				var column_of_pending = 'column_of_pending'+x[i];
				document.getElementById(column_of_pending).classList.add('text-danger');
				document.getElementById(row_of_pending).classList.add('pulse_div');
			}
			//alert(response);
		}
	};
	xhttp.open("GET", "AJAX/get_requested.php?operation=check_to_ten_min", true);
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
				//document.getElementById('content_page_notification').innerHTML="";
			}
			//alert(response);
		}
	};
	xhttp.open("GET", "AJAX/realtime_remarks.php?operation=remarks_mm", true);
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
// 	xhttp.open("GET", "AJAX/realtime_remarks.php?operation=mm_remarks_pannel", true);
// 	xhttp.send();
// }