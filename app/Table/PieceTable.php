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

    /**
     *Récupère les derniers pieces
     * @return array
     */

    public function last(){
        return $this->db->getPDO()->query("
            SELECT * FROM pieces
            ORDER BY pieces.creation DESC
        ");
    }

    public function lastP($offset,$limit){
        return $this->db->getPDO()->query("
            SELECT * FROM pieces
            ORDER BY pieces.creation DESC LIMIT $offset,$limit
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