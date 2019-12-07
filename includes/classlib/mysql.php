<?
include_once("ResultSet.php");

if(!defined('Top')) 
	define("Top",0);

if(!defined('Buttom')) 
	define("Buttom",-1);

define("Begin",1);
define("End",2);
define("Abort",3);

define("ER_CANT_FIND_SYSTEM_REC",1012);
define("ER_CANT_GET_STAT",1013);
define("ER_CANT_GET_WD",1014);
define("ER_CANT_LOCK",1015);
define("ER_CANT_OPEN_FILE",1016);
define("ER_FILE_NOT_FOUND",1017);
define("ER_CANT_READ_DIR",1018);
define("ER_CANT_SET_WD",1019);

define("ER_DBACCESS_DENIED_ERROR",1044);
define("ER_ACCESS_DENIED_ERROR",1045);
define("ER_NO_DB_ERROR",1046);
define("ER_UNKNOWN_COM_ERROR",1047);
define("ER_BAD_NULL_ERROR",1048);
define("ER_BAD_DB_ERROR",1049);
define("ER_TABLE_EXISTS_ERROR",1050);
define("ER_BAD_TABLE_ERROR",1051);
define("ER_NON_UNIQ_ERROR",1052);
define("ER_SERVER_SHUTDOWN",1053);
define("ER_BAD_FIELD_ERROR",1054);
define("ER_WRONG_FIELD_WITH_GROUP",1055);
define("ER_WRONG_GROUP_FIELD",1056);

define ("ER_DUP_ENTRY",1062);
define ("ER_PARSE_ERROR",1064);
define("ER_NO_SUCH_TABLE",1146);
define("ER_DATA_TOO_LONG",1406);

define("CR_UNKNOWN_ERROR",2000);
define("CR_SOCKET_CREATE_ERROR",2001);
define("CR_CONNECTION_ERROR",2002);
define("CR_CONN_HOST_ERROR",2003);
define("CR_IPSOCK_ERROR",2004);
define("CR_UNKNOWN_HOST",2005);
define("CR_SERVER_GONE_ERROR",2006);
define("CR_VERSION_ERROR",2007);
define("CR_OUT_OF_MEMORY",2008);
define("CR_WRONG_HOST_INFO",2009);
define("CR_LOCALHOST_CONNECTION",2010);
define("CR_TCP_CONNECTION",2010);

/**
 * Clase para conexion y consulta a una base de datos, (por lo pronto solo para mysql)
 *
 */
class mysql
{	
	var $serverConnection;  //conexión con el servidor
	var $IsConnect;    		//Indica si ha una conexión activa con una base de datos	
	var $rowA;            	
	var $names;			  	//Guarda los nombre de las columnas de la última consulta	
	var $numerror;		  	//múmero de error del mysql de la última consulta
	var $MessageRealError;	//Mensaje original de error del servidor Mysql
	
	/**
	 * Constructor del objeto
	 *
	 * @param String $dbase
	 * @param String $host
	 * @param String $usuario
	 * @param String $pass
	 * @return mysql
	 */
	function mysql($dbase = null,$host = null,$usuario = null,$pass = null)
	{	
		$this->serverConnection = 0;
		$this->IsConnect = 0;		
		$this->numrows = 0;
		$this->numcols = 0;
		$this->DataSourse = 0;		
		
		if(!is_null($dbase) && !is_null($host) && !is_null($usuario) && !is_null($pass))
			$this->createdbconnection($dbase,$host,$usuario,$pass);
	}
	
	/**
	 * Crea una conexiona la base de datos y abre la base de datos
	 *
	 * @param String $dbase
	 * @param String $host
	 * @param String $usuario
	 * @param String $pass
	 * @return Boolean
	 */
	function createdbconnection($dbase,$host,$usuario,$pass)
	{	
		$this->serverConnection = mysql_connect($host,$usuario,$pass);
		if($this->serverConnection)
		{	
			$this->IsConnect = mysql_select_db($dbase,$this->serverConnection);
			if($this->IsConnect)			
				return true;
			else			
			{
				$this->numerror = mysql_errno($this->serverConnection);				
				$this->MessageRealError = mysql_error($this->serverConnection);
				return false;
			}
		}
		else
		{	$this->numerror = mysql_errno();				
			$this->MessageRealError = mysql_error($this->serverConnection);
			return false;
		}
	}	
	
