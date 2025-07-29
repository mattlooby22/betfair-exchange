<?php

declare(strict_types=1);

namespace PeterColes\Betfair\Api;

class Account extends BaseApi
{
    /**
     * Betfair API endpoint for account subsystem requests
     */
    public const ENDPOINT = 'https://api.betfair.com/exchange/account/rest/v1.0/';
}
