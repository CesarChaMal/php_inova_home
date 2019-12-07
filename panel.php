<? include("cabecera.php"); ?>
<!-- incluyo la cabecera -->
<!-- del contenido -->
<script>
mipanel =function(){}


mipanel.trim = function(string) {
      return string.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
} 
/*
-----------------------------------
*/

/*
Ajax del Combo Gateway
*/
mipanel.anioAjax = function(campo)
{
     //alert(campo.value);
     //alert(fecha);
     var host ="http://localhost/inova_home/";
     modulo=document.getElementById('cbx_vista').value;
     //alert(modulo);
     //alert(host);
     espera=document.getElementById('div_espera');
     loading="<img src='images/load.gif' width='32' height='32' /><span class='styleNBG'> Cargando Datos...</span>";
     gateway=campo.value;
     if(gateway=='false'){
     document.getElementById('txt_fecha').value=""
     fecha="";
     }else{
      fecha=document.getElementById('txt_fecha').value;
     }
     if(fecha!=""){
     var info=fecha.split("-");
     anio=info[0]; 
     mes=info[1];
     dia=info[2];
     if(anio!="" && anio!="false" && mes != "" && mes != 'false' && dia!="" && dia!='false'){
     
         mipanel.actualizaRegion(anio,mes,dia);
         espera.innerHTML=loading;
     
     }else{
     if(anio!="" && anio!="false" && mes != "" && mes != 'false'){
      
     var url="includes/classlib/ResponseAjax.php?modulo="+modulo+"&ajax=3";
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = mipanel.updatediaAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("mes=" + escape(mes) + "&gateway=" + escape(gateway) + "&anio=" + escape(anio)); 
     espera.innerHTML=loading;   
         
     }else{
     if(anio!="" && anio!="false"){
     
     var url="includes/classlib/ResponseAjax.php?modulo="+modulo+"&ajax=2";
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = mipanel.updatemesesAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("anio=" + escape(anio) + "&gateway=" + escape(gateway));   
     espera.innerHTML=loading;     
     }         
     } 
     }    
     }else{
     var url="includes/classlib/ResponseAjax.php?modulo="+modulo+"&ajax=1"; 
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = mipanel.updateanioAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("gateway=" + escape(gateway));
     espera.innerHTML=loading; 
     }

}

mipanel.updateanioAjax=function()
{
    if (request.readyState == 4){
    if (request.status == 200) {         
          
      var dataAnio = request.responseText;
      string=dataAnio;
      data=mipanel.trim(string);
      //document.getElementById('texto_code').value=dataAnio;
      espera=document.getElementById('div_espera');
     
      //alert(dataAnio);
      datas=data.split("+");
      seleccion=datas[0];
      content=datas[1];
      gateway=datas[2];
      //alert(content);
      //alert(seleccion);
      //alert(content);
      // contenedores  DIV
      anio=document.getElementById("div_anio"); 
      gridData=document.getElementById('div_gridContenedor');  
      mensaje=document.getElementById('message');               
      //- Fin contenedores DIV
      
      if(seleccion==""){
      tempAnio="";
      tempMes="";
      tempDia="";
      anio=document.getElementById("cbx_anios");
      mes=document.getElementById("cbx_meses");
      dia=document.getElementById("cbx_dias");
      anio.innerHTML=tempAnio;
      mes.innerHTML=tempMes;
      dia.innerHTML=tempDia;
      gridData.innerHTML=content;
      mensaje.innerHTML="&nbsp;&nbsp;&nbsp;+ Seleccione un Gateway ";
      espera.innerHTML="";
      }else{
      anio.innerHTML=seleccion;
      gridData.innerHTML=content;
      mensaje.innerHTML="&nbsp;&nbsp;&nbsp;+ Resultados del Gateway "+gateway;
      espera.innerHTML="";
      }                      
      }
      }
}  

/*
Fin Ajax del Combo Gateway
*/

