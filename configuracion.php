<? include("cabecera.php"); ?>
<!-- incluyo la cabecera -->
<!-- del contenido -->
<script>
miconfig = function(){}

miconfig.trim = function(string){
      return string.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
}

/* Ajax Actualizacion de Datos de Acceso */
miconfig.acceso = function(campo){
   //alert(campo.value);
    var user_old=document.getElementById('txt_usuario_old').value
    var pass_old=document.getElementById('txt_password_old').value
    var user_new=document.getElementById('txt_usuario_new').value
    var pass_new=document.getElementById('txt_password_new').value
    
    //alert(user_old);
    //alert(user_new);
    //alert(pass_old);
    //alert(pass_new);
    
     var url="includes/classlib/ResponseAjax.php?ajax=5"; 
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = miconfig.updateaccesoAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("user_old=" + escape(user_old) + "&pass_old=" + escape(pass_old) + "&user_new=" + escape(user_new) + "&pass_new=" + escape(pass_new));        
}

miconfig.updateaccesoAjax=function()
{
    if (request.readyState == 4){
        if (request.status == 200) {               
             var dataAcceso = request.responseText;
             alert(dataAcceso);
         }
     }
}

/* Ajax Actualizacion de Datos de Acceso */

/*Agregar Valores de Ocupacion en Ajax*/

miconfig.ocupacion = function(campo){
     //alert(campo.value);
     var txt_fecha_inicio=document.getElementById('txt_fecha_inicio').value;
     //alert(txt_fecha_inicio);  
     var txt_fecha_fin=document.getElementById('txt_fecha_final').value;
     //alert(txt_fecha_fin);
     var gateway=document.getElementById('cbx_gateway').value;
     //alert(gateway);       
     var minutos=document.getElementById('txt_minutos_ocupacion').value;      
     var puertoinicial=document.getElementById('txt_puertoinicio').value;      
     var puertofinal=document.getElementById('txt_puertofinal').value;      
     //alert(minutos);
     if(txt_fecha_inicio!="" && txt_fecha_fin != "" && gateway != "false" && minutos != "0" && minutos != "" && puertoinicial!="" && puertofinal!=""){
         if(txt_fecha_inicio < txt_fecha_fin){
         if(puertoinicial < puertofinal){
         var url="includes/classlib/ResponseAjax.php?ajax=7"; 
         url = url + "&dummy=" + new Date().getTime();  
         request.open("POST", url, true);
         request.onreadystatechange = miconfig.updateocupacionAjax;
         request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
         request.send("txt_fecha_inicio=" + escape(txt_fecha_inicio) + "&txt_fecha_fin=" + escape(txt_fecha_fin) + "&gateway=" + escape(gateway) + "&minutos=" + escape(minutos) + "&puertoinicial=" + escape(puertoinicial) + "&puertofinal=" + escape(puertofinal));
         }else{
         alert('El puerto inicial no puede ser mayor que el puerto final.');
         }
         }else{
            alert('La fecha de inicio es menor que la fecha final.');
         }
     }else{
        alert('Debes llenar todos los campos. \n- Verifique que haya un fecha inicial. \n - Verifique que haya una fecha final.\n - Verifique que haya un puerto inicio.\n - Verifique que haya un puerto final.\n- Verifique que haya un gateway seleccionado\n- Los minutos no pueden ser 0, ni estar vacio');
     }    
}

miconfig.updateocupacionAjax=function()
{
    if (request.readyState == 4){
        if (request.status == 200) {               
            var data = request.responseText;
            //alert(data);
            // string = dataLotes;
            //data=miconfig.trim(string);
            var gridOcupacion=document.getElementById('gridOcupacion');
            //alert(gridOcupacion);
            //alert(gridOcupacion.innerHTML);
            gridOcupacion.innerHTML=data;
         }
     }
}
/*Agregar Valores de Ocupacion en Ajax*/

/*Eliminar valores de ocupacion*/
miconfig.eliminarocupacion= function (campo){
    // alert(campo.name);
    if(confirm('Desea eliminar el registro de ocupacion.')){
     var id=campo.name;
     var url="includes/classlib/ResponseAjax.php?ajax=8"; 
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = miconfig.updateeliminaocupacionAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("id=" + escape(id));    
     }    
}

miconfig.updateeliminaocupacionAjax=function()
{
    if (request.readyState == 4){
        if (request.status == 200) {               
            var dataOcupacion = request.responseText;
            // string = dataLotes;
            //data=miconfig.trim(string);
            var gridOcupacion=document.getElementById('gridOcupacion');
            gridOcupacion.innerHTML=dataOcupacion;
            //alert(dataOcupacion);
        }
    }
}

/*Fin Eliminar valores de ocupacion*/

/* Modificar valores de ocupacion*/
miconfig.modificarocupacion= function (campo){ 
   
     //alert(campo.name);
     var row=campo.name;
     var idgateway="rowGateway_"+row;
     var idfechainicio="rowFechainicio_"+row;
     var idfechafin="rowFechafin_"+row;
     var idminutos="rowMinutos_"+row; 
     var idportinicio="rowPortInicio_"+row; 
     var idportfinal="rowPortFinal_"+row;
//     alert(idgateway)
     //alert(id);
     //alert(row);
     //gateway=document.getElementById(eval(id)).firstChild.nodeValue;
     var gateway = document.getElementById(idgateway).firstChild.nodeValue;
     var fechainicio = document.getElementById(idfechainicio).firstChild.nodeValue;
     var fechafin = document.getElementById(idfechafin).firstChild.nodeValue;
     var minutos = document.getElementById(idminutos).firstChild.nodeValue;
     var portinicio = document.getElementById(idportinicio).firstChild.nodeValue;
     var portfinal = document.getElementById(idportfinal).firstChild.nodeValue;
     //alert(gateway);
     //alert(fechainicio);
     //alert(fechafin);
     //alert(minutos);
     var url="includes/classlib/ResponseAjax.php?ajax=9"; 
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = miconfig.updatemodificarocupacionAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("row=" + escape(row) + "&gateway=" + escape(gateway) + "&fechainicio=" + escape(fechainicio) + "&fechafin=" + escape(fechafin) + "&minutos=" + escape(minutos) + "&puertoinicio=" + escape(portinicio) + "&puertofinal=" + escape(portfinal));   
}

