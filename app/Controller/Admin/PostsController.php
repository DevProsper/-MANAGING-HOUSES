<?php
namespace App\Controller\Admin;
use Core\Html\BootstrapForm;
use Core\Library\Export\ExportDataExcel;

/**
 * Created by PhpStorm.
 * Users: DevProsper
 * Date: 15/03/2018
 * Time: 12:37
 */
class PostsController extends AdminAppController
{
    protected $auth;

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        if(isset($_POST['query'])){
            $query = $_POST['query'];
            $q = '%'.$query.'%';
            $sql = "SELECT * FROM posts WHERE titre LIKE '%$query%' ORDER BY posts.creation DESC";
            $sql = $this->db->getPDO()->prepare($sql);
            $sql->execute([$q]);
            $count = $sql->rowCount();
            $posts = $sql->fetchAll();
            $this->render('admin.posts.search', compact('posts','count'));
        }else{
            $total = $this->Post->tableCount();
            $perPage = 4;
            $current = 1;
            $nbPage = ceil($total/$perPage);
            $requette = $this->paginatePost($current,$nbPage,$perPage);
            $posts = $this->Post->all();
            $this->render('admin.posts.index', compact('posts','requette','nbPage','current'));
        }
    }

    public function export(){
        $data = $this->Post->export();
        ExportDataExcel::export($data,'Export');
    }

    public function add(){
        if(!empty($_POST)){
            $files = $_FILES['file_name'];
            $titre = htmlspecialchars(trim($_POST['titre']));
            $id_categorie = htmlspecialchars(trim($_POST['id_categorie']));
            $contenu = htmlspecialchars(trim($_POST['contenu']));
            $id_ville = htmlspecialchars(trim($_POST['id_ville']));
            $id_arrondissement = htmlspecialchars(trim($_POST['id_arrondissement']));
            $id_quartier = htmlspecialchars(trim($_POST['id_quartier']));
            $id_type_bien = htmlspecialchars(trim($_POST['id_type_bien']));
            $adresse = htmlspecialchars(trim($_POST['adresse']));
            $latitude = htmlspecialchars(trim($_POST['latitude']));
            $longitude = htmlspecialchars(trim($_POST['longitude']));
            $id_piece = htmlspecialchars(trim($_POST['id_piece']));
            $prix = htmlspecialchars(trim($_POST['prix']));
            $id_agence = htmlspecialchars(trim($_POST['id_agence']));
            $extensions = array('jpg','png','jpeg','JPG','PNG','JPEG');

            $errors = [];
            if (empty($titre)|| empty($contenu)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }elseif(in_array($this->extension, $extensions)){
                $errors['files'] = "Format de fichier invalide";
            }
            if(empty($errors)){
                $result = $this->Post->create([
                    'titre' => $titre,
                    'contenu'  => $contenu,
                    'id_categorie'  => $id_categorie,
                    'id_ville'  => $id_ville,
                    'id_arrondissement'  => $id_arrondissement,
                    'id_quartier'  => $id_quartier,
                    'id_piece'  => $id_piece,
                    'id_type_bien'  => $id_type_bien,
                    'adresse'  => $adresse,
                    'latitude'  => $latitude,
                    'longitude'  => $longitude,
                    'prix'  => $prix,
                    'id_agence'  => $id_agence,
                    'id_utilisateur'  => $_SESSION['auth']->id,
                    'creation'  => date('Y-m-d H:i:s')
                ]);
                $id = $this->db->getPDO()->lastInsertId();
                if ($result) {
                    $this->uploadFile($files, $id,$extensions);
                    setFlash("Le bien a bien été ajouter");
                    urlAdmin('posts.index');
                }
            }
        }

        $categories_list = $this->Category->extract('id', 'nom');
        $arrondissement_list = $this->Arrondissement->extract('id', 'nom');
        $form = new BootstrapForm($_POST);
        $this->render('admin.posts.edit', compact('form', 'categories_list','errors','arrondissement_list'));

    }

    public function edit(){
        if(!empty($_POST)){
            $files = $_FILES['file_name'];
            $titre = htmlspecialchars(trim($_POST['titre']));
            $id_categorie = htmlspecialchars(trim($_POST['id_categorie']));
            $contenu = htmlspecialchars(trim($_POST['contenu']));
            $id_ville = htmlspecialchars(trim($_POST['id_ville']));
            $id_arrondissement = htmlspecialchars(trim($_POST['id_arrondissement']));
            $id_quartier = htmlspecialchars(trim($_POST['id_quartier']));
            $id_type_bien = htmlspecialchars(trim($_POST['id_type_bien']));
            $adresse = htmlspecialchars(trim($_POST['adresse']));
            $latitude = htmlspecialchars(trim($_POST['latitude']));
            $longitude = htmlspecialchars(trim($_POST['longitude']));
            $id_piece = htmlspecialchars(trim($_POST['id_piece']));
            $prix = htmlspecialchars(trim($_POST['prix']));
            $id_agence = htmlspecialchars(trim($_POST['id_agence']));
            $extensions = array('jpg','png','jpeg','JPG','PNG','JPEG');

            $errors = [];
            if (empty($titre)|| empty($contenu)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }elseif(in_array($this->extension, $extensions)){
                $errors['files'] = "Format de fichier invalide";
            }
            $result = $this->Post->update($_GET['id'],[
                'titre' => $titre,
                'contenu'  => $contenu,
                'id_categorie'  => $id_categorie,
                'id_ville'  => $id_ville,
                'id_arrondissement'  => $id_arrondissement,
                'id_quartier'  => $id_quartier,
                'id_piece'  => $id_piece,
                'id_type_bien'  => $id_type_bien,
                'adresse'  => $adresse,
                'latitude'  => $latitude,
                'longitude'  => $longitude,
                'prix'  => $prix,
                'id_agence'  => $id_agence,
                'id_utilisateur'  => $_SESSION['auth']->id,
                'creation'  => date('Y-m-d H:i:s')
            ]);
            $extensions = array('jpg','png','jpeg','JPG');
            if ($result) {
                $this->uploadFile($files, $_GET['id'],$extensions);
                setFlash("Le bien a bien été modifié");
                urlAdmin('posts.index');
            }
        }
        $post = $this->Post->find($_GET['id']);
        $categories_list = $this->Category->extract('id', 'nom');
        //$categories_list = $this->Category->extra();
        $form = new BootstrapForm($post);
        $this->render('admin.posts.edit', compact('form', 'categories_list'));
    }

    public function delete(){
        if(!empty($_POST)){
            $this->Post->delete($_POST['id']);
            setFlash("Le post a bien été supprimer");
            urlAdmin('posts.index');
        }
    }
}