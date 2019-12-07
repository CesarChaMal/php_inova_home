<?php
   include("cabecera.php"); 
?>
<script language="javascript" type="text/javascript">
mifuncion = function(){}

mifuncion.cambia= function(){
content=document.getElementById('cbx_llena');
content_txt=document.getElementById('mensaje');
alert(content);
content.inneHTML="<option value=joel> Joel</option>";
content_txt.innerHTML="<option value=joel> Joel</option>";
document.getElementById('cbx_llena').value=content.innerHTML;

}
function test()
{
    var objSelect = document.all.idSelect;
    var strOrigHTML     = objSelect.innerHTML;
    objSelect.innerHTML = strOrigHTML;
    var strNewHTML      = objSelect.innerHTML;

    if (strNewHTML == strOrigHTML)
        alert("Test passed.");
    else
        alert("Test failed: innerHTML = " + strNewHTML );
}

function atributo(){

ContenGrid=document.getElementById('contentGrid');
alert(contentGrid);
contentGrid.innerHTML="<select><option value='2007'>hola</option></select>";

}


</script>
<form id="frm">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17%">&nbsp;
      <input name="btn_prueba" id="btn_prueba" type="button"  value="llena select" onClick="mifuncion.cambia();" /></td>
    <td width="83%">
	<select class="styleCBX" name="cbx_llena" id="cbx_llena">

    </select>    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;<span id="mensaje"></span></td>
  </tr>
  <tr>
    <td>[CODE]</td>
    <td><input type="text" id="txt_code" name="txt_code"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;<div id="contentGrid" >
	<table width="98%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>hola </td>
    <td>hola </td>
    <td>&nbsp;</td>
    <td>que</td>
  </tr>
  <tr>
    <td>tal </td>
    <td>como est </td>
    <td>as</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div></td>
  </tr>
  <tr>
    <td>&nbsp;<select id="idSelect">
    <option value="line1">Option 1</option>
    <option value="line2">Option 2</option>
  </select></td>
    <td>
  <input type="button" value="test" onClick="test()" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input name="btn_plus" type="button" id="btn_plus" value="Pulsa" onClick="atributo();"></td>
    <td>
	<table id="tbl_cambia" width="98%" border="0" cellspacing="0" cellpadding="0" onMouseUp="alert(this.id);">
      <tr>
        <td>hola</td>
        <td>hola</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<?php
   include("pie.php"); 
?>