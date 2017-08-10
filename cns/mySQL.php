<?php
    

  namespace mySQL;

  use Kernel\App\Core\Config;

  $ConfigOBJ = new Config();
  $config = $ConfigOBJ->get();

  class mySQL
  {

  //class for mysql queries easy to use

  
    private static $db,$query,$lastInsertId,$error;

    public function __construct($host,$dbname,$user,$password,$config)
    {
        /*
            php pdo connection is initiated
        */
        try 
        {
          self::$db = new \PDO("mysql:host=".$host.";dbname=".$dbname,$user,$password);
        }
        catch(Exception $e)
        {

          /*
            If error is thrown then mysql_connect_error.html page is thrown
          */
          echo file_get_contents(ROOT_DIR."/error_files/mysql_connect_error.html");

          if($config->mySql->log)
          {
            file_put_contents(ROOT_DIR.'/logs/mySQL.log', $e->getMessage(). PHP_EOL, FILE_APPEND);
          }
          die();
        }
    }

      public static function prepare($bind,$param)

      {

        /*
          php pdo prepare statement
        */

         self::$db->beginTransaction();

         self::$query = self::$db->prepare($param());

         $bindLen = sizeof($bind);

         for($i=0;$i<$bindLen;$i++)
         {

            $j = $i + 1;

            self::$query->bindParam($j,$bind[$i]);

         }
         try
         {

          self::$query->execute();

          self::$lastInsertId = self::$db->lastInsertId();

          self::$db->commit();

          return self::$query;

         }

         catch(Exception $e)

         {

            self::$db->rollback();

            if($config->sql->log)
            {
              file_put_contents(ROOT_DIR.'/logs/mySQL.log', $e->getMessage(). PHP_EOL, FILE_APPEND);
            }

            return  $e->getMessage();

         }

      }

      public static function query($param)

      {
        // php query statement
         self::$db->beginTransaction();

         try

         {

          self::$query = self::$db->query($param());

          self::$lastInsertId = self::$db->lastInsertId();

          self::$db->commit();

          return self::$query;

         }

         catch(Exception $e)

         {

            self::$db->rollback();
            
            if($config->sql->log)
            {
              file_put_contents(ROOT_DIR.'/logs/mySQL.log', $e->getMessage(). PHP_EOL, FILE_APPEND);
            }

            return  $e->getMessage();

         }

      }

      public static function exec($param)

      {
        // php execute statement
         self::$db->beginTransaction();

         try

         {

          self::$query = self::$db->exec($param());

          self::$lastInsertId = self::$db->lastInsertId();

          self::$db->commit();

          return self::$query;

         }

         catch(Exception $e)

         {

            self::$db->rollback();

            if($config->sql->log)
            {
              file_put_contents(ROOT_DIR.'/logs/mySQL.log', $e->getMessage(). PHP_EOL, FILE_APPEND);
            }

            return  $e->getMessage();

         }

      }

      public static function rowCount()

      {  
        // php method for row count
         return self::$query->rowCount();

      }

      public static function InsertID()

      {
        // php method for getting the last insert id
         return self::$lastInsertId;

      }

      public static function fetchObject()

      {
        // php method to fetch sql data in object form
         return self::$query->fetch(PDO::FETCH_OBJ);
      }

      public static function fetchAll()

      {
        // fetching all the data in object form
        return self::$query->fetchAll(PDO::FETCH_OBJ);
      }

      public static function errorQuery()

      {
        // if any error occurs
         self::$error = self::$db->errorInfo();
      }

      public static function closeConnection()
      {
        self::$db = null;
      }

      public function __destruct()
      {
        unset($ConfigOBJ);
      }

  }

$dbobj = new mySQL($config->mySql->host,$config->mySql->database,$config->mySql->username,$config->mySql->password,$config);

?>