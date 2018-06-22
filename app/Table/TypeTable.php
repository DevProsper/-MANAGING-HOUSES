<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 05/06/2018
 * Time: 05:38
 */

namespace App\Table;


use Core\Table\Table;

class TypeTable extends Table
{
    protected $table = "types_bien";

    public $sql = "SELECT types_bien.id, types_bien.nom,
            utilisateurs.nom as utilisateur
            FROM types_bien
            LEFT JOIN utilisateurs
            ON types_bien.id_utilisateur = utilisateurs.id";
    /**
     *Récupère les derniers types_bien
     * @return array
     */

    public function last(){
        return $this->db->getPDO()->query($this->sql."
            ORDER BY types_bien.creation DESC
        ");
    }

    public function lastP($offset,$limit){
        return $this->db->getPDO()->query($this->sql."
            ORDER BY types_bien.creation DESC LIMIT $offset,$limit
        ");
    }

    public function TypeCount(){
        return $this->tableCount();
    }

    public function export(){
        $sql = "SELECT id as Id,nom as Nom FROM types_bien";
        $req = $this->db->getPDO()->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }

}