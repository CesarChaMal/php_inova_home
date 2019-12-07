SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Received)='2006' 
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN '01:00:00' AND '01:59:59') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='2006'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '01:00:00' AND '01:59:59') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='2006'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '01:00:00' AND '01:59:59') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='2006'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '01:00:00' AND '01:59:59')
     AS minutos
     
     
insert into national_paises(idpais, nombre) values('OT2', 'OTHER2')



SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM ofomerd WHERE YEAR(Received)='' AND MONTH(Received)='09' 
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN '01:00:00' AND '01:59:59') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM ofomerd WHERE Duration>0 AND YEAR(Dialed)='' AND MONTH(Dialed)='09' 
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '01:00:00' AND '01:59:59') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM ofomerd WHERE YEAR(Dialed)='' AND MONTH(Dialed)='10' 
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '01:00:00' AND '01:59:59') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM ofomerd WHERE YEAR(Dialed)='' AND MONTH(Dialed)='09'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '01:00:00' AND '01:59:59')
     AS minutos
     
     
     
  insert into national_monedas(descripcion, siglas, simbologia, aplicacion) values('A2', 'A22', 'A222', 'A2222')   
  
  
  SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Received)='' AND MONTH(Received)='09' 
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN '23:00:00' AND '23:59:59') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='' AND MONTH(Dialed)='09' 
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '23:00:00' AND '23:59:59') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='' AND MONTH(Dialed)='09' 
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '23:00:00' AND '23:59:59') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='' AND MONTH(Dialed)='09'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '23:00:00' AND '23:59:59')
     AS minutos
  
  
SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN '00:00:00' AND '00:59:59') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='false'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '00:59:59') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='false'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '00:59:59') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='false'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '00:59:59')
     AS minutos


SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd
     where  TIME(RIGHT(TRIM(Received),8)) BETWEEN '00:00:00' AND '00:59:59') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 and
      TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '00:59:59') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd
     where  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '00:59:59') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd
    where  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '00:59:59')
     AS minutos  
     
-- // del Gateway    
SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd
     WHERE  TIME(RIGHT(TRIM(Received),8)) BETWEEN '05:00:00' AND '05:59:59') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '05:00:00' AND '05:59:59') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd
     WHERE  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '05:00:00' AND '05:59:59') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd
     WHERE  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '05:00:00' AND '05:59:59')
     AS minutos
     
-- // del Año     
 SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Received)='2007' 
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN '06:00:00' AND '06:59:59') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='2007'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '06:00:00' AND '06:59:59') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='2007'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '06:00:00' AND '06:59:59') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='2007'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '06:00:00' AND '06:59:59')
     AS minutos    
     
-- // del mes

SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR',
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total_minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Received)='2007' AND MONTH(Received)='10'
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN '06:00:00' AND '06:59:59') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='2007'  AND MONTH(Dialed)='10'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '06:00:00' AND '06:59:59') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='2007'  AND MONTH(Dialed)='10'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '06:00:00' AND '06:59:59') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='2007'  AND MONTH(Dialed)='10'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '06:00:00' AND '06:59:59')
     AS minutos
     
     -- // del dia
     SELECT llamadas.total AS 'llamadas_totales',
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
     
     
     
     
-- Sumatoria de los ASR

 SELECT llamadas.total AS 'llamadas_totales',
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

    
     
     