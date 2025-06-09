<?php

namespace PeterColes\Betfair;

use PeterColes\Betfair\Api\Auth;

class Betfair
{
    /**
     * Distribute requests to appropriate subsystems
     *
     * @param  $method string   the requested method (usually an API call)
     * @param  $params array    any parameters needed by, or to refine, the call
     * @return mixed
     */
    public static function __callStatic($method, $params)
    {
        // alias for Auth's init and persist methods
        if ($method == 'init' || $method == 'persist') {
            return call_user_func_array([ new Auth, $method ], $params);
        }

        // standard Auth
        if ($method == 'auth') {
            return new Auth;
        }

        // all other subsystems, currently Betting and Account
        $class = 'PeterColes\\Betfair\\Api\\'.ucfirst($method);
        if (class_exists($class)) {
            return call_user_func([ new $class, 'execute' ], $params);
        }
    }
}
