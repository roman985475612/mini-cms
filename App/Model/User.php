<?php

namespace App\Model;

use Home\CmsMini\Model;

class User extends Model
{
    const ADMIN = 'admin';

    const EDITOR = 'editor';

    const GUEST = 'guest';

    protected array $fillable = [
        'username',
        'email',
        'role',
        'password'
    ];

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
        $user = static::find('email', $email)->one();
        
        if (!$user->isEmpty() && $user->checkPassword($password)) {
            return $user; 
        }

        throw new \Exception('Email and password does not matches!');
    }

    protected static function defultImage(): string
    {
        return '/public/assets/img/avatar.webp';
    }

    public function setAdmin()
    {
        $this->role = static::ADMIN;
    }

    public function setEditor()
    {
        $this->role = static::EDITOR;
    }

    public function setGuest()
    {
        $this->role = static::GUEST;
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
            $user = static::find('token', $token)->one();
        } while (!$user->isEmpty());

        $this->recordModeEnable();
        $this->token = $token;
        $this->save();
    }

    public function delete(): bool
    {
        $this->removeImage();
        return parent::delete();
    }
}