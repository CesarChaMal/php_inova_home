<? include("cabecera.php"); ?>
<!-- incluyo la cabecera -->
<!-- del contenido -->
<script>
//mipanel =function(){}


function trim (string) {
      return string.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
} 
/*
-----------------------------------
*/

/*
Ajax del Combo Gateway
*/
function anioAjax(campo){
//alert(campo.value);
     //alert(fecha);
     var host ="http://localhost/inova_home/";
     modulo=document.getElementById('cbx_vista').value;
     //alert(modulo);
     //alert(host);
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
     
     }else{
     if(anio!="" && anio!="false" && mes != "" && mes != 'false'){
      
     var url="includes/classlib/ResponseAjax.php?modulo="+modulo+"&ajax=3";
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = mipanel.updatediaAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("mes=" + escape(mes) + "&gateway=" + escape(gateway) + "&anio=" + escape(anio)); 
         
         
     }else{
     if(anio!="" && anio!="false"){
     
     var url="includes/classlib/ResponseAjax.php?modulo="+modulo+"&ajax=2";
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = mipanel.updatemesesAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("anio=" + escape(anio) + "&gateway=" + escape(gateway));   
         
     }         
     } 
     }    
     }else{
     var url="includes/classlib/ResponseAjax.php?modulo="+modulo+"&ajax=1"; 
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = updateanioAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("gateway=" + escape(gateway));
     }
                       
};

function updateanioAjax()
{
    if (request.readyState == 4){
    if (request.status == 200) {         
          
      var dataAnio = request.responseText;
      string=dataAnio;
      data=trim(string);
      document.getElementById('texto_code').value=dataAnio;
      datas=data.split("+");
      select=datas[0];
      content=datas[1];
      gateway=datas[2];
      //alert(content);
      alert(select);
      alert(content);
      alert(gateway);
      mensaje=document.getElementById('message');     
      if(select==""){
      tempAnio="";
      tempMes="";
      tempDia="";
      anio=document.getElementById("cbx_anios");
      mes=document.getElementById("cbx_meses");
      dia=document.getElementById("cbx_dias");
      anio.innerHTML=tempAnio;
      mes.innerHTML=tempMes;
      dia.innerHTML=tempDia;
      gridData=document.getElementById('gridContenedor');
      gridData.innerHTML=content;
      }else{
     // anio=document.getElementById("cbx_anios");
      //document.getElementById("cbx_anios").innerHTML=select;     
      //gridData=document.getElementById('gridContenedor');  
      //select=String(select);
      //alert(select);
      //document.write(select);
      //anio.innerHTML="<option value='false'>Seleccione</option><option value='2007'>2007</option>"; 
      //document.getElementById('texto_code').value=select;
      //alert(anio.innerHTML);    
     
      //gridData.innerHTML=content;
      //alert(gridData.innerHTML);
      mensaje.innerHTML="&nbsp;&nbsp;&nbsp;+ Resultados del Gateway "+ gateway;
      }                      
      }
      }
}; 

function simple(campo){
    alert(campo);
      anio=document.getElementById("cbx_anios");
      form=document.getElementById("frm");
      //anio.innerHTML="<select id='cbx_anios'><option value='false'>Seleccione</option><option value='2007'>2007</option></select>";    
      valor='<OPTION value="false">Seleccione</OPTION><OPTION value="2007">2007</OPTION>';
      alert(valor);
      anio.innerHTML=valor;
      alert(anio.outerHTML);   
      document.getElementById('texto_code').value=anio.innerHTML;
      alert(anio.innerHTML);
      alert(anio);
}

</script>
<form id="frm" >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="lineHorizontal"><img src="./images/gateways.gif" border="0"><a href="panel.php" class="styleMain">&nbsp;&nbsp;Gateways </a>&nbsp;|&nbsp; <img src="./images/configuracion.gif" border="0" /><a href="configuracion.php" class="styleMain"> &nbsp;&nbsp;Configuracion</a>&nbsp;|&nbsp;<img src="./images/cerrar_s_1.gif" border="0" /><a href="index.php?logout=true" class="styleMain">&nbsp;&nbsp;Cerrar Sesion</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
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
      <tr>
	        <td width="22%" rowspan="2" class="lineHorizontal">
