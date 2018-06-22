<?php
namespace App\Controller\Admin;
use App\Table\Repository\CategoryRepository;
use App\Validator\CategoryValidator;
use Core\Html\BootstrapForm;

/**
 * Created by PhpStorm.
 * Users: DevProsper
 * Date: 15/03/2018
 * Time: 12:37
 */
class CategoriesController extends AdminAppController
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        if(isset($_POST['query'])){
            $query = $_POST['query'];
            $q = '%'.$query.'%';
            $sql = $this->Category->sql."
            WHERE categories.nom 
            LIKE '%$query%' ORDER BY categories.creation DESC";
            $sql = $this->db->getPDO()->prepare($sql);
            $sql->execute([$q]);
            $count = $sql->rowCount();
            $categories = $sql->fetchAll();
            $this->render('admin.categories.search', compact('categories','count'));
        }else{
            $total = $this->Category->tableCount();
            $perPage = 4;
            $current = 1;
            $nbPage = ceil($total/$perPage);
            $requette = $this->paginateCategorie($current,$nbPage,$perPage);
            $categories = $this->Category->last();
            $this->render('admin.categories.index', compact('categories','requette','nbPage','current'));
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
                $result = $this->Category->create([
                    'nom' => $nom,
                    'slug'  => $slug,
                    'id_statut'  => $id_statut,
                    'id_utilisateur'  => $_SESSION['auth']->id,
                    'creation'  => date('Y-m-d H:i:s')
                ]);
                if ($result) {
                    setFlash("La categorie a bien été ajouter");
                    urlAdmin('categories.index');
                }
            }
        }

        $etat_list = $this->Statut->extra();
        $form = new BootstrapForm($_POST);
        $this->render('admin.categories.edit', compact('form','errors','etat_list'));
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
                $result = $this->Category->update($_GET['id'],[
                    'nom' => $nom,
                    'slug'  => $slug,
                    'id_statut'  => $id_statut,
                    'id_utilisateur'  => $_SESSION['auth']->id,
                    'creation'  => date('Y-m-d H:i:s')
                ]);
                if ($result) {
                    setFlash("La categorie a bien été modifier");
                    urlAdmin('categories.index');
                }
            }
        }
        $post = $this->Category->find($_GET['id']);
        $etat_list = $this->Statut->extra();
        $form = new BootstrapForm($post);
        $this->render('admin.categories.edit', compact('form','errors','etat_list'));
    }

    public function delete(){
        if(!empty($_POST)){
            $this->Category->delete($_POST['id']);
            setFlash("La categorie a bien été supprimer");
            urlAdmin('categories.index');
        }
    }
}