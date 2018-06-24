<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 05/06/2018
 * Time: 05:31
 */

namespace App\Controller\Admin;


use Core\Html\BootstrapForm;

class QuartiersController extends AdminAppController
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        if(isset($_POST['query'])){
            $query = $_POST['query'];
            $q = '%'.$query.'%';
            $sql = $this->Quartier->sql . "
            WHERE quartiers.nom
            LIKE '%$query%' ORDER BY quartiers.creation DESC";
            $sql = $this->db->getPDO()->prepare($sql);
            $sql->execute([$q]);
            $count = $sql->rowCount();
            $quartiers = $sql->fetchAll();
            $this->render('admin.quartiers.search', compact('quartiers','count'));
        }else{
            $total = $this->Quartier->tableCount();
            $perPage = 4;
            $current = 1;
            $nbPage = ceil($total/$perPage);
            $requette = $this->paginateQuartier($current,$nbPage,$perPage);
            $quartiers = $this->Quartier->last();
            $this->render('admin.quartiers.index', compact('quartiers','requette','nbPage','current'));
        }
    }

    public function add(){
        if(!empty($_POST)){
            $nom = htmlspecialchars(trim($_POST['nom']));
            $slug = htmlspecialchars(trim($_POST['slug']));
            $id_arrondissement = htmlspecialchars(trim($_POST['id_arrondissement']));
            $id_statut = htmlspecialchars(trim($_POST['id_statut']));

            $errors = [];
            if (empty($nom)|| empty($slug)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }
            if(empty($errors)){
                $result = $this->Quartier->create([
                    'nom' => $nom,
                    'slug'  => $slug,
                    'id_arrondissement'  => $id_arrondissement,
                    'id_statut'  => $id_statut,
                    'id_utilisateur'  => $_SESSION['auth']->id,
                    'creation'  => date('Y-m-d H:i:s')
                ]);
                if ($result) {
                    setFlash("La quartier a bien été ajouter");
                    urlAdmin('quartiers.index');
                }
            }
        }
        $arrondissement_list = $this->Arrondissement->extra();
        $etat_list = $this->Statut->extra();
        $form = new BootstrapForm($_POST);
        $this->render('admin.quartiers.edit', compact('form','errors','arrondissement_list','etat_list'));
    }

    public function edit(){
        if(!empty($_POST)){
            $nom = htmlspecialchars(trim($_POST['nom']));
            $slug = htmlspecialchars(trim($_POST['slug']));
            $id_arrondissement = htmlspecialchars(trim($_POST['id_arrondissement']));
            $id_statut = htmlspecialchars(trim($_POST['id_statut']));

            $errors = [];
            if (empty($nom)|| empty($slug)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }
            if(empty($errors)){
                $result = $this->Quartier->update($_GET['id'],[
                    'nom' => $nom,
                    'slug'  => $slug,
                    'id_arrondissement'  => $id_arrondissement,
                    'id_statut'  => $id_statut,
                    'id_utilisateur'  => $_SESSION['auth']->id,
                    'creation'  => date('Y-m-d H:i:s')
                ]);
                if ($result) {
                    setFlash("Le quartier a bien été modifier");
                    urlAdmin('quartiers.index');
                }
            }
        }
        $arrondissement_list = $this->Arrondissement->extra();
        $etat_list = $this->Statut->extra();
        $post = $this->Quartier->find($_GET['id']);
        $form = new BootstrapForm($post);
        $this->render('admin.quartiers.edit', compact('form','errors','arrondissement_list','etat_list'));
    }

    public function delete(){
        if(!empty($_POST)){
            $this->Quartier->delete($_POST['id']);
            setFlash("La categorie a bien été supprimer");
            urlAdmin('quartiers.index');
        }
    }
}