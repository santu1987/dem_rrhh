<?php
function get_template($form){
	$file = $_SERVER['DOCUMENT_ROOT'].'/dem_horas_extras/site_media/templates/'.$form.'.html';
	$template = file_get_contents($file);
	return $template;
}
//--Función que permite delimitar la sección de la página en la que se realizará la sustitutción
function set_match_identificador_dinamico($html,$identificador){
    $ini = strpos($html,$identificador);
    $fin = strpos($html,$identificador,$ini+1);
    $len = strlen($identificador);
    $cal = substr($html,($ini+$len),($fin-$len-$ini));
    return $cal;
}

//--Función que permite el calculo de limites dentro de la paginación
function calculo_limites($offset,$cuantos_son,$tipo){
	$inicio_tabla = $offset+1;
	//--Valido que si $offset=0 se inicie la tabla en valor 0
	$valor = $offset+20;
	if($valor >= $cuantos_son)
		$fin_tabla = $cuantos_son;
	else
		$fin_tabla = $valor;		
	if($cuantos_son==0){
		$inicio_tabla = 0;
	}
	$dicc_tabla = array(
							"inicio_tabla" => $inicio_tabla,
							"fin_tabla" => $fin_tabla
	);
	return $dicc_tabla;
}

//--Función que permite armar paginación en las consultas
function armar_paginacion($cuantos_son,$vector){
	//--Validación de cuantos_son
	if(($vector['cuantos_son']==0)||($vector['tipo']==3))
	{
		$cuantos_son_tabla = $cuantos_son;
	}				
	else
		$cuantos_son_tabla = $vector['cuantos_son'];//Determino cuantos ticket_son
	//--Calculo de a que página debe ir
	switch ($vector['tipo']){
		case 0:
				$offset = 0;
				///Calculo limites:
				$dic_tabla = calculo_limites($offset,$cuantos_son_tabla,1);
		break;		
		case 1:
				$offset = $vector['actual']+$vector['cuantos_x_pagina'];
				///Calculo limites:
				$dic_tabla = calculo_limites($offset,$cuantos_son_tabla,1);
		break;
		case 2:
				$offset = $vector['actual']-$vector['cuantos_x_pagina'];
				///Calculo limites:
				$dic_tabla = calculo_limites($offset,$cuantos_son_tabla,2);
		break;
		case 3:
				$offset=$vector['actual'];
				//--
				if($vector[0]==$cuantos_son_tabla)
					$offset=0;
				//--
				$dic_tabla = calculo_limites($offset,$cuantos_son_tabla,1);
		break;		
	}
	//--Para ocultar siguiente 
	$offset_sig = $offset+$vector['cuantos_x_pagina'];
	$clase_sig = "";
	if(($offset_sig == $cuantos_son_tabla)||($offset_sig > $cuantos_son_tabla ))
		$clase_sig = "disabled";
	//--Para ocultar anterior
	if($offset == 0)
		$clase_ant = "disabled";
	else
		$clase_ant = "";	
	//--Validar si tiene o no tickets
	if($cuantos_son_tabla>0){
			$clase_tabla = 'show';
			$clase_tickets = 'hide';
	}else{
			$clase_tabla = 'hide';
			$clase_tickets = 'show';
	}
	$diccionario = array(
							"paginador_siguiente"=>"ir_tabla(".$offset.",".$cuantos_son_tabla .",20,1);",
							"paginador_anterior"=>"ir_tabla(".$offset.",".$cuantos_son_tabla .",20,2);",
							"clase_paginador_siguiente"=>$clase_sig,
							"clase_paginador_anterior"=>$clase_ant,
							"offset_tabla"=>$offset,
							"cuantos_tabla"=>$cuantos_son_tabla,
							"inicio_tabla"=>$dic_tabla["inicio_tabla"],
							"fin_tabla"=>$dic_tabla["fin_tabla"],
							"clase_tabla"=>$clase_tabla,
							"clase_tickets"=>$clase_tickets
						);
	return $diccionario;
}

function meses_a_letras($mes){
	switch($mes){
		case '01':
			$nonmes = "Enero";
			break;
		case '02':
			$nonmes =  "Febrero";
			break;
		case '03':
			$nonmes = "Marzo";
			break;
		case '04':
			$nonmes = "Abril";
			break;
		case '05':
			$nonmes = "Mayo";
			break;
		case '06':
			$nonmes = "Junio";
			break;
		case '07':
			$nonmes = "Julio";
			break;
		case '08':
			$nonmes =  "Agosto";
			break;
		case '09':
			$nonmes = "Septiembre";
			break;
		case '10':
			$nonmes = "Octubre";
			break;
		case '11':
			$nonmes = "Noviembre";
			break;
		case '12':
			$nonmes = "Diciembre";
			break;					
	}
	return $nonmes;
}
function armar_mes($mes){
	if($mes<10){
		$mes = "0".$mes;
	}
	return $mes;
}
//--
function registrar_auditoria($id_usuario,$proceso_ejecutado,$tabla_afectada,$id,$descripcion){
	require("../modelos/auditoriaModel.php");
	$obj = new auditoriaModel();
	$arreglo_valor = array();
	$recordset = array();
	$recordset = $obj->guardar_auditoria($id_usuario,get_ip(),$proceso_ejecutado,$tabla_afectada,$id,$descripcion);
	if($recordset==true){
		$arreglo_valor[0] = 1; //registro exitoso...
	}else{
		$arreglo_valor[0] = 0; //ocurrio un error inesperado al guardar...
	}
	return $arreglo_valor;
}
//--
function get_ip(){
        if($_SERVER){
            if($_SERVER["HTTP_X_FORWARDED_FOR"]){
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            }elseif($_SERVER["HTTP_CLIENT_IP"]){
            $realip = $_SERVER["HTTP_CLIENT_IP"];
            }else{
            $realip = $_SERVER["REMOTE_ADDR"];
            }
        }else{
            if (getenv('HTTP_X_FORWARDED_FOR')){
                    $realip = getenv('HTTP_X_FORWARDED_FOR');
            }elseif(getenv('HTTP_CLIENT_IP')){
                    $realip = getenv('HTTP_CLIENT_IP');
            }else{
                    $realip = getenv('REMOTE_ADDR');
            }
        }
        return $realip;
}
//--
//FUNCION QUE TRANSFORMA UN ARREGLO PHP A UNO EN PL/PGSQL
function to_pg_array($set) {
    settype($set, 'array'); // can be called with a scalar or array
    $result = array();
    foreach ($set as $t) {
        if (is_array($t)) {
            $result[] = to_pg_array($t);

        } else {
            $t = str_replace('"', '\\"', $t); // escape double quote
            /*if (! is_numeric($t)) // quote only non-numeric values
                $t = '"' . $t . '"';*/
            $result[] = $t;
        }
    }
    return '{' . implode(",", $result) . '}'; // format
}
//--
?>
