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
}