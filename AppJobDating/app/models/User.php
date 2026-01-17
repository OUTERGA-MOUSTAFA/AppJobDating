<?php

namespace App\app\models;

use App\app\core\BaseModel;

class User extends BaseModel
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'email', 'password', 'role'];

    /**
     * Trouve un utilisateur par email
     */
    public function findByEmail(string $email): ?array
    {
        $result = $this->where('email', $email);
        return !empty($result) ? $result[0] : null;
    }

    /**
     * Vérifie si un email existe déjà
     */
    public function emailExists(string $email): bool
    {
        $user = $this->findByEmail($email);
        return $user !== null;
    }

    /**
     * Récupère tous les admins
     */
    public function getAdmins(): array
    {
        return $this->where('role', 'admin');
    }

    /**
     * Met à jour le dernier login
     */
    public function updateLastLogin(int $userId): bool
    {
        $sql = "UPDATE {$this->table} SET last_login = NOW() WHERE {$this->primaryKey} = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId]);
    }
    public function alldata() :array
    {
        return $this->all();
    }
}