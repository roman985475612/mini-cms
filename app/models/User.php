<?php

namespace App\Model;

use Home\CmsMini\Model;

class User extends Model
{
    protected string $username;

    protected string $password;

    protected string $email;

    protected string $token = '';

    public function __get(string $name)
    {
        switch ($name) {
            case 'id': return $this->id;
            case 'username': return $this->username;
            case 'email': return $this->email;
        }
    }

    public function __set(string $name, mixed $value)
    {
        switch ($name) {
            case 'username': $this->username = $value; break;
            case 'email': $this->email = $value; break;
        }
    }

    public function __toString(): string
    {
        return ucfirst($this->username);
    }

    public static function getTableName(): string
    {
        return 'users';
    }

    public static function attempt(string $email, string $password): User
    {
        $user = static::findOne('email', $email);
        if ($user instanceof User && $user->checkPassword($password)) {
            return $user; 
        }
        throw new \Exception('Email and password does not matches!');
    }

    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function checkPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}