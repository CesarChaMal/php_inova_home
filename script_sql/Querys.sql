SHOW TABLES LIKE 'luptmerd';
SHOW TABLE STATUS LIKE 'luptmerd';
SHOW TABLES

SELECT * from luptmerd;

-- Total de llamadas
SELECT count(*) as 'Total llamadas' from luptmerd;

-- Total de llamadas completadas
SELECT count(*) as 'Total llamadas completadas' from luptmerd where Duration > 0;

-- ASR porcentaje de llamadas completadas
SELECT llamadas.total AS 'Llamadas totales',llamadas_completadas.total AS 'Llamadas totales completadas', (llamadas_completadas.total/llamadas.total)*100 AS 'Porcentaje completadas'FROM
(SELECT COUNT(*) AS total FROM luptmerd) AS llamadas,
(SELECT COUNT(*) AS total FROM luptmerd WHERE Duration > 0) AS llamadas_completadas

-- Total de segundos de las llamadas
SELECT SUM(Duration) as 'Total de segundos' from luptmerd

-- ACD promedio duracion por llamada en segundos
SELECT segundos.total as 'Total de Segundos',llamadas_completadas.total as'Llamadas totales completadas',(segundos.total/llamadas_completadas.total) as 'Promedio duracion por llamada en segundos' from
(SELECT sum(Duration) as total from luptmerd) as segundos,
(SELECT count(*) as total from luptmerd where Duration > 0) as llamadas_completadas

-- ACD promedio duracion por llamada en minutos
SELECT segundos.total as 'Total de Segundos',llamadas_completadas.total as'Llamadas totales completadas',CEILING((segundos.total/llamadas_completadas.total)/60) as 'Promedio duracion por llamada en minutos' from
(SELECT sum(Duration) as total from luptmerd) as segundos,
(SELECT count(*) as total from luptmerd where Duration > 0) as llamadas_completadas

-- Total de minutos de las llamadas
SELECT SUM(CEILING(Duration/60)) as 'Total Minutos' from luptmerd

select year(now()) as y,
       month(now()) as m,
       dayofmonth(now()) as d,
       hour(now()) AS h,
       minute(now()) as m,
       second(now()) as s;

SELECT 
       *,
       CONCAT(currentdate.year,'-',
       currentdate.month,'-',
       currentdate.day,' ',
       currentdate.hour,':',
       currentdate.minute,':',
       currentdate.second
       ) AS fecha 
FROM
    (SELECT 
            YEAR(NOW()) AS year,
            MONTH(NOW()) AS month,
            DAYOFMONTH(NOW()) AS day,
            HOUR(NOW()) AS hour,
            MINUTE(NOW()) AS minute,
            SECOND(NOW()) AS second
    ) AS currentdate

select current_timestamp;
select current_time;
select current_date;
select now();
select SECOND(now());
SELECT DATE_FORMAT("2078-08-30 21:19:58", "%M %D,%Y %k:%i CST %W");
SELECT DATE_FORMAT(NOW(), "%M %D,%Y %k:%i CST %W");
SELECT DATE_FORMAT(NOW(), "%S");
SELECT DATE_FORMAT(NOW(), "%s");
SELECT MOD(234, 10);
SELECT MOD(MONTH('1998-01-30'), 12) + 1;
SELECT MOD(MONTH(CURDATE()), 12) + 1;
SELECT MONTH('1979-04-30') = MOD(MONTH('1998-01-30'), 12) + 1;
SELECT MONTH('1979-04-30') = MOD(MONTH(CURDATE()), 12) + 1;

-------------------------------------------------------------------------------------------------------------------------------------------     

-- Query Para el año 2006
SELECT llamadas.total AS 'Llamadas totales',
       llamadas_completadas.total AS 'Llamadas totales completadas', 
--       ROUND((llamadas_completadas.total/llamadas.total)*100) AS 'Porcentaje completadas' ,
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'Porcentaje completadas' ,
       segundos.total AS 'Total de segundos',
       (segundos.total/llamadas_completadas.total) AS 'Promedio duracion por llamada en segundos',
       minutos.total AS 'Total Minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Received)='2006') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='2006') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='2006') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='2006')
     AS minutos

-- Query Para el año 2007
SELECT llamadas.total AS 'Llamadas totales',
       llamadas_completadas.total AS 'Llamadas totales completadas', 
--       ROUND((llamadas_completadas.total/llamadas.total)*100) AS 'Porcentaje completadas' ,
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'Porcentaje completadas' ,
       segundos.total AS 'Total de segundos',
       (segundos.total/llamadas_completadas.total) AS 'Promedio duracion por llamada en segundos',
       minutos.total AS 'Total Minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Received)='2007') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='2007') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='2007') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='2007')
     AS minutos

-------------------------------------------------------------------------------------------------------------------------------------------     

-- Query Para el año 2006 mes 9
SELECT llamadas.total AS 'Llamadas totales',
       llamadas_completadas.total AS 'Llamadas totales completadas', 
--       ROUND((llamadas_completadas.total/llamadas.total)*100) AS 'Porcentaje completadas' ,
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'Porcentaje completadas' ,
       segundos.total AS 'Total de segundos',
       (segundos.total/llamadas_completadas.total) AS 'Promedio duracion por llamada en segundos',
       minutos.total AS 'Total Minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Received)='2006' AND MONTH(Dialed)='9') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='2006' AND MONTH(Dialed)='9') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='2006' AND MONTH(Dialed)='9') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='2006' AND MONTH(Dialed)='9')
     AS minutos

-- Query Para el año 2007 mes 10
SELECT llamadas.total AS 'Llamadas totales',
       llamadas_completadas.total AS 'Llamadas totales completadas', 
--       ROUND((llamadas_completadas.total/llamadas.total)*100) AS 'Porcentaje completadas' ,
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'Porcentaje completadas' ,
       segundos.total AS 'Total de segundos',
       (segundos.total/llamadas_completadas.total) AS 'Promedio duracion por llamada en segundos',
       minutos.total AS 'Total Minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Received)='2007' AND MONTH(Dialed)='10') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='2007' AND MONTH(Dialed)='10') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='2007' AND MONTH(Dialed)='10') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='2007' AND MONTH(Dialed)='10')
     AS minutos
     
-------------------------------------------------------------------------------------------------------------------------------------------     

-- Query Para el año 2006 mes 9 dia 28
SELECT llamadas.total AS 'Llamadas totales',
       llamadas_completadas.total AS 'Llamadas totales completadas', 
--       ROUND((llamadas_completadas.total/llamadas.total)*100) AS 'Porcentaje completadas' ,
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'Porcentaje completadas' ,
       segundos.total AS 'Total de segundos',
       (segundos.total/llamadas_completadas.total) AS 'Promedio duracion por llamada en segundos',
       minutos.total AS 'Total Minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Received)='2006' AND MONTH(Dialed)='9' AND DAYOFMONTH(Dialed)='28') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='2006' AND MONTH(Dialed)='9' AND DAYOFMONTH(Dialed)='28') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='2006' AND MONTH(Dialed)='9' AND DAYOFMONTH(Dialed)='28') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='2006' AND MONTH(Dialed)='9' AND DAYOFMONTH(Dialed)='28')
     AS minutos

-- Query Para el año 2007 mes 10 dia 29
SELECT llamadas.total AS 'Llamadas totales',
       llamadas_completadas.total AS 'Llamadas totales completadas', 
--       ROUND((llamadas_completadas.total/llamadas.total)*100) AS 'Porcentaje completadas' ,
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'Porcentaje completadas' ,
       segundos.total AS 'Total de segundos',
       (segundos.total/llamadas_completadas.total) AS 'Promedio duracion por llamada en segundos',
       minutos.total AS 'Total Minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29')
     AS minutos

-------------------------------------------------------------------------------------------------------------------------------------------     

-- Query Para el año 2006 mes 9 dia 28 hora de 23 a 24
SELECT llamadas.total AS 'Llamadas totales',
       llamadas_completadas.total AS 'Llamadas totales completadas', 
--       ROUND((llamadas_completadas.total/llamadas.total)*100) AS 'Porcentaje completadas' ,
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'Porcentaje completadas' ,
       segundos.total AS 'Total de segundos',
       (segundos.total/llamadas_completadas.total) AS 'Promedio duracion por llamada en segundos',
       minutos.total AS 'Total Minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Received)='2006' AND MONTH(Dialed)='9' AND DAYOFMONTH(Dialed)='28' 
--     AND  HOUR(RIGHT(TRIM(Dialed),8)) BETWEEN '23' AND '24') 
     AND TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '23:00:00' AND '23:59:59') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='2006' AND MONTH(Dialed)='9' AND DAYOFMONTH(Dialed)='28'
--     AND  HOUR(RIGHT(TRIM(Dialed),8)) BETWEEN '23' AND '24') 
     AND TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '23:00:00' AND '23:59:59') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='2006' AND MONTH(Dialed)='9' AND DAYOFMONTH(Dialed)='28'
--     AND  HOUR(RIGHT(TRIM(Dialed),8)) BETWEEN '23' AND '24') 
     AND TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '23:00:00' AND '23:59:59') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='2006' AND MONTH(Dialed)='9' AND DAYOFMONTH(Dialed)='28'
--     AND  HOUR(RIGHT(TRIM(Dialed),8)) BETWEEN '23' AND '24')
     AND TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '23:00:00' AND '23:59:59') 
     AS minutos

-- Query Para el año 2007 mes 10 dia 29 hora de 00 a 01 horas
SELECT llamadas.total AS 'Llamadas totales',
       llamadas_completadas.total AS 'Llamadas totales completadas', 
--       ROUND((llamadas_completadas.total/llamadas.total)*100) AS 'Porcentaje completadas' ,
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'Porcentaje completadas' ,
       segundos.total AS 'Total de segundos',
       (segundos.total/llamadas_completadas.total) AS 'Promedio duracion por llamada en segundos',
       minutos.total AS 'Total Minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Received)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29' 
--     AND HOUR(RIGHT(TRIM(Dialed),8)) BETWEEN '00' AND '01') 
     AND TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '00:59:59') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29'
--     AND HOUR(RIGHT(TRIM(Dialed),8)) BETWEEN '00' AND '01') 
     AND TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '00:59:59') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29'
--     AND HOUR(RIGHT(TRIM(Dialed),8)) BETWEEN '00' AND '01') 
     AND TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '00:59:59') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29'
--     AND HOUR(RIGHT(TRIM(Dialed),8)) BETWEEN '00' AND '01') 
     AND TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '00:59:59') 
     AS minutos

