<?php
$rutaDescarga = $_GET['id'];
echo "ruta descarga: $rutaDescarga";
header("Content-disposition: attachment; filename=".$rutaDescarga);
header("Content-type: application/pdf");
readfile($rutaDescarga);
?>