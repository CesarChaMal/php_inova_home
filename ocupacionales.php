<? include("cabecera.php"); ?>
<!-- incluyo la cabecera -->
<!-- fin del contenido -->
<script>
miocupacion = function(){}

miocupacion.gridAjax=function(campo){
//alert(campo.value);
  gateway=campo.value;
  var url="includes/classlib/ResponseAjax.php?ajax=22"; 
  url = url + "&dummy=" + new Date().getTime();  
  request.open("POST", url, true);
  request.onreadystatechange = miocupacion.updategridAjax;
  request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  request.send("gateway=" + escape(gateway));  
  var espera=document.getElementById('div_espera');
  loading="<img src='images/load.gif' width='32' height='32' /><span class='styleNBG'> Cargando Datos...</span>";
  espera.innerHTML=loading;
}

miocupacion.updategridAjax=function(){
  if (request.readyState == 4){
    if (request.status == 200){         
         var data= request.responseText;   
         //alert(data);
         var grid = document.getElementById("gridContenedor");
         grid.innerHTML = data;
         var espera=document.getElementById('div_espera');
         espera.innerHTML="";
     }
  }
}


</script>
<form id="frm" name="frm" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr id="barra_menu">
      <td class="lineHorizontal"><img src="./images/gateways.gif" border="0"><a href="panel.php" class="styleMain">&nbsp;&nbsp;Gateways </a>&nbsp;|&nbsp; <img src="./images/ocupacional.gif" border="0" /><a href="ocupacionales.php" class="styleMain"> % ocupacion</a>&nbsp;|&nbsp; <img src="./images/dir_p.gif" border="0" /> <a href="tablaip.php" class="styleMain">Tabla IP's </a>&nbsp;|&nbsp; <img src="./images/configuracion.gif" border="0" /><a href="configuracion.php" class="styleMain"> &nbsp;&nbsp;Configuracion</a>&nbsp;|&nbsp;<img src="./images/cerrar_s_1.gif" border="0" /><a href="index.php?logout=true" class="styleMain">&nbsp;&nbsp;Cerrar Sesion</a></td>
  </tr>
  <tr>
    <td><span class="lineHorizontal">
      <? 
        $rs = new ResultSet();
        //$qry = "SELECT * FROM tbl_configuracion_ocupacional GROUP BY gateway";
        $qry = "show tables";
        $rs=$con->executeQuery($qry);
        while($rs->next()){
        //$table[]=$rs->get("gateway");
        $table[]=$rs->get(0);
    }  
    ?>
    </span></td>
  </tr>
  <tr>
    <td class="lineHorizontal" id="barra_opciones">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
      <td>&nbsp;</td>
      </tr>
        <tr>
            <td valign="top">
                <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="8%">
<!--                    <td width="10%" class="lineHorizontal"> -->
                        <div align="center"><span class="styleNBLM">Gateway</span></div>
                        </td>
                    <td width="92%">
<!--                    <td width="88%" class="lineHorizontal"> -->
                        <div id="div_gateway" style="width:70px;">
                            <select name="cbx_gateway" class="styleCBX" id="cbx_gateway"  onchange="miocupacion.gridAjax(this);">
                                <option value="false">Seleccione</option>
                                <? 
                                for($i=0;$i<count($table);$i++){
                                    if($table[$i]!="tbl_usuario" and $table[$i]!="tbl_configuracion_lote"  and $table[$i]!="tbl_configuracion_ocupacional" and $table[$i]!="tbl_configuracion_ip"){
                                        echo "<option value=$table[$i]>$table[$i]</option>";
                                    }
                                }
                                /*
                                for($i=0;$i<count($table);$i++){
                                    echo "<option value=$table[$i]>$table[$i]</option>";
                                }
                                */
                                ?>
                            </select>
                        </div>                    
                        </td>
                </tr>
                </table>            
                </td>
        </tr>
        </table>    
        </td>
  </tr>
<!--
  <tr>
      <td class="lineHorizontal">&nbsp;</td>
  </tr>
-->
 <tr id="barra_vacia">
   <td valign="top"><!--<img src="images/load.gif" width="32" height="32" /><span class="styleNBG"> Cargando Datos...</span>--><div id="div_espera">&nbsp;</div></td>
 </tr>
  <tr class="lineHorizontal" width="100%">
    <td>
      <table width="100%" border="0">
      <tr>
        <td colspan="2" width="100%" class="lineHorizontal">&nbsp;<div id="div_result" align="right"><span class="styleNBG" id="message"></span></div></td>
      </tr>
        <td id="barra_impresion" height="21" colspan="2">
            <table width="20%" border="0" align="left" cellpadding="0" cellspacing="0" class="tableBorder">
            <tr>
                <td width="45%" class="lineVerticalD">&nbsp;&nbsp;<img src="images/imprimir.gif" width="16" height="16" /> <span class="styleMain" onClick="doPrintOcupacionales();" style="cursor:pointer"> Imprimir</span></td>
                <td width="55%"><div id="div_descarga">&nbsp;&nbsp;<img src="images/excel.gif" width="16" height="16" /><a href="<? $fecha=date("y-m-d"); $download="./includes/classlib/temp/".$fecha.".xls"; echo $download;?>" class="styleMain"> excel</a></div></td>
<!--                <td width="45%" class="lineVerticalD">&nbsp;&nbsp;<img src="images/imprimir.gif" width="16" height="16" /> <span class="styleMain" onClick="doPrint();" style="cursor:pointer"> Imprimir</span></td> -->
<!--                <td width="55%">&nbsp;&nbsp;<img src="images/excel.gif" width="16" height="16" /> <span class="styleNBC">Excel</span></td> -->
            </tr>
            </table>
        </td>
      </tr>
      </table>
      </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td>
	<div id="gridContenedor">
	</div>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>

<!-- fin del contenido -->
<!-- incluyo la el pie -->
<? include("pie.php");?>