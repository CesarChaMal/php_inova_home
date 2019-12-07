<?
include_once("System.php");

class ResultSet
{	
	var $DataSourse;		//Arreglo Origen de datos
	var $CurrentRecord;  //Objeto Registro actual
	var $DataPointer; 		//Puntero del ResultSet	
	
	/**
	 * Inicializo el objeto ResultSet
	 *
	 * @return ResultSet
	 */
	function ResultSet($DataSourse = null)
	{	
		$this->DataSourse = $DataSourse;
		$this->CurrentRecord = null;
		$this->DataPointer = -1;
	}
	
	/**
	 * Muevo el puntero del Resulte a una Posición Indicada
	 *
	 * @param unknown_type $pos
	 * @return unknown
	 */
	function relative($pos)
	{	
		if(!is_null($this->DataSourse))
		{	
			if($pos >= 0 && $pos < $this->RecCount())
				$puntero = $pos;
			else
				return false;			
				
			if(mysql_data_seek($this->DataSourse, $puntero))
				return true;
			else
				return false;
		}
		else 
			return false;
	}
	
	/**
	 * Posiciona el puntero del resultset antes del inicio del objeto
	 *
	 */
	function beforefirst()
	{
		if(!is_null($this->DataSourse))
			$this->DataPointer = -1;					
	}
	
	/**
	 * Mueve el puntero al inicio de ResultSet
	 *
	 */
	function first()
	{	
		$status = false;
		if(!is_null($this->DataSourse))
		{	
			$this->DataPointer = 0;
			if($this->relative($this->DataPointer))
			{	
				$this->getDataRowToArray();
				$status = true;
			}
		}
		
		return $status;
	}
	
	/**
	 * Mueve el puntero a la posición anterior
	 */
	function previous()
	{	
		$status = false;
		if(!is_null($this->DataSourse))
		{	
			$this->DataPointer--;
			if($this->relative($this->DataPointer))
			{	
				$this->getDataRowToArray();
				$status = true;
			}
		}
		
		return $status;
	}
	
	/**
	 * Mueve el puntero a la  posición siguiente
	 *
	 */
	function next()	
	{	
		$status = false;
		if(!is_null($this->DataSourse))
		{	
			$this->DataPointer++;
			if($this->relative($this->DataPointer))			
			{	
				$this->getDataRowToArray();
				$status = true;
			}
		}
		
		return $status;
	}
	
	/**
	 * Mueve el puntero a la última`posición del ResultSet
	 *
	 */
	function last()
	{	
		$status = false;
		if(!is_null($this->DataSourse))
		{	
			$this->DataPointer = $this->RecCount()-1;
			if($this->relative($this->DataPointer))	
			{	
				$this->getDataRowToArray();
				$status = true;
			}
		}
		
		return $status;
	}	
	
	/**
	 * Convierte el objeto ResultSet a una Matriz
	 *
	 * @return unknown
	 */
	function QueryToArray()
	{	
		$table = array();
		if(!is_null($this->DataSourse) && $this->RecCount() > 0)
		{	
			$CurrentPointer = $this->DataPointer;
			$this->first();			
			do 
			{	
				$registro = $this->getRow();
				$pos = sizeof($table);
				
				foreach ($registro as $column => $value)
					$table[$pos][$column] = $value;				
			}
			while ($this->next());
			
			$this->DataPointer = $CurrentPointer;			
		}
		return $table;
	}
	
