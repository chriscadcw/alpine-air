<?php
/**
 * User controller for interactions pertaining to users
 */
namespace App\Controllers;

use App\Lib\Controller;
use App\Models\User;
use App\Models\Role;
 class Users extends Controller {

    /**
     * Holds the current user object
     * @var User
     */
    protected $user;

    
    public function __construct() {        
        if(isset($_SESSION['user_id'])){
            $this->user = new User;
            $this->user->load($_SESSION['user_id']);
        }
    }

    /**
     * Returns the user home page view
     */
    public function home(){        
        if(!isset($_SESSION['user_id'])){            
            header('Location: '.URLROOT .'/auth/login');
            die();
        }
        $messages = $this->getMessages();
        $this->view('user/home', ['user' => $this->user, 'messages' => $messages]);
    }

    /**
     * Returns the user profile view
     */
    public function profile(){        
        $messages = $this->getMessages();
        $this->view('user/profile', ['user' => $this->user, 'messages' => $messages]);
    }

    /**
     * Method that allows for updating user profile data
     * 
     * The try/catch blocks belows should be replaced by a standard error handler given time
     * @method POST
     */
    public function profileUpdate(){
        $changed = false;
        if( $this->user->getFirstName() !== $_POST['first_name']){
            $this->user->setFirstName($_POST['first_name']);
            $changed = true;
        }
        if( $this->user->getLastName() !== $_POST['last_name']){
            $this->user->setLastName($_POST['last_name']);
            $changed = true;
        }
        if( $this->user->getEmailAddress() !== $_POST['email_address']){
            $this->user->setEmailAddress($_POST['email_address']);
            $changed = true;
        }
        if( !empty($_POST['password']) ){
            $this->user->setPassword($_POST['password']);
        }
        if($changed){
            if($this->user->save()) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * This section should contain additional confirmation before simply resetting the password
         * I am going to to attempt to also add client side validation
         */
        if( !empty($_POST['new_password']) && !empty($_POST['old_password']) ){
            if( User::checkLogin($this->user->getEmailAddress(), $_POST['old_password'])){
                User::updatePassword($this->user->getId(), $_POST['new_password']);
            }
        }
    }

    /**
     * If the user is a "Super Admin" returns a list of the current users in the system
     * If the user is not a "Super Admin", redirects to the home page
     */
    public function list(){
        $role = new Role;
        $role->loadByName('Super Admin');
        if( $this->user->getRoleId() !== $role->getId()){
            header('Location: ' . URLROOT . '/users/home');
            die();
        }
        $this->view('user/list', ['user' => $this->user, 'users' => $this->user->getUsers()]);
    }
 }
