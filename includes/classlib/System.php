<?
include_once("mydatetime.php");

define("Browser_undefined",0);
define("Browser_Opera", 1);
define("Browser_FireFox", 2);
define("Browser_Netscape", 3);
define("Browser_MSIE", 4);
define("Browser.MSIEMac", 5);
define("Browser_Dom", 6);
define("Browser_Safari",7);
define("Browser_Konqueror",8);
define("Browser_Lynx", 9);
define("Browser_Bot", 10);

/**
 * Clase para el manejo de funciones base del sistema
 *
 */
class Application
{			
	/**
	 * Escribir texto
	 *
	 * @param String $Cad
	 */
	function Write($Cad)
	{
		echo $Cad;
	}
	
	/**
	 * Escribe texto con un nuevo inicio de linea
	 *
	 * @param String $Cad
	 */
	function WriteLn($Cad = "")
	{
		Application::Write($Cad."<br>");
	}
	
	/**
	 * Escribe una cadena con formato stripslashes
	 *
	 * @param String $Cad
	 */
	function WriteAddSlashes($Cad = "") 
	{
		Application::Write(addslashes($Cad));	
	}

	/**
	 * Escribe una cadena con formato stripslashes
	 *
	 * @param String $Cad
	 */
	function WriteStripSlashes($Cad = "")
	{
		Application::Write(stripcslashes($Cad));	
	}
	
	/**
	 * Imprimir una cadena
	 *
	 * @param String $Cad
	 */
	function Printer($Cad)
	{		
		print $Cad;
	}
	
	/**
	 * Ejecuta una sentencia script
	 *
	 * @param String $Script
	 */
	function ExecuteScript($Script)
	{
		?>
		<script><?Application::Write($Script);?></script>
		<?
	}
	
	/**
	 * Imprimir un cadena con un nuevo inicio de línea
	 *
	 * @param String $Cad
	 */
	function PrinterLn($Cad = "")
	{
		Application::Printer($Cad."<br>");
	}
	
	/**
	 * Redireccionar a otra URL por medio de función PHP
	 *
	 * @param String $url
	 */	
	function getURLPHP($url)
	{	
		header("Location: ".$url);
	}
	
	/**
	 * Ejecuto un comando
	 *
	 * @param String $Cmd
	 */
	function Command($Cmd)
	{
		system($Cmd);
	}
	
	/**
	 * Cambiar la dirección URL según el histórico del navegador
	 *
	 * @param String $pos
	 */
	function history($pos)
	{	
		Application::ExecuteScript("System.History.Go(parseInt('".$pos."'))");		
	}
	
	/**
	 * Enviar un mensaje de alerta a la pantalla
	 *
	 * @param String $str
	 */
	function message($str)
	{	
		$str = addslashes($str);					
		Application::ExecuteScript("alert(\"".$str."\")");		
	}
	
	/**
	 * Redireccionar a otra URL por medio de función JavaScript
	 *
	 * @param String $url
	 */
	function getUrl($url)
	{	
		Application::ExecuteScript("System.getURL('".$url."')");		
		
	}	
	
	/**
	 * Cambiar el texto que tiene un objeto div por ID
	 *
	 * @param unknown_type $mydiv
	 * @param String $msj
	 */
	function updateMsj($mydiv,$msj)
	{	
		Application::ExecuteScript("System.updateMsj('".$mydiv."','".$msj."')");		
	}
	
	/**
	 * Cambiar la imagende un objeto Image por Id
	 *
	 * @param unknown_type $objimg
	 * @param unknown_type $image
	 */
	function updateImg($objimg,$image)
	{	
		Application::ExecuteScript("System.updateImg('".$objimg."','".$image."')");		
	}
	
	/**
	 * Mostrar u ocultar un objeto por su ID
	 *
	 * @param String $objId
	 * @param String $tempvisible
	 */
	function showObjId($objId,$tempvisible)
	{	
		$visible = $tempvisible ? "true" : "false";                                  
		Application::ExecuteScript("System.showObjId('".$objId."',".$visible.")");	
        return $visible;	
	}	
	
	/**
	 * Mestra un mensaje de texto con ícono y un botón
	 *
	 * @param String $icono
	 * @param String $mensaje
	 * @param String $URL
	 */
	function MessageBoxInfo($icono,$mensaje,$URL)
	{
		Application::ShowMessage($icono,$mensaje,$URL,2);
	}
		
	/**
	 * Enviar un mensaje de texto con ícono a la pantalla
	 *
	 * @param String $icono
	 * @param String $mensaje
	 */
	function MessageInfo($icono,$mensaje,$width="93%")
	{			
		Application::ShowMessage($icono,$mensaje,"",1,$width);
	}	
	
