<?
include_once("mysql.php");

class dbconexion extends mysql
{	
	function dbconexion($dbase = null,$host = null,$usuario = null,$pass = null)
	{	
		parent::mysql($dbase,$host,$usuario,$pass);
	}
}
?>