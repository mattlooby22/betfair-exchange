<?php

declare(strict_types=1);

namespace PeterColes\Tests\Integration\Accounts;

use PeterColes\Betfair\Betfair;
use PeterColes\Tests\Integration\BaseTest;

class CurrencyRatesTest extends BaseTest
{
    public function test_list_currency_rates()
    {
        $result = Betfair::account('listCurrencyRates');

        $this->assertObjectHasAttribute('currencyCode', $result[0]);
        $this->assertObjectHasAttribute('rate', $result[0]);
    }
}
