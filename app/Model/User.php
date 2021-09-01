<?php

namespace App\Model;

use Home\CmsMini\Model;
use Home\CmsMini\Storage;

class User extends Model
{
    const ADMIN = 'admin';

    const EDITOR = 'editor';

    const GUEST = 'guest';

    public static function getRoles(): array
    {
        return [
            self::ADMIN  => 'Administrator',
            self::EDITOR => 'Editor',
            self::GUEST  => 'Guest',
        ];
    }

    public static function attempt(string $email, string $password): self
    {
        $user = static::findOne('email', $email);
        if ($user instanceof User && $user->checkPassword($password)) {
            return $user; 
        }
        throw new \Exception('Email and password does not matches!');
    }

    protected static function defultImage(): string
    {
        return '/public/assets/img/avatar.webp';
    }

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

    public function __toString(): string
    {
        return ucfirst($this->username);
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

    public function delete(): bool
    {
        static::removeImage();
        return parent::delete();
    }
}