miconfig.updatemodificarocupacionAjax=function()
{
    if (request.readyState == 4){
        if (request.status == 200) {               
            var data = request.responseText;
            var data=data.split("+");
            //alert(data);
            //alert(data.length);
            //for (i=0;i<data.length;i++){
                //alert(data[i]);
            //}

            var row=data[0];
            var cell1id="ocupacion_gateway_"+row;
            var cell2id="ocupacion_portinicio_"+row;
            var cell3id="ocupacion_portfin_"+row;
            var cell4id="ocupacion_fechaini_"+row;
            var cell5id="ocupacion_fechafin_"+row;
            var cell6id="ocupacion_minutos_"+row;
            var cell7id="ocupacion_btn1_"+row;
            var cell8id="ocupacion_btn2_"+row;
            

            var cell1=document.getElementById(cell1id);
            cell1.innerHTML=data[1];

            var cell2=document.getElementById(cell2id);
            cell2.innerHTML=data[2];

            var cell3=document.getElementById(cell3id);
            cell3.innerHTML=data[3];

            var cell4=document.getElementById(cell4id);
            cell4.innerHTML=data[4];
            
            var cell5=document.getElementById(cell5id);
            cell5.innerHTML=data[5];

            var cell6=document.getElementById(cell6id);
            cell6.innerHTML=data[6];
            
            var cell7=document.getElementById(cell7id);
            cell7.innerHTML=data[7];
            
            var cell8=document.getElementById(cell8id);
            cell8.innerHTML=data[8];
            
            eval(data[9]); 

            eval(data[10]);
        }
    }
}
/* Fin Modificar valores de ocupacion*/

/* Cancelar valores de ocupacion*/
miconfig.cancelarocupacion= function (campo){
        
  // alert(campo.name);
   var row=campo.name;
   var url="includes/classlib/ResponseAjax.php?ajax=10"; 
   url = url + "&dummy=" + new Date().getTime();  
   request.open("POST", url, true);
   request.onreadystatechange = miconfig.updatecancelarocupacionAjax;
   request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   request.send("row=" + escape(row));    
}

miconfig.updatecancelarocupacionAjax=function()
{
    if (request.readyState == 4){
        if (request.status == 200) {   
            var data = request.responseText;
            var data=data.split("+");
            //alert(data);
            //alert(data.length);
            //for (i=0;i<data.length;i++){
                //alert(data[i]);
            //}

            var row=data[0];
            var cell1id="ocupacion_gateway_"+row;
            var cell2id="ocupacion_portinicio_"+row;
            var cell3id="ocupacion_portfin_"+row;
            var cell4id="ocupacion_fechaini_"+row;
            var cell5id="ocupacion_fechafin_"+row;
            var cell6id="ocupacion_minutos_"+row;
            var cell7id="ocupacion_btn1_"+row;
            var cell8id="ocupacion_btn2_"+row;
            

            var cell1=document.getElementById(cell1id);
            cell1.innerHTML=data[1];

            var cell2=document.getElementById(cell2id);
            cell2.innerHTML=data[2];

            var cell3=document.getElementById(cell3id);
            cell3.innerHTML=data[3];

            var cell4=document.getElementById(cell4id);
            cell4.innerHTML=data[4];
            
            var cell5=document.getElementById(cell5id);
            cell5.innerHTML=data[5];

            var cell6=document.getElementById(cell6id);
            cell6.innerHTML=data[6];
            
            var cell7=document.getElementById(cell7id);
            cell7.innerHTML=data[7];
            
            var cell8=document.getElementById(cell8id);
            cell8.innerHTML=data[8];
        }
    }
}

/* Fin Cancelar valores de ocupacion*/
miconfig.guardarocupacion= function (campo){ 
    
   //alert(campo.name);
   var row=campo.name;
   var gateway=("cbx_gateway_"+row);
   var fechainicio="txt_mod_fecha_inicio_"+row;
   var fechafin="txt_mod_fecha_fin_"+row;
   var minutos="txt_mod_minutos_"+row;
   var portinicio="txt_portinicio_"+row; 
   var portfinal="txt_portfinal_"+row;
   var gateway=document.getElementById(gateway).value;
   var fechainicio=document.getElementById(fechainicio).value;
   var fechafin=document.getElementById(fechafin).value;
   var minutos=document.getElementById(minutos).value;
   var portfinal=document.getElementById(portfinal).value;
   var portinicio=document.getElementById(portinicio).value;

   //alert(gateway);
   //alert(minutos); 
   if(fechainicio!="" && fechafin != "" && gateway != "false" && minutos != "0" && minutos != ""){
   if(fechainicio < fechafin){
   if(portfinal>portinicio){
   var url="includes/classlib/ResponseAjax.php?ajax=11"; 
   url = url + "&dummy=" + new Date().getTime();  
   request.open("POST", url, true);
   request.onreadystatechange = miconfig.updateguardarocupacionAjax;
   request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   request.send("row=" + escape(row) + "&gateway=" + escape(gateway) + "&fechainicio=" + escape(fechainicio) + "&fechafin=" + escape(fechafin) + "&minutos=" + escape(minutos) + "&portinicio=" + escape(portinicio) + "&portfinal=" + escape(portfinal) );
   }else{
         alert('El puerto inicial no puede ser mayor que el puerto final.');
   }
   }else{
     alert('La fecha de inicio es menor que la fecha final.');
     }
   }else{
     alert('Debes llenar todos los campos.\n\n- Verifique que haya un fecha inicial. \n - Verifique que haya una fecha final.\n- Verifique que haya un gateway seleccionado\n- Los minutos no pueden ser 0, ni estar vacio');
   } 
}