	/**
	 * Executo una operación de actualizado a la base de datos (Insert, Update, Delete, entre otros)
	 *
	 * @param Boolean $str
	 */
	function executeUpdate($str)
	{	
		if($this->IsConnect)
			if(mysql_query($str,$this->serverConnection))
				return true;			
			else
			{
				$this->numerror = mysql_errno($this->serverConnection);
				$this->MessageRealError = mysql_error($this->serverConnection);
				return false;		
			}
		else 
			return false;		
	}
			
	/**
	 * Ejecuta una consulta SQl y devuelve un objeto ResultSet
	 *
	 * @param String $str
	 * @return ResultSet
	 */
	function executeQuery($str)
	{	
		$rs = new ResultSet();
		$rs->DataSourse = null;
	
		$str = trim($str);
		if($this->IsConnect)
		{	
			if($DataSourse = mysql_query($str,$this->serverConnection))
				$rs->DataSourse	= $DataSourse;							
			else
			{	
				$this->numerror = mysql_errno($this->serverConnection);
				$this->MessageRealError = mysql_error($this->serverConnection);
			}
		}
		return $rs;		
	}
	
	/**
	 * Borro la última consulta de mi objeto
	 *
	 */
	function closeQuery()
	{	
		if($this->IsConnect && $this->DataSourse)
		{	
			mysql_free_result($this->DataSourse);	
			$this->numrows = 0;
			$this->numcols = 0;
		}
	}	
	
	/**
	 * Cierra una conexión ya abierta
	 *
	 */
	function closedbconnection()
	{	
		if($this->serverConnection)
		{	
			mysql_close($this->serverConnection);
			$this->serverConnection = 0;
		}		
	}	
	
	/**
	 * Operaciones para transacciones
	 *
	 * @param integer $operacion
	 * @return bool
	 */
	function transaction($operacion)
	{	
		if($this->IsConnect)				
		{	
			$Query = "";
			switch($operacion)
			{	
				case Begin:
					$Query = "start transaction"; //Iniciar de una transacción.
					break;
				case End:
					$Query = "commit";            //Cometer una transacción
					break;
				case Abort:
					$Query = "rollback";		  //Abortar una transacción.
					break;
				default:
					return false;
			}
			$this->DataSourse = mysql_query($Query);
			if($this->DataSourse)
				return true;
			else
			{	
				$this->numerror = mysql_errno($this->serverConnection);		
				$this->MessageRealError = mysql_error($this->serverConnection);		
				return false;	
			}	
		}
		else
			return false;				
	}
	
	/**
	 * Abrir una transacción
	 *
	 */
	function BeginTransaction()
	{	
		$this->transaction(Begin);		
	}
	
	/**
	 * Cerrar una transacción
	 *
	 */
	function EndTransaction()
	{
		$this->transaction(End);
	}
	
	/**
	 * Abortar una transacción
	 *
	 */
	function RollBack()
	{	
		$this->transaction(Abort);
	}
	
	/**
	 * Devuelve el tipo de error ocurrido en el proceso de conexiónen texto
	 *
	 * @return integer
	 */
	function getnumError()
	{	
		if($this->IsConnect && $this->DataSourse)
			return $this->numerror;
	}
	
