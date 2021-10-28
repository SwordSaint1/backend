const check_out_fsib =()=>{
	document.getElementById('loading_indicator').style.display="inline-block";
	document.getElementById('checking_indicator').style.display="inline-block";
	document.getElementById('checking_indicator').innerHTML="Checking";
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			let response = this.responseText;
			document.getElementById('loading_indicator').style.display="none";
			document.getElementById('checking_indicator').innerHTML="Ready for Delivery: "+ response;
			setTimeout(check_out_fsib, 30000);
		}		
	};
	xhttp.open("GET", "AJAX/out_from_fsib.php?operation=check_out_fsib", true);
	xhttp.send();
}
setTimeout(check_out_fsib, 10000);//Check Database After 10sec = 10000 , 30sec = 30000 , 1 = 60000 , 2 = 120000 , 3 = 180000 , 4 = 240000 Minutes