miconfig.updateguardarocupacionAjax=function()
{
    if (request.readyState == 4){
        if (request.status == 200){  
            var data = request.responseText;
            var data=data.split("+");
            //alert(data);
            //alert(data.length);
            //for (i=0;i<data.length;i++){
                //alert(data[i]);
            //}

            var row=data[0];
            var cell1id="ocupacion_gateway_"+row;
            var cell2id="ocupacion_portinicio_"+row;
            var cell3id="ocupacion_portfin_"+row;
            var cell4id="ocupacion_fechaini_"+row;
            var cell5id="ocupacion_fechafin_"+row;
            var cell6id="ocupacion_minutos_"+row;
            var cell7id="ocupacion_btn1_"+row;
            var cell8id="ocupacion_btn2_"+row;
            

            var cell1=document.getElementById(cell1id);
            cell1.innerHTML=data[1];

            var cell2=document.getElementById(cell2id);
            cell2.innerHTML=data[2];

            var cell3=document.getElementById(cell3id);
            cell3.innerHTML=data[3];

            var cell4=document.getElementById(cell4id);
            cell4.innerHTML=data[4];
            
            var cell5=document.getElementById(cell5id);
            cell5.innerHTML=data[5];

            var cell6=document.getElementById(cell6id);
            cell6.innerHTML=data[6];
            
            var cell7=document.getElementById(cell7id);
            cell7.innerHTML=data[7];
            
            var cell8=document.getElementById(cell8id);
            cell8.innerHTML=data[8];
        }
    }
}

/*Agregar Valores de Lote en Ajax*/
miconfig.lote = function(campo){
//     var gateway=document.getElementById('cbx_gatewaylote');
//     alert(gateway);       
//     alert(gateway.tagName);       
//     alert(gateway.value);
     var gateway=document.getElementById('cbx_gatewaylote').value;
     //alert(gateway);
//     var cantidad=document.getElementById('txt_minutos_lote');
//     alert(cantidad);
//     alert(cantidad.tagName);
//     alert(cantidad.value);
     var cantidad=document.getElementById('txt_minutos_lote').value;      
     //alert(cantidad);
     if(gateway != "false" && cantidad != "0" && cantidad != ""){
     var url="includes/classlib/ResponseAjax.php?ajax=12"; 
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = miconfig.updateloteAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("&gateway=" + escape(gateway) + "&cantidad=" + escape(cantidad));    
     }else{
        alert('Debes llenar todos los campos.\n\n- Verifique que haya un gateway seleccionado\n- La cantidad de minutos no pueden ser 0, ni estar vacio');
     }    
}

miconfig.updateloteAjax=function()
{
    if (request.readyState == 4){
        if (request.status == 200) {               
            var data = request.responseText;
            //alert(data);
            // string = dataLotes;
            //data=miconfig.trim(string);
            var gridLote=document.getElementById('gridLote');
            //alert(gridLote);
            //alert(gridLote.innerHTML);
            gridLote.innerHTML=data;
        }
    }
}
/*Agregar Valores de Lote en Ajax*/

/* Modificar valores de lote*/
miconfig.modificarlote= function (campo){ 
     var row=campo.name;
     var idgateway="rowGatewayLote_"+row;
     //alert(idgateway)
     //alert(document.getElementById(idgateway));
     var idcantidad="rowCantidad_"+row;  
     //alert(idcantidad)
     var gateway = document.getElementById(idgateway).firstChild.nodeValue;
     //alert(gateway);
     var cantidad = document.getElementById(idcantidad).firstChild.nodeValue;
     //alert(cantidad);
     var url="includes/classlib/ResponseAjax.php?ajax=13"; 
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = miconfig.updatemodificarloteAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("row=" + escape(row) + "&gateway=" + escape(gateway) + "&cantidad=" + escape(cantidad));   
}

miconfig.updatemodificarloteAjax=function()
{
    if (request.readyState == 4){
        if (request.status == 200) {               
            var data = request.responseText;
            //alert(data);
            //eval(data);

//            var div=document.getElementById("gridLote");
//            alert(div.innerHTML);
            var data=data.split("+");
            //alert(data);
            //alert(data.length);
            //for (i=0;i<data.length;i++){
                //alert(data[i]);
            //}


            var row=data[0];
            var cell1id="lote_gateway_"+row;
            var cell2id="lote_cantidad_"+row;
            var cell3id="lote_btn1_"+row;
            var cell4id="lote_btn2_"+row;

            //alert(data[1]);
            
            var cell1=document.getElementById(cell1id);
            cell1.innerHTML=data[1];

            var cell2=document.getElementById(cell2id);
            cell2.innerHTML=data[2];

            var cell3=document.getElementById(cell3id);
            cell3.innerHTML=data[3];

            var cell4=document.getElementById(cell4id);
            cell4.innerHTML=data[4];
        }
    }
}

