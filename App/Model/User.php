<?php

namespace App\Model;

use Home\CmsMini\App;
use Home\CmsMini\Exception\UserNotFoundException;
use Home\CmsMini\Model;
use Home\CmsMini\Router;

class User extends Model
{
    const ROLE_ADMIN = 'admin';
    const ROLE_EDITOR = 'editor';
    const ROLE_GUEST = 'guest';

    const STATUS_CONFIRMED = 'CONFIRMED';
    const STATUS_NOT_CONFIRMED = 'NOT_CONFIRMED';
    const STATUS_DEACTIVATED = 'DEACTIVATED';

    protected array $fillable = [
        'username',
        'email',
        'role',
        'password'
    ];

    public static function create(array $data): static
    {
        $user = new static;
        $user->recordModeEnable();
        $user->username = $data['username'];
        $user->email    = $data['email'];
        $user->generateToken();
        $user->setPassword($data['password']);
        $user->save();

        $confirmUrl = Router::url('confirm', null, ['token' => $user->token], true);
        
        App::mailer()->compose()
            ->setTo($user->email, $user->username)
            ->setSubject('Confirmation of registration')
            ->setHtmlBody('confirm', compact('confirmUrl'))
            ->send();

        return $user;
    }

    public static function getRoles(): array
    {
        return [
            self::ROLE_ADMIN  => 'Administrator',
            self::ROLE_EDITOR => 'Editor',
            self::ROLE_GUEST  => 'Guest',
        ];
    }

    public static function attempt(string $email, string $password): self
    {
        $user = static::findOne('email', $email);
        
        if (!$user->isEmpty() && $user->checkPassword($password)) {
            return $user; 
        }

        throw new UserNotFoundException('Email and password does not matches!');
    }

    protected static function defultImage(): string
    {
        return '/public/assets/img/avatar.webp';
    }

    public function recoveryPassword()
    {
        $newPassword = getRandomPassword();

        $this->recordModeEnable();
        $this->setPassword($newPassword);
        $this->save();

        App::mailer()->compose()
            ->setTo($this->email, $this->username)
            ->setSubject('Recovery password')
            ->setHtmlBody('recovery', ['password' => $newPassword])
            ->send();
    }

    public function isAdmin(): bool
    {
        return $this->role == self::ROLE_ADMIN;
    }

    public function setAdmin()
    {
        $this->role = self::ROLE_ADMIN;
    }

    public function setEditor()
    {
        $this->role = self::ROLE_EDITOR;
    }

    public function setGuest()
    {
        $this->role = self::ROLE_GUEST;
    }

    public function setConfirmed()
    {
        $this->recordModeEnable();
        $this->status = self::STATUS_CONFIRMED;
        $this->save();
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
        $this->recordModeEnable();
        $this->generateToken();
        $this->save();
    }

    public function delete()
    {
        $this->removeImage();

        parent::delete();
    }

    private function generateToken(): void
    {
        do {
            $token = uniqid();
            $user = static::findOne('token', $token);
        } while (!$user->isEmpty());

        $this->token = $token;
    }
}