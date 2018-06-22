<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 05/06/2018
 * Time: 05:32
 */

namespace App\Controller\Admin;


use Core\Html\BootstrapForm;

class PiecesController extends AdminAppController
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        if(isset($_POST['query'])){
            $query = $_POST['query'];
            $q = '%'.$query.'%';
            $sql = $this->Piece->sql."
            WHERE pieces.nombre
            LIKE '%$query%' ORDER BY pieces.nombre ASC";
            $sql = $this->db->getPDO()->prepare($sql);
            $sql->execute([$q]);
            $count = $sql->rowCount();
            $pieces = $sql->fetchAll();
            $this->render('admin.pieces.search', compact('pieces','count'));
        }else{
            $total = $this->Piece->tableCount();
            $perPage = 4;
            $current = 1;
            $nbPage = ceil($total/$perPage);
            $requette = $this->paginatePiece($current,$nbPage,$perPage);
            $pieces = $this->Piece->last();
            $this->render('admin.pieces.index', compact('pieces','requette','nbPage','current'));
        }
    }

    public function add(){
        if(!empty($_POST)){
            $nombre = htmlspecialchars(trim($_POST['nombre']));

            $errors = [];
            if (empty($nombre)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }
            if(empty($errors)){
                $result = $this->Piece->create([
                    'nombre' => $nombre,
                    'id_utilisateur'  => $_SESSION['auth']->id,
                    'creation'  => date('Y-m-d H:i:s')
                ]);
                if ($result) {
                    setFlash("Le nombre de piece a bien été ajouter");
                    urlAdmin('pieces.index');
                }
            }
        }

        $form = new BootstrapForm($_POST);
        $this->render('admin.pieces.edit', compact('form','errors'));
    }

    public function edit(){
        if(!empty($_POST)){
            $nombre = htmlspecialchars(trim($_POST['nombre']));

            $errors = [];
            if (empty($nombre)) {
                $errors['empty'] = "Tous les champs sont obligatoires";
            }
            if(empty($errors)){
                $result = $this->Piece->update($_GET['id'],[
                    'nombre' => $nombre,
                    'id_utilisateur'  => $_SESSION['auth']->id,
                    'creation'  => date('Y-m-d H:i:s')
                ]);
                if ($result) {
                    setFlash("Le nombre de piece a bien été modifier");
                    urlAdmin('pieces.index');
                }
            }
        }
        $post = $this->Piece->find($_GET['id']);
        $form = new BootstrapForm($post);
        $this->render('admin.pieces.edit', compact('form','errors'));
    }

    public function delete(){
        if(!empty($_POST)){
            $this->Piece->delete($_POST['id']);
            setFlash("Le nombre de bien été supprimer");
            urlAdmin('pieces.index');
        }
    }
}