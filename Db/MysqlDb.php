<?php
namespace Db;
class MysqlDb extends \Db\BaseMysqlDb
{
	protected static $_mysql;
	protected $_sql;
	public static function Prepare($params)
	{
		parent::getInstance($params);
		self::$_mysql=new self($params);
		return self::$_mysql;
	}

    public function fetch_query($sql)
    {

		$resLink=parent::sqlQuery(self::$_mysql->_db,$sql);
		while($resource=mysqli_fetch_array($resLink,MYSQLI_ASSOC))
        {
            $result[]=$resource;
        }
        if(!empty($result)){
            return $result;
        }else{
            return false;
        }
    }
	
    public function check_param($params)
    {
        foreach ($params as $K=>$V)
            {
                $params[$K]=stripslashes($V);
                if (!is_numeric($V))
                {
                    $params[$K] = mysqli_real_escape_string(self::$_mysql->_db,$V);
                }
        }
        return $params;
    }
    
    public function sql_query($sql)
    {
		return $resLink=parent::sqlQuery(self::$_mysql->_db,$sql);
    }
	
	public function sql_transaction($sqlarr)
	{
		$stat=true;
		mysqli_autocommit(self::$_mysql->_db, FALSE);
		foreach($sqlarr as $v){
			mysqli_query(self::$_mysql->_db,$v) or die(mysqli_error(self::$_mysql->_db)) ? null : $stat=false;
		}
		if ($stat){
			mysqli_commit(self::$_mysql->_db);
			$exstat=1;
		}else{
			mysqli_rollback(self::$_mysql->_db);
			$exstat=0;
		}
		mysqli_autocommit(self::$_mysql->_db, TRUE);
		return $exstat;
	}
	
	public function getRows()
    {
       return parent::sqlQuery($this->_sql);
    }
	
	public function insert()
	{
		return parent::sqlQuery($this->_sql);
	}
	
	public function update()
	{
		return parent::sqlQuery($this->_sql);
	}
	
	public function delete()
	{
		return parent::sqlQuery($this->_sql);
	}
	
}