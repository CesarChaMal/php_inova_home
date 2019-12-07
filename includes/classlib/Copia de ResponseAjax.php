<?php
session_start();
include_once("dbconexion.php");
include_once("System.php");
include_once("mydatetime.php");
include_once("../datoscon.php");
//include_once("grid.php");
//require_once('JSON.php');
$conexion = new dbconexion(database,host,user,pass);
         
/*
* Modulo de gateway combox 
*/

/*
*Funcion de reemplazos 
*/

/*Funcion Actualiza el contenido del grid*/
 function contentGrid($anio,$mes,$dia,$gateway){
$conexion = new dbconexion(database,host,user,pass); 
?>
           +<table id="gridContenedor" width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableBorder">
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
<?
//array de horas
$horas = array("'00:00:00' AND '00:59:59'","'01:00:00' AND '01:59:59'","'02:00:00' AND '02:59:59'","'03:00:00' AND '03:59:59'","'04:00:00' AND '04:59:59'",
               "'05:00:00' AND '05:59:59'","'06:00:00' AND '06:59:59'","'07:00:00' AND '07:59:59'","'08:00:00' AND '08:59:59'","'09:00:00' AND '09:59:59'",
               "'10:00:00' AND '10:59:59'","'11:00:00' AND '11:59:59'","'12:00:00' AND '12:59:59'","'13:00:00' AND '13:59:59'","'14:00:00' AND '14:59:59'",
               "'15:00:00' AND '15:59:59'","'16:00:00' AND '16:59:59'","'17:00:00' AND '17:59:59'","'18:00:00' AND '18:59:59'","'19:00:00' AND '19:59:59'",
               "'20:00:00' AND '20:59:59'","'21:00:00' AND '21:59:59'","'22:00:00' AND '22:59:59'","'23:00:00' AND '23:59:59'");
$costado=array("00 - 01","01 - 02","02 - 03","03 - 04","04 - 05","05 - 06","06 - 07","07 - 08","08 - 09","09 - 10","10 - 11","11 - 12","12 - 13",
               "13 - 14","14 - 15","15 - 16","16 - 17","17 - 18","18 - 19","19 - 20","20 - 21","21 - 22","22 - 23","23 - 24");
// fin arrar de horas
for($i=0;$i<count($horas);$i++){
/* Busco el query adecuado al filtro*/     
if($gateway!="false" and $anio=='false' and $mes=='false' and $dia=='false'){
 $qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM ".$gateway."
     WHERE  TIME(RIGHT(TRIM(Received),8)) BETWEEN ".$horas[$i].") 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM ".$gateway." WHERE Duration>0 
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i].") 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM ".$gateway."
     WHERE  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i].") 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM ".$gateway."
     WHERE  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i].")
     AS minutos";   
    
}elseif($anio!="false" and $gateway!="false" and $mes=='false' and $dia=='false'){
$qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM ".$gateway." WHERE YEAR(Received)='".$anio."' 
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN ".$horas[$i].") 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM ".$gateway." WHERE Duration>0 AND YEAR(Dialed)='".$anio."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i].") 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM ".$gateway." WHERE YEAR(Dialed)='".$anio."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i].") 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM ".$gateway." WHERE YEAR(Dialed)='".$anio."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i].")
     AS minutos";
}elseif($anio!="false" and $mes!="false" and $gateway!="false" and $dia=='false'){

 $qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM ".$gateway." WHERE YEAR(Received)='".$anio."' AND MONTH(Received)='".$mes."'
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN ".$horas[$i].") 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM ".$gateway." WHERE Duration>0 AND YEAR(Dialed)='".$anio."'  AND MONTH(Dialed)='".$mes."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i].") 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM ".$gateway." WHERE YEAR(Dialed)='".$anio."'  AND MONTH(Dialed)='".$mes."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i].") 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM ".$gateway." WHERE YEAR(Dialed)='".$anio."'  AND MONTH(Dialed)='".$mes."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i].")
     AS minutos";

}elseif($anio!="false" and $mes!="false" and $dia!="false" and $gateway!="false"){

$qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM ".$gateway." WHERE YEAR(Received)='".$anio."' AND MONTH(Received)='".$mes."' AND DAYOFMONTH(Received)='".$dia."' 
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN ".$horas[$i].") 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM ".$gateway." WHERE Duration>0 AND YEAR(Dialed)='".$anio."' AND MONTH(Dialed)='".$mes."' AND DAYOFMONTH(Dialed)='".$dia."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i].") 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM ".$gateway." WHERE YEAR(Dialed)='".$anio."' AND MONTH(Dialed)='".$mes."' AND DAYOFMONTH(Dialed)='".$dia."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i].") 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM ".$gateway." WHERE YEAR(Dialed)='".$anio."' AND MONTH(Dialed)='".$mes."' AND DAYOFMONTH(Dialed)='".$dia."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i].")
     AS minutos";
    
}
/* Final Busco e query*/
   // echo $qry."<br>";
     
     $rs=new ResultSet();
    //echo $qry; 
     $rs=$conexion->executeQuery($qry);
     //body de la tabla
     while($rs->next()){
         $total_llamadas=$rs->get('llamadas_totales');
         $total_llamadas_completadas=$rs->get('llamadas_total_completadas');
         $total_segundos=$rs->get('total_de_segundos');
         $total_minutos=$rs->get('total_minutos');
         $asr=$rs->get('por_completadas_ASR');
         $acd=$rs->get('promedio_ACD');
         if($total_minutos==""){$total_minutos="0";}
         if($total_segundos==""){$total_segundos="0";}
    echo "<tr
    onmouseover=\"this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'\"
    onmouseout=\"this.style.backgroundColor='#FFFFFF';this.style.color='#000000'\" 
    style=\"cursor:default; background-color:#FFFFFF; color='#000000'\"
    >";
?>                                                                                       

                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent"><?=$costado[$i];?></span></div></td>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent"><?=$total_llamadas;?></span></div></td>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent"><?=$total_llamadas_completadas;?></span></div></td>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent"><?=$total_segundos;?></span></div></td>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent"><?=$total_minutos;?></span></div></td>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent"><?=number_format($asr,1,".",",")." %";?></span></div></td>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent"><?=number_format($acd,2,".","");?></span></div></td>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>

<?
     }

} echo "</table>+$gateway+$anio+$mes+$dia";
}
/* Fin funcion Actualiza el contenido del Grid*/

/* funcion Actualiza con un Grid Vacio */
 function contentGridBlank(){
 /* en el caso de que no seleccione ningun dia dibujo la tabla sin nada */
 ?>
              +<table id="gridContenedor" width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableBorder">
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
 <?
/* Fin termino de dibujar la tabla en caso de q no se seleccione un dia*/  
 }
/* fin funcion Actualiza con un Grid Vacio */

/*
*SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Received)='2007' AND MONTH(Received)='10' AND DAYOFMONTH(Received)='29' 
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN '06:00:00' AND '06:59:59') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '06:00:00' AND '06:59:59') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '06:00:00' AND '06:59:59') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '06:00:00' AND '06:59:59')
     AS minutos 
*/

