<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar With Dropdown | Ludiflex</title>

</head>
<body>
    
    <nav class="nav">
        <button class="menu-toggle"><i class="fa fa-bars"></i></button>
        <ul class="nav-main-menu">
            <li class="dropdown">
                <a href="#" class="nav-link"><span>Validar</span> <i class="fa fa-chevron-down"></i></a>
                <ul class="dropdown-content">
                    <li><a href="capacitados.php">Usuarios Proservipol</a></li>
                    <li><a href="certificacionServicio.php">Validar</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link"><span>Servicios</span> <i class="fa fa-chevron-down"></i></a>
                <ul class="dropdown-content">
                    <li><a href="serviciosUnidadesEspecializadas.php">Servicios</a></li>
                    <li><a href="actividadFueraCuartel.php">Comisi&oacute;n de Servicio</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link"><span>Personal</span> <i class="fa fa-chevron-down"></i></a>
                <ul class="dropdown-content">
                    <li><a href="personal.php">Personal Unidad</a></li>
                    <li><a href="personal.php?subSeccion=agregados">Personal Agregado al Cuartel</a></li>
                    <li><a href="personal.php?subSeccion=destinados">Personal Destinado a Servicios en este Cuartel</a></li>
                    <li><a href="licenciasDeConducir.php">Licencias de Conducir</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link"><span>Licencias y Permisos</span> <i class="fa fa-chevron-down"></i></a>
                <ul class="dropdown-content">
                    <li><a href="ferper.php">FERPER</a></li>
                    <li><a href="licenciasMedicas.php">Licencias Medicas</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link"><span>Recursos Log&iacute;sticos</span> <i class="fa fa-chevron-down"></i></a>
                <ul class="dropdown-content">
                    <li class="sub-dropdown">
                        <a href="#" class="dropdown-link"><span>Veh&iacute;culos</span> <i class="fa fa-chevron-right"></i></a>
                        <ul class="sub-dropdown-content">
                            <li><a href="vehiculos.php">Veh&iacute;culos</a></li>
                            <li><a href="vehiculos.php?subSeccion=agregados">Veh&iacute;culos agregados</a></li>
                        </ul>
                    </li>
                    <li class="sub-dropdown">
                        <a href="#" class="dropdown-link"><span>Armas</span> <i class="fa fa-chevron-right"></i></a>
                        <ul class="sub-dropdown-content">
                            <li><a href="armas.php">Armas</a></li>
                            <li><a href="armas.php?subSeccion=agregados">Armas agregadas</a></li>
                        </ul>
                    </li>
                    <li class="sub-dropdown">
                        <a href="#" class="dropdown-link"><span>C&aacute;maras Corporales</span> <i class="fa fa-chevron-right"></i></a>
                        <ul class="sub-dropdown-content">
                            <li><a href="camarasCorporales.php">C&aacute;maras Corporales</a></li>
                            <li><a href="camarasCorporales.php?subSeccion=agregados">C&aacute;maras Corporales agregadas</a></li>
                        </ul>
                    </li>
                    <li class="sub-dropdown">
                        <a href="#" class="dropdown-link"><span>Animales</span> <i class="fa fa-chevron-right"></i></a>
                        <ul class="sub-dropdown-content">
                            <li><a href="animales.php">Animales</a></li>
                            <li><a href="animales.php?subSeccion=agregados">Animales agregados</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link"><span>Solicitudes</span> <i class="fa fa-chevron-down"></i></a>
                <ul class="dropdown-content">
                    <li><a href="solicitudes.php">En tramite</a></li>
                    <li><a href="solicitudesUnidadCerradas.php">Cerradas</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link"><span>Mesa de Ayuda</span> <i class="fa fa-chevron-down"></i></a>
                <ul class="dropdown-content">
                    <li><a href="#" onclick="aparece_arbol();">Fiscalizaci&oacute;n</a></li>
                    <li><a href="claveUsuario.php">Gesti&oacute;n Usuario</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link"><span>Configuraci&oacute;n</span> <i class="fa fa-chevron-down"></i></a>
                <ul class="dropdown-content">
                    <li><a href="consultas.php">Consultas</a></li>
                    <li><a href="configuracion.php">Cuadrantes</a></li>
                    <li><a href="abrirVentanaUsuario()">Modifica Clave</a></li>
                    <li><a href="cerrarAplicacion()">Cerrar</a></li>
                </ul>
            </li>
        </ul>
    </nav>