-- Query Para el año 2007 mes 10 dia 29 hora de 00 a 01 horas pero con ACD en minutos
SELECT llamadas.total AS 'Llamadas totales',
       llamadas_completadas.total AS 'Llamadas totales completadas', 
--       ROUND((llamadas_completadas.total/llamadas.total)*100) AS 'Porcentaje completadas' ,
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'Porcentaje completadas' ,
       segundos.total AS 'Total de segundos',
       (segundos.total/llamadas_completadas.total) AS 'Promedio duracion por llamada en segundos',
       ((segundos.total/llamadas_completadas.total)/60) AS 'Promedio duracion por llamada en minutos',
       minutos.total AS 'Total Minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Received)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29' 
--     AND HOUR(RIGHT(TRIM(Dialed),8)) BETWEEN '00' AND '01') 
     AND TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '00:59:59') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29'
--     AND HOUR(RIGHT(TRIM(Dialed),8)) BETWEEN '00' AND '01') 
     AND TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '00:59:59') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29'
--     AND HOUR(RIGHT(TRIM(Dialed),8)) BETWEEN '00' AND '01') 
     AND TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '00:59:59') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29'
--     AND HOUR(RIGHT(TRIM(Dialed),8)) BETWEEN '00' AND '01') 
     AND TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '00:59:59') 
     AS minutos

-------------------------------------------------------------------------------------------------------------------------------------------     

-- ip del servidor
SELECT RemoteSignalIP FROM luptmerd GROUP BY RemoteSignalIP ORDER BY RemoteSignalIP

-- ip del cliente

SELECT RemoteMediaAddr FROM luptmerd  WHERE RemoteMediaAddr IS NOT NULL GROUP BY RemoteMediaAddr ORDER BY RemoteMediaAddr;

SELECT RemoteMediaAddr FROM luptmerd WHERE RemoteMediaAddr IS NOT NULL 
GROUP BY RemoteMediaAddr 

SELECT ip FROM tbl_configuracion_ip GROUP BY ip ORDER BY ip;

SELECT ip FROM tbl_configuracion_ip WHERE ip in(SELECT RemoteMediaAddr FROM luptmerd WHERE RemoteMediaAddr IS NOT NULL GROUP BY RemoteMediaAddr )
GROUP BY ip ORDER BY ip;

(SELECT ip FROM tbl_configuracion_ip GROUP BY ip ORDER BY ip)
        UNION
(SELECT RemoteMediaAddr FROM luptmerd WHERE RemoteMediaAddr IS NOT NULL GROUP BY RemoteMediaAddr);

(SELECT ip FROM tbl_configuracion_ip GROUP BY ip ORDER BY ip)
        UNION ALL
(SELECT RemoteMediaAddr FROM luptmerd WHERE RemoteMediaAddr IS NOT NULL GROUP BY RemoteMediaAddr);

SELECT 
       tbl_configuracion_ip.ip 
FROM 
     tbl_configuracion_ip 
JOIN
    luptmerd ON tbl_configuracion_ip.ip=luptmerd.RemoteMediaAddr
GROUP BY 
      tbl_configuracion_ip .ip 

SELECT ip FROM tbl_configuracion_ip GROUP BY ip ORDER BY ip
-- 66.128.60.95
-- 66.63.165.151
-- 67.18.228.218
SELECT RemoteMediaAddr FROM luptmerd GROUP BY RemoteMediaAddr
SELECT RemoteMediaAddr FROM luptmerd WHERE RemoteMediaAddr ='66.128.60.95'
-- Existe en tbl_configuracion_ip
SELECT RemoteMediaAddr FROM luptmerd WHERE RemoteMediaAddr ='66.63.165.151'
-- Existe en tbl_configuracion_ip
SELECT RemoteMediaAddr FROM luptmerd WHERE RemoteMediaAddr ='67.18.228.218'
-- NO existe en tbl_configuracion_ip
select RemoteMediaAddr from  ofomerd where RemoteMediaAddr='204.246.135.204' 


SELECT 
       luptmerd.RemoteMediaAddr,
       IF(luptmerd.RemoteMediaAddr=checa.ip,true,false) AS status
FROM 
     luptmerd
JOIN
    (SELECT 
            ip 
    FROM 
         tbl_configuracion_ip 
    WHERE 
          ip in
          (SELECT 
                  RemoteMediaAddr 
          FROM 
               luptmerd 
          WHERE 
                RemoteMediaAddr IS NOT NULL 
          GROUP BY 
                RemoteMediaAddr)
    GROUP BY ip 
    ORDER BY ip)
    AS checa 
WHERE 
      luptmerd.RemoteMediaAddr IS NOT NULL
GROUP BY 
      luptmerd.RemoteMediaAddr
-- HAVING 
--       status=true
ORDER BY
      luptmerd.RemoteMediaAddr DESC;

(SELECT 
        ip as ipconfig 
FROM 
     tbl_configuracion_ip 
WHERE 
      ip in
      (SELECT 
              RemoteMediaAddr 
      FROM 
           luptmerd 
      WHERE 
            RemoteMediaAddr IS NOT NULL 
      GROUP BY 
            RemoteMediaAddr)
GROUP BY ip 
ORDER BY ip)
      UNION DISTINCT
(SELECT 
         RemoteMediaAddr AS ipclient
 FROM 
      luptmerd
 WHERE 
       RemoteMediaAddr IS NOT NULL
 GROUP BY 
       RemoteMediaAddr)

SELECT 
        ip as ipconfig 
FROM 
     tbl_configuracion_ip 
WHERE 
      EXISTS
      (SELECT 
              RemoteMediaAddr 
      FROM 
           luptmerd 
      WHERE 
            RemoteMediaAddr IS NOT NULL 
      GROUP BY 
            RemoteMediaAddr)
GROUP BY ip 
ORDER BY ip

SELECT 
       ip,
       status 
FROM
    (SELECT 
            ip,
            IF(ip IS NULL,false,true) as status
    FROM 
         tbl_configuracion_ip 
    WHERE 
          ip IN
          (SELECT 
                  RemoteMediaAddr 
          FROM 
               luptmerd 
          WHERE 
                RemoteMediaAddr IS NOT NULL 
          GROUP BY 
                RemoteMediaAddr)
          AND gateway='luptmerd'
    GROUP BY ip 
    ORDER BY ip)
    as checa
UNION DISTINCT
    (SELECT 
            RemoteMediaAddr,
            IF(RemoteMediaAddr IS NULL,true,false) AS status
    FROM 
         luptmerd
    WHERE 
          RemoteMediaAddr NOT IN
          (SELECT 
                  ip
          FROM 
               tbl_configuracion_ip
          GROUP BY ip)
    GROUP BY RemoteMediaAddr)
ORDER BY ip DESC

SELECT 
       ip,
       status 
FROM
    (SELECT 
            ip,
            IF(ip IS NULL,false,true) as status
    FROM 
         tbl_configuracion_ip 
    WHERE 
          ip IN
          (SELECT 
                  RemoteMediaAddr 
          FROM 
               luptmerd 
          WHERE 
                RemoteMediaAddr IS NOT NULL 
          GROUP BY 
                RemoteMediaAddr
          ORDER BY RemoteMediaAddr DESC)
          AND gateway='luptmerd'
    GROUP BY ip 
    ORDER BY ip)
    as checa
UNION DISTINCT
    (SELECT 
            RemoteMediaAddr,
            IF(RemoteMediaAddr IS NULL,true,false) AS status
    FROM 
         luptmerd
    WHERE 
          RemoteMediaAddr NOT IN
          (SELECT 
                  ip
          FROM 
               tbl_configuracion_ip
          WHERE 
                gateway='luptmerd'
          GROUP BY ip)
    GROUP BY RemoteMediaAddr
    ORDER BY RemoteMediaAddr DESC)
ORDER BY ip DESC

SELECT 
       ip,
       status 
FROM
    (SELECT 
            ip,
            IF(ip IS NULL,false,true) as status
    FROM 
         tbl_configuracion_ip 
    WHERE 
          ip IN
          (SELECT 
                  RemoteMediaAddr 
          FROM 
               ofomerd 
          WHERE 
                RemoteMediaAddr IS NOT NULL 
          GROUP BY 
                RemoteMediaAddr
          ORDER BY RemoteMediaAddr DESC)
          AND gateway='ofomerd'
    GROUP BY ip 
    ORDER BY ip)
    as checa
UNION DISTINCT
    (SELECT 
        RemoteMediaAddr,
        IF(RemoteMediaAddr IS NULL,true,false) AS status
    FROM 
         ofomerd
    WHERE 
          RemoteMediaAddr NOT IN
          (SELECT 
                  ip
          FROM 
               tbl_configuracion_ip
          WHERE 
                gateway='ofomerd'
          GROUP BY ip)
    GROUP BY RemoteMediaAddr
    ORDER BY RemoteMediaAddr DESC)
ORDER BY ip DESC

SELECT 
        RemoteSignalIP as ip,
        IF(RemoteSignalIP IS NULL,true,false) AS status
    FROM 
         ofomerd
    WHERE 
          RemoteSignalIP NOT IN
          (SELECT 
                  ip
          FROM 
               tbl_configuracion_ip
          WHERE 
                gateway='ofomerd'
          GROUP BY ip)
    GROUP BY RemoteSignalIP
    ORDER BY RemoteSignalIP DESC

SELECT HOUR(Dialed),Dialed FROM luptmerd
SELECT HOUR('2007-10-30 10:50:49')
SELECT HOUR('2007-10-29 T :52:02')
SELECT TRIM('   2007- 10-29 T 18:52:02          ')

SELECT RIGHT('2007-10-29 T 18:52:02',8)
SELECT HOUR(RIGHT('2007-10-29 T 18:52:02',8))
SELECT HOUR( RIGHT( TRIM(' 2007-10-29 T 18:52:02 '),8))
SELECT HOUR( RIGHT( TRIM(' 2007-10-29 T 18:52:02 '),8)) BETWEEN '17' AND '18'
SELECT TIME( RIGHT( TRIM(' 2007-10-29 T 18:52:02 '),8)) BETWEEN '17' AND '18'
SELECT TIME( RIGHT( TRIM(' 2007-10-29 T 18:59:59 '),8)) BETWEEN '18:00:00' AND '18:59:59'

SELECT Received,CallID FROM luptmerd WHERE YEAR(Received)='2006' AND MONTH(Received)='10' AND DAYOFMONTH(Received)='28' 
     AND  HOUR(RIGHT(TRIM(Received),8)) BETWEEN '23' AND '24'     

SELECT Received,CallID FROM luptmerd WHERE YEAR(Received)='2006' AND MONTH(Received)='10' AND DAYOFMONTH(Received)='28' 
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN '23' AND '24'     

