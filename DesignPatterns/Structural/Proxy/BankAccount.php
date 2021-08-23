<?php

namespace DesignPatterns\Structural\Proxy;

interface BankAccount
{
    public function deposite(int $amount);

    public function getBalance(): int;
}