miconfig.guardarlote=function (campo){ 
    
   //alert(campo.name);
   var row=campo.name;
   var idgateway="cbx_gatewaylote_"+row;
   var idcantidad="txt_mod_cantidad_"+row;
   var gateway=document.getElementById(idgateway).value;
   var cantidad=document.getElementById(idcantidad).value;
   if(gateway != "false" && cantidad != "0" && cantidad != ""){
       var url="includes/classlib/ResponseAjax.php?ajax=14"; 
       url = url + "&dummy=" + new Date().getTime();  
       request.open("POST", url, true);
       request.onreadystatechange = miconfig.updateguardarloteAjax;
       request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
       request.send("row=" + escape(row) + "&gateway=" + escape(gateway) + "&cantidad=" + escape(cantidad) );
   }else{
     alert('Debes llenar todos los campos.\n\n- Verifique que haya un gateway seleccionado\n- Los minutos no pueden ser 0, ni estar vacio');
   } 
}

miconfig.updateguardarloteAjax=function()
{
    if (request.readyState == 4){
        if (request.status == 200){  
            var data=request.responseText;
            var data=data.split("+");
            //for (i=0;i<data.length;i++){
                //alert(data[i]);
            //}

            //var div=document.getElementById("gridLote");
            //alert(div.innerHTML);

            var row=data[0];
            var cell1id="lote_gateway_"+row;
            var cell2id="lote_cantidad_"+row;
            var cell3id="lote_btn1_"+row;
            var cell4id="lote_btn2_"+row;

            var cell1=document.getElementById(cell1id);
            cell1.innerHTML=data[1];

            var cell2=document.getElementById(cell2id);
            cell2.innerHTML=data[2];

            var cell3=document.getElementById(cell3id);
            cell3.innerHTML=data[3];

            var cell4=document.getElementById(cell4id);
            cell4.innerHTML=data[4];
        }
    }
}

/* Cancelar valores de lote*/
miconfig.cancelarlote= function (campo){
        
   //alert(campo.name);
   var row=campo.name;
   var url="includes/classlib/ResponseAjax.php?ajax=15"; 
   url = url + "&dummy=" + new Date().getTime();  
   request.open("POST", url, true);
   request.onreadystatechange = miconfig.updatecancelarloteAjax;
   request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   request.send("row=" + escape(row));    
}

miconfig.updatecancelarloteAjax=function()
{
    if (request.readyState == 4){
        if (request.status == 200) {   
            var data=request.responseText;
            var data=data.split("+");
            //for (i=0;i<data.length;i++){
                //alert(data[i]);
            //}

            //var div=document.getElementById("gridLote");
            //alert(div.innerHTML);

            var row=data[0];
            var cell1id="lote_gateway_"+row;
            var cell2id="lote_cantidad_"+row;
            var cell3id="lote_btn1_"+row;
            var cell4id="lote_btn2_"+row;

            var cell1=document.getElementById(cell1id);
            cell1.innerHTML=data[1];

            var cell2=document.getElementById(cell2id);
            cell2.innerHTML=data[2];

            var cell3=document.getElementById(cell3id);
            cell3.innerHTML=data[3];

            var cell4=document.getElementById(cell4id);
            cell4.innerHTML=data[4];
        }
    }
}
/* Fin Cancelar valores de lote*/

/* Eliminar valores de lote*/
miconfig.eliminarlote= function (campo){
    // alert(campo.name);
    if(confirm('Desea eliminar el registro de lote.')){
     var id=campo.name;
     var url="includes/classlib/ResponseAjax.php?ajax=16"; 
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = miconfig.updateeliminaloteAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("id=" + escape(id));    
     }    
}

miconfig.updateeliminaloteAjax=function()
{
    if (request.readyState == 4){
        if (request.status == 200) {               
            var data = request.responseText;
            // string = dataLotes;
            //data=miconfig.trim(string);
            var gridLote=document.getElementById('gridLote');
            gridLote.innerHTML=data;
            //alert(dataOcupacion);
         }
     }
}
/*Fin Eliminar valores de lote*/

/*Agregar Valores de ip en Ajax*/
miconfig.ip = function(campo){
     var gateway=document.getElementById('cbx_gatewayip').value;
     var ip=document.getElementById('txt_ip').value;      
     if(gateway != "false" && ip != ""){
        //var JSRegExp=/^[0-2][0-9]({0,2}).[0-2][0-9]({0,2}).[0-2][0-9]({0,2}).[0-2][0-9]({0,2})$/;
        var JSRegExp = /^((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){3}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})$/;
        if(ip.match(JSRegExp)){ 
             var url="includes/classlib/ResponseAjax.php?ajax=17"; 
             url = url + "&dummy=" + new Date().getTime();  
             request.open("POST", url, true);
             request.onreadystatechange = miconfig.updateipAjax;
             request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
             request.send("&gateway=" + escape(gateway) + "&ip=" + escape(ip));    
        }
        else{
            alert('Ip no valida');
        }
     }else{
        alert('Debes llenar todos los campos.\n\n- Verifique que haya un gateway seleccionado\n- El ip no puede estar vacio');
     }    
}

miconfig.updateipAjax=function()
{
    if (request.readyState == 4){
        if (request.status == 200) {               
             var data = request.responseText;
             //alert(data);
            // string = dataLotes;
             //data=miconfig.trim(string);
             var gridIp=document.getElementById('gridIp');
             //alert(gridIp);
             //alert(gridIp.firstChild.nodeValue);
             //alert(gridIp.innerHTML);
             gridIp.innerHTML=data;
             //alert(data);
             //alert(dataOcupacion);
         }
     }
}
/* Fin de agregar Valores de ip en Ajax*/

/* Modificar valores de ip*/
miconfig.modificarip= function (campo){ 
     var row=campo.name;
     var idgateway="rowGatewayIp_"+row;
     //alert(idgateway)
     var idip="rowIp_"+row;  
     //alert(idip)
     var gateway = document.getElementById(idgateway).firstChild.nodeValue;
     //alert(gateway);
     var ip = document.getElementById(idip).firstChild.nodeValue;
     //alert(ip);
     var url="includes/classlib/ResponseAjax.php?ajax=18"; 
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = miconfig.updatemodificaripAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("row=" + escape(row) + "&gateway=" + escape(gateway) + "&ip=" + escape(ip));   
}

