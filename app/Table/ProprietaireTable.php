<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 05/06/2018
 * Time: 05:39
 */

namespace App\Table;


class ProprietaireTable extends UtilisateurTable
{
    protected $table = "utilisateurs";

    public function last(){
        //Utilisateur
        return $this->db->getPDO()->query($this->sql."
            WHERE id_role = 8
            ORDER BY utilisateurs.creation DESC
        ");
    }

    public function lastP($offset,$limit){
        return $this->db->getPDO()->query($this->sql."
            WHERE id_role = 8
            ORDER BY utilisateurs.creation DESC LIMIT $offset,$limit
        ");
    }

    public function UtilisateurCount(){
        return $this->tableCount();
    }

    public function export(){
        $sql = "SELECT id as Id,nombre as Nombre FROM utilisateurs";
        $req = $this->db->getPDO()->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }
}