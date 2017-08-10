<?php

/*
	obejct relation mapping class for mysql
*/
  
  namespace mySQLORM;

  use Kernel\App\Core\Config;

	class Orm

	{

		private $host,$dbname,$user,$password,$db,$QUERY,$error,$lastInsertId;

		public function __construct()

		{

			/*

				simple orm class for saving time in sql queries

				

				database connections initialization



				its a test version developed by IgN!TiOn a open source developer



				contact sudeep.ignition@gmail.com for any query

			*/

		$ConfigOBJ = new Config();
  		$config = $ConfigOBJ->get();

		try 
          {
          	$this->host = $config->mySql->host;

			$this->dbname = $config->mySql->database;

			$this->user = $config->mySql->username;

			$this->password = $config->mySql->password;
            $this->db = new \PDO("mysql:host=".$this->host.";dbname=".$this->dbname,$this->user,$this->password) or die('Could not connect to database');
          }
          catch(Exception $e)
          {
            if($config->mySql->log)
            {
              file_put_contents(ROOT_DIR.'/logs/mySQL.log', $e->getMessage(). PHP_EOL, FILE_APPEND);
            }
          }

			$this->query = "";
		}



		public function start_transaction()

		{

			// start the transaction processing system



			$this->query .= "start transaction;SET autocommit=0;";

			return $this;

		}



		public function dropTable($data)

		{

			// drop table



			$this->query .= "DROP TABLE ".$data;

			return $this;

		}



		public function dropDB($data)

		{

			// drop database 



			$this->query .= "DROP database ".$data;

			return $this;

		}



		public function createDB($data)

		{

			// create database



			$this->query .= "CREATE database ".$data;

			return $this;

		}



		public function createTable($data)

		{

			// create table



			$this->query .= "CREATE table ".$data;

			return $this;

		}



		public function alterTable($data)

		{

			// alter table



			$this->query .= "alter table ".$data;

			return $this;

		}



		public function alterColumn($data)

		{

			// alter column



			$this->query .= "alter column ".$data;

			return $this;

		} 



		public function add($data)

		{

			// add query in sql for adding contrainst, key etc



			$this->query .= "add ".$data;

			return $this;

		}



		public function references($data)

		{

			// references query



			$this->query .= "REFERENCES ".$data;

			return $this;

		}



		public function orderBy($column,$orderBY)

		{

			//order by



			$this->query .= "ORDER BY ".$column." ".$orderBY;

			return $this;

		}



		public function groupBy($data)

		{

			// group by



			$this->query .= "group by (".$data.")";

			return $this;

		}



		public function save_point($id)

		{

			// save points



			$this->query .= "savepoint ".$id.";";

		}



		public function rollback($id)

		{

			//rollback



			if(isset($id) && !empty($id))

			{

				$this->query .= "rollback to savepoint ".$id.";release savepoint ".$id;

			}

			else

			{

				$this->query .= "rollback";

			}



			return $this;

		}



		public function select($data)

		{

			// select query



			$this->query .= "SELECT ". $data;

			return $this;

		}



		public function from($data)

		{	

			// from table



			$this->query .= " FROM ".$data;

			return $this;

		}



		public function where($data)

		{

			// where clause for matching data to columns



			$this->query .= " WHERE ".$data;

			return $this;

		}



		public function insert($data)

		{

			// insert into table



			$this->query .= " INSERT INTO ".$data;

			return $this;

		}



		public function replace($data)

		{

			$this->query .= " REPLACE INTO ".$data;

			return $this;

		}



		public function column($data)

		{

			// write the columns name 



			$this->query .= '('.$data.')';

			return $this;

		}



		public function values($data)

		{

			// values for insert or replace query



			$this->query .= " VALUES (".$data.")";

			return $this;

		}



		public function delete($data)

		{

			// delete query



			$this->query .= " DELETE FROM ".$data;

			return $this;

		}



		public function update($data)

		{

			// update query



			$this->query .= " UPDATE ".$data;

			return $this;

		}



		public function set($data)

		{

			// set query



			$this->query .= " SET ".$data;

			return $this;

		}



		public function prepare($bind)

		{

			// prepare statements for binding values



			$this->db->beginTransaction();

	        $this->QUERY = $this->db->prepare($this->query);

	        $bindLen = sizeof($bind);

	        for($i=0;$i<$bindLen;$i++)

	        {

	           $j = $i + 1;

	           $this->QUERY->bindParam($j,$bind[$i]);

	        }

	        try

	        {

	         	$this->QUERY->execute();

	         	$this->lastInsertId = $this->db->lastInsertId();

	          	$this->db->commit();

	          	return $this->QUERY;

	        }

	        catch(Exception $e)

	        {

	            $this->db->rollback();

	            return  $e->getMessage();

	        }

		}


	   public static function closeConnection()
      {
        $this->db = null;
      }


		public function query()

      	{

      		// simple query for select



         	$this->db->beginTransaction();

	         try

	         {

	          $this->QUERY = $this->db->query($this->query);

	          $this->db->commit();

	          return $this->QUERY;

	         }

	         catch(Exception $e)

	         {

	            $this->db->rollback();

	            return  $e->getMessage();

	         }

      	}



      	public function exec()

      	{

      		// simple query for insert and update



         	$this->db->beginTransaction();

         	try

         	{

          		$this->QUERY = $this->db->exec($this->query);

          		$this->lastInsertId = $this->db->lastInsertId();

          		$this->db->commit();

          		return $this->QUERY;

         	}

         	catch(Exception $e)

         	{

            	$this->db->rollback();

            	return  $e->getMessage();

         	}

      	}



		public function rowCount()

      	{  

      		// row count

         	return $this->QUERY->rowCount();

      	}



      	public function InsertID()

      	{

      		// last insert id



         	return $this->lastInsertId;

      	}

      	public function fetchObject()

      	{

      		// fetch data as object



         	return $this->QUERY->fetch(PDO::FETCH_OBJ);

      	}

      	public static function errorQuery()

      	{

      		// fetch error in any qyery

      		

         	return $this->error = $this->db->errorInfo();
      	}


        public function __destruct()
        {
        	unset($ConfigOBJ);
        }
	}



?>