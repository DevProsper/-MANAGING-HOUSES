<?php

namespace App\Table;
use Core\Table\Table;

/**
 * Created by PhpStorm.
 * Users: DevProsper
 * Date: 12/03/2018
 * Time: 18:17
 */
class CategoryTable extends Table
{
    protected $table = "categories";

    /**
     *Récupère les derniers categories
     * @return array
     */

    public function last(){
        return $this->db->getPDO()->query("
            SELECT categories.id, categories.nom,categories.slug,
            utilisateurs.nom as utilisateur
            FROM categories
            LEFT JOIN utilisateurs
            ON categories.id_utilisateur = utilisateurs.id
            ORDER BY categories.creation DESC
        ");
    }

    public function lastP($offset,$limit){
        return $this->db->getPDO()->query("
            SELECT categories.id, categories.nom,categories.slug,
            utilisateurs.nom as utilisateur 
            FROM categories
            LEFT JOIN utilisateurs
            ON categories.id_utilisateur = utilisateurs.id
            ORDER BY categories.creation DESC LIMIT $offset,$limit
        ");
    }

    public function CategoryCount(){
        return $this->tableCount();
    }

    public function export(){
        $sql = "SELECT id as Id,nom as Nom FROM categories";
        $req = $this->db->getPDO()->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }
}