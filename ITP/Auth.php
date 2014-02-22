<?php
/**
 * Created by PhpStorm.
 * User: cmcclees
 * Date: 2/9/14
 * Time: 3:14 PM
 */

namespace ITP;

use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;

class Auth {
    public $pdo;
    public $username;
    public $email;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function attempt($username, $pass) {
        $this->username =  $username;
       //check username & pass are valid, return a boolean
        $sql = "SELECT * FROM users WHERE users.username LIKE '$username' AND users.password LIKE '$pass'";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $users = $statement->fetchAll(\PDO::FETCH_OBJ);


        if(empty($users)) {
            return false;
        }  else {
            $this->email = $users{0}->email;
            return true;
        }

    }

    public function getUsername() {
        return $this->username;
    }
    public function getEmail() {
        return $this->email;
    }
} 