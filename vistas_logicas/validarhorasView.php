<?php
require("../core/fbasic.php");
//--Armo diccionario para render de lista de horas extras pro trabajador
function render_list_tabla_consulta($html,$data){
//----------------------------------------------------------------------------------------
	$match_cal = set_match_identificador_dinamico($html,"<!--row_horas_extras-->");
	$x = 0;
	if($data!="error"){
		//--
		for($i=0;$i<count($data);$i++){
			//--Armando botones:
			$x++;
			if($data[$i][8]!=5){
				$btn_activar = "<div title='Aprobar registro' class='btn btn-success' id='btn_estatus_".$data[$i][0]."' name='btn_estatus_".$data[$i][0]."' onclick='aprobar_reg(".$data[$i][0].",".$x.",".$data[$i][14].")'><i id='icono_estatus_".$data[$i][0]."' class='fa fa-check' aria-hidden='true' ></i></div>";
				$opcion_habilitado = "disabled";
			}else{ 
				$btn_activar = "<div title='Desaprobar registro' class='btn btn-danger' id='btn_estatus_".$data[$i][0]."' name='btn_estatus_".$data[$i][0]."' onclick='aprobar_reg(".$data[$i][0].",".$x.",".$data[$i][14].")'><i id='icono_estatus_".$data[$i][0]."' class='fa fa-times' aria-hidden='true' ></i></div>";
					$opcion_habilitado = "";
			}
			$btn_consultar = "<div title='Seleccionar registro' class='btn btn-info' id='btn_seleccionar_registro' name='btn_seleccionar_registro' onclick='btn_seleccionar_registro_validar(this);' dat='".$data[$i][0]."|".$data[$i][1]."|".$data[$i][2]."|".$data[$i][3]."|".$data[$i][4]."|".$data[$i][5]."|".$data[$i][6]."|".$data[7]."|".$data[$i][8]."|".$data[$i][10]."|".$data[$i][12]."'><i  class='fa fa-search' aria-hidden='true'></i></div>";
			if($data[$i][8]!=5){
				$clase_estatus = "bg-danger";
				$valor_estatus = "No validado";
			}else{
				$clase_estatus = "bg-success";
				$valor_estatus = "Validado";
			}
			if($data[$i][10]=="3"){
				$btn_pdf = "<div ".$opcion_habilitado." title='Generar PDF' class='btn btn-warning' id='btn_imprimir_registro".$data[$i][0]."' name='btn_imprimir_registro' onclick='btn_imprimir_planilla_dia_extra(".$data[$i][0].");'><i  class='fa fa-file-pdf-o' aria-hidden='true'></i></div>";
			}else{
				$btn_pdf = "<div ".$opcion_habilitado." title='Generar PDF' class='btn btn-warning' id='btn_imprimir_registro".$data[$i][0]."' name='btn_imprimir_registro' onclick='btn_imprimir_registro(".$data[$i][0].");'><i  class='fa fa-file-pdf-o' aria-hidden='true'></i></div>";
			}
			$estatus = "<div class=".$clase_estatus." style='padding: 6%'><span>".$valor_estatus."</span></div>";
			$operacion = $btn_consultar." ".$btn_activar." ".$btn_pdf;
			$mes = meses_a_letras($data[$i][5]);
			$dic = array(
									"{i}" 	=> $x,
									"{id}" 	=> $data[$i][0],
									"{nombres}" => $data[$i][2],
									"{cedula}"	=>  $data[$i][3],
									"{mes}" => $mes,
									"{motivo}" => $data[$i][6],
									"{total}" => $data[$i][7],
									"{cargo}" => $data[$i][4],
									"{data}"=>$data[$i][0]."|".$data[$i][1]."|".$data[$i][2]."|".$data[$i][3]."|".$data[$i][4]."|".$data[$i][5]."|".$data[$i][6]."|".$data[7]."|".$data[$i][8]."|".$data[$i][10]."|".$data[$i][12],
									"{tipo}"=>$data[$i][11],
									"{estatus}"=>$estatus,
									"{operaciones}"=>$operacion,
									"{anio}"=>$data[$i][12],
									"{tab}"=>"fila".$x,
									"{unidad}"=>$data[$i][13]
						);
			$render.=str_replace(array_keys($dic), array_values($dic), $match_cal);
		}
	}
	$html = str_replace($match_cal, $render, $html);
	return $html;
//----------------------------------------------------------------------------------------	
}
//--Armo diccionario para detalle de tabla de consulta de horas...
function render_list_tabla_detalle($html, $data){
	$match_cal = set_match_identificador_dinamico($html,"<!--row_horas_extras_lista-->");
	$x = 0;
	if($data!="error"){
	//--
		for($i=0;$i<count($data);$i++){
			$x = $i+1;
			//--Hora inicio
			$hora = explode(":",$data[$i][3]);
			$hora_ini = $hora[0].":".$hora[1];
			//-- Hora fin 
			$hora2 = explode(":",$data[$i][4]);
			$hora_fin = $hora2[0].":".$hora2[1];
			//-- Cantidad horas
			$hora3 = explode(":",$data[$i][5]);
			$cant_horas = $hora3[0].":".$hora3[1];

			$dic = array(
							"{i}" 	=> $x,
							"{fecha_he}" 	=> date("d/m/Y", strtotime($data[$i][2])),
							"{hora_he_ini}" => $hora_ini,
							"{hora_he_fin}"	=> $hora_fin,
							"{cantidad_he}" => $cant_horas
						);
			$render.=str_replace(array_keys($dic), array_values($dic), $match_cal);
		}
	//--	
	}
	$html = str_replace($match_cal, $render, $html);
	return $html;
}
//----------------------------------------------------------------------------------------
//--Para renderización estática
function render_estaticos($html,$data){
	foreach ($data as $clave => $valor) {
		$html = str_replace('{'.$clave.'}', $valor, $html);
	}
	return $html;
}
//----------------------------------------------------------------------------------------
//--Para renederización dinámica tabla consulta...
function render_vista_consulta_trabajadores($html,$data){
	$template = get_template($html);
	$html = render_list_tabla_consulta($template,$data);
	print $html;
}
//--Para generar renderización dinámica de detalle 
/*function render_list_formulario($html,$data_detalle){
	//$template = get_template($html);
	$html = render_list_tabla_detalle($template,$data_detalle);
	print $html;
}*/
//----------------------------------------------------------------------------------------
//--Para generar arreglo del encabezado
function generar_arreglo_encabezado($data_encabezado){
	$arreglo_encabezado2["cedula_trabajador"] = $data_encabezado[0][3];
	$arreglo_encabezado2["nombre_trabajador"] = $data_encabezado[0][2];
	$arreglo_encabezado2["cargo_trabajador"] = $data_encabezado[0][4];
	$arreglo_encabezado2["mes_trabajador"] = meses_a_letras($data_encabezado[0][5]);
	$arreglo_encabezado2["motivo_he"] = $data_encabezado[0][6];
	$arreglo_encabezado2["total_horas"] = $data_encabezado[0][7];
	if($data_encabezado[0][10]=="1"){
		$arreglo_encabezado2["opcion_dia"] = "invisible";
		$arreglo_encabezado2["opcion_sol"] = "visible";
		$arreglo_encabezado2["opcion_luna"] = "invisible"; 
	}else if($data_encabezado[0][10]=="2"){
		$arreglo_encabezado2["opcion_dia"] = "invisible";
		$arreglo_encabezado2["opcion_sol"] = "invisible";
		$arreglo_encabezado2["opcion_luna"] = "visible";
	}else if($data_encabezado[0][10]=="3"){
		$arreglo_encabezado2["opcion_dia"] = "visible";
		$arreglo_encabezado2["opcion_sol"] = "invisible";
		$arreglo_encabezado2["opcion_luna"] = "invisible";
	}
	return $arreglo_encabezado2;
}
//----------------------------------------------------------------------------------------
//--Para renderización de formulario de consulta
function render_vista_formulario_he($html,$data_encabezado){
	$template = get_template($html);
	$arreglo_encabezado = generar_arreglo_encabezado($data_encabezado);
	$html = render_estaticos($template,$arreglo_encabezado);
	return $html;
}
//----------------------------------------------------------------------------------------
//--Para renderización dinámica de formulario de consulta
function render_vista_dinamica_formulario_he($html,$data_detalle){
	$html= render_list_tabla_detalle($html,$data_detalle);
	print $html;
}
//----------------------------------------------------------------------------------------
?>