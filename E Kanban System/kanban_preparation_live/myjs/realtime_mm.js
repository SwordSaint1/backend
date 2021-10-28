const check_notification =()=>{
	let entries = document.getElementById('count_kanban_entries').value;
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			if (response != entries){
				display_all_requested_parts(response);
				document.getElementById('count_kanban_entries').value=response;
			}else{
				realtime_remarks();
			}
		}
	};
	xhttp.open("GET", "AJAX/realtime_mm.php?operation=count_entries", true);
	xhttp.send();
}
const display_all_requested_parts =(x)=>{
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			document.getElementById('count_kanban_entries').value=x;
			document.getElementById('requested_parts').innerHTML=response;
			display_all_requested__op_parts();
			//console.log('checking op request');
		}
	};
	xhttp.open("GET", "AJAX/get_requested_printing.php?operation=display_pending", true);
	xhttp.send();
}
const display_all_requested__op_parts =()=>{
	let load_more_counter_op = parseInt(document.getElementById('load_more_counter_op').value);
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			document.getElementById('ongoing_picking_parts').innerHTML=response;
			count_requested_ongoing_realtime();
			//console.log('checking remarks');
		}
	};
	xhttp.open("GET", "AJAX/get_requested_printing.php?operation=display_ongoing_realtime&&limiter_count="+load_more_counter_op, true);
	xhttp.send();
}
const count_requested_ongoing_realtime =()=>{
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			let total_count = parseInt(response);
			let table_rows = parseInt(document.getElementById("ongoing_picking_parts").rows.length);
			let load_more_counter_op = document.getElementById('load_more_counter_op').value;
			document.getElementById('counter_viewer_op').innerHTML=table_rows +' - '+ total_count;
			if (total_count == 0){
				document.getElementById('load_more_botton_op').style.display='none';
			}else if (total_count > load_more_counter_op){
				document.getElementById('load_more_botton_op').style.display='inline-block';
			}else if (total_count < load_more_counter_op){
				document.getElementById('load_more_botton_op').style.display='none';
			}
			realtime_remarks();
		}
	};
	xhttp.open("GET", "AJAX/get_requested_printing.php?operation=count_requested_ongoing", true);
	xhttp.send();
}
const realtime_remarks =()=>{
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			if(response != 0){				
				document.getElementById('badge_notification').innerHTML=response;
			}else if( response == 0){
				document.getElementById('badge_notification').innerHTML='';
			}
			check_to_ten_min();
			//console.log('checking 10 mins');
		}
	};
	xhttp.open("GET", "AJAX/realtime_mm.php?operation=remarks_mm", true);
	xhttp.send();
}
const check_to_ten_min =()=>{
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			let x = response.split('~!~');
			x.slice(0, -1);
			for(i=0;i<x.length;i++){
				let row_of_pending = 'row_of_pending'+x[i];
				let myEle = document.getElementById(row_of_pending);
				if(row_of_pending != 'row_of_pending'){
					if(myEle){
						document.getElementById(row_of_pending).classList.add('pulse_div');
					}else{
					}
				}else{

				}
			}
			//For Removing Selector IP After 10 Mins
			remove_ip_selector();
		}
	};
	xhttp.open("GET", "AJAX/realtime_mm.php?operation=check_to_ten_min", true);
	xhttp.send();
}
const remove_ip_selector =()=>{
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			//alert(response);
			setTimeout(check_notification, 10000);
		}
	};
	xhttp.open("GET", "AJAX/realtime_mm.php?operation=remove_ip_selector", true);
	xhttp.send();
}
setTimeout(check_notification, 10000);