/*
Ajax combo de los anios
*/
mipanel.mesesAjax=function(campo){
anio=campo.value;
//alert(anio);
espera=document.getElementById('div_espera');
loading="<img src='images/load.gif' width='32' height='32' /><span class='styleNBG'> Cargando Datos...</span>";
modulo=document.getElementById("cbx_vista").value; 
if(anio!='false'){document.getElementById('txt_fecha').value=anio+"-";}else{document.getElementById('txt_fecha').value="";}
     gateway=document.getElementById("cbx_gateway").value;
     var url="includes/classlib/ResponseAjax.php?modulo="+modulo+"&ajax=2";
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = mipanel.updatemesesAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("anio=" + escape(anio) + "&gateway=" + escape(gateway));
     espera.innerHTML=loading;
}

mipanel.updatemesesAjax=function()
{
    if (request.readyState == 4){
    if (request.status == 200) {         
          
     var dataMeses = request.responseText;
     string=dataMeses;
     data=mipanel.trim(string); 
     datas=data.split("+");
     seleccion=datas[0];
     content=datas[1];
     gateway=datas[2]; 
     anio=datas[3];
     //alert(datas);
     //alert(dataMeses);
     //alert(content);
     espera=document.getElementById('div_espera');
     //document.getElementById('texto_code').value=dataMeses;
     //contenedores DIV
     mensaje=document.getElementById('message');     
     gridData=document.getElementById('div_gridContenedor');  
     // Fin contenedores DIV
     meses=document.getElementById("div_meses");
     if(seleccion == ''){
      tempMes="";
      tempDia="";
      mes=document.getElementById("cbx_meses");
      dia=document.getElementById("cbx_dias");
      mes.innerHTML=tempMes;
      dia.innerHTML=tempDia;
      gridData.innerHTML=content;
      mensaje.innerHTML="&nbsp;&nbsp;&nbsp;+ Resultados del Gateway "+gateway;
      espera.innerHTMl="";
      }else{
      meses.innerHTML=seleccion; 
      gridData.innerHTML=content;
      mensaje.innerHTML="&nbsp;&nbsp;&nbsp;+ Resultados del Gateway "+gateway+" del año "+anio ;
      espera.innerHTML="";
      }                      
      }
      }
} 
/*
Ajax combo de los anios
*/
/*
Ajax combo de los Meses
*/
mipanel.diaAjax=function(campo){
   
     mes=campo.value;
     //alert(mes);
     espera=document.getElementById('div_espera');
     loading="<img src='images/load.gif' width='32' height='32' /><span class='styleNBG'> Cargando Datos...</span>";
     anio=document.getElementById("cbx_anios").value; 
     modulo=document.getElementById("cbx_vista").value; 
     if(mes!='false'){
         document.getElementById('txt_fecha').value=anio +"-"+mes+"-";
     }else{
         document.getElementById('txt_fecha').value=anio +"-";
     }
     
     gateway=document.getElementById("cbx_gateway").value;
     var url="includes/classlib/ResponseAjax.php?modulo="+modulo+"&ajax=3";
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = mipanel.updatediaAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("mes=" + escape(mes) + "&gateway=" + escape(gateway) + "&anio=" + escape(anio));
     espera.innerHTML=loading;
}

mipanel.updatediaAjax=function()
{
    if (request.readyState == 4){
    if (request.status == 200) {         
          
     var dataDias = request.responseText;
     string=dataDias;
     data=mipanel.trim(string); 
     datas=data.split("+");
     seleccion=datas[0];
     content=datas[1];
     gateway=datas[2]; 
     anio=datas[3];
     mes=datas[4];
     //alert(data);
     //alert(seleccion);
     //alert(content);
     //Div Contenedores
     espera=document.getElementById('div_espera');
     gridData=document.getElementById('div_gridContenedor');
     dia=document.getElementById("div_dias");      
     mensaje=document.getElementById('message');
     //- Fin DIV contenedores
      //document.getElementById('texto_code').value=dataDias;
      if(seleccion==''){   
      tempDia="<select id=cbx_dias name=cbx_dias></select>";
      gridData.innerHTML=content;
      dia.innerHTML=tempDia;                   
      mensaje.innerHTML="&nbsp;&nbsp;&nbsp;+ Resultados del Gateway "+gateway+" del año "+anio;
      espera.innerHTML="";
      }else{
     dia.innerHTML=seleccion;
     gridData.innerHTML=content;
     mensaje.innerHTML="&nbsp;&nbsp;&nbsp;+ Resultados del Gateway "+gateway+" del año "+anio+" del mes "+mes;  
     espera.innerHTML="";
      }
    }
    }
} 

