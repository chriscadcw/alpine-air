<?php
/**
 * Class for the Role model
 */
namespace App\Models;

use App\Lib\Database;
class Role {

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $role_name;
    /**
     * Holds the database instance for this model
     * @var Database
     */
    private $db;

    /**
     * Public constructor that can set the name of the role
     * @param string $role_name
     */
    public function __construct(string $role_name = ""){
        $this->role_name = $role_name;
        $this->db = new Database;
    }

    /**
     * Gets the id of the role
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Gets the name of the role
     * @return string
     */
    public function getRoleName(): string {
        return $this->role_name;
    }

    /**
     * Sets the name of the role
     * @param string
     */
    public function setRoleName(string $role_name){
        $this->role_name = $role_name;
    }

    /**
     * Loads a role with the given id
     * @param int $id
     */
    public function load(int $id){
        $this->db->query("SELECT id, role_name FROM roles WHERE id = :id");
        $this->db->bind(':id', $id);
        if($result = $this->db->execute() === true){
            $this->id = $result->id;
            $this->role_name = $result->role_name;
        }
    }

    /**
     * Loads the current role based on the role name
     * @param string $role_name
     * @return void
     */
    public function loadByName(string $role_name){
        $this->db->query("SELECT id, role_name FROM roles WHERE role_name = :role_name");
        $this->db->bind(':role_name', $role_name);
        $result = $this->db->single();
        $this->id = $result->id;
        $this->role_name = $result->role_name;
    }

    /**
     * Saves the current role data to the database
     * @return bool
     */
    public function save(){
        if( is_null($this->id) ){
            $this->db->query("INSERT INTO roles (role_name) VALUES (:role_name)");
        } else {
            $this->db->query("UPDATE roles set role_name = :role_name WHERE id = :id");
            $this->bind(':id', $this->id);
        }
        $this->db->bind(':role_name', $this->role_name);
        if($this->db->execute()){
            if(is_null($this->id)){
                $this->db->query("SELECT LAST_INSERT_ID()");
                $this->id = $this->db->execute();
            }
            return true;
        } else {
            return false;
        }
    }

}
