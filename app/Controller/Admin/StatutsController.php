<?php
namespace App\Controller\Admin;
use Core\Html\BootstrapForm;

/**
 * Created by PhpStorm.
 * Users: DevProsper
 * Date: 15/03/2018
 * Time: 12:37
 */
class StatutsController extends AdminAppController
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        if(isset($_POST['query'])){
            $query = $_POST['query'];
            $q = '%'.$query.'%';
            $sql = $this->Statut->sql ."
            WHERE statuts.nom
            LIKE '%$query%' ORDER BY statuts.creation DESC";
            $sql = $this->db->getPDO()->prepare($sql);
            $sql->execute([$q]);
            $count = $sql->rowCount();
            $statuts = $sql->fetchAll();
            $this->render('admin.statuts.search', compact('statuts','count'));
        }else{
            $total = $this->Statut->tableCount();
            $perPage = 4;
            $current = 1;
            $nbPage = ceil($total/$perPage);
            $requette = $this->paginateStatut($current,$nbPage,$perPage);
            $statuts = $this->Statut->last();
            $this->render('admin.statuts.index', compact('statuts','requette','nbPage','current'));
        }
    }

    public function add(){
        if(!empty($_POST)){
            $nom = htmlspecialchars(trim($_POST['nom']));

            $errors = [];
            if (empty($nom)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }
            if(empty($errors)){
                $result = $this->Statut->create([
                    'nom' => $nom,
                    'id_utilisateur'  => $_SESSION['auth']->id,
                    'creation'  => date('Y-m-d H:i:s')
                ]);
                if ($result) {
                    setFlash("L'état a bien été ajouter");
                    urlAdmin('statuts.index');
                }
            }
        }
        $form = new BootstrapForm($_POST);
        $this->render('admin.statuts.edit', compact('form','errors'));
    }

    public function edit(){
        if(!empty($_POST)){
            $nom = htmlspecialchars(trim($_POST['nom']));

            $errors = [];
            if (empty($nom)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }
            if(empty($errors)){
                $result = $this->Statut->update($_GET['id'],[
                    'nom' => $nom,
                    'id_utilisateur'  => $_SESSION['auth']->id,
                    'creation'  => date('Y-m-d H:i:s')
                ]);
                if ($result) {
                    setFlash("L'état a bien été modifier");
                    urlAdmin('statuts.index');
                }
            }
        }
        $post = $this->Statut->find($_GET['id']);
        $form = new BootstrapForm($post);
        $this->render('admin.statuts.edit', compact('form','errors'));
    }

    public function delete(){
        if(!empty($_POST)){
            $this->Statut->delete($_POST['id']);
            setFlash("L'état a bien été supprimer");
            urlAdmin('statuts.index');
        }
    }
}