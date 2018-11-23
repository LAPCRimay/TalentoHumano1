<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Inicializar datos generales
$rutaAlmacenamiento='C:\\\\uploads\\';
$servidor='localhost';
$usuario='usrtalento';
$contrasena='KzLPMpwHpfZ7VHdg';
$baseDatos='TALENTO_HUMANO';
$correoAdministrador="lorepadilla0@gmail.com";
$correoTalentoHumano="lorepadilla0@gmail.com";
//Conectar con la base de datos
  $conexion = new mysqli($servidor,$usuario,$contrasena);
   //Verificar la conexion
   if(!$conexion->set_charset('utf8')){
       echo("No se pudo conectar con el servidor");
   }else{
       $base = mysqli_select_db($conexion,$baseDatos);
       if(!$base){
           echo("No se encontro la base de datos");
       }
   }
?>