/* Funcion del grid Content Del Modulo Gateways*/
function contentGridGateway($anio,$mes,$dia){
 $conexion = new dbconexion(database,host,user,pass);
 $horas = array("'00:00:00' AND '00:59:59'","'01:00:00' AND '01:59:59'","'02:00:00' AND '02:59:59'","'03:00:00' AND '03:59:59'","'04:00:00' AND '04:59:59'",
               "'05:00:00' AND '05:59:59'","'06:00:00' AND '06:59:59'","'07:00:00' AND '07:59:59'","'08:00:00' AND '08:59:59'","'09:00:00' AND '09:59:59'",
               "'10:00:00' AND '10:59:59'","'11:00:00' AND '11:59:59'","'12:00:00' AND '12:59:59'","'13:00:00' AND '13:59:59'","'14:00:00' AND '14:59:59'",
               "'15:00:00' AND '15:59:59'","'16:00:00' AND '16:59:59'","'17:00:00' AND '17:59:59'","'18:00:00' AND '18:59:59'","'19:00:00' AND '19:59:59'",
               "'20:00:00' AND '20:59:59'","'21:00:00' AND '21:59:59'","'22:00:00' AND '22:59:59'","'23:00:00' AND '23:59:59'");
 
 
/* Encabezado */
?>
            +
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableBorder">
            <tr>
            <td colspan="2" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">Gateways</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">00-01</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">01-02</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">02-03</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">03-04</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">04-05</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">05-06</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">06-07</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">07-08</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">08-09</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">09-10</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">10-11</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">11-12</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">12-13</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">13-14</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">14-15</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">15-16</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">16-17</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">17-18</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">18-19</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">19-20</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">20-21</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">21-22</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">22-23</span></div></td>
            <td width="3.5%" class="lineHorizontal"><div align="center"><span class="gridContent">23-24</span></div></td>
          </tr>
<?  
/* fin e encabezado */

/*Cuerpo*/
    $rs = new ResultSet();
    $qry = "show tables";
    $rs=$conexion->executeQuery($qry);
    while($rs->next()){
    $tabla[]=$rs->get(0);
    }
    for($a=0;$a<count($tabla);$a++){
    if($tabla[$a]!="tbl_usuario" and $tabla[$a]!="tbl_configuracion_lote"  and $tabla[$a]!="tbl_configuracion_ocupacional"){
    echo "<tr
    onmouseover=\"this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'\"
    onmouseout=\"this.style.backgroundColor='#FFFFFF';this.style.color='#000000'\" 
    style=\"cursor:default; background-color:#FFFFFF; color='#000000'\"
    >";
    
    ?>
            <td width="8%" class="lineHorizontal lineVerticalD"><span class="gridContent">&nbsp;&nbsp;<?=$tabla[$a];?></span></td>
            <td width="3%" class="lineHorizontal lineVerticalD">
            <table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="lineHorizontal"><div align="center"><span class="gridContent">ASR</span></div></td>
              </tr>
              <tr>
                <td><div align="center"><span class="gridContent">ACD</span></div></td>
              </tr>
            </table>
            </td>
<?
    // del cuerpo dinamico
   for($i=0;$i<count($horas);$i++){  
    $rs=new ResultSet();
    
if($anio=='' and $mes=='' and $dia==''){
    $qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM ".$tabla[$a]." WHERE TIME(RIGHT(TRIM(Received),8)) BETWEEN ".$horas[$i].") 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM ".$tabla[$a]." WHERE Duration>0 AND TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i].") 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM ".$tabla[$a]." WHERE TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i].") 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM ".$tabla[$a]." WHERE TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i].")
     AS minutos";  
}elseif($anio!='' and $mes!='' and $dia!=''){

    $qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
    FROM 
     (SELECT COUNT(*) AS total FROM ".$tabla[$a]." WHERE YEAR(Received)='".$anio."' AND MONTH(Received)='".$mes."' AND DAYOFMONTH(Received)='".$dia."' 
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN ".$horas[$i].") 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM ".$tabla[$a]." WHERE Duration>0 AND YEAR(Dialed)='".$anio."' AND MONTH(Dialed)='".$mes."' AND DAYOFMONTH(Dialed)='".$dia."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i].") 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM ".$tabla[$a]." WHERE YEAR(Dialed)='".$anio."' AND MONTH(Dialed)='".$mes."' AND DAYOFMONTH(Dialed)='29'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i].") 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM ".$tabla[$a]." WHERE YEAR(Dialed)='".$anio."' AND MONTH(Dialed)='".$mes."' AND DAYOFMONTH(Dialed)='".$dia."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i].")
     AS minutos";
    
}
    
     $rs=$conexion->executeQuery($qry);
     while($rs->next()){
     $tempASR=$rs->get('por_completadas_ASR');
     $tempACD=$rs->get('promedio_ACD');
     }    
     
?>
            <td  class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
            <td class="lineHorizontal"><span class="gridContentMin"><?=number_format($tempASR,"1",".","");?></span></td>
            </tr>
            <tr>
            <td><span class="gridContentMin"><?=number_format($tempACD,"1",".","");?></span></td>
            </tr>
            </table>
            </td> 
<?       
}
    
    // Cuerpo dinamico

    }
    }
    echo "</table>+Todos+$anio+$mes+$dia";
/*Fin del cuerpo*/

}
/* Fin Funcion del grid Content Del Modulo Gateways*/

/* Funcion del grid vacio Del Modulo Gateways*/
function contentGridBlankGateway(){
$conexion = new dbconexion(database,host,user,pass);    
?>
         +
         <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableBorder"> 
         <tr>
            <td colspan="2" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">Gateways</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">00-01</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">01-02</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">02-03</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">03-04</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">04-05</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">05-06</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">06-07</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">07-08</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">08-09</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">09-10</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">10-11</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">11-12</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">12-13</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">13-14</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">14-15</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">15-16</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">16-17</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">17-18</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">18-19</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">19-20</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">20-21</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">21-22</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">22-23</span></div></td>
            <td width="3.5%" class="lineHorizontal"><div align="center"><span class="gridContent">23-24</span></div></td>
          </tr>
    <?
    $rs = new ResultSet();
    $qry = "show tables";
    $rs=$conexion->executeQuery($qry);
    while($rs->next()){
    $tabla[]=$rs->get(0);
    }
    for($a=0;$a<count($tabla);$a++){
    if($tabla[$a]!="tbl_usuario" and $tabla[$a]!="tbl_configuracion_lote"  and $tabla[$a]!="tbl_configuracion_ocupacional"){
    echo "<tr
    onmouseover=\"this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'\"
    onmouseout=\"this.style.backgroundColor='#FFFFFF';this.style.color='#000000'\" 
    style=\"cursor:default; background-color:#FFFFFF; color='#000000'\"
    >";
    ?>
            <td width="9%" class="lineHorizontal lineVerticalD"><span class="gridContent">&nbsp;&nbsp;<?=$tabla[$a];?></span></td>
            <td width="5%" class="lineHorizontal lineVerticalD">
            <table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="lineHorizontal"><div align="center"><span class="gridContent">ASR</span></div></td>
              </tr>
              <tr>
                <td><div align="center"><span class="gridContent">ACD</span></div></td>
              </tr>
            </table>
            </td>
            <td  class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
            </td>
            <td  class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
            </td>
            <td  class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td  class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          </table>
          <? 
          }
          }?>
 
<?
}
/* Fin Funcion del grid vacio Del Modulo Gateways*/

/* Funcion del Grid Vacio del Modulo de Puertos*/
function contentGridBlankPort(){
 $conexion = new dbconexion(database,host,user,pass);
?>
  +<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableBorder"> 
         <tr>
            <td colspan="2" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">Puerto / Horas</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">00-01</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">01-02</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">02-03</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">03-04</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">04-05</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">05-06</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">06-07</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">07-08</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">08-09</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">09-10</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">10-11</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">11-12</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">12-13</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">13-14</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">14-15</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">15-16</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">16-17</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">17-18</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">18-19</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">19-20</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">20-21</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">21-22</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">22-23</span></div></td>
            <td width="3.5%" class="lineHorizontal"><div align="center"><span class="gridContent">23-24</span></div></td>
          </tr>
    <?
    $rs = new ResultSet();
    $qry = "select distinct(LocalChannel) from luptmerd order by LocalChannel asc";
    $rs=$conexion->executeQuery($qry);
    while($rs->next()){
    $tabla[]=$rs->get(0);
    }
    for($a=0;$a<count($tabla);$a++){
    echo "<tr
    onmouseover=\"this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'\"
    onmouseout=\"this.style.backgroundColor='#FFFFFF';this.style.color='#000000'\" 
    style=\"cursor:default; background-color:#FFFFFF; color='#000000'\"
    >";
    ?>
            <td width="7%" class="lineHorizontal lineVerticalD"><span class="gridContent">&nbsp;&nbsp;Port <?=$tabla[$a];?></span></td>
            <td width="3%" class="lineHorizontal lineVerticalD">
            <table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="lineHorizontal"><div align="center"><span class="gridContent">ASR</span></div></td>
              </tr>
              <tr>
                <td><div align="center"><span class="gridContent">ACD</span></div></td>
              </tr>
            </table>
            </td>
            <td  class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
            </td>
            <td  class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
            </td>
            <td  class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td  class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td class="lineHorizontal">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
             
            </table></td>
          </tr> 
          <? 
    }

          ?>  
          </table>
<? 

} 
/* Fin del Grid Vacio del modulo de Puertos*/