SELECT Received,CallID FROM luptmerd WHERE CallID='177520' AND TIME(RIGHT(TRIM(Received),8)) BETWEEN '23' AND '24'
AND HOUR(RIGHT(TRIM(TIME(RIGHT(TRIM(Received),8))),8))='23'

SELECT Received,CallID FROM luptmerd WHERE YEAR(Received)='2006' AND MONTH(Received)='10' AND DAYOFMONTH(Received)='28' 
     AND  TIME(RIGHT(TRIM(Received),8)) BETWEEN '23:00:00' AND '24:00:00'     

SELECT TIME( RIGHT( TRIM(' 2007-10-29 T 17:59:59 '),8)) BETWEEN '17:00:00' AND '17:59:59'
SELECT TIME( RIGHT( TRIM(' 2007-10-29 T 18:00:00 '),8)) BETWEEN '17:00:00' AND '17:59:59'
SELECT TIME( RIGHT( TRIM(' 2007-10-29 T 18:00:00 '),8)) BETWEEN '18:00:00' AND '18:59:59'

SELECT TIME( RIGHT( TRIM(' 2007-10-29 T 17:59:59 '),8)) >='17:00:00' AND TIME(RIGHT( TRIM('2007-10-29 T 17:59:59 '),8))<'18:00:00'
SELECT TIME( RIGHT( TRIM(' 2007-10-29 T 18:00:00 '),8)) >='17:00:00' AND TIME(RIGHT( TRIM('2007-10-29 T 18:00:00 '),8))<'18:00:00'
SELECT TIME( RIGHT( TRIM(' 2007-10-29 T 18:00:00 '),8)) >='18:00:00' AND TIME(RIGHT( TRIM('2007-10-29 T 18:00:00 '),8))<'19:00:00'

-------------------------------------------------------------------------------------------------------------------------------------------     

-- Query Para el año 2007 mes 10 dia 29 hora de 00 a 01 horas
SELECT llamadas.total AS 'Llamadas totales',
       llamadas_completadas.total AS 'Llamadas totales completadas', 
--       ROUND((llamadas_completadas.total/llamadas.total)*100) AS 'Porcentaje completadas' ,
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'Porcentaje completadas' ,
       segundos.total AS 'Total de segundos',
       (segundos.total/llamadas_completadas.total) AS 'Promedio duracion por llamada en segundos',
       minutos.total AS 'Total Minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE YEAR(Received)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29' 
     AND TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '23:59:59') 
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29'
     AND TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '23:59:59') 
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29'
     AND TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '23:59:59') 
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE YEAR(Dialed)='2007' AND MONTH(Dialed)='10' AND DAYOFMONTH(Dialed)='29'
     AND TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '23:59:59') 
     AS minutos

----------------------------------------------------------------------------------------------------------------------------------------------------

SELECT CallID,Received FROM luptmerd WHERE YEAR(Received)='2007' AND MONTH(Dialed)='10'
     AND TIME(RIGHT(TRIM(Dialed),8)) BETWEEN '00:00:00' AND '23:59:59'
     
SELECT CONCAT(DATE(TRIM(Received)),' ',TIME(RIGHT(TRIM(Received),8))) FROM luptmerd
     
SELECT CallID,Received,Dialed,Duration FROM luptmerd WHERE DATE(TRIM(Received)) 
BETWEEN '2007-09-29' AND '2007-10-28' ORDER BY Received ASC;

SELECT CallID,Received,Dialed,Duration FROM luptmerd WHERE DATE(TRIM(Received)) 
BETWEEN '2007-09-29' AND '2007-10-28' AND TIME(RIGHT(TRIM(Received),8)) BETWEEN '00:00:00' AND '23:59:59'
ORDER BY Received ASC;
     
SELECT CallID,Received,Dialed,Duration FROM luptmerd WHERE
CONCAT(DATE(TRIM(Received)),' ', TIME(RIGHT(TRIM(Received),8))) BETWEEN '2007-09-29 00:00:00' AND '2007-10-28 23:59:59'
ORDER BY Received ASC;


SELECT DATE_ADD('2007-09-29 00:00:00', INTERVAL 1 DAY);

SELECT CASE WHEN 10*2=30 THEN '30 correct'
   WHEN 10*2=40 THEN '40 correct'
   ELSE 'Should be 10*2=20'
END;

SELECT Name, RatingID AS Rating,
   CASE
      WHEN RatingID='R' THEN 'Under 17 requires an adult.'
      WHEN RatingID='X' THEN 'No one 17 and under.'
      WHEN RatingID='NR' THEN 'Use discretion when renting.'
      ELSE 'OK to rent to minors.'
   END AS Policy
FROM DVDs
ORDER BY Name;

SET @t1=0, @t2=0, @t3=0;
SELECT @t1:=(@t2:=1)+@t3:=4,@t1,@t2,@t3;
SELECT @a:=100 as result

-------------------------------------------------------------------------------------------------------------------------------------------     

-- Query Para el 2007-09-29 hasta 2007-10-28
SELECT llamadas.total AS 'Llamadas totales',
       llamadas_completadas.total AS 'Llamadas totales completadas', 
       LEFT((llamadas_completadas.total/llamadas.total)*100,4) AS 'Porcentaje completadas' ,
       segundos.total AS 'Total de segundos',
       (segundos.total/llamadas_completadas.total) AS 'Promedio duracion por llamada en segundos',
       minutos.total AS 'Total Minutos'
FROM 
     (SELECT COUNT(*) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Received)),' ', TIME(RIGHT(TRIM(Received),8))) BETWEEN '2007-09-29 00:00:00' AND '2007-10-28 23:59:59')
     AS llamadas,
     (SELECT COUNT(*) AS total FROM luptmerd WHERE Duration>0 AND CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN '2007-09-29 00:00:00' AND '2007-10-28 23:59:59')
     AS llamadas_completadas,
     (SELECT SUM(Duration) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN '2007-09-29 00:00:00' AND '2007-10-28 23:59:59')
     AS segundos,
     (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN '2007-09-29 00:00:00' AND '2007-10-28 23:59:59')
     AS minutos

-------------------------------------------------------------------------------------------------------------------------------------------     

-- Query Para el 2007-09-29 hasta 2007-10-01
SELECT (dias.dia1/dias.total)*100 AS porcentaje1,(dias.dia2/dias.total)*100 AS porcentaje2
FROM
    (SELECT minutos1.total AS dia1,
           minutos2.total AS dia2,
           minutos1.total + minutos2.total AS total
    FROM 
         (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN '2007-09-29 00:00:00' AND '2007-09-29 23:59:59')
         AS minutos1,
         (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN '2007-09-30 00:00:00' AND '2007-09-30 23:59:59')
         AS minutos2
    )
    AS dias


SELECT (dias.dia1/total.cantidad)*100 AS porcentaje1,(dias.dia2/total.cantidad)*100 AS porcentaje2
FROM
    (SELECT minutos1.total AS dia1,
           minutos2.total AS dia2
     FROM 
         (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN '2007-09-29 00:00:00' AND '2007-09-29 23:59:59')
         AS minutos1,
         (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN '2007-09-30 00:00:00' AND '2007-09-30 23:59:59')
         AS minutos2
     )
    AS dias,
    (SELECT 78 as cantidad) 
    AS total

SELECT 
       suma.porcentaje1,
       suma.porcentaje2,
       suma.porcentaje3,
       (suma.porcentaje1+suma.porcentaje3+suma.porcentaje3) 'porcentaje total',
       suma.acumulado as 'suma de minutos de todos los dias del periodo',
       suma.total as 'maximo numero de minutos',
       IF(suma.acumulado<=suma.total, suma.total-suma.acumulado, 0) AS 'minutos disponibles',
       IF(suma.acumulado<=suma.total, NULL, abs(suma.total-suma.acumulado)) AS 'minutos sobrantes'
FROM
    (SELECT (dias.dia1/total.cantidad)*100 
            AS porcentaje1,
            (dias.dia2/total.cantidad)*100 
            AS porcentaje2,
            (dias.dia3/total.cantidad)*100 
            AS porcentaje3,
            (dias.dia1+dias.dia2+dias.dia3) 
            AS acumulado,
            total.cantidad  AS 
            total
     FROM
        (SELECT 
                minutos1.total 
                AS dia1,
                minutos2.total 
                AS dia2,
                minutos3.total 
                AS dia3
         FROM 
             (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN '2007-09-29 00:00:00' AND '2007-09-29 23:59:59')
             AS minutos1,
             (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN '2007-09-30 00:00:00' AND '2007-09-30 23:59:59')
             AS minutos2,
             (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN '2007-10-01 00:00:00' AND '2007-10-01 23:59:59')
             AS minutos3
        ) 
        AS dias,
        (SELECT 104 as cantidad) 
        AS total
    )
    AS suma
-- WHERE suma.acumulado<=suma.total


SELECT 
--       suma.porcentaje1a,
--       suma.porcentaje2a,
--       suma.porcentaje3a,
--       (suma.porcentaje1a+suma.porcentaje2a+suma.porcentaje3a) 'porcentaje total 1',
       suma.porcentaje1b,
       suma.porcentaje2b,
       suma.porcentaje3b,
       (suma.porcentaje1b+suma.porcentaje2b+suma.porcentaje3b) 'porcentaje total 2',
       suma.acumulado as 'suma de minutos de todos los dias del periodo',
       suma.total as 'maximo numero de minutos',
       IF(suma.acumulado<=suma.total, suma.total-suma.acumulado, 0) AS 'minutos disponibles',
       IF(suma.acumulado<=suma.total, NULL, abs(suma.total-suma.acumulado)) AS 'minutos sobrantes'
FROM
    (SELECT 
--            (dias.dia1/dias.acumulado)*100 
--            AS porcentaje1a,
--            (dias.dia2/dias.acumulado)*100 
--            AS porcentaje2a,
--            (dias.dia3/dias.acumulado)*100 
--            AS porcentaje3a,
            (dias.dia1/dias.total)*100 
            AS porcentaje1b,
            (dias.dia2/dias.total)*100 
            AS porcentaje2b,
            (dias.dia3/dias.total)*100 
            AS porcentaje3b,
            dias.total 
            AS total,
            dias.acumulado
            AS acumulado
     FROM
        (SELECT 
                minutos1.total 
                AS dia1,
                minutos2.total 
                AS dia2,
                minutos3.total 
                AS dia3,
                (minutos1.total+minutos2.total+minutos3.total)
                AS acumulado,
                total.cantidad 
                AS total 
         FROM 
             (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN '2007-09-29 00:00:00' AND '2007-09-29 23:59:59')
             AS minutos1,
             (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN '2007-09-30 00:00:00' AND '2007-09-30 23:59:59')
             AS minutos2,
             (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN '2007-10-01 00:00:00' AND '2007-10-01 23:59:59')
             AS minutos3,
             (SELECT 120 as cantidad) 
             AS total
        ) 
        AS dias
    )
    AS suma
