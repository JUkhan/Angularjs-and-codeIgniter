<?php
/**
 * Description of JCrud
 *
 * @author Md. Jasim Khan
 */
class JCrud extends PDO {

    public function  __construct()
    {
        try {
                 parent::__construct('mysql:host='.JCrud::$HOST.';dbname='.JCrud::$DBNAME, JCrud::$USER, JCrud::$PASS);
            } catch (PDOException $e) {
              trigger_error("Connection failed:  <strong>$e->getMessage()</strong> doesn't exist", E_USER_ERROR);
            }
    }   

    public static $HOST;
    public static $USER;
    public static $PASS;
    public static $DBNAME;
   
	public function insert($sql, $params)
    {       
         try
         {        
          $stmt=$this->prepare($sql);

          $stmt->execute($params);
			
          return $this->lastInsertId();
         }catch (Exception $ex)
         {
             throw $ex;
         }
    }
	 public function update($sql, $params)
    {       
         try
         {        
          $stmt=$this->prepare($sql);

          $stmt->execute($params);			
         
         }catch (Exception $ex)
         {
             throw $ex;
         }
    }
    
    public function query1($sql)
    {
        try
        {
            $stmt=$this->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(self::FETCH_OBJ);
        }  catch (Exception $ex)
        {
            throw $ex;
        }
    }
	 public function query2($sql, $params)
    {
        try
        {
            $stmt=$this->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(self::FETCH_OBJ);
        }  catch (Exception $ex)
        {
            throw $ex;
        }
    }
     public function query3($sql, $start, $limit)
    {
        try
        {
			$sql .=" LIMIT $start, $limit";
            $stmt=$this->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(self::FETCH_OBJ);
        }  catch (Exception $ex)
        {

            throw $ex;
        }
    }
	 public function query4($sql, $start, $limit, $params)
    {
        try
        {
			$sql .=" LIMIT $start, $limit";
            $stmt=$this->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(self::FETCH_OBJ);
        }  catch (Exception $ex)
        {

            throw $ex;
        }
    }
	
	public function count1($sql){
	 try
        {
			$stmt=$this->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();	
			
		}  catch (Exception $ex)
        {

            throw $ex;
        }
	}
	public function count2($sql, $params){
	 try
        {
			$stmt=$this->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchColumn();	
			
		}  catch (Exception $ex)
        {

            throw $ex;
        }
	}   
   
}
?>
