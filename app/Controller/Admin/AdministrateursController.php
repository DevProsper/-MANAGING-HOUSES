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

class AdministrateursController extends AdminAppController
{

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        if(isset($_POST['query'])){
            $query = $_POST['query'];
            $q = '%'.$query.'%';
            $sql = $this->Utilisateur->sql ."
            WHERE utilisateurs.nom || utilisateurs.prenom || id_role = 1
            || id_role = 2 || id_role = 3
            LIKE '%$query%' ORDER BY utilisateurs.creation DESC";
            $sql = $this->db->getPDO()->prepare($sql);
            $sql->execute([$q]);
            $count = $sql->rowCount();
            $admins = $sql->fetchAll();
            $this->render('admin.admins.search', compact('admins','count'));
        }else{
            $total = $this->Utilisateur->tableCount();
            $perPage = 4;
            $current = 1;
            $nbPage = ceil($total/$perPage);
            $requette = $this->paginateAdministrateur($current,$nbPage,$perPage);
            $admins = $this->Administrateur->last();
            $this->render('admin.admins.index', compact('admins','requette','nbPage','current'));
        }
    }

    public function export(){
        $data = $this->Administrateur->export();
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
                $result = $this->Administrateur->create([
                    'nom' => $nom,
                    'prenom'  => $prenom,
                    'tel'  => $tel,
                    'id_role'  => '1',
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
                    setFlash("L'aministrateur a bien été ajouter");
                    urlAdmin('admins.index');
                }
            }
        }

        $etat_list = $this->Statut->extra();
        $form = new BootstrapForm($_POST);
        $this->render('admin.admins.edit', compact('form','errors','etat_list'));
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
                $result = $this->Administrateur->update($_GET['id'],[
                    'nom' => $nom,
                    'prenom'  => $prenom,
                    'tel'  => $tel,
                    'id_role'  => '1',
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
                    setFlash("L'administrateur a bien été modifié");
                    urlAdmin('admins.index');
                }
            }
        }
        $post = $this->Administrateur->find($_GET['id']);
        $etat_list = $this->Statut->extra();
        $form = new BootstrapForm($post);
        $this->render('admin.admins.edit', compact('form','etat_list'));
    }

    public function delete(){
        if(!empty($_POST)){
            $this->Administrateur->delete($_POST['id']);
            setFlash("L'administrateur a bien été supprimer");
            urlAdmin('admins.index');
        }
    }
}