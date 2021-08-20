<?php

namespace DesignPatterns\Structural\Proxy;

class BankAccountProxy extends HeavyBankAccount implements BankAccount
{
    private ?int $balance = null;

    public function getBalance(): int
    {
        $this->balance ??= parent::getBalance();

        return $this->balance;
    }
}