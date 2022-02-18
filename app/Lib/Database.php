<?php
namespace App\Lib;
/**
 * A bare bones php interface to use PDO to connect to the database and perform queries
 */
use PDO;
use PDOException;
class Database {

    // Database connection settings pulled from app/config.php
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh; // Database Handler
    private $stmt; // Prepared statment holder
    private $error; // Any error messages returned from the database

    // Attempts to make a connection to the database when an instance is created if one does not already exist
    public function __construct(){
        // Setup the DNS
        $dsn = "mysql:host=".$this->host.";dbname=".$this->dbname;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            // Attempt to set up our database handler, if this fails it will throw a PDOException that will
            // be caught by the catch block
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e){
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    // Prepares a query to be sent to the database
    public function query($sql){
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Binds values for the query
    public function bind($param, $value, $type = null){
        if( is_null($type) ){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;                  
                }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the query within the database
    public function execute(){
        return $this->stmt->execute();        
    }

    // Returns a result set based on the query used
    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Returns a single result based on the query used
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Returns a single value
     * @return int|mixed
     */
    public function value(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Returns a row count of the rows affected by the query used
    public function rowCount(){
        return $this->stmt->rowCount();
    }


}
