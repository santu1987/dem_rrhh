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
			if($data[$i][8]==2){
				$btn_activar = "<div title='Activar registro' class='btn btn-success' id='btn_estatus_".$data[$i][0]."' name='btn_estatus_".$data[$i][0]."' onclick='activar_reg(".$data[$i][0].",".$x.")'><i id='icono_estatus_".$data[$i][0]."' class='fa fa-check' aria-hidden='true' ></i></div>";
			}else if($data[$i][8]==1){
				$btn_activar = "<div title='Inactivar registro' class='btn btn-danger' id='btn_estatus_".$data[$i][0]."' name='btn_estatus_".$data[$i][0]."' onclick='activar_reg(".$data[$i][0].",".$x.")'><i id='icono_estatus_".$data[$i][0]."' class='fa fa-times' aria-hidden='true' ></i></div>";
			}else if($data[$i][8]==5){
				$btn_activar = "<div disabled title='Activar registro' class='btn btn-success' id='btn_estatus_".$data[$i][0]."' name='btn_estatus_".$data[$i][0]."' onclick='activar_reg(".$data[$i][0].",".$x.")'><i id='icono_estatus_".$data[$i][0]."' class='fa fa-check' aria-hidden='true'  ></i></div>";
			}
			$btn_consultar = "<div title='Seleccionar registro' class='btn btn-info' id='btn_seleccionar_registro' name='btn_seleccionar_registro' onclick='btn_seleccionar_registro(this);' dat='".$data[$i][0]."|".$data[$i][1]."|".$data[$i][2]."|".$data[$i][3]."|".$data[$i][4]."|".$data[$i][5]."|".$data[$i][6]."|".$data[7]."|".$data[$i][8]."|".$data[$i][10]."|".$data[$i][12]."'><i  class='fa fa-search' aria-hidden='true'></i></div>";
			if($data[$i][8]==1){
				$clase_estatus = "bg-success";
			}else if($data[$i][8]==2){
				$clase_estatus = "bg-danger";
			}else if($data[$i][8]==5){
				$clase_estatus = "bg-info";
			}else if($data[$i][8]==4){
				$clase_estatus = "bg-warning";
			}
			$estatus = "<div class=' btn-alerta ".$clase_estatus."' style=''><span>".$data[$i][9]."</span></div>";
			$operacion = $btn_consultar." ".$btn_activar;
			$dic = array(
									"{i}" 	=> $x,
									"{id}" 	=> $data[$i][0],
									"{nombres}" => $data[$i][2],
									"{cedula}"	=>  $data[$i][3],
									"{mes}" => meses_a_letras($data[$i][5]),
									"{motivo}" => $data[$i][6],
									"{total}" => $data[$i][7],
									"{cargo}" => $data[$i][4],
									"{data}"=>$data[$i][0]."|".$data[$i][1]."|".$data[$i][2]."|".$data[$i][3]."|".$data[$i][4]."|".$data[$i][5]."|".$data[$i][6]."|".$data[7]."|".$data[$i][8]."|".$data[$i][10]."|".$data[$i][12]."|".$data[$i][13],
									"{tipo}"=>$data[$i][11],
									"{estatus}"=>$estatus,
									"{operaciones}"=>$operacion,
									"{anio}"=>$data[$i][12],
									"{tab}"=>"fila".$x
						);
			$render.=str_replace(array_keys($dic), array_values($dic), $match_cal);
		}
	}
	$html = str_replace($match_cal, $render, $html);
	return $html;
//----------------------------------------------------------------------------------------	
}
//----------------------------------------------------------------------------------------
//Función para renderización dinámica de tabla de horas extras
function render_list_tabla_consulta_horas_extras($html,$data){
	$match_cal = set_match_identificador_dinamico($html,"<!--row_lista_horas_extras-->");
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
							"{hora_he_fin}"	=>  $hora_fin,
							"{cantidad_he}" => $cant_horas,
							"{motivo}"      => $data[$i][6]
						);
			$render.=str_replace(array_keys($dic), array_values($dic), $match_cal);
		}
	}
	$html = str_replace($match_cal, $render, $html);
	return $html;
}
//----------------------------------------------------------------------------------------
//Para renderizacion de select dinamicos
function render_list_select_departamentos($html,$data){
	$match_cal = set_match_identificador_dinamico($html,"<!--row_lista_departamentos-->");
	$x = 0;
	if($data!="error"){
		//--
		for($i=0;$i<count($data);$i++){
			$dic = array(
							"{i}"  => $x,
							"{id}" => $data[$i][0],
							"{descripcion}" => $data[$i][1]
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
		die($html);
	}
	return $html;
}
//----------------------------------------------------------------------------------------
//--Para renderizacion dinamica
function render_vista_consulta($html,$data){
	$template=get_template($html);
	//$html = render_list($template,$data);//--renderización dinamica
	$arreglo["valore"] = $data["valore"];
	$html = render_estaticos($template,$arreglo);//--renderización estatica
	print $html;
}
//----------------------------------------------------------------------------------------
//--Para renederización dinámica tabla consulta...
function render_vista_consulta_trabajadores($html,$data){
	$template = get_template($html);
	$html = render_list_tabla_consulta($template,$data);
	print $html;
}
//----------------------------------------------------------------------------------------
//--Para renderización dinámica tabla horas extras
function render_vista_consulta_lista_horas_extras($html,$data){
	$template = get_template($html);
	$html = render_list_tabla_consulta_horas_extras($template,$data);
	print $html;
}
//----------------------------------------------------------------------------------------
//--Para renderización dinámica de select de departamentos
function render_vista_consulta_departamentos($html,$data){
	$template = get_template($html);
	$html = render_list_select_departamentos($template,$data);
	print $html;
}
//----------------------------------------------------------------------------------------
?>