/* Grid Content de Modulo de puertos*/
function contentGridPort($anio,$mes,$dia,$gateway){
 $conexion = new dbconexion(database,host,user,pass);
 $horas = array("'00:00:00' AND '00:59:59'","'01:00:00' AND '01:59:59'","'02:00:00' AND '02:59:59'","'03:00:00' AND '03:59:59'","'04:00:00' AND '04:59:59'",
               "'05:00:00' AND '05:59:59'","'06:00:00' AND '06:59:59'","'07:00:00' AND '07:59:59'","'08:00:00' AND '08:59:59'","'09:00:00' AND '09:59:59'",
               "'10:00:00' AND '10:59:59'","'11:00:00' AND '11:59:59'","'12:00:00' AND '12:59:59'","'13:00:00' AND '13:59:59'","'14:00:00' AND '14:59:59'",
               "'15:00:00' AND '15:59:59'","'16:00:00' AND '16:59:59'","'17:00:00' AND '17:59:59'","'18:00:00' AND '18:59:59'","'19:00:00' AND '19:59:59'",
               "'20:00:00' AND '20:59:59'","'21:00:00' AND '21:59:59'","'22:00:00' AND '22:59:59'","'23:00:00' AND '23:59:59'");
 ?>
            +<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableBorder"> 
            <tr>
            <td colspan="2" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">Puerto / Horas</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">00-01</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">01-02</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">02-03</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">03-04</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">04-05</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">05-06</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">06-07</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">07-08</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">08-09</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">09-10</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">10-11</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">11-12</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">12-13</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">13-14</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">14-15</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">15-16</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">16-17</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">17-18</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">18-19</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">19-20</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">20-21</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">21-22</span></div></td>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">22-23</span></div></td>
            <td width="3.5%" class="lineHorizontal"><div align="center"><span class="gridContent">23-24</span></div></td>
          </tr>
    <?
    
    $rs = new ResultSet();
    $qry = "select distinct(LocalChannel) from luptmerd order by LocalChannel asc";
    $rs=$conexion->executeQuery($qry);
    while($rs->next()){
    $tabla[]=$rs->get(0);
    }
    for($a=0;$a<count($tabla);$a++){
            
    echo "<tr
    onmouseover=\"this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'\"
    onmouseout=\"this.style.backgroundColor='#FFFFFF';this.style.color='#000000'\" 
    style=\"cursor:default; background-color:#FFFFFF; color='#000000'\"
    >";
    ?>
            <td width="7%" class="lineHorizontal lineVerticalD"><span class="gridContent">&nbsp;&nbsp;Port <?=$tabla[$a];?></span></td>
            <td width="3%" class="lineHorizontal lineVerticalD">
            
            <table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="lineHorizontal"><div align="center"><span class="gridContent">ASR</span></div></td>
              </tr>
              <tr>
                <td><div align="center"><span class="gridContent">ACD</span></div></td>
              </tr>
            </table>
            </td>
            <?
            
                /*
     SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Received)='2007' AND MONTH(Received)='10' AND DAYOFMONTH(Received)='29' 
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN '06:00:00' AND '06:59:59' and LocalChannel='17') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '06:00:00' AND '06:59:59' and LocalChannel='17') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '06:00:00' AND '06:59:59' and LocalChannel='17') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '06:00:00' AND '06:59:59' and LocalChannel='17')
     AS minutos 
     */   
        
 for($i=0;$i<count($horas);$i++){
// De los querys Search
 if($gateway!="false" and $anio=='false' and $mes=='false' and $dia=='false'){
 $qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM ".$gateway."
     WHERE  TIME(RIGHT(TRIM(Received),8)) BETWEEN ".$horas[$i]." and LocalChannel='".$tabla[$a]."') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM ".$gateway." WHERE Duration>0 
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i]." and LocalChannel='".$tabla[$a]."') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM ".$gateway."
     WHERE  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i]." and LocalChannel='".$tabla[$a]."') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM ".$gateway."
     WHERE  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i]." and LocalChannel='".$tabla[$a]."')
     AS minutos";   
    
}elseif($anio!="false" and $gateway!="false" and $mes=='false' and $dia=='false'){
$qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM ".$gateway." WHERE YEAR(Received)='".$anio."' 
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN ".$horas[$i]." and LocalChannel='".$tabla[$a]."') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM ".$gateway." WHERE Duration>0 AND YEAR(Dialed)='".$anio."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i]." and LocalChannel='".$tabla[$a]."') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM ".$gateway." WHERE YEAR(Dialed)='".$anio."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i]." and LocalChannel='".$tabla[$a]."') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM ".$gateway." WHERE YEAR(Dialed)='".$anio."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i]." and LocalChannel='".$tabla[$a]."')
     AS minutos";
}elseif($anio!="false" and $mes!="false" and $gateway!="false" and $dia=='false'){

 $qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM ".$gateway." WHERE YEAR(Received)='".$anio."' AND MONTH(Received)='".$mes."'
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN ".$horas[$i]." and LocalChannel='".$tabla[$a]."') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM ".$gateway." WHERE Duration>0 AND YEAR(Dialed)='".$anio."'  AND MONTH(Dialed)='".$mes."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i]." and LocalChannel='".$tabla[$a]."') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM ".$gateway." WHERE YEAR(Dialed)='".$anio."'  AND MONTH(Dialed)='".$mes."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i]." and LocalChannel='".$tabla[$a]."') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM ".$gateway." WHERE YEAR(Dialed)='".$anio."'  AND MONTH(Dialed)='".$mes."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i]." and LocalChannel='".$tabla[$a]."')
     AS minutos";

}elseif($anio!="false" and $mes!="false" and $dia!="false" and $gateway!="false"){

$qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM ".$gateway." WHERE YEAR(Received)='".$anio."' AND MONTH(Received)='".$mes."' AND DAYOFMONTH(Received)='".$dia."' 
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN ".$horas[$i]." and LocalChannel='".$tabla[$a]."') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM ".$gateway." WHERE Duration>0 AND YEAR(Dialed)='".$anio."' AND MONTH(Dialed)='".$mes."' AND DAYOFMONTH(Dialed)='".$dia."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i]." and LocalChannel='".$tabla[$a]."') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM ".$gateway." WHERE YEAR(Dialed)='".$anio."' AND MONTH(Dialed)='".$mes."' AND DAYOFMONTH(Dialed)='".$dia."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i]." and LocalChannel='".$tabla[$a]."') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM ".$gateway." WHERE YEAR(Dialed)='".$anio."' AND MONTH(Dialed)='".$mes."' AND DAYOFMONTH(Dialed)='".$dia."'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN ".$horas[$i]." and LocalChannel='".$tabla[$a]."')
     AS minutos";
    
}
// fin de los querys search

            $rs = new ResultSet();
            $rs=$conexion->executeQuery($qry);
            while($rs->next()){
                $tempASR=$rs->get('por_completadas_ASR');
                $tempACD=$rs->get('promedio_ACD');
              }    
            ?>
            <td  class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="lineHorizontal"><span class="gridContentMin"><?=number_format($tempASR,"1",".","");?></span></td>
              </tr>
              <tr>
                <td><span class="gridContentMin"><?=number_format($tempACD,"1",".","");?></span></td>
              </tr>
            </table>
            </td>
            <? 
             }
            ?>
           
           </td>
          </tr> 
          <? 
    }
    
    echo"</table>+$gateway+$anio+$mes+$dia";
}
/* Fin Grid Content de Modulo de puertos*/

/*
* Funcion de reemplazos
*/

 //-----------------------------
/* combo de años ajax  modulo general*/
if($_GET['ajax']==1)
{
//$anio= new Datetime_Now();
//$anio->GetYear();    
/* Inicio del Modulo General*/
$gateway=$_POST['gateway'];    
if($_GET['modulo']=='general'){
if($gateway!='false'){
$rs=new ResultSet();
$qry="select DISTINCT(year(Received)) as anio from ".$gateway." order by anio asc";
$rs=$conexion->executeQuery($qry);
echo "
<select name='cbx_anios'  class='styleCBX' id='cbx_anios' onchange='mipanel.mesesAjax(this)'>
<option value='false'>Seleccione</option>
";         
while($rs->next()){ 
$tempanio=$rs->get('anio');
?>
<option value='<?=$tempanio;?>'><?=$tempanio;?></option>         
<? 
}
echo "</select>";
contentGrid("false","false","false",$gateway);
      
}else{
//echo "false";
contentGridBlank();
}
}
/*Fin Inicio del Modulo General*/
/* Inicio del Modulo Gateway*/  
if($_GET['modulo']=='gateway'){
$anio=$_POST['anio'];
$mes=$_POST['mes'];
$dia=$_POST['dia'];
contentGridGateway($anio,$mes,$dia);
}
/* fin combo de años ajax Modulo Gateway */   
/* Del modulo de Puertos */
if($_GET['modulo']=='puerto'){
if($gateway!='false'){
$rs=new ResultSet();
$qry="select DISTINCT(year(Received)) as anio from ".$gateway." order by anio asc";
$rs=$conexion->executeQuery($qry);
echo "
<select name='cbx_anios'  class='styleCBX' id='cbx_anios' onchange='mipanel.mesesAjax(this)'>
<option value='false'>Seleccione</option>
";         
while($rs->next()){ 
$tempanio=$rs->get('anio');
?>
<option value='<?=$tempanio;?>'><?=$tempanio;?></option>         
<? 
}
echo "</select>";
contentGridPort("false","false","false",$gateway);
      
}else{
//echo "false";
contentGridBlankPort();
}
    
}
/* Fin Del modulo de Puertos */

}




