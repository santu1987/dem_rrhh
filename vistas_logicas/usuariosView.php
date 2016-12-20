
<?php
require("../core/fbasic.php");
//--Armo diccionario 
function render_list($html,$data){
//---------------------------------------------------------------------------------------

	$match_cal = set_match_identificador_dinamico($html,"<!--row_usuarios-->");
	if($data!="error"){
		//--
		for($i=0;$i<count($data);$i++){
			//--Armando botones:
			if($data[$i][4]==2){
				$btn_activar = "<div title='Activar usuario' class='btn btn-danger' id='btn_estatus_".$data[$i][0]."' name='btn_estatus_".$data[$i][0]."' onclick='activar_us(".$data[$i][0].")'><i id='icono_estatus_".$data[$i][0]."' class='fa fa-unlock' aria-hidden='true' ></i></div>";
				$estatus ="<div id='div_estatus_".$data[$i][0]."'>Inactivo</div>";
			}else if($data[$i][4]==1){
				$btn_activar = "<div title='Inactivar usuario' class='btn btn-success' id='btn_estatus_".$data[$i][0]."' name='btn_estatus_".$data[$i][0]."' onclick='activar_us(".$data[$i][0].")'><i id='icono_estatus_".$data[$i][0]."' class='fa fa-lock' aria-hidden='true' ></i></div>";
				$estatus ="<div id='div_estatus_".$data[$i][0]."'>Activo</div>";
			}
			$btn_consultar = "<div title='Consultar usuario' class='btn btn-info' id='btn_consultar_usuario' name='btn_consultar_usuario' onclick='consultar_usuario(".$data[$i][0].");'><i  class='fa fa-search' aria-hidden='true'></i></div>";
			$operacion = $btn_consultar." ".$btn_activar;
			$dic = array(
									"{i}" 	=> $i,
									"{id}" 	=> $data[$i][0],
									"{login}" => $data[$i][1],
									"{id_tipo_us}"	=>  $data[$i][2],
									"{tipo_us}" => $data[$i][3],
									"{tab}" => "tab".$data[$i][0],
									"{data}"=>$data[$i][0]."|".$data[$i][1]."|".$data[$i][2]."|".$data[$i][3]."|".$data[$i][4],
									"{operacion}"=>$operacion,
									"{estatus}"=>$estatus
						);
			$render.=str_replace(array_keys($dic), array_values($dic), $match_cal);
		}
	}
	$html = str_replace($match_cal, $render, $html);
	return $html;
//----------------------------------------------------------------------------------------	
}
//--Para renderización estática
/*function render_estaticos($html,$data){
	foreach ($data as $clave => $valor) {
		$html = str_replace('{'.$clave.'}', $valor, $html);
	}
	return $html;
}*/
//----------------------------------------------------------------------------------------
//--Para renderizacion dinamica
function render_vista_consulta($html,$data){
	$template=get_template($html);
	$html = render_list($template,$data);//--renderización dinamica
	//$html = render_estaticos($html,$arr_pag);//--renderización estatica
	print $html;
	//die("aaa");
	//die($html);
}
//----------------------------------------------------------------------------------------
?>