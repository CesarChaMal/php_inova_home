<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<body>

<?
include_once("includes/classlib.php");
include_once("includes/datoscon.php");
?>

<form action="" method="post" name="frmConsulta" target="_parent" id="frmConsulta">
  <label></label>
  <table width="90%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td>Consulta a probar: </td>
    </tr>
    <tr>
      <td align="center" valign="middle">
	  <textarea name="query" rows="20" id="query" style="width:100%;"><? Application::WriteStripSlashes(isset($_POST["query"]) ? $_POST["query"] : ""); ?></textarea>
	  </td>
    </tr>
    <tr>
      <td align="center" valign="middle"><label>
        <input name="ejecutar" type="submit" id="ejecutar" value="Executar consulta" />
      </label></td>
    </tr>
    <tr>
      <td align="left" valign="top">
		<?
		if(isset($_POST["query"]))
		{				
			$con = new dbconexion(database,host,user,pass);
			if($con)
			{
				$rs = new ResultSet();		
				$rs = $con->executeQuery(stripcslashes($_POST["query"]));	
                $rs= $con->executeQuery();
		
				if(!$rs->IsNull())
					$rs->PrintResult();				
				else 
				{
					Application::WriteLn("ERROR:");				
					Application::WriteLn($con->getmsjError());
					Application::WriteLn($con->MessageRealError);
				}
			}
			else 
				Application::message("Conexión fallida");
		}
		?>	  </td>
    </tr>
  </table>
</form>


</body>
</html>
