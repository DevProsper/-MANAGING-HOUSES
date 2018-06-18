<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 05/06/2018
 * Time: 05:33
 */

namespace App\Controller\Admin;


use App;
use App\Controller\AppController;
use Core\Auth\DBAuth;
use Core\Html\BootstrapForm;

class UtilisateursController extends AppController
{
    /**
     * @var UserRepository
     */
    private $repository;

    protected $auth;

    public function __construct(){
        parent::__construct();
        $this->loadModel('Utilisateur');
        $this->auth = new DBAuth(App::getInstance()->getDB());
        $this->isLogged();
    }

    public function register(){
        if(!empty($_POST)){
            $nom = htmlspecialchars(trim($_POST['nom']));
            $email = htmlspecialchars(trim($_POST['email']));
            $password = htmlspecialchars(trim($_POST['password']));
            $password_confirm = htmlspecialchars(trim($_POST['password_confirm']));

            $errors = [];
            if (empty($nom)) {
                $errors['empty'] = "Ce champ ne peut pas être vide";
            }
            if(empty($errors)){
                $result = $this->Utilisateur->create([
                    'nom'  => $nom,
                    'id_utilisateur'  => $_SESSION['auth']->id,
                    'created'  => date('Y-m-d H:i:s')
                ]);
                $id = $_SESSION['auth']->id;
                dd($id);
                if ($result) {
                    setFlash("L'arrondissements a bien été ajouter");
                    urlAdmin('arrond.index');
                }
            }
        }
        if($this->isAdmin() != 1){
            urlAdmin('arrond.index');
        }
        $form = new BootstrapForm($_POST);
        $this->render('admin.arrondissements.edit', compact('form','errors'));
    }

    /**
     *
     */
    public function login(){
        $errors = false;
        if (!empty($_POST)) {
            if($this->auth->login($_POST['email'], $_POST['password'])){
                //urlAdmin('posts.index');
                setFlash("Vous êtes maintenant connecté");
            }
        }
        $form = new BootstrapForm($_POST);
        $this->render('admin.utilisateurs.login', compact('form', 'errors'));
    }


    public function logout(){
        unset($_SESSION['auth']);
        urlLogin();
    }

    public function forgetPassword(){
        if (!empty($_POST)) {
            if($this->auth->forgetPassword($_POST['email'])){
                urlHome();
            }
        }
        $form = new BootstrapForm($_POST);
        $this->render('utilisateurs.oublie', compact('form'));
    }

    public function resetPassword(){
        if(isset($_GET['id']) && isset($_GET['token'])){
            if(!empty($_POST)){
                $post  = $this->auth->resetPassword($_GET['id'], $_GET['token'],$_POST['password'],$_POST['paswword_confirm']);
                if($post){
                    urlLogin();
                }
            }
        }else{
            urlLogin();
        }
        $form = new BootstrapForm($_POST);
        $this->render('utilisateurs.reinitialiser', compact('form'));
    }
}