miconfig.updatemodificaripAjax=function()
{
    if (request.readyState == 4){
        if (request.status == 200) {               
            var data=request.responseText;
            var data=data.split("+");
            //for (i=0;i<data.length;i++){
                //alert(data[i]);
            //}

            //var div=document.getElementById("gridLote");
            //alert(div.innerHTML);

            var row=data[0];
            var cell1id="ip_gateway_"+row;
            var cell2id="ip_ip_"+row;
            var cell3id="ip_btn1_"+row;
            var cell4id="ip_btn2_"+row;

            var cell1=document.getElementById(cell1id);
            cell1.innerHTML=data[1];

            var cell2=document.getElementById(cell2id);
            cell2.innerHTML=data[2];

            var cell3=document.getElementById(cell3id);
            cell3.innerHTML=data[3];

            var cell4=document.getElementById(cell4id);
            cell4.innerHTML=data[4];
        }
    }
}

miconfig.guardarip= function (campo){ 
   //alert(campo.name);
   var row=campo.name;
   var idgateway="cbx_gatewayip_"+row;
   var idip="txt_mod_ip_"+row;
   var gateway=document.getElementById(idgateway).value;
   var ip=document.getElementById(idip).value;
   //alert(gateway);
   //alert(ip); 
     if(gateway != "false" && ip != ""){
        var JSRegExp = /^((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){3}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})$/;
        if(ip.match(JSRegExp)){ 
             var url="includes/classlib/ResponseAjax.php?ajax=19"; 
             url = url + "&dummy=" + new Date().getTime();  
             request.open("POST", url, true);
             request.onreadystatechange = miconfig.updateguardaripAjax;
             request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
             request.send("row=" + escape(row) + "&gateway=" + escape(gateway) + "&ip=" + escape(ip));
        }else{
            alert('Ip no valida');
        }
     }else{
        alert('Debes llenar todos los campos.\n\n- Verifique que haya un gateway seleccionado\n- El ip no puede estar vacio');
     }
}

miconfig.updateguardaripAjax=function()
{
    if (request.readyState == 4){
        if (request.status == 200){  
            var data=request.responseText;
            var data=data.split("+");
            //for (i=0;i<data.length;i++){
                //alert(data[i]);
            //}

            //var div=document.getElementById("gridLote");
            //alert(div.innerHTML);

            var row=data[0];
            var cell1id="ip_gateway_"+row;
            var cell2id="ip_ip_"+row;
            var cell3id="ip_btn1_"+row;
            var cell4id="ip_btn2_"+row;

            var cell1=document.getElementById(cell1id);
            cell1.innerHTML=data[1];

            var cell2=document.getElementById(cell2id);
            cell2.innerHTML=data[2];

            var cell3=document.getElementById(cell3id);
            cell3.innerHTML=data[3];

            var cell4=document.getElementById(cell4id);
            cell4.innerHTML=data[4];
        }
    }
}

/* Cancelar valores de ip*/
miconfig.cancelarip= function (campo){
        
  // alert(campo.name);
   var row=campo.name;
   var url="includes/classlib/ResponseAjax.php?ajax=20"; 
   url = url + "&dummy=" + new Date().getTime();  
   request.open("POST", url, true);
   request.onreadystatechange = miconfig.updatecancelaripAjax;
   request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   request.send("row=" + escape(row));    
}

miconfig.updatecancelaripAjax=function()
{
    if (request.readyState == 4){
        if (request.status == 200) {   
            var data=request.responseText;
            var data=data.split("+");
            //for (i=0;i<data.length;i++){
                //alert(data[i]);
            //}

            //var div=document.getElementById("gridLote");
            //alert(div.innerHTML);

            var row=data[0];
            var cell1id="ip_gateway_"+row;
            var cell2id="ip_ip_"+row;
            var cell3id="ip_btn1_"+row;
            var cell4id="ip_btn2_"+row;

            var cell1=document.getElementById(cell1id);
            cell1.innerHTML=data[1];

            var cell2=document.getElementById(cell2id);
            cell2.innerHTML=data[2];

            var cell3=document.getElementById(cell3id);
            cell3.innerHTML=data[3];

            var cell4=document.getElementById(cell4id);
            cell4.innerHTML=data[4];
        }
    }
}
/* Fin Cancelar valores de ip*/

/* Eliminar valores de Ip*/
miconfig.eliminarip= function (campo){
     //alert(campo.name);
    if(confirm('Desea eliminar la ip.')){
     var id=campo.name;
     var url="includes/classlib/ResponseAjax.php?ajax=21"; 
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = miconfig.updateeliminaipAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("id=" + escape(id));    
     }    
}

miconfig.updateeliminaipAjax=function()
{
    if (request.readyState == 4){
        if (request.status == 200) {               
            var data = request.responseText;
            var gridLote=document.getElementById('gridIp');
            gridLote.innerHTML=data;
        }
    }
}

/*Fin Eliminar valores de ip*/

/* Exportar a excel una de la tablas*/
miconfig.exportAjax=function(){
    gateway=document.getElementById('cbx_exp_gateway').value;
    fecha_inicio=document.getElementById('txt_inicio').value;
    fecha_final=document.getElementById('txt_final').value;
	espera=document.getElementById('div_espera');
    if(gateway!='false'){
        if(fecha_inicio < fecha_final || fecha_inicio=='' || fecha_final==''){
     var url="includes/classlib/ResponseAjax.php?ajax=23"; 
     url = url + "&dummy=" + new Date().getTime();  
     request.open("POST", url, true);
     request.onreadystatechange = miconfig.updateExportAjax;
     request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
     request.send("gateway=" + escape(gateway) + "&fechainicio=" + escape(fecha_inicio) + "&fechafinal=" + escape(fecha_final));
	 espera.innerHTML='<img src="images/load_1.gif" /><span class="styleNBG"> Generando Archivo...</span>';
        }else{alert('La fecha inicial no puede ser mayor que la final.');}
    }else{alert('Debes seleccionar un Gateway.')}

}

