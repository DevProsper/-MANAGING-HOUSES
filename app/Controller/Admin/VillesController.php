<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 05/06/2018
 * Time: 05:12
 */

namespace App\Controller\Admin;


use Core\Html\BootstrapForm;

class VillesController extends AdminAppController
{
	public function __construct(){
        parent::__construct();
    }

    public function index(){
        if(isset($_POST['query'])){
            $query = $_POST['query'];
            $q = '%'.$query.'%';
            $sql = $this->Ville->sql ."
            WHERE villes.nom 
            LIKE '%$query%' ORDER BY villes.creation DESC";
            $sql = $this->db->getPDO()->prepare($sql);
            $sql->execute([$q]);
            $count = $sql->rowCount();
            $villes = $sql->fetchAll();
            $this->render('admin.villes.search', compact('villes','count'));
        }else{
            $total = $this->Ville->tableCount();
            $perPage = 4;
            $current = 1;
            $nbPage = ceil($total/$perPage);
            $requette = $this->paginateVille($current,$nbPage,$perPage);
            $villes = $this->Ville->last();
            $this->render('admin.villes.index', compact('villes','requette','nbPage','current'));
        }
    }

    public function add(){
        if(!empty($_POST)){
            $nom = htmlspecialchars(trim($_POST['nom']));
            $slug = htmlspecialchars(trim($_POST['slug']));
            $id_statut = htmlspecialchars(trim($_POST['id_statut']));

            $errors = [];
            if (empty($nom)|| empty($slug)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }
            if(empty($errors)){
                $result = $this->Ville->create([
                    'nom' => $nom,
                    'slug'  => $slug,
                    'id_statut'  => $id_statut,
                    'id_utilisateur'  => $_SESSION['auth']->id,
                    'creation'  => date('Y-m-d H:i:s')
                ]);
                if ($result) {
                    setFlash("La categorie a bien ÃƒÂ©tÃƒÂ© ajouter");
                    urlAdmin('villes.index');
                }
            }
        }

        $etat_list = $this->Statut->extra();
        $form = new BootstrapForm($_POST);
        $this->render('admin.villes.edit', compact('form','errors','etat_list'));
    }

    public function edit(){
        if(!empty($_POST)){
            $nom = htmlspecialchars(trim($_POST['nom']));
            $slug = htmlspecialchars(trim($_POST['slug']));
            $id_statut = htmlspecialchars(trim($_POST['id_statut']));

            $errors = [];
            if (empty($nom)|| empty($slug)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }
            if(empty($errors)){
                $result = $this->Ville->update($_GET['id'],[
                    'nom' => $nom,
                    'slug'  => $slug,
                    'id_statut'  => $id_statut,
                    'id_utilisateur'  => $_SESSION['auth']->id,
                    'creation'  => date('Y-m-d H:i:s')
                ]);
                if ($result) {
                    setFlash("La ville a bien été modifié");
                    urlAdmin('villes.index');
                }
            }
        }

        $etat_list = $this->Statut->extra();
        $post = $this->Ville->find($_GET['id']);
        $form = new BootstrapForm($post);
        $this->render('admin.villes.edit', compact('form','errors','etat_list'));
    }

    public function delete(){
        if(!empty($_POST)){
            $this->Ville->delete($_POST['id']);
            setFlash("La ville a bien été supprimer");
            urlAdmin('villes.index');
        }
    }
}