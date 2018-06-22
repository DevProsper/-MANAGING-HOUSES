<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 18/06/2018
 * Time: 05:46
 */

namespace App\Controller\Admin;


use Core\Html\BootstrapForm;
use Core\Library\Export\ExportDataExcel;

class RolesController extends AdminAppController
{
    protected $auth;

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        if(isset($_POST['query'])){
            $query = $_POST['query'];
            $q = '%'.$query.'%';
            $sql = $this->Role->sql."
            WHERE roles.nom LIKE '%$query%'
            ORDER BY roles.creation DESC";
            $sql = $this->db->getPDO()->prepare($sql);
            $sql->execute([$q]);
            $count = $sql->rowCount();
            $roles = $sql->fetchAll();
            $this->render('admin.roles.search', compact('roles','count'));
        }else{
            $total = $this->Role->tableCount();
            $perPage = 4;
            $current = 1;
            $nbPage = ceil($total/$perPage);
            $requette = $this->paginateRole($current,$nbPage,$perPage);
            $roles = $this->Role->last();
            $this->render('admin.roles.index', compact('roles','requette','nbPage','current'));
        }
    }

    public function export(){
        $data = $this->Role->export();
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
                $result = $this->Role->create([
                    'nom' => $nom,
                    'id_utilisateur'  => $_SESSION['auth']->id,
                    'creation'  => date('Y-m-d H:i:s')
                ]);
                if ($result) {
                    setFlash("Le role a bien été ajouter");
                    urlAdmin('roles.index');
                }
            }
        }

        $form = new BootstrapForm($_POST);
        $this->render('admin.roles.edit', compact('form','errors'));

    }

    public function edit(){
        if(!empty($_POST)){
            $nom = htmlspecialchars(trim($_POST['nom']));

            $errors = [];
            if (empty($nom)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }
            $result = $this->Role->update($_GET['id'],[
                'nom' => $nom,
                'id_utilisateur'  => $_SESSION['auth']->id,
                'creation'  => date('Y-m-d H:i:s')
            ]);
            if ($result) {
                setFlash("Le role a bien été modifier");
                urlAdmin('roles.index');
            }
        }
        $post = $this->Role->find($_GET['id']);
        $form = new BootstrapForm($post);
        $this->render('admin.roles.edit', compact('form'));
    }

    public function delete(){
        if(!empty($_POST)){
            $this->Role->delete($_POST['id']);
            setFlash("Le role a bien été supprimer");
            urlAdmin('roles.index');
        }
    }
}