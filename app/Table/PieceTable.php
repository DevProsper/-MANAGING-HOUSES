<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 05/06/2018
 * Time: 05:38
 */

namespace App\Table;


use Core\Table\Table;

class PieceTable extends Table
{
    protected $table = "pieces";

    public $sql = "SELECT pieces.id, pieces.nombre,
            utilisateurs.nom as utilisateur
            FROM pieces
            LEFT JOIN utilisateurs
            ON pieces.id_utilisateur = utilisateurs.id";

    /**
     *Récupère les derniers pieces
     * @return array
     */

    public function last(){
        return $this->db->getPDO()->query($this->sql."
            ORDER BY pieces.nombre ASC
        ");
    }

    public function lastP($offset,$limit){
        return $this->db->getPDO()->query($this->sql."
            ORDER BY pieces.nombre ASC LIMIT $offset,$limit
        ");
    }

    public function PieceCount(){
        return $this->tableCount();
    }

    public function export(){
        $sql = "SELECT id as Id,nombre as Nombre FROM pieces";
        $req = $this->db->getPDO()->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }
}