-- WHERE suma.acumulado<=suma.total

-- DROP PROCEDURE IF EXISTS `inovadb`.`ocupacion`;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ocupacion`(fechainicio datetime,fechafinal datetime)
BEGIN
--    DECLARE myquery VARCHAR(1000) DEFAULT '';
    DECLARE i INT DEFAULT 1;
    DECLARE fechainiciotemp datetime DEFAULT fechainicio;
    DECLARE fechafinaltemp datetime DEFAULT fechafinal;
    
    SET @sql='SELECT ';
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    WHILE fechainiciotemp < fechafinal DO
--    WHILE i < 5 DO
--        SET @sql = CONCAT(myquery,'minutos',i,'.total AS dia',i);
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total AS dia',CAST(i AS char),' ');
        ELSE
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total AS dia',CAST(i AS char),',');
        END IF;
--        SET @sql = CONCAT_WS('\n',@sql,'minutos',CAST(i AS char),'.total AS dia',CAST(i AS char),',');
--        SELECT fechainiciotemp,fechafinal,i;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET @sql = CONCAT(@sql,'FROM ');
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
/*
        SET @sql = CONCAT(@sql,'(SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN \''
                 ,CAST(fechainiciotemp AS char)
                 ,'\' AND \''
                 ,CAST(fechafinaltemp AS char)
                 ,'\')AS minutos',CAST(i AS char),',');
*/
        IF fechafinaltemp=fechafinal THEN         
            SET @sql = CONCAT(@sql,'(SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN \''
--                     ,CAST(fechainiciotemp AS char)
                     ,CAST(fechainiciotemp AS datetime)
                     ,'\' AND \''
--                     ,CAST(fechafinaltemp AS char)
                     ,CAST(fechafinaltemp AS datetime)
                     ,'\')AS minutos',CAST(i AS char));
        ELSE
            SET @sql = CONCAT(@sql,'(SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN \''
--                     ,CAST(fechainiciotemp AS char)
                     ,CAST(fechainiciotemp AS datetime)
                     ,'\' AND \''
--                     ,CAST(fechafinaltemp AS char)
                     ,CAST(fechafinaltemp AS datetime)
                     ,'\')AS minutos',CAST(i AS char),',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
--        SELECT fechainiciotemp,fechainicio,fechafinal,fechafinaltemp,i;
    END WHILE;

/*
             FROM 
                 (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN \''
                 ,fechainicio
                 ,'\' AND \''
                 ,fechafinal
                 ,'\')AS minutos1');
*/                 
--    SELECT @sql;         
    PREPARE s1 FROM @sql;
    EXECUTE s1;
    DEALLOCATE PREPARE s1;
END
$$

delimiter ;
CALL ocupacion('2007-09-29 00:00:00','2007-10-02 00:00:00');
CALL ocupacion('2007-09-29 00:00:00','2007-10-29 00:00:00');

SHOW PROCEDURE STATUS
SHOW TABLES
 
DECLARE v1 INT DEFAULT 5;

  WHILE v1 > 0 DO
    SET v1 = v1 - 1;
  END WHILE;
  
-- DROP PROCEDURE IF EXISTS `inovadb`.`ocupacion`;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ocupacion`(fechainicio datetime,fechafinal datetime,tablename varchar(100))
BEGIN
--    DECLARE myquery VARCHAR(1000) DEFAULT '';
    DECLARE i INT DEFAULT 1;
    DECLARE fechainiciotemp datetime DEFAULT fechainicio;
    DECLARE fechafinaltemp datetime DEFAULT fechafinal;
    
    SET @sql='SELECT ';
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total AS dia',CAST(i AS char),' ');
        ELSE
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total AS dia',CAST(i AS char),',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET @sql = CONCAT(@sql,'FROM ');
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
            SET @sql = CONCAT(@sql,'(SELECT SUM(CEILING(Duration/60)) AS total FROM ',tablename
                     ,' WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) >= \''
                     ,CAST(fechainiciotemp AS char)
                     ,'\' AND '
                     ,'CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) < \''
                     ,CAST(fechafinaltemp AS char)
                     ,'\')AS minutos',CAST(i AS char));
        ELSE
            SET @sql = CONCAT(@sql,'(SELECT SUM(CEILING(Duration/60)) AS total FROM ',tablename
                     ,' WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) >= \''
                     ,CAST(fechainiciotemp AS char)
                     ,'\' AND '
                     ,'CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) < \''
                     ,CAST(fechafinaltemp AS char)
                     ,'\')AS minutos',CAST(i AS char),',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
--        SELECT fechainiciotemp,fechainicio,fechafinal,fechafinaltemp,i;
    END WHILE;

    SELECT @sql;         
--    PREPARE s1 FROM @sql;
--    EXECUTE s1;
--    DEALLOCATE PREPARE s1;
END
$$

CALL ocupacion('2007-09-29 00:00:00','2007-10-02 00:00:00','luptmerd');
CALL ocupacion('2007-10-29 00:00:00','2007-11-01 00:00:00','ofomerd');

-- DROP PROCEDURE IF EXISTS `inovadb`.`ocupacion`;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ocupacion`(fechainicio datetime,fechafinal datetime,tablename varchar(100),cantidad int)
BEGIN
--    DECLARE myquery VARCHAR(1000) DEFAULT '';
    DECLARE i INT DEFAULT 1;
    DECLARE fechainiciotemp datetime DEFAULT fechainicio;
    DECLARE fechafinaltemp datetime DEFAULT fechafinal;
    
    SET @sql='SELECT ';
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total AS dia',CAST(i AS char),' ');
        ELSE
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total AS dia',CAST(i AS char),',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET @sql = CONCAT(@sql,', (');
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total ) ');
        ELSE
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total + ');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET @sql = CONCAT(@sql,'AS acumulado,total.cantidad AS total ');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET @sql = CONCAT(@sql,'FROM ');
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
            SET @sql = CONCAT(@sql,'(SELECT IF(SUM(CEILING(Duration/60)) IS NULL,0,SUM(CEILING(Duration/60))) AS total FROM ',tablename
                     ,' WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) >= \''
                     ,CAST(fechainiciotemp AS char)
                     ,'\' AND '
                     ,'CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) < \''
                     ,CAST(fechafinaltemp AS char)
                     ,'\')AS minutos',CAST(i AS char));
        ELSE
            SET @sql = CONCAT(@sql,'(SELECT IF(SUM(CEILING(Duration/60)) IS NULL,0,SUM(CEILING(Duration/60))) AS total FROM ',tablename
                     ,' WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) >= \''
                     ,CAST(fechainiciotemp AS char)
                     ,'\' AND '
                     ,'CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) < \''
                     ,CAST(fechafinaltemp AS char)
                     ,'\')AS minutos',CAST(i AS char),',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
--        SELECT fechainiciotemp,fechainicio,fechafinal,fechafinaltemp,i;
    END WHILE;

    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET @sql = CONCAT(@sql,',(SELECT ',CAST(cantidad AS char),' as cantidad) AS total');
    SET i = 1;

--    SELECT @sql;         
    PREPARE s1 FROM @sql;
    EXECUTE s1;
    DEALLOCATE PREPARE s1;
END
$$

CALL ocupacion('2007-09-29 00:00:00','2007-10-02 00:00:00','luptmerd',120);
CALL ocupacion('2007-10-29 00:00:00','2007-11-01 00:00:00','ofomerd',120);

-- DROP PROCEDURE IF EXISTS `inovadb`.`ocupacion`;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ocupacion`(fechainicio datetime,fechafinal datetime,tablename varchar(100),cantidad int)
BEGIN
--    DECLARE myquery VARCHAR(1000) DEFAULT '';
    DECLARE i INT DEFAULT 1;
    DECLARE fechainiciotemp datetime DEFAULT fechainicio;
    DECLARE fechafinaltemp datetime DEFAULT fechafinal;
    DECLARE accumulated_minutes float DEFAULT 0;
    
    SET @sql='SELECT ';
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'suma.porcentaje',CAST(i AS char),' AS \'',CAST(DATE(fechainiciotemp) AS char),'\' ');
        ELSE
           SET @sql = CONCAT(@sql,'suma.porcentaje',CAST(i AS char),' AS \'',CAST(DATE(fechainiciotemp) AS char),'\',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET @sql = CONCAT(@sql,', (');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'suma.porcentaje',CAST(i AS char),' ) ');
        ELSE
           SET @sql = CONCAT(@sql,'suma.porcentaje',CAST(i AS char),' + ');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;
    
    SET @sql = CONCAT(@sql,'AS \'Porcentaje Total \',');
    SET @sql = CONCAT(@sql,'suma.acumulado as \'Suma de todos los dias\',');
    SET @sql = CONCAT(@sql,'suma.total as \'Maximo numero de minutos\',');
    SET @sql = CONCAT(@sql,'IF(suma.acumulado<=suma.total, suma.total-suma.acumulado, 0) AS \'Minutos disponibles\',');
    SET @sql = CONCAT(@sql,'IF(suma.acumulado<=suma.total, 0, abs(suma.total-suma.acumulado)) AS \'Minutos sobrantes\' ');
    SET @sql = CONCAT(@sql,'FROM (');
    SET @sql = CONCAT(@sql,'SELECT ');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'(dias.dia',CAST(i AS char),'/dias.total)*100 AS porcentaje',CAST(i AS char),' ');
        ELSE
           SET @sql = CONCAT(@sql,'(dias.dia',CAST(i AS char),'/dias.total)*100 AS porcentaje',CAST(i AS char),', ');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET @sql = CONCAT(@sql,', dias.total AS total');
    SET @sql = CONCAT(@sql,', dias.acumulado AS acumulado FROM(');
    SET @sql = CONCAT(@sql,'SELECT ');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total AS dia',CAST(i AS char),' ');
        ELSE
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total AS dia',CAST(i AS char),',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET @sql = CONCAT(@sql,', (');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total ) ');
        ELSE
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total + ');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET @sql = CONCAT(@sql,'AS acumulado,total.cantidad AS total ');
    SET @sql = CONCAT(@sql,'FROM ');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
            SET @sql = CONCAT(@sql,'(SELECT IF(SUM(CEILING(Duration/60)) IS NULL,0,SUM(CEILING(Duration/60))) AS total FROM ',tablename
                     ,' WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) >= \''
                     ,CAST(fechainiciotemp AS char)-- ,' 00:00:00'
                     ,'\' AND '
                     ,'CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) < \''
                     ,CAST(fechafinaltemp AS char)-- ,' 00:00:00'
                     ,'\')AS minutos',CAST(i AS char));
        ELSE
            SET @sql = CONCAT(@sql,'(SELECT IF(SUM(CEILING(Duration/60)) IS NULL,0,SUM(CEILING(Duration/60))) AS total FROM ',tablename
                     ,' WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) >= \''
                     ,CAST(fechainiciotemp AS char)-- ,' 00:00:00'
                     ,'\' AND '
                     ,'CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) < \''
                     ,CAST(fechafinaltemp AS char)-- ,' 00:00:00'
                     ,'\')AS minutos',CAST(i AS char),',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
--        SELECT fechainiciotemp,fechainicio,fechafinal,fechafinaltemp,i;
    END WHILE;

    SET @sql = CONCAT(@sql,',(SELECT ',CAST(cantidad AS char),' as cantidad) AS total');
    SET @sql = CONCAT(@sql,') AS dias');
    SET @sql = CONCAT(@sql,') AS suma');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;

--    SELECT @sql;         
    PREPARE s1 FROM @sql;
    EXECUTE s1;
    DEALLOCATE PREPARE s1;
END
$$

CALL ocupacion('2007-09-29 00:00:00','2007-10-02 00:00:00','luptmerd',120);
CALL ocupacion('2007-10-29 00:00:00','2007-11-01 00:00:00','ofomerd',14900);

CALL ocupacion('2007-09-29','2007-10-02','luptmerd',120);
CALL ocupacion('2007-10-29','2007-11-01','ofomerd',14900);

SELECT
--       suma.porcentaje1a,
--       suma.porcentaje2a,
--       suma.porcentaje3a,
--       (suma.porcentaje1a+suma.porcentaje2a+suma.porcentaje3a) 'porcentaje total 1',
--       @ = suma.porcentaje1b as
--       suma.porcentaje1b as
       IF( suma.porcentaje1b>100,100,suma.porcentaje1b)as
       porcentaje1b,
--       IF( (100-suma.porcentaje2b,100,porcentaje1b)as
       IF( suma.porcentaje2b>(100-suma.porcentaje1b), IF( (100-suma.porcentaje1b)<0 ,0,(100-suma.porcentaje1b)),suma.porcentaje2b)as
--       IF( suma.porcentaje2b>100,100,suma.porcentaje2b)as
       porcentaje2b,
       IF( suma.porcentaje3b>(100-suma.porcentaje2b-suma.porcentaje1b), IF( (100-suma.porcentaje2b-suma.porcentaje1b)<0,0,(100-suma.porcentaje2b-suma.porcentaje1b)),suma.porcentaje3b)as
--       IF( (suma.porcentaje2b+suma.porcentaje3b)>100,(suma.porcentaje2b+suma.porcentaje3b)-100,porcentaje3b)as
--       IF( suma.porcentaje3b>100,100,suma.porcentaje3b)as
       porcentaje3b,
       IF( (porcentaje1b+porcentaje2b+porcentaje3b)>100,100,(porcentaje1b+porcentaje2b+porcentaje3b)) AS 'porcentaje total',
       suma.acumulado as 'suma de minutos de todos los dias del periodo',
       suma.total as 'maximo numero de minutos',
       IF(suma.acumulado<=suma.total, suma.total-suma.acumulado, 0) AS 'minutos disponibles',
       IF(suma.acumulado<=suma.total, NULL, abs(suma.total-suma.acumulado)) AS 'minutos sobrantes'
FROM
    (SELECT 
--            (dias.dia1/dias.acumulado)*100 
--            AS porcentaje1a,
--            (dias.dia2/dias.acumulado)*100 
--            AS porcentaje2a,
--            (dias.dia3/dias.acumulado)*100 
--            AS porcentaje3a,
            (dias.dia1/dias.total)*100 
            AS porcentaje1b,
            (dias.dia2/dias.total)*100 
            AS porcentaje2b,
            (dias.dia3/dias.total)*100 
            AS porcentaje3b,
            dias.total 
            AS total,
            dias.acumulado
            AS acumulado
     FROM
        (SELECT 
                minutos1.total 
                AS dia1,
                minutos2.total 
                AS dia2,
                minutos3.total 
                AS dia3,
                (minutos1.total+minutos2.total+minutos3.total)
                AS acumulado,
                total.cantidad 
                AS total 
         FROM 
             (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN '2007-09-29 00:00:00' AND '2007-09-29 23:59:59')
             AS minutos1,
             (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN '2007-09-30 00:00:00' AND '2007-09-30 23:59:59')
             AS minutos2,
             (SELECT SUM(CEILING(Duration/60)) AS total FROM luptmerd WHERE CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) BETWEEN '2007-10-01 00:00:00' AND '2007-10-01 23:59:59')
             AS minutos3,
             (SELECT 80 as cantidad) 
             AS total
        ) 
        AS dias
    )
    AS suma
-- WHERE suma.acumulado<=suma.total

SELECT @a:=
(dias.dia/dias.total)*100 AS porcentaje
FROM
(
    SELECT minutos.total AS dia,
    total.cantidad AS total 
    FROM (SELECT IF(SUM(CEILING(Duration/60)) IS NULL,0,SUM(CEILING(Duration/60))) AS total FROM luptmerd 
    WHERE CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) >= '2007-10-29 00:00:00' 
    AND CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) < '2007-10-30 00:00:00')
    AS minutos,
    (SELECT 12371 as cantidad) AS total
) 
AS dias

