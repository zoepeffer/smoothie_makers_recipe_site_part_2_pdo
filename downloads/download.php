<?php
/*
Download
===================================
*/
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="neuer_name.zip"');
readfile("datei.zip");
?>