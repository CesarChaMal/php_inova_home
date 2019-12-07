<?php
//session_start();
include_once("FetchUtil.php");   
include_once("dbconexion.php");  
include_once("System.php");
include_once("mydatetime.php");
include_once("../datoscon.php");
require_once "class.writeexcel_workbookbig.inc.php";
require_once "class.writeexcel_workbook.inc.php"; 
require_once "class.writeexcel_worksheet.inc.php";
//include_once("grid.php");
//require_once('JSON.php');
$conexion = new dbconexion(database,host,user,pass);
/*
* Exportar a Excell
* @worksheet
*/
if($_GET['ajax']=='excel'){
set_time_limit(600);

$fname = tempnam("/tmp", "bigfile.xls");
$fname = tempnam(getcwd() . '/temp', 'bigfile.xls');
$workbook = &new writeexcel_workbookbig($fname);
$worksheet = &$workbook->addworksheet();

$worksheet->set_column(0, 50, 18);

for ($col=0;$col<50;$col++) {
    for ($row=0;$row<50;$row++) {
        $worksheet->write($row, $col, "ROW:$row COL:$col");
        echo "ROW:$row COL:$col <br>"; 
    }
}
   
$fh = fopen($fname, "w");
fwrite($fh,"Escribiendo");
fclose($fh);
//echo getcwd();
//unlink($fname);
$workbook->close();
 
$fname=str_replace("\\","/",$fname);
$temp=explode("/",$fname);
$temporal=$temp[count($temp)-1];
//echo getcwd();
//echo $temporal;
//echo $fname;
$fechaxls=date("y-m-d_H-m-s");
$old=getcwd()."/temp/".$temporal;
$new=getcwd().'/temp/'.$fechaxls.'.xls';
$old=str_replace("\\","/",$old);
$new=str_replace("\\","/",$new);
//echo $old; 
//echo $new;
rename($old,$new);


} 

/*
* Fin Exportar a Excel
*/         

         
         
/*
* Modulo de gateway combox 
*/

/*
*Funcion de reemplazos 
*/

/*Funcion Actualiza el contenido del grid*/
 function contentGrid($anio,$mes,$dia,$gateway){
$conexion = new dbconexion(database,host,user,pass); 

/* Para Exportar a Excel */
$gridExcel = tempnam(getcwd() . '/temp', 'gridGeneral.xls');
$workbook = &new writeexcel_workbookbig ($gridExcel);
$worksheet = &$workbook->addworksheet();
$worksheet->set_column(0, 50, 18);
/* Formato*/
$title_format =& $workbook->addformat(array(
                                            bold    => 1,
                                            italic  => 1,
                                            color   => 'gray',
                                            size    => 11,
                                            font    => 'Verdana'
                                        ));

$cabecera=& $workbook->addformat();
$cabecera->set_align('center');
$cabecera->set_border(1);
$cabecera->set_border_color("gray");

$texto=& $workbook->addformat();
$texto->set_border(1);
$texto->set_border_color('green');
$texto->set_align('center');

$numero=& $workbook->addformat();
$numero->set_border(1);
$numero->set_border_color('green');
$numero->set_align('center');
$numero->set_num_format('#,##0');

$porcentaje=& $workbook->addformat();
$porcentaje->set_border(1);
$porcentaje->set_border_color('green');
$porcentaje->set_align('center');
$porcentaje->set_num_format('0.00%');

/* Fin Formato*/
///$date=date("Y M D , h:i:s");
//$worksheet->write(29,1,$date);
/* Para Exportar a Excel */       
//saco el numero de minutos para los lotes ..
$query=new ResultSet();
$query=$conexion->executeQuery("select * from tbl_configuracion_lote where gateway='".$gateway."'");
while($query->next()){
$minlote=$query->get('cantidad');
}

//Fin saco el numero de minutos para los lotes ..


?>
           +<table id="gridContenedor" width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableBorder">
           <tr>
                <td width="9%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Hora</span></div></td>
                <? $worksheet->write(3, 0, "HORA",$cabecera);?>
                <td width="15%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Total llamadas</span></div></td>
                <? $worksheet->write(3, 1, "TOTAL LLAMADAS",$cabecera);?>
                <td width="24%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Total llamadas completadas</span></div></td>
                <? $worksheet->write(3, 2, "TOTAL LLAMADAS COMPLETADAS",$cabecera);?>
                <td width="14%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM"><span class="styleNBLM">Total segundos</span></span></div></td>
                <? $worksheet->write(3, 3, "TOTAL SEGUNDOS",$cabecera);?>
                <td width="14%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM"><span class="styleNBLM">Total Minutos</span></span></div></td>
                <? $worksheet->write(3, 4, "TOTAL MINUTOS",$cabecera);?>
                <td width="6%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">ASR</span></div></td>
                <? $worksheet->write(3, 5, "ASR",$cabecera);?>
                <td width="7%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">ACD</span></div></td>
                <? $worksheet->write(3, 6, "ACD",$cabecera);?>
                <td width="11%" class="lineHorizontal"><div align="center"><span class="styleNBLM">Lotes de <?=$minlote;?> m</span></div></td>
                <? $worksheet->write(3, 7, "LOTES DE ".$minlote." M",$cabecera);?>
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

$e=4;
for($i=0;$i<count($horas);$i++){
/* Busco el query adecuado al filtro*/     
if($gateway!="false" and $anio=='false' and $mes=='false' and $dia=='false'){
 $qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       CEILING((segundos.total/llamadas_completadas.total)/60) AS 'promedio_ACD',
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
    
 $title="Informacion del Gateway ".$gateway;   
}elseif($anio!="false" and $gateway!="false" and $mes=='false' and $dia=='false'){
$qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       CEILING((segundos.total/llamadas_completadas.total)/60) AS 'promedio_ACD',
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
     
     $title="Informacion del Gateway ".$gateway." del año ".$anio;
}elseif($anio!="false" and $mes!="false" and $gateway!="false" and $dia=='false'){

 $qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       CEILING((segundos.total/llamadas_completadas.total)/60) AS 'promedio_ACD',
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
     
     $title="Informacion del Gateway ".$gateway." del año ".$anio." del mes ".$mes;

}elseif($anio!="false" and $mes!="false" and $dia!="false" and $gateway!="false"){

$qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       CEILING((segundos.total/llamadas_completadas.total)/60) AS 'promedio_ACD',
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
    
    $title="Informacion del Gateway ".$gateway." del año ".$anio." del mes ".$mes." del dia ".$dia;
}
/* Final Busco e query*/

//$worksheet->write(0,0,$qry);
//echo $qry."</br>";

/* Pongo el encabezado que debe llevar*/
$worksheet->write(1,0,$title,$title_format);

/* Fin del encabezado*/
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
         if($total_minutos!="0" and $minlotes > 0){$lotes=($total_minutos/$minlote);}else{$lotes=0;} 
    echo "<tr
    onmouseover=\"this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'\"
    onmouseout=\"this.style.backgroundColor='#FFFFFF';this.style.color='#000000'\" 
    style=\"cursor:default; background-color:#FFFFFF; color='#000000'\"
    >";
?>                                                                                       

                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent"><?=$costado[$i];?></span></div></td>
                <? $worksheet->write($e, 0, $costado[$i],$texto);?>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent"><?=$total_llamadas;?></span></div></td>
                <? $worksheet->write($e, 1, $total_llamadas,$numero);?>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent"><?=$total_llamadas_completadas;?></span></div></td>
                <? $worksheet->write($e, 2, $total_llamadas_completadas,$numero);?>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent"><?=$total_segundos;?></span></div></td>
                <? $worksheet->write($e, 3, $total_segundos,$numero);?>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent"><?=$total_minutos;?></span></div></td>
                <? $worksheet->write($e, 4, $total_minutos,$numero);?>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent"><?=number_format($asr,1,".",",")." %";?></span></div></td>
                <? $worksheet->write($e, 5, number_format($asr,2,".","")."%",$numero);?>
                <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent"><?=number_format($acd,1,".","");?></span></div></td>
                <? $worksheet->write($e, 6, number_format($acd,2,".",""),$numero);?>
                <td class="lineHorizontal"><div align="center"><span class="gridContent"><?=floor($lotes);?></span></div></td>
                <? $worksheet->write($e, 7, $lotes,$numero);?>
              </tr>

<?
     } 
     $e++;
     
} echo "</table>+$gateway+$anio+$mes+$dia";