SELECT FORMAT(@a,4)

-- DROP PROCEDURE IF EXISTS `inovadb`.`ocupacion`;
--CREATE DEFINER=`root`@`localhost` PROCEDURE `ocupacion`(fechainicio datetime,fechafinal datetime,tablename varchar(100),cantidad int)
DELIMITER $$
DROP PROCEDURE IF EXISTS `inovadb`.`ocupacion`$$
CREATE PROCEDURE `ocupacion`(fechainicio datetime,fechafinal datetime,tablename varchar(100),cantidad int)
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE fechainiciotemp datetime DEFAULT fechainicio;
    DECLARE fechafinaltemp datetime DEFAULT fechafinal;
    DECLARE accumulated_minutes float DEFAULT 0;
    
    SET @sql='SELECT ';
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'FORMAT(final.porcentaje',CAST(i AS char),',4) AS \'',CAST(DATE(fechainiciotemp) AS char),'\' ');
        ELSE
           SET @sql = CONCAT(@sql,'FORMAT(final.porcentaje',CAST(i AS char),',4) AS \'',CAST(DATE(fechainiciotemp) AS char),'\',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET @sql = CONCAT(@sql,', (');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'FORMAT(final.porcentaje',CAST(i AS char),',4) ) ');
        ELSE
           SET @sql = CONCAT(@sql,'FORMAT(final.porcentaje',CAST(i AS char),',4) + ');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;
    
    SET @sql = CONCAT(@sql,' AS \'Porcentaje Total \',');
    SET @sql = CONCAT(@sql,'final.acumulado AS \'Suma de todos los dias\',');
    SET @sql = CONCAT(@sql,'final.total as \'Maximo numero de minutos\',');
    SET @sql = CONCAT(@sql,'final.disponibles AS \'Minutos disponibles\',');
    SET @sql = CONCAT(@sql,'final.sobrantes AS \'Minutos sobrantes\' ');
    SET @sql = CONCAT(@sql,'FROM( ');
    SET @sql = CONCAT(@sql,'SELECT ');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    SET @total_percent = 0;
    SET @left_percent = 100;
    WHILE fechainiciotemp < fechafinal DO
        SET @sql2 = '';
        SET @sql2 = CONCAT(@sql2,'SELECT @percent_per_day:= (dias.dia/dias.total)*100 AS porcentaje FROM');
        SET @sql2 = CONCAT(@sql2,'(SELECT minutos.total AS dia,total.cantidad AS total FROM ');
        SET @sql2 = CONCAT(@sql2,'(SELECT IF(SUM(CEILING(Duration/60)) IS NULL,0,SUM(CEILING(Duration/60))) AS total FROM ',tablename);
        SET @sql2 = CONCAT(@sql2,' WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) >= \'');
        SET @sql2 = CONCAT(@sql2,CAST(fechainiciotemp AS char),'\' AND ','CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) < \'');
        SET @sql2 = CONCAT(@sql2,CAST(fechafinaltemp AS char),'\')AS minutos');
        SET @sql2 = CONCAT(@sql2,',(SELECT ',CAST(cantidad AS char),' as cantidad) AS total');
        SET @sql2 = CONCAT(@sql2,') AS dias');
        PREPARE s2 FROM @sql2;
        EXECUTE s2;
        DEALLOCATE PREPARE s2;
        SET @percent_per_day = FORMAT(@percent_per_day,4);
        SET @total_percent = @total_percent + @percent_per_day;

        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'IF(suma.porcentaje',CAST(i AS char),'>',CAST(@left_percent AS char)
               ,',IF(',CAST(@left_percent AS char),'<0,0,',CAST(@left_percent AS char),'),suma.porcentaje',CAST(i AS char),')'
               ,' AS porcentaje',CAST(i AS char));
        ELSE
           SET @sql = CONCAT(@sql,'IF(suma.porcentaje',CAST(i AS char),'>',CAST(@left_percent AS char)
               ,',IF(',CAST(@left_percent AS char),'<0,0,',CAST(@left_percent AS char),'),suma.porcentaje',CAST(i AS char),')'
               ,' AS porcentaje',CAST(i AS char),',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
        SET @left_percent = @left_percent - @percent_per_day;
    END WHILE;

    SET @sql = CONCAT(@sql,',suma.acumulado AS acumulado,');
    SET @sql = CONCAT(@sql,'suma.total AS total,');
    SET @sql = CONCAT(@sql,'IF(suma.acumulado<=suma.total, suma.total-suma.acumulado, 0) AS disponibles,');
    SET @sql = CONCAT(@sql,'IF(suma.acumulado<=suma.total, 0, abs(suma.total-suma.acumulado)) AS sobrantes ');
    SET @sql = CONCAT(@sql,'FROM (');
    SET @sql = CONCAT(@sql,'SELECT ');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'(dias.dia',CAST(i AS char),'/dias.total)*100 AS porcentaje',CAST(i AS char),' ');
        ELSE
           SET @sql = CONCAT(@sql,'(dias.dia',CAST(i AS char),'/dias.total)*100 AS porcentaje',CAST(i AS char),', ');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET @sql = CONCAT(@sql,', dias.total AS total');
    SET @sql = CONCAT(@sql,', dias.acumulado AS acumulado FROM(');
    SET @sql = CONCAT(@sql,'SELECT ');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total AS dia',CAST(i AS char),' ');
        ELSE
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total AS dia',CAST(i AS char),',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET @sql = CONCAT(@sql,', (');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total ) ');
        ELSE
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total + ');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET @sql = CONCAT(@sql,'AS acumulado,total.cantidad AS total ');
    SET @sql = CONCAT(@sql,'FROM ');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
            SET @sql = CONCAT(@sql,'(SELECT IF(SUM(CEILING(Duration/60)) IS NULL,0,SUM(CEILING(Duration/60))) AS total FROM ',tablename
                     ,' WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) >= \''
--                     ,CAST(fechainiciotemp AS char),' 00:00:00'
                     ,CAST(fechainiciotemp AS char)
                     ,'\' AND '
                     ,'CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) < \''
--                     ,CAST(fechafinaltemp AS char),' 00:00:00'
                     ,CAST(fechafinaltemp AS char)
                     ,'\')AS minutos',CAST(i AS char));
        ELSE
            SET @sql = CONCAT(@sql,'(SELECT IF(SUM(CEILING(Duration/60)) IS NULL,0,SUM(CEILING(Duration/60))) AS total FROM ',tablename
                     ,' WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) >= \''
--                     ,CAST(fechainiciotemp AS char),' 00:00:00'
                     ,CAST(fechainiciotemp AS char)
                     ,'\' AND '
                     ,'CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) < \''
--                     ,CAST(fechafinaltemp AS char),' 00:00:00'
                     ,CAST(fechafinaltemp AS char)
                     ,'\')AS minutos',CAST(i AS char),',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
--        SELECT fechainiciotemp,fechainicio,fechafinal,fechafinaltemp,i;
    END WHILE;

    SET @sql = CONCAT(@sql,',(SELECT ',CAST(cantidad AS char),' as cantidad) AS total');
    SET @sql = CONCAT(@sql,') AS dias');
    SET @sql = CONCAT(@sql,') AS suma');
    SET @sql = CONCAT(@sql,') AS final');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;

--    SELECT @sql;
--    SELECT @sql2;
--    SELECT @percent_per_day,@total_percent;
    PREPARE s1 FROM @sql;
    EXECUTE s1;
    DEALLOCATE PREPARE s1;
END;
$$
DELIMITER;

CALL ocupacion('2007-09-29 00:00:00','2007-10-02 00:00:00','luptmerd',120);
CALL ocupacion('2007-10-29 00:00:00','2007-11-01 00:00:00','luptmerd',12371);
CALL ocupacion('2007-10-29 00:00:00','2007-10-30 00:00:00','luptmerd',12371);
CALL ocupacion('2007-10-29 00:00:00','2007-11-01 00:00:00','ofomerd',14900);
CALL ocupacion('2007-10-29 00:00:00','2007-11-01 00:00:00','luptmerd',11371);

-- CALL ocupacion('2007-09-01 00:00:00','2007-11-01 00:00:00','ofomerd',14900); -- marca error
CALL ocupacion('2007-09-01 00:00:00','2007-10-31 00:00:00','ofomerd',14900);
CALL ocupacion('2007-09-29','2007-10-02','luptmerd',120);
CALL ocupacion('2007-09-29','2007-10-02','luptmerd',104);
delimiter ;
CALL ocupacion('2007-10-29','2007-11-01','ofomerd',14900);

-- Query generado por 
-- CALL ocupacion('2007-10-29 00:00:00','2007-11-01 00:00:00','luptmerd',11371);
-- CALL ocupacion('2007-10-29','2007-11-01','luptmerd',11371);
SELECT 
    FORMAT(final.porcentaje1,4) AS '2007-10-29',
    FORMAT(final.porcentaje2,4) AS '2007-10-30',
    FORMAT(final.porcentaje3,4) AS '2007-10-31' , 
    (FORMAT(final.porcentaje1,4) + FORMAT(final.porcentaje2,4) + FORMAT(final.porcentaje3,4) )  AS 'Porcentaje Total ',
    final.acumulado as 'Suma de todos los dias',
    final.total as 'Maximo numero de minutos',
    final.disponibles AS 'Minutos disponibles',
    final.sobrantes AS 'Minutos sobrantes' 
FROM( 
      SELECT 
             IF(suma.porcentaje1>100,IF(100<0,0,100),suma.porcentaje1) AS porcentaje1,
             IF(suma.porcentaje2>6.4198,IF(6.4198<0,0,6.4198),suma.porcentaje2) AS porcentaje2,
             IF(suma.porcentaje3>-8.7943,IF(-8.7943<0,0,-8.7943),suma.porcentaje3) AS porcentaje3,
             suma.acumulado AS acumulado,
             suma.total AS total,
             IF(suma.acumulado<=suma.total, suma.total-suma.acumulado, 0) AS disponibles,
             IF(suma.acumulado<=suma.total, 0, abs(suma.total-suma.acumulado)) AS sobrantes
      FROM 
             (SELECT 
                     (dias.dia1/dias.total)*100 AS porcentaje1, 
                     (dias.dia2/dias.total)*100 AS porcentaje2, 
                     (dias.dia3/dias.total)*100 AS porcentaje3 , 
                     dias.total AS total, 
                     dias.acumulado AS acumulado 
             FROM
                 (SELECT 
                         minutos1.total AS dia1,
                         minutos2.total AS dia2,
                         minutos3.total AS dia3 , 
                         (minutos1.total + minutos2.total + minutos3.total ) AS acumulado,
                         total.cantidad AS total 
                 FROM 
                      (SELECT 
                              IF(SUM(CEILING(Duration/60)) IS NULL,0,SUM(CEILING(Duration/60))) AS total 
                      FROM 
                           luptmerd 
                      WHERE 
                            CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) >= '2007-10-29 00:00:00' 
                            AND CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) < '2007-10-30 00:00:00')
                      AS minutos1,
                      (SELECT 
                              IF(SUM(CEILING(Duration/60)) IS NULL,0,SUM(CEILING(Duration/60))) AS total 
                      FROM 
                           luptmerd 
                      WHERE 
                            CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) >= '2007-10-30 00:00:00' 
                            AND CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) < '2007-10-31 00:00:00')
                      AS minutos2,
                      (SELECT 
                              IF(SUM(CEILING(Duration/60)) IS NULL,0,SUM(CEILING(Duration/60))) AS total 
                      FROM 
                           luptmerd 
                      WHERE 
                            CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) >= '2007-10-31 00:00:00' 
                            AND CONCAT(DATE(TRIM(Dialed)),' ', TIME(RIGHT(TRIM(Dialed),8))) < '2007-11-01 00:00:00')
                      AS minutos3,
                      (SELECT 11371 as cantidad) 
                      AS total) 
                 AS dias) 
             AS suma) 
      AS final



