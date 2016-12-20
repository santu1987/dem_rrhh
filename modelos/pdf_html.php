<?php
require("../core/helpers/tcpdf/tcpdf.php");
class pdf_html
{
	//---Metodo que configura el pdf
	public function configurar_pdf($orientacion,$width_header,$ruta_header){
		$pdf = new TCPDF($orientacion, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// Informacion propia del pdf
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Gianni Santucci');
		$pdf->SetTitle('');
		$pdf->SetSubject('Admin Template');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		
		// Contenido del Header
		//$pdf->SetHeaderData($ruta_header, $width_header,'','',array(0,0,0), array(0,96,99));

		//Contenido del Footer
		$pdf->SetFooterData(array(0,0,0),array(0,96,99));

		// Fuente cabecera y pie de página
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set margins
		//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(10);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		// saltos de página automáticos
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// Se establece ratio de imagenes a utilizar
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		//--
		return $pdf;
	}
	//--Metodo que arma el encabezado
	public function armar_encabezado_constancia(){
		$estructura_consulta='';
		return $estructura_consulta;					   
	}
	//--
}
?>