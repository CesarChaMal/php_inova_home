<?
/**
 * Clase para tiempo y fecha actual
 *
 */
class Datetime_Now
{
	/**
	 * Día del més
	 *
	 */
	function GetDay()
	{
		return date("j");
	}
	
	/**
	 * Día del mes en dos dígitos
	 *
	 * @return unknown
	 */
	function GetDigitDay()
	{
		return date("d");
	}
	
	/**
	 * Año del sistema
	 *
	 * @return Integer
	 */
	function GetYear()
	{			
		return date("Y");
	}	
	
	/**
	 * Mes del sistema
	 *
	 * @return Integer
	 */
	function GetMounth()
	{	
		return date("n");		
	}
	
	/**
	 * ´Mes del sistema en dos dígitos
	 *
	 * @return unknown
	 */
	function GetDigitMounth()
	{
		return date("m");		
	}
	
	/**
	 * Dia del mes del sistema
	 *
	 * @return Integer
	 */
	function GetMounthDay()
	{			
		return date("d");
	}
	
	/**
	 * Determina si un año es bisisesto
	 *
	 * @return Boolean
	 */
	function IsYearBis()
	{
		return date("L") == 1 ? true : false;	
	}
	
	/**
	 * Devuelvo el número de días que tiene un mes
	 *
	 * @param Integer $NumMounth
	 */
	function GetNumDaysToMounth($Mounth = -1, $Year = -1)
	{
		$_datetime = new MyDateTime();
				
		$_datetime->Mounth = $Mounth != -1 ? $Mounth : self::GetDigitMounth();		
		$_datetime->Year = $Year != -1 ? $Year : self::GetYear();		
				
		return $_datetime->GetNumDaysToMounth();
	}		
	
	/**
	 *  Obtengo el nombre de un mes 
	 *
	 * @param Integer $Mounth
	 * @return String
	 */
	function GetNameMounth($Mounth = -1)
	{
		$_datetime = new MyDateTime();
		$_datetime->Mounth = $Mounth != -1 ? $Mounth : self::GetDigitMounth();
		return $_datetime->GetNameMounth();
	}
	
	/**
	 * Convertir Fecha de formato AAAA-MM-DD a DD/MM/AAAA
	 *
	 * @param unknown_type $date
	 * @return unknown
	 */	
	function GetFormatStandart($date = "")
	{	
		$dia = "";
		$mes = "";
		$anio = "";	
		
		if($date != "")
		{	
			if(ereg("([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $date, $registers))	
			{
				$dia = $registers[3];
				$mes = $registers[2];
				$anio = $registers[1];
			}			
		}
		else 
		{
			$dia = Datetime_Now::GetDigitDay();
			$mes = Datetime_Now::GetDigitMounth();
			$anio = Datetime_Now::GetYear();	
		}
	
		return ($dia."/".$mes."/".$anio);	
	}
	
	/**
	 * Convertir Fecha de formato DD/MM/AAAA a AAAA-MM-DD
	 *
	 * @param unknown_type $date
	 * @return unknown
	 */
	function GetFormatMySQL($date = "")
	{	
		$dia = "00";
		$mes = "00";
		$anio = "0000";	
		
		if($date != "")
		{	
			if(ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $date, $registers))	
			{
				$dia = $registers[1];
				$mes = $registers[2];
				$anio = $registers[3];
			}			
		}
		else 
		{
			$dia = Datetime_Now::GetDigitDay();
			$mes = Datetime_Now::GetDigitMounth();
			$anio = Datetime_Now::GetYear();	
		}
		
		return ($anio."-".$mes."-".$dia);	
	}			
}

?>