miconfig.updateExportAjax=function(){
    if (request.readyState == 4){
        if (request.status == 200) {  
            dataExport = request.responseText;
            //alert(dataExport);
           // window.open(dataExport,'_blank');
           base="<?=base;?>";
           document.location = base + "/includes/classlib/temp/" + dataExport;
           //document.location="http://localhost/inova_home/includes/classlib/temp/" + dataExport;
           //document.location="http://localhost:8080/file:/E:/inova_home/includes/classlib/temp/" + dataExport;
           espera.innerHTML="";
        }
    }
}
/* Fin Exportar a excel una de la tablas*/

</script>

<form name="frm" method="post">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="lineHorizontal"><img src="./images/gateways.gif" border="0"><a href="panel.php" class="styleMain">&nbsp;&nbsp;Gateways </a>&nbsp;|&nbsp; <img src="./images/ocupacional.gif" border="0" /><a href="ocupacionales.php" class="styleMain"> % ocupacion</a>&nbsp;|&nbsp; <img src="./images/dir_p.gif" border="0" /> <a href="tablaip.php" class="styleMain">Tabla IP's </a>&nbsp;|&nbsp; <img src="./images/configuracion.gif" border="0" /><a href="configuracion.php" class="styleMain"> &nbsp;&nbsp;Configuracion</a>&nbsp;|&nbsp;<img src="./images/cerrar_s_1.gif" border="0" /><a href="index.php?logout=true" class="styleMain">&nbsp;&nbsp;Cerrar Sesion</a></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td class="lineHorizontal"><span class="styleNBLM">Configuraciones</span></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td>
    <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="50%" valign="top">
        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td class="lineHorizontal"><span class="styleNBLM">&nbsp;.:. Configuracion de Acceso</span></td>
          </tr>
          <tr>
            <td class="lineVerticalA lineHorizontal"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" class="lineHorizontal"><span class="styleContent">.:. Actualizar datos de usuario.</span></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>
                <table width="98%" border="0" align="center" cellpadding="0" cellspacing="3">
                  <tr>
                    <td width="10%"><span class="styleContent">Usuario :</span></td>
                    <td width="20%"><input name="txt_usuario_old" type="text" class="boxText" id="txt_usuario_old" size="30" /></td>
                    <td width="12%"><span class="styleContent">Usuario :</span></td>
                    <td width="18%"><input name="txt_usuario_new" type="text" class="boxText" id="txt_usuario_new" size="30" /></td>
                    <td rowspan="2" width="40%" valign="bottom"><label>
                    <input name="btn_actualiza" type="button" class="btnText" id="btn_actualiza" value=":: Actualizar" onclick="miconfig.acceso(this);" />
<!--                      <input name="btn_actualiza" type="button" class="btnText" id="btn_actualiza" value=":: Actualizar" onclick="miconfig.checa(this);" /> -->
                    </label></td>
                  </tr>
                  <tr>
                    <td><span class="styleContent">Password viejo :</span></td>
                    <td><label>
                      <input name="txt_password_old" type="password" class="boxText" id="txt_password_old" size="30" />
                      </label>                    </td>
                    <td><span class="styleContent">Password  Nuevo :</span></td>
                    <td><input name="txt_password_new" type="password" class="boxText" id="txt_password_new" size="30" /></td>
                  </tr>
                </table>                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td class="lineHorizontal"><span class="styleNBLM">&nbsp;.:. Configuracion de lotes</span></td>
          </tr>
          <tr>
            <td class="lineVerticalA lineHorizontal"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" class="lineHorizontal"><span class="styleContent">.:. Actualizar cantidad de minutos para agrupar lotes.</span></td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td width="37%" valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="3">
                  <tr>
                    <td><span class="styleContent">Gateway : </span></td>
                    <td>
                    <select name="cbx_gatewaylote" id="cbx_gatewaylote" class="styleCBX">
                      <option value="false">Seleccione</option>
                      <? 
                $table = array();
                $rs = new ResultSet();
                $qry = "show tables";
                $rs=$con->executeQuery($qry);
                while($rs->next()){
                    $table[]=$rs->get(0);
                } 
                for($i=0;$i<count($table);$i++){
                    if($table[$i]!="tbl_usuario" and $table[$i]!="tbl_configuracion_lote"  and $table[$i]!="tbl_configuracion_ocupacional" and $table[$i]!="tbl_configuracion_ip"){
                        echo "<option value=$table[$i]>$table[$i]</option>";
                    }
                }
                  ?>
                    </select></td>
                  </tr>
                  <tr>
                    <td><span class="styleContent">Minutos : </span></td>
                    <td><input name="txt_minutos_lote" type="text" class="boxText" id="txt_minutos_lote" size="15" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input name="btn_actualiza_lotes" type="button" class="btnText" id="btn_actualiza_lote" onclick="miconfig.lote(this);" value=":: Actualizar" /></td>
                  </tr>
                </table>                </td>
                <td width="63%" valign="top">
                <div id="gridLote">
