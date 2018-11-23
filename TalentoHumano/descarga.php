<?php
header("Content-disposition: attachment; filename=c:\uploads\iesspdf.pdf");
header("Content-type: application/pdf");
readfile("c:\uploads\iesspdf.pdf");
?>