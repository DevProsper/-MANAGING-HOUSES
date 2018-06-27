<?php
/**
 * Created by PhpStorm.
 * User: DevProsper
 * Date: 05/06/2018
 * Time: 05:39
 */

namespace App\Table;


use Core\Table\Table;

class UtilisateurTable extends Table
{
    protected $table = "utilisateurs";

    public $sql = "
    SELECT  utilisateurs.id, 
            utilisateurs.nom,
            utilisateurs.prenom,
            utilisateurs.adresse,
            utilisateurs.nom_agence,
            utilisateurs.nom_prorietaire,
            utilisateurs.tel,
            utilisateurs.email,
            utilisateurs.fonction,
            utilisateurs.latitude,
            utilisateurs.longitude,
            utilisateurs.identite,
            utilisateurs.id_utilisateur,
            statuts.nom as statut,
            roles.nom as role
        FROM utilisateurs
        LEFT JOIN statuts
        ON utilisateurs.id_statut = statuts.id
        LEFT JOIN roles
        ON utilisateurs.id_role = roles.id
        ";

    /**
     * Créer un utilisateurs
     * @param UserRepository $repository
     * @return bool
     */
    public function createUser(UserRepository $repository): bool{
        $statement = $this->db->getPDO()->prepare("INSERT INTO users (name,username) VALUES(?,?)");
        return $statement->execute([
            $repository->getName(),
            $repository->getUsername()
        ]);
    }

    public function extraAgence($id,$nom){
        $select = $this->db->getPDO()->query("SELECT $id, $nom FROM $this->table WHERE id_role = 7 ORDER BY $nom ASC");
        $table_field = $select->fetchAll();
        $table_field_list = array();
        foreach ($table_field as $filed) {
            $table_field_list[$filed[$id]] = $filed[$nom];
        }
        return $table_field_list;
    }

    public function extraProprietaire($id,$nom){
        $select = $this->db->getPDO()->query("SELECT $id, $nom FROM $this->table WHERE id_role = 8 ORDER BY $nom ASC");
        $table_field = $select->fetchAll();
        $table_field_list = array();
        foreach ($table_field as $filed) {
            $table_field_list[$filed[$id]] = $filed[$nom];
        }
        return $table_field_list;
    }

    /**
     * @param UserRepository $repository
     * @param array $data
     * @return UserRepository
     */
    public function hydrate(UserRepository $repository, array $data){
        $repository->setName($data['name']);
        $repository->setUsername($data['username']);
        $repository->setUsername($data['email']);
        return $repository;
    }

    /**
     * Modification de l'événement un événement
     * @param UserRepository $repository
     * @return bool
     * @internal param Event $event
     */
    public function updateUser(UserRepository $repository): bool{
        $statement = $this->db->getPDO()->prepare("UPDATE users SET name = ?,username = ? WHERE id= ?");
        return $statement->execute([
            $repository->getName(),
            $repository->getUsername(),
            $repository->getId()
        ]);
    }

    /**
     * @param UserRepository $repository
     * @return mixed
     */
    public function getUserByEmail(UserRepository $repository){
        $req = $this->db->getPDO()->prepare("SELECT * FROM users WHERE email = ?");
        $req->execute([$repository->getEmail()]);
        return $user = $req->fetch();
    }

    /**
     * @param $reset_token
     * @return bool
     */
    public function updateResetPassword($reset_token){
        $req = $this->db->getPDO()->prepare("UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?");
        return $req->execute([$reset_token]);
    }

    /**
     *Récupère les derniers utilisateurs
     * @return array
     */

    public function last(){
        //Utilisateur
        return $this->db->getPDO()->query($this->sql."
            ORDER BY utilisateurs.creation DESC
        ");
    }

    public function lastP($offset,$limit){
        return $this->db->getPDO()->query($this->sql."
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