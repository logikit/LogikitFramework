<?php

/**
 * Logikit::Framework
 *
 * Open source development framework for PHP 5
 *
 * @package		Logikit Framework
 * @author		Can Ince
 * @copyright	        Copyright (c) 2009, Logikit / Can Ince.
 * @license		http://www.opensource.org/licenses/mit-license.php

 * @link		http://framework.logikit.net
 */

// ------------------------------------------------------------------------

/**
 * Main Model Class
 *
 * @package		Logikit Framework
 * @subpackage	        Core
 * @category	        Core
 * @author		Can Ince
 */

// ------------------------------------------------------------------------
abstract class LogikitModel extends PDO
{

	/**
	* Constructor
	*
	* initialize the data source object
	*
	*/

	private $_select = array() , $_where = array() , $_limit = array() , $_join = array() , $_orderBy = array(); 

	public function __construct()
	{
	    if (!$settings = parse_ini_file(APPLICATIONPATH . 'config/database.ini' , TRUE)) throw new exception('Unable to open ' . $file . '.');
	   
	    $dsn = $settings[DB_ENVIRONMENT]['driver'] .
	    ':host=' . $settings[DB_ENVIRONMENT]['host'] .
	    ((!empty($settings[DB_ENVIRONMENT]['port'])) ? (';port=' . $settings[DB_ENVIRONMENT]['port']) : '') .
	    ';dbname=' . $settings[DB_ENVIRONMENT]['schema'];
	   
	    parent::__construct($dsn , $settings[DB_ENVIRONMENT]['username'] , $settings[DB_ENVIRONMENT]['password']);
	}

	/**
	* Prepare a query
	*
	* @access	public
	* @param        mixed  (args)
	* @return	mixed
	*/
    
	public function prepare()
	{
		$args = func_get_args();
		$rawSql = array_shift($args);
		if(get_magic_quotes_gpc()) $args = array_map('stripslashes' , $args);
		$args = array_map('mysql_escape_string' , $args);
		$sql = vsprintf($rawSql , $args);
		return $sql;
	}
	
	/**
	* Return list of tables
	*
	* @access	public
	* @return	array
	*/
	
	public function tables()
	{
		static $tables = array();
		if(!count($tables))
		{
			foreach($this->query('SHOW TABLES') as $row )
			{
				$tables[] = $row[0];
			}
		}
		return $tables;
	}
	
	/**
	* Check if table exists
	*
	* @access	public
	* @param        string  tableName
	* @return	mixed
	*/
	
	public function tableExists($tableName)
	{
		return in_array($tableName , $this->tables());
	}

	/**
	* Get table name from class name
	*
	* @access	public
	* @param        string  className
	* @return	string
	*/
	
	public function getTableName($className)
	{
		$className = str_replace('Model' , '' , $className);
		return strtolower($className);
	}
	
	/**
	* Return list of columns
	*
	* @access	public
	* @param        string  tableName
	* @return	array
	*/
	
	public function columns($tableName)
	{
		$tableName = strtolower($tableName);
	
		$arrFields = array();
		foreach($this->query("SHOW COLUMNS FROM $tableName") as $col)
		{
			$arrFields[$col['Field']] = $col;
		}
	
		return $arrFields;
	}
	
	/**
	* Return type of a table field
	*
	* @access	public
	* @param        string  tableName
	* @param        string  fieldName
	* @return	string
	*/
	
	public function getType($tableName , $fieldName)
	{
		$fields = $this->columns($tableName);
		if( isset($fields[$fieldName]['Type']) )
		{
		$type_len = explode( '(', $fields[$fieldName]['Type'] );
		$type = $type_len[0];
		return $type;
		}
		else
		{
			return false;
		}
	}

	/**
	* Return length of a table field
	*
	* @access	public
	* @param        string  tableName
	* @param        string  fieldName
	* @return	integer
	*/
		
	public function getLen($tableName , $fieldName)
	{
		$fields=$this->columns($tableName);
		if( isset($fields[$fieldName]['Type']) )
		{
		$type_len = explode( '(', $fields[$fieldName]['Type'] );
		$length = array_key_exists(1, $type_len) ? str_replace(')', '', $type_len[1]) : false;
		return $length;
		}
		else
		{
			return false;
		}
	}
	
	/**
	* Escape a string
	*
	* @access	public
	* @param        string  value
	* @return	string
	*/
	
	public function escape($value)
	{
		$val = trim( $value );		
		if ( get_magic_quotes_gpc() )
		{
			$val = stripslashes($val);
		}
		return("'".mysql_escape_string($val)."'");
	}
	
	/**
	* Populate a dataset
	*
	* @access	public
	* @param        object  modelobject
	* @param        array  	values
	* @return	object
	*/
	
	public function create($modelObj , $values = NULL)
	{
		$obj = new $modelObj();
		foreach($this->columns($modelObj) as $key=>$field)
		{
			$obj->$key = $field['Default'];
		}
		$obj->populate($values);		
		return $obj;
	}
	
	/**
	* Count the rows for a result set
	*
	* @access	public
	* @param        string  $where
	* @return	integer
	*/
	
	public function count($where = '')
	{
		$table = $this->getTableName(get_class($this));
		$sqlString = "SELECT count(id) AS count FROM $table ";
		if($where != '') $sqlString .= "WHERE $where";
		$result = $this->getRow($sqlString);
		return $result['count'];
	}
	
	/**
	* Return the result set for a query string
	*
	* @access	public
	* @param        string  sqlString
	* @return	array
	*/
	
	public function result($sqlString)
	{
		$result = array();
		
		foreach($this->query($sqlString) as $values)
		{
			$result[] = $values;
		}
		
		return $result;
	}
	
