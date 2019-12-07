<? 
//error_reporting(0);
include("cabecera.php"); 
if($_GET['logout']=='true'){session_destroy();}
?>
<!-- incluyo la cabecera -->

<!-- inicio el contenido -->
<form name="frm" action="<?=$_SERVER['PHP_SEFL'];?>" method="post">
<? 
if($_POST[btn_ingresar])
{

if($_POST['txt_usuario']!="" and $_POST['txt_contrasena'])
{   
$tempuser=$_POST['txt_usuario'];
$temppass=md5($_POST['txt_contrasena']);
$rs= new ResultSet();
$qry="select * from tbl_usuario where username='$tempuser' and password='$temppass'";
$rs= $con->executeQuery($qry);
$user=$rs->get('username');
if($user != "")
{
   $_SESSION['user']=$tempuser;
   $_SESSION['active']=1;
   echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=panel.php\">";
   
}else{
$_SESSION['active']=1;
Application::message(" :: Usuario no encontrado.");
Application::message($con->getmsjError());
Application::message($con->MessageRealError);
}

}else{
Application::message(" :: Escriba sus datos de acceso.");
}

}
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableBorder">
      <tr>
        <td class="lineHorizontal"><span class="styleNBM">&nbsp;.:.Acceso</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="80%" border="0" align="center" cellpadding="0" cellspacing="1">
          <tr>
            <td width="22%"><span class="styleNBC">:: Usuario</span></td>
            <td width="78%"><input name="txt_usuario" type="text" class="boxText" /></td>
          </tr>
          <tr>
            <td><span class="styleNBC">:: Contraclave</span></td>
            <td><label>
              <input name="txt_contrasena" type="password" class="boxText" />
            </label></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><input name="btn_ingresar" type="submit" class="btnText" value=":: Ingresar ::" /></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<!-- fin del contenido -->
<!-- incluyo la el pie -->
<? include("pie.php");?>