/* Creo el archivo Excel*/
//$fechaxls=date("h-i-s");
$fechaxls=date("y-m-d");
$archivo=getcwd()."/temp/".$fechaxls.".xls";
if(file_exists($archivo)){unlink($archivo);}
$fh = fopen($gridExcel, "w");
fwrite($fh,"Escribiendo");
fclose($fh);
//echo getcwd();
//unlink($fname);
$workbook->close();
 
$gridExcel=str_replace("\\","/",$gridExcel);
$temp=explode("/",$gridExcel);
$temporal=$temp[count($temp)-1];
//echo getcwd();
//echo $temporal;
//echo $fname;

$old=getcwd()."/temp/".$temporal;
$new=getcwd().'/temp/'.$fechaxls.'.xls';
$old=str_replace("\\","/",$old);
$new=str_replace("\\","/",$new);
//echo $old; 
//echo $new;
rename($old,$new);

/* Fin creo el archivo excel*/





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
                <td width="11%" class="lineHorizontal"><div align="center"><span class="styleNBLM">Lotes de X</span></div></td>
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
 

/* Para Exportar a Excel */
$gridExcelGateway = tempnam(getcwd() . '/temp', 'gridGeneral.xls');
$workbook = &new writeexcel_workbook($gridExcelGateway);
$worksheet = &$workbook->addworksheet();
//$worksheet->set_column(0, 50, 18);
# Set the column width for columns 2 and 3
//$worksheet->set_column(1, 2, 20);

# Set the row height for row 2
//$worksheet->set_row(2, 30);
/* Formato*/
$title_format =& $workbook->addformat(array(
                                            bold    => 1,
                                            italic  => 1,
                                            color   => 'gray',
                                            size    => 11,
                                            font    => 'Verdana'
                                        ));

$cabecera=& $workbook->addformat();
$cabecera->set_align('center');
$cabecera->set_border(1);
$cabecera->set_border_color("gray");

$texto=& $workbook->addformat();
$texto->set_border(1);
$texto->set_border_color('green');
$texto->set_align('center');

$numero=& $workbook->addformat();
$numero->set_border(1);
$numero->set_border_color('green');
$numero->set_align('center');
$numero->set_num_format('#,##0');

$porcentaje=& $workbook->addformat();
$porcentaje->set_border(1);
$porcentaje->set_border_color('green');
$porcentaje->set_align('center');
$porcentaje->set_num_format('0.00%');

/* Fin Formato*/
$date=date("Y M D , h:i:s");

//$worksheet->merge_cells(0,0,1,0);
//$worksheet->write(29,1,$date);
/* Para Exportar a Excel */     
 