DROP PROCEDURE IF EXISTS `leer`;
CREATE DEFINER=`root`@`localhost` PROCEDURE `leer`(tablename varchar(100))
BEGIN
    SET @sql='SELECT * from ';
    SET @sql = CONCAT(@sql,tablename);

    SELECT @sql;

--    PREPARE s1 FROM @sql;
--    EXECUTE s1;
--    DEALLOCATE PREPARE s1;
END;

DROP PROCEDURE IF EXISTS `leer`;
CREATE DEFINER=`root`@`localhost` PROCEDURE `leer`(tablename varchar(100))
BEGIN
    SET @sql ='SELECT  @total:= count(*) ';
    SET @sql = CONCAT(@sql,' FROM ',tablename);
--    SELECT @sql;

    PREPARE s1 FROM @sql;
    EXECUTE s1;
    DEALLOCATE PREPARE s1;
END;
CALL leer('luptmerd');
select @total

DROP PROCEDURE IF EXISTS `leer`;
CREATE DEFINER=`root`@`localhost` PROCEDURE `leer`(tablename varchar(100),OUT outvar int)
BEGIN
    
    SET @sql ='SELECT  count(*) into ? FROM ?';
--    SELECT @sql;

    PREPARE s1 FROM @sql;
    SET @tabla = tablename;
    SET @outvarible = outvar;
    EXECUTE s1 USING @tabla,@outvarible;
    DEALLOCATE PREPARE s1;
END;

CALL leer('luptmerd',@total);
select @total


delimiter //
DROP PROCEDURE IF EXISTS `simpleproc`//
CREATE PROCEDURE simpleproc (OUT param1 INT)
BEGIN
     SELECT COUNT(*) INTO param1 FROM luptmerd;
END;
//
delimiter ;

CALL simpleproc(@a);
SELECT @a;
      


CREATE FUNCTION hello (s CHAR(20)) RETURNS CHAR(50)
       RETURN CONCAT('Hello, ',s,'!');

SELECT hello('world');

-- Procedimiento 1
DROP PROCEDURE IF EXISTS `inovadb`.`ocupacion`;
-- CREATE PROCEDURE `ocupacion`(INOUT fechainicio DATETIME,INOUT fechafinal DATETIME,tablename VARCHAR(100),cantidad INT,INOUT initialport INT,INOUT finalport INT,temp VARCHAR(100))
-- CREATE PROCEDURE `ocupacion`(fechainicio DATETIME,fechafinal DATETIME,tablename VARCHAR(100),cantidad INT,initialport INT,finalport INT,temp VARCHAR(100))
CREATE DEFINER=`root`@`localhost` PROCEDURE `ocupacion`(fechainicio DATETIME,fechafinal DATETIME,tablename VARCHAR(100),cantidad INT,initialport INT,finalport INT,temp VARCHAR(100))
-- CREATE DEFINER=`root`@`%` PROCEDURE `ocupacion`(fechainicio DATETIME,fechafinal DATETIME,tablename VARCHAR(100),cantidad INT,initialport INT,finalport INT,temp VARCHAR(100))
-- CREATE DEFINER=`inova`@`%` PROCEDURE `ocupacion`(fechainicio DATETIME,fechafinal DATETIME,tablename VARCHAR(100),cantidad INT,initialport INT,finalport INT,temp VARCHAR(100))
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE fechainiciotemp datetime DEFAULT fechainicio;
    DECLARE fechafinaltemp datetime DEFAULT fechafinal;
    DECLARE accumulated_minutes float DEFAULT 0;
    DECLARE currentdate DATETIME DEFAULT NOW();
    
    SET @portinitemp = initialport;
    SET @portfintemp = finalport;
    
    SET @portmin = 'SELECT MIN(LocalChannel) INTO @portmin FROM ';
    SET @portmin = CONCAT(@portmin,tablename);
    PREPARE s1 FROM @portmin;
    EXECUTE s1;
    DEALLOCATE PREPARE s1;
    
    SET @portmax = 'SELECT @portmax:= MAX(LocalChannel) FROM ';
    SET @portmax = CONCAT(@portmax,tablename);
    PREPARE s1 FROM @portmax;
    EXECUTE s1;
    DEALLOCATE PREPARE s1;
   
