<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 11/06/2018
 * Time: 03:07
 */

namespace App\Table;


use Core\Table\Table;

class RoleTable extends Table
{
    protected $table = "roles";

    public $sql = "SELECT roles.id, roles.nom,
            utilisateurs.nom as utilisateur
            FROM roles
            LEFT JOIN utilisateurs
            ON roles.id_utilisateur = utilisateurs.id";

    /**
     *Récupère les derniers roles
     * @return array
     */

    public function last(){
        return $this->db->getPDO()->query($this->sql."
            ORDER BY roles.creation DESC
        ");
    }

    public function lastP($offset,$limit){
        return $this->db->getPDO()->query($this->sql."
            ORDER BY roles.creation DESC LIMIT $offset,$limit
        ");
    }

    public function RoleCount(){
        return $this->tableCount();
    }

    public function export(){
        $sql = "SELECT id as Id,nom as Nom FROM roles";
        $req = $this->db->getPDO()->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }

}