	/**
	 * Devuelve el error según su número
	 *
	 * @param integer $numerror
	 * @return string
	 */
	function getmsjError($numerror = -1)
	{	
		$numerror = ($numerror != -1? $numerror: $this->numerror);
		$msj = "";		
	
		switch ($numerror)	
		{	
			case ER_CANT_FIND_SYSTEM_REC:
				$msj = "No puedo leer el registro en la tabla del sistema";
				break;
			case ER_CANT_GET_STAT:
				$msj = "No puede obtener el estado";
				break;
			case ER_CANT_GET_WD:	
				$msj = " No puedo acceder al directorio";
				break;
			case ER_CANT_LOCK:	
				$msj = "No puedo bloquear el archivo";
				break;
			case ER_CANT_OPEN_FILE:	
				$msj = "No puedo abrir archivo";
				break;
			case ER_FILE_NOT_FOUND:	
				$msj = "No puedo encontrar archivo";
				break;
			case ER_CANT_READ_DIR:	
				$msj = "No puedo leer el directorio";
				break;
			case ER_CANT_SET_WD:	
				$msj = "No puedo cambiar al directorio";							
				break;				
			case ER_DBACCESS_DENIED_ERROR:	
				$msj = "Acceso negado del usuario para la base de datos especificada";	
				break;
			case ER_ACCESS_DENIED_ERROR:	
				$msj = "Acceso negado para usuario de la base de datos con el usuario y clave especificada";	
				break;
			case ER_NO_DB_ERROR:	
				$msj = "Base de datos no seleccionada";	
				break;
			case ER_UNKNOWN_COM_ERROR:	
				$msj = "Comando desconocido";	
				break;
			case ER_BAD_NULL_ERROR:	
				$msj = "La columna no puede ser nula";	
				break;
			case ER_BAD_DB_ERROR:	
				$msj = "Base de datos desconocida";	
				break;
			case ER_TABLE_EXISTS_ERROR:	
				$msj = "La tabla ya existe";	
				break;
			case ER_BAD_TABLE_ERROR:	
				$msj = "Tabla desconocida";	
				break;
			case ER_NON_UNIQ_ERROR:	
				$msj = "Ambigüedad entre columnas";	
				break;
			case ER_SERVER_SHUTDOWN:	
				$msj = "Desconexion de servidor en proceso";					
				break;
			case ER_BAD_FIELD_ERROR:	
				$msj = "La columna especificada es desconocida";	
				break;
			case ER_WRONG_FIELD_WITH_GROUP:	
				$msj = "Usado un campo el cual no esta group by";	
				break;
			case ER_WRONG_GROUP_FIELD:	
				$msj = "No puedo agrupar por el campo especificado";	
				break;
			case ER_DUP_ENTRY:
				$msj = "Entrada de datos duplicada";	
				break;
			case CR_UNKNOWN_ERROR:
				$msj = "Error del manjador de base de datos descpnpcido";	
				break;
			case CR_SOCKET_CREATE_ERROR:
				$msj = "No se puede crear el socket UNIX especificado";	
				break;
			case CR_CONNECTION_ERROR:
				$msj = "No se puede conectar al servidor de base de datos local en el socket específico";	
				break;
			case CR_CONN_HOST_ERROR:
				$msj = "No se puede conectar al servidor de base de datos especificado";	
				break;
			case CR_IPSOCK_ERROR:
				$msj = "No se puede el socket TCP/IP especificado";	
				break;
			case CR_UNKNOWN_HOST:
				$msj = "No se reconoce el host especificado";	
				break;
			case CR_SERVER_GONE_ERROR:
				$msj = "El servidor de base de datos no esta disponible";	
				break;
			case CR_VERSION_ERROR:
				$msj = "Error en la compatibilidad de versión del protocolo con el servidor y el cliente";	
				break;
			case CR_OUT_OF_MEMORY:
				$msj = "El cliente del manejador de la base de datos se ha debordado";	
				break;						
			case CR_WRONG_HOST_INFO:
				$msj = "Información del host equivocado";	
				break;
			case CR_LOCALHOST_CONNECTION:
				$msj = "Error en socket LINUX del host local";	
				break;
			case CR_TCP_CONNECTION:
				$msj = "Error en el protocolo TCP/IP";	
				break;				
			case ER_PARSE_ERROR:
				$msj = "Error de sintaxis, los campos se encuentran cercanos o no se encuentran limitados";	
				break;
			case ER_NO_SUCH_TABLE:
				$msj = "La tabla especificada no existe";	
				break;				
			case ER_DATA_TOO_LONG:
				$msj = "Los datos requieren también de otra columna o la columna no tiene el espacio suficiente";	
				Break;
			default:
				$msj = $this->MessageRealError;
		}
		return $msj;
	}	
}//Fin clase
?>