--   SELECT @portmin,@portmax;
   
    IF @portfintemp > @portmax THEN
       SET @portfintemp = @portmax;
    END IF;     

    IF @portinitemp < @portmin THEN
       SET @portfintemp = @portmin;
    END IF;     
/*    
    SET @sql = 'DROP TABLE IF EXISTS ';
    SET @sql = CONCAT(@sql,temp);
    PREPARE s1 FROM @sql;
    EXECUTE s1;
    DEALLOCATE PREPARE s1;
*/
--    SET @sql = 'CREATE TEMPORARY TABLE ';
    SET @sql = 'CREATE TABLE ';
    SET @sql = CONCAT(@sql,temp,' SELECT ');
--    SET @sql='SELECT ';
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'FORMAT(final.porcentaje',CAST(i AS char),',4) AS \'',CAST(DATE(fechainiciotemp) AS char),'\' ');
        ELSE
           SET @sql = CONCAT(@sql,'FORMAT(final.porcentaje',CAST(i AS char),',4) AS \'',CAST(DATE(fechainiciotemp) AS char),'\',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET @sql = CONCAT(@sql,', (');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'FORMAT(final.porcentaje',CAST(i AS char),',4) ) ');
        ELSE
           SET @sql = CONCAT(@sql,'FORMAT(final.porcentaje',CAST(i AS char),',4) + ');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;
    
    SET @sql = CONCAT(@sql,' AS Porcentaje_Total,');
    SET @sql = CONCAT(@sql,'final.acumulado AS Total_x_Dias,');
    SET @sql = CONCAT(@sql,'final.total as Maximo_Minutos,');
    SET @sql = CONCAT(@sql,'final.disponibles AS Minutos_Disponibles,');
    SET @sql = CONCAT(@sql,'final.sobrantes AS Minutos_Sobrantes ');
    SET @sql = CONCAT(@sql,'FROM( ');
    SET @sql = CONCAT(@sql,'SELECT ');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    
    SET i = 1;
    SET @total_percent = 0;
    SET @left_percent = 100;
    SET @percent_per_day = 0;
    
    WHILE fechainiciotemp < fechafinal DO
        SET @sql2 = '';
        SET @sql2 = CONCAT(@sql2,'SELECT @percent_per_day:= (dias.dia/dias.total)*100 AS porcentaje FROM');
        SET @sql2 = CONCAT(@sql2,'(SELECT minutos.total AS dia,total.cantidad AS total FROM ');
        SET @sql2 = CONCAT(@sql2,'(SELECT IF(SUM(CEILING(Duration/60)) IS NULL,0,SUM(CEILING(Duration/60))) AS total FROM ',tablename);
        SET @sql2 = CONCAT(@sql2,' WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) >= \'');
        SET @sql2 = CONCAT(@sql2,CAST(fechainiciotemp AS char),'\' AND ','CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) < \'');
        SET @sql2 = CONCAT(@sql2,CAST(fechafinaltemp AS char),'\')AS minutos');
        SET @sql2 = CONCAT(@sql2,',(SELECT ',CAST(cantidad AS char),' as cantidad) AS total');
        SET @sql2 = CONCAT(@sql2,') AS dias');
        PREPARE s2 FROM @sql2;
        EXECUTE s2;
        DEALLOCATE PREPARE s2;

        SET @percent_per_day = FORMAT(@percent_per_day,4);
        SET @total_percent = @total_percent + @percent_per_day;

        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'IF(suma.porcentaje',CAST(i AS char),'>',CAST(@left_percent AS char)
               ,',IF(',CAST(@left_percent AS char),'<0,0,',CAST(@left_percent AS char),'),suma.porcentaje',CAST(i AS char),')'
               ,' AS porcentaje',CAST(i AS char));
        ELSE
           SET @sql = CONCAT(@sql,'IF(suma.porcentaje',CAST(i AS char),'>',CAST(@left_percent AS char)
               ,',IF(',CAST(@left_percent AS char),'<0,0,',CAST(@left_percent AS char),'),suma.porcentaje',CAST(i AS char),')'
               ,' AS porcentaje',CAST(i AS char),',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
        SET @left_percent = @left_percent - @percent_per_day;
    END WHILE;

    SET @sql = CONCAT(@sql,',suma.acumulado AS acumulado,');
    SET @sql = CONCAT(@sql,'suma.total AS total,');
    SET @sql = CONCAT(@sql,'IF(suma.acumulado<=suma.total, suma.total-suma.acumulado, 0) AS disponibles,');
    SET @sql = CONCAT(@sql,'IF(suma.acumulado<=suma.total, 0, abs(suma.total-suma.acumulado)) AS sobrantes ');
    SET @sql = CONCAT(@sql,'FROM (');
    SET @sql = CONCAT(@sql,'SELECT ');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'(dias.dia',CAST(i AS char),'/dias.total)*100 AS porcentaje',CAST(i AS char),' ');
        ELSE
           SET @sql = CONCAT(@sql,'(dias.dia',CAST(i AS char),'/dias.total)*100 AS porcentaje',CAST(i AS char),', ');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET @sql = CONCAT(@sql,', dias.total AS total');
    SET @sql = CONCAT(@sql,', dias.acumulado AS acumulado FROM(');
    SET @sql = CONCAT(@sql,'SELECT ');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total AS dia',CAST(i AS char),' ');
        ELSE
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total AS dia',CAST(i AS char),',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET @sql = CONCAT(@sql,', (');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total ) ');
        ELSE
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total + ');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET @sql = CONCAT(@sql,'AS acumulado,total.cantidad AS total ');
    SET @sql = CONCAT(@sql,'FROM ');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
            SET @sql = CONCAT(@sql,'(SELECT IF(SUM(CEILING(Duration/60)) IS NULL,0,SUM(CEILING(Duration/60))) AS total FROM ',tablename
                     ,' WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) >= \''
--                     ,CAST(fechainiciotemp AS char),' 00:00:00'
                     ,CAST(fechainiciotemp AS char)
                     ,'\' AND '
                     ,'CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) < \''
--                     ,CAST(fechafinaltemp AS char),' 00:00:00'
                     ,CAST(fechafinaltemp AS char)
                     ,'\' AND LocalChannel BETWEEN ',CAST(@portinitemp AS char),' AND ',CAST(@portfintemp AS char)
                     ,')AS minutos',CAST(i AS char));
        ELSE
            SET @sql = CONCAT(@sql,'(SELECT IF(SUM(CEILING(Duration/60)) IS NULL,0,SUM(CEILING(Duration/60))) AS total FROM ',tablename
                     ,' WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) >= \''
--                     ,CAST(fechainiciotemp AS char),' 00:00:00'
                     ,CAST(fechainiciotemp AS char)
                     ,'\' AND '
                     ,'CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) < \''
                     ,CAST(fechafinaltemp AS char)
                     ,'\' AND LocalChannel BETWEEN ',CAST(@portinitemp AS char),' AND ',CAST(@portfintemp AS char)
                     ,')AS minutos',CAST(i AS char),',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
--        SELECT fechainiciotemp,fechainicio,fechafinal,fechafinaltemp,i;
    END WHILE;

    SET @sql = CONCAT(@sql,',(SELECT ',CAST(cantidad AS char),' as cantidad) AS total');
    SET @sql = CONCAT(@sql,') AS dias');
    SET @sql = CONCAT(@sql,') AS suma');
    SET @sql = CONCAT(@sql,') AS final');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;

   SELECT @sql;
--    SELECT @sql2;
--    SELECT @percent_per_day,@total_percent;
    PREPARE s1 FROM @sql;
    EXECUTE s1;
    DEALLOCATE PREPARE s1;

--    SET @sql = 'SELECT * FROM ';
--    SET @sql = CONCAT(@sql,temp);
--    PREPARE s1 FROM @sql;
--    EXECUTE s1;
--    DEALLOCATE PREPARE s1;

--    SET @sql = 'DROP TABLE IF EXISTS ';
--    SET @sql = CONCAT(@sql,temp);
--    PREPARE s1 FROM @sql;
--    EXECUTE s1;
--    DEALLOCATE PREPARE s1;
END;


-- Procedimiento 2
DROP PROCEDURE IF EXISTS `inovadb`.`porcentaje`;
-- CREATE PROCEDURE `porcentaje`(INOUT percent_per_day FLOAT,fechainiciotemp DATETIME,fechafinaltemp DATETIME,tablename VARCHAR(100),cantidad INT)
CREATE DEFINER=`root`@`localhost` PROCEDURE `porcentaje`(INOUT percent_per_day FLOAT,fechainiciotemp DATETIME,fechafinaltemp DATETIME,tablename VARCHAR(100),cantidad INT)
BEGIN
    SET @sql2 = '';
--    SET @sql2 = CONCAT(@sql2,'SELECT @percent_per_day:= (dias.dia/dias.total)*100 AS porcentaje FROM');
    SET @sql2 = CONCAT(@sql2,'SELECT (dias.dia/dias.total)*100 AS porcentaje INTO @varInOut FROM');
    SET @sql2 = CONCAT(@sql2,'(SELECT minutos.total AS dia,total.cantidad AS total FROM ');
    SET @sql2 = CONCAT(@sql2,'(SELECT IF(SUM(CEILING(Duration/60)) IS NULL,0,SUM(CEILING(Duration/60))) AS total FROM ',tablename);
    SET @sql2 = CONCAT(@sql2,' WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) >= \'');
    SET @sql2 = CONCAT(@sql2,CAST(fechainiciotemp AS char),'\' AND ','CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) < \'');
    SET @sql2 = CONCAT(@sql2,CAST(fechafinaltemp AS char),'\')AS minutos');
    SET @sql2 = CONCAT(@sql2,',(SELECT ',CAST(cantidad AS char),' AS cantidad) AS total');
    SET @sql2 = CONCAT(@sql2,') AS dias');
  
--    SELECT @sql2;
    
    PREPARE s2 FROM @sql2;
    EXECUTE s2;
    DEALLOCATE PREPARE s2;
    SET percent_per_day = @varInOut;
END;

DROP PROCEDURE IF EXISTS `inovadb`.`ocupacion`;
-- CREATE PROCEDURE `ocupacion`(INOUT fechainicio DATETIME,INOUT fechafinal DATETIME,tablename VARCHAR(100),cantidad INT,INOUT initialport INT,INOUT finalport INT,temp VARCHAR(100))
-- CREATE PROCEDURE `ocupacion`(fechainicio DATETIME,fechafinal DATETIME,tablename VARCHAR(100),cantidad INT,initialport INT,finalport INT,temp VARCHAR(100))
CREATE DEFINER=`root`@`localhost` PROCEDURE `ocupacion`(fechainicio DATETIME,fechafinal DATETIME,tablename VARCHAR(100),cantidad INT,initialport INT,finalport INT,temp VARCHAR(100))
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE fechainiciotemp datetime DEFAULT fechainicio;
    DECLARE fechafinaltemp datetime DEFAULT fechafinal;
    DECLARE accumulated_minutes float DEFAULT 0;
    DECLARE currentdate DATETIME DEFAULT NOW();
    
    SET @portinitemp = initialport;
    SET @portfintemp = finalport;
    
    SET @portmin = 'SELECT MIN(LocalChannel) INTO @portmin FROM ';
    SET @portmin = CONCAT(@portmin,tablename);
    PREPARE s1 FROM @portmin;
    EXECUTE s1;
    DEALLOCATE PREPARE s1;
    
    SET @portmax = 'SELECT @portmax:= MAX(LocalChannel) FROM ';
    SET @portmax = CONCAT(@portmax,tablename);
    PREPARE s1 FROM @portmax;
    EXECUTE s1;
    DEALLOCATE PREPARE s1;
   
--   SELECT @portmin,@portmax;
   
    IF @portfintemp > @portmax THEN
       SET @portfintemp = @portmax;
    END IF;     

    IF @portinitemp < @portmin THEN
       SET @portfintemp = @portmin;
    END IF;     
    
    SET @sql = 'DROP TABLE IF EXISTS ';
    SET @sql = CONCAT(@sql,temp);
    PREPARE s1 FROM @sql;
    EXECUTE s1;
    DEALLOCATE PREPARE s1;


--    SET @sql = 'CREATE TEMPORARY TABLE ';
    SET @sql = 'CREATE TABLE ';
    SET @sql = CONCAT(@sql,temp,' SELECT ');
--    SET @sql='SELECT ';
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'FORMAT(final.porcentaje',CAST(i AS char),',4) AS \'',CAST(DATE(fechainiciotemp) AS char),'\' ');
        ELSE
           SET @sql = CONCAT(@sql,'FORMAT(final.porcentaje',CAST(i AS char),',4) AS \'',CAST(DATE(fechainiciotemp) AS char),'\',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET @sql = CONCAT(@sql,', (');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'FORMAT(final.porcentaje',CAST(i AS char),',4) ) ');
        ELSE
           SET @sql = CONCAT(@sql,'FORMAT(final.porcentaje',CAST(i AS char),',4) + ');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;
    
    SET @sql = CONCAT(@sql,' AS Porcentaje_Total,');
    SET @sql = CONCAT(@sql,'final.acumulado AS Total_x_Dias,');
    SET @sql = CONCAT(@sql,'final.total as Maximo_Minutos,');
    SET @sql = CONCAT(@sql,'final.disponibles AS Minutos_Disponibles,');
    SET @sql = CONCAT(@sql,'final.sobrantes AS Minutos_Sobrantes ');
    SET @sql = CONCAT(@sql,'FROM( ');
    SET @sql = CONCAT(@sql,'SELECT ');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    SET @total_percent = 0;
    SET @left_percent = 100;
    SET @percent_per_day = 0;
    
    WHILE fechainiciotemp < fechafinal DO

--        CALL porcentaje(fechainiciotemp,fechafinaltemp,tablename,cantidad);
--        CALL porcentaje(@percent_per_day,'2007-10-29','2007-11-01','luptmerd',14900);
        CALL porcentaje(@percent_per_day,fechainiciotemp,fechafinaltemp,tablename,cantidad);
--        SELECT @percent_per_day;
--        SET @percent_per_day = 50;     
        SET @percent_per_day = FORMAT(@percent_per_day,4);
        SET @total_percent = @total_percent + @percent_per_day;

        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'IF(suma.porcentaje',CAST(i AS char),'>',CAST(@left_percent AS char)
               ,',IF(',CAST(@left_percent AS char),'<0,0,',CAST(@left_percent AS char),'),suma.porcentaje',CAST(i AS char),')'
               ,' AS porcentaje',CAST(i AS char));
        ELSE
           SET @sql = CONCAT(@sql,'IF(suma.porcentaje',CAST(i AS char),'>',CAST(@left_percent AS char)
               ,',IF(',CAST(@left_percent AS char),'<0,0,',CAST(@left_percent AS char),'),suma.porcentaje',CAST(i AS char),')'
               ,' AS porcentaje',CAST(i AS char),',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
        SET @left_percent = @left_percent - @percent_per_day;
    END WHILE;

    SET @sql = CONCAT(@sql,',suma.acumulado AS acumulado,');
    SET @sql = CONCAT(@sql,'suma.total AS total,');
    SET @sql = CONCAT(@sql,'IF(suma.acumulado<=suma.total, suma.total-suma.acumulado, 0) AS disponibles,');
    SET @sql = CONCAT(@sql,'IF(suma.acumulado<=suma.total, 0, abs(suma.total-suma.acumulado)) AS sobrantes ');
    SET @sql = CONCAT(@sql,'FROM (');
    SET @sql = CONCAT(@sql,'SELECT ');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'(dias.dia',CAST(i AS char),'/dias.total)*100 AS porcentaje',CAST(i AS char),' ');
        ELSE
           SET @sql = CONCAT(@sql,'(dias.dia',CAST(i AS char),'/dias.total)*100 AS porcentaje',CAST(i AS char),', ');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET @sql = CONCAT(@sql,', dias.total AS total');
    SET @sql = CONCAT(@sql,', dias.acumulado AS acumulado FROM(');
    SET @sql = CONCAT(@sql,'SELECT ');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total AS dia',CAST(i AS char),' ');
        ELSE
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total AS dia',CAST(i AS char),',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET @sql = CONCAT(@sql,', (');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total ) ');
        ELSE
           SET @sql = CONCAT(@sql,'minutos',CAST(i AS char),'.total + ');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
    END WHILE;

    SET @sql = CONCAT(@sql,'AS acumulado,total.cantidad AS total ');
    SET @sql = CONCAT(@sql,'FROM ');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;
    WHILE fechainiciotemp < fechafinal DO
        IF fechafinaltemp=fechafinal THEN         
            SET @sql = CONCAT(@sql,'(SELECT IF(SUM(CEILING(Duration/60)) IS NULL,0,SUM(CEILING(Duration/60))) AS total FROM ',tablename
                     ,' WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) >= \''
--                     ,CAST(fechainiciotemp AS char),' 00:00:00'
                     ,CAST(fechainiciotemp AS char)
                     ,'\' AND '
                     ,'CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) < \''
--                     ,CAST(fechafinaltemp AS char),' 00:00:00'
                     ,CAST(fechafinaltemp AS char)
                     ,'\' AND LocalChannel BETWEEN ',CAST(@portinitemp AS char),' AND ',CAST(@portfintemp AS char)
                     ,')AS minutos',CAST(i AS char));
        ELSE
            SET @sql = CONCAT(@sql,'(SELECT IF(SUM(CEILING(Duration/60)) IS NULL,0,SUM(CEILING(Duration/60))) AS total FROM ',tablename
                     ,' WHERE CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) >= \''
--                     ,CAST(fechainiciotemp AS char),' 00:00:00'
                     ,CAST(fechainiciotemp AS char)
                     ,'\' AND '
                     ,'CONCAT(DATE(TRIM(Dialed)),\' \', TIME(RIGHT(TRIM(Dialed),8))) < \''
                     ,CAST(fechafinaltemp AS char)
                     ,'\' AND LocalChannel BETWEEN ',CAST(@portinitemp AS char),' AND ',CAST(@portfintemp AS char)
                     ,')AS minutos',CAST(i AS char),',');
        END IF;
        SET i = i + 1;
        SET fechainiciotemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
        SET fechafinaltemp = DATE_ADD(fechafinaltemp, INTERVAL 1 DAY);