<div style="float: right; margin-left: 1em; margin-bottom: 1em;"
id="calendario"></div>

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
      // redirect...
      //window.location = "/" + y + "/" + m + "/" + d + "/index.php";
      anio=y;
      mes=(m+1);
      dia=d;
    //document.frm.cbx_anios.options[0].selected==true;
    //document.frm.cbx_meses.options[0].selected==true;
    //document.frm.cbx_dias.options[0].selected==true;
    //alert(document.frm.cbx_anios.options[0].selected);
    //form.cbx_anios[0].value==true;
    //alert(form.cbx_anios[0].value);
    //alert(form.cbx_anios[0].selected);
    //modulo=document.getElementById('cbx_vista').value;
	//actualizaRegion(anio,mes,dia);  
    }
  };

  Calendar.setup(
    {
      flat         : "calendario", // ID of the parent element
      flatCallback : dateChanged           // our callback function
    }
  );
</script>		</td>
	   <td valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
         <tr>
           <td width="9%" class="lineHorizontal"><div align="center"><span class="styleNBLM">Gateway</span></div></td>
           <td width="13%" class="lineHorizontal"><div id="div_gateway" style="width:70px;">
               <select name="cbx_gateway" class="styleCBX" id="cbx_gateway"  onchange="simple(this)">
                 <!-- <select class="styleCBX" id="cbx_gateway" name="cbx_gateway">-->
                 <option value="false">Seleccione</option>
                 <? 
		  for($i=0;$i<count($table);$i++){
		  if($table[$i]!="tbl_usuario" and $table[$i]!="tbl_configuracion_lote"  and $table[$i]!="tbl_configuracion_ocupacional"){
		  echo "<option value=$table[$i]>$table[$i]</option>";
		  }
		  }
		  ?>
               </select>
           </div></td>
           <td width="6%" class="lineHorizontal">|&nbsp; <span class="styleNBLM">A&Ntilde;O </span></td>
           <td width="13%" class="lineHorizontal"><div id="div_anio" style="width:70px;">
               <select name="cbx_anios"  class="styleCBX" id="cbx_anios" onchange="mesesAjax(this)">
               </select>
           </div></td>
           <td width="6%" class="lineHorizontal">&nbsp; |&nbsp; <span class="styleNBLM"> mes</span></td>
           <td width="14%" class="lineHorizontal"><div id="div_meses">
               <select id="cbx_meses" name="cbx_meses" class="styleCBX" onchange="diaAjax(this)">
               </select>
           </div></td>
           <td width="7%" class="lineHorizontal">&nbsp; |&nbsp; <span class="styleNBLM">dia</span></td>
           <td width="12%" class="lineHorizontal"><div id="div_dias">
               <select id="cbx_dias" name="cbx_dias" class="styleCBX" onchange="gridAjax(this)">
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
               <select name="cbx_vista" id="cbx_vista" class="styleCBX" onchange="vista(this);">
                 <option value="general">general</option>
                 <option value="gateway">Gateways</option>
                 <option value="puerto">Puertos</option>
               </select>
               <input name="text" type="text" id="txt_fecha" /></td>
         </tr>
         <tr>
           <td colspan="11">&nbsp;</td>
         </tr>
       </table></td>
        </tr>
      
      <tr>
        <td class="lineHorizontal"><div id="div_result" align="right"><span class="styleNBG" id="message"></span></div></td>
        </tr>
	   <tr>
        <td height="21" colspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td height="21" colspan="2">&nbsp;</td>
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
            </table></td>
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
        <td colspan="2">&nbsp;<!-- Aki va lo del los gteway--></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;<textarea id="texto_code" cols="100%" rows="300"></textarea></td>
      </tr>
    </table>
	<!-- aki terminan lo gateways-->	</td>
  </tr>
</table>
</form>
<!-- fin del contenido -->
<!-- incluyo la el pie -->
<? include("pie.php");?>