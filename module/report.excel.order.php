<?
require('common.connect.php');
require('common.formlev2.php');
require('module.order.php');
require_once "../plugin/excel/class.writeexcel_workbookbig.inc.php";
require_once "../plugin/excel/class.writeexcel_worksheet.inc.php";
$fname = tempnam('../plugin/excel/temp',"blueline");
$workbook =& new writeexcel_workbookbig($fname);
$worksheet =& $workbook->addworksheet('Order');
$worksheet->hide_gridlines(2);
$worksheet->set_landscape();
$worksheet->set_paper(8);
include("exel_style.php");
//
$head = array('Product','Amount','Price','Total','Chair','Type');
$col_width = array('50','20','50','50','20','20');
for ($i=0;$i<7;$i++){
	$worksheet->set_column($i,$i,$col_width[$i]);
}
//
$supplyid = supplyid($_GET['chart']);
$judul = 'Order_Report_'.date("d-M-Y_h:i:A");
$title_col1 = array('TRANSACTION ID : '.$supplyid,'','','','','','');
//
$worksheet->set_row(0,15);
$worksheet->set_selection('C3');
$worksheet->write(0,0,$title_col1,$merg_cel_titel);
//
$j=0;
foreach($head AS $head1){
	$worksheet->write(2,$j,$head1,$header2);
	$j++;
}
//
list($rows,$ids) = order_data(1);
$i=3;
$no=1;
foreach($rows AS $d){
	$j=0;
	foreach($d AS $d1){
		$worksheet->write($i,$j,strip_tags($d1),$headerDt);
		$j++;
	}
	$i++;
}
$workbook->close();
//
header("Content-Type: application/x-msexcel; name=\"$judul.xls\"");
header("Content-Disposition: inline; filename=\"$judul.xls\"");
$fh=fopen($fname, "r");
fpassthru($fh);
unlink($fname);
?>
