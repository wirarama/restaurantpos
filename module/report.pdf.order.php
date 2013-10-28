<?
require('../plugin/fpdf16/fpdf.php');
require('common.connect.php');
require('common.formlev2.php');
require('module.order.php');
class PDF extends FPDF
{
	function Header()
	{
		$supplyid = supplyid($_GET['chart']);
		$this->SetFont('','B');
		$this->SetFont('');
		$this->Cell(40,5,'TRANSACTION ID : ',0,0,'R');
		$this->Cell(100,5,$supplyid,0,0,'L');
		$this->Ln();
		//Line break
		$this->Ln(10);
		//Colors, line width and bold font
		$this->SetFillColor(100,100,100);
		$this->SetTextColor(255);
		$this->SetDrawColor(0,0,0);
		$this->SetLineWidth(.2);
		$this->SetFont('','B');
		$header = array('Product','Amount','Price','Total','Chair','Type');
		$w = array('50','20','50','50','20','20');
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
		//Line break
		$this->Ln();
	}
	//Colored table
	function FancyTable($data)
	{
		//Header
		$w = array('50','20','50','50','20','20');
		//Color and font restoration
		$this->SetFillColor(200,200,200);
		$this->SetTextColor(0);
		$this->SetFont('');
		//Data
		$fill=false;
		$i=0;
		foreach($data as $row)
		{
			$j=0;
			foreach($row AS $row1){
				$this->Cell($w[$j],6,strip_tags($row[$j]),'LR',0,'R',$fill);
				$j++;
			}
			$this->Ln();
			$fill=!$fill;
			$i++;
			if($i==24){
				$i = 0;
				$this->Cell(array_sum($w),0,'','T');
				$this->AddPage('L','A4','mm');
			}
		}
		$this->Cell(array_sum($w),0,'','T');
	}
}
$pdf=new PDF();
//Column titles
list($rows,$ids) = order_data(1);
$pdf->SetFont('Arial','',9);
$pdf->AddPage('L','A4','mm');
$pdf->FancyTable($rows);
$pdf->Output();
?>
