SELECT Received,CallID FROM luptmerd WHERE YEAR(Received)='2006' AND MONTH(Received)='10' AND DAYOFMONTH(Received)='28' 
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN '23:00:00' AND '24:00:00'     
SELECT Received,CallID FROM luptmerd WHERE YEAR(Received)='2006' AND MONTH(Received)='10' AND DAYOFMONTH(Received)='28' 
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN '23' AND '24'     

     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN '00:00:00' AND '01:00:00'     
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN '01:00:00' AND '02:00:00'  
     

SELECT TIME( RIGHT( TRIM(' 2007-10-29 T 17:59:00 '),8)) BETWEEN '17:00:00' AND '18:00:00'

SELECT TIME( RIGHT( TRIM(' 2007-10-29 T 18:00:00 '),8)) BETWEEN '17:00:00' AND '17:59:59'

SELECT TIME( RIGHT( TRIM(' 2007-10-29 T 18:00:00 '),8)) BETWEEN '18:00:00' AND '19:00:00'   


SELECT TIME( RIGHT( TRIM(' 2007-10-29 T 18:00:00 '),8)) > '17:00:00' AND TIME( RIGHT( TRIM(' 2007-10-29 T 18:00:00 '),8)) < '18:00:00'     



SELECT llamadas.total AS 'llamadas_totales',
       llamadas_completadas.total AS 'llamadas_total_completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'por_completadas_ASR' ,
       segundos.total AS 'total_de_segundos',
       (segundos.total/llamadas_completadas.total) AS 'promedio_ACD',
       minutos.total AS 'total _minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Received)='2006' AND MONTH(Received)='09' AND DAYOFMONTH(Received)='28' 
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN '00:00:00' AND '00:59:59') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='2006' AND MONTH(Dialed)='09' AND DAYOFMONTH(Dialed)='28'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '00:59:59') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='2006' AND MONTH(Dialed)='09' AND DAYOFMONTH(Dialed)='28'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '00:59:59') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='2006' AND MONTH(Dialed)='09' AND DAYOFMONTH(Dialed)='28'
     AND  TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '00:59:59')
     AS minutos