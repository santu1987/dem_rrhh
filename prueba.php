<?php
require_once('core/conex.php');
/*$bd = new Conex();
$sql = "SELECT * FROM tbl_idiomas";
$rs = $bd->procesarQuery($sql);
if($rs!="error"){
	for($i =0;$i<count($rs);$i++)
	{
		echo " Idioma= ".$rs[$i][1]."<br>";
	}
}*/
class prueba extends Conex
{
	public function consultar_idioma()
	{
		$sql = "SELECT * FROM tbl_idiomas";
		$rs = $this->procesarQuery($sql);
		if($rs!="error"){
			for($i =0;$i<count($rs);$i++)
			{	
				echo " Idioma= ".$rs[$i][1]."<br>";
			}
		}
	}	
}
$objeto = new prueba();
$objeto->consultar_idioma();
?>