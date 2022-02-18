<?php
namespace App\Controllers;

use App\Lib\Controller;
use App\Models\User;
use App\Helpers\UserHelper;
use PDOException;

class Auth extends Controller {

    /**
     * @var User
     */
    protected $user;

    public function __construct(){
        if(isset($_SESSION['user_id'])){
            $this->user = new User;
            $this->user->load($_SESSION['user_id']);
        }
    }

    /**
     * Returns the user login view
     */
    public function login(){
        $messages = $this->getMessages();
        if($this->user instanceof User){
            header('Location: ' . URLROOT . '/user/home');
            die();
        }
        $this->view('auth/login', ['messages' => $messages]);
    }

    /**
     * Returns the user registration view
     */
    public function register(){
        $messages = $this->getMessages();
        $this->view('auth/register', ['messages' => $messages]);
    }

    /**
     * Stores the user registration data in the database
     * @throws PDOException
     * @return void
     */
    public function store(): void{
        if(!isset($_POST['first_name'])){
            die('Registration Failed');
        }
        $user = new User;
        $user->setFirstName($_POST['first_name']);
        $user->setLastName($_POST['last_name']);
        $user->setEmailAddress($_POST['email_address']);
        if($user->save()){
            $user->setPassword($_POST['password']);
            if($user->updatePassword()){
                $this->addMessage('User registered', 'success');
                header('Location: ' . URLROOT . '/auth/login');
                die();
            }
        } else {
            $this->addMessage('Unable to register user', 'error');
        }
    }

    /**
     * Checks to see if the user submitted the form correctly and if the user is in the database.
     * Will redirect back to login on failed attempt or to the user homepage on success
     */
    public function checkLogin(){
        if(!isset($_POST['email_address'])){
            $this->addMessage("Invalid Login Attempt", 'error');
            header('Location: ' . URLROOT . '/auth/login');
            die();
        }
        $id = UserHelper::checkLogin($_POST['email_address'], $_POST['password']);
        if( $id !== null){
            $this->user = new User;
            $this->user->load($id);
            $_SESSION['user_id'] = $id;
            header('Location: ' . URLROOT . '/users/home');
            die();
        } else {
            $this->addMessage('Invalid Login', 'error');
            header('Location: ' . URLROOT . '/auth/login');
            die();
        }
    }

    /**
     * Logs the user out and clears all session data that has been set
     */
    public function logout(){
        $this->user = null;
        unset($_SESSION['user_id']);
        unset($_SESSION['messages']);
        header('Location: ' . URLROOT . '/auth/login');
    }

}
