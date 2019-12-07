<?php
include('adodb/adodb.inc.php');
class FetchUtil {
    /* This class is everything a smarty using php project needs
     */
    var $row;
    var $DB_type;
    var $DB; 
    function FetchUtil($dsn){
        $this->DB = NewADOConnection($dsn);
        //$this->DB = ADONewConnection($dsn);
        if ( !$this->DB ) die("Coneccion fallida - $dsn");
        $this->DB->SetFetchMode(ADODB_FETCH_ASSOC);
    }
    function Execute($query){
        $this->row  = $this->DB->Execute($query) or die ($this->DB->errormsg());
    }
    
    function ReConnect($host,$user,$pass,$database){
        $this->DB->PConnect($host,$user,$pass,$database);
    }

    function Close(){
        $this->DB->Close();
    }
    
    function FetchAll($query){
        /* It returns 1 dimension bigger arrays for 1 row, but 
         * helps lowering the methods in this class
         */
        $rs = Array();
        $this->Execute($query);
        while(!$this->row->EOF){
            $temp[] = $this->row->fields;
            $this->row->MoveNext();
        } 
        return $temp; 
    }
}
/*
<?php
class FetchUtil {
    var $row;
    var $DB_type;
    function FetchUtil (&$id){
        $this->row = $id;
    }
    function FetchRow(){
        if (!$this->row->EOF){
            $temp = $this->row->fields;
            $this->row->MoveNext();
            return $temp;
        } else {
            return false;
        }
    }
    function FetchAll(){
        $rs = $this->FetchRow();
        while ($rs){
            $rows[] = $this->FetchRow();
            $rs = $this->FetchRow();
        }
        return $rows; 
    }
}
function FetchAll($query){
    global $db;
    $sql = $db->execute($query) or die ($db->errormsg);
    $rs = new FetchUtil($sql);
    $rows = $rs->FetchAll();
    return $rows;
}
function FetchOne($query){
    global $db;
    $sql = $db->execute($query) or die ($db->errormsg);
    $rs = new FetchUtil($sql);
    $rows = $rs->FetchRow();
    return $rows;
}
*/