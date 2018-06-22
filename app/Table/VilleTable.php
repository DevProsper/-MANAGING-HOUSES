<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 05/06/2018
 * Time: 05:38
 */
namespace App\Table;


use Core\Table\Table;

class VilleTable extends Table
{
    protected $table = "villes";

    public $sql = "SELECT villes.id, villes.nom,villes.slug,
            utilisateurs.nom as utilisateur,
            statuts.nom as statut
            FROM villes
            LEFT JOIN utilisateurs
            ON villes.id_utilisateur = utilisateurs.id
            LEFT JOIN statuts
            ON villes.id_statut = statuts.id";
    /**
     *Récupère les derniers villes
     * @return array
     */

    public function last(){
        return $this->db->getPDO()->query($this->sql ."
            ORDER BY villes.creation DESC
        ");
    }

    public function lastP($offset,$limit){
        return $this->db->getPDO()->query($this->sql."
            ORDER BY villes.creation DESC LIMIT $offset,$limit
        ");
    }

    public function VilleCount(){
        return $this->tableCount();
    }

    public function export(){
        $sql = "SELECT id as Id,nom as Nom FROM villes";
        $req = $this->db->getPDO()->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }
}