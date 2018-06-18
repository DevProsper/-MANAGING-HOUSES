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
            $sql = "SELECT categories.id,categories.nom,categories.slug,
            utilisateurs.nom as utilisateur
            FROM categories
            LEFT JOIN utilisateurs
            ON utilisateurs.id = categories.id_utilisateur 
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

            $errors = [];
            if (empty($nom)|| empty($slug)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }
            if(empty($errors)){
                $result = $this->Category->create([
                    'nom' => $nom,
                    'slug'  => $slug,
                    'id_utilisateur'  => $_SESSION['auth']->id,
                    'creation'  => date('Y-m-d H:i:s')
                ]);
                if ($result) {
                    setFlash("La categorie a bien été ajouter");
                    urlAdmin('categories.index');
                }
            }
        }

        $form = new BootstrapForm($_POST);
        $this->render('admin.categories.edit', compact('form','errors'));
    }

    public function edit(){
        if(!empty($_POST)){
            $nom = htmlspecialchars(trim($_POST['nom']));
            $slug = htmlspecialchars(trim($_POST['slug']));

            $errors = [];
            if (empty($nom)|| empty($slug)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }
            $result = $this->Category->update($_GET['id'],[
                'nom' => $nom,
                'slug'  => $slug,
                'id_utilisateur'  => $_SESSION['auth']->id,
                'creation'  => date('Y-m-d H:i:s')
            ]);
            if ($result) {
                setFlash("La categorie a bien été modifié");
                urlAdmin('categories.index');
            }
        }
        $post = $this->Category->find($_GET['id']);
        $form = new BootstrapForm($post);
        $this->render('admin.categories.edit', compact('form'));
    }

    public function delete(){
        if(!empty($_POST)){
            $this->Category->delete($_POST['id']);
            setFlash("La categorie a bien �t� supprimer");
            urlAdmin('categories.index');
        }
    }
}