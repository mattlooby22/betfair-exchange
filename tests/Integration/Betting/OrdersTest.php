<?php

declare(strict_types=1);

namespace PeterColes\Tests\Integration\Betting;

use PeterColes\Betfair\Betfair;
use PeterColes\Tests\Integration\BaseTest;

class OrdersTest extends BaseTest
{
    public function test_list_current_orders_with_no_params()
    {
        $result = Betfair::betting('listCurrentOrders');

        $this->assertObjectHasAttribute('currentOrders', $result);
    }
}
