<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 05/06/2018
 * Time: 05:38
 */

namespace App\Table;


use Core\Table\Table;

class ContactTable extends Table
{

    protected $table = "contacts";

    /**
     *Récupère les derniers contacts
     * @return array
     */

    public function last(){
        return $this->db->getPDO()->query("
            SELECT * FROM contacts
            ORDER BY contacts.creation DESC
        ");
    }

    public function lastP($offset,$limit){
        return $this->db->getPDO()->query("
            SELECT * FROM contacts
            ORDER BY contacts.creation DESC LIMIT $offset,$limit
        ");
    }

    public function ContactCount(){
        return $this->tableCount();
    }

    public function export(){
        $sql = "SELECT id as Id,nom as Nom,email as Email FROM contacts";
        $req = $this->db->getPDO()->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }
}