--        SELECT fechainiciotemp,fechainicio,fechafinal,fechafinaltemp,i;
    END WHILE;

    SET @sql = CONCAT(@sql,',(SELECT ',CAST(cantidad AS char),' as cantidad) AS total');
    SET @sql = CONCAT(@sql,') AS dias');
    SET @sql = CONCAT(@sql,') AS suma');
    SET @sql = CONCAT(@sql,') AS final');
    SET fechainiciotemp = fechainicio;
    SET fechafinaltemp = DATE_ADD(fechainiciotemp, INTERVAL 1 DAY);
    SET i = 1;

--    SELECT @sql;
--    SELECT @sql2;
--    SELECT @percent_per_day,@total_percent;
    PREPARE s1 FROM @sql;
    EXECUTE s1;
    DEALLOCATE PREPARE s1;

    SET @sql = 'SELECT * FROM ';
    SET @sql = CONCAT(@sql,temp);
    PREPARE s1 FROM @sql;
    EXECUTE s1;
    DEALLOCATE PREPARE s1;

--    SET @sql = 'DROP TABLE IF EXISTS ';
--    SET @sql = CONCAT(@sql,temp);
--    PREPARE s1 FROM @sql;
--    EXECUTE s1;
--    DEALLOCATE PREPARE s1;
END;

CALL ocupacion('2007-10-28','2007-11-01','luptmerd',14900,0,32,'tmp');
CALL ocupacion('2007-09-29','2007-10-02','luptmerd',120,0,32,'tmp');
CALL ocupacion('2007-09-29','2007-10-02','luptmerd',104,0,32,'tmp');
CALL ocupacion('2007-09-29','2007-10-02','luptmerd',104,0,20,'tmp');
CALL ocupacion('2007-09-29','2007-11-05','luptmerd',104,0,20,'tmp');
CALL ocupacion('2007-09-29','2007-11-28','luptmerd',104,0,32,'tmp');
CALL ocupacion('2007-09-29','2007-11-29','luptmerd',104,0,33,'tmp');--marca error too many table MYSQL only can use 61 tables in a join
SELECT * FROM tmp
      
CALL ocupacion('2007-11-02','2007-11-24','ofomerd',1500,0,32,'tmp');      
CALL ocupacion('2007-09-29','2007-10-29','luptmerd',1200,0,32,'tmp');
CALL ocupacion('2007-11-01','2007-11-16','ofomerd',15000,0,32,'tmp');      
SELECT * FROM tmp