/* Encabezado */   
?>
            +
            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="tableBorder">
            <tr>
            <td colspan="2" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">Gateways</span></div></td>
            <? $worksheet->write(3, 0, "Gateways/ Horas",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">00-01</span></div></td>
            <? $worksheet->write(3, 2, "00 - 01",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">01-02</span></div></td>
            <? $worksheet->write(3, 3, "01 - 02",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">02-03</span></div></td>
            <? $worksheet->write(3, 4, "02 - 03",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">03-04</span></div></td>
            <? $worksheet->write(3, 5, "03 - 04",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">04-05</span></div></td>
            <? $worksheet->write(3, 6, "04 - 05",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">05-06</span></div></td>
            <? $worksheet->write(3, 7, "05 - 06",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">06-07</span></div></td>
            <? $worksheet->write(3, 8, "06 - 07",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">07-08</span></div></td>
            <? $worksheet->write(3, 9, "07 - 08",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">08-09</span></div></td>
            <? $worksheet->write(3, 10, "08 - 09",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">09-10</span></div></td>
            <? $worksheet->write(3, 11, "09 - 10",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">10-11</span></div></td>
            <? $worksheet->write(3,12, "10 - 11",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">11-12</span></div></td>
            <? $worksheet->write(3, 13, "11 - 12",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">12-13</span></div></td>
            <? $worksheet->write(3, 14, "12 - 13",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">13-14</span></div></td>
            <? $worksheet->write(3, 15, "13 - 14",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">14-15</span></div></td>
            <? $worksheet->write(3, 16, "14 - 15",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">15-16</span></div></td>
            <? $worksheet->write(3, 17, "15 - 16",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">16-17</span></div></td>
            <? $worksheet->write(3, 18, "16 - 17",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">17-18</span></div></td>
            <? $worksheet->write(3, 19, "17 - 18",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">18-19</span></div></td>
            <? $worksheet->write(3, 20, "18 - 19",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">19-20</span></div></td>
            <? $worksheet->write(3, 21, "19 - 20",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">20-21</span></div></td>
            <? $worksheet->write(3, 22, "20 - 21",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">21-22</span></div></td>
            <? $worksheet->write(3, 23, "21 - 22",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">22-23</span></div></td>
            <? $worksheet->write(3, 24, "22 - 23",$cabecera);?>
            <td width="3.5%" class="lineHorizontal"><div align="center"><span class="gridContent">23-24</span></div></td>
            <? $worksheet->write(3, 25, "23 - 24",$cabecera);?>
            <? $worksheet->write(3, 1, "",$cabecera);?>
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
    
    $b=4;
    $c=5;
    $x=4;
    $y=5;
    for($a=0;$a<count($tabla);$a++){
    if($tabla[$a]!="tbl_usuario" and $tabla[$a]!="tbl_configuracion_lote"  and $tabla[$a]!="tbl_configuracion_ocupacional" and $tabla[$a]!="tbl_configuracion_ip"){
    echo "<tr
    onmouseover=\"this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'\"
    onmouseout=\"this.style.backgroundColor='#FFFFFF';this.style.color='#000000'\" 
    style=\"cursor:default; background-color:#FFFFFF; color='#000000'\"
    >";
    
    ?>
            <td width="8%" class="lineHorizontal lineVerticalD"><span class="gridContent">&nbsp;&nbsp;<?=$tabla[$a];?></span></td>
            <? 
            //$worksheet->merge_cells(4,0,5,0);
            $worksheet->merge_cells($b,0,$c,0);
            //$worksheet->write($b, ($b++) ,$tabla[$a]);
            $worksheet->write($b, 0,$tabla[$a]);
            //$worksheet->merge_cells(5,0,6,0);
            ?>
            <td width="3%" class="lineHorizontal lineVerticalD">
            <table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="lineHorizontal"><div align="center"><span class="gridContent">ASR</span></div></td>
               <? $worksheet->write($b,1,"ASR",$texto);?> 
              </tr>
              <tr>
                <td><div align="center"><span class="gridContent">ACD</span></div></td>
                <? $worksheet->write($c,1,"ACD",$texto);?> 
              </tr>
            </table>
            </td>
<?
    // del cuerpo dinamico
    $z=2;
   for($i=0;$i<count($horas);$i++){  
    $rs=new ResultSet();
    
if($anio=='' and $mes=='' and $dia==''){
    $qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       CEILING((segundos.total/llamadas_completadas.total)/60) AS 'promedio_ACD',
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
     $title="Resultados del Gateway Todos";
}elseif($anio!='' and $mes!='' and $dia!=''){

    $qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       CEILING((segundos.total/llamadas_completadas.total)/60) AS 'promedio_ACD',
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
     $title="Resultados del Gateway Todos de año ".$anio." del mes ".$mes." del dia ".$dia;
    
}
    
    $worksheet->write(1,0,$title,$title_format);
    
     $rs=$conexion->executeQuery($qry);
     while($rs->next()){
     $tempASR=$rs->get('por_completadas_ASR');
     $tempACD=$rs->get('promedio_ACD');
     }    
     
?>
            <td  class="lineHorizontal lineVerticalD">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
            <td class="lineHorizontal"><span class="gridContentMin"><?=number_format($tempASR,"0",".","")."%";?></span></td>
            <? $worksheet->write($b, $z, number_format($tempASR,"0",".","")."%",$numero);?>
            </tr>
            <tr>
            <td><span class="gridContentMin"><?=number_format($tempACD,"0",".","");?></span></td>
            <? $worksheet->write($c, $z, number_format($tempACD,"0",".",""),$numero);?>
            </tr>
            </table>
            </td> 
<? 
$z++;      
}
    
    // Cuerpo dinamico

    }
    $b=$b+2;
    $c=$c+2;
    $x++;
    $y++;
    } echo "</table>+Todos+$anio+$mes+$dia";
/*Fin del cuerpo*/
/* Creo el archivo Excel*/
//$fechaxls=date("h-i-s");
$fechaxls=date("y-m-d");
$archivo=getcwd()."/temp/".$fechaxls.".xls";
if(file_exists($archivo)){unlink($archivo);}
$fh = fopen($gridExcelGateway, "w");
fwrite($fh,"Escribiendo");
fclose($fh);
//echo getcwd();
//unlink($fname);
$workbook->close();
 
$gridExcelGateway=str_replace("\\","/",$gridExcelGateway);
$temp=explode("/",$gridExcelGateway);
$temporal=$temp[count($temp)-1];
//echo getcwd();
//echo $temporal;
//echo $fname;

$old=getcwd()."/temp/".$temporal;
$new=getcwd().'/temp/'.$fechaxls.'.xls';
$old=str_replace("\\","/",$old);
$new=str_replace("\\","/",$new);
//echo $old; 
//echo $new;
rename($old,$new);

/* Fin creo el archivo excel*/




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
               
/* Para Exportar a Excel */
$gridExcelGateway = tempnam(getcwd() . '/temp', 'gridGeneral.xls');
$workbook = &new writeexcel_workbook($gridExcelGateway);
$worksheet = &$workbook->addworksheet();
//$worksheet->set_column(0, 50, 18);
# Set the column width for columns 2 and 3
//$worksheet->set_column(1, 2, 20);

# Set the row height for row 2
//$worksheet->set_row(2, 30);
/* Formato*/
$title_format =& $workbook->addformat(array(
                                            bold    => 1,
                                            italic  => 1,
                                            color   => 'gray',
                                            size    => 11,
                                            font    => 'Verdana'
                                        ));

$cabecera=& $workbook->addformat();
$cabecera->set_align('center');
$cabecera->set_border(1);
$cabecera->set_border_color("gray");

$texto=& $workbook->addformat();
$texto->set_border(1);
$texto->set_border_color('green');
$texto->set_align('center');

$numero=& $workbook->addformat();
$numero->set_border(1);
$numero->set_border_color('green');
$numero->set_align('center');
$numero->set_num_format('#,##0');

$porcentaje=& $workbook->addformat();
$porcentaje->set_border(1);
$porcentaje->set_border_color('green');
$porcentaje->set_align('center');
$porcentaje->set_num_format('0.00%');

/* Fin Formato*/
$date=date("Y M D , h:i:s");               
               
 ?>
            +<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableBorder"> 
            <tr>
            <td colspan="2" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">Puerto / Horas</span></div></td>
            <? 
            $worksheet->merge_cells(3,0,3,1);
            $worksheet->write(3,0,"PUERTO / HORAS",$cabecera);
            $worksheet->write(3,1,"",$cabecera);
            ?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">00-01</span></div></td>
            <? $worksheet->write(3, 2, "00 - 01",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">01-02</span></div></td>
            <? $worksheet->write(3, 3, "01 - 02",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">02-03</span></div></td>
            <? $worksheet->write(3, 4, "02 - 03",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">03-04</span></div></td>
            <? $worksheet->write(3, 5, "03 - 04",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">04-05</span></div></td>
            <? $worksheet->write(3, 6, "04 - 05",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">05-06</span></div></td>
            <? $worksheet->write(3, 7, "05 - 06",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">06-07</span></div></td>
            <? $worksheet->write(3, 8, "06 - 07",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">07-08</span></div></td>
            <? $worksheet->write(3, 9, "07 - 08",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">08-09</span></div></td>
            <? $worksheet->write(3, 10, "08 - 09",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">09-10</span></div></td>
            <? $worksheet->write(3, 11, "09 - 10",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">10-11</span></div></td>
            <? $worksheet->write(3,12, "10 - 11",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">11-12</span></div></td>
            <? $worksheet->write(3, 13, "11 - 12",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">12-13</span></div></td>
            <? $worksheet->write(3, 14, "12 - 13",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">13-14</span></div></td>
            <? $worksheet->write(3, 15, "13 - 14",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">14-15</span></div></td>
            <? $worksheet->write(3, 16, "14 - 15",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">15-16</span></div></td>
            <? $worksheet->write(3, 17, "15 - 16",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">16-17</span></div></td>
            <? $worksheet->write(3, 18, "16 - 17",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">17-18</span></div></td>
            <? $worksheet->write(3, 19, "17 - 18",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">18-19</span></div></td>
            <? $worksheet->write(3, 20, "18 - 19",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">19-20</span></div></td>
            <? $worksheet->write(3, 21, "19 - 20",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">20-21</span></div></td>
            <? $worksheet->write(3, 22, "20 - 21",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">21-22</span></div></td>
            <? $worksheet->write(3, 23, "21 - 22",$cabecera);?>
            <td width="3.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">22-23</span></div></td>
            <? $worksheet->write(3, 24, "22 - 23",$cabecera);?>
            <td width="3.5%" class="lineHorizontal"><div align="center"><span class="gridContent">23-24</span></div></td>
            <? $worksheet->write(3, 25, "23 - 24",$cabecera);?>
          </tr>
    <?
    
    $rs = new ResultSet();
    $qry = "select distinct(LocalChannel) from luptmerd order by LocalChannel asc";
    $rs=$conexion->executeQuery($qry);
    while($rs->next()){
    $tabla[]=$rs->get(0);
    }
    
    $b=4;
    $c=5;
    $x=4;
    $y=5;
        
    for($a=0;$a<count($tabla);$a++){
            
    echo "<tr
    onmouseover=\"this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'\"
    onmouseout=\"this.style.backgroundColor='#FFFFFF';this.style.color='#000000'\" 
    style=\"cursor:default; background-color:#FFFFFF; color='#000000'\"
    >";
    ?>
            <td width="7%" class="lineHorizontal lineVerticalD"><span class="gridContent">&nbsp;&nbsp;Port <?=$tabla[$a];?></span></td>
            <? $worksheet->merge_cells($b , 0, $c , 0);?>
            <? $worksheet->write($b,0, "Port ".$tabla[$a],$texto);?>
            <td width="3%" class="lineHorizontal lineVerticalD">
            <table width="98%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="lineHorizontal"><div align="center"><span class="gridContent">ASR</span></div></td>
                <? $worksheet->write($b,1,"ASR",$texto);?>
              </tr>
              <tr>
                <td><div align="center"><span class="gridContent">ACD</span></div></td>
                <? $worksheet->write($c,1,"ACD",$texto);?>   
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
     
 $z=2;
 for($i=0;$i<count($horas);$i++){     
// De los querys Search
 if($gateway!="false" and $anio=='false' and $mes=='false' and $dia=='false'){
 $qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       CEILING((segundos.total/llamadas_completadas.total)/60) AS 'promedio_ACD',
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
     $title="Resultados del Gateway ".$gateway;
    
}elseif($anio!="false" and $gateway!="false" and $mes=='false' and $dia=='false'){
$qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       CEILING((segundos.total/llamadas_completadas.total)/60) AS 'promedio_ACD',
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
     $title="Resultados del Gateway ".$gateway." del año ".$anio;
}elseif($anio!="false" and $mes!="false" and $gateway!="false" and $dia=='false'){

 $qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
      CEILING((segundos.total/llamadas_completadas.total)/60) AS 'promedio_ACD',
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
     $title="Resultados del Gateway ".$gateway." del año ".$anio." del mes ".$mes; 

}elseif($anio!="false" and $mes!="false" and $dia!="false" and $gateway!="false"){

$qry="SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       CEILING((segundos.total/llamadas_completadas.total)/60) AS 'promedio_ACD',
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
     
     $title="Resultados del Gateway ".$gateway." del año ".$anio." del mes ".$mes." del dia ".$dia;  
    
}

$worksheet->write(1,0,$title,$title_format);
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
                <td class="lineHorizontal"><span class="gridContentMin"><?=number_format($tempASR,"0",".","")."%";?></span></td>
                <? $worksheet->write($b, $z, number_format($tempASR,"0",".","")."%",$numero);?>
              </tr>
              <tr>
                <td><span class="gridContentMin"><?=number_format($tempACD,"0",".","");?></span></td>
                <? $worksheet->write($c, $z, number_format($tempACD,"0",".",""),$numero);?>
              </tr>
            </table>
            </td>
            <? 
            $z++;
             }
            ?>
           
           </td>
          </tr> 
          <? 
          $b=$b+2;
          $c=$c+2;      
          
    }
    
    echo"</table>+$gateway+$anio+$mes+$dia";
/* Creo el archivo Excel*/
//$fechaxls=date("h-i-s");
$fechaxls=date("y-m-d");
$archivo=getcwd()."/temp/".$fechaxls.".xls";
if(file_exists($archivo)){unlink($archivo);}
$fh = fopen($gridExcelGateway, "w");
fwrite($fh,"Escribiendo");
fclose($fh);
//echo getcwd();
//unlink($fname);
$workbook->close();
 
$gridExcelGateway=str_replace("\\","/",$gridExcelGateway);
$temp=explode("/",$gridExcelGateway);
$temporal=$temp[count($temp)-1];
//echo getcwd();
//echo $temporal;
//echo $fname;

$old=getcwd()."/temp/".$temporal;
$new=getcwd().'/temp/'.$fechaxls.'.xls';
$old=str_replace("\\","/",$old);
$new=str_replace("\\","/",$new);
//echo $old; 
//echo $new;
rename($old,$new);

/* Fin creo el archivo excel*/
    
    
    
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
    $initialport=$_POST['puertoinicio'];
    $finalport=$_POST['puertofinal'];
    $qry="insert into tbl_configuracion_ocupacional(fecha_inicio,fecha_fin,gateway,minutos_disponibles,initialport,finalport) value('$txt_inicio','$txt_final','$gateway','$minutos','$initialport','$finalport')";
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
           <td width="14%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Gateway</span></div></td>
           <td width="14%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Port Inicio</span></div></td>
           <td width="14%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Port Final</span></div></td>
           <td width="19%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Fecha inicio</span></div></td>
           <td width="17%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Fecha Final</span></div></td>
           <td width="13%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Minutos</span></div></td>
           <td width="3%" class="lineHorizontal lineVerticalD">&nbsp;</td>
           <td width="3%" class="lineHorizontal">&nbsp;</td>
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
           <td width="14%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Gateway</span></div></td>
           <td width="14%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Port Inicio</span></div></td>
           <td width="14%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Port Final</span></div></td>
           <td width="19%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Fecha inicio</span></div></td>
           <td width="17%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Fecha Final</span></div></td>
           <td width="13%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Minutos</span></div></td>
           <td width="3%" class="lineHorizontal lineVerticalD">&nbsp;</td>
           <td width="3%" class="lineHorizontal">&nbsp;</td>
    <?
    while($rs->next()){
        $tempinicio=$rs->get('fecha_inicio');
        $tempfinal=$rs->get('fecha_fin');
        $tempgateway=$rs->get('gateway');
        $tempMinutos=$rs->get('minutos_disponibles');
        $tempid=$rs->get('idconfiguracion');
        $tempportinicial=$rs->get('initialport');
        $tempportfinal=$rs->get('finalport');
         echo "<tr id='ocupacion_$tempid'
         onmouseover=\"this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'\"
         onmouseout=\"this.style.backgroundColor='#FFFFFF';this.style.color='#000000'\" 
         style=\"cursor:default; background-color:#FFFFFF; color='#000000'\"
         >";
    ?>
            <td class="lineHorizontal lineVerticalD" id='ocupacion_gateway_<?=$tempid;?>'><div align="center"><span id="rowGateway_<?=$tempid;?>" class="gridContent"><?=$tempgateway;?></span></div></td>
            <td class="lineHorizontal lineVerticalD" id='ocupacion_portinicio_<?=$tempid;?>'><div align="center"><span id="rowPortInicio_<?=$tempid;?>" class="gridContent"><?=$tempportinicial;?></span></div></td>
            <td class="lineHorizontal lineVerticalD" id='ocupacion_portfin_<?=$tempid;?>'><div align="center"><span id="rowPortFinal_<?=$tempid;?>" class="gridContent"><?=$tempportfinal;?></span></div></td>
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
$tempportinicio=$_POST['puertoinicio'];
$tempportfinal=$_POST['puertofinal'];
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
    <span id="rowPortInicio_<?=$tempid;?>" class="gridContent"><input type="text" id="txt_portinicio_<?=$tempid;?>" size="10" class="boxTextGrid" value="<?=$tempportinicio;?>" ></span>
  </div>
   +
  <div align="center">
    <span id="rowPortFinal_<?=$tempid;?>" class="gridContent"><input type="text" id="txt_portfinal_<?=$tempid;?>" size="10" class="boxTextGrid" value="<?=$tempportfinal;?>" ></span>
  </div>
  +
  <div align="center">
    <span id="rowFechainicio_<?=$tempid;?>" class="gridContent"><input type="text" id="txt_mod_fecha_inicio_<?=$tempid;?>" size="10" class="boxTextGrid" value="<?=$tempinicio;?>" readonly="readonly" ></span>&nbsp;<img src="images/calendario.gif" width="16" height="16" name="btn_mod_fecha_inicio" id="btn_mod_fecha_inicio_<?=$tempid;?>" style="cursor:pointer"/>
  </div>
  +
  <div align="center">
    <span id="rowFechafin_<?=$tempid;?>" class="gridContent"><input type="text" id="txt_mod_fecha_fin_<?=$tempid;?>" size="10" class="boxTextGrid"   value="<?=$tempfinal;?>" readonly="readonly" ></span>&nbsp;<img src="images/calendario.gif" width="16" height="16" id="btn_mod_fecha_fin_<?=$tempid;?>" style="cursor:pointer" />
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
          button      : "btn_mod_fecha_inicio_<?=$tempid;?>"       // ID of the button
      }
  ); 
  +
  Calendar.setup(
      {
          inputField  : "txt_mod_fecha_fin_<?=$tempid;?>",         // ID of the input field
          ifFormat    : "%Y-%m-%d",    // the date format
          button      : "btn_mod_fecha_fin_<?=$tempid;?>"       // ID of the button
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
    $tempportinicial=$rs->get('initialport');
    $tempportfinal=$rs->get('finalport');
    echo $tempid."+";
?>                 
  <div align="center">
    <span id="rowGateway_<?=$tempid;?>" class="gridContent"><?=$tempgateway;?></span>    
  </div>
  +
  <div align="center">
  <span id="rowPortInicio_<?=$tempid;?>" class="gridContent"><?=$tempportinicial;?></span>
  </div>
  +
  <div align="center">
  <span id="rowPortFinal_<?=$tempid;?>" class="gridContent"><?=$tempportfinal;?></span>
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
    $portinicio=$_POST['portinicio'];
    $portfin=$_POST['portfinal'];
 
 $qry="update tbl_configuracion_ocupacional set gateway='$gateway',fecha_inicio='$fechainicio',fecha_fin='$fechafin',minutos_disponibles='$minutos',initialport='$portinicio',finalport='$portfin' where idconfiguracion='$row'";  
 
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
        $tempportinicial=$rs->get('initialport');
        $tempportfinal=$rs->get('finalport');
         echo $row."+";  
?>
            <div align="center">
                <span id="rowGateway_<?=$tempid;?>" class="gridContent"><?=$tempgateway;?></span>
            </div>
            +
            <div align="center">
            <span id="rowPortInicio_<?=$tempid;?>" class="gridContent"><?=$tempportinicial;?></span>
            </div>
            +
            <div align="center">
            <span id="rowPortFinal_<?=$tempid;?>" class="gridContent"><?=$tempportfinal;?></span>
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
    <span id="rowIp_<?=$tempid;?>" class="gridContent"><input type="text" id="txt_mod_ip_<?=$tempid;?>" size="10" class="boxTextGrid"  value="<?=$tempip;?>" ></span>
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
    /* Para Exportar a Excel */
    $gridExcel = tempnam(getcwd() . '/temp', 'grid.xls');
    $workbook = &new writeexcel_workbookbig ($gridExcel);
    $worksheet = &$workbook->addworksheet();
    //$worksheet->set_column(0, 50, 18);
    /* Formato*/
    $title_format =& $workbook->addformat(array(
                                                bold    => 1,
                                                italic  => 1,
                                                color   => 'gray',
                                                size    => 11,
                                                font    => 'Verdana'
                                            ));

    $cabecera=& $workbook->addformat();
    $cabecera->set_align('center');
    $cabecera->set_border(1);
    $cabecera->set_border_color("gray");

    $texto=& $workbook->addformat();
    $texto->set_border(1);
    $texto->set_border_color('green');
    $texto->set_align('center');

    $numero=& $workbook->addformat();
    $numero->set_border(1);
    $numero->set_border_color('green');
    $numero->set_align('center');
    $numero->set_num_format('#,##0');

    $porcentaje=& $workbook->addformat();
    $porcentaje->set_border(1);
    $porcentaje->set_border_color('green');
    $porcentaje->set_align('center');
    $porcentaje->set_num_format('0.00%');

    /* Fin Formato*/

    $title="Informacion de las ip ";//.$gateway;
    $worksheet->write(1,0,$title,$title_format);
    //$worksheet->write(29,1,$date);
    /* Para Exportar a Excel */       

    $gateway=$_POST['gateway']!=NULL?$_POST['gateway']:false;
    
    $querys= array();
    if($gateway=="false"){
    //    $qry="SHOW TABLES LIKE '$gateway'";
    //    $qry="SHOW TABLES LIKE '".$gateway."'";
        $qry="SHOW TABLES";
        $rs = new ResultSet();
        $rs=$conexion->executeQuery($qry);
        $table= array();
        while($rs->next()){
            if($rs->get(0)!="tbl_usuario" and $rs->get(0)!="tbl_configuracion_lote"  and $rs->get(0)!="tbl_configuracion_ocupacional" and $rs->get(0)!="tbl_configuracion_ip" ){
                $table[]=$rs->get(0);
                $qry="SELECT 
                        RemoteSignalIP as ip,
                        IF(RemoteSignalIP IS NULL,true,false) AS status
                    FROM 
                         ".$rs->get(0)."
                    WHERE 
                          RemoteSignalIP NOT IN
                          (SELECT 
                                  ip
                          FROM 
                               tbl_configuracion_ip
                          WHERE 
                                gateway='".$rs->get(0)."'  
                          GROUP BY ip)
                    GROUP BY RemoteSignalIP
                    ORDER BY RemoteSignalIP DESC";
                        
                $resulset = new ResultSet();
                $querys[]= $resulset = $conexion->executeQuery($qry);  
            }
        }
    }else{
    
        $qry="SELECT 
                RemoteSignalIP as ip,
                IF(RemoteSignalIP IS NULL,true,false) AS status
            FROM 
                 $gateway
            WHERE 
                  RemoteSignalIP NOT IN
                  (SELECT 
                          ip
                  FROM 
                       tbl_configuracion_ip
                  WHERE 
                        gateway='$gateway'  
                  GROUP BY ip)
            GROUP BY RemoteSignalIP
            ORDER BY RemoteSignalIP DESC";
        $resulset = new ResultSet();
        $querys[]= $resulset = $conexion->executeQuery($qry);  
    }
    
    ?>
    <table id="gridContenedor" width="50%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
      <tr>
        <td width="40%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Ip</span></div></td>
        <? $worksheet->write(3, 0, "Ip",$cabecera);?>
        <td width="40%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Gateway</span></div></td>
        <? $worksheet->write(3, 1, "Gateway",$cabecera);?>
        <td width="20%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Status</span></div></td>
        <? $worksheet->write(3, 2, "Status",$cabecera);?>
      </tr>       
    <?
    $j=5;
    for($i=0;$i<sizeof($querys);$i++){
        //if($querys[$i]->recCount()>0){
            $querys[$i]->beforefirst();
            while($querys[$i]->next()){
                if($querys[$i]->get("ip")!=""){
                    echo "<tr
                     onmouseover=\"this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'\"
                     onmouseout=\"this.style.backgroundColor='#FFFFFF';this.style.color='#000000'\" 
                     style=\"cursor:default; background-color:#FFFFFF; color='#000000'\"
                     >";
                    ?>
                        <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">&nbsp;<?=$querys[$i]->get("ip");?>&nbsp;</span></div></td>
                        <? //$worksheet->write($e, 0,$querys[$i]->get("ip"),$texto);?>
                        <? $worksheet->write($j, 0,$querys[$i]->get("ip"),$numero);?>
                        <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">&nbsp;<?=$servidor=$gateway!="false"?$gateway:$table[$i];?>&nbsp;</span></div></td>
                        <? $worksheet->write($j, 1,$servidor,$texto);?>
                        <td class="lineHorizontal lineVerticalD"><div align="center"><span class="gridContent">&nbsp;<?=$status=($querys[$i]->get("status"))?"Existe":"No Existe";?>&nbsp;</span></div></td>
                        <? $worksheet->write($j, 2,$status,$texto);?>
                      </tr>
                    <?        
                }
                $j++;   
            }      
        //}
    }
?>    
    </table>
<?        
    /* Creo el archivo Excel*/
    //$fechaxls=date("h-i-s");
    $fechaxls=date("y-m-d");
    $archivo=getcwd()."/temp/".$fechaxls.".xls";
    if(file_exists($archivo)){unlink($archivo);}
    $fh = fopen($gridExcel, "w");
    fwrite($fh,"Escribiendo");
    fclose($fh);
    //echo getcwd();
    //unlink($fname);
    $workbook->close();
     
    $gridExcel=str_replace("\\","/",$gridExcel);
    $temp=explode("/",$gridExcel);
    $temporal=$temp[count($temp)-1];
    //echo getcwd();
    //echo $temporal;
    //echo $fname;

    $old=getcwd()."/temp/".$temporal;
    $new=getcwd().'/temp/'.$fechaxls.'.xls';
    $old=str_replace("\\","/",$old);
    $new=str_replace("\\","/",$new);
    //echo $old; 
    //echo $new;
    rename($old,$new);

    /* Fin creo el archivo excel*/
}       
/* Fin de modulo de tabla ip */

/*
* Modulo de ip
*/

/* Modulo de ocupacionales */
if($_GET['ajax']==22){  
    $gateway = $_POST["gateway"];
    //$gateway = "luptmerd";
    //$row = new ResultSet();
    //$row = $conexion->executeQuery("SELECT * FROM tbl_configuracion_ocupacional WHERE gateway LIKE '$gateway'");

    $data_base = 'mysql';
    $pass = urlencode(pass);
    //$dsn = "$data_base://".user.":".$pass."@".host."/".database."?clientflags=65536";
    $dsn = "$data_base://".user.":".$pass."@".host."/".database."?persist&clientflags=65536";
    
    $conex = new FetchUtil($dsn);

    $row = $conex->FetchAll("SELECT * FROM tbl_configuracion_ocupacional WHERE gateway LIKE '$gateway'");
    $i=0;

    //$row->beforefirst();
    //while($row->next()){
    while($i<sizeof($row)){
        $fechainicio = $row[$i]["fecha_inicio"];
        $fechafinal = $row[$i]["fecha_fin"];
        $cantidad = $row[$i]["minutos_disponibles"];
        $initialPort = $row[$i]["initialPort"];
        $finalPort = $row[$i]["finalPort"];
        $temptable = 'tmp'.$row[$i]["idconfiguracion"];
/*
        $fechainicio = $row->get("fecha_inicio");
        $fechafinal = $row->get("fecha_fin");
        $cantidad = $row->get("minutos_disponibles");
        $initialPort = $row->get("initialPort");
        $finalPort = $row->get("finalPort");
        $temptable = 'tmp'.$row->get("idconfiguracion");
        $conexion->closedbconnection();
*/
        //$conex->ReConnect(host,user,pass,database);
        $conex->Close();
        $conex = new FetchUtil($dsn);
        $query = "CALL ocupacion('".$fechainicio."','".$fechafinal."','".$gateway."',".$cantidad.",".$initialPort.",".$finalPort.",'".$temptable."');";
        //$query = "CALL ocupacion('$fechainicio','$fechafinal','$gateway',$cantidad,$initialPort,$finalPort,'$temptable');";
        $procedure = $conex->FetchAll($query);
        //print_r($procedure);
        //echo("<br>");

        //$conex->ReConnect(host,user,pass,database);
        $conex->Close();
        $conex = new FetchUtil($dsn);
        $data = $conex->FetchAll("SELECT * FROM ".$temptable.";");
        //print_r($data);
        //echo("<br>");

        //$conexion->createdbconnection(database,host,user,pass);
        //$conexion = new dbconexion(database,host,user,pass);
        //$data = new ResultSet();
        //$data = $conexion->executeQuery("SELECT * FROM ".$temptable.";");
        //echo $data->get("Porcentaje_Total");
        //echo"<br>";
        //echo $temptable;
        //echo $data[0]["Porcentaje_Total"];
        
        //mktime($hour,$minutes,$seconds,$month,$day,$year));
        
        list($yearIni,$monthIni,$dayIni)= explode("-",$fechainicio);
        //list($dayIni,$hourIni)= explode(" ",$dayIni);
        //list($hourIni,$minutesIni,$secondsIni)= explode(":",$hoursIni);
        $d1=mktime(0,0,0,$monthIni,$dayIni,$yearIni);

        list($yearFin,$monthFin,$dayFin)= explode("-",$fechafinal);
        $d2=mktime(0,0,0,$monthFin,$dayFin,$yearFin);

        //$date1 = date('Y-m-d H:i:s',$d1);
        //$date2 = date('Y-m-d H:i:s',$d2);

        //One day is always 24 hours * 60 minutes * 60 seconds = 86400
        $Difference_Between_days = floor(($d2-$d1)/86400);

        $dates = array();
        $acumulated=$d1;
        for ($k=0;$k<$Difference_Between_days;$k++){
            //$conex = new FetchUtil($dsn);
            ///$conex->ReConnect(host,user,pass,database);
            $dates[$k]=date('Y-m-d',$acumulated);
            $acumulated+=86400;
        }
/*        
        $dates[$Difference_Between_days] = "Porcentaje_Total";
        $dates[$Difference_Between_days+1] = "Total_x_Dias";
        $dates[$Difference_Between_days+2] = "Maximo_Minutos";
        $dates[$Difference_Between_days+3] = "Minutos_Disponibles";
        $dates[$Difference_Between_days+4] = "Minutos_Sobrantes";
*/        
        ?>
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableBorder">
          <tr>
            <td colspan="7" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Gateway:&nbsp;<?=$gateway;?>&nbsp;&nbsp;&nbsp;puertos&nbsp;del&nbsp;<?=$initialPort?>&nbsp;al&nbsp;<?=$finalPort;?>&nbsp;&nbsp;&nbsp;Del&nbsp;periodo&nbsp;<?=$fechainicio;?>&nbsp;a&nbsp;<?=$fechafinal;?></span></div></td>
          </tr>
          <tr onmouseover="this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'"
          onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000'" 
          style="cursor:default; background-color:#FFFFFF; color='#000000'">
        <?
        $j = 0;
        //$a = array();
        //$a = $data->getDataRowToArray();
        //$data->beforefirst();
        //$data->first();
        //while($data->next()){
        while($j<sizeof($dates)){
            $conex->Close();
            $conex = new FetchUtil($dsn);
            //$conex->ReConnect(host,user,pass,database);
            if($j%7==0 && $j!=0){
                ?>     
                </tr>
                <tr onmouseover="this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'"
                onmouseout="this.style.backgroundColor='#FFFFFF';this.style.color='#000000'" 
                style="cursor:default; background-color:#FFFFFF; color='#000000'">
                <?
            }
            ?>    
                <td> 
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
    <!--                    <td class="lineHorizontal lineVerticalD"><div align="center"><span class="styleContent"><?//=$dates[$j];?>&nbsp;<?//=$data->get($dates[$j]);?>&nbsp;</span></div></td> -->
                            <td class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">&nbsp;<?=$dates[$j];?>&nbsp;</span></div></td>
                        </tr>
                        <tr>
                            <td class="lineHorizontal lineVerticalD"><div align="center"><span class="styleContent">&nbsp;<?=$data[0][$dates[$j]];?>&nbsp;</span></div></td>
                        </tr>
                    </table>    
                </td> 
            <?
            $j++;    
        }
        //$delete = $conexion->executeQuery("DROP TABLE ".$temptable.";");
        //$delete = $conex->FetchAll("DROP TABLE IF EXISTS ".$temptable.";");
        $delete = $conex->Execute("DROP TABLE IF EXISTS ".$temptable.";");

        ?>
            </tr>
        </table>
        <br>
        <?
        $i++;
        //$conexion->createdbconnection(database,host,user,pass);
        //$conexion = new dbconexion(database,host,user,pass);
    }
}       
/* Fin del modulo de ocupacionales */
  

/*
*  Modulo para exportar a excel la database
*/

if($_GET['ajax']=='23'){
    
/* Para Exportar a Excel */
$gridExcel = tempnam(getcwd() . '/temp', 'gridGeneral.xls');
$workbook = &new writeexcel_workbookbig ($gridExcel);
$worksheet = &$workbook->addworksheet();
//$worksheet->set_column(0, 50, 18);
/* Formato*/
$title_format =& $workbook->addformat(array(
                                            bold    => 1,
                                            italic  => 1,
                                            color   => 'gray',
                                            size    => 11,
                                            font    => 'Verdana'
                                        ));

$cabecera=& $workbook->addformat();
$cabecera->set_align('center');
$cabecera->set_border(1);
$cabecera->set_border_color("gray");

$texto=& $workbook->addformat();
$texto->set_border(1);
$texto->set_border_color('green');
$texto->set_align('center');

$numero=& $workbook->addformat();
$numero->set_border(1);
$numero->set_border_color('green');
$numero->set_align('center');
$numero->set_num_format('#,##0');

$porcentaje=& $workbook->addformat();
$porcentaje->set_border(1);
$porcentaje->set_border_color('green');
$porcentaje->set_align('center');
$porcentaje->set_num_format('0.00%');
/*  expotar*/    
    
    
    
$gateway=$_POST['gateway']; 
$fechainicio=$_POST['fechainicio'];
$fechafin=$_POST['fechafinal'];
//select * from luptmerd WHERE date(dialed) between '2007-10-28' and '2007-10-30' order by date(Dialed) asc  
if($gateway!="false" and $fechainicio=="" and $fechafin==""){
$qry="select * from ".$gateway." order by date(Dialed) asc";
$title=" Información del Gateway ".$gateway;
    
}elseif($gateway!="false" and $fechainicio!="" and $fechafin==""){
    $qry="select * from ".$gateway." WHERE date(dialed) >= '".$fechainicio."'  order by date(Dialed) asc";
$title=" Información del Gateway ".$gateway." Mayores o Iguales a la fecha ".$fechainicio;

}elseif($gateway!="false" and $fechainicio=="" and $fechafinal!=""){
    $qry="select * from ".$gateway." WHERE date(dialed) <= '".$fechafin."'  order by date(Dialed) asc";
$title=" Información del Gateway ".$gateway." Menores o Iguales a la fecha ".$fechafin;
}elseif($gateway!="false" and $fechainicio!="" and $fechafin!=""){
    $qry="select * from ".$gateway." between '".$fechainicio."' and '".$fechafin."' order by date(Dialed) asc  ";    
$title=" Información del Gateway ".$gateway." de la fecha ".$fechainicio." hasta la  fecha ". $fechafin;
}

// Dibujo los encabezados

$worksheet->write(1,1,$title,$title_format);

$worksheet->write(3,1,"CallId",$cabecera);
$worksheet->write(3,2,"Received",$cabecera);
$worksheet->write(3,3,"Dialed",$cabecera);
$worksheet->write(3,4,"E164Src",$cabecera);
$worksheet->write(3,5,"E164Dest",$cabecera);
$worksheet->write(3,6,"StartTime",$cabecera);
$worksheet->write(3,7,"EndTime",$cabecera);
$worksheet->write(3,8,"Duration",$cabecera);
$worksheet->write(3,9,"RemoteSignalIp",$cabecera);
$worksheet->write(3,10,"RemoteMediaAddr",$cabecera);
$worksheet->write(3,11,"RemoteMediaPort",$cabecera);
$worksheet->write(3,12,"LocalChanel",$cabecera);
$worksheet->write(3,13,"RemoteCardSlot",$cabecera);
$worksheet->write(3,14,"CallDirection",$cabecera); 
$worksheet->write(3,15,"HangupInitiator",$cabecera); 
$worksheet->write(3,16,"TxRTP",$cabecera); 
$worksheet->write(3,17,"RxRTP",$cabecera); 
$worksheet->write(3,18,"LostRTP",$cabecera); 
$worksheet->write(3,19,"HangupReason",$cabecera); 

// Fin Dibujo los encabezado

$rs=new ResultSet();
$rs=$conexion->executeQuery($qry);
$i=4;
while($rs->next()){
 $callid=$rs->get('CallID');    
 $received=$rs->get('Received');    
 $dialed=$rs->get('Dialed');
 $e164src=$rs->get('E164Src');    
 $e164Dest=$rs->get('E164Dest');    
 $starttime=$rs->get('StartTime');    
 $endtime=$rs->get('EndTime');    
 $duration=$rs->get('Duration');    
 $remotesignalip=$rs->get('RemoteSignalIp');    
 $remotmediaaddr=$rs->get('RemoteMediaAddr');    
 $remotemediaport=$rs->get('RemoteMediaPort');
 $locachanel=$rs->get('LocalChanel');    
 $remotecardslot=$rs->get('RemoteCardSlot');    
 $calldirection=$rs->get('CallDirection');    
 $hangupinitiator=$rs->get('HangupInitiator');   
 $txtrtp=$rs->get('TxRTP');    
 $rxrtp=$rs->get('rxRTP');    
 $lostrtp=$rs->get('LostRTP');    
 $hangupreason=$rs->get('HangupReason');    
 
 //---- creo la tabla
 $worksheet->write($i,1,"$callid",$texto);
 $worksheet->write($i,2,"$received",$texto);
 $worksheet->write($i,3,"$dialed",$texto);
 $worksheet->write($i,4,"$e164src",$texto);
 $worksheet->write($i,5,"$e164Dest",$texto);
 $worksheet->write($i,6,"$starttime",$texto);
 $worksheet->write($i,7,"$endtime",$texto);
 $worksheet->write($i,8,"$duration",$texto);
 $worksheet->write($i,9,"$remotesignalip",$texto);
 $worksheet->write($i,10,"$remotmediaaddr",$texto);
 $worksheet->write($i,11,"$remotemediaport",$texto);
 $worksheet->write($i,12,"$locachanel",$texto);
 $worksheet->write($i,13,"$remotecardslot",$texto);
 $worksheet->write($i,14,"$calldirection",$texto);
 $worksheet->write($i,15,"$hangupinitiator",$texto);
 $worksheet->write($i,16,"$txtrtp",$texto);
 $worksheet->write($i,17,"$rxrtp",$texto);
 $worksheet->write($i,18,"$lostrtp",$texto);
 $worksheet->write($i,19,"$hangupreason",$texto); 
 //----------
 
 $i++;
}  

/* Creo el archivo Excel*/
//$fechaxls=date("h-i-s");
$fechaxls=date("y-m-d-H-i-s");
$archivo=getcwd()."/temp/exp-".$fechaxls.".xls";
if(file_exists($archivo)){unlink($archivo);}
$fh = fopen($gridExcel, "w");
fwrite($fh,"Escribiendo");
fclose($fh);
//echo getcwd();
//unlink($fname);
$workbook->close();
 
$gridExcel=str_replace("\\","/",$gridExcel);
$temp=explode("/",$gridExcel);
$temporal=$temp[count($temp)-1];
//echo getcwd();
//echo $temporal;
//echo $fname;

$old=getcwd()."/temp/".$temporal;
$new=getcwd().'/temp/exp-'.$fechaxls.'.xls';
$old=str_replace("\\","/",$old);
$new=str_replace("\\","/",$new);
//echo $old; 
//echo $new;
rename($old,$new);
echo 'exp-'.$fechaxls.'.xls';
}
/*
* Fin Modulo para exportar a excel la database
*/




/*
* Modulo de Configuracion   
*/


?>
               
       
         
                                     
