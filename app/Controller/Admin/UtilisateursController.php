<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 05/06/2018
 * Time: 05:33
 */

namespace App\Controller\Admin;

use Core\Html\BootstrapForm;
use Core\Library\Export\ExportDataExcel;

class UtilisateursController extends AdminAppController
{

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        if(isset($_POST['query'])){
            $query = $_POST['query'];
            $q = '%'.$query.'%';
            $sql = $this->Utilisateur->sql ."
            WHERE utilisateurs.nom || utilisateurs.prenom
            LIKE '%$query%' ORDER BY utilisateurs.creation DESC";
            $sql = $this->db->getPDO()->prepare($sql);
            $sql->execute([$q]);
            $count = $sql->rowCount();
            $utilisateurs = $sql->fetchAll();
            $this->render('admin.utilisateurs.search', compact('utilisateurs','count'));
        }else{
            $total = $this->Utilisateur->tableCount();
            $perPage = 4;
            $current = 1;
            $nbPage = ceil($total/$perPage);
            $requette = $this->paginateUtilisateur($current,$nbPage,$perPage);
            $utilisateurs = $this->Post->all();
            $this->render('admin.utilisateurs.index', compact('utilisateurs','requette','nbPage','current'));
        }
    }

    public function export(){
        $data = $this->Utilisateur->export();
        ExportDataExcel::export($data,'Export');
    }

    public function add(){
        if(!empty($_POST)){
            $nom = htmlspecialchars(trim($_POST['nom']));
            $tel = htmlspecialchars(trim($_POST['tel']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
            $id_role = htmlspecialchars(trim($_POST['id_role']));
            $adresse = htmlspecialchars(trim($_POST['adresse']));
            $password = htmlspecialchars(trim($_POST['password']));
            $identite = htmlspecialchars(trim($_POST['identite']));
            $id_statut = htmlspecialchars(trim($_POST['id_statut']));
            $email = htmlspecialchars(trim($_POST['email']));
            $fonction = htmlspecialchars(trim($_POST['fonction']));

            $errors = [];
            if (empty($nom)|| empty($prenom)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }
            if(empty($errors)){
                $result = $this->Utilisateur->create([
                    'nom' => $nom,
                    'prenom'  => $prenom,
                    'tel'  => $tel,
                    'id_role'  => $id_role,
                    'id_statut'  => $id_statut,
                    'adresse'  => $adresse,
                    'password'  => sha1($password),
                    'identite'  => $identite,
                    'email'  => $email,
                    'fonction'  => $fonction,
                    'id_utilisateur'  => $_SESSION['auth']->id,
                    'creation'  => date('Y-m-d H:i:s')
                ]);
                if ($result) {
                    setFlash("L'utilisateur a bien �t� ajouter");
                    urlAdmin('utilisateurs.index');
                }
            }
        }

        $etat_list = $this->Statut->extra();
        $role_list = $this->Role->extra();
        $form = new BootstrapForm($_POST);
        $this->render('admin.utilisateurs.edit', compact('form', 'categories_list','errors','etat_list','role_list'));

    }

    public function edit(){
        if(!empty($_POST)){
            $nom = htmlspecialchars(trim($_POST['nom']));
            $tel = htmlspecialchars(trim($_POST['tel']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
            $id_role = htmlspecialchars(trim($_POST['id_role']));
            $adresse = htmlspecialchars(trim($_POST['adresse']));
            $password = htmlspecialchars(trim($_POST['password']));
            $identite = htmlspecialchars(trim($_POST['identite']));
            $id_statut = htmlspecialchars(trim($_POST['id_statut']));
            $email = htmlspecialchars(trim($_POST['email']));
            $fonction = htmlspecialchars(trim($_POST['fonction']));

            $errors = [];
            if (empty($nom)|| empty($prenom)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }
            if(empty($errors)){
                $result = $this->Utilisateur->update($_GET['id'],[
                    'nom' => $nom,
                    'prenom'  => $prenom,
                    'tel'  => $tel,
                    'id_role'  => $id_role,
                    'id_statut'  => $id_statut,
                    'adresse'  => $adresse,
                    'password'  => sha1($password),
                    'identite'  => $identite,
                    'email'  => $email,
                    'fonction'  => $fonction,
                    'id_utilisateur'  => $_SESSION['auth']->id,
                    'creation'  => date('Y-m-d H:i:s')
                ]);
                if ($result) {
                    setFlash("L'utilisateur a bien �t� modifi�");
                    urlAdmin('utilisateurs.index');
                }
            }
        }
        $post = $this->Utilisateur->find($_GET['id']);
        $etat_list = $this->Statut->extra();
        $role_list = $this->Role->extra();
        //$categories_list = $this->Category->extra();
        $form = new BootstrapForm($post);
        $this->render('admin.utilisateurs.edit', compact('form', 'categories_list','etat_list','role_list'));
    }

    public function delete(){
        if(!empty($_POST)){
            $this->Utilisateur->delete($_POST['id']);
            setFlash("L'utilisateur a bien �t� supprimer");
            urlAdmin('utilisateurs.index');
        }
    }
}