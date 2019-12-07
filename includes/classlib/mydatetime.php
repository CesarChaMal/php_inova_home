<?
include_once("datetime_now.php");

//*************************************************************************************************
//**************Clase para el manejo de formatos de fecha***************************************
//*************************************************************************************************

/**
 * Meses del año
 *
 */
define("DATETIME_ENERO",1);
define("DATETIME_FEBRERO",2);
define("DATETIME_MARZO",3);
define("DATETIME_ABRIL",4);
define("DATETIME_MAYO",5);
define("DATETIME_JUNIO",6);
define("DATETIME_JULIO",7);
define("DATETIME_AGOSTO",8);
define("DATETIME_SEPTIEMBRE",9);
define("DATETIME_OCTUBRE",10);
define("DATETIME_NOVIEMBRE",11);
define("DATETIME_DICIEMBRE",12);

/**
 * Días de la semana
 *
 */
define("DATETIME_DOMINGO",0);
define("DATETIME_LUNES",1);
define("DATETIME_MARTES",2);
define("DATETIME_MIERCOLES",3);
define("DATETIME_JUEVES",4);
define("DATETIME_VIERNES",5);
define("DATETIME_SABADO",6);

class MyDateTime
{		
	var $Hour = null;
	var $Minute = null;
	Var $Seconds = null;
	var $Day = null;
	var $Mounth = null;
	var $Year = null;			
			
	/**
	 * Constructor del objeto
	 *
	 * @param unknown_type $Hour
	 * @param unknown_type $Min
	 * @param unknown_type $Seconds
	 * @param unknown_type $Day
	 * @param unknown_type $Mounth
	 * @param unknown_type $Year
	 * @return dateTime
	 */
	function MyDateTime($Hour = 0, $Min = 0, $Seconds = 0, $Day = 0, $Mounth = 0, $Year = 0)
	{
		$this->Hour = $Hour;
		$this->Minute = $Min;
		$this->seconds = $Seconds;
		$this->Day = $Day;
		$this->Mounth = $Mounth;
		$this->Year = $Year;	
	}	
	
	/**
	 * Fecha actual del istema
	 *
	 * @return Datetime_Now
	 */
	function Now()
	{
		return Datetime_Now;
	}
		
	/**
	 * Regreso una fecha en formato standart
	 *
	 */
	function GetFormatStandart()
	{		
		return ($this->Day."/".$this->Mounth."/".$this->Year);
	}
			
	/**
	 * Regreso la fecha en formato MySQL
	 *
	 * @return unknown
	 */
	function GetFormatMySQL()
	{
//        if(!($this->Mounth>=10))
//            $this->Mounth ='0'.$this->Mounth;
//        if(!($this->Day>=10))
//            $this->Day ='0'.$this->Day;
        $this->Year = $this->Year==NULL?'0000':$this->Year;
        $this->Mounth = $this->Mounth==NULL?'00':$this->Mounth;
        $this->Day = $this->Day==NULL?'00':$this->Day;
        $this->Hour = $this->Hour==NULL?'00':$this->Hour;
        $this->Minute = $this->Minute==NULL?'00':$this->Minute;
		return ($this->Year."-".$this->Mounth."-".$this->Day." ".$this->Hour.":".$this->Minute);
	}	
	
	/**
	 * Obtengo el nombre de un mes 
	 *
	 */
	function GetNameMounth()
	{			
		$Name = "";
		switch ($this->Mounth) 
		{
			case DATETIME_ENERO:
				$Name =	"Enero";
				break;
			case DATETIME_FEBRERO:
				$Name =	"Febrero";
				break;
			case DATETIME_MARZO:
				$Name =	"Marzo";
				break;
			case DATETIME_ABRIL:
				$Name =	"Abril";
				break;
			case DATETIME_MAYO:
				$Name =	"Mayo";
				break;
			case DATETIME_JUNIO:
				$Name =	"Junio";
				break;	
			case DATETIME_JULIO:
				$Name =	"Julio";
				break;	
			case DATETIME_AGOSTO:
				$Name =	"Agosto";
				break;		
			case DATETIME_SEPTIEMBRE:
				$Name =	"Septiembre";
				break;	
			case DATETIME_OCTUBRE:
				$Name =	"Octubre";
				break;	
			case DATETIME_NOVIEMBRE:
				$Name =	"Noviembre";
				break;	
			case DATETIME_DICIEMBRE:
				$Name =	"Diciembre";
				break;	
		}
		
		return $Name;
	}
	
	/**
	 * Determina si un año es bisisesto
	 *
	 * @return unknown
	 */
	function IsYearBis()
	{		
		return date("L",$this->GetMKTime()) == 1 ? true : false;	
	}
	
	/**
	 * Número de día de la semana
	 *
	 * @return unknown
	 */
	function GetWeekDay()
	{
		return date("w",$this->GetMKTime());
	}
	
	/**
	 * Obtengo el nombre del día de la semana
	 *
	 * @return unknown
	 */
	function GetWeekNameDay()
	{
		$Name = "";
		switch ($this->GetWeekDay())	
		{
			case DATETIME_DOMINGO:
				$Name = "Domingo";
				break;			
			case DATETIME_LUNES:
				$Name = "Lunes";
				break;
			case DATETIME_MARTES:
				$Name = "Martes";
				break;
			case DATETIME_MIERCOLES:
				$Name = "Miercoles";
				break;
			case DATETIME_JUEVES:
				$Name = "Jueves";
				break;
			case DATETIME_VIERNES:
				$Name = "Viernes";
				break;
			case DATETIME_SABADO:
				$Name = "Sábado";
				break;				
		}
		
		return $Name;
	}
		
	/**
	 * Devuelvo el número de días que tiene un mes
	 *
	 * @return unknown
	 */
	function GetNumDaysToMounth()
	{	
		$NumDays = 0;
		switch ($this->Mounth) 
		{
			case DATETIME_ENERO:
				$NumDays = 31;
				break;
			case DATETIME_FEBRERO:
				$NumDays = !$this->IsYearBis() ? 28 : 29;
				break;
			case DATETIME_MARZO:
				$NumDays = 31;
				break;
			case DATETIME_ABRIL:
				$NumDays = 30;
				break;
			case DATETIME_MAYO:
				$NumDays = 31;
				break;
			case DATETIME_JUNIO:
				$NumDays = 30;
				break;
			case DATETIME_JULIO:
				$NumDays = 31;
				break;
			case DATETIME_AGOSTO:
				$NumDays = 31;
				break;
			case DATETIME_SEPTIEMBRE:
				$NumDays = 30;
				break;
			case DATETIME_OCTUBRE:
				$NumDays = 31;
				break;
			case DATETIME_NOVIEMBRE:
				$NumDays = 30;
				break;
			case DATETIME_DICIEMBRE:
				$NumDays = 31;		
				break;			
		}
		
		return $NumDays;
	}			
	
	/**
	 * Regreso el valor MKTime del objeto
	 *
	 * @return unknown
	 */
	function GetMKTime()
	{
		return mktime($this->Hour, $this->Minute, $this->Seconds, $this->Mounth, $this->Day, $this->Year);
	}
}
?>