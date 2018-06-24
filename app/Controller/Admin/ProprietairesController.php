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

class ProprietairesController extends AdminAppController
{

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        if(isset($_POST['query'])){
            $query = $_POST['query'];
            $q = '%'.$query.'%';
            $sql = $this->Proprietaire->sql ."
            WHERE id_role = 8 AND utilisateurs.nom
            LIKE '%$query%' ORDER BY utilisateurs.nom ASC";
            $sql = $this->db->getPDO()->prepare($sql);
            $sql->execute([$q]);
            $count = $sql->rowCount();
            $proprietaires = $sql->fetchAll();
            $this->render('admin.proprietaires.search', compact('proprietaires','count'));
        }else{
            $total = $this->Proprietaire->tableCount();
            $perPage = 4;
            $current = 1;
            $nbPage = ceil($total/$perPage);
            $requette = $this->paginateProprietaire($current,$nbPage,$perPage);
            $proprietaires = $this->Proprietaire->last();
            $this->render('admin.proprietaires.index', compact('proprietaires','requette','nbPage','current'));
        }
    }

    public function export(){
        $data = $this->Proprietaire->export();
        ExportDataExcel::export($data,'Export');
    }

    public function add(){
        if(!empty($_POST)){
            $nom = htmlspecialchars(trim($_POST['nom']));
            $tel = htmlspecialchars(trim($_POST['tel']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
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
                $result = $this->Proprietaire->create([
                    'nom' => $nom,
                    'prenom'  => $prenom,
                    'tel'  => $tel,
                    'id_role'  => '8',
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
                    setFlash("Le proprietaire a bien été ajouter");
                    urlAdmin('proprietaires.index');
                }
            }
        }

        $etat_list = $this->Statut->extra();
        $form = new BootstrapForm($_POST);
        $this->render('admin.proprietaires.edit', compact('form', 'categories_list','errors','etat_list','role_list'));

    }

    public function edit(){
        if(!empty($_POST)){
            $nom = htmlspecialchars(trim($_POST['nom']));
            $tel = htmlspecialchars(trim($_POST['tel']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
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
                    'id_role'  => '8',
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
                    setFlash("Le proprietaire a bien été modifié");
                    urlAdmin('proprietaires.index');
                }
            }
        }
        $post = $this->Proprietaire->find($_GET['id']);
        $etat_list = $this->Statut->extra();
        //$categories_list = $this->Category->extra();
        $form = new BootstrapForm($post);
        $this->render('admin.proprietaires.edit', compact('form', 'categories_list','etat_list','role_list'));
    }

    public function delete(){
        if(!empty($_POST)){
            $this->Utilisateur->delete($_POST['id']);
            setFlash("Le proprietaire a bien été supprimer");
            urlAdmin('proprietaires.index');
        }
    }
}