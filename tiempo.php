<?
  include("session.php");

?>
<script>
	let date_now = new Date();
	let sesion_datetime = new Date(sessionStorage.getItem('session_datetime'));

	if(date_now<sesion_datetime){
		date_now.setMinutes(date_now.getMinutes() + 60);
		sessionStorage.setItem('session_datetime', date_now);
	}
	else{
    alert("SU SESION HA EXPIRADO POR INACTIVIDAD, PARA CONTNUAR DEBE INICIAR SESION NUEVAMENTE.");
    window.location.href="logout.php?inactividad=true";
	}

</script>