</body>
</html>

<style>

/* ===== Reset some default styles ===== */
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

/* ===== VARIABLES ===== */
:root{
    --bg-color: #fff;
    --primary-color: #000000;
    --second-color: #196FE0;
    --hover-bg-color: #efefef;
    --shadow-1: 0px 2px 10px rgba(0, 0, 0, 0.3);
    --shadow-2: 0px 2px 10px rgba(26, 112, 224, 0.4);
}
/* ===== BODY ===== */
body{
    background: url("../img/bg.jpg");
    background-position: center;
    background-size: cover;
    background-attachment: fixed;
}

/* ===== Reusable CSS ===== */
a{
    text-decoration: none;
    color: var(--primary-color);
    font-weight: 500;
}
ul{
    list-style-type: none;
}

/* ===== Menu Toggle ===== */
.menu-toggle{
    display: none;
    font-size: 24px;
    background: transparent;
    border: none;
    color: var(--primary-color);
    cursor: pointer;
}

/* ===== Navigation Bar ===== */
.nav{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-inline: 3vw;
    height: 70px;
    background: var(--bg-color);
    color: var(--primary-color);
}
.logo h1{
    font-weight: 600;
}
.nav-main-menu{
    display: flex;
}
.nav-link{
    padding: 26px 10px;
    margin-inline: 10px;
    transition: .3s;
}
.nav-link:hover{
    color: var(--second-color);
}
.nav span{
    margin-right: 5px;
}
.fa-chevron-down, .fa-chevron-right{
    font-size: 12px;
    transition: .3s;
}

.dropdown:hover .fa-chevron-down, .sub-dropdown:hover .fa-chevron-right{
    transform: rotate(180deg);
}
.dropdown:hover .nav-link{
    color: var(--second-color);
}

/* ===== Dropdown ===== */
.dropdown{
    position: relative;
}
.nav-main-menu .dropdown-content{
    display: none;
    position: absolute;
    top: 25px;
    left: 0;
    background: var(--bg-color);
    min-width: 240px;
    border-top: 3px solid #ccc;
    border-radius: 0 0 3px 3px;
    animation: slideUp .3s;
}
.dropdown-content li{
    padding: 20px;
}
.dropdown-content li:hover{
    background: var(--hover-bg-color);
}
.dropdown:hover .dropdown-content{
    display: block;
}
/* ===== Sub - Dropdown ===== */
.nav-main-menu .sub-dropdown-content{
   display: none;
   background: var(--bg-color);
   min-width: 240px;
   border-top: 3px solid #ccc;
   border-radius: 3px;
   animation: slideUp .3s;
   box-shadow: var(--shadow-1);
}
@keyframes slideUp {
    from{
        margin-top: 20px;
    }
    to{
        margin-top: 0;
    }
}
.dropdown-link{
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.sub-dropdown:hover .sub-dropdown-content{
    display: block;
}
.btn{
    font-size: 15px;
    background-color: var(--second-color);
    color: var(--bg-color);
    border: none;
    padding: 10px 24px;
    border-radius: 30px;
    box-shadow: var(--shadow-2);
    cursor: pointer;
    transition: .3s;
}
.btn:hover{
    opacity: 0.9;
}

main{
    display: flex;
    align-items: center;
    justify-content: center;
    height: 80vh;
    color: var(--bg-color);
    padding: 20px;
}
main p{
    font-size: 50px;
    font-weight: 600;
    text-align: center;

}

/* ===== Responsive styles ===== */

@media only screen and (max-width: 794px){
    .nav-main-menu{
        display: none;
    }
    .menu-toggle{
        display: block;
    }
}
</style>