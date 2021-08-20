<?php

namespace Tests;

use DesignPatterns\Structural\Proxy\BankAccountProxy;
use PHPUnit\Framework\TestCase;

class ProxyTest extends TestCase
{
    public function testProxyWillOnlyExecuteExpensiveGetBalanceOnce()
    {
        $bankAccount = new BankAccountProxy;
        $bankAccount->deposite(30);

        $this->assertSame(30, $bankAccount->getBalance());
        
        $bankAccount->deposite(50);

        $this->assertSame(30, $bankAccount->getBalance());
    }
}