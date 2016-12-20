<?php 
require_once('../modelos/reporteusModel.php');
require_once("../modelos/usuarioModel.php");
header('Content-type: application/pdf');
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment");
//CREO OBJETO PARA EL PDF
$pdf=new pdf_lista_us();
$pdf->Header();
$pdf->AliasNbPages();
$pdf->AddPage('P','Letter');
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(159,182,205);
$pdf->SetMargins(20, 5 , 10);
$pdf->SetWidths(array(10,60,60,45));
srand(microtime()*1000000);
/////////////////////////////////////////
$obj = new usuarioModel();
$rs = $obj->consultar_usuarios_lista();
for($i=0;$i<=count($rs)-1;$i++)
{
	$a = $a +1;
    $pdf->Row(array($a,$rs[$i][1],$rs[$i][3],$rs[$i][5]));
}	
////////////////////////////////////////
$pdf->Output('reporte_usuarios.pdf','D');     

?>