/*
Fin Ajax combo de los meses
*/

/*
 Ajax Calendario Busca datos
*/
mipanel.actualizaRegion= function (anio,mes,dia){
espera=document.getElementById('div_espera');
loading="<img src='images/load.gif' width='32' height='32' /><span class='styleNBG'> Cargando Datos...</span>";
document.getElementById('txt_fecha').value=anio +"-"+ mes +"-"+ dia;
gateway=document.getElementById("cbx_gateway").value; 
//alert(gateway);
modulo=document.getElementById('cbx_vista').value;
if(modulo=='general'){
if(gateway!="false"){
//alert(modulo);    
     url="includes/classlib/ResponseAjax.php?modulo="+modulo+"&ajax=4";
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = mipanel.updategridAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("mes=" + escape(mes) + "&gateway=" + escape(gateway) + "&anio=" + escape(anio) + "&dia=" + escape(dia));
     espera.innerHTML=loading;
}
}
if(modulo=='gateway'){
      // alert(modulo);
     url="includes/classlib/ResponseAjax.php?modulo="+modulo+"&ajax=4";
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = mipanel.updategridAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("mes=" + escape(mes) + "&gateway=" + escape(gateway) + "&anio=" + escape(anio) + "&dia=" + escape(dia));
     espera.innerHTML=loading;    
}
if(modulo=='puerto'){
      // alert(modulo);
     url="includes/classlib/ResponseAjax.php?modulo="+modulo+"&ajax=4";
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = mipanel.updategridAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("mes=" + escape(mes) + "&gateway=" + escape(gateway) + "&anio=" + escape(anio) + "&dia=" + escape(dia));
     espera.innerHTML=loading;    
}

}

/*
 Fin Ajax Calendario Busca datos
*/

/*
Ajax combo de dia
*/
mipanel.gridAjax=function(campo){
     dia= campo.value;
     anio=document.getElementById("cbx_anios").value;
     mes=document.getElementById("cbx_meses").value;
     gateway=document.getElementById("cbx_gateway").value;
     modulo=document.getElementById("cbx_vista").value;
     espera=document.getElementById('div_espera');
     loading="<img src='images/load.gif' width='32' height='32' /><span class='styleNBG'> Cargando Datos...</span>";
     if(dia!='false'){document.getElementById('txt_fecha').value=anio +"-"+ mes +"-"+ dia;}else{document.getElementById('txt_fecha').value=anio +"-"+ mes +"-";}
     
     /*alert(dia);
     alert(anio);
     alert(mes);
     alert(gateway);*/
     var url="includes/classlib/ResponseAjax.php?modulo="+modulo+"&ajax=4";
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = mipanel.updategridAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("mes=" + escape(mes) + "&gateway=" + escape(gateway) + "&anio=" + escape(anio) + "&dia=" + escape(dia));
     espera.innerHTML=loading;
}

mipanel.updategridAjax=function()
{
    if (request.readyState == 4){
    if (request.status == 200){               
     var dataGrid = request.responseText;
     //alert(dataGrid);
     //document.getElementById('texto_code').value=dataGrid;
     data=dataGrid.split("+");
     //alert(dataGrid);
     select=data[0];
     content=data[1];
     gateway=data[2]; 
     anio=data[3];
     mes=data[4];
     dia=data[5];
     //alert(day);
     //alert(data[5]);
     //Div contenedores
     espera=document.getElementById('div_espera');
     mensaje=document.getElementById('message');
     gridTable=document.getElementById("div_gridContenedor");
     //Div COnyenedores fin
     //gridTable=document.getElementById("areaText");
     gridTable.innerHTML=content;
     mensaje.innerHTML="&nbsp;&nbsp;&nbsp;+ Resultados del Gateway "+gateway+" del año "+anio+" del mes "+mes+" del dia "+dia;  
     espera.innerHTML="";
      }                                                                                                 

        
     }
} 
/*
Fin Ajax combo de dia
*/