	/**
	* Return the result set for a pre-formatted query
	*
	* @access	public
	* @param        string  where
	* @param        string  orderBy
	* @param	integer	start
	* @param	integer	limit
	* @return	array
	*/
	
	public function fetchAll($where = NULL , $orderBy = 'id ASC' , $limit = 9999999 , $start = 0)
	{
		$table = $this->getTableName(get_class($this));
	
		$sqlString = "SELECT * FROM $table";
		if($where)
		{
			
			if(is_array($where))
			{
				$conditions = array();
				foreach($where as $key=>$val)
				{
					$val = addslashes($val);
					$conditions[] = "$key='$val'";
				}
				$where = implode(' AND ', $conditions);
			}

			$sqlString .= ' WHERE ' . $where;
		}
		$sqlString .= " ORDER BY $orderBy ";
		$sqlString .= "LIMIT $start,$limit";
		return $this->result($sqlString);
	}
	
	/**
	* Return the first row of a result set for a pre-formatted query
	*
	* @access	public
	* @param        string  where
	* @param        string  orderBy
	* @return	array
	*/
	
	public function getRow($query)
	{
		foreach($this->query($query . "LIMIT 1") as $row)
		return $row;
	}
	
	/**
	* Get a record by id
	*
	* @access	public
	* @param        integer  id
	* @return	array
	*/
	
	public function getById($id)
	{
		$table = $this->getTableName(get_class($this));
		$query = "SELECT * FROM $table WHERE id = '$id'";
		return $this->getRow($query);
	}

	/**
	* Run "BEGIN" query
	*
	* @access	public
	* @return	boolean
	*/

	public function begin()
	{
		$this->query('BEGIN');
		
		return true;
	}
	
	/**
	* Run "ROLLBACK" query
	*
	* @access	public
	* @return	boolean
	*/
	
	public function rollBack()
	{
		$this->query('ROLLBACK');
		
		return true;
	}

	/**
	* Run "COMMIT" query
	*
	* @access	public
	* @return	boolean
	*/
	
	public function commit()
	{
		$this->query('COMMIT');
		
		return true;
	}

	/**
	* Save 
	*
	* @access	public
	* @return	integer
	*/
	
	public function save()
	{
		$table = $this->getTableName(get_class($this));
		
		$fields = $this->columns($table);
		
		foreach ( $fields as $key => $field )
		{
			if($key != 'id')
			{
				$val = $this->escape(isset($this->$key) ? $this->$key : NULL);
				$vals[] = $val;
				$keys[] = "`" . $key . "`";
				$set[] = "`$key` = $val";
			}
		}
		
		$table = strtolower($table);
		
		// insert or update ?
		if( isset($this->id) )
		{
			$sql = "UPDATE `$table` SET " . implode($set , ", ")." WHERE id={$this->id}";
		}
		else
		{
			$sql = "INSERT INTO `$table` (" . implode($keys , ", ") . ") VALUES (" . implode($vals , ", ") . ")";
		}
	
		$success = $this->query($sql);
		if(!isset($this->id))
		{
			$this->id = $this->lastinsertId();
		}
		return $success;
		
	}

	/**
	* Populate dataset field values 
	*
	* @access	public
	* @param	array	values
	* @return	boolean
	*/
	
	public function populate($values)
	{
		if( is_array($values) )
		{
			foreach($values as $key => $val)
			{
				$this->$key = $val;
			}
			return true;
		}
		else
		{
			return false;
		}
	}
		
	/**
	* Delete a preset row from table
	*
	* @access	public
	* @return	boolean
	*/
	
	public function delete($id)
	{
		$table = $this->getTableName(get_class($this));
		return $this->query("DELETE FROM $table WHERE id ='$id'");
	}
	
	/**
	* Return an Sql formatted date using a timestamp
	*
	* @access	public
	* @param	timestamp	timestamp
	* @return	string
	*/
	
	public function dbDate($intTimeStamp = NULL)
	{
		return date('Y-m-d', ($intTimeStamp != NULL) ? $intTimestamp : time());
	}

	/**
	* Return an Sql formatted date using a european/american date format
	*
	* @access	public
	* @param	timestamp	timestamp
	* @return	string
	*/
	
	public function convertDate($date , $tokenizer = '/' , $format = 'eu')
	{
		$dateArray = explode($tokenizer , $date);
		if($format == 'eu')
		{
			$sqlDate = $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];
		}
		elseif($format == 'us')
		{
			$sqlDate = $dateArray[1] . '-' . $dateArray[2] . '-' . $dateArray[0];
		}
		
		return $sqlDate;
	}

	/**
	* Return a european formatted date using an SQL date format
	*
	* @access	public
	* @param	timestamp	timestamp
	* @return	string
	*/	
	public function convertToEuropeanDate($date)
	{
		$dateArray = explode('-' , $date);
		
		$sqlDate = $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];

		return $sqlDate;		
	}
	
	/**
	* Return an american formatted date using an SQL date format
	*
	* @access	public
	* @param	timestamp	timestamp
	* @return	string
	*/	
	public function convertToAmericanDate($date)
	{
		$dateArray = explode('-' , $date);
		
		$sqlDate = $dateArray[1] . '-' . $dateArray[2] . '-' . $dateArray[0];

		return $sqlDate;		
	}
	
	/**
	* Return an Sql formatted datetime
	*
	* @access	public
	* @param	timestamp	timestamp
	* @return	string
	*/
	
	public function dbDateTime($intTimeStamp = NULL)
	{
		return date('Y-m-d H:i:s' , $intTimeStamp ? $intTimeStamp : time());
	}

}

/* End of file LogikitModel.php 
   Location: ./system/model/LogikitModel.php */