	/**
	 * Devuelvo un arreglo con todos los registro de la columna indicada en la tabla
	 *
	 * @param unknown_type $column
	 * @param unknown_type $type_order
	 * @param unknown_type $isfilter
	 * @return unknown
	 */
	function ColumnToArray($column,$type_order = null,$isfilter = false)
	{	
		$temptable = array();
		$table = array();		
						
		if(!is_null($this->DataSourse) && $this->RecCount() > 0)
		{	
			$CurrentPointer = $this->DataPointer;			
			$this->first();				
			do 
			{	
				$registro = $this->getRow();
				$temptable[sizeof($temptable)] = strtolower($registro[$column]);				
			}
			while ($this->next());
			
			$this->DataPointer = $CurrentPointer;
			
			//Ordenar la lista
			switch($type_order) 
			{	
				case SORT_ASC:
					sort($temptable);
					reset($temptable);
					break;
				case SORT_DESC:
					rsort($temptable);
					reset($temptable);
					break;
				default:
					break;
			}
			
			//Filtrar la lista			
			if($isfilter)
			{	
				$temptable = array_unique($temptable);
				
				$i = 0;
				foreach($temptable as $value)								
				{	
					$table[$i] = $value;
					$i++;
				}
			}	
			else 
				$table = $temptable;			
		}
				
		return $table;
	}	
		
	/**
	 * Devuelve la fila siguiente en objeto
	 *
	 * @return unknown
	 */
	function getRow()
	{
		if(!is_null($this->DataSourse))
		{	
			if(is_null($this->CurrentRecord))
				$this->next();		
		
			return $this->CurrentRecord;	
		}
		return NULL;
	}	
	
	/**
	 * Regreso el valor de una columna 
	 *
	 * @param unknown_type $col
	 */
	function get($col)
	{
		$record = null;
		if(!is_null($this->DataSourse))
		{	
			if(is_null($this->CurrentRecord))
				$this->next();
				
			$record = $this->CurrentRecord[$col];
		}
		return $record;		
	}
	
	/**
	 * Devuelve el número total filas de la consulta hecha
	 *
	 * @return unknown
	 */
	function RecCount()
	{
		if(!is_null($this->DataSourse))
			return mysql_num_rows($this->DataSourse); 		
	}	
	
	/**
	 * Devuleve un arreglo con el nombre de todos los campos de la cosulta
	 *
	 */
	function GetListNameFields()
	{
		$names = array();
		$this->numcols = mysql_num_fields($this->DataSourse); 		
		for($i = 0; $i < $this->numcols; $i++)
			$names[$i] = mysql_field_name($this->DataSourse, $i);
			
		return $names;
	}
	
	/**
	 * Devuleve el numero de columnas de la fila actual
	 *
	 */
	function ColsCount()
	{
		if(!is_null($this->DataSourse))
			return mysql_num_fields($this->DataSourse); 		
	}
	
	/**
	 * Obtiene los datos de la fila Actual en Objeto y arreglo
	 *
	 */
	function getDataRowToArray()
	{	
		$this->CurrentRecord = mysql_fetch_array($this->DataSourse,MYSQL_BOTH);		
	}
	
	/**
	 * Determina si el Datasourse del ResultSet es nulo
	 *
	 * @return unknown
	 */
	function isNull()
	{	
		return is_null($this->DataSourse);
	}
	
	/**
	 * Imprime el objeto ResultSet
	 *
	 */
	function PrintResult()
	{
		$Names = $this->GetListNameFields();
		?>
		<table border="0" cellpadding="3" cellspacing="1">
       	<tr>
        <?
        foreach ($Names as $name) 
        {
        	?>
			<td bgcolor="#999999" align="center" style="color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold">
			<?
			Application::Write($name);                  	                        
			?>			
			</td>
			<?
        }        	       	                                	
        ?>
        </tr>
                
        <?
        $NumFila = 0;
        $Color = "";        
        $this->beforefirst();
        while ($this->next()) 
        {	
			$Color = $NumFila % 2 != 0 ? "#CCCCCC" : "#F4F4F4";
        	?>
			<tr>
			<?
            foreach ($Names as $name) 
            {	
				?>
				<td bgcolor="<? Application::Write($Color);?>" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px">
				<?
				Application::Write($this->get($name));
				?>				
				</td>
				<?
			}			
			?>
			</tr>
			<?       
			$NumFila++; 	                   
		}			
        ?>                      
        </table>	
	  	<?
	}
}//Fin clase
?>