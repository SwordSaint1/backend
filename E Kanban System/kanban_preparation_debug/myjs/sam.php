<button onclick="a()">M</button>
<script>
function a(){
	var voice = '';
var msg = new SpeechSynthesisUtterance(voice);
window.speechSynthesis.speak(msg);
}
</script>