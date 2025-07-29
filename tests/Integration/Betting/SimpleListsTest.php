<?php

declare(strict_types=1);

namespace PeterColes\Tests\Integration\Betting;

use PeterColes\Betfair\Betfair;
use PeterColes\Tests\Integration\BaseTest;

class SimpleListsTest extends BaseTest
{
    public function test_list_competitions()
    {
        $result = Betfair::betting('listCompetitions');

        $this->assertTrue(is_array($result));
        $this->assertObjectHasAttribute('competition', $result[0]);
    }

    public function test_list_countries()
    {
        $result = Betfair::betting('listCountries');

        $this->assertTrue(is_array($result));
        $this->assertObjectHasAttribute('countryCode', $result[0]);
    }

    public function test_list_events()
    {
        $result = Betfair::betting('listEvents');

        $this->assertTrue(is_array($result));
        $this->assertObjectHasAttribute('event', $result[0]);
    }

    public function test_list_events_with_text_filter()
    {
        $result = Betfair::betting('listEvents', ['filter' => ['textQuery' => 'Horse']]);

        if (count($result)) {
            $this->assertTrue(mb_strpos($result[0]->event->name, 'Horse') !== 0);
        }
    }

    public function test_list_events_with_event_ids_filter()
    {
        // get some current IDs with which to work
        $firstResult = Betfair::betting('listEvents');
        $eventIds = [$firstResult[0]->event->id, $firstResult[1]->event->id];

        $secondResult = Betfair::betting('listEvents', ['filter' => ['eventIds' => $eventIds]]);
        $secondResultIds = collect($secondResult)->pluck('event.id');

        $this->assertTrue(count($secondResult) === 2);
        $this->assertContains($eventIds[0], $secondResultIds);
        $this->assertContains($eventIds[1], $secondResultIds);
    }

    public function test_list_event_types()
    {
        $result = Betfair::betting('listEventTypes');

        $this->assertTrue(is_array($result));
        $this->assertObjectHasAttribute('eventType', $result[0]);
    }

    public function test_list_market_types()
    {
        $result = Betfair::betting('listMarketTypes');

        $this->assertTrue(is_array($result));
        $this->assertObjectHasAttribute('marketType', $result[0]);
    }

    public function test_list_venues()
    {
        $result = Betfair::betting('listVenues');

        $this->assertTrue(is_array($result));
        $this->assertObjectHasAttribute('venue', $result[0]);
    }
}
