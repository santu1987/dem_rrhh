<?php
session_start();
//conexion de bd 
abstract class Conex
{
		private $conexion;
		private static $servidor="localhost";
		private static $clave="123456";
		private static $usuario="postgres";
		private static $bd="bd_horas_extras";
		//private $bd="espacio_v_blanco";
		protected $query;
		public $arreglo = array();
		public  $sql="";

		//-- Metodo constructor*/
		public function __construct()
		{
			$this->query="";
		}
		//-- Metodo que permite conectarse a la bd en mysql
		private function conectar()
		{
			//valido la sesion antes de conectar
			$this->conexion=pg_connect('host='.self::$servidor. ' port=5432'. ' dbname='.self::$bd. ' user='.self::$usuario.' password='.self::$clave);
			if($this->conexion)
			{
				return 'SI';
			}
			else
			{
				return 'NO';
			}	
		}
		//--Metodo que cierra la conexion a la bd
		private function desconectar()
		{

		}
		//
		//-- Metodo que permite ejecutar un query
		protected function enviarQuery($sql)
		{
			$this->conectar();
			$this->query = pg_query($sql);
			return $this->query;
		}
		//-- Vectoriza el resultado de una consulta
		protected function vectorizar($result)
		{
			return pg_fetch_row($this->query);
		}
		//--Para Consultas
		protected function execute($sql)
		{
			$result = $this->enviarQuery($sql);
			if($result){
				$arr = array();
				while($row = $this->vectorizar($result)){
					$arr[] = $row;
				}
			}else{
				$arr = "error";
			}
			return $arr;
		}
		//--Para procesar consultas
		protected function procesarQuery($sql)
		{
			$this->conectar();
			$rs = $this->execute($sql);
			return $rs;
		}
		//--Para procesar insert, updare, delete
		protected function procesarQuery2($sql)
		{
			$this->conectar();
			$rs = $this->enviarQuery($sql);
			return $rs;
		}
}
?>