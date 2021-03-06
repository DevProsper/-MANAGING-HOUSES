<?php
namespace App\Controller;
use Core\Auth\DBAuth;
use Core\Controller\Controller;
use \App;
use Core\Database\MysqlDatabase;

/**
 * Created by PhpStorm.
 * Users: DevProsper
 * Date: 15/03/2018
 * Time: 11:42
 */
class AppController extends Controller
{

    protected $auth;
    protected $db;
    protected $extension;

    public function __construct(){
        $this->viewPath = ROOT . '/app/Views/';
        $this->loadModel('Arrondissement');
        $this->loadModel('Administrateur');
        $this->loadModel('Agence');
        $this->loadModel('Proprietaire');
        $this->loadModel('Category');
        $this->loadModel('Contact');
        $this->loadModel('Depot');
        $this->loadModel('Piece');
        $this->loadModel('Post');
        $this->loadModel('Quartier');
        $this->loadModel('Role');
        $this->loadModel('Statut');
        $this->loadModel('Type');
        $this->loadModel('Utilisateur');
        $this->loadModel('Ville');
        $this->template = "default";
        $this->auth = new DBAuth(App::getInstance()->getDB());
        $this->db = new MysqlDatabase(App::getInstance()->getDB());
    }

    public function uploadFile($file,$idPost,$extensions = []){
        $files = $file;
        $file_name = array();
        foreach ($files['tmp_name'] as $k => $v) {
            $file_name = array(
                'name'  => $files['name'][$k],
                'tmp_name'  => $files['tmp_name'][$k]
            );
            $this->extension = pathinfo($file_name['name'], PATHINFO_EXTENSION);
            if(in_array($this->extension, $extensions)){
                $req = $this->db->getPDO()->prepare("INSERT INTO files SET post_id=$idPost");
                $req->execute([$idPost]);
                $file_id = $this->db->getPDO()->lastInsertId();
                //cr�ation du fichier
                $directoryName = PATH_IMAGE."/".$idPost.'/';
                if(!is_dir($directoryName)){
                    //Directory does not exist, so lets create it.
                    mkdir($directoryName, 0755, true);
                }
                $image_name = time() + 7 ."post".$file_id.'.'.$this->extension;
                move_uploaded_file($file_name['tmp_name'], $directoryName.$image_name);
                $i = [
                    'id' =>$file_id,
                    'file_name' =>$image_name
                ];
                $req = $this->db->getPDO()->prepare("UPDATE files SET file_name=:file_name WHERE id=:id");
                $req->execute($i);
            }
        }
    }

    protected function loadModel($model_name){
        $this->$model_name = App::getInstance()->getTable($model_name);
    }

    public function notFound(){
        header('HTTP/1.0 404 Not Found');
    }


    public function paginatePost($current2,$nbPage2,$perPage){
        $perPage = $this->perPage($perPage);
        $nbPage = $nbPage2;
        $firstOpage = $this->parametersPaginate($current2,$perPage,$nbPage);
        $statement = $this->Post->lastP($firstOpage,$perPage);
        return $statement;
    }

    public function paginateArrondi($current2,$nbPage2,$perPage){
        $perPage = $this->perPage($perPage);
        $nbPage = $nbPage2;
        $firstOpage = $this->parametersPaginate($current2,$perPage,$nbPage);
        $statement = $this->Arrondissement->lastP($firstOpage,$perPage);
        return $statement;
    }

    public function paginateCategorie($current2,$nbPage2,$perPage){
        $perPage = $this->perPage($perPage);
        $nbPage = $nbPage2;
        $firstOpage = $this->parametersPaginate($current2,$perPage,$nbPage);
        $statement = $this->Category->lastP($firstOpage,$perPage);
        return $statement;
    }

    public function paginatePiece($current2,$nbPage2,$perPage){
        $perPage = $this->perPage($perPage);
        $nbPage = $nbPage2;
        $firstOpage = $this->parametersPaginate($current2,$perPage,$nbPage);
        $statement = $this->Piece->lastP($firstOpage,$perPage);
        return $statement;
    }

    public function paginateType($current2,$nbPage2,$perPage){
        $perPage = $this->perPage($perPage);
        $nbPage = $nbPage2;
        $firstOpage = $this->parametersPaginate($current2,$perPage,$nbPage);
        $statement = $this->Type->lastP($firstOpage,$perPage);
        return $statement;
    }

    public function paginateRole($current2,$nbPage2,$perPage){
        $perPage = $this->perPage($perPage);
        $nbPage = $nbPage2;
        $firstOpage = $this->parametersPaginate($current2,$perPage,$nbPage);
        $statement = $this->Role->lastP($firstOpage,$perPage);
        return $statement;
    }

    public function paginateVille($current2,$nbPage2,$perPage){
        $perPage = $this->perPage($perPage);
        $nbPage = $nbPage2;
        $firstOpage = $this->parametersPaginate($current2,$perPage,$nbPage);
        $statement = $this->Ville->lastP($firstOpage,$perPage);
        return $statement;
    }

    public function paginateQuartier($current2,$nbPage2,$perPage){
        $perPage = $this->perPage($perPage);
        $nbPage = $nbPage2;
        $firstOpage = $this->parametersPaginate($current2,$perPage,$nbPage);
        $statement = $this->Quartier->lastP($firstOpage,$perPage);
        return $statement;
    }

    public function paginateStatut($current2,$nbPage2,$perPage){
        $perPage = $this->perPage($perPage);
        $nbPage = $nbPage2;
        $firstOpage = $this->parametersPaginate($current2,$perPage,$nbPage);
        $statement = $this->Statut->lastP($firstOpage,$perPage);
        return $statement;
    }

    public function paginateUtilisateur($current2,$nbPage2,$perPage){
        $perPage = $this->perPage($perPage);
        $nbPage = $nbPage2;
        $firstOpage = $this->parametersPaginate($current2,$perPage,$nbPage);
        $statement = $this->Utilisateur->lastP($firstOpage,$perPage);
        return $statement;
    }

    public function paginateAdministrateur($current2,$nbPage2,$perPage){
        $perPage = $this->perPage($perPage);
        $nbPage = $nbPage2;
        $firstOpage = $this->parametersPaginate($current2,$perPage,$nbPage);
        $statement = $this->Administrateur->lastP($firstOpage,$perPage);
        return $statement;
    }

    public function paginateAgence($current2,$nbPage2,$perPage){
        $perPage = $this->perPage($perPage);
        $nbPage = $nbPage2;
        $firstOpage = $this->parametersPaginate($current2,$perPage,$nbPage);
        $statement = $this->Agence->lastP($firstOpage,$perPage);
        return $statement;
    }

    public function paginateProprietaire($current2,$nbPage2,$perPage){
        $perPage = $this->perPage($perPage);
        $nbPage = $nbPage2;
        $firstOpage = $this->parametersPaginate($current2,$perPage,$nbPage);
        $statement = $this->Proprietaire->lastP($firstOpage,$perPage);
        return $statement;
    }

    /**
     * Verifie si la session existe
     * @return bool
     */
    public function isLogged(){
        if(isset($_SESSION['auth'])){
            urlAdmin('posts.index');
            return $_SESSION['auth'];
        }
    }
}