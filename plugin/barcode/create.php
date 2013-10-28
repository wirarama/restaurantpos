<?php
require("barcode.inc.php");
$encode=$_REQUEST['encode'];
$bar= new BARCODE();
if($bar==false) die($bar->error());
$barnumber='120000000789';
$bar->setSymblogy('CODE128');
$bar->setHeight('50');
$bar->setScale('2');
$bar->setHexColor('#000000','#FFFFFF');  	
$return = $bar->genBarCode($barnumber,'png','output');
if($return==false) $bar->error(true);
?>
