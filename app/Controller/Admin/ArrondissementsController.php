<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 05/06/2018
 * Time: 05:31
 */

namespace App\Controller\Admin;


use Core\Html\BootstrapForm;
use Core\Library\Export\ExportDataExcel;

class ArrondissementsController extends AdminAppController
{
    protected $auth;

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        if(isset($_POST['query'])){
            $query = $_POST['query'];
            $q = '%'.$query.'%';
            $sql = "SELECT arrondissements.id,arrondissements.nom,arrondissements.slug,
            villes.slug as ville
            FROM arrondissements
            LEFT JOIN villes
            ON arrondissements.id_ville = villes.id
            WHERE arrondissements.nom LIKE '%$query%' 
            ORDER BY arrondissements.creation DESC";
            $sql = $this->db->getPDO()->prepare($sql);
            $sql->execute([$q]);
            $count = $sql->rowCount();
            $arrondissements = $sql->fetchAll();
            $this->render('admin.arrondissements.search', compact('arrondissements','count'));
        }else{
            $total = $this->Arrondissement->tableCount();
            $perPage = 4;
            $current = 1;
            $nbPage = ceil($total/$perPage);
            $requette = $this->paginateArrondi($current,$nbPage,$perPage);
            $arrondissements = $this->Arrondissement->all();
            $this->render('admin.arrondissements.index', compact('arrondissements','requette','nbPage','current'));
        }
    }

    public function export(){
        $data = $this->Arrondissement->export();
        ExportDataExcel::export($data,'Export');
    }

    public function add(){
        if(!empty($_POST)){
            $nom = htmlspecialchars(trim($_POST['nom']));
            $id_ville = htmlspecialchars(trim($_POST['id_ville']));
            $slug = htmlspecialchars(trim($_POST['slug']));
            $poster = htmlspecialchars(trim($_POST['poster']));

            $errors = [];
            if (empty($nom)|| empty($slug)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }
            if(empty($errors)){
                $result = $this->Arrondissement->create([
                    'nom' => $nom,
                    'slug'  => $slug,
                    'id_ville'  => $id_ville,
                    'poster'  => $poster,
                    'id_utilisateur'  => $_SESSION['auth']->id,
                    'creation'  => date('Y-m-d H:i:s')
                ]);
                if ($result) {
                    setFlash("L'arrondissement a bien été ajouter");
                    urlAdmin('arrond.index');
                }
            }
        }

        $categories_list = $this->Category->extract('id', 'nom');
        $form = new BootstrapForm($_POST);
        $this->render('admin.arrondissements.edit', compact('form', 'categories_list','errors'));

    }

    public function edit(){
        if(!empty($_POST)){
            $nom = htmlspecialchars(trim($_POST['nom']));
            $id_ville = htmlspecialchars(trim($_POST['id_ville']));
            $slug = htmlspecialchars(trim($_POST['slug']));
            $poster = htmlspecialchars(trim($_POST['poster']));

            $errors = [];
            if (empty($nom)|| empty($contenu)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }
            $result = $this->Arrondissement->update($_GET['id'],[
                'nom' => $nom,
                'slug'  => $slug,
                'poster'  => $poster,
                'id_ville'  => $id_ville,
                'id_utilisateur'  => $_SESSION['auth']->id,
                'creation'  => date('Y-m-d H:i:s')
            ]);
            if ($result) {
                setFlash("L'arrondissement a bien été modifié");
                urlAdmin('arrond.index');
            }
        }
        $post = $this->Arrondissement->find($_GET['id']);
        $categories_list = $this->Category->extract('id', 'nom');
        //$categories_list = $this->Category->extra();
        $form = new BootstrapForm($post);
        $this->render('admin.arrondissements.edit', compact('form', 'categories_list'));
    }

    public function delete(){
        if(!empty($_POST)){
            $this->Arrondissement->delete($_POST['id']);
            setFlash("L'arrondissement a bien été supprimer");
            urlAdmin('arrond.index');
        }
    }

}