/* combo de meses en ajax*/
if($_GET['ajax']==2)
{
$gateway=$_POST['gateway'];
$anio=$_POST['anio'];
$modulo=$_GET['modulo'];
/* Inicio del modulo General*/
if($modulo=='general'){
if($anio!='false'){
$rs=new ResultSet();
$qry="select DISTINCT(month(Received)) as mes from ".$gateway." where year(Received)='".$anio."' order by mes asc";
$rs=$conexion->executeQuery($qry);
echo "
<select name='cbx_meses'  class='styleCBX' id='cbx_meses' onchange='mipanel.diaAjax(this)'>
<option value='false'>Seleccione</option>";
while($rs->next()){
$mes=$rs->get('mes'); 
if($mes=='01'){$tempmes='Enero';}
if($mes=='02'){$tempmes='Febrero';}
if($mes=='03'){$tempmes='Marzo';}
if($mes=='04'){$tempmes='Abril';}
if($mes=='05'){$tempmes='Mayo';}
if($mes=='06'){$tempmes='Junio';}
if($mes=='07'){$tempmes='Julio';}
if($mes=='08'){$tempmes='Agosto';}
if($mes=='09'){$tempmes='Septiembre';}
if($mes=='10'){$tempmes='Octubre';}
if($mes=='11'){$tempmes='Noviembre';}
if($mes=='12'){$tempmes='Diciembre';}
?>
<option value="<?=$mes;?>"><?=$tempmes;?></option>
<?
}
echo "</select>";
/*Actualizo la tabla con los datos del año seleccionado*/
contentGrid($anio,"false","false",$gateway);
/* fin  Actualizo la tabla con los datos del año seleccionado*/
}else{
//echo "false";
contentGrid("false","false","false",$gateway);
}
}
/*Fin del modulo general*/

/*Inicio del modulo de puertos*/
if($modulo=='puerto'){  
 if($anio!='false'){
$rs=new ResultSet();
$qry="select DISTINCT(month(Received)) as mes from ".$gateway." where year(Received)='".$anio."' order by mes asc";
$rs=$conexion->executeQuery($qry);
echo "
<select name='cbx_meses'  class='styleCBX' id='cbx_meses' onchange='mipanel.diaAjax(this)'>
<option value='false'>Seleccione</option>";
while($rs->next()){
$mes=$rs->get('mes'); 
if($mes=='01'){$tempmes='Enero';}
if($mes=='02'){$tempmes='Febrero';}
if($mes=='03'){$tempmes='Marzo';}
if($mes=='04'){$tempmes='Abril';}
if($mes=='05'){$tempmes='Mayo';}
if($mes=='06'){$tempmes='Junio';}
if($mes=='07'){$tempmes='Julio';}
if($mes=='08'){$tempmes='Agosto';}
if($mes=='09'){$tempmes='Septiembre';}
if($mes=='10'){$tempmes='Octubre';}
if($mes=='11'){$tempmes='Noviembre';}
if($mes=='12'){$tempmes='Diciembre';}
?>
<option value="<?=$mes;?>"><?=$tempmes;?></option>
<?
}
echo "</select>";
/*Actualizo la tabla con los datos del año seleccionado*/
contentGridPort($anio,"false","false",$gateway);
/* fin  Actualizo la tabla con los datos del año seleccionado*/
}else{
//echo "false";
contentGridPort("false","false","false",$gateway);
}
}
/*Fin del modulo de puertos*/

}
/* fin combo de meses en ajax*/

/* Combo de los dias con Ajax*/
if($_GET['ajax']==3)
{
 $gateway=$_POST['gateway']; 
 $mes=$_POST['mes'];
 $anio=$_POST['anio'];
 $modulo=$_GET['modulo'];
 if($modulo=='general'){
 if($mes != 'false'){
 $rs=new ResultSet();
 $qry="select DISTINCT(day(Received)) as dia from ".$gateway." where month(Received)='".$mes."' order by dia asc";
 $rs=$conexion->executeQuery($qry);
 echo "
 <select id='cbx_dias' name='cbx_dias' class='styleCBX' onchange='mipanel.gridAjax(this)'>
 <option value='false'>Seleccione</option>";
while($rs->next()){
$dia=$rs->get('dia'); 
?>
<option value="<?=$dia;?>"><?=$dia;?></option>
<?
 }
 echo"</select>";
 
 /* inicio en pintar la tabla del mes del años especificado*/
 
contentGrid($anio,$mes,"false",$gateway);
 
 /* Fin inicio de ointar del ms del año especificad*/
     
}else{
//echo "false+";
contentGrid($anio,"false","false",$gateway);
}
 }
 //--------modulo_gateway
 
 if($modulo=='puerto'){
 if($mes != 'false'){
 $rs=new ResultSet();
 $qry="select DISTINCT(day(Received)) as dia from ".$gateway." where month(Received)='".$mes."' order by dia asc";
 $rs=$conexion->executeQuery($qry);
 echo "
 <select id='cbx_dias' name='cbx_dias' class='styleCBX' onchange='mipanel.gridAjax(this)'>
 <option value='false'>Seleccione</option>";
while($rs->next()){
$dia=$rs->get('dia'); 
?>
<option value="<?=$dia;?>"><?=$dia;?></option>
<?
 }
 echo"</select>";
 
 /* inicio en pintar la tabla del mes del años especificado*/
 
contentGridPort($anio,$mes,"false",$gateway);
 
 /* Fin inicio de ointar del ms del año especificad*/
     
}else{
//echo "false+";
contentGridPort($anio,"false","false",$gateway);
}
 }
 
}
/* Fin Combo de los dias con Ajax*/

/* Lenna Grid con ajax */
if($_GET['ajax']==4)
{
 $gateway=$_POST['gateway']; 
 $anio=$_POST['anio'];
 $dia=$_POST['dia'];
 $mes=$_POST['mes'];
 $modulo=$_GET['modulo'];
 if($modulo=='general'){
 if($dia!= 'false'){
   contentGrid($anio,$mes,$dia,$gateway);
  }else{
   contentGrid($anio,$mes,"false",$gateway);
    }
 }
 if($modulo=='gateway'){
   contentGridGateway($anio,$mes,$dia);     
 }
 
 if($modulo=='puerto'){
  if($dia!= 'false'){
   contentGridPort($anio,$mes,$dia,$gateway);
  }else{
   contentGridPort($anio,$mes,"false",$gateway);
    }       
 }
 
}

/* Fin Lenna Grid con ajax */

/*
* Fin Modulo de gateway combox 
*/ 


/*
* Modulo de Configuracion 
*/
/* Modulo de cambio de acceso*/
 if($_GET['ajax']==5){
 
 $user_old=$_POST['user_old'];
 $pass_old=$_POST['pass_old'];
 $user_new=$_POST['user_new'];
 $pass_new=$_POST['pass_new'];
 
 $rs=new ResultSet();
 $qry="select * from tbl_usuario where username='".$user_old."' and password='".md5($pass_old)."'";
 $rs=$conexion->executeQuery($qry);
 $tempuser=$rs->get('username');
 if($tempuser != ""){
//    $query="insert into tbl_usuario(username,password) values('$user_new','".md5($pass_new)."')";
    $query="update tbl_usuario set password='".md5($pass_new)."' where username='$user_new'";
     $conexion->BeginTransaction();
     if($conexion->executeUpdate($query)){
         echo "Actualizacion finalizada.";
         $conexion->EndTransaction();     
     }else{
         $conexion->RollBack();
         echo "Ocurrio un error al actualizar. Intente de nuevo";
     }
 }else{
    echo "Los datos del usuario anterior no son correctos.";
 }     
 }
 /* Fin Modulo de cambio de acceso*/




/* Modulo  Configuracion de ocupacionales */
if($_GET['ajax']==7){  
    $txt_inicio=$_POST['txt_fecha_inicio'];
    $txt_final=$_POST['txt_fecha_fin'];
    $gateway=$_POST['gateway'];
    $minutos=$_POST['minutos'];
    $qry="insert into tbl_configuracion_ocupacional(fecha_inicio,fecha_fin,gateway,minutos_disponibles) value('$txt_inicio','$txt_final','$gateway','$minutos')";
    $conexion->BeginTransaction();
    if($conexion->executeQuery($qry)){
        //echo "true";
    $conexion->EndTransaction();
    // hago un select y vuelvo a cargar la pagina;
    $rs=new ResultSet();
    $qry="select * from tbl_configuracion_ocupacional order by gateway asc";
    $rs=$conexion->executeQuery($qry);
    ?>      
    <table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="tableBorder">
       <tr>
           <td width="21%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Gateway</span></div></td>
           <td width="25%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Fecha inicio</span></div></td>
           <td width="25%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Fecha Final</span></div></td>
           <td width="21%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Minutos</span></div></td>
           <td width="4%" class="lineHorizontal lineVerticalD">&nbsp;</td>
           <td width="4%" class="lineHorizontal">&nbsp;</td>
       </tr>
    <?
    while($rs->next()){
        $tempinicio=$rs->get('fecha_inicio');
        $tempfinal=$rs->get('fecha_fin');
        $tempgateway=$rs->get('gateway');
        $tempMinutos=$rs->get('minutos_disponibles');
        $tempid=$rs->get('idconfiguracion');
         echo "<tr id='ocupacion_$tempid'
         onmouseover=\"this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'\"
         onmouseout=\"this.style.backgroundColor='#FFFFFF';this.style.color='#000000'\" 
         style=\"cursor:default; background-color:#FFFFFF; color='#000000'\"
         >";
    ?>
            <td class="lineHorizontal lineVerticalD" id='ocupacion_gateway_<?=$tempid;?>'><div align="center"><span id="rowGateway_<?=$tempid;?>" class="gridContent"><?=$tempgateway;?></span></div></td>
            <td class="lineHorizontal lineVerticalD" id='ocupacion_fechaini_<?=$tempid;?>'><div align="center"><span id="rowFechainicio_<?=$tempid;?>" class="gridContent"><?=$tempinicio;?></span></div></td>
            <td class="lineHorizontal lineVerticalD" id='ocupacion_fechafin_<?=$tempid;?>'><div align="center"><span id="rowFechafin_<?=$tempid;?>" class="gridContent"><?=$tempfinal;?></span></div></td>
            <td class="lineHorizontal lineVerticalD" id='ocupacion_minutos_<?=$tempid;?>'><div align="center"><span id="rowMinutos_<?=$tempid;?>" class="gridContent"><?=$tempMinutos;?></span></div></td>
            <td class="lineHorizontal lineVerticalD" id='ocupacion_btn1_<?=$tempid;?>'><div align="center"><img src="images/editar.gif" border="0" name="<?=$tempid;?>" style="cursor:pointer" onclick="miconfig.modificarocupacion(this);" /></div></td>
            <td class="lineHorizontal" id='ocupacion_btn2_<?=$tempid;?>'><div align="center"><img src="images/eliminar.gif" name="<?=$tempid;?>" border="0" style="cursor:pointer" onclick="miconfig.eliminarocupacion(this);" /></div></td>
       <tr>
<?        
    }   
?>    
    </table>
<?        
    }else{
        $conexion->RollBack();
        //echo "false";
    }
      
}


