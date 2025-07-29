<?php

declare(strict_types=1);

namespace PeterColes\Tests\Integration\Auth;

use PeterColes\Betfair\Api\Auth;
use PeterColes\Betfair\Betfair;
use PeterColes\Tests\Integration\BaseTest;

class AuthTest extends BaseTest
{
    public function test_auth_class_instantiation()
    {
        $this->assertInstanceOf('PeterColes\Betfair\Api\Auth', Betfair::auth());
    }

    public function test_login_obtains_session_token()
    {
        $token = Betfair::auth()->login($this->appKey, $this->username, $this->password);

        $this->assertTrue(is_string($token));
        $this->assertEquals(44, mb_strlen($token));
    }

    public function test_init_logins_in_first_time_only()
    {
        Betfair::auth()->init($this->appKey, $this->username, $this->password);

        // first init logs in
        $firstSessionToken = Auth::$sessionToken;
        $firstLastLogin = Auth::$lastLogin;
        $this->assertEquals($this->appKey, Auth::$appKey);
        $this->assertTrue(is_string($firstSessionToken));
        $this->assertEquals(44, mb_strlen($firstSessionToken));

        sleep(1); // ensure at least a second between inits to force a different timestamp
        Betfair::auth()->init($this->appKey, $this->username, $this->password);

        // second init should continue to use existing session token
        $secondSessionToken = Auth::$sessionToken;
        $secondLastLogin = Auth::$lastLogin;
        $this->assertEquals($this->appKey, Auth::$appKey);
        $this->assertEquals($firstSessionToken, $secondSessionToken);
        $this->assertNotEquals($firstLastLogin, $secondLastLogin);
    }

    public function test_keep_alive_update_last_login_timestamp()
    {
        Betfair::auth()->init($this->appKey, $this->username, $this->password);

        $firstSessionToken = Auth::$sessionToken;
        $firstLastLogin = Auth::$lastLogin;

        sleep(1); // delay to force a different timestamp
        $result = Betfair::auth()->keepAlive();

        $secondSessionToken = Auth::$sessionToken;
        $secondLastLogin = Auth::$lastLogin;

        $this->assertGreaterThan($firstLastLogin, $secondLastLogin);
    }

    public function test_logout_clears_local_auth_data()
    {
        Betfair::auth()->init($this->appKey, $this->username, $this->password);

        Betfair::auth()->logout();

        $this->assertNull(Auth::$appKey);
        $this->assertNull(Auth::$sessionToken);
        $this->assertNull(Auth::$lastLogin);
    }

    public function test_no_betfair_session_after_logout()
    {
        Betfair::auth()->init($this->appKey, $this->username, $this->password);

        Betfair::auth()->logout();

        $this->expectException('Exception');
        Betfair::auth()->logout();
    }

    public function test_session_remaining()
    {
        Betfair::auth()->init($this->appKey, $this->username, $this->password);

        sleep(2);

        $this->assertEquals(Auth::SESSION_LENGTH - 2, Betfair::auth()->sessionRemaining());
    }
}
