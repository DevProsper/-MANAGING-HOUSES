<?php
namespace App\Controller\Admin;

/**
 * Created by PhpStorm.
 * Users: DevProsper
 * Date: 15/03/2018
 * Time: 12:37
 */

use \App;
use App\Controller\AppController;

class AdminAppController extends AppController
{

    public function __construct(){
        parent::__construct();
        $this->template = "admin";
        $app = App::getInstance();
        if(!isset($_SESSION['auth'])){
            url('utilisateurs.login');
        }
    }

    public function isAdmin(){
        if(isset($_SESSION['auth'])) {
            $a = [
                'email'	=> $_SESSION['auth']->email
            ];
            $sql = "SELECT * FROM utilisateurs WHERE email=:email AND function_id=1";
            $req = $this->db->getPDO()->prepare($sql);
            $req->execute($a);
            $exist = $req->rowCount($sql);
            return $exist;
        }else{
            return 0;
        }
    }

    public function isModo(){
        if(isset($_SESSION['auth'])) {
            $a = [
                'email'	=> $_SESSION['auth']->email
            ];
            $sql = "SELECT * FROM utilisateurs WHERE email=:email AND function_id=2";
            $req = $this->db->getPDO()->prepare($sql);
            $req->execute($a);
            $exist = $req->rowCount($sql);
            return $exist;
        }else{
            return 0;
        }
    }

    public function isReda(){
        if(isset($_SESSION['auth'])) {
            $a = [
                'email'	=> $_SESSION['auth']->email
            ];
            $sql = "SELECT * FROM users WHERE email=:email AND function_id=3";
            $req = $this->db->getPDO()->prepare($sql);
            $req->execute($a);
            $exist = $req->rowCount($sql);
            return $exist;
        }else{
            return 0;
        }
    }
}