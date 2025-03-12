<? 
session_start();

$userName 			= $_POST['textUsuario'];
$clave 		 		= $_POST['textClave'];
$aplicacion	 		= 10;
$ip         		= $_SERVER['REMOTE_ADDR'];
$fecha_hra_inicio	= date("Y/m/d H:i:s");

?>

<form method="post" action="valida.php" id="formValidar" name="formValidar">
	<input name="textUsuario" type="hidden" id="textUsuario" value="<? echo $_POST['textUsuario']; ?>" />
	<input name="textClave" type="hidden" id="textClave" value="<? echo $_POST['textClave']; ?>" />
</form>

<script src=".\axios\dist\axios.js"></script>
<script>

async function obtenerToken(){
	axios.post('https://api-cil.hoscar.cl/api/v1/login', {
    	usuario: 'proservipol',
    	clave: '49epRYJrTzse'
	},
	{
		headers: {
			'Access-Control-Allow-Origin': '*',
			'Access-Control-Allow-Headers': 'POST, GET, PUT, DELETE, OPTIONS, HEAD, Authorization, Origin, Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers, Access-Control-Allow-Origin',
			'Content-Type': 'application/json',
		}
    })
    .then(function(res) {
        if(res.status==200) {
			let date_now = new Date();
			date_now.setMinutes(date_now.getMinutes() + 2);
			sessionStorage.setItem('access_token', res.data.access_token);
			sessionStorage.setItem('token_type', res.data.token_type);
			sessionStorage.setItem('session_datetime', date_now);
			document.cookie = 'access_token='+res.data.access_token+'; session_datetime='+date_now;
			document.formValidar.submit();
        }
    })
    .catch(function(err) {
        console.log(err);
        self.location.href='index.php?ctrl=1';
    });
}

obtenerToken();

</script>
