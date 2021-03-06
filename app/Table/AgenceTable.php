<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 05/06/2018
 * Time: 05:39
 */

namespace App\Table;


class AgenceTable extends UtilisateurTable
{
    protected $table = "utilisateurs";

    public function extraAgence($id,$nom){
        $select = $this->db->getPDO()->query("SELECT $id, $nom FROM $this->table WHERE id_role = 7 ORDER BY $nom ASC");
        $table_field = $select->fetchAll();
        $table_field_list = array();
        foreach ($table_field as $filed) {
            $table_field_list[$filed[$id]] = $filed[$nom];
        }
        return $table_field_list;
    }

    /**
     *R�cup�re les derniers utilisateurs
     * @return array
     */

    public function last(){
        //Utilisateur
        return $this->db->getPDO()->query($this->sql."
            WHERE id_role = 7
            ORDER BY utilisateurs.creation DESC
        ");
    }

    public function lastP($offset,$limit){
        return $this->db->getPDO()->query($this->sql."
            WHERE id_role = 7
            ORDER BY utilisateurs.creation DESC LIMIT $offset,$limit
        ");
    }

    public function AgenceCount(){
        return $this->tableCount();
    }

    public function export(){
        $sql = "SELECT id as Id,nombre as Nombre FROM utilisateurs";
        $req = $this->db->getPDO()->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }
}