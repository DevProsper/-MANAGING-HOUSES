<?php

namespace App\Table;
use Core\Table\Table;
use PDO;

/**
 * Created by PhpStorm.
 * Users: DevProsper
 * created: 12/03/2018
 * Time: 18:17
 */
class PostTable extends Table
{
    protected $table = "posts";

    public $sql = "
            SELECT posts.id,
             posts.titre,
             posts.contenu,
             posts.creation,
             posts.adresse,
             posts.prix,
             categories.nom as categorie,
             utilisateurs.nom as utilisateur,
             villes.nom as ville,
             quartiers.nom as quartier,
             arrondissements.nom as arrondissement,
             types_bien.nom as type_bien,
             pieces.nombre as piece,
             statuts.nom as statut
            FROM posts
            LEFT JOIN categories
            ON posts.id_categorie = categories.id
            LEFT JOIN utilisateurs
            ON posts.id_utilisateur = utilisateurs.id
            LEFT JOIN villes
            ON posts.id_ville = villes.id
            LEFT JOIN quartiers
            ON posts.id_quartier = quartiers.id
            LEFT JOIN arrondissements
            ON posts.id_arrondissement = arrondissements.id
            LEFT JOIN types_bien
            ON posts.id_type_bien = types_bien.id
            LEFT JOIN pieces
            ON posts.id_piece = pieces.id
            LEFT JOIN statuts
            ON posts.id_statut = statuts.id
            ";
    /**
     *Révupère les derniers posts
     * @return array
     */

    public function last(){
        return $this->db->getPDO()->query($this->sql."
            ORDER BY posts.creation DESC
        ");
    }

    public function lastP($offset,$limit){
        return $this->db->getPDO()->query($this->sql."
            ORDER BY posts.creation DESC LIMIT $offset,$limit
        ");
    }

    public function findWithCategory($id){
        return $this->query("
          SELECT posts.id,posts.titre, posts.contenu,posts.categorie, 
          categories.nom as categorie
          FROM posts
          LEFT JOIN categories
          ON categories.nom = posts.categorie
          WHERE posts.id = ?
          ORDER BY posts.creation DESC
          ", [$id], true);
    }

    public function lastByCategory($category_id){
        return $this->query("
          SELECT posts.id,posts.titre, posts.contenu,posts.categorie, 
          categories.nom as categorie
          FROM posts
          LEFT JOIN categories
          ON categories.nom = posts.categorie
          WHERE categorie = ?
          ORDER BY posts.creation DESC
          ", [$category_id]);
    }

    public function postCount(){
        return $this->tableCount();
    }

    function post_img($tmp_name,$extension){
        $id = $this->lastInsertId();
        $image_name = time() + 7 ."post".$id.'.'.$extension;
        $i = [
            'id'      => $id,
            'file_name'   => $image_name
        ];

        $sql = "UPDATE files SET file_name=:file_name WHERE id= :id";
        $req = $this->db->getPDO()->prepare($sql);
        $req->execute($i);
    }

    public function export(){
        $sql = "SELECT id as Id,titre as Titre,contenu as Contenu FROM posts";
        $req = $this->db->getPDO()->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }
}