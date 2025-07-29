<?php

declare(strict_types=1);

namespace PeterColes\Tests\Integration\Accounts;

use PeterColes\Betfair\Betfair;
use PeterColes\Tests\Integration\BaseTest;

class AccountDetailsTest extends BaseTest
{
    public function test_get_account_details()
    {
        $result = Betfair::account('getAccountDetails');

        $this->assertObjectHasAttribute('firstName', $result);
        $this->assertObjectHasAttribute('pointsBalance', $result);
    }

    public function test_account_statement()
    {
        $result = Betfair::account('getAccountStatement');

        $this->assertObjectHasAttribute('accountStatement', $result);
    }
}