/*
Ajax de las vistas de los grid
*/
mipanel.vista=function(campo){
  //alert(campo.value);
  vista=campo.value;
  gateway=document.getElementById('cbx_gateway').value;
 //alert(gateway);
  mensaje=document.getElementById('message');
  espera=document.getElementById('div_espera');
  loading="<img src='images/load.gif' width='32' height='32' /><span class='styleNBG'> Cargando Datos...</span>";
  modulo=campo.value;
  // General Modulo
  if(modulo=='general'){
  document.frm.cbx_gateway.disabled=false;
  document.frm.cbx_anios.disabled=false;
  document.frm.cbx_meses.disabled=false;
  document.frm.cbx_dias.disabled=false;    
  
  var url="includes/classlib/ResponseAjax.php?modulo="+modulo+"&ajax=1"; 
  url = url + "&dummy=" + new Date().getTime();  
  request.open("POST", url, true);
  request.onreadystatechange = mipanel.updateanioAjax;
  request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  request.send("modulo=" + escape(modulo) + "&gateway="+ escape(gateway));
  espera.innerHTML=loading;
  }

  //Modulo Gateways
  if(modulo=='gateway'){
  document.frm.cbx_gateway.disabled=true;
  document.frm.cbx_anios.disabled=true;
  document.frm.cbx_meses.disabled=true;
  document.frm.cbx_dias.disabled=true;
  
  var url="includes/classlib/ResponseAjax.php?modulo="+modulo+"&ajax=1"; 
  url = url + "&dummy=" + new Date().getTime();  
  request.open("POST", url, true);
  request.onreadystatechange = mipanel.updateanioAjax;
  request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  request.send("modulo=" + escape(modulo));  
  mensaje.innerHTML="&nbsp;&nbsp;&nbsp;+ Resultados de ASR y ACD General Por Gateway ";  
  espera.innerHTML=loading;
  }
  
  if(modulo=='puerto'){
  document.frm.cbx_gateway.disabled=false;
  document.frm.cbx_anios.disabled=false;
  document.frm.cbx_meses.disabled=false;
  document.frm.cbx_dias.disabled=false;
  gateway=document.getElementById('cbx_gateway').value;
  var url="includes/classlib/ResponseAjax.php?modulo="+modulo+"&ajax=1"; 
  url = url + "&dummy=" + new Date().getTime();  
  request.open("POST", url, true);
  request.onreadystatechange = mipanel.updateanioAjax;
  request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  request.send("modulo=" + escape(modulo) + "&gateway=" + escape(gateway));  
  mensaje.innerHTML="&nbsp;&nbsp;&nbsp;+ Resultados de ASR y ACD General Por Puerto";  
  espera.innerHTML=loading;
  }
       
} 
/*
Fin Ajax de las vistas de los grid
*/

/*
Ajax exportar a Excel
*/
mipanel.ExportExcel= function(){
  
  modulo=document.getElementById("cbx_vista").value;
  espera=document.getElementById('div_espera');
  loading="<img src='images/load.gif' width='32' height='32' /><span class='styleNBG'> Cargando Datos...</span>";
  var url="includes/classlib/ResponseAjax.php?ajax=excel"; 
  url = url + "&dummy=" + new Date().getTime();  
  request.open("POST", url, true);
  request.onreadystatechange = mipanel.updateExportAjax;
  request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  request.send("modulo=" + escape(modulo));  
  espera.innerHTML=loading;
  
}

mipanel.updateExportAjax=function(){

    if (request.readyState == 4){
    if (request.status == 200){               
    
    var dataExport = request.responseText;
    //alert(dataExport);
    //document.getElementById('texto_code').value=dataExport;
    espera=document.getElementById('div_espera');
    espera.innerHTML="";
    
    
    }
    }
}

/*
Fin Ajax exportar a Excel
*/

