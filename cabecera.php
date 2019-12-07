<? 
session_start();
include_once("includes/classlib.php");
include_once("includes/datoscon.php");
$con= new dbconexion(database,host,user,pass);
if(!$con)
{
    Application::message('Conexion Fállida.');
}
?>
<script>
function ExportExcel(){
  
  modulo=document.getElementById("cbx_vista").value;
  espera=document.getElementById('div_espera');
  loading="<img src='images/load.gif' width='32' height='32' /><span class='styleNBG'> Cargando Datos...</span>";
  var url="includes/classlib/ResponseAjax.php?ajax=excel"; 
  url = url + "&dummy=" + new Date().getTime();  
  request.open("POST", url, true);
  request.onreadystatechange =updateExportAjax;
  request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  request.send("modulo=" + escape(modulo));  
  espera.innerHTML=loading;
  
}

function updateExportAjax(){

    if (request.readyState == 4){
    if (request.status == 200){               
    
    var dataExport = request.responseText;
    //alert(dataExport);
    document.getElementById('texto_code').value=dataExport;
    espera=document.getElementById('div_espera');
    espera.innerHTML="";
    
    }
    }
}
</script>

<?
/*header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=prueba.xls" );
header ("Content-Description: PHP/INTERBASE Generated Data" );*/
?>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="style.css" rel="stylesheet" type="text/css" />
<!--
<style type="text/css">@import url(calendar-blue.css);</style>
<script type="text/javascript" src="calendar.js"></script>
<script type="text/javascript" src="lang/calendar-es.js"></script>
<script type="text/javascript" src="calendar-setup.js"></script>-->
<style type="text/css">@import url(includes/jscalendar/calendar-blue.css);</style>
<script type="text/javascript" src="includes/jscalendar/calendar.js"></script>
<script type="text/javascript" src="includes/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="includes/jscalendar/calendar-setup.js"></script>
<script src="includes/classlib/ajax.js"> </script>
<script src="includes/classlib/text-utils.js"> </script>  
<title>.:: Administraci&oacute;n ::.</title>
</head>
<script language="javascript">
/*
Impresion de los Datos mostrados en el div_contentGrid
*/
function doPrint(){
    
  document.getElementById('barra_menu').style.display = 'none'; 
  document.getElementById('barra_opciones').style.display = 'none';
  document.getElementById('barra_vacia').style.display = 'none';
  document.getElementById('barra_vacia_dos').style.display = 'none';
  document.getElementById('barra_impresion').style.display = 'none';
  document.getElementById('calendario').style.display="none";
     
  var cabecera = micab.printing.header;
  var f = micab.printing.footer;
  // -- basic features
  micab.printing.header = "";
  micab.printing.footer = "";
  micab.printing.portrait = false;
  micab.printing.leftMargin = 1.0 ;
  micab.printing.topMargin = 1.0;
  micab.printing.rightMargin = 1.0;
  micab.printing.bottomMargin = 1.0;
  micab.doPrint(true); 

  document.getElementById('barra_menu').style.display = 'block'; 
  document.getElementById('barra_opciones').style.display = 'block';
  document.getElementById('barra_vacia').style.display = 'block';
  document.getElementById('barra_vacia_dos').style.display = 'block';
  document.getElementById('barra_impresion').style.display = 'block';  
  document.getElementById('calendario').style.display="block";
  }
/*
Impresion de los Datos mostrados en el div_contentGrid
*/

function doPrintTablaIp(){
    
  document.getElementById('barra_menu').style.display = 'none'; 
  document.getElementById('barra_opciones').style.display = 'none';
  document.getElementById('barra_vacia').style.display = 'none';
  document.getElementById('barra_impresion').style.display = 'none';
//  document.getElementById('barra_vacia_dos').style.display = 'none';
//  document.getElementById('calendario').style.display="none";
     
  var cabecera = micab.printing.header;
  var f = micab.printing.footer;
  // -- basic features
  micab.printing.header = "";
  micab.printing.footer = "";
  micab.printing.portrait = true;
  micab.printing.leftMargin = 1.0 ;
  micab.printing.topMargin = 1.0;
  micab.printing.rightMargin = 1.0;
  micab.printing.bottomMargin = 1.0;
  micab.doPrint(true); 

  document.getElementById('barra_menu').style.display = 'block'; 
  document.getElementById('barra_opciones').style.display = 'block';
  document.getElementById('barra_vacia').style.display = 'block';
  document.getElementById('barra_impresion').style.display = 'block';  
//  document.getElementById('barra_vacia_dos').style.display = 'block';
//  document.getElementById('calendario').style.display="block"; 
  }                                                             

  function doPrintOcupacionales(){
    
  document.getElementById('barra_menu').style.display = 'none'; 
  document.getElementById('barra_opciones').style.display = 'none';
  document.getElementById('barra_vacia').style.display = 'none';
  document.getElementById('barra_impresion').style.display = 'none';
     
  var cabecera = micab.printing.header;
  var f = micab.printing.footer;
  // -- basic features
  micab.printing.header = "";
  micab.printing.footer = "";
  micab.printing.portrait = true;
  micab.printing.leftMargin = 1.0 ;
  micab.printing.topMargin = 1.0;
  micab.printing.rightMargin = 1.0;
  micab.printing.bottomMargin = 1.0;
  micab.doPrint(true); 

  document.getElementById('barra_menu').style.display = 'block'; 
  document.getElementById('barra_opciones').style.display = 'block';
  document.getElementById('barra_vacia').style.display = 'block';
  document.getElementById('barra_impresion').style.display = 'block';  
  }                                                             

  /*
Impresion de los Datos mostrados en el div_contentGrid
*/
</script>
<body topmargin="0">
<object id='micab' style="display:none" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" viewastext codebase="http://localhost/inova_home/smsx.cab#Version=6,3,434,26"></object>
<!-- <object id='micab' style="display:none" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" viewastext codebase="http://localhost:8080/file:/E:/inova_home/smsx.cab#Version=6,3,434,26"></object>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableBorder">
<tr>
<td valign="top" class="lineHorizontal"><span class="styleNBG">&nbsp;Administración</span></td>
</tr>
  <tr>
    <td valign="top">
<!-- contenido -->