	/**
	 * Muestra el mensaje en la pantalla
	 *
	 * @param String $icono
	 * @param String $mensaje
	 * @param Integer $type
	 */
	function ShowMessage($icono,$mensaje, $URL ,$type,$width="93%")
	{
		?>
<!--         <table width="93%" border="0" align="center" cellpadding="0" cellspacing="0"> -->
<!--         <table width="909" border="0" align="center" cellpadding="0" cellspacing="0"> -->
        <table width="<?=$width;?>" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
        <td height="20" align="center" valign="middle" class="stylewhiteL">&nbsp;
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
        <td align="center" valign="middle"><img src="images/site/LeftPoint.gif" width="20" height="20" /></td>
        <td width="100%" align="left" valign="middle" background="images/site/TopBorder.gif" bgcolor="#c60000" class="stylewhiteL">Mensaje</td>
        <td align="center" valign="middle"><img src="images/site/RightPoint.gif" width="20" height="20" /></td>
        </tr>
        </table></td>
        </tr>
        <tr>
        <td class="bodyForm" align="center" valign="middle" background="images/site/center.gif" bgcolor="#EFEFEF">
		<?
		if($type == 1)
			Application::BodyMessageInfo($icono,$mensaje);
		else
			Application::BodyMessageBox($icono,$mensaje,$URL);
		?>
		</td>
        </tr>
        </table>
		<br />
		<?
	}
	
	/**
	 * Cuerpo de MessageInfo
	 *
	 */
	function BodyMessageInfo($icono,$mensaje)
	{
		?>
		<table border="0" align="center" cellpadding="0" cellspacing="6">
        <tr>
        <?
		if($icono != "")
		{	?>
         	<td align="center" valign="top"><img src="<? Application::Write($icono);?>" width="48" height="48" /></td>
            <?
		}
		?>
        <td width="93%" align="left" valign="middle" class="styleblack"><div id="dvmessage"> <? Application::Write($mensaje);?> </div></td>
        </tr>
        </table>
		<?
	}	
	
	/**
	 * Incluyo un archivo .js a la página
	 *
	 * @param String $src
	 */
	function include_js($src)
	{			
		?>
		<script type="text/javascript" src="<? Application::Write($src);?>"></script>
		<?			
	}	
	
	/**
	 * Cuerpo de MessageBox
	 *
	 */
	function BodyMessageBox($icono,$mensaje,$URL)
	{
		?>
		<table border="0" align="center" cellpadding="0" cellspacing="6">
        <tr>
        <?
		if($icono != "")
		{	?>
         	<td align="center" valign="top"><img src="<?  Application::Write($icono);?>" width="48" height="48" /></td>
            <?
		}
		?>
        <td width="93%" align="left" valign="middle" class="styleblack"><div id="dvmessage"> <? Application::Write($mensaje);?> </div></td>
        </tr>
        <tr>
          <td colspan="2" align="center" valign="top">
		  <button class="button" id="atras" title="Anterior" onclick="System.getURL('<? Application::Write($URL);?>'); return false;" type="button" >		  
		  <img src="images/site/button_ok.gif" width="16" height="16" align="absmiddle" />
		  Aceptar
		  </button>					  
		  </td>
          </tr>
        </table>
		<?
	}
	
	/**
	 * Función que te controla los errores del PHP
	 *
	 * @param Integer $nivel
	 */
	function sysErrors($nivel)
	{	
		error_reporting($nivel);	
	}		
	
	/**
	 * Determina cual es el navegador que se esta utilizando
	 *
	 * @return Enum
	 */
	function DetectBrowser()
	{
		$browser = Browser_undefined;
		$UserAgent = strtoupper($_SERVER['HTTP_USER_AGENT']);
   		if((ereg("NAV", $UserAgent) || (ereg("GOLD", $UserAgent)) || (ereg("X11", $UserAgent)) || (ereg("Mozilla", $_SERVER["HTTP_USER_AGENT"])) || (ereg("Netscape", $_SERVER["HTTP_USER_AGENT"])) AND (!ereg("MSIE", $UserAgent) AND (!ereg("KONQUEROR", $UserAgent))))) 
   			if(ereg("FIREFOX", $UserAgent))
   				$browser = Browser_FireFox;	
   			else 
   				$browser = Browser_Netscape;
  		else
			if(ereg("MSIE", $UserAgent)) 
				$browser = Browser_MSIE;
  			else
				if(ereg("LYNX", $UserAgent))
					$browser = Browser_Lynx;
  				else
					if(ereg("OPERA", $UserAgent))
						$browser = Browser_Opera;
  					else
						if(ereg("KONQUEROR", $UserAgent)) 
							$browser = Browser_Konqueror;
  						else
							if((eregi("BOT", $UserAgent)) || (ereg("GOOGLE", $UserAgent)) || (ereg("SLURP", $UserAgent)) || (ereg("SCOOTER", $UserAgent)) || (eregi("SPIDER", $UserAgent)) || (eregi("INFOSEEK", $UserAgent))) 
								$browser = Browser_Bot;
		return $browser;
   }  
}//class

/**
 * Arreglo que guarda los src's
 */
$ScriptSrc = array();

/**
 *	Incluir archivo javascxript en proyecto
 *
 * @param String $src
 */
function include_js($src)
{	
	global $ScriptSrc;		
	array_push($ScriptSrc,$src);
}
?>