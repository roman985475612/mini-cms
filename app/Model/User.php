<?php

namespace App\Model;

use Home\CmsMini\Model;

class User extends Model
{
    const ADMIN = 'admin';

    const EDITOR = 'editor';

    const GUEST = 'guest';

    protected string $username;

    protected string $password;

    protected string $email;

    protected string $token = '';

    protected string $role;

    public function __call($name, $arguments)
    {
        switch ($name) {
            case 'setAdmin':
                $this->role = static::ADMIN;
                break;

            case 'setEditor':
                $this->role = static::EDITOR;
                break;

            case 'setGuest':
                $this->role = static::GUEST;
                break;
        }
    }

    public function __get(string $name)
    {
        return match ($name) {
            'id'    => $this->id,
            'email' => $this->email,
            'token' => $this->token,
            'role'  => $this->role,
            'username' => $this->username,
        };
    }

    public function __set(string $name, mixed $value)
    {
        // switch ($name) {
        //     case 'username': $this->username = $value; break;
        //     case 'email': $this->email = $value; break;
        // }

        // $this->$name = match ($name) {
        //     'username' => $value,
        //     'email' => $value,
        // };

        if (in_array($name, ['username', 'email'])) {
            $this->$name = $value;
        }
    }

    public function __toString(): string
    {
        return ucfirst($this->username);
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

    public function setToken(): void
    {
        do {
            $token = uniqid();
        } while (static::findOne('token', $token));   

        $this->token = $token;
        $this->save();
    }
}