/* Fin Modulo  Configuracion de ocupacionales */

/* Modulo  Configuracion de ocupacionales Eliminar */
if($_GET['ajax']==8){  

    $id=$_POST['id'];
    $qry="delete from tbl_configuracion_ocupacional where idconfiguracion='$id'";
    $conexion->BeginTransaction();
    if($conexion->executeQuery($qry)){
    $conexion->EndTransaction();
    
    // hago un select y vuelvo a cargar la pagina;
    $rs=new ResultSet();
    $qry="select * from tbl_configuracion_ocupacional order by gateway asc";
    $rs=$conexion->executeQuery($qry);
    ?>
    <table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="tableBorder">
       <tr>
           <td width="21%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Gateway</span></div></td>
           <td width="25%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Fecha inicio</span></div></td>
           <td width="25%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Fecha Final</span></div></td>
           <td width="21%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Minutos</span></div></td>
           <td width="4%" class="lineHorizontal lineVerticalD">&nbsp;</td>
           <td width="4%" class="lineHorizontal">&nbsp;</td>
       </tr>
    <?
    while($rs->next()){
        $tempinicio=$rs->get('fecha_inicio');
        $tempfinal=$rs->get('fecha_fin');
        $tempgateway=$rs->get('gateway');
        $tempMinutos=$rs->get('minutos_disponibles');
        $tempid=$rs->get('idconfiguracion');
         echo "<tr id='ocupacion_$tempid'
         onmouseover=\"this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'\"
         onmouseout=\"this.style.backgroundColor='#FFFFFF';this.style.color='#000000'\" 
         style=\"cursor:default; background-color:#FFFFFF; color='#000000'\"
         >";
    ?>
            <td class="lineHorizontal lineVerticalD" id='ocupacion_gateway_<?=$tempid;?>'><div align="center"><span id="rowGateway_<?=$tempid;?>" class="gridContent"><?=$tempgateway;?></span></div></td>
            <td class="lineHorizontal lineVerticalD" id='ocupacion_fechaini_<?=$tempid;?>'><div align="center"><span id="rowFechainicio_<?=$tempid;?>" class="gridContent"><?=$tempinicio;?></span></div></td>
            <td class="lineHorizontal lineVerticalD" id='ocupacion_fechafin_<?=$tempid;?>'><div align="center"><span id="rowFechafin_<?=$tempid;?>" class="gridContent"><?=$tempfinal;?></span></div></td>
            <td class="lineHorizontal lineVerticalD" id='ocupacion_minutos_<?=$tempid;?>'><div align="center"><span id="rowMinutos_<?=$tempid;?>" class="gridContent"><?=$tempMinutos;?></span></div></td>
            <td class="lineHorizontal lineVerticalD" id='ocupacion_btn1_<?=$tempid;?>'><div align="center"><img src="images/editar.gif" border="0" name="<?=$tempid;?>" style="cursor:pointer" onclick="miconfig.modificarocupacion(this);" /></div></td>
            <td class="lineHorizontal" id='ocupacion_btn2_<?=$tempid;?>'><div align="center"><img src="images/eliminar.gif" name="<?=$tempid;?>" border="0" style="cursor:pointer" onclick="miconfig.eliminarocupacion(this);" /></div></td>
       <tr>
<?        
    }   
?>    
    </table>
<?        
    }else{
        $conexion->RollBack();
    }    
}       
/* Fin Modulo  Configuracion de ocupacionales Eliminar */

/* Configuracion de ocupacionales Modificar*/
if($_GET['ajax']==9){
$tempid=$_POST['row'];
$tempgateway=$_POST['gateway'];
$tempinicio=$_POST['fechainicio'];
$tempfinal=$_POST['fechafin'];
$tempMinutos=$_POST['minutos'];
echo $tempid."+";
$rs=new ResultSet();
$qry="show tables";
$rs=$conexion->executeQuery($qry);
while($rs->next()){
    $gatewayTemp=$rs->get(0);
     if($gatewayTemp !="tbl_usuario" and $gatewayTemp !="tbl_configuracion_lote"  and $gatewayTemp !="tbl_configuracion_ocupacional" and $gatewayTemp != "tbl_configuracion_ip"){
     $arrayGateway[]=$gatewayTemp;         
     //echo $gatewayTemp;
     }   
}
?>
  <div align="center">
    <span id="rowGateway_<?=$tempid;?>" class="gridContent"><select id="cbx_gateway_<?=$tempid;?>" class="boxTextGrid"><? for($i=0;$i<count($arrayGateway);$i++){ if($arrayGateway[$i]==$tempgateway){echo "<option value=$arrayGateway[$i] selected>$arrayGateway[$i]</option>";}else{ echo "<option value=$arrayGateway[$i]>$arrayGateway[$i]</option>";}}?></select></span>
  </div>
  +
  <div align="center">
    <span id="rowFechainicio_<?=$tempid;?>" class="gridContent"><input type="text" id="txt_mod_fecha_inicio_<?=$tempid;?>" size="10" class="boxTextGrid" value="<?=$tempinicio;?>" readonly="readonly" ></span>&nbsp;<img src="images/calendario.gif" width="16" height="16" name="btn_mod_fecha_inicio" id="btn_mod_fecha_inicio" style="cursor:pointer"/>
  </div>
  +
  <div align="center">
    <span id="rowFechafin_<?=$tempid;?>" class="gridContent"><input type="text" id="txt_mod_fecha_fin_<?=$tempid;?>" size="10" class="boxTextGrid"   value="<?=$tempfinal;?>" readonly="readonly" ></span>&nbsp;<img src="images/calendario.gif" width="16" height="16" id="btn_mod_fecha_fin" style="cursor:pointer" />
  </div>
  +
  <div align="center">
    <span id="rowMinutos_<?=$tempid;?>" class="gridContent"><input type="text" id="txt_mod_minutos_<?=$tempid;?>" size="10" class="boxTextGrid"  value="<?=$tempMinutos;?>" ></span>
  </div>
  +
  <div align="center">
    <img src="images/guardar.gif" border="0" name="<?=$tempid;?>" style="cursor:pointer" onclick="miconfig.guardarocupacion(this);" />
  </div>
  +
  <div align="center">
    <img src="images/cancelar.gif" name="<?=$tempid;?>" border="0" style="cursor:pointer" onclick="miconfig.cancelarocupacion(this);" />
  </div>
  +
  Calendar.setup(
      {
          inputField  : "txt_mod_fecha_inicio_<?=$tempid;?>",         // ID of the input field
          ifFormat    : "%Y-%m-%d",    // the date format
          button      : "btn_mod_fecha_inicio"       // ID of the button
      }
  ); 
  +
  Calendar.setup(
      {
          inputField  : "txt_mod_fecha_fin_<?=$tempid;?>",         // ID of the input field
          ifFormat    : "%Y-%m-%d",    // the date format
          button      : "btn_mod_fecha_fin"       // ID of the button
      }
  ); 
<?    
    
}
/* Fin Configuracion de ocupacionales Modificar*/

