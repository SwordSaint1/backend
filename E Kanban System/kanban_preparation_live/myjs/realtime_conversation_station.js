let convo_checker;
const check_conversation_section =()=>{
	// To Check if the Conversation Section is Open or Close
    let active_conversation = document.getElementById('active_conversation').value;
    if(active_conversation == 'Open'){
        count_conversation();
    }else if(active_conversation == 'Close'){
        //Do Nothing
    }
}
const count_conversation =()=>{
	//For Count of Current Conversation
    let remarks_id_scanned_kanban = document.getElementById('remarks_id_scanned_kanban').value;
	let remarks_kanban = document.getElementById('remarks_kanban').value;
	let remarks_kanban_num = document.getElementById('remarks_kanban_num').value;
	let remarks_scan_date_time = document.getElementById('remarks_scan_date_time').value;
	let remarks_request_date_time = document.getElementById('remarks_request_date_time').value;
	let scooter_station = document.getElementById('remarks_scooter_station').value;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			document.getElementById('conversation_count').value=response;
			convo_checker = setTimeout(check_conversation_section_again, 10000);
		}
	};
	xhttp.open("GET", "AJAX/realtime_conversation_station.php?operation=count_conversation&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&scooter_station="+scooter_station, true);	
	xhttp.send();
}
const check_conversation_section_again =()=>{
	//To Check if the Conversation Section is Open or Close
    let active_conversation = document.getElementById('active_conversation').value;
    if(active_conversation == 'Open'){
        count_new_conversation();
    }else if(active_conversation == 'Close'){
        //Do Nothing
	}
}
const count_new_conversation =()=>{
	//For Recount of Conversation
    let remarks_id_scanned_kanban = document.getElementById('remarks_id_scanned_kanban').value;
	let remarks_kanban = document.getElementById('remarks_kanban').value;
	let remarks_kanban_num = document.getElementById('remarks_kanban_num').value;
	let remarks_scan_date_time = document.getElementById('remarks_scan_date_time').value;
	let remarks_request_date_time = document.getElementById('remarks_request_date_time').value;
	let scooter_station = document.getElementById('remarks_scooter_station').value;
	let conversation_count = parseInt(document.getElementById('conversation_count').value);
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = parseInt(this.responseText);
			if(conversation_count != response){
				load_realtime_conversation();
				document.getElementById('conversation_count').value=response;
			}else{
				document.getElementById('conversation_count').value=response;
				//Rechecking of Conversation Section if it is Open or Close
				convo_checker = setTimeout(check_conversation_section_again, 10000);
			}
		}
	};
	xhttp.open("GET", "AJAX/realtime_conversation_station.php?operation=count_conversation&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&scooter_station="+scooter_station, true);	
	xhttp.send();
}
const load_realtime_conversation =()=>{
	let remarks_id_scanned_kanban = document.getElementById('remarks_id_scanned_kanban').value;
	let remarks_kanban = document.getElementById('remarks_kanban').value;
	let remarks_kanban_num = document.getElementById('remarks_kanban_num').value;
	let remarks_scan_date_time = document.getElementById('remarks_scan_date_time').value;
	let remarks_request_date_time = document.getElementById('remarks_request_date_time').value;
	let scooter_station = document.getElementById('remarks_scooter_station').value;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		let response = this.responseText;
		//Display Updated Conversation
		document.getElementById('convo_remarks').innerHTML=response;
		//Rechecking of Conversation Section if it is Open or Close
		convo_checker =  setTimeout(check_conversation_section_again, 10000);
	}
	};
	xhttp.open("GET", "AJAX/realtime_conversation_station.php?operation=load_realtime_conversation&&remarks_id_scanned_kanban="+remarks_id_scanned_kanban+"&&remarks_kanban="+remarks_kanban+"&&remarks_kanban_num="+remarks_kanban_num+"&&remarks_scan_date_time="+remarks_scan_date_time+"&&remarks_request_date_time="+remarks_request_date_time+"&&scooter_station="+scooter_station, true);
	xhttp.send();
}
