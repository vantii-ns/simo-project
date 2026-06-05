<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    // Tambahkan 'bio', 'avatar', dan 'theme' ke dalam array ini
    protected $allowedFields = ['username', 'password', 'role', 'bio', 'avatar', 'theme'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    /**
     * Find a user by username.
     */
    public function findByUsername(string $username): ?array
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Check if a username is already taken.
     */
    public function usernameExists(string $username): bool
    {
        return $this->where('username', $username)->countAllResults() > 0;
    }
}