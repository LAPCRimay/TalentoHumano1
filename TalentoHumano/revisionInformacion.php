<?php
//require_once 'upload.php';
require_once 'configuracion.php';

//Creamos el encabezado HTML
//html_encabezado("Servicio de postales de DesarrolloWeb","Servicio de postales gratuitas para todo tipo de felicitaciones","postal, navidad, san valentin, cumpleaños, felicitacion");

//Ejecutamos sentencia SQL y recogemos resultado en datoConsultado
$resultid = mysqli_query($conexion,"SELECT * FROM postulante WHERE numero_identificacion='101010100'");//.'$numeroIdentificacion');
$datoConsultado = mysqli_fetch_array($resultid,MYSQLI_ASSOC);

//Si el identificador es correcto, deberiamos tener valores en datoConsultado
if ($datoConsultado) //Si existe esa postal la muestro
{	

//Recreamos la postal con los datos extraidos
?>
<br>
<table align="center" cellspacing="0" cellpadding="2" border="0" bgcolor="White">
<tr>
   <td align="left" valign="middle"><img src="2lightho.gif" width="32" height="32" border="0" alt=""></td>
   <td rowspan="2" width="300">
       <?php echo $datoConsultado["numero_identificacion"].',<br>&nbsp;&nbsp;&nbsp;'.$datoConsultado["nombre_1"].'<br>'
       .$datoConsultado["apellido_1"];?>
   </td>
</tr>

</table>
<!--<div align="center"><a href=<?php "descarga.php?id=".$datoConsultado["curriculum_vitae"];?>>Descargar PDF</a></div> -->
<div align="center"><a href=<?php "descarga.php";?>>Descargar PDF</a></div>

<?php
//ENVIANDO UN CORREO
//Variables de configuracion del correo
$asunto = "Tu postal ha sido recibida";
$cuerpo_mensaje = "Saludos cordiales ".$datoConsultado["nombre_remitente"].",\n\n";
$cuerpo_mensaje .= $datoConsultado["nombre_destinatario"]." ha recibido bien tu postal.\n";
$headers_mensaje = "From: DesarrolloWeb.com>\n";

//Funcion para enviar el correo
$mailenviado = mail ($datoConsultado["email_remitente"], $asunto, $cuerpo_mensaje, $headers_mensaje);
}
else //El identificador era erroneo, la postal no existe
   echo "<div align=\"center\">Lo sentimos, pero esa postal no existe</div>";

//Liberamos la memoria de consulta
mysql_free_result($resultid);
?>
</body>
</html>