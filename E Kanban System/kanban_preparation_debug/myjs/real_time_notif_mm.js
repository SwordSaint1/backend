const check_notification =()=>{
	let notif_count = parseInt(document.getElementById('notif_count_hidden').value);
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
            let response = parseInt(this.responseText);
			if(response == '0'){
				//Check the Remarks Again
				setTimeout(check_notification, 10000);
				document.getElementById('badge_notification').innerHTML='';
                document.getElementById('notif_count_hidden').value=response;
			}else if (response != notif_count){
				display_remarks_realtime();
                document.getElementById('badge_notification').innerHTML=response;
                document.getElementById('notif_count_hidden').value=response;
			}else{
				//Check the Remarks Again
				setTimeout(check_notification, 10000);

			}
		}
	};
	xhttp.open("GET", "AJAX/realtime_notif_page_mm.php?operation=count_notif", true);
	xhttp.send();
}
const display_remarks_realtime =()=>{
	let status_sender_id = document.getElementById('status_sender_id').value;
	document.getElementById('header_notif').innerHTML=status_sender_id;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
            let response = this.responseText;
            document.getElementById('remarks_area').innerHTML=response
			setTimeout(check_notification, 10000);
		}
	};
	xhttp.open("GET", "AJAX/notification_mm.php?operation=display_remarks&&status_sender_id="+status_sender_id, true);
	xhttp.send();
}
setTimeout(check_notification, 10000);
