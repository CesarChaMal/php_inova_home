-- Query Para el año 2006 mes 9 dia 28 hora de 23 a 24
SELECT llamadas.total AS 'Llamadas totales',
       llamadas_completadas.total AS 'Llamadas totales completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'Porcentaje completadas' ,
       segundos.total AS 'Total de segundos',
       (segundos.total/llamadas_completadas.total) AS 'Promedio duracion por llamada en segundos',
       minutos.total AS 'Total Minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Dialed)='2006' AND MONTH(Dialed)='9' AND DAYOFMONTH(Dialed)='28' 
     AND  HOUR(RIGHT(TRIM(Dialed),8)) BETWEEN '23' AND '24') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='2006' AND MONTH(Dialed)='9' AND DAYOFMONTH(Dialed)='28'
     AND  HOUR(RIGHT(TRIM(Dialed),8)) BETWEEN '23' AND '24') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='2006' AND MONTH(Dialed)='9' AND DAYOFMONTH(Dialed)='28'
     AND  HOUR(RIGHT(TRIM(Dialed),8)) BETWEEN '23' AND '24') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='2006' AND MONTH(Dialed)='9' AND DAYOFMONTH(Dialed)='28'
     AND  HOUR(RIGHT(TRIM(Dialed),8)) BETWEEN '23' AND '24')
     AS minutos
     
     

SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR' ,
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total _minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Dialed)='2006' AND MONTH(Dialed)='09' AND DAYOFMONTH(Dialed)='28' 
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '23' AND '24') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='2006' AND MONTH(Dialed)='09' AND DAYOFMONTH(Dialed)='28'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '23' AND '24') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='2006' AND MONTH(Dialed)='09' AND DAYOFMONTH(Dialed)='28'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '23' AND '24') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='2006' AND MONTH(Dialed)='09' AND DAYOFMONTH(Dialed)='28'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '23' AND '24')
     AS minutos 
     
     
SELECT Received,CallID FROM luptmerd WHERE YEAR(Received)='2006' AND MONTH(Received)='10' AND DAYOFMONTH(Received)='28' 
     AND  HOUR(RIGHT(TRIM(Received),8)) BETWEEN '23' AND '24'

SELECT Received,CallID FROM luptmerd WHERE YEAR(Received)='2006' AND MONTH(Received)='10' AND DAYOFMONTH(Received)='28' 
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN '23' AND '24'
     