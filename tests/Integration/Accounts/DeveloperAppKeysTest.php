<?php

declare(strict_types=1);

namespace PeterColes\Tests\Integration\Accounts;

use PeterColes\Betfair\Betfair;
use PeterColes\Tests\Integration\BaseTest;

class DeveloperAppKeysTest extends BaseTest
{
    public function test_account_statement()
    {
        $result = Betfair::account('getDeveloperAppKeys');

        $this->assertTrue(is_array($result));
        $this->assertObjectHasAttribute('appVersions', $result[0]);
        $this->assertEquals(2, count($result[0]->appVersions));
    }
}
