<?php 
require_once('../modelos/pdf_html.php');
require_once("../modelos/horasextrasModel.php");
require_once("../core/fbasic.php");
///////////////////////////////////////
///////////////////////////////////////
$id = $_GET["id"];
$pdf_html = new pdf_html();
$pdf=$pdf_html->configurar_pdf('P','250','');//Genero el reporte en 
//-- Añadir una página
$pdf->AddPage();
$pdf->writeHTML(cuerpo_reporte($id),true,0,true,true);
$pdf->Output('reporte_horas_extras.pdf', 'D');

//--
function cuerpo_reporte($id){
//--
	$objeto = new horasextrasModel();
	$recordset = $objeto -> consultar_datos_trabajador_reporte($id);
	$id_he = $recordset[0][8];
	$hora_enc = $recordset[0][5];
	$vector_horas = explode(":",$hora_enc);
	$recordset2 = $objeto->consultar_horas_extras_detalle($id_he);
	$linea19 = '';
	$mes = armar_mes($recordset[0][9]);
	$mes = meses_a_letras($mes);
	for($i = 0; $i<=count($recordset2);$i++){
		$i2 =$i+1;
		if($recordset2[$i][2]){
			$fecha1 = date("d/m/Y", strtotime($recordset2[$i][2]));	
		}else{
			$fecha1 = "";
		}
		if($recordset2[$i2][2]){
			$fecha2 = date("d/m/Y", strtotime($recordset2[$i2][2]));	
		}else{
			$fecha2 = "";
		}

		$linea19.= '<!--Linea 19-->
						<tr>
							<td colspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	8px; 
    							text-align:center;">
    							'.$fecha1.'
							</td>
							<td colspan="1"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	8px; 
    							text-align:center;">
								'.$recordset2[$i][3].'
							</td>
							<td colspan="1"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	8px; 
    							text-align:center;">
								'.$recordset2[$i][4].'
							</td>
							<td colspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	8px; 
    							text-align:center;">
								'.$recordset2[$i][5].'	
							</td>
							<td colspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	8px; 
    							text-align:center;">
    							'.$fecha2.'
							</td>
							<td colspan="1"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	8px; 
    							text-align:center;">
    							'.$recordset2[$i2][3].'
							</td>
							<td colspan="1"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	8px; 
    							text-align:center;">
								'.$recordset2[$i2][4].'
							</td>
							<td colspan="3"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	8px; 
    							text-align:center;">
    							'.$recordset2[$i2][5].'
							</td>
							
						</tr>';
						$i = $i2;
	}
	$fecha = date("d-m-Y");
	$body_reporte = '<table style="  width:100%;"  >

<!--Linea 1-->
						<tr>	
							<td rowspan="4" 
								colspan="6" 
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	16px; 
    							background-color: #9da29f; 
    							text-align:center;">
								<br><br>
									 REPÚBLICA BOLIVARIANA DE VENEZUELA
									 TRIBUNAL SUPREMO DE JUSTICIA
									 DIRECCIÓN DE LA MAGISTRATURA
								<br>
							</td>
							<td rowspan="4" 
								colspan="3"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	14px; 
    							background-color: #9da29f; 
    							text-align:center">
								<br><br>
								<span style="color:#030760">
										PLANILLA DE TRÁMITE DE HORAS EXTRAORDINARIAS <span style="color:#bf270a">'.strtoupper($recordset[0][10]).'</span>
								</span>
								<span style="color:#9b0206">
								</span>
								<br>
							</td>
							<td colspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							background-color: #9da29f; 
    							text-align:center;">
								
									Elaboración
								
							</td>
						</tr>
						<tr>
							<td colspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							text-align:center;">
								'.$fecha.'
							</td>

						</tr>
						<tr>
							<td colspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							background-color: #9da29f; 
    							text-align:center;">
									Tipo de Personal
								
							</td>

						</tr>
<!--Linea 6-->
						<tr>
							<td colspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							text-align:center;">
    							<br><br>
								'.$recordset[0][2].'
							</td>

						</tr>
<!--Linea 6-->
						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse;
    							background-color: #9da29f;">
								
							</td>

						</tr>
<!--Linea 7-->
						<tr>
							<td colspan="7"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	14px; 
    							background-color: #9da29f; 
    							text-align:center;">
									APELLIDOS Y NOMBRES
							</td>

							<td colspan="4"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	14px; 
    							background-color: #9da29f; 
    							text-align:center;">
									CEDULA DE IDENTIDAD
							</td>
						</tr>
<!--Linea 8-->
						<tr>
							<td colspan="7"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							text-align:center;">
								'.$recordset[0][0].'
							</td>

							<td colspan="4"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							text-align:center;">
								'.$recordset[0][1].'
							</td>
						</tr>
<!--Linea 9-->
						<tr>
							<td colspan="6"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	14px; 
    							background-color: #9da29f; 
    							text-align:center;">
									CARGO
							</td>

							<td colspan="3"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	14px; 
    							background-color: #9da29f; 
    							text-align:center;">
								
									CONDICIÓN
							</td>

							<td colspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	14px; 
    							background-color: #9da29f; 
    							text-align:center;">
							</td>
						</tr>
<!--Linea 10-->
						<tr>
							<td colspan="6"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							text-align:center;">
								'.$recordset[0][3].'
							</td>

							<td colspan="3"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							text-align:center;">
								'.$recordset[0][4].'
							</td>

							<td colspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							text-align:center;">
								
							</td>
						</tr>
<!--Linea 11-->
						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							text-align:center;">
								AL CDDNO. IDENTIFICADO SE LE TRAMITARÁ LA CANTIDAD DE: '.$recordset[0][5].' HORAS POR CONCEPTO DE HORAS EXTRAORDINARIAS
							</td>

						</tr>
<!--Linea 12-->
						<tr>
							<td colspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							text-align:center;
    							font-weight:bold;">
									LABORADAS EN:
							</td>
							<td colspan="9"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							text-align:center;">
								'.$recordset[0][6].'
							</td>

						</tr>
<!--Linea 13-->
						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	8px; 
    							text-align:center;">
								SEGÚN LO ESTABLECIDO EN LA CLAUSULA N°11 DE LA SEGUNDA CONVENCIÓN COLECTIVA DE EMPLEADOS DE LA DIRECCIÓN EJECUTIVA; Y  
							</td>

						</tr>
<!--Linea 14-->

						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	8px; 
    							text-align:center;">
								SEGÚN LO ESTABLECIDO EN LA CLAUSULA N°15 DE LA 1RA. CONVENCIÓN COLECTIVA DEL PERSONAL OBRERO DE LA DIRECCIÓN EJECUTIVA
							</td>

						</tr>
<!--Linea 15-->
						<tr>
							<td colspan="4"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	8px; 
    							text-align:center;">
								DE LA MAGISTRATURA, LA(S) CUAL(ES) FUE(RON)
							</td>
							<td colspan="3"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px; 
    							background-color: #9da29f; 
    							text-align:center;">
									LABORADA(S) EN EL MES DE:
							</td>
							<td colspan="4"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px; 
    							text-align:center;">
								'.$mes.'
							</td>

						</tr>
<!--Linea 16-->
						<tr>
							<td colspan="3"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px; 
    							background-color: #9da29f; 
    							text-align:center;"><br><br>
									HORA(S) EXTRA(S) MOTIVADA(S) POR:<br>
							</td>
							<td colspan="8"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px; 
    							text-align:center;"><br><br>
								'.strtoupper($recordset[0][7]).'<br>
							</td>
							
						</tr>

<!--Linea 17-->
						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	8px; 
    							text-align:center;">
								
							</td>
							
						</tr>
<!--Linea 18-->
						<tr>
							<td colspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							background-color: #9da29f; 
    							text-align:center;">
								
									FECHA
							</td>
							<td colspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							background-color: #9da29f; 
    							text-align:center;">
								
									LAPSO
								
							</td>
							<td colspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							background-color: #9da29f; 
    							text-align:center;">
								
									HORA(S) EXTRA(S)
								
							</td>
							<td colspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							background-color: #9da29f; 
    							text-align:center;">
								
									FECHA
								
							</td>
							<td colspan="1"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							background-color: #9da29f; 
    							text-align:center;">
							
									LAPSO
								
							</td>
							<td colspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							background-color: #9da29f; 
    							text-align:center;">
							
									HORA(S) EXTRA(S)
								
							</td>
							
						</tr>
<!--Linea 19: detalle de horas -->
							'.$linea19.'
<!--Linea 36-->
						<tr>
							<td colspan="3"
								rowspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							background-color: #9da29f;">
							</td>
							<td colspan="8"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							background-color: #9da29f; 
    							text-align:center;">
								
								Nro. DE HORAS
								
							</td>
							
						</tr>
						<tr>
							<td colspan="4"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							background-color: #9da29f; 
    							text-align:center;">
								
								HORAS
								
							</td>
							<td colspan="4"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							background-color: #9da29f; 
    							text-align:center;">
								
								MINUTOS
								
							</td>
						</tr>

<!--LINEA 38-->
						<tr>
							<td colspan="3"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse;">
							</td>
							
							<td colspan="4"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	16px;
    							text-align:center;
    							font-weight:bold;">
								
								'.$vector_horas[0].'
								
							</td>
							<td colspan="4"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	16px; 
    							text-align:center;
    							font-weight:bold;">
								
								'.$vector_horas[1].'
								
							</td>
						</tr>
<!--Linea 39-->
						<tr>
							<td colspan="3"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	14px; 
    							background-color: #9da29f; 
    							text-align:center;">
    							APROBADO POR:
								
							</td>

							<td colspan="4"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	14px; 
    							background-color: #9da29f; 
    							text-align:center;">
    							CONFORMADO POR:
								
							</td>

							<td colspan="4"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	14px; 
    							background-color: #9da29f; 
    							text-align:center;">
    							AUTORIZADO POR:
								
							</td>
							
						</tr>
<!--Linea 40-->
						<tr>
							<td colspan="3"
								rowspan="3"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; ">
								
							</td>

							<td colspan="4"
								rowspan="3"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse;">
    							
								
							</td>

							<td colspan="4"
								rowspan="3"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse;">
								
							</td>
							
						</tr>

						<tr>
							<td>
							</td>
						</tr>
						<tr>
							<td>
							</td>
						</tr>
<!--Linea 42-->
						<tr>
							<td colspan="3"
								rowspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; ">
								
							</td>

							<td colspan="4"
								rowspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse;">
    							
								
							</td>

							<td colspan="4"
								rowspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse;">
								
							</td>
							
						</tr>

						<tr>
							<td>
							</td>
						</tr>
<!--Linea 44-->
						<tr>
							<td colspan="3"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px; 
    							background-color: #9da29f; 
    							text-align:center;">
    							CONFORME
								
							</td>

							<td colspan="4"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px; 
    							background-color: #9da29f; 
    							text-align:center;">
    							CONFORME
								
							</td>

							<td colspan="4"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px; 
    							background-color: #9da29f; 
    							text-align:center;">
    							CONFORME
								
							</td>
							
						</tr>
<!--Linea 45-->
						<tr>
							<td colspan="3"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							background-color: #9da29f; 
    							text-align:center;">
    							FIRMA Y SELLO
								
							</td>

							<td colspan="4"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px; 
    							background-color: #9da29f; 
    							text-align:center;">
    							FIRMA Y SELLO
								
							</td>

							<td colspan="4"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px; 
    							background-color: #9da29f; 
    							text-align:center;">
    							FIRMA Y SELLO
								
							</td>
							
						</tr>
<!--Linea 46-->
						<tr>
							<td colspan="3"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							background-color: #9da29f;
    							font-weight:bold; ">
    							ELABORADO POR:
								
							</td>

							<td colspan="8"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px; 
    							background-color: #9da29f; 
    							text-align:center;">
    							'.strtoupper($_SESSION['nombres_persona']).'
								
							</td>

														
						</tr>

<!--Linea 47-->
						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	14px; 
    							background-color: #9da29f;
    							text-align:center;	
    							font-weight:bold; ">
    							REQUISITOS A CONSIGNAR, EN CASO DE:
								
							</td>

														
						</tr>
<!--Linea 48-->
						<tr>
							<td colspan="11"
								style=" border-right: 1px
								solid black;
								border-left: 1px
								solid black;
    							border-collapse: collapse; 
    							font-size:	14px; 
    							text-align:center; ">
    							1.-PERSONAL CONTRATADO: COPIA DEL CONTRATO (CONSIGNAR UNA (1) SOLA VEZ)
								
							</td>

														
						</tr>
<!--Linea 49-->
						<tr>
							<td colspan="11"
								style=" border-right: 1px
								solid black;
								border-left: 1px
								solid black;
    							border-collapse: collapse; 
    							font-size:	14px; 
    							text-align:center; ">
    							2.-ASCENSO: COPIA DE NOTIFICACIÓN
								
							</td>

														
						</tr>
<!--Linea 50-->
						<tr>
							<td colspan="11"
								style=" border-right: 1px
								solid black;
								border-left: 1px
								solid black;
    							border-collapse: collapse; 
    							font-size:	14px; 
    							text-align:center; ">
    							3.-CAMBIO DE CONDICIÓN (CONTRATADO A FIJO): COPIA DE PARTICIPACIÓN DE NOMBRAMIENTO 
								
							</td>

														
						</tr>
<!--Linea 51-->
						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	14px; 
    							text-align:center;	
    							font-weight:bold; ">
    							SIN EXCEPCIÓN: REPORTE DE ENTRADA Y SALIDA EMITIDO POR LA DIRECCIÓN GENERAL DE SEGURIDAD
								
							</td>

														
						</tr>
<!--Linea 52-->
						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	14px; 
    							text-align:center;	
    							font-weight:bold; ">
    							CHOFERES Y ESCOLTAS SIN EXCEPCIÓN: REPORTE DE ENTRADA Y SALIDA AVALADO POR LA AUTORIDAD A LA CUAL PRESTA EL SERVICIO
								
							</td>

														
						</tr>
<!--Linea 53-->
						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	14px; 
    							background-color: #9da29f;
    							text-align:center;	
    							font-weight:bold; ">
    							OBSERVACIONES DE LA DIVISIÓN DE RELACIONES LABORALES:
								
							</td>
						</tr>
<!-- -->
						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px; 
    							text-align:center;">
							</td>
						</tr>							
<!-- --->						
					</table>
						
					</thead>
					<tbody></tbody>
					</table>';
	/*$body_reporte = '<div style="width:100%">
						<div style="background-color:#9da29f;width:350px;float:left">
							<div> REPÚBLICA BOLIVARIANA DE VENEZUELA</div>
							<div>  TRIBUNAL SUPREMO DE JUSTICIA</div>
							<div>  DIRECCIÓN DE LA MAGISTRATURA</div>
						</div>
						<div style="float:left">
							<div>PLANILLA DE TRAMITE DE </div>
							<div>HORAS EXTRAORDINARIAS</div>
							<div> DIURNAS </div>
						</div>
						<div style="clear:both"></div>
					</div>';*/				
	//--
	return $body_reporte;
}
?>