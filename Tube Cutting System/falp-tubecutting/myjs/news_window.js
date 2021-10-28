function close_modal_news_window(){
	$('#news_window').modal('toggle');
	document.getElementById('modal_stat').value='Hide';
}
function activityWatcher(){
  var secondsSinceLastActivity = 0;
  // Maximum 30sec of inactivity
  var maxInactivity = 60;
  setInterval(function(){
      secondsSinceLastActivity++;
      if(secondsSinceLastActivity > maxInactivity){
        var modal_stat = document.getElementById("modal_stat").value;
        var fileName = location.href.split("/").slice(-1);
        if (fileName == 'request.php'){
          var id_scanned_kanban = document.getElementById("id_scanned_kanban").value;
          if (id_scanned_kanban == ''){
            if (modal_stat == "Hide"){
              $("#news_window").modal();
              document.getElementById("modal_stat").value="Show";
            }else{

            }
          }else{
          }
        }else{
          if (modal_stat == "Hide"){
            $("#news_window").modal();
            document.getElementById("modal_stat").value="Show";
          }else{

          }
        }
      }
  }, 1000);
  function activity(){
    secondsSinceLastActivity = 0;
  }
  var activityEvents = ['mousedown', 'mousemove', 'keydown','scroll', 'touchstart'];
  activityEvents.forEach(function(eventName) {
    document.addEventListener(eventName, activity, true);
  });


}
activityWatcher();