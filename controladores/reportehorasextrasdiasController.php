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
$pdf->Output('reporte_dias_adicionales.pdf', 'D');
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
	$arreglo_vector = array();
	$x = 0;
	$c =0;
	for($i=0;$i<count($recordset2);$i++){
		//--
		for($j=2;$j<4;$j++){
			if($recordset2[$i][$j]){
				if($x==0){
					$array[$i][$x] = date("d/m/Y", strtotime($recordset2[$i][$j]));	
					$c++;
				}else{
					$array[$i][$x] = $recordset2[$i][$j];
				}
			}else{
				$array[$i][$x] = "";
			}
			$x++;
		}
		$x = 0;
		//--
	}
	//--
	if($c<10){
		$c = "0".$c;
	}
	//------------------------------------
	$linea13.= '<!--Linea 13-->
			<tr>
				<td colspan="1"
					style=" border: 1px 
					solid black;
					border-collapse: collapse; 
					font-size:	10px; 
					text-align:center;">
					'.$array[0][0].'
				</td>
				<td colspan="1"
					style=" border: 1px 
					solid black;
					border-collapse: collapse; 
					font-size:	10px; 
					text-align:center;">
					'.$array[1][0].'
				</td>
				<td colspan="1"
					style=" border: 1px 
					solid black;
					border-collapse: collapse; 
					font-size:	10px; 
					text-align:center;">
					'.$array[2][0].'
				</td>
				<td colspan="1"
					style=" border: 1px 
					solid black;
					border-collapse: collapse; 
					font-size:	10px; 
					text-align:center;">
					'.$array[3][0].'
				</td>
				<td colspan="1"
					style=" border: 1px 
					solid black;
					border-collapse: collapse; 
					font-size:	10px; 
					text-align:center;">
					'.$array[4][0].'
				</td>
				<td colspan="1"
					style=" border: 1px 
					solid black;
					border-collapse: collapse; 
					font-size:	10px; 
					text-align:center;">
					'.$array[5][0].'
				</td>
				<td colspan="1"
					style=" border: 1px 
					solid black;
					border-collapse: collapse; 
					font-size:	10px; 
					text-align:center;">
					'.$array[6][0].'
				</td>
				<td colspan="1"
					style=" border: 1px 
					solid black;
					border-collapse: collapse; 
					font-size:	10px; 
					text-align:center;">
					'.$array[7][0].'
				</td>
				<td colspan="1"
					style=" border: 1px 
					solid black;
					border-collapse: collapse; 
					font-size:	10px; 
					text-align:center;">
					'.$array[8][0].'
				</td>
				<td colspan="1"
					style=" border: 1px 
					solid black;
					border-collapse: collapse; 
					font-size:	10px; 
					text-align:center;">
					'.$array[9][0].'
				</td>
				<td colspan="1"
					style=" border: 1px 
					solid black;
					border-collapse: collapse; 
					font-size:	10px; 
					text-align:center;">
					'.$array[10][0].'
				</td>
			</tr>';
	//--------------------------------------------------				
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
										PLANILLA DE TRÁMITE DE JORNADA DE DÍAS DE DESCANSO Y/O FERIADOS LABORADOS
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
    							text-align:center;
    							font-weight:bold;">
								
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
    							text-align:center;
    							font-weight:bold;">
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
    							background-color: #9da29f;
    							font-size:	12px;
    							font-weight:bold;  
    							text-align:center">
								DATOS PERSONALES
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
    							font-size:	12px;
    							font-weight:bold; 
    							text-align:center;">
									APELLIDOS Y NOMBRES
							</td>

							<td colspan="4"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px;
    							font-weight:bold; 
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
							<td colspan="4"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px;
    							font-weight:bold; 
    							background-color: #9da29f; 
    							text-align:center;"><br><br>
									UBICACIÓN ADMINISTRATIVA
									<br>
							</td>

							<td colspan="4"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px; 
    							text-align:center;"><br><br>
    							'.$recordset[0][6].'									
							</td>

							<td colspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px;
    							font-weight:bold; 
    							background-color: #9da29f; 
    							text-align:center;"><br><br>
    							CONDICIÓN
							</td>
							<td colspan="4"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	14px; 
    							text-align:center;"><br><br>
    							'.$recordset[0][4].'
							</td>
						</tr>
<!--Linea 10-->
						<tr>
							<td colspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px;
    							font-weight:bold;
    							background-color: #9da29f; 
    							text-align:center;">
								CARGO
							</td>

							<td colspan="6"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							text-align:center;">
								'.$recordset[0][3].'
							</td>

							<td colspan="2"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px;
    							background-color: #9da29f;  
    							text-align:center;">
								
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
								CANCELACIÓN DE DÍAS ADICIONALES POR CONCEPTO DE DÍA DE DESCANSO Y/O FERIADO: 
							</td>

						</tr>
<!--Linea 12 -->
						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	12px; 
    							text-align:center;">
								SIGUIENTE(S) FECHAS(S): 
							</td>

						</tr>
<!--Linea 13-->
						'.$linea13.'
<!--Linea 14 -->
						
						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px; 
    							font-weight:bold; 
    							text-align:center;">
							</td>

						</tr>						
<!--Linea 15-->
						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px; 
    							background-color: #9da29f;
    							font-weight:bold; 
    							text-align:center;">
								CON UN RECARGO DEL 150% SOBRE EL SALARIO NORMAL DIARIO, SEGÚN LO ESTABLECIDO EN LA CLÁUSULA NRO.13 DE LA 
								    SEGUNDA CONVENCIÓN COLECTIVA DE EMPLEADOS DE LA DIRECCIÓN EJECUTIVA DE LA MAGISTRATURA. Y 
							</td>

						</tr>
<!--Linea 16-->
						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px;
    							background-color: #9da29f;
    							font-weight:bold;  
    							text-align:center;">
								SEGUN LO ESTABLECIDO EN LA CLÁUSULA N° 33 DE LA 1ERA CONVENCIÓN COLECTIVA DEL PERSONAL OBRERO DE LA 
									DIRECCIÓN EJECUTIVA. (PAGADO FRACCIONADO DE ACUERDO AL NÚMERO DE HORAS LABORADAS) 
							</td>

						</tr>	

<!--Linea 17-->

						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px;
    							background-color: #9da29f;
    							font-weight:bold;  
    							text-align:center;">
								LOS MOTIVOS QUE ORIGINARON EL TRABAJO EN EL (LOS) DÍA(S) ADICIONAL(ES):
							</td>

						</tr>
<!--Linea 18-->

						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px; 
    							text-align:center;">
							</td>

						</tr>
<!--Linea 19-->
						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px; 
    							text-align:center;">
							</td>

						</tr>													
<!--Linea 20-->
						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	10px;
    							background-color: #9da29f;
    							font-weight:bold;  
    							text-align:center;">
    								NÚMERO DE DÍAS LABORADOS
							</td>
						</tr>
<!--LINEA 21-->
						<tr>
							<td colspan="11"
								style=" border: 1px 
								solid black;
    							border-collapse: collapse; 
    							font-size:	16px;
    							text-align:center;
    							font-weight:bold;">
								
								'.$c.'
								
							</td>
						</tr>
<!--Linea 22-->
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
<!--Linea 23-->
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
<!--Linea 24-->
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
<!--Linea 25-->
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
<!--Linea 26-->
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
<!--Linea 27-->
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

<!--Linea 28-->
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
<!--Linea 29-->
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
<!--Linea 30-->
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
<!--Linea 31-->
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
<!--Linea 32-->
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
<!--Linea 33-->
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
<!--Linea 34-->
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