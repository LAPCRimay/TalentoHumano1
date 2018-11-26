<?php
//require_once 'upload.php';
require_once 'configuracion.php';

//Ejecutamos sentencia SQL y recogemos resultado en datoConsultado
$id=$_GET['id'];
$resultid = mysqli_query($conexion,"SELECT * FROM postulante WHERE id='".$id."'");
$datoConsultado = mysqli_fetch_array($resultid,MYSQLI_ASSOC);
echo $datoConsultado["curriculum_vitae"];

//Si el identificador es correcto, deberiamos tener valores en datoConsultado
if ($datoConsultado) //Si existe esa postal la muestro
{	

//Recreamos la postal con los datos extraidos
?>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>REVISIÓN DE INFORMACIÓN</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<br>
<table align="center" cellspacing="0" cellpadding="2" border="0" bgcolor="White">
<tr>
    <td rowspan="2" width="300">
       <?php echo $datoConsultado["numero_identificacion"].',<br>&nbsp;&nbsp;&nbsp;'.$datoConsultado["nombre_1"].'<br>'
       .$datoConsultado["apellido_1"];
       $rutaDescarga=$datoConsultado["curriculum_vitae"]; ?>
   </td>
</tr>

</table>


<form>
  <fieldset disabled>
    <div class="form-group">
      <label for="disabledTextInput">Número Identificación*:</label>
      <input type="text" id="numeroIdentificacion" class="form-control" value=<?php echo $datoConsultado["numero_identificacion"]?>>
    </div>
    <div class="form-group">
      <label for="disabledTextInput">Primer Nombre*:</label>
      <input type="text" id="nombre1" class="form-control" value=<?php echo $datoConsultado["nombre_1"]?> >
    </div>
    <div class="form-group">
      <label for="disabledTextInput">Segundo Nombre:</label>
      <input type="text" id="nombre2" class="form-control" value=<?php echo $datoConsultado["nombre_2"]?> >
    </div>
    <div class="form-group">
      <label for="disabledTextInput">Primer Apellido*:</label>
      <input type="text" id="apellido1" class="form-control" value=<?php echo $datoConsultado["apellido_1"]?> >
    </div> 
    <div class="form-group">
      <label for="disabledTextInput">Segundo Apellido:</label>
      <input type="text" id="apellido2" class="form-control" value=<?php echo $datoConsultado["apellido_2"]?> >
    </div>
    <div class="form-group">
      <label for="disabledTextInput">Fecha Nacimiento:</label>
      <input type="date" id="fechaNacimiento" class="form-control" value=<?php echo $datoConsultado["fecha_nacimiento"]?> >
    </div>
    <div class="form-group">
      <label for="disabledTextInput">Correo electrónico:</label>
      <input type="email" id="correo" class="form-control" value=<?php echo $datoConsultado["correo_electronico"]?> >
    </div>
    <div class="form-group">
      <label for="disabledTextInput">Teléfono/Celular: </label>
      <input type="text" id="correo" class="form-control" value=<?php echo $datoConsultado["telefono"]?> >
    </div>  
    
   <div class="form-check">
      <input class="form-check-input" type="checkbox" id="informacionCorrecta">
      <label class="form-check-label" for="disabledFieldsetCheck">
        Información Correcta?
      </label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </fieldset>
</form>

<?php  
echo "<a href='descarga.php?id=$rutaDescarga'>Descargar PDF</a>";
?>

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