<!--                <table id="gridLote" width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="tableBorder">-->
                <table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="tableBorder">
                    <tr>
                        <td width="45.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Gateway</span></div></td>
                        <td width="45.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Minutos</span></div></td>
                        <td width="4.5%" class="lineHorizontal lineVerticalD">&nbsp;</td>
                        <td width="4.5%" class="lineHorizontal">&nbsp;</td>
                    </tr>
                  <? 
                  $rs=new ResultSet();
                  $qry="select * from tbl_configuracion_lote order by gateway,cantidad asc";
                  $rs=$con->executeQuery($qry);
                  while($rs->next()){
                  $tempgateway=$rs->get('gateway');
                  $tempcantidad=$rs->get('cantidad');
                  $tempid=$rs->get('idlote');
                   echo "<tr id='lote_$tempid'
                    onmouseover=\"this.style.backgroundColor='#CCFFCC'; this.style.color='#000000'\"
                    onmouseout=\"this.style.backgroundColor='#FFFFFF';this.style.color='#000000'\" 
                    style=\"cursor:default; background-color:#FFFFFF; color='#000000'\"
                     width=100%>";
                  ?>
                    <td class="lineHorizontal lineVerticalD" id='lote_gateway_<?=$tempid;?>'><div align="center"><span id="rowGatewayLote_<?=$tempid;?>" class="gridContent"><?=$tempgateway;?></span></div></td>
                    <td class="lineHorizontal lineVerticalD" id='lote_cantidad_<?=$tempid;?>'><div align="center" ><span id="rowCantidad_<?=$tempid;?>" class="gridContent"><?=$tempcantidad;?></span></div></td>
                    <td class="lineHorizontal lineVerticalD" id='lote_btn1_<?=$tempid;?>'><div align="center"><img src="images/editar.gif" border="0" name="<?=$tempid;?>" style="cursor:pointer" onclick="miconfig.modificarlote(this);" /></div></td>
                    <td class="lineHorizontal" id='lote_btn2_<?=$tempid;?>'><div align="center"><img src="images/eliminar.gif" name="<?=$tempid;?>" border="0" style="cursor:pointer" onclick="miconfig.eliminarlote(this);" /></div></td>
                  </tr>
                  <? }?>
                </table>                
                </div>                </td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
            </table></td>
          </tr> 
        </table>        </td>
        </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2" valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td class="lineHorizontal"><span class="styleNBLM">&nbsp;.:. Actualizar Valor ocupacion.</span></td>
          </tr>
          <tr>
            <td class="lineVerticalA lineHorizontal"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" class="lineHorizontal"><span class="styleContent">.:. Actualizar los variables del calculo del % ocupacional.</span></td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td width="37%" valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="3">
                  <tr>
                    <td width="23%"><span class="styleContent">Fecha inicio : </span></td>
                    <td width="77%">
					<input name="txt_fecha_inicio" type="text" class="boxText" id="txt_fecha_inicio" readonly="readonly"/> 
					<img src="images/calendario.gif" width="16" height="16" id="btn_fecha_inicio" style="cursor:pointer;" /> 
					<script type="text/javascript">
					  Calendar.setup(
				    {
			        inputField  : "txt_fecha_inicio",         // ID of the input field
			        ifFormat    : "%Y-%m-%d",    // the date format
				    button      : "btn_fecha_inicio"       // ID of the button
				    }
				    );
					</script>                    </td>
                  </tr>
                  <tr>
                    <td><span class="styleContent">Fecha final : </span></td>
                    <td>
                    <input name="txt_fecha_final" type="text" class="boxText" id="txt_fecha_final" readonly="readonly" />
                    <img src="images/calendario.gif" width="16" height="16" id="btn_fecha_final" style="cursor:pointer;" />
                    <script type="text/javascript">
                    Calendar.setup(
                    {
                    inputField  : "txt_fecha_final",         // ID of the input field
                    ifFormat    : "%Y-%m-%d",    // the date format
                    button      : "btn_fecha_final"       // ID of the button
                    }
                    );
                    </script>                      </td>
                  </tr>
				  <tr>
                    <td><span class="styleContent">Puerto inicial</span></td>
                    <td><input name="txt_puertoinicio" type="text" id="txt_puertoinicio" size="3" /></td>
                  </tr>
				  <tr>
                    <td><span class="styleContent">Puerto Final</span></td>
                    <td><input name="txt_puertofinal" type="text" id="txt_puertofinal" size="3" /></td>
                  </tr>
				  <tr>
                    <td><span class="styleContent">Gateway : </span></td>
                    <td>
					<select name="cbx_gateway" id="cbx_gateway" class="styleCBX">
                      <option value="false">Seleccione</option>
                      <? 
                $table = array();
			    $rs = new ResultSet();
			    $qry = "show tables";
			    $rs=$con->executeQuery($qry);
			    while($rs->next()){
 			    $table[]=$rs->get(0);
   				 } 
		 		 for($i=0;$i<count($table);$i++){
                  if($table[$i]!="tbl_usuario" and $table[$i]!="tbl_configuracion_lote"  and $table[$i]!="tbl_configuracion_ocupacional" and $table[$i]!="tbl_configuracion_ip"){
		    	  echo "<option value=$table[$i]>$table[$i]</option>";
		  		}
		  		}
		 		 ?>
                    </select></td>
                  </tr>
                  <tr>
                    <td><span class="styleContent">Minutos : </span></td>
                    <td><input name="txt_minutos_ocupacion" type="text" class="boxText" id="txt_minutos_ocupacion" size="15" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input name="btn_actualiza_ocupacion" type="button" class="btnText" id="btn_actualiza_ocupacion" onclick="miconfig.ocupacion(this);" value=":: Actualizar" /></td>
                  </tr>
                </table></td>
                <td width="63%" valign="top">
                <div id="gridOcupacion">
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
                  </tr> 
                  <? 
                  $rs=new ResultSet();
                  $qry="select * from tbl_configuracion_ocupacional order by gateway asc";
                  $rs=$con->executeQuery($qry);
                  while($rs->next()){
                  $tempinicio=$rs->get('fecha_inicio');
                  $tempfinal=$rs->get('fecha_fin');
                  $tempgateway=$rs->get('gateway');
                  $tempMinutos=$rs->get('minutos_disponibles');
                  $tempportinicial=$rs->get('initialPort');
                  $tempportfinal=$rs->get('finalPort');
                  $tempid=$rs->get('idconfiguracion');
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
                  </tr>
                  <? }?>
                </table>                
                </div>                </td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
            </table></td>
          </tr> 
        </table>        </td>
        </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td class="lineHorizontal"><span class="styleNBLM">&nbsp;.:. Configuracion de Ip's</span></td>
          </tr>
          <tr>
            <td class="lineVerticalA lineHorizontal"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" class="lineHorizontal"><span class="styleContent">.:. Actualizar cantidad de ip's.</span></td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td width="37%" valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="3">
                  <tr>
                    <td><span class="styleContent">Gateway : </span></td>
                    <td>
                    <select name="cbx_gatewayip" id="cbx_gatewayip" class="styleCBX">
                      <option value="false">Seleccione</option>
                      <? 
                $table = array();
                $rs = new ResultSet();
                $qry = "show tables";
                $rs=$con->executeQuery($qry);
                while($rs->next()){
                 $table[]=$rs->get(0);
                    } 
                  for($i=0;$i<count($table);$i++){
                  if($table[$i]!="tbl_usuario" and $table[$i]!="tbl_configuracion_lote"  and $table[$i]!="tbl_configuracion_ocupacional" and $table[$i]!="tbl_configuracion_ip"){
                  echo "<option value=$table[$i]>$table[$i]</option>";
                  }
                  }
                  ?>
                    </select></td>
                  </tr>
                  <tr>
                    <td><span class="styleContent">Ip's : </span></td>
                    <td><input name="txt_ip" type="text" class="boxText" id="txt_ip" size="15" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input name="btn_actualiza_ip" type="button" class="btnText" id="btn_actualiza_ip" onclick="miconfig.ip(this);" value=":: Actualizar" /></td>
                  </tr>
                </table>                </td>
                <td width="63%" valign="top">
                <div id="gridIp">
                <table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="tableBorder">
                    <tr>
                    <td width="45.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">Gateway</span></div></td>
                    <td width="45.5%" class="lineHorizontal lineVerticalD"><div align="center"><span class="styleNBLM">IP</span></div></td>
                    <td width="4.5%" class="lineHorizontal lineVerticalD">&nbsp;</td>
                    <td width="4.5%" class="lineHorizontal">&nbsp;</td>
                  </tr> 
                  <? 
                  $rs=new ResultSet();
                  $qry="select * from tbl_configuracion_ip order by gateway,ip asc";
                  $rs=$con->executeQuery($qry);
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
                  <? }?>
                </table>                
                </div>                </td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
            </table></td>
          </tr> 
        </table>        </td>
        </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td class="lineHorizontal"><span class="styleNBLM">.:. Exportar informacion a excel</span></td>
          </tr>
          <tr>
            <td class="lineVerticalA">&nbsp;</td>
          </tr>
          <tr>
            <td class="lineVerticalA"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td><span class="styleContent">.:. Selecciona el gateway y la fecha la cual desea exportar. </span></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="lineHorizontal"><span class="styleContent">Gateway</span> 
                  <select id="cbx_exp_gateway" name="cbx_exp_gateway" class="styleCBX">
				   <option value="false">Seleccione</option>
                      <? 
                $table = array();
			    $rs = new ResultSet();
			    $qry = "show tables";
			    $rs=$con->executeQuery($qry);
			    while($rs->next()){
 			    $table[]=$rs->get(0);
   				 } 
		 		 for($i=0;$i<count($table);$i++){
                  if($table[$i]!="tbl_usuario" and $table[$i]!="tbl_configuracion_lote"  and $table[$i]!="tbl_configuracion_ocupacional" and $table[$i]!="tbl_configuracion_ip"){
		    	  echo "<option value=$table[$i]>$table[$i]</option>";
		  		}
		  		}
		 		 ?>
                  </select>
                   |&nbsp;&nbsp;<span class="styleContent">Fecha inicio 
                   <input name="txt_inicio" type="text" id="txt_inicio" size="10" />
                   <img src="images/calendario.gif" width="16" height="16" id="btn_exp_inicial" /> 
				   <script type="text/javascript">
					  Calendar.setup(
				    {
			        inputField  : "txt_inicio",         // ID of the input field
			        ifFormat    : "%Y-%m-%d",    // the date format
				    button      : "btn_exp_inicial"       // ID of the button
				    }
				    );
					</script>   
				   </span>|&nbsp;&nbsp;<span class="styleContent">Fecha fin    
                   &nbsp;
                   <input name="txt_final" type="text" id="txt_final" size="10" />
                   <img src="images/calendario.gif" width="16" height="16" id="btn_exp_final" /> 
				      <script type="text/javascript">
					  Calendar.setup(
				    {
			        inputField  : "txt_final",         // ID of the input field
			        ifFormat    : "%Y-%m-%d",    // the date format
				    button      : "btn_exp_final"       // ID of the button
				    }
				    );
					</script> 
				   </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   <input name="btn_export" type="button" class="btnText" value="Exportar" onclick="miconfig.exportAjax(this);" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div id="div_espera"><!--&nbsp;<img src="images/load_1.gif" /><span class="styleNBG"> Generando Archivo...</span>--></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td class="lineVerticalA lineHorizontal">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</form>
<!-- fin del contenido -->
<!-- incluyo la el pie -->
<? include("pie.php");?>
