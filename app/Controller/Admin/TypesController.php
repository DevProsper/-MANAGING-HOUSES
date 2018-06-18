<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 05/06/2018
 * Time: 05:32
 */

namespace App\Controller\Admin;


use Core\Html\BootstrapForm;
use Core\Library\Export\ExportDataExcel;

class TypesController extends AdminAppController
{
    protected $auth;

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        if(isset($_POST['query'])){
            $query = $_POST['query'];
            $q = '%'.$query.'%';
            $sql = "SELECT types_bien.id,types_bien.nom,
            utilisateurs.nom as utilisateur
            FROM types_bien
            LEFT JOIN utilisateurs
            ON types_bien.id_utilisateur = utilisateurs.id
            WHERE types_bien.nom LIKE '%$query%'
            ORDER BY types_bien.creation DESC";
            $sql = $this->db->getPDO()->prepare($sql);
            $sql->execute([$q]);
            $count = $sql->rowCount();
            $types_bien = $sql->fetchAll();
            $this->render('admin.types_bien.search', compact('types_bien','count'));
        }else{
            $total = $this->Type->tableCount();
            $perPage = 4;
            $current = 1;
            $nbPage = ceil($total/$perPage);
            $requette = $this->paginateType($current,$nbPage,$perPage);
            $types_bien = $this->Type->last();
            $this->render('admin.types_bien.index', compact('types_bien','requette','nbPage','current'));
        }
    }

    public function export(){
        $data = $this->Type->export();
        ExportDataExcel::export($data,'Export');
    }

    public function add(){
        if(!empty($_POST)){
            $nom = htmlspecialchars(trim($_POST['nom']));

            $errors = [];
            if (empty($nom)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }
            if(empty($errors)){
                $result = $this->Type->create([
                    'nom' => $nom,
                    'id_utilisateur'  => $_SESSION['auth']->id,
                    'creation'  => date('Y-m-d H:i:s')
                ]);
                if ($result) {
                    setFlash("Le type de bien a bien été ajouter");
                    urlAdmin('types_bien.index');
                }
            }
        }
        $form = new BootstrapForm($_POST);
        $this->render('admin.types_bien.edit', compact('form', 'categories_list','errors'));

    }

    public function edit(){
        if(!empty($_POST)){
            $nom = htmlspecialchars(trim($_POST['nom']));

            $errors = [];
            if (empty($nom)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }
            $result = $this->Type->update($_GET['id'],[
                'nom' => $nom,
                'id_utilisateur'  => $_SESSION['auth']->id,
                'creation'  => date('Y-m-d H:i:s')
            ]);
            if ($result) {
                setFlash("Le type de bien a bien été modifié");
                urlAdmin('types_bien.index');
            }
        }
        $post = $this->Type->find($_GET['id']);
        $form = new BootstrapForm($post);
        $this->render('admin.types_bien.edit', compact('form'));
    }

    public function delete(){
        if(!empty($_POST)){
            $this->Type->delete($_POST['id']);
            setFlash("Le type de bien a bien été supprimer");
            urlAdmin('types_bien.index');
        }
    }

}