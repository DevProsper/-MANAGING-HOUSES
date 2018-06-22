<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 05/06/2018
 * Time: 05:37
 */

namespace App\Table;


use Core\Table\Table;

class ArrondissementTable extends Table
{
    protected $table = "arrondissements";

    public $sql = "SELECT arrondissements.id,arrondissements.nom,arrondissements.slug,
            villes.slug as ville,statuts.nom as statut,
            utilisateurs.nom as utilisateur
            FROM arrondissements
            LEFT JOIN villes
            ON arrondissements.id_ville = villes.id
            LEFT JOIN statuts
            ON arrondissements.id_statut = statuts.id
            LEFT JOIN utilisateurs
            ON arrondissements.id_utilisateur = utilisateurs.id";

    /**
     *Récupère les derniers arrondissements
     * @return array
     */

    public function last(){
        return $this->db->getPDO()->query($this->sql ."
            ORDER BY arrondissements.creation DESC
        ");
    }

    public function lastP($offset,$limit){
        return $this->db->getPDO()->query($this->sql."
            ORDER BY arrondissements.creation DESC LIMIT $offset,$limit
        ");
    }

    public function findWithVille($id){
        return $this->query("
          SELECT arrondissements.id,arrondissements.nom, 
          arrondissements.id_ville,
          ville.nom as ville
          FROM arrondissements
          LEFT JOIN ville
          ON ville.id = arrondissements.id_ville
          WHERE arrondissements.id = ?
          ORDER BY arrondissements.creation DESC
          ", [$id], true);
    }

    public function lastByVille($ville_id){
        return $this->query("
          SELECT arrondissements.id,arrondissements.nom,
          arrondissements.id_ville,
          ville.nom as ville
          FROM arrondissements
          LEFT JOIN ville
          ON ville.id = arrondissements.id_ville
          WHERE ville = ?
          ORDER BY arrondissements.creation DESC
          ", [$ville_id]);
    }

    public function ArrondissementCount(){
        return $this->tableCount();
    }

    public function export(){
        $sql = "SELECT id as Id,nom as Nom FROM arrondissements";
        $req = $this->db->getPDO()->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }
}