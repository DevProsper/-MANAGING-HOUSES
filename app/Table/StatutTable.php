<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 18/06/2018
 * Time: 04:50
 */

namespace app\Table;


use Core\Table\Table;

class StatutTable extends Table
{
    protected $table = "statuts";

    public $sql = "SELECT statuts.id, statuts.nom,
            utilisateurs.nom as utilisateur
            FROM statuts
            LEFT JOIN utilisateurs
            ON statuts.id_utilisateur = utilisateurs.id";
    
    /**
     *Récupère les derniers statuts
     * @return array
     */

    public function last(){
        return $this->db->getPDO()->query($this->sql ."
            ORDER BY statuts.creation DESC
        ");
    }

    public function lastP($offset,$limit){
        return $this->db->getPDO()->query($this->sql."
            ORDER BY statuts.creation DESC LIMIT $offset,$limit
        ");
    }

    public function RoleCount(){
        return $this->tableCount();
    }

    public function export(){
        $sql = "SELECT id as Id,nom as Nom FROM statuts";
        $req = $this->db->getPDO()->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }
}