/* Configuracion de ocupacionales Modificar Cancelar*/
if($_GET['ajax']==10){ 
    $row=$_POST['row'];
    $rs= new ResultSet();
    $qry="select * from tbl_configuracion_ocupacional where idconfiguracion='$row'";
    $rs=$conexion->executeQuery($qry);  
    
    while($rs->next()){
    $tempinicio=$rs->get('fecha_inicio');
    $tempfinal=$rs->get('fecha_fin');
    $tempgateway=$rs->get('gateway');
    $tempMinutos=$rs->get('minutos_disponibles');
    $tempid=$rs->get('idconfiguracion');
    echo $tempid."+";
?>                 
  <div align="center">
    <span id="rowGateway_<?=$tempid;?>" class="gridContent"><?=$tempgateway;?></span>    
  </div>
  +
  <div align="center">
    <span id="rowFechainicio_<?=$tempid;?>" class="gridContent"><?=$tempinicio;?></span>
  </div>
  +
  <div align="center">
    <span id="rowFechafin_<?=$tempid;?>" class="gridContent"><?=$tempfinal;?></span>
  </div>
  +
  <div align="center">
    <span id="rowMinutos_<?=$tempid;?>" class="gridContent"><?=$tempMinutos;?></span>
  </div>
  +
  <div align="center">
    <img src="images/editar.gif" border="0" name="<?=$tempid;?>" style="cursor:pointer" onclick="miconfig.modificarocupacion(this);" />
  </div>
  +
  <div align="center">
    <img src="images/eliminar.gif" name="<?=$tempid;?>" border="0" style="cursor:pointer" onclick="miconfig.eliminarocupacion(this);" />
  </div>
<? 
    }
}
/* Fin Configuracion de ocupacionales Modificar Cancelar*/

/* Guardar la configuracion de ocupacionales*/
if($_GET['ajax']==11){  
    $row=$_POST['row'];
    $gateway=$_POST['gateway'];
    $fechainicio=$_POST['fechainicio'];
    $fechafin=$_POST['fechafin'];
    $minutos=$_POST['minutos'];
 
 $qry="update tbl_configuracion_ocupacional set gateway='$gateway',fecha_inicio='$fechainicio',fecha_fin='$fechafin',minutos_disponibles='$minutos' where idconfiguracion='$row'";  
 
 $conexion->BeginTransaction();
 if($conexion->executeQuery($qry)){
  $conexion->EndTransaction();
  
  $rs= new ResultSet();
  $qry="select * from tbl_configuracion_ocupacional where idconfiguracion='$row'";
  $rs=$conexion->executeQuery($qry);
    while($rs->next()){
        $tempinicio=$rs->get('fecha_inicio');
        $tempfinal=$rs->get('fecha_fin');
        $tempgateway=$rs->get('gateway');
        $tempMinutos=$rs->get('minutos_disponibles');
        $tempid=$rs->get('idconfiguracion');
         echo $row."+";  
?>
            <div align="center">
                <span id="rowGateway_<?=$tempid;?>" class="gridContent"><?=$tempgateway;?></span>
            </div>
            +
            <div align="center">
                <span id="rowFechainicio_<?=$tempid;?>" class="gridContent"><?=$tempinicio;?></span>
            </div>
            +
            <div align="center">
                <span id="rowFechafin_<?=$tempid;?>" class="gridContent"><?=$tempfinal;?></span>
            </div>
            +
            <div align="center">
                <span id="rowMinutos_<?=$tempid;?>" class="gridContent"><?=$tempMinutos;?></span>
            </div>
            +
            <div align="center">
                <img src="images/editar.gif" border="0" name="<?=$tempid;?>" style="cursor:pointer" onclick="miconfig.modificarocupacion(this);" />
            </div>
            +
            <div align="center">
                <img src="images/eliminar.gif" name="<?=$tempid;?>" border="0" style="cursor:pointer" onclick="miconfig.eliminarocupacion(this);" />
            </div>
<?
    }
 }else{
    $conexion->RollBack();
 }  
}
/* Fin Guardar la configuracion de ocupacionales*/


/* Modulo  Configuracion de lote */
if($_GET['ajax']==12){  

    $gateway=$_POST['gateway'];
    $cantidad=$_POST['cantidad'];
    $qry="insert into tbl_configuracion_lote(gateway,cantidad) value('$gateway','$cantidad')";
    $conexion->BeginTransaction();
    if($conexion->executeQuery($qry)){
        //echo "true";
    $conexion->EndTransaction();
    // hago un select y vuelvo a cargar la pagina;
    $rs=new ResultSet();
    $qry="select * from tbl_configuracion_lote order by gateway,cantidad asc";
    $rs=$conexion->executeQuery($qry);
    ?>
    <table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="tableBorder">
       <tr>
            <td width="45.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Gateway</span></div></td>
            <td width="45.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Minutos</span></div></td>
            <td width="4.5%" class="lineHorizontal lineVerticalD">&nbsp;</td>
            <td width="4.5%" class="lineHorizontal">&nbsp;</td>
       </tr>
    <?
    while($rs->next()){
        $tempgateway=$rs->get('gateway');
        $tempMinutos=$rs->get('cantidad');
        $tempid=$rs->get('idlote');
         echo "<tr id='lote_$tempid'
         onmouseover=\"this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'\"
         onmouseout=\"this.style.backgroundColor='#FFFFFF';this.style.color='#000000'\" 
         style=\"cursor:default; background-color:#FFFFFF; color='#000000'\"
         >";
    ?>
            <td class="lineHorizontal lineVerticalD" id='lote_gateway_<?=$tempid;?>'><div align="center"><span id="rowGatewayLote_<?=$tempid;?>" class="gridContent"><?=$tempgateway;?></span></div></td>
            <td class="lineHorizontal lineVerticalD" id='lote_cantidad_<?=$tempid;?>'><div align="center"><span id="rowCantidad_<?=$tempid;?>" class="gridContent"><?=$tempMinutos;?></span></div></td>
            <td class="lineHorizontal lineVerticalD" id='lote_btn1_<?=$tempid;?>'><div align="center"><img src="images/editar.gif" border="0" name="<?=$tempid;?>" style="cursor:pointer" onclick="miconfig.modificarlote(this);" /></div></td>
            <td class="lineHorizontal" id='lote_btn2_<?=$tempid;?>'><div align="center"><img src="images/eliminar.gif" name="<?=$tempid;?>" border="0" style="cursor:pointer" onclick="miconfig.eliminarlote(this);" /></div></td>
         </tr>
<?        
    }   
?>    
    </table>
<?        
    }else{
        $conexion->RollBack();
        //echo "false";
    }
      
}
/* Fin Modulo  Configuracion de lote */

/* Modificar lote*/
if($_GET['ajax']==13){
$tempid=$_POST['row'];
$tempgateway=$_POST['gateway'];
$tempMinutos=$_POST['cantidad'];
echo $tempid."+";
$rs=new ResultSet();
$qry="show tables";
$rs=$conexion->executeQuery($qry);
while($rs->next()){
    $gatewayTemp=$rs->get(0);
     if($gatewayTemp !="tbl_usuario" and $gatewayTemp !="tbl_configuracion_lote"  and $gatewayTemp !="tbl_configuracion_ocupacional" and $gatewayTemp != "tbl_configuracion_ip"){
     $arrayGateway[]=$gatewayTemp;         
     //echo $gatewayTemp;
     }   
}
?>
  <div align="center">
      <span id="rowGateway_<?=$tempid;?>" class="gridContent">
        <select id="cbx_gatewaylote_<?=$tempid;?>" class="boxTextGrid"><? for($i=0;$i<count($arrayGateway);$i++){ if($arrayGateway[$i]==$tempgateway){echo "<option value=$arrayGateway[$i] selected>$arrayGateway[$i]</option>";}else{ echo "<option value=$arrayGateway[$i]>$arrayGateway[$i]</option>";}}?></select>
      </span>
  </div>
  +
  <div align="center">
    <span id="rowCantidad_<?=$tempid;?>" class="gridContent"><input type="text" id="txt_mod_cantidad_<?=$tempid;?>" size="10" class="boxTextGrid"  value="<?=$tempMinutos;?>" ></span>
  </div>
  +
  <div align="center">
    <img src="images/guardar.gif" border="0" name="<?=$tempid;?>" style="cursor:pointer" onclick="miconfig.guardarlote(this);" />
  </div>
  +
  <div align="center">
    <img src="images/cancelar.gif" name="<?=$tempid;?>" border="0" style="cursor:pointer" onclick="miconfig.cancelarlote(this);" />
  </div>
<?    
}
/* Fin Modificar lote*/
/*
if($_GET['ajax']==13){
$tempid=$_POST['row'];
$tr='lote_'.$_POST['row'];
$tempgateway=$_POST['gateway'];
$tempMinutos=$_POST['cantidad'];
//echo $tempid."+";
$rs=new ResultSet();
$qry="show tables";
$rs=$conexion->executeQuery($qry);
while($rs->next()){
    $gatewayTemp=$rs->get(0);
     if($gatewayTemp !="tbl_usuario" and $gatewayTemp !="tbl_configuracion_lote"  and $gatewayTemp !="tbl_configuracion_ocupacional" and $gatewayTemp != "tbl_configuracion_ip"){
     $arrayGateway[]=$gatewayTemp;         
     //echo $gatewayTemp;
     }   
}
echo "
    var grid = document.getElementById('gridLote');
    var table = grid.getElementsByTagName('table');
    var table = table[0];
    var list_rows = new Array();
    var temp_list_rows = table.getElementsByTagName('tr');
    //alert('$tr');

    for(var i = 0; i < temp_list_rows.length; i++){
        //alert(temp_list_rows[i].id);
        if(temp_list_rows[i].id == '$tr'){
            //alert(temp_list_rows[i].id)
            var tr = temp_list_rows[i];
            break;
        }
    }
    //alert(tr.id);
    //alert(tr.hasChildNodes());

    var nodes = tr.childNodes;
    //alert(nodes.length);

    i=0;
    while (tr.hasChildNodes()) 
    {
        //alert(nodes[i].tagName);
        tr.removeChild(nodes[i]);
        i++;
    }
";
}
*/
/* Guardar la configuracion de ocupacionales*/
if($_GET['ajax']==14){  
    $row=$_POST['row'];
    $gateway=$_POST['gateway'];
    $cantidad=$_POST['cantidad'];
 
 $qry="update tbl_configuracion_lote set gateway='$gateway',cantidad='$cantidad' where idlote='$row'";  
 
 $conexion->BeginTransaction();
 if($conexion->executeQuery($qry)){
  $conexion->EndTransaction();
  
  $rs= new ResultSet();
  $qry="select * from tbl_configuracion_lote where idlote='$row'";
  $rs=$conexion->executeQuery($qry);
    while($rs->next()){
        $tempgateway=$rs->get('gateway');
        $tempMinutos=$rs->get('cantidad');
        $tempid=$rs->get('idlote');
         echo $row."+";  
?>
            <div align="center">
                <span id="rowGatewayLote_<?=$tempid;?>" class="gridContent"><?=$tempgateway;?></span>
            </div>
            +
            <div align="center">
                <span id="rowCantidad_<?=$tempid;?>" class="gridContent"><?=$tempMinutos;?></span>
            </div>
            +
            <div align="center">
                <img src="images/editar.gif" border="0" name="<?=$tempid;?>" style="cursor:pointer" onclick="miconfig.modificarlote(this);" />
            </div>
            +
            <div align="center">
                <img src="images/eliminar.gif" name="<?=$tempid;?>" border="0" style="cursor:pointer" onclick="miconfig.eliminarlote(this);" />
            </div>
<?
    }
 }else{
 $conexion->RollBack();
 }  
}
/* Fin Guardar la configuracion de ocupacionales*/

