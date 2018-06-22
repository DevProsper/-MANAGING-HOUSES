<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 05/06/2018
 * Time: 05:38
 */

namespace App\Table;


use Core\Table\Table;

class QuartierTable extends Table
{

    protected $table = "quartiers";

    public $sql = "SELECT quartiers.id, quartiers.nom,quartiers.slug,
            utilisateurs.nom as utilisateur,
            arrondissements.nom as arrondissement,
            villes.nom as ville,
            statuts.nom as statut
            FROM quartiers
            LEFT JOIN utilisateurs
            ON quartiers.id_utilisateur = utilisateurs.id
            LEFT JOIN arrondissements
            ON quartiers.id_arrondissement = arrondissements.id
            LEFT JOIN villes
            ON arrondissements.id_ville = villes.id
            LEFT JOIN statuts
            ON quartiers.id_statut = statuts.id";
    /**
     *Récupère les derniers quartiers
     * @return array
     */

    public function last(){
        return $this->db->getPDO()->query($this->sql ."
            ORDER BY quartiers.creation DESC
        ");
    }

    public function lastP($offset,$limit){
        return $this->db->getPDO()->query($this->sql ."
            ORDER BY quartiers.creation DESC LIMIT $offset,$limit
        ");
    }

    public function QuartierCount(){
        return $this->tableCount();
    }

    public function export(){
        $sql = "SELECT id as Id,nom as Nom FROM quartiers";
        $req = $this->db->getPDO()->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }

}