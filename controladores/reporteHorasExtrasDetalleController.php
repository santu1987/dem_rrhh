<?php 
require_once('../modelos/pdf_html.php');
require_once("../modelos/horasextrasModel.php");
require_once("../core/fbasic.php");
//------------------------------------------------
$fecha_desde = $_POST["fecha_desde"];
$fecha_hasta = $_POST["fecha_hasta"];
$unidad_administrativa = $_POST["select_dptos"];
$pdf_html = new pdf_html();
$pdf=$pdf_html->configurar_pdf('L','250','');//Genero el reporte en 
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
$pdf->ln(10);
$pdf->SetFont('','',15);
$pdf->Cell(0,5,'REPORTE HORAS EXTRAS TRABAJADORES DETALLE', 0,false,'C',0,'',0,false,'M','M');
$pdf->ln(5);
$pdf->writeHTML(cuerpo_reporte($fecha_desde,$fecha_hasta,$unidad_administrativa),true,0,true,true);
$pdf->Output('reporte_horas_extras_detalles.pdf', 'D');
//--
function cuerpo_reporte($fecha_desde,$fecha_hasta,$unidad_administrativa){
	$objeto = new horasextrasModel();
	$recordset = $objeto -> consultar_datos_detalle_horas_extras($fecha_desde,$fecha_hasta,$unidad_administrativa);
	if(count($recordset)>0){
		$body_reporte = '<table style="width:100%;border:solid #fff 1px;">
							<tr style="font-size:11pt;">
								<td style="text-align:center;background-color:#244478;color:#fff;width:90px;">CÉDULA</td>
								<td style="text-align:center;background-color:#244478;color:#fff;">TRABAJADOR</td>
								<td style="text-align:center;background-color:#244478;color:#fff;width:150px;">UNIDAD.ADM</td>
								<td style="text-align:center;background-color:#244478;color:#fff;">FECHA</td>
								<td style="text-align:center;background-color:#244478;color:#fff;">HORA.INI</td>
								<td style="text-align:center;background-color:#244478;color:#fff;">HORA.FIN</td>
								<td style="text-align:center;background-color:#244478;color:#fff;">CANT</td>
							</tr>
						';
		for($i = 0; $i<=count($recordset);$i++){
			$i2 = $i+1; 
			//--Configurando fechas...
			if($recordset[$i][4]){
				$fecha1 = date("d/m/Y", strtotime($recordset[$i][4]));	
			}else{
				$fecha1 = "";
			}
			//--
			$mod = $i2%2;
			if($mod==0){
				$color="#fff";
			}else{
				$color = "#dae4f4";
			}
			//--
			$body_reporte.='<tr style="border:solid #fff;font-size:10pt;">
								<td style="text-align:center;background-color:'.$color.';width:90px;">'.$recordset[$i][1].'</td>
								<td style="text-align:left;background-color:'.$color.'">'.$recordset[$i][0].'</td>
								<td style="text-align:left;background-color:'.$color.';width:150px;">'.$recordset[$i][3].'</td>
								<td style="text-align:center;background-color:'.$color.'">'.$fecha1.'</td>
								<td style="text-align:center;background-color:'.$color.'">'.$recordset[$i][5].'</td>
								<td style="text-align:center;background-color:'.$color.'">'.$recordset[$i][6].'</td>
								<td style="text-align:center;background-color:'.$color.'">'.$recordset[$i][7].'</td>
							</tr>';
		}
		$body_reporte.="</table>";
	}else{
		$body_reporte = '<div style="text-align:center;font-weight:bold">No se consiguen datos relacionados con los motores de búsquedas.</div>';
	}		
	//---
	return $body_reporte;
	//---
	
}
//------------------------------------------------
?>