/* Configuracion de lote Modificar Cancelar*/
if($_GET['ajax']==15){ 
    $row=$_POST['row'];
    $rs= new ResultSet();
    $qry="select * from tbl_configuracion_lote where idlote='$row'";
    $rs=$conexion->executeQuery($qry);  
    
    while($rs->next()){
    $tempgateway=$rs->get('gateway');
    $tempMinutos=$rs->get('cantidad');
    $tempid=$rs->get('idlote');
    echo $tempid."+";
?>                 
    <div align="center">
        <span id="rowGatewayLote_<?=$tempid;?>" class="gridContent"><?=$tempgateway;?></span>
    </div>
    +
    <div align="center">
        <span id="rowCantidad_<?=$tempid;?>" class="gridContent"><?=$tempMinutos;?></span>
    </div>
    +
    <div align="center">
        <img src="images/editar.gif" border="0" name="<?=$tempid;?>" style="cursor:pointer" onclick="miconfig.modificarlote(this);" />
    </div>
    +
    <div align="center">
        <img src="images/eliminar.gif" name="<?=$tempid;?>" border="0" style="cursor:pointer" onclick="miconfig.eliminarlote(this);" />
    </div>
<? 
    }
}
/* Fin Configuracion de lote Modificar Cancelar*/

/* Modulo  Configuracion de lote Eliminar */
if($_GET['ajax']==16){  

    $id=$_POST['id'];
    $qry="delete from tbl_configuracion_lote where idlote='$id'";
    $conexion->BeginTransaction();
    if($conexion->executeQuery($qry)){
    $conexion->EndTransaction();
    
    // hago un select y vuelvo a cargar la pagina;
    $rs=new ResultSet();
    $qry="select * from tbl_configuracion_lote order by gateway,cantidad asc";
    $rs=$conexion->executeQuery($qry);
    ?>
    <table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="tableBorder">
       <tr>
            <td width="45.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Gateway</span></div></td>
            <td width="45.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Minutos</span></div></td>
            <td width="4.5%" class="lineHorizontal lineVerticalD">&nbsp;</td>
            <td width="4.5%" class="lineHorizontal">&nbsp;</td>
       </tr>
    <?
    while($rs->next()){
        $tempgateway=$rs->get('gateway');
        $tempMinutos=$rs->get('cantidad');
        $tempid=$rs->get('idlote');
         echo "<tr id='lote_$tempid'
         onmouseover=\"this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'\"
         onmouseout=\"this.style.backgroundColor='#FFFFFF';this.style.color='#000000'\" 
         style=\"cursor:default; background-color:#FFFFFF; color='#000000'\"
         >";
    ?>
            <td class="lineHorizontal lineVerticalD" id='lote_gateway_<?=$tempid;?>'><div align="center"><span id="rowGatewayLote_<?=$tempid;?>" class="gridContent"><?=$tempgateway;?></span></div></td>
            <td class="lineHorizontal lineVerticalD" id='lote_cantidad_<?=$tempid;?>'><div align="center"><span id="rowCantidad_<?=$tempid;?>" class="gridContent"><?=$tempMinutos;?></span></div></td>
            <td class="lineHorizontal lineVerticalD" id='lote_btn1_<?=$tempid;?>'><div align="center"><img src="images/editar.gif" border="0" name="<?=$tempid;?>" style="cursor:pointer" onclick="miconfig.modificarlote(this);" /></div></td>
            <td class="lineHorizontal" id='lote_btn2_<?=$tempid;?>'><div align="center"><img src="images/eliminar.gif" name="<?=$tempid;?>" border="0" style="cursor:pointer" onclick="miconfig.eliminarlote(this);" /></div></td>
         </tr>   
    <?        
    }      
?>    
    </table>
<?        
    }else{
    $conexion->RollBack();
    }    
}       
/* Fin Modulo  Configuracion de lote Eliminar */

/* Modulo  Configuracion de ip's */
if($_GET['ajax']==17){  

    $gateway=$_POST['gateway'];
    $ip=$_POST['ip'];
    $qry="insert into tbl_configuracion_ip(gateway,ip) value('$gateway','$ip')";
    $conexion->BeginTransaction();
    if($conexion->executeQuery($qry)){
    //echo "true";
    $conexion->EndTransaction();
    // hago un select y vuelvo a cargar la pagina;
    $rs=new ResultSet();
    $qry="select * from tbl_configuracion_ip order by gateway,ip asc";
    $rs=$conexion->executeQuery($qry);
    ?>
    <table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="tableBorder">
       <tr>
            <td width="45.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Gateway</span></div></td>
            <td width="45.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">IP</span></div></td>
            <td width="4.5%" class="lineHorizontal lineVerticalD">&nbsp;</td>
            <td width="4.5%" class="lineHorizontal">&nbsp;</td>
       </tr>
    <?
    while($rs->next()){
        $tempgateway=$rs->get('gateway');
        $tempip=$rs->get('ip');
        $tempid=$rs->get('id');
         echo "<tr id='ip_$tempid'
         onmouseover=\"this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'\"
         onmouseout=\"this.style.backgroundColor='#FFFFFF';this.style.color='#000000'\" 
         style=\"cursor:default; background-color:#FFFFFF; color='#000000'\"
         >";
    ?>         
            <td class="lineHorizontal lineVerticalD" id='ip_gateway_<?=$tempid;?>'><div align="center"><span id="rowGatewayIp_<?=$tempid;?>" class="gridContent"><?=$tempgateway;?></span></div></td>
            <td class="lineHorizontal lineVerticalD" id='ip_ip_<?=$tempid;?>'><div align="center"><span id="rowIp_<?=$tempid;?>" class="gridContent"><?=$tempip;?></span></div></td>
            <td class="lineHorizontal lineVerticalD" id='ip_btn1_<?=$tempid;?>'><div align="center"><img src="images/editar.gif" border="0" name="<?=$tempid;?>" style="cursor:pointer" onclick="miconfig.modificarip(this);" /></div></td>
            <td class="lineHorizontal" id='ip_btn2_<?=$tempid;?>'><div align="center"><img src="images/eliminar.gif" name="<?=$tempid;?>" border="0" style="cursor:pointer" onclick="miconfig.eliminarip(this);" /></div></td>
         </tr>   
    <?        
    }      
?>    
    </table>
<?        
    }else{
        $conexion->RollBack();
        //echo "false";
    }
      
}
/* Fin Modulo  Configuracion de ip's*/

/* Modificar Ip*/
if($_GET['ajax']==18){
$tempid=$_POST['row'];
$tempgateway=$_POST['gateway'];
$tempip=$_POST['ip'];
echo $tempid."+";
$rs=new ResultSet();
$qry="show tables";
$rs=$conexion->executeQuery($qry);
while($rs->next()){
    $gatewayTemp=$rs->get(0);
     if($gatewayTemp !="tbl_usuario" and $gatewayTemp !="tbl_configuracion_lote"  and $gatewayTemp !="tbl_configuracion_ocupacional" and $gatewayTemp != "tbl_configuracion_ip"){
     $arrayGateway[]=$gatewayTemp;         
     //echo $gatewayTemp;
     }   
}
?>
  <div align="center">
    <span id="rowGatewayIp_<?=$tempid;?>" class="gridContent">
        <select id="cbx_gatewayip_<?=$tempid;?>" class="boxTextGrid"><? for($i=0;$i<count($arrayGateway);$i++){ if($arrayGateway[$i]==$tempgateway){echo "<option value=$arrayGateway[$i] selected>$arrayGateway[$i]</option>";}else{ echo "<option value=$arrayGateway[$i]>$arrayGateway[$i]</option>";}}?></select>
    </span>
  </div>
  +
  <div align="center">
    <span id="rowIp_<?=$tempid;?>" class="gridContent"><input type="text" id="txt_mod_ip_<?=$tempid;?>" size="11" class="boxTextGrid"  value="<?=$tempip;?>" ></span>
  </div>
  +
  <div align="center">
    <img src="images/guardar.gif" border="0" name="<?=$tempid;?>" style="cursor:pointer" onclick="miconfig.guardarip(this);" />
  </div>
  +
  <div align="center">
    <img src="images/cancelar.gif" name="<?=$tempid;?>" border="0" style="cursor:pointer" onclick="miconfig.cancelarip(this);" />
  </div>
<?    
    
}
/* Fin Modificar Ip*/

/* Guardar la configuracion de ips*/
if($_GET['ajax']==19){  
    $row=$_POST['row'];
    $gateway=$_POST['gateway'];
    $ip=$_POST['ip'];
 
 $qry="update tbl_configuracion_ip set gateway='$gateway',ip='$ip' where id='$row'";  
 
 $conexion->BeginTransaction();
 if($conexion->executeQuery($qry)){
  $conexion->EndTransaction();
  
  $rs= new ResultSet();
  $qry="select * from tbl_configuracion_ip where id='$row'";
  $rs=$conexion->executeQuery($qry);
    while($rs->next()){
        $tempgateway=$rs->get('gateway');
        $tempip=$rs->get('ip');
        $tempid=$rs->get('id');
         echo $row."+";  
?>
            <div align="center">
                <span id="rowGatewayIp_<?=$tempid;?>" class="gridContent"><?=$tempgateway;?></span>
            </div>
            +
            <div align="center">
                <span id="rowIp_<?=$tempid;?>" class="gridContent"><?=$tempip;?></span>
            </div>
            +
            <div align="center">
                <img src="images/editar.gif" border="0" name="<?=$tempid;?>" style="cursor:pointer" onclick="miconfig.modificarip(this);" />
            </div>
            +
            <div align="center">
                <img src="images/eliminar.gif" name="<?=$tempid;?>" border="0" style="cursor:pointer" onclick="miconfig.eliminarip(this);" />
            </div>
<?
    }
 }else{
    $conexion->RollBack();
 }  
}
/* Fin Guardar la configuracion de ips*/

/* Configuracion de ip Modificar Cancelar*/
if($_GET['ajax']==20){ 
    $row=$_POST['row'];
    $rs= new ResultSet();
    $qry="select * from tbl_configuracion_ip where id='$row'";
    $rs=$conexion->executeQuery($qry);  
    
    while($rs->next()){
    $tempgateway=$rs->get('gateway');
    $tempip=$rs->get('ip');
    $tempid=$rs->get('id');
    echo $tempid."+";
?>                 
    <div align="center">
        <span id="rowGatewayIp_<?=$tempid;?>" class="gridContent"><?=$tempgateway;?></span>
    </div>
    +
    <div align="center">
        <span id="rowIp_<?=$tempid;?>" class="gridContent"><?=$tempip;?></span>
    </div>
    +
    <div align="center">
        <img src="images/editar.gif" border="0" name="<?=$tempid;?>" style="cursor:pointer" onclick="miconfig.modificarip(this);" />
    </div>
    +
    <div align="center">
        <img src="images/eliminar.gif" name="<?=$tempid;?>" border="0" style="cursor:pointer" onclick="miconfig.eliminarip(this);" />
    </div>
<? 
    }
}
/* Fin Configuracion de ip Modificar Cancelar*/

/* Modulo de tabla ip */
if($_GET['ajax']==21){  

    $gateway=$_POST['gateway']!=NULL?$_POST['gateway']:false;
    
    $querys= array();
    if($gateway=="false"){
    //    $qry="SHOW TABLES LIKE '$gateway'";
    //    $qry="SHOW TABLES LIKE '".$gateway."'";
        $qry="SHOW TABLES";
        $rs=$conexion->executeQuery($qry);
        $table= array();
        while($rs->next()){
            if($rs->get(0)!="tbl_usuario" and $rs->get(0)!="tbl_configuracion_lote"  and $rs->get(0)!="tbl_configuracion_ocupacional" and $rs->get(0)!="tbl_configuracion_ip" ){
                $table[]=$rs->get(0);
                $qry="SELECT 
                               ip,
                               status 
                        FROM
                            (SELECT 
                                    ip,
                                    IF(ip IS NULL,false,true) AS status
                            FROM 
                                 tbl_configuracion_ip 
                            WHERE 
                                  ip IN
                                  (SELECT 
                                          RemoteMediaAddr 
                                  FROM 
                                       ".$rs->get(0)."
                                  WHERE 
                                        RemoteMediaAddr IS NOT NULL 
                                  GROUP BY 
                                        RemoteMediaAddr
                                  ORDER BY RemoteMediaAddr DESC)
                                  AND gateway='".$rs->get(0)."'
                            GROUP BY ip 
                            ORDER BY ip)
                            AS checa
                        UNION DISTINCT
                            (SELECT 
                                    RemoteMediaAddr,
                                    IF(RemoteMediaAddr IS NULL,true,false) AS status
                            FROM 
                                 ".$rs->get(0)."
                            WHERE 
                                  RemoteMediaAddr NOT IN
                                  (SELECT 
                                          ip
                                  FROM 
                                       tbl_configuracion_ip
                                  WHERE gateway='".$rs->get(0)."'
                                  GROUP BY ip)
                            GROUP BY RemoteMediaAddr
                            ORDER BY RemoteMediaAddr DESC)
                        ORDER BY ip DESC";
                $resulset = new ResultSet();
                $querys[]= $resulset = $conexion->executeQuery($qry);  
            }
        }
    }else{
    
        $qry="SELECT 
                       ip,
                       status 
                FROM
                    (SELECT 
                            ip,
                            IF(ip IS NULL,false,true) AS status
                    FROM 
                         tbl_configuracion_ip 
                    WHERE 
                          ip IN
                          (SELECT 
                                  RemoteMediaAddr 
                          FROM 
                               $gateway
                          WHERE 
                                RemoteMediaAddr IS NOT NULL 
                          GROUP BY 
                                RemoteMediaAddr
                          ORDER BY RemoteMediaAddr DESC)
                          AND gateway='$gateway'
                    GROUP BY ip 
                    ORDER BY ip)
                    AS checa
                UNION DISTINCT
                    (SELECT 
                            RemoteMediaAddr,
                            IF(RemoteMediaAddr IS NULL,true,false) AS status
                    FROM 
                         $gateway
                    WHERE 
                          RemoteMediaAddr NOT IN
                          (SELECT 
                                  ip
                          FROM 
                               tbl_configuracion_ip
                          WHERE gateway='$gateway'
                          GROUP BY ip)
                    GROUP BY RemoteMediaAddr
                    ORDER BY RemoteMediaAddr DESC)
                ORDER BY ip DESC";
        $resulset = new ResultSet();
        $querys[]= $resulset = $conexion->executeQuery($qry);  
    }
    
    ?>
    <table id="gridContenedor" width="50%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
      <tr>
        <td width="40%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Ip</span></div></td>
        <td width="40%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">gateway</span></div></td>
        <td width="20%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Status</span></div></td>
      </tr>       
    <?
    for($i=0;$i<sizeof($querys);$i++){
        if($querys[$i]->recCount()>0){
            $querys[$i]->beforefirst();
            $j=1;
            while($querys[$i]->next()){
                if($querys[$i]->get("ip")!=""){
                    echo "<tr
                     onmouseover=\"this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'\"
                     onmouseout=\"this.style.backgroundColor='#FFFFFF';this.style.color='#000000'\" 
                     style=\"cursor:default; background-color:#FFFFFF; color='#000000'\"
                     >";
                    ?>
                        <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">&nbsp;<?=$querys[$i]->get("ip");?>&nbsp;</span></div></td>
                        <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">&nbsp;<?=$servidor=$gateway!="false"?$gateway:$table[$i];?>&nbsp;</span></div></td>
                        <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">&nbsp;<?=$status=($querys[$i]->get("status"))?"Existe":"No Existe";?>&nbsp;</span></div></td>
                      </tr>
                    <?        
                }
                $j++;   
            }      
        }
    }
?>    
    </table>
<?        
}       
/* Fin de modulo de tabla ip */

/*
* Modulo de ip
*/
  
?>               
       
         
                                     
