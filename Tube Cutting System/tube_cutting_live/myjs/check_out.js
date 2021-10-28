setTimeout(check_out_fsib, 30000);//Check Database After 10sec = 10000 , 30sec = 30000 , 1 = 60000 , 2 = 120000 , 3 = 180000 , 4 = 240000 Minutes
function check_out_fsib(){
	//alert('Ongoing Checking');
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			var response = this.responseText;
			//alert(response);
			setTimeout(check_out_fsib, 10000);
			//alert(response);
		}		
	};
	xhttp.open("GET", "AJAX/out_from_fsib.php?operation=check_out_fsib", true);
	xhttp.send();
}