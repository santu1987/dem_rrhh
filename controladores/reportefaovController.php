<?php 
require_once('../modelos/pdf_html.php');
require_once("../modelos/usuarioModel.php");
require_once("../core/helpers/EnLetras.php");
require_once("../core/fbasic.php");
///////////////////////////////////////
$usuario = new usuarioModel();
$arreglo = $usuario->consultar_faov();
///////////////////////////////////////
$pdf_html = new pdf_html();
$pdf=$pdf_html->configurar_pdf('P','250','');//Genero el reporte en 
//-- Añadir una página
$pdf->AddPage();
//--Muestro el encabezado
$pdf->SetFont('','',30);
$pdf->Cell(0, 5,'DEM', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$pdf->ln(10);
$pdf->SetFont('','',12);
$pdf->Cell(0, 5,'REPÚBLICA BOLIVARIANA DE VENEZUELA', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$pdf->ln(5);
$pdf->SetFont('','B',12);
$pdf->Cell(0, 5,'DIRECCIÓN EJECUTIVA DE LA MAGISTRATURA', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('','',12);
$pdf->ln(5);
$pdf->Cell(0, 5,'Dirección General de Recursos Humanos', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$pdf->ln(5);
$pdf->Cell(0, 5,'Dirección de Servicios al Personal', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$pdf->ln(10);
$pdf->SetFont('','B',12);
$pdf->Cell(0, 5,'CONSTANCIA', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$pdf->ln(10);
$pdf->SetFont('','',12);
$pdf->writeHTML(cuerpo_reporte($arreglo), true, 0, true, true);
$pdf->ln(10);
$pdf->writeHTML(cuerpo_reporte2(), true, 0, true, true);
$pdf->ln(10);
$pdf->Cell(0, 5,'Atentamente', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$pdf->ln(20);
$pdf->SetFont('','B',12);
$pdf->Cell(0, 5,'JUDITH DEL CARMEN FRANCO PÉREZ', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$pdf->SetFont('','',12);
$pdf->ln(5);
$pdf->Cell(0, 5,'Directora de Servicios al personal (E) ', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$pdf->Output();
//--Cuerpo de funciones
function cuerpo_reporte($arreglo){
	//
	$fecha_nacimiento = substr($arreglo[0][3],0,10);
	$vector_nac = explode("-",$fecha_nacimiento);
	$dia_letras = numero_to_letras($vector_nac[2]);
	$mes_letras = meses_a_letras($vector_nac[1]);
	$ano_letras = numero_to_letras($vector_nac[0]);
	//
	$fecha_ingreso = substr($arreglo[0][5],0,10);
	$vector_ingreso = explode("-",$fecha_ingreso);
	$dia_letras_ing = numero_to_letras($vector_ingreso[2]);
	$mes_letras_ing = meses_a_letras($vector_ingreso[1]);
	$ano_letras_ing = numero_to_letras($vector_ingreso[0]);
	//
	$body_reporte ='<span style="text-align:justify;">Quien suscribe <b>JUDITH DEL CARMEN FRANCO PÉREZ</b> titular de la cédula de identidad número <b>V-6.000.964</b>, en su condición de <b>Directora de Servicios al Personal (E), de la Dirección General de Recursos Humanos</b> designada mediante resolución  número 0015 de fecha trece (13) de octubre de 2015, publicado en la Gaceta Oficial de la República Bolivariana de Venezuela N° 40.771 de fecha veintiuno (21) de octubre de 2015, <b>HACE CONSTAR</b>: Que el/la ciudadana/ciudadano <b>'.strtoupper($arreglo[0][0])." ".strtoupper($arreglo[0][1]).'</b> titular de la cédula de identidad número <b>'.$arreglo[0][2].'</b> con fecha de nacimiento el día '.strtolower($dia_letras).' ('.$vector_nac[2].') de '.strtolower($mes_letras).' de '.$vector_nac[0].' desempeñando el cargo de '.$arreglo[0][4].' adscrito a la '.$arreglo[0][7].', es contribuyente de la Ley de Regimén Prestacional de Vivienda y Habitat desde el día '.strtolower($dia_letras_ing).' ('.$vector_ingreso[2].') de '.strtolower($mes_letras_ing).' de '.strtolower($ano_letras_ing).' hasta la presente fecha, depositándose el respectivo descuento en el <b>BANCO NACIONAL DE VIVIENDA Y HABITAT</b>, bajo el número de afilación '.$arreglo[0][6].'.</span>';
	return $body_reporte;
}
//--
function cuerpo_reporte2(){
	//
	$dia = date("d");
	$mes = date("m");
	$anio = date("Y");
	$dia_letras_actual = numero_to_letras($dia);
	$mes_letras_actual = meses_a_letras($mes);
	$ano_letras_actual = numero_to_letras($anio);
	//
	$body_reporte ='<span style="text-align:justify;">Constancia que se expide, a solicitud de la parte interesada en Caracas, a los '.strtolower($dia_letras_actual).'('.$dia.') días de '.strtolower($mes_letras_actual).'  de '.strtolower($ano_letras_actual).' ('.$anio.')</span>';
	return $body_reporte;
}
?>