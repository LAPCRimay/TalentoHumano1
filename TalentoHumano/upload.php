<?php
header("Content-Type: text/html;charset=utf-8");
// Configuracion
require_once 'configuracion.php';
session_start();
$servidor = gethostname();
$folder = "C://uploads/"; // Carpeta a la que queremos subir los archivos
$maxlimit = 500000000; // M�ximo l�mite de tama�o (en bits)
$allowed_ext = "rar,pdf"; // Extensiones permitidas (usad una coma para separarlas)
$overwrite = "yes"; // Permitir sobreescritura? (yes/no)
$error="";
$fechaActual = new DateTime("now");

try{
//GRABAR DATOS
$id= uniqid();
$numeroIdentificacion=$_POST['numeroIdentificacion'];
$nombre1=$_POST['nombre1'];
$nombre2=$_POST['nombre2'];
$apellido1=$_POST['apellido1'];
$apellido2=$_POST['apellido2'];
$cargo=$_POST['cargo'];
$correoElectronico=$_POST['correo'];
$telefono=$_POST['telefono'];
$nombreGuardar = $apellido1."_".$apellido2."_".$nombre1."_".$nombre2.".pdf";
$curriculumVitae=$rutaAlmacenamiento.$nombreGuardar;
$fechaNacimiento=$_POST['fechaNacimiento'];
$fecha=date('Y-m-d', strtotime($fechaNacimiento));
$edad= 4;//date_diff($fechaActual, $fecha);

//CREACIÓN DE LA SENTENCIA
$sql="INSERT INTO POSTULANTE (id,apellido_1,apellido_2,cargo,correo_electronico,curriculum_vitae,edad,fecha_nacimiento,nombre_1,nombre_2,numero_identificacion,telefono)"
        . " VALUES('$id','$apellido1','$apellido2','$cargo','$correoElectronico','$curriculumVitae',$edad,'$fecha','$nombre1','$nombre2','$numeroIdentificacion','$telefono')";
 echo $sql;
//EJECUTAR SENTENCIA
$ejecutar = mysqli_query($conexion,$sql);


//GUARDAR ARCHIVO
$match = ""; 
$filesize = $_FILES['userfile']['size']; // toma el tama�o del archivo
$filename = strtolower($_FILES['userfile']['name']); // toma el nombre del archivo y lo pasa a min�sculas

    
if(!$filename || $filename==""){ // mira si no se ha seleccionado ning�n archivo
   $error = "- Ningún archivo selecccionado para subir.<br>";
}elseif(file_exists($folder.$filename) && $overwrite=="no"){ // comprueba si el archivo existe ya
   $error = "- El archivo <b>$filename</b> ya existe<br>";
}
    
// comprobar tama�o de archivo
if($filesize < 1){ // el archivo est� vac�o
   $error .= "- Archivo vac�o.<br>";
}elseif($filesize > $maxlimit){ // el archivo supera el m�ximo
   $error .= "- Este archivo supera el m�ximo tama�o permitido.<br>";
}
    
$file_ext = preg_split("/\./",$filename); //toma la extension del archivo
$allowed_ext = preg_split("/\,/",$allowed_ext); // verifica que la extension del archivo este dentro de las permitidas
foreach($allowed_ext as $ext){
   if($ext==$file_ext[1]) $match = "1"; // Permite el archivo
}
   
// Extensión no permitida
if(!$match){
   $error .= "- Este tipo de archivo no esta permitido: $filename<br>";
}
    
if($error){
   print "Se ha producido el siguiente error al subir el archivo:<br> $error"; // Muestra los errores
}else{
   if(move_uploaded_file($_FILES['userfile']['tmp_name'], $folder.$nombreGuardar)){ // Finalmente sube el archivo
      print "El archivo se ha subido correctamente!"; //el mensaje que saldra cuando el archivo este subido
   }else{
      print "Error! Puede que el tamano supere el máximo permitido por el servidor. Int�ntelo de nuevo."; // Otro error
   }
}

//ENVIAR CORREO A POSTULANTE
$mail = "Estimado ".$nombre1." ".$apellido1." Tu información ha sido enviada a revisión. Por favor mantente al pendiente de tu correo.";
//Titulo
$titulo = "INFORMACIÓN RECIBIDA";
//cabecera
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
//dirección del remitente 
$headers .= "From: EPN Tech< $correoAdministrador >\r\n";
//Enviamos el mensaje a tu_dirección_email 
$bool = mail($correoElectronico,$titulo,$mail,$headers);
if($bool){
    echo "Mensaje enviado";
}else{
    echo "Mensaje no enviado";
}

//ENVIAR CORREO A GERENTE TALENTO HUMANO
/*$mail = "Estimad@, ha llegado una nueva postulacion de: ".$nombre1." ".$apellido1." Por favor tu revision en el siguiente enlace:".
        "http://".'$dominio'."/TalentoHumano/revisionInformacion";*/
$mail = "Estimad@, ha llegado una nueva postulacion de: ".$nombre1." ".$apellido1." Por favor tu revisión en el siguiente enlace:"
		." http://localhost/TalentoHumano/revisionInformacion.php?id=$id" ;
//Titulo
$titulo = "INFORMACION RECIBIDA";
//cabecera
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
//dirección del remitente 
$headers .= "From: EPN Tech< $correoAdministrador >\r\n";
//Enviamos el mensaje a tu_dirección_email 
$bool = mail($correoElectronico,$titulo,$mail,$headers);
if($bool){
    echo "Mensaje enviado";
}else{
    echo "Mensaje no enviado";
}

}
catch (Exception $e){
    echo 'Se ha producido el error: '.$e;
}
?>

<form>
    <INPUT TYPE="button" VALUE="Atr�s" onClick="history.back()">
</form>