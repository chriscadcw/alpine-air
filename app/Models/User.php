<?php
/**
 * Class for the user object that will store and retrieve data from the database
 * 
 * @attr 
 */
namespace App\Models;

use App\Lib\Database;
use PDOException;
use phpDocumentor\Reflection\Types\Object_;

class User {
    
    /**
     * @param int
     */
    private $id;
    /**
     * @param string
     */
    private $first_name;
    /**
     * @param string
     */
    private $last_name;
    /**
     * @param string
     */
    private $email_address;
    /**
     * @param int
     */
    private $role_id;
    /**
     * This stores the password during updates and registration, and then is wiped, it is never loaded from the database
     * @param string
     */
    private $password;
    /**
     * @param Database
     */
    private $db;

    /**
     * Public constructor, parameters can be passed to set up the new object at instantiation
     * 
     * @param string $first_name
     * @param string $last_name
     * @param string $email_address
     */
    public function __construct(string $first_name = '', string $last_name = '', string $email_address = ''){
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email_address = $email_address;

        $this->db = new Database;
    }

    /**
     * Returns user id
     * @return int
     */     
    public function getId(): int{
        return $this->id;
    }

    /**
     * Returns user first name
     * @return string
     */
    public function getFirstName(): string{
        return $this->first_name;
    }

    /**
     * Returns user last name
     * @return string
     */
    public function getLastName(): string{
        return $this->last_name;
    }

    /**
     * Returns user email address
     * @return string
     */
    public function getEmailAddress(): string{
        return $this->email_address;
    }

    /**
     * Returns the user's role id
     * @return int
     */
    public function getRoleId(): int{
        return $this->role_id;
    }

    /**
     * Sets user first name
     * @param string $first_name
     */
    public function setFirstName(string $first_name){
        $this->first_name = $first_name;
    }
    
    /**
     * Sets user last name
     * @param string $last_name
     */
    public function setLastName(string $last_name){
        $this->last_name = $last_name;
    }

    /**
     * Sets user email address
     * @param string $email_address
     */
    public function setEmailAddress(string $email_address){
        $this->email_address = $email_address;
    }

    /**
     * Sets the user's role_id
     * @param int $role_id
     */
    public function setRoleId(int $role_id){
        $this->role_id = $role_id;
    }

    /**
     * Sets the user password
     * @param string $password
     */
    public function setPassword(string $password){
        $this->password = $password;
    }



    /**
     * Attempts to save the current user to the database.  
     * If the user object does not have an `id` attached (ie. registration)
     *  it will then insert the user into the database and set the id
     * 
     * This is not the best approach to handling the database queries for updating user information, 
     * the query should use more of a "builder" approach to allow for more dynamic updating of included fields.
     * 
     * @throws PDOException
     * 
     * @return boolean
     */
    public function save(): bool{
        if (is_null($this->id)) {
            $this->id = $this->insertUser();
        } else {
            $this->updateUser();
        }

        if ($this->password !== null) {
            $this->updatePassword();
        }
        return true;
    }

     /**
      * Updates the password for the current user
      *
      * Given more time, the entire insert/update query should be written as a dynamic builder instead of static queries
      * @return boolean
      */
     public function updatePassword(): bool
     {
         $this->db->query("UPDATE users SET password = :password WHERE id = :id");
         $this->db->bind(':password', password_hash($this->password, PASSWORD_DEFAULT));
         $this->db->bind(':id', $this->id);
         if($this->db->execute()){
             return true;
         } else {
             return false;
         }
     }

    /**
     * Gets the current user from the database based on the ID supplied
     * @param int $id     
     * 
     * NOTE: Would like to add throwable exceptions here if the user isn't found, but will simply display the error for now.    
     * @throws PDOException
     * 
     * @return User|null
     */
    public function load($id){
        $result = $this->fetchOne($id);
        if( $result ){
            $this->id = $id;
            $this->first_name = $result->first_name;
            $this->last_name = $result->last_name;
            $this->email_address = $result->email_address;
            $this->role_id = $result->role_id;
            return $this;                
        } else {
            return null;
        }        
    }

    /**
     * Returns a list of users and their information
     * @throws PDOException
     * @return Object list [{id, first_name, last_name, email_address}]
     */
    public function getUsers(){
        $results = $this->fetchAll();
        return $results ?? null;        
    }

     /**
      * Returns a single user from the database
      * @param int $id
      * @return object
      */
     private function fetchOne(int $id): object {
         $this->db->query("SELECT first_name, last_name, email_address, role_id FROM users WHERE id = :id");
         $this->db->bind(':id', $id);

         return $this->db->single();
     }

    /**
     * Returns all users in the database
     * @return array
     */
    private function fetchAll(): array {
        $db = new Database;
        $db->query("SELECT id, first_name, last_name, email_address, role_id FROM users");

        return $db->resultSet();
    }

    /**
     * Inserts a new user record and returns the insert id
     * @return int
     */
    private function insertUser(): int {
        $this->db->query("INSERT INTO users (first_name, last_name, email_address, role_id) 
                                VALUES (:first_name, :last_name, :email_address, :role_id);");
        $this->db->bind(':first_name', $this->first_name);
        $this->db->bind(':last_name', $this->last_name);
        $this->db->bind(':email_address', $this->email_address);
        if(!isset($_POST['role_id'])){
            $role_id = 3;
        } else {
            $role_id = $_POST['role_id'];
        }
        $this->db->bind(':role_id', $role_id);
        $this->db->execute();
        $this->db->query('SELECT LAST_INSERT_ID()');
        $result = $this->db->value();
        return (int)$result["LAST_INSERT_ID()"];
    }

    /**
     * Updates an existing user
     * @return bool
     */
    private function updateUser(): bool {
        $this->db->query("UPDATE users set first_name = :first_name, last_name = :last_name, email_address = :email_address, 
                                role_id = :role_id WHERE id = :id");
        $this->db->bind(':id', $this->id);
        $this->db->bind(':first_name', $this->first_name);
        $this->db->bind(':last_name', $this->last_name);
        $this->db->bind(':email_address', $this->email_address);
        if(!isset($_POST['role_id'])){
            $role_id = 3;
        } else {
            $role_id = $_POST['role_id'];
        }
        $this->db->bind(':role_id', $role_id);
        return($this->db->execute());
    }


    /**
     * Static function to check if the user can be found using an email and password match
     * @param string $email_address
     * @param string $password
     * 
     * @throws PDOException
     * 
     * @return int $id | null
     */
    public static function checkLogin(string $email_address, string $password){
        $db = new Database;
        $db->query("SELECT id FROM users WHERE email_address = :email_address AND password = :password");
        $db->bind(':email_address', $email_address, PDO::PARAM_STR);
        $db->bind(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        
        $result = $db->single();
        if( $result !== null ){
            return $result->id;
        }
        return null;
    }
 }