</script>
<form id="frm" name="frm" >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr id="barra_vacia_dos">
    <td>&nbsp;</td>
  </tr>
  <tr id="barra_menu">
    <td class="lineHorizontal"><img src="./images/gateways.gif" border="0"><a href="panel.php" class="styleMain">&nbsp;&nbsp;Gateways </a>&nbsp;|&nbsp; <img src="./images/ocupacional.gif" border="0" /><a href="ocupacionales.php" class="styleMain"> % ocupacion</a>&nbsp;|&nbsp; <img src="./images/dir_p.gif" border="0" /> <a href="tablaip.php" class="styleMain">Tabla IP's </a>&nbsp;|&nbsp; <img src="./images/configuracion.gif" border="0" /><a href="configuracion.php" class="styleMain"> &nbsp;&nbsp;Configuracion</a>&nbsp;|&nbsp;<img src="./images/cerrar_s_1.gif" border="0" /><a href="index.php?logout=true" class="styleMain">&nbsp;&nbsp;Cerrar Sesion</a></td>
  </tr>
  <tr>
    <td id="barra_vacia">&nbsp;</td>
  </tr>
  <tr>
    <td>
    <!-- aki van los gateways -->
    <? 
    $rs = new ResultSet();
    $qry = "show tables";
    $rs=$con->executeQuery($qry);
    while($rs->next()){
    $table[]=$rs->get(0);
    }  
    ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr id="barra_opciones">
            <td width="22%">
<div style="float: right; margin-left: 1em; margin-bottom: 1em;" id="calendario"></div>

<script type="text/javascript">
  function dateChanged(calendar) {
    // Beware that this function is called even if the end-user only
    // changed the month/year.  In order to determine if a date was
    // clicked you can use the dateClicked property of the calendar:
    // alertCalendar._SMN[month]);
    // alert(Calendar._TT["WEEKEND"]);
    if (calendar.dateClicked) {
      // OK, a date was clicked, redirect to /yyyy/mm/dd/index.php
      var y = calendar.date.getFullYear();
      var m = calendar.date.getMonth();     // integer, 0..11
      var d = calendar.date.getDate();      // integer, 1..31
      anio=y;
      mes=(m+1);
      dia=d;
    mipanel.actualizaRegion(anio,mes,dia);  
    }
  };
  Calendar.setup(
    {
      flat         : "calendario", // ID of the parent element
      flatCallback : dateChanged           // our callback function
    }
  );
</script>        </td>
       <td valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
         <tr>
           <td width="9%" class="lineHorizontal"><div align="center"><span class="styleNBLM">Gateway</span></div></td>
           <td width="13%" class="lineHorizontal"><div id="div_gateway" style="width:70px;">
               <select name="cbx_gateway" class="styleCBX" id="cbx_gateway"  onchange="mipanel.anioAjax(this);">
                 <!-- <select class="styleCBX" id="cbx_gateway" name="cbx_gateway">-->
                 <option value="false">Seleccione</option>
                 <? 
          for($i=0;$i<count($table);$i++){
          if($table[$i]!="tbl_usuario" and $table[$i]!="tbl_configuracion_lote"  and $table[$i]!="tbl_configuracion_ocupacional" and $table[$i]!="tbl_configuracion_ip"){
          echo "<option value=$table[$i]>$table[$i]</option>";
          }
          }
          ?>
               </select>
           </div></td>
           <td width="6%" class="lineHorizontal">|&nbsp; <span class="styleNBLM">A&Ntilde;O </span></td>
           <td width="13%" class="lineHorizontal"><div id="div_anio" style="width:70px;">
               <select name="cbx_anios"  class="styleCBX" id="cbx_anios" onChange="mipanel.mesesAjax(this)">
               </select>
           </div></td>
           <td width="6%" class="lineHorizontal">&nbsp; |&nbsp; <span class="styleNBLM"> mes</span></td>
           <td width="14%" class="lineHorizontal"><div id="div_meses">
               <select id="cbx_meses" name="cbx_meses" class="styleCBX" onChange="mipanel.diaAjax(this)">
               </select>
           </div></td>
           <td width="7%" class="lineHorizontal">&nbsp; |&nbsp; <span class="styleNBLM">dia</span></td>
           <td width="12%" class="lineHorizontal"><div id="div_dias">
               <select id="cbx_dias" name="cbx_dias" class="styleCBX" onChange="mipanel.gridAjax(this)">
               </select>
           </div></td>
           <td width="6%" class="lineHorizontal">&nbsp;</td>
           <td width="6%" class="lineHorizontal">&nbsp;</td>
           <td width="8%" class="lineHorizontal">&nbsp;</td>
         </tr>
         <tr>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td colspan="11" class="lineHorizontal"><span class="styleNBLM">ver por </span>
               <select name="cbx_vista" id="cbx_vista" class="styleCBX" onChange="mipanel.vista(this);">
                 <option value="general">general</option>
                 <option value="gateway">Gateways</option>
                 <option value="puerto">Puertos</option>
               </select>
               <input name="text" type="hidden" id="txt_fecha" /></td>
         </tr>
         <!--<tr>
           <td colspan="11">&nbsp;</td>
         </tr>-->
         <tr>
           <td colspan="11" valign="top"><!--<img src="images/load.gif" width="32" height="32" /><span class="styleNBG"> Cargando Datos...</span>--><div id="div_espera"></div></td>
         </tr>
       </table></td>
        </tr>
      
      <tr>
        <td colspan="2" class="lineHorizontal"><div id="div_result" align="right"><span class="styleNBG" id="message">&nbsp;</span></div></td>
        </tr>
       <tr id="barra_impresion">
        <td height="21" colspan="2"><table width="20%" border="0" align="left" cellpadding="0" cellspacing="0" class="tableBorder">
          <tr>
            <td width="45%" class="lineVerticalD">&nbsp;&nbsp;<img src="images/imprimir.gif" width="16" height="16" /> <span class="styleMain" onClick="doPrint();" style="cursor:pointer"> Imprimir</span></td>
            <td width="55%"><div id="div_descarga">&nbsp;&nbsp;<img src="images/excel.gif" width="16" height="16" /><a href="<? $fecha=date("y-m-d"); $download="./includes/classlib/temp/".$fecha.".xls"; echo $download;?>" class="styleMain"> excel</a></div></td>
          </tr>
        </table></td>
        </tr>
     <!-- <tr>
        <td colspan="3" class="lineHorizontal"><span class="styleNBLM">Informacion del gateway</span></td>
      </tr>-->
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="76%">
            <div id="div_gridContenedor">
            <table id="gridContenedor" width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableBorder">
              <tr>
                <td width="9%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Hora</span></div></td>
                <td width="15%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Total llamadas</span></div></td>
                <td width="24%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Total llamadas completadas</span></div></td>
                <td width="14%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM"><span class="styleNBLM">Total segundos</span></span></div></td>
                <td width="14%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM"><span class="styleNBLM">Total Minutos</span></span></div></td>
                <td width="6%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">ASR</span></div></td>
                <td width="7%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">ACD</span></div></td>
                <td width="11%" class="lineHorizontal"><div align="center"><span class="styleNBLM">Lotes por X</span></div></td>
              </tr>
              <tr>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">00 - 01</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">01 - 02</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
              <tr>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">02 - 03</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
              <tr>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">03 - 04</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
              <tr>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">04 - 05</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
              <tr>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">05 - 06</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
              <tr>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">06 - 07</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
              <tr>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">07 - 08</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
              <tr >
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">08 - 09</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
                  <tr >
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">09 - 10</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
                  <tr >
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">10 - 11</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
                  <tr >
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">11 - 12</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
                  <tr >
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">12 - 13</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
                  <tr >
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">13 - 14</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
                  <tr >
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">14 - 15</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
                  <tr >
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">15 - 16</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
                  <tr >
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">16 - 17</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
                  <tr >
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">17 - 18</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
                  <tr >
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">18 - 19</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
                  <tr >
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">19 - 20</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
                  <tr >
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">20 - 21</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
                  <tr >
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">21 - 22</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
                  <tr >
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">22 - 23</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
                  <tr >
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">23  - 24</span></div></td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal lineVerticalD">&nbsp;</td>
                <td class="lineHorizontal">&nbsp;</td>
                </tr>
            </table>
            </div>            </td>
           <!-- <td width="24%">&nbsp;</td>-->
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;<!--<textarea id="areaText" name="areaText" cols="90%" rows="150">&nbsp;</textarea>--></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;
        <!-- Aki va lo del los gteway-->
        <!--  Aki van lo de los gateway--></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;<!--<textarea id="texto_code" cols="100%" rows="10"></textarea>--></td>
      </tr>
    </table>
    <!-- aki terminan lo gateways-->    </td>
  </tr>
</table>
</form>
<!-- fin del contenido -->
<!-- incluyo